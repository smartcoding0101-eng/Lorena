<?php

namespace App\Http\Controllers;

use App\Services\GardenAudioLibraryService;
use Illuminate\Http\JsonResponse;

class GardenAudioLibraryController extends Controller
{
    /**
     * Retorna el catálogo dinámico de canciones encontradas en public/audio/.
     */
    public function index(): JsonResponse
    {
        $tracks = GardenAudioLibraryService::getPublicAudioTracks();

        return response()->json([
            'success' => true,
            'count' => $tracks->count(),
            'tracks' => $tracks,
        ]);
    }
}
