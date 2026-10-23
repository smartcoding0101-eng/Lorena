<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGardenHomeCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->is_admin || in_array(auth()->id(), [1, 2], true));
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:100'],
            'subtitle'      => ['nullable', 'string', 'max:150'],
            'emblem_icon'   => ['nullable', 'string', 'max:20'],
            'description'   => ['required', 'string', 'max:1000'],
            'quote'         => ['nullable', 'string', 'max:255'],
            'target_screen' => ['required', 'string', 'max:50'],
            'style_variant' => ['required', 'string', 'max:50'],
            'sort_order'    => ['nullable', 'integer', 'min:1'],
            'is_active'     => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'         => 'El título de la tarjeta es obligatorio.',
            'description.required'   => 'La descripción de la tarjeta es obligatoria.',
            'target_screen.required' => 'Debes elegir una pantalla de destino.',
            'style_variant.required' => 'Debes elegir un estilo visual para la tarjeta.',
        ];
    }
}
