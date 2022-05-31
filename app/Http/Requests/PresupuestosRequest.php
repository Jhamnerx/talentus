<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresupuestosRequest extends FormRequest
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
        $contrato = $this->route()->parameter('contrato');

        $rules = [
            'clientes_id' => 'required',
            'numero' => 'required|unique:presupuestos,numero',
            'fecha' => 'required',
            'fecha_caducidad' => 'required',
            'divisa' => 'required',
            'items[]' => 'required',
        ];
        if ($contrato) {

            $rules['numero'] = 'required|unique:presupuestos,numero,' . $contrato->id;
        }

        return $rules;
    }

        public function messages()
    {

        $messages = [

            'clientes_id.required' => 'Debes Seleccionar un Cliente',
            'numero.required' => 'Debes Ingresar un numero',
            'numero.unique' => 'Este número ya esta registrado',
            'fecha.required' => 'Selecciona una fecha',
            'fecha_caducidad.required' => 'Selecciona una fecha de Caducidad',
            'divisa.required' => 'Debe seleccionar una divisa',
            'items[].required' => 'Debes Ingresar al menos un item',
        ];

        return $messages;
    }
}
