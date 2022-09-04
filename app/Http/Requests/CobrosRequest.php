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
            'cliente' => 'required',
            "vehiculos_id" => 'required',
            "comentario" => 'nullable',
            "periodo" => 'required',
            "monto_unidad" => 'required',
            "fecha_vencimiento" => 'required|date',
            "cantidad_unidades" => 'nullable',
            "tipo_pago" => 'required',
            "nota" => 'nullable',
            "observacion" =>'nullable',
        ];

        return $rules;
    }

    public function messages()
    {

        $messages = [

            'cliente.required' => 'Selecciona un cliente',
            'vehiculos_id.required' => 'Selecciona un vehiculo',
            'periodo.required' => 'Selecciona un periodo',
            'monto_unidad.required' => 'Ingresa un monto',
            'fecha_vencimiento.required' => 'Ingresa la fecha de vencimiento',
            'fecha_vencimiento.date' => 'El formato debe ser de fecha',
            'tipo_pago.required' => 'Selecciona el tipo de pago',

        ];

        return $messages;
    }
}
