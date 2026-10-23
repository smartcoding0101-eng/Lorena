<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeCapsuleRequest;
use App\Models\TimeCapsule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimeCapsuleController extends Controller
{
    /**
     * Listar cápsulas del tiempo del usuario actual.
     */
    public function index(Request $request): JsonResponse
    {
        $capsules = $request->user()->timeCapsules()
            ->orderBy('unlock_at', 'asc')
            ->get()
            ->map(function (TimeCapsule $capsule) {
                $isUnlocked = $capsule->isUnlocked();
                return [
                    'id' => $capsule->id,
                    'title' => $capsule->title,
                    // Si no está desbloqueada, no exponer el mensaje secreto
                    'message' => $isUnlocked ? $capsule->message : null,
                    'author_name' => $capsule->author_name,
                    'unlock_at' => $capsule->unlock_at->toIso8601String(),
                    'unlock_at_formatted' => $capsule->unlock_at->translatedFormat('d \d\e F, Y - H:i'),
                    'is_unlocked' => $isUnlocked,
                    'is_opened' => $capsule->is_opened,
                    'mood' => $capsule->mood,
                    'image_url' => ($isUnlocked && $capsule->image_path) ? Storage::url($capsule->image_path) : null,
                    'has_image' => !empty($capsule->image_path),
                    'created_at' => $capsule->created_at->translatedFormat('d M Y'),
                ];
            });

        return response()->json([
            'success' => true,
            'capsules' => $capsules,
            'total' => $capsules->count(),
            'locked_count' => $capsules->where('is_unlocked', false)->count(),
            'unlocked_count' => $capsules->where('is_unlocked', true)->count(),
        ]);
    }

    /**
     * Guardar una nueva carta o cápsula sellada.
     */
    public function store(StoreTimeCapsuleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('time-capsules', 'public');
        }

        $user    = $request->user();
        $capsule = $user->timeCapsules()->create([
            'title'       => trim($validated['title']),
            'message'     => trim($validated['message']),
            'unlock_at'   => $validated['unlock_at'],
            'mood'        => $validated['mood'] ?? 'love',
            'author_name' => ($validated['author_name'] ?? '') ?: ($user->name ?? 'Carla Lorena'),
            'image_path'  => $imagePath,
            'is_opened'   => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Tu cápsula del tiempo ha sido sellada con amor! Se abrirá en la fecha elegida.',
            'capsule' => [
                'id'                 => $capsule->id,
                'title'              => $capsule->title,
                'unlock_at'          => $capsule->unlock_at->toIso8601String(),
                'unlock_at_formatted'=> $capsule->unlock_at->translatedFormat('d \de F, Y - H:i'),
                'is_unlocked'        => false,
            ],
        ]);
    }

    /**
     * Marcar cápsula como leída/abierta cuando ya se desbloqueó.
     */
    public function markOpened(Request $request, TimeCapsule $capsule): JsonResponse
    {
        if ($capsule->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        if (!$capsule->isUnlocked()) {
            return response()->json(['success' => false, 'message' => 'Esta cápsula aún no puede abrirse.'], 400);
        }

        $capsule->update(['is_opened' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Cápsula marcada como leída.',
        ]);
    }

    /**
     * Eliminar una cápsula.
     */
    public function destroy(Request $request, TimeCapsule $capsule): JsonResponse
    {
        if ($capsule->user_id !== $request->user()->id && !$request->user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        if ($capsule->image_path) {
            Storage::disk('public')->delete($capsule->image_path);
        }

        $capsule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cápsula eliminada correctamente.',
        ]);
    }
}
