<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComprasFacturasRequest extends FormRequest
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
        $factura = $this->route()->parameter('factura');

        $rules = [

            'proveedores_id' => 'required',
            'numero' => ['required', Rule::unique('compras_factura', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa')))],
            'fecha_emision' => 'required',
            'divisa' => 'required',
            'subtotal' => 'required',
            'subtotal' => 'required',
            'total' => 'required',
            'items.*.producto' => 'required',
            'items.*.cantidad' => 'required',
            'items.*.precio' => 'required',
            'items.*.importe' => 'required',
        ];

        if ($factura) {

            $rules['numero'] = ['required', Rule::unique('facturas', 'numero')->ignore($factura->id)->where(fn ($query) => $query->where('empresa_id', session('empresa')))];
        }

        return $rules;
    }

    public function messages()
    {

        $messages = [

            'proveedores_id.required' => 'Debes Seleccionar un proveedor',
            'numero.required' => 'Debes Ingresar un numero',
            'numero.unique' => 'Este número ya esta registrado',
            'fecha_vencimiento.required' => 'Selecciona una fecha',
            'divisa.required' => 'Debe seleccionar una divisa',
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
