<?php

namespace App\Services;

use App\Models\GardenNote;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Encapsula toda la lógica de creación, actualización y eliminación
 * de notas del jardín (GardenNote), incluyendo el manejo de imágenes.
 */
class GardenNoteService
{
    /**
     * Crear una nueva nota, manejando la imagen si viene incluida.
     *
     * @param array             $data   Campos validados del FormRequest
     * @param UploadedFile|null $image  Archivo de imagen opcional
     * @param int|null          $userId ID del usuario autenticado (si aplica)
     * @return GardenNote
     */
    public function create(array $data, ?UploadedFile $image, ?int $userId): GardenNote
    {
        $imagePath = null;
        if ($image) {
            $imagePath = $image->store('garden-notes', 'public');
        }

        $authorName = $data['author_name'] ?? null;
        if (!$authorName) {
            $authorName = 'Carla Lorena';
        }

        return GardenNote::create([
            'screen_key'  => $data['screen_key'],
            'user_id'     => $userId,
            'author_name' => $authorName,
            'title'       => $data['title'] ?? null,
            'content'     => $data['content'],
            'mood'        => $data['mood'] ?? 'love',
            'image_path'  => $imagePath,
            'is_pinned'   => (bool) ($data['is_pinned'] ?? false),
        ]);
    }

    /**
     * Actualizar una nota existente, manejando el reemplazo o eliminación
     * de imagen cuando corresponda.
     *
     * @param GardenNote        $note
     * @param array             $data
     * @param UploadedFile|null $image
     * @param bool              $removeImage Si el usuario pidió eliminar la imagen
     * @return GardenNote
     */
    public function update(GardenNote $note, array $data, ?UploadedFile $image, bool $removeImage = false): GardenNote
    {
        if ($removeImage && $note->image_path) {
            Storage::disk('public')->delete($note->image_path);
            $note->image_path = null;
        }

        if ($image) {
            if ($note->image_path) {
                Storage::disk('public')->delete($note->image_path);
            }
            $note->image_path = $image->store('garden-notes', 'public');
        }

        $note->update([
            'title'       => $data['title'] ?? $note->title,
            'content'     => $data['content'],
            'mood'        => $data['mood'] ?? $note->mood,
            'author_name' => $data['author_name'] ?? $note->author_name,
            'is_pinned'   => (bool) ($data['is_pinned'] ?? $note->is_pinned),
            'image_path'  => $note->image_path,
        ]);

        return $note->fresh();
    }

    /**
     * Eliminar una nota y su imagen asociada del disco.
     */
    public function delete(GardenNote $note): void
    {
        if ($note->image_path) {
            Storage::disk('public')->delete($note->image_path);
        }
        $note->delete();
    }

    /**
     * Formatea una nota para la respuesta JSON de la API.
     */
    public function toApiArray(GardenNote $note, string $dateFormatted = 'Justo ahora'): array
    {
        return [
            'id'             => $note->id,
            'screen_key'     => $note->screen_key,
            'title'          => $note->title,
            'content'        => $note->content,
            'author_name'    => $note->author_name,
            'mood'           => $note->mood,
            'image_url'      => $note->image_path ? Storage::url($note->image_path) : null,
            'is_pinned'      => $note->is_pinned,
            'date_formatted' => $dateFormatted,
        ];
    }
}
