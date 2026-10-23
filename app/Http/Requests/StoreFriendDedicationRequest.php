<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFriendDedicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cualquier visitante puede enviar una dedicatoria
    }

    public function rules(): array
    {
        return [
            'author_name'  => ['required', 'string', 'min:2', 'max:60'],
            'message'      => ['required', 'string', 'min:4', 'max:600'],
            'flower_badge' => ['nullable', 'string', 'max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'author_name.required' => 'Por favor escribe tu nombre o apodo.',
            'author_name.min'      => 'El nombre debe tener al menos 2 caracteres.',
            'message.required'     => 'El mensaje de dedicatoria no puede estar vacío.',
            'message.min'          => 'El mensaje debe tener al menos 4 caracteres.',
            'message.max'          => 'El mensaje no puede superar los 600 caracteres.',
        ];
    }

    /**
     * Sanitize inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'author_name' => strip_tags($this->author_name ?? ''),
            'message'     => strip_tags($this->message ?? ''),
        ]);
    }
}
