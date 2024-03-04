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
            "periodo" => 'required',
            "monto_unidad" => 'required',
            "divisa" => 'required',
            "fecha_vencimiento" => 'required|date',
            "fecha_inicio" => 'required|date',
            "cantidad_unidades" => 'nullable',
            "tipo_pago" => 'required',
            "nota" => 'nullable',
            "observacion" => 'nullable',

            'items' => 'array|between:1,100',
            'items.*.plan' => 'required|integer',
            'items.*.placa' => 'required',
            'items.*.fecha' => 'required|date',
            'items.*.vehiculo_id' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {

        $messages = [

            'clientes_id.required' => 'Selecciona un cliente',

            'periodo.required' => 'Selecciona un periodo',
            'divisa.required' => 'Selecciona una divisa',
            'monto_unidad.required' => 'Ingresa un monto',
            'fecha_vencimiento.required' => 'Ingresa la fecha de vencimiento',
            'fecha_vencimiento.date' => 'El formato debe ser de fecha',
            'tipo_pago.required' => 'Selecciona el tipo de pago',

            'items.*.plan.required' => 'Ingresa un plan valido',
            'items.*.plan.integer' => 'No puedes ingresar letras aqui',
            'items.array' => 'Ingresa como minimo un vehiculo',
            'items.between' => 'Ingresa como minimo un vehiculo'
        ];


        return $messages;
    }
}
