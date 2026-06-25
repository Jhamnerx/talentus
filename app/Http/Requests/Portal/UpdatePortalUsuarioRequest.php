<?php

namespace App\Http\Requests\Portal;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePortalUsuarioRequest extends FormRequest
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
            'estado' => ['required', Rule::in(['aprobado', 'suspendido'])],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'estado.required' => 'Indica el estado.',
            'estado.in' => 'Estado no válido.',
        ];
    }
}
