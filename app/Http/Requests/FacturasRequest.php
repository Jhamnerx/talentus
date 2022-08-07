<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturasRequest extends FormRequest
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

        $factura = $this->route()->parameter('factura');
       // dd($factura);
        $rules = [
            'clientes_id' => 'required',
            'numero' => 'required|unique:facturas,numero',
            'fecha_emision' => 'required',
            'fecha_vencimiento' => 'required',
            'divisa' => 'required',
            'tipo_pago' => 'required',
            'subtotal' => 'required',
            'impuesto' => 'required',
            'total' => 'required',
            'items.*.producto' => 'required',
            'items.*.cantidad' => 'required',
            'items.*.precio' => 'required',
            'items.*.importe' => 'required',
        ];
        if ($factura) {


            $rules['numero'] = 'required|unique:facturas,numero,' . $factura->id;

        }

        return $rules;
    }

        public function messages()
    {

        $messages = [

            'clientes_id.required' => 'Debes Seleccionar un Cliente',
            'numero.required' => 'Debes Ingresar un numero',
            'numero.unique' => 'Este número ya esta registrado',
            'fecha_emision.required' => 'Selecciona una fecha',
            'fecha_vencimiento.required' => 'Selecciona una fecha',
            'divisa.required' => 'Debe seleccionar una divisa',
            'tipo_pago.required' => 'Debe seleccionar una divisa',
            'subtotal.required' => 'No se encontro el subtotal',
            'impuesto.required' => 'No se encontro el impuesto',
            'total.required' => 'No se encontro el total',
            'items.*.producto.required' => 'Ingresa el producto',
            'items.*.cantidad.required' => 'Ingresa la cantidad',
            'items.*.precio.required' => 'Ingresa un precio',
        ];

        return $messages;
    }
}
