<?php

namespace App\Http\Requests;

use App\Enums\TicketStatus;
use App\Enums\TicketPriority;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by Policy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'string', Rule::in(array_column(TicketPriority::cases(), 'value'))],
            'category_id' => ['nullable', 'integer', 'exists:ticket_categories,id'],
            'customer_id' => ['required', 'integer', 'exists:clientes,id'],
            'team_id' => ['nullable', 'integer', 'exists:teams,id'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'El asunto del ticket es obligatorio.',
            'subject.max' => 'El asunto no puede exceder 255 caracteres.',
            'description.required' => 'La descripción del ticket es obligatoria.',
            'priority.required' => 'La prioridad es obligatoria.',
            'priority.in' => 'La prioridad seleccionada no es válida.',
            'customer_id.required' => 'El cliente es obligatorio.',
            'customer_id.exists' => 'El cliente seleccionado no existe.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'team_id.exists' => 'El equipo seleccionado no existe.',
            'assigned_to.exists' => 'El usuario asignado no existe.',
        ];
    }
}
