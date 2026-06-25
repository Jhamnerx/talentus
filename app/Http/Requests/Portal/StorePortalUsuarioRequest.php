<?php

namespace App\Http\Requests\Portal;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePortalUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->esTitular() ?? false;
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException('Solo el titular puede gestionar los usuarios de la cuenta.');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('cliente_users', 'email')],
            'telefono' => ['nullable', 'string', 'max:30'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Ingresa el nombre del colaborador.',
            'email.required' => 'Ingresa el correo del colaborador.',
            'email.email' => 'Debe tener formato de correo electrónico.',
            'email.unique' => 'Ya existe una cuenta con este correo.',
        ];
    }
}
