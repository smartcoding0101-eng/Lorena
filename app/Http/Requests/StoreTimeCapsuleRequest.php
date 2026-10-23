<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeCapsuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:160'],
            'message'     => ['required', 'string', 'max:5000'],
            'unlock_at'   => ['required', 'date', 'after:now'],
            'mood'        => ['nullable', 'string', 'in:love,secret,anniversary,birthday,future'],
            'author_name' => ['nullable', 'string', 'max:100'],
            'image'       => ['nullable', 'image', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'La cápsula debe tener un título que la identifique.',
            'message.required'  => 'El mensaje secreto de la cápsula no puede estar vacío.',
            'message.max'       => 'El mensaje no puede superar los 5000 caracteres.',
            'unlock_at.required' => 'Debes indicar cuándo podrá abrirse esta cápsula.',
            'unlock_at.after'   => 'La fecha de apertura debe ser en el futuro.',
            'image.image'       => 'El archivo adjunto debe ser una imagen válida.',
            'image.max'         => 'La imagen no puede superar los 10 MB.',
        ];
    }
}
