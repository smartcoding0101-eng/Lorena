<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class AlbumPhotoController extends Controller
{
    public function store(Request $request, Album $album): RedirectResponse
    {
        Gate::authorize('update', $album);

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:120'],
            'description' => ['nullable', 'string', 'max:4000'],
            'photo' => ['required', File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max(10240)],
        ]);
        $upload = $validated['photo'];
        $extension = $upload->guessExtension();

        if (! $extension) {
            abort(422, 'No se pudo determinar el formato de la imagen.');
        }

        $path = sprintf(
            '%d/%d/%s.%s',
            $request->user()->id,
            $album->id,
            Str::uuid(),
            $extension,
        );
        $storedPath = Storage::disk('garden_private')->putFileAs(
            dirname($path),
            $upload,
            basename($path),
        );

        if (! is_string($storedPath)) {
            throw new \RuntimeException('No se pudo guardar el archivo privado.');
        }

        try {
            DB::transaction(function () use ($album, $request, $storedPath, $validated, $upload): void {
                $photo = $album->photos()->make([
                    'title' => $validated['title'],
                    'description' => $validated['description'] ?? null,
                    'mime_type' => $upload->getMimeType(),
                    'file_size' => $upload->getSize(),
                ]);
                $photo->path = $storedPath;
                $photo->user()->associate($request->user());
                $photo->save();
            });
        } catch (Throwable $exception) {
            Storage::disk('garden_private')->delete($storedPath);
            throw $exception;
        }

        return redirect()->to(route('home').'#albumes')->with('status', 'Fotografía agregada al álbum.');
    }

    public function update(Request $request, AlbumPhoto $photo): RedirectResponse
    {
        Gate::authorize('update', $photo);
        Gate::authorize('update', $photo->album);

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:120'],
            'description' => ['nullable', 'string', 'max:4000'],
        ]);

        $photo->update($validated);

        return redirect()->to(route('home').'#albumes')->with('status', 'Descripción de la fotografía actualizada.');
    }

    public function favorite(Request $request, AlbumPhoto $photo): RedirectResponse
    {
        Gate::authorize('update', $photo);
        Gate::authorize('update', $photo->album);

        $validated = $request->validate([
            'is_favorite' => ['required', 'boolean'],
            'return_to' => ['nullable', 'in:albumes,favoritos'],
        ]);

        $photo->update(['is_favorite' => $validated['is_favorite']]);

        $screen = $validated['return_to'] ?? 'albumes';

        return redirect()->to(route('home')."#{$screen}")->with('status', 'Favoritos actualizados.');
    }

    public function destroy(AlbumPhoto $photo): RedirectResponse
    {
        Gate::authorize('delete', $photo);
        Gate::authorize('delete', $photo->album);
        Storage::disk('garden_private')->delete($photo->path);
        $photo->delete();

        return redirect()->to(route('home').'#albumes')->with('status', 'Fotografía eliminada.');
    }

    public function show(AlbumPhoto $photo): StreamedResponse
    {
        Gate::authorize('view', $photo);
        Gate::authorize('view', $photo->album);

        $disk = Storage::disk('garden_private');
        abort_unless($disk->exists($photo->path), 404, 'La fotografía no está disponible.');

        return $disk->response($photo->path, 'fotografia', [
            'Content-Type' => $photo->mime_type,
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ], 'inline');
    }
}
