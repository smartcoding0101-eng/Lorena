<?php

namespace App\Services;

use App\Models\TimeCapsule;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Encapsula la lógica de negocio de las Cápsulas del Tiempo:
 * creación, apertura, eliminación y formateo para la API.
 */
class TimeCapsuleService
{
    /**
     * Crear una nueva cápsula sellada para el usuario.
     *
     * @param array             $data  Campos validados
     * @param UploadedFile|null $image Imagen adjunta opcional
     * @param User              $user  Usuario autenticado
     * @return TimeCapsule
     */
    public function create(array $data, ?UploadedFile $image, User $user): TimeCapsule
    {
        $imagePath = null;
        if ($image) {
            $imagePath = $image->store('time-capsules', 'public');
        }

        return $user->timeCapsules()->create([
            'title'       => trim($data['title']),
            'message'     => trim($data['message']),
            'unlock_at'   => $data['unlock_at'],
            'mood'        => $data['mood'] ?? 'love',
            'author_name' => ($data['author_name'] ?? '') ?: ($user->name ?? 'Carla Lorena'),
            'image_path'  => $imagePath,
            'is_opened'   => false,
        ]);
    }

    /**
     * Intentar marcar la cápsula como abierta.
     * Retorna false si aún no ha llegado la fecha de apertura.
     *
     * @param TimeCapsule $capsule
     * @param User        $user
     * @return bool  true si se marcó correctamente, false si aún está bloqueada
     * @throws \Illuminate\Auth\Access\AuthorizationException si el usuario no es el dueño
     */
    public function markOpened(TimeCapsule $capsule, User $user): bool
    {
        if ($capsule->user_id !== $user->id) {
            abort(403, 'No autorizado.');
        }

        if (!$capsule->isUnlocked()) {
            return false;
        }

        $capsule->update(['is_opened' => true]);
        return true;
    }

    /**
     * Eliminar la cápsula y su imagen del disco.
     *
     * @param TimeCapsule $capsule
     * @param User        $user
     */
    public function delete(TimeCapsule $capsule, User $user): void
    {
        if ($capsule->user_id !== $user->id && !$user->is_admin) {
            abort(403, 'No autorizado.');
        }

        if ($capsule->image_path) {
            Storage::disk('public')->delete($capsule->image_path);
        }

        $capsule->delete();
    }

    /**
     * Formatea una cápsula para la respuesta JSON de la lista (index).
     * El mensaje secreto sólo se expone si ya está desbloqueada.
     */
    public function toApiArray(TimeCapsule $capsule): array
    {
        $isUnlocked = $capsule->isUnlocked();

        return [
            'id'                  => $capsule->id,
            'title'               => $capsule->title,
            'message'             => $isUnlocked ? $capsule->message : null,
            'author_name'         => $capsule->author_name,
            'unlock_at'           => $capsule->unlock_at->toIso8601String(),
            'unlock_at_formatted' => $capsule->unlock_at->translatedFormat('d \d\e F, Y - H:i'),
            'is_unlocked'         => $isUnlocked,
            'is_opened'           => $capsule->is_opened,
            'mood'                => $capsule->mood,
            'image_url'           => ($isUnlocked && $capsule->image_path)
                                        ? Storage::url($capsule->image_path)
                                        : null,
            'has_image'           => !empty($capsule->image_path),
            'created_at'          => $capsule->created_at->translatedFormat('d M Y'),
        ];
    }

    /**
     * Formatea una cápsula recién creada (aún sellada) para la respuesta JSON.
     */
    public function toCreatedApiArray(TimeCapsule $capsule): array
    {
        return [
            'id'                  => $capsule->id,
            'title'               => $capsule->title,
            'unlock_at'           => $capsule->unlock_at->toIso8601String(),
            'unlock_at_formatted' => $capsule->unlock_at->translatedFormat('d \d\e F, Y - H:i'),
            'is_unlocked'         => false,
        ];
    }
}
