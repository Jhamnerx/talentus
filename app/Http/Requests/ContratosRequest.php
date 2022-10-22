<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratosRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // $contrato = $this->route()->parameter('contrato');

        $rules = [
            'clientes_id' => 'required',
            'fecha' => 'required',
            'ciudades_id' => 'required',
            'items' => 'array|between:1,30',
            'items.*.plan' => 'required|integer',
            'items.*.placa' => 'required',
            'items.*.vehiculos_id' => 'required',
            'sello' => 'boolean',
            'fondo' => 'boolean',


        ];

        return $rules;
    }

    public function messages()
    {

        $messages = [

            'clientes_id.required' => 'Debes Seleccionar un Cliente',
            'fecha.required' => 'Selecciona una fecha',
            'ciudades_id.required' => 'Debe seleccionar una ciudad',
            'items.*.plan.required' => 'Ingresa un plan valido',
            'items.*.plan.integer' => 'No puedes ingresar letras aqui',
            'items.array' => 'Ingresa como minimo un vehiculo',
            'items.between' => 'Ingresa como minimo un vehiculo'
        ];

        return $messages;
    }
}
