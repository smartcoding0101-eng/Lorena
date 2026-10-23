<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFriendDedicationRequest;
use App\Models\FriendDedication;
use Illuminate\Http\JsonResponse;

class FriendDedicationController extends Controller
{
    /**
     * Devuelve la lista de dedicatorias en formato JSON.
     */
    public function index(): JsonResponse
    {
        $dedications = FriendDedication::query()
            ->latest()
            ->take(60)
            ->get();

        return response()->json([
            'success' => true,
            'dedications' => $dedications,
        ]);
    }

    /**
     * Guarda una nueva dedicatoria enviada por cualquier visitante / amigo.
     */
    public function store(StoreFriendDedicationRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $dedication = FriendDedication::create([
            'author_name'  => $validated['author_name'],
            'message'      => $validated['message'],
            'flower_badge' => $validated['flower_badge'] ?? '🌸',
        ]);

        return response()->json([
            'success'     => true,
            'message'     => '¡Tu dedicatoria ha florecido en el jardín de Carla!',
            'dedication'  => $dedication,
        ], 201);
    }

    /**
     * Elimina una dedicatoria (Solo para el Administrador / Usuario Autenticado).
     */
    public function destroy(FriendDedication $friendDedication): JsonResponse
    {
        $friendDedication->delete();

        return response()->json([
            'success' => true,
            'message' => 'La dedicatoria ha sido eliminada con éxito.',
        ]);
    }
}
