<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecibosRequest extends FormRequest
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

        $recibo = $this->route()->parameter('recibo');
        $rules = [
            'clientes_id' => 'required',
            'numero' => 'required|unique:recibos,numero',
            'fecha' => 'required',
            'divisa' => 'required',
            'items.*.producto' => 'required',
            'items.*.cantidad' => 'required',
            'items.*.precio' => 'required',
            'items.*.importe' => 'required',
        ];
        if ($recibo) {


            $rules['numero'] = 'required|unique:recibos,numero,' . $recibo->id;

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
            'divisa.required' => 'Debe seleccionar una divisa',
            'items.*.producto.required' => 'Ingresa el producto',
            'items.*.cantidad.required' => 'Ingresa la cantidad',
            'items.*.precio.required' => 'Ingresa un precio',
        ];

        return $messages;
    }
}
