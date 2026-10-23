<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGardenNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'screen_key'  => ['required', 'string', 'max:60'],
            'title'       => ['nullable', 'string', 'max:140'],
            'content'     => ['required', 'string', 'min:1', 'max:4000'],
            'author_name' => ['nullable', 'string', 'max:80'],
            'mood'        => ['nullable', 'string', 'in:love,joy,calm,nostalgia,hope,secret,dream,memory,gratitude'],
            'is_pinned'   => ['nullable', 'boolean'],
            'image'       => ['nullable', 'image', 'max:8192'],
        ];
    }

    public function messages(): array
    {
        return [
            'screen_key.required' => 'Debes indicar a qué rincón pertenece esta nota.',
            'content.required'    => 'El contenido de la nota no puede estar vacío.',
            'content.min'         => 'La nota debe tener al menos 1 carácter.',
            'content.max'         => 'La nota no puede superar los 4000 caracteres.',
            'image.image'         => 'El archivo adjunto debe ser una imagen válida.',
            'image.max'           => 'La imagen no puede superar los 8 MB.',
        ];
    }
}
