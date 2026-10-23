<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGardenNoteRequest;
use App\Models\GardenNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GardenNoteController extends Controller
{
    /**
     * Listar notas de una pantalla específica.
     */
    public function index(Request $request): JsonResponse
    {
        $screenKey = $request->query('screen', 'inicio');

        $notes = GardenNote::where('screen_key', $screenKey)
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($note) {
                return [
                    'id' => $note->id,
                    'screen_key' => $note->screen_key,
                    'title' => $note->title,
                    'content' => $note->content,
                    'author_name' => $note->author_name,
                    'mood' => $note->mood,
                    'image_url' => $note->image_path ? Storage::url($note->image_path) : null,
                    'is_pinned' => $note->is_pinned,
                    'date_formatted' => $note->created_at->locale('es')->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'screen' => $screenKey,
            'notes' => $notes,
        ]);
    }

    /**
     * Crear una nueva nota o memoria para la pantalla activa.
     */
    public function store(StoreGardenNoteRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('garden-notes', 'public');
        }

        $user       = $request->user();
        $authorName = $validated['author_name']
            ?? ($user ? ($user->name ?? 'Adrián & Carla') : 'Carla Lorena');

        $note = GardenNote::create([
            'screen_key'  => $validated['screen_key'],
            'user_id'     => $user?->id,
            'author_name' => $authorName,
            'title'       => $validated['title'] ?? null,
            'content'     => $validated['content'],
            'mood'        => $validated['mood'] ?? 'love',
            'image_path'  => $imagePath,
            'is_pinned'   => $request->boolean('is_pinned'),
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Nota guardada con amor!',
            'note'    => [
                'id'             => $note->id,
                'screen_key'     => $note->screen_key,
                'title'          => $note->title,
                'content'        => $note->content,
                'author_name'    => $note->author_name,
                'mood'           => $note->mood,
                'image_url'      => $note->image_path ? Storage::url($note->image_path) : null,
                'is_pinned'      => $note->is_pinned,
                'date_formatted' => 'Justo ahora',
            ],
        ], 201);
    }

    /**
     * Actualizar una nota existente.
     */
    public function update(Request $request, GardenNote $note): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:120'],
            'content' => ['required', 'string', 'max:2500'],
            'mood' => ['nullable', 'string', 'in:love,joy,calm,nostalgia,hope,secret,dream,memory,gratitude'],
            'author_name' => ['nullable', 'string', 'max:80'],
            'is_pinned' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:6144'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_image') && $note->image_path) {
            Storage::disk('public')->delete($note->image_path);
            $note->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($note->image_path) {
                Storage::disk('public')->delete($note->image_path);
            }
            $note->image_path = $request->file('image')->store('garden-notes', 'public');
        }

        $note->title = $validated['title'] ?? $note->title;
        $note->content = $validated['content'];
        $note->mood = $validated['mood'] ?? $note->mood;
        if (isset($validated['author_name'])) {
            $note->author_name = $validated['author_name'];
        }
        if ($request->has('is_pinned')) {
            $note->is_pinned = $request->boolean('is_pinned');
        }
        $note->save();

        return response()->json([
            'success' => true,
            'message' => 'Nota actualizada correctamente.',
            'note' => [
                'id' => $note->id,
                'screen_key' => $note->screen_key,
                'title' => $note->title,
                'content' => $note->content,
                'author_name' => $note->author_name,
                'mood' => $note->mood,
                'image_url' => $note->image_path ? Storage::url($note->image_path) : null,
                'is_pinned' => $note->is_pinned,
                'date_formatted' => $note->updated_at->locale('es')->diffForHumans(),
            ],
        ]);
    }

    /**
     * Eliminar una nota.
     */
    public function destroy(GardenNote $note): JsonResponse
    {
        if ($note->image_path) {
            Storage::disk('public')->delete($note->image_path);
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Nota eliminada con éxito.',
        ]);
    }
}
