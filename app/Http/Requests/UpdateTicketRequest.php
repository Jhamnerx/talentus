<?php

namespace App\Http\Requests;

use App\Enums\TicketPriority;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
            'subject' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'priority' => ['sometimes', 'required', 'string', Rule::in(array_column(TicketPriority::cases(), 'value'))],
            'category_id' => ['nullable', 'integer', 'exists:ticket_categories,id'],
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
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }
}
