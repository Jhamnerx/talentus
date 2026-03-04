<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CobrosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'clientes_id' => 'required',
            "comentario" => 'nullable',
            "divisa" => 'required',
            "nota" => 'nullable',
            "tipo_pago" => 'required|in:FACTURA,RECIBO',

            'items' => 'array|between:1,100',
            'items.*.plan_id' => 'required|exists:plans,id',
            'items.*.monto' => 'required|decimal:0,4',
            'items.*.placa' => 'required',
            'items.*.periodo' => 'required|in:MENSUAL,BIMENSUAL,TRIMESTRAL,SEMESTRAL,ANUAL',
            'items.*.fecha_inicio' => 'required|date',
            'items.*.fecha_vencimiento' => 'nullable|date',
            'items.*.vehiculo_id' => 'required',
            'items.*.estado' => 'boolean',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'clientes_id.required' => 'Selecciona un cliente',
            'divisa.required' => 'Selecciona una divisa',
            'tipo_pago.required' => 'Selecciona el tipo de comprobante',
            'tipo_pago.in'       => 'El tipo de comprobante debe ser FACTURA o RECIBO',

            'items.array' => 'Ingresa como mínimo un vehículo',
            'items.between' => 'Ingresa como mínimo un vehículo',
            'items.*.plan_id.required' => 'Selecciona un plan para cada vehículo',
            'items.*.plan_id.exists' => 'El plan seleccionado no es válido',
            'items.*.monto.required' => 'El monto es requerido',
            'items.*.monto.decimal' => 'El monto debe ser un número decimal válido',
            'items.*.periodo.required' => 'Selecciona un periodo para cada vehículo',
            'items.*.periodo.in' => 'El periodo debe ser MENSUAL, BIMENSUAL, TRIMESTRAL, SEMESTRAL o ANUAL',
            'items.*.fecha_inicio.required' => 'Ingresa la fecha de inicio para cada vehículo',
            'items.*.fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida',
            'items.*.fecha_vencimiento.date' => 'La fecha de vencimiento debe ser una fecha válida',
        ];

        return $messages;
    }
}
