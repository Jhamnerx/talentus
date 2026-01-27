<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachTicketFileRequest extends FormRequest
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
            'file' => ['required', 'file', 'max:10240'], // max 10MB
            'message_id' => ['nullable', 'integer', 'exists:ticket_messages,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Debe seleccionar un archivo.',
            'file.file' => 'El archivo no es válido.',
            'file.max' => 'El archivo no puede exceder 10 MB.',
            'message_id.exists' => 'El mensaje seleccionado no existe.',
        ];
    }
}
