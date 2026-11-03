<?php

namespace App\Http\Controllers;

use App\Models\GardenHeroPhoto;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GardenHeroPhotoController extends Controller
{
    public function show(GardenHeroPhoto $heroPhoto): StreamedResponse
    {
        abort_unless(
            $heroPhoto->is_active || (auth()->check() && (auth()->user()->is_admin || auth()->id() === $heroPhoto->user_id)),
            404
        );

        $disk = Storage::disk('garden_private');
        abort_unless($disk->exists($heroPhoto->photo_path), 404, 'La fotografía no está disponible.');

        $extension = pathinfo($heroPhoto->photo_path, PATHINFO_EXTENSION);
        $mimeType = match (strtolower($extension)) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            default => 'application/octet-stream',
        };

        return $disk->response($heroPhoto->photo_path, null, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400, stale-while-revalidate=604800',
            'X-Content-Type-Options' => 'nosniff',
        ], 'inline');
    }
}

