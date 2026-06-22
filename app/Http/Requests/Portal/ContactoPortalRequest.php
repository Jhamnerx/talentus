<?php

namespace App\Http\Requests\Portal;

use Illuminate\Foundation\Http\FormRequest;

class ContactoPortalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:191'],
            'numero_documento' => ['required', 'string', 'max:191'],
            'cargo' => ['nullable', 'string', 'max:191'],
            'telefono' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'birthday' => ['nullable', 'date'],
            'is_gerente' => ['nullable', 'boolean'],
            'is_cobros' => ['nullable', 'boolean'],
            'descripcion' => ['nullable', 'string', 'max:191'],
            'nota' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'Ingresa el nombre del contacto.',
            'numero_documento.required' => 'Ingresa el documento del contacto.',
            'email.email' => 'Debe tener formato de correo electrónico.',
        ];
    }
}
