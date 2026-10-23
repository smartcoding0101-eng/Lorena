<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGardenHomeCardRequest;
use App\Http\Requests\UpdateGardenHomeCardRequest;
use App\Models\GardenHomeCard;
use App\Services\GardenHomeCardService;
use Illuminate\Http\JsonResponse;

class GardenHomeCardController extends Controller
{
    public function __construct(
        private readonly GardenHomeCardService $service
    ) {}

    public function store(StoreGardenHomeCardRequest $request): JsonResponse
    {
        $card = $this->service->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tarjeta agregada exitosamente al inicio.',
            'card'    => $card,
        ], 201);
    }

    public function update(UpdateGardenHomeCardRequest $request, GardenHomeCard $homeCard): JsonResponse
    {
        $card = $this->service->update($homeCard, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tarjeta actualizada exitosamente.',
            'card'    => $card,
        ]);
    }

    public function destroy(GardenHomeCard $homeCard): JsonResponse
    {
        $this->service->delete($homeCard);

        return response()->json([
            'success' => true,
            'message' => 'Tarjeta eliminada exitosamente del inicio.',
        ]);
    }
}
