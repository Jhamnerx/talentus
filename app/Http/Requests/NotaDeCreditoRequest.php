<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaDeCreditoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo_comprobante_id' => 'required|exists:tipo_comprobantes,codigo',
            'serie' => 'required|exists:series,serie',
            'correlativo' => 'required',
            'serie_correlativo' => 'required',
            'fecha_emision' => 'required|date',
            'invoice_id' => 'required|exists:ventas,id',
            'invoice_id_new' => 'nullable',
            'serie_correlativo_ref' => 'required|exists:ventas,serie_correlativo'
        ];
    }
}
