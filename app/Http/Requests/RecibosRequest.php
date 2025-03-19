<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecibosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules($recibo = null)
    {
        $rules = [
            'clientes_id' => 'required',
            'serie_numero' => [
                'required',
                Rule::unique('recibos', 'serie_numero')->where(function ($query) {
                    $query->where('empresa_id', session('empresa'))
                        ->whereNull('deleted_at');
                }),
            ],
            'serie' => 'required',
            'estado' => 'required',
            'numero' => 'required',
            'fecha_emision' => 'required|date',
            'fecha_pago' => 'nullable|date',
            'divisa' => 'required',
            'forma_pago' => 'required',
            'total' => 'required',
            'tipo_venta' => 'required',
            'nota' => 'nullable',
            'items' => 'array|between:1,100',
            'items.*.producto_id' => 'required',
            'items.*.producto' => 'required',
            'items.*.descripcion' => 'nullable',
            'items.*.cantidad' => 'required|gte:1',
            'items.*.precio' => 'required',
            'items.*.total' => 'required',
        ];

        if ($recibo) {

            $rules['serie_numero'] = [
                'required',
                Rule::unique('recibos', 'serie_numero')->where(fn($query) => $query->where('empresa_id', session('empresa')))
                    ->ignore($recibo->id),

            ];
        }

        return $rules;
    }

    public function messages()
    {

        $messages = [
            'clientes_id.required' => 'Debes Seleccionar un Cliente',
            'serie_numero.required' => 'La serie y numero son requeridos',
            'serie_numero.unique' => 'Esta serie y numero ya existe',
            'serie.required' => 'Ingresa la serie',
            'numero.required' => 'Ingresa el numero',
            'fecha_emision.required' => 'Selecciona una fecha',
            'fecha.date' => 'El campo debe ser una fecha',
            'fecha_pago.date' => 'El campo debe ser una fecha',
            'divisa.required' => 'Debe seleccionar una divisa',
            'forma_pago.required' => 'Selecciona una forma de pago',
            'total.required' => 'Error al calcular el total',
            'tipo_venta.required' => 'Selecciona una opción',

            'items.*.producto.required' => 'Ingresa el producto',
            'items.*.cantidad.required' => 'Ingresa la cantidad',
            'items.*.cantidad.gte' => 'Ingresa como minimo 1',
            'items.*.precio.required' => 'Ingresa un precio',
            'items.*.total.required' => 'Ingresa un precio',
            'items.array' => 'Ingresa como minimo un producto',
            'items.between' => 'Ingresa como minimo un producto'
        ];

        return $messages;
    }
}
