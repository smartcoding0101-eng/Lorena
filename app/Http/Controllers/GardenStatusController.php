<?php

namespace App\Http\Controllers;

use App\Models\GardenStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;

class GardenStatusController extends Controller
{
    private const IMAGE_MAX_KILOBYTES = 15360; // 15 MB

    /**
     * Lista pública de estados activos (últimas 24 horas).
     */
    public function index(): JsonResponse
    {
        $statuses = GardenStatus::active()
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'statuses' => $statuses,
            'count' => $statuses->count(),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    /**
     * Subida directa de uno o varios estados (duración automática de 24 horas) por el Admin.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'caption' => ['nullable', 'string', 'max:280'],
            'image' => [
                'nullable',
                File::image()->max(self::IMAGE_MAX_KILOBYTES),
            ],
            'images' => ['nullable', 'array'],
            'images.*' => [
                'required',
                File::image()->max(self::IMAGE_MAX_KILOBYTES),
            ],
        ]);

        $files = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
        } elseif ($request->hasFile('image')) {
            $files = [$request->file('image')];
        }

        if (empty($files)) {
            return response()->json([
                'message' => 'Selecciona al menos una imagen para publicar en el estado.',
            ], 422);
        }

        $caption = trim((string) $request->input('caption', ''));
        $expiresAt = now()->addHours(24);
        $created = [];

        foreach ($files as $uploadedFile) {
            $ext = $uploadedFile->getClientOriginalExtension() ?: 'jpg';
            $safeName = Str::uuid()->toString() . '.' . $ext;
            $path = $uploadedFile->storeAs('garden-statuses', $safeName, 'public');

            $status = GardenStatus::create([
                'user_id' => $request->user()?->id,
                'caption' => $caption !== '' ? $caption : null,
                'image_path' => $path,
                'expires_at' => $expiresAt,
            ]);

            $created[] = $status->fresh();
        }

        return response()->json([
            'success' => true,
            'message' => count($created) === 1
                ? 'Estado publicado por 24 horas.'
                : count($created) . ' estados publicados por 24 horas.',
            'statuses' => $created,
        ], 201);
    }

    /**
     * Eliminar un estado manualmente antes de las 24 horas.
     */
    public function destroy(GardenStatus $gardenStatus): JsonResponse
    {
        if ($gardenStatus->image_path && Storage::disk('public')->exists($gardenStatus->image_path)) {
            Storage::disk('public')->delete($gardenStatus->image_path);
        }

        $gardenStatus->delete();

        return response()->json([
            'success' => true,
            'message' => 'Estado eliminado correctamente.',
        ]);
    }
}

