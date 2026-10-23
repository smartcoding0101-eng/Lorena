<?php

namespace App\Services;

use App\Models\GardenHomeCard;

/**
 * Encapsula la lógica de negocio de las tarjetas de inicio dinámicas.
 * Permite crear, actualizar, eliminar y reordenar las cards del jardín.
 */
class GardenHomeCardService
{
    /**
     * Crear una nueva tarjeta de inicio.
     * Si no se indica sort_order, se posiciona al final.
     *
     * @param array $data Campos validados del FormRequest
     * @return GardenHomeCard
     */
    public function create(array $data): GardenHomeCard
    {
        if (empty($data['sort_order'])) {
            $data['sort_order'] = (GardenHomeCard::max('sort_order') ?? 0) + 1;
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;

        return GardenHomeCard::create($data);
    }

    /**
     * Actualizar una tarjeta existente.
     *
     * @param GardenHomeCard $card
     * @param array          $data Campos validados
     * @return GardenHomeCard
     */
    public function update(GardenHomeCard $card, array $data): GardenHomeCard
    {
        if (array_key_exists('is_active', $data)) {
            $data['is_active'] = (bool) $data['is_active'];
        }

        $card->update($data);
        return $card->fresh();
    }

    /**
     * Eliminar una tarjeta.
     */
    public function delete(GardenHomeCard $card): void
    {
        $card->delete();
    }

    /**
     * Reordenar las tarjetas según el array de IDs ordenados recibido.
     * Cada posición en el array = sort_order de esa tarjeta.
     *
     * @param array $orderedIds  Array de IDs en el orden deseado, ej. [3, 1, 5, 2]
     */
    public function reorder(array $orderedIds): void
    {
        foreach ($orderedIds as $position => $id) {
            GardenHomeCard::where('id', (int) $id)->update(['sort_order' => $position + 1]);
        }
    }

    /**
     * Obtener todas las tarjetas activas ordenadas, listas para la vista.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActive()
    {
        return GardenHomeCard::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Obtener todas las tarjetas (activas e inactivas) para el panel admin.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return GardenHomeCard::orderBy('sort_order')->get();
    }
}
