<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGardenPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'    => ['required', 'string', 'min:1', 'max:160'],
            'category' => ['nullable', 'string', 'max:80'],
            'excerpt'  => ['nullable', 'string', 'max:500'],
            'body'     => ['required', 'string', 'min:1', 'max:30000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.max'      => 'El título no puede superar los 160 caracteres.',
            'body.required'  => 'El contenido de la entrada no puede estar vacío.',
            'body.max'       => 'El contenido no puede superar los 30000 caracteres.',
        ];
    }
}
