<?php

namespace App\Http\Controllers;

use App\Models\GardenProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class GardenProfileController extends Controller
{
    public function save(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'profession' => ['nullable', 'string', 'max:160'],
            'biography' => ['nullable', 'string', 'max:5000'],
            'education' => ['nullable', 'string', 'max:10000'],
            'experience' => ['nullable', 'string', 'max:10000'],
            'achievements' => ['nullable', 'string', 'max:10000'],
            'interests' => ['nullable', 'string', 'max:10000'],
            'additional_info' => ['nullable', 'string', 'max:10000'],
            'status' => ['required', 'in:draft,published'],
            'featured_photo' => [
                'nullable',
                File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max(10240),
                'prohibited_if:remove_photo,1',
            ],
            'remove_photo' => ['sometimes', 'boolean'],
        ]);

        $profile = $request->user()->gardenProfile()->firstOrNew();
        if ($profile->exists) {
            Gate::authorize('update', $profile);
        }

        $disk = Storage::disk('garden_private');
        $oldPhotoPath = $profile->featured_photo_path;
        $newPhotoPath = null;
        $removePhoto = in_array($validated['remove_photo'] ?? false, [true, 1, '1'], true);

        if (isset($validated['featured_photo'])) {
            $extension = $validated['featured_photo']->guessExtension();
            if (! $extension) {
                abort(422, 'No se pudo determinar el formato de la fotografía.');
            }

            $newPhotoPath = sprintf(
                'profiles/%d/%s.%s',
                $request->user()->id,
                Str::uuid(),
                $extension,
            );
            $storedPath = $disk->putFileAs(dirname($newPhotoPath), $validated['featured_photo'], basename($newPhotoPath));
            if (! is_string($storedPath)) {
                throw new \RuntimeException('No se pudo guardar la fotografía privada del perfil.');
            }
        }

        $attributes = [
            'profession' => $validated['profession'] ?? null,
            'biography' => $validated['biography'] ?? null,
            'education' => $validated['education'] ?? null,
            'experience' => $validated['experience'] ?? null,
            'achievements' => $validated['achievements'] ?? null,
            'interests' => $validated['interests'] ?? null,
            'additional_info' => $validated['additional_info'] ?? null,
            'status' => $validated['status'],
        ];

        if ($newPhotoPath !== null) {
            $attributes['featured_photo_path'] = $newPhotoPath;
        } elseif ($removePhoto) {
            $attributes['featured_photo_path'] = null;
        }

        try {
            DB::transaction(function () use ($profile, $request, $attributes): void {
                $profile->fill($attributes);
                $profile->user()->associate($request->user());
                $profile->save();
            });
        } catch (Throwable $exception) {
            if ($newPhotoPath !== null) {
                $disk->delete($newPhotoPath);
            }

            throw $exception;
        }

        $photoWasReplacedOrRemoved = $oldPhotoPath !== null
            && ($newPhotoPath !== null || $removePhoto);
        if ($photoWasReplacedOrRemoved && ! $disk->delete($oldPhotoPath)) {
            throw new \RuntimeException('El perfil se guardó, pero no se pudo retirar la fotografía anterior.');
        }

        return redirect()->to(route('home').'#blog')->with(
            'status',
            $profile->isPublished()
                ? 'Perfil actualizado y publicado en el blog.'
                : 'Perfil guardado como borrador privado.',
        );
    }

    public function featuredPhoto(GardenProfile $profile): StreamedResponse
    {
        abort_unless(Gate::allows('view', $profile), 404);
        abort_unless($profile->featured_photo_path !== null, 404, 'El perfil no tiene una fotografía destacada.');

        $disk = Storage::disk('garden_private');
        abort_unless($disk->exists($profile->featured_photo_path), 404, 'La fotografía destacada no está disponible.');

        $extension = pathinfo($profile->featured_photo_path, PATHINFO_EXTENSION);
        $mimeType = match (strtolower($extension)) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            default => abort(404, 'El formato de la fotografía destacada no está disponible.'),
        };

        return $disk->response($profile->featured_photo_path, 'foto-destacada', [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ], 'inline');
    }
}
