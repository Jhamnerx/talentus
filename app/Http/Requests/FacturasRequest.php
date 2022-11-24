<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FacturasRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules($presupuesto = null)
    {
        $rules = [
            'clientes_id' => 'required',
            'serie_numero' => [
                'required', Rule::unique('facturas', 'serie_numero')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),
            ],
            'serie' => 'required',
            'numero' => 'required',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'divisa' => 'required',
            'forma_pago' => 'required',
            'sub_total' => 'required',
            'impuesto' => 'required',
            'total' => 'required',
            'tipo_venta' => 'required',
            'numero_cuotas' => 'integer|required_if:tipo_venta,CREDITO|min:1',
            'detalle_cuotas.*' => 'array|between:1,100|required_if:tipo_venta,CREDITO',
            'vence_cuotas' => 'integer|required_if:tipo_venta,CREDITO|min:1',
            'nota' => 'nullable',
            'items' => 'array|between:1,100',
            'items.*.producto_id' => 'required',
            'items.*.producto' => 'required',
            'items.*.descripcion' => 'nullable',
            'items.*.igv' => 'required',
            'items.*.cantidad' => 'required|digits_between:1,100',
            'items.*.precio' => 'required',
            'items.*.total' => 'required',
        ];

        if ($presupuesto) {

            $rules['serie_numero'] = [
                'required',
                Rule::unique('facturas', 'serie_numero')->where(fn ($query) => $query->where('empresa_id', session('empresa')))
                    ->ignore($presupuesto->id),

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
            'fecha_vencimiento.required' => 'Selecciona una fecha de vencimiento',
            'fecha_vencimiento.date' => 'El campo debe ser una fecha',
            'divisa.required' => 'Debe seleccionar una divisa',
            'forma_pago.required' => 'Selecciona una forma de pago',
            'sub_total.required' => 'Error al calcular el sub total',
            'impuesto.required' => 'Error al calcular el impuesto',
            'total.required' => 'Error al calcular el total',
            'tipo_venta.required' => 'Selecciona una opción',
            'numero_cuotas.integer' => 'Ingresa un valor numerico',
            'numero_cuotas.min' => 'Ingresa un valor mayor a 0 de cuotas',
            'numero_cuotas.required_if' => 'Ingresa el numero de cuotas',
            'detalle_cuotas.*.required_if' => 'No se pudo obtener el detalle de cuotas',
            'detalle_cuotas.between' => 'Ingresa como minimo 1 cuota',
            'vence_cuotas.required_if' => 'Ingresa el periodo de dias',
            'vence_cuotas.integer' => 'Ingresa un valor numerico',
            'vence_cuotas.min' => 'Ingresa un valor mayor a 0',

            'items.*.producto.required' => 'Ingresa el producto',
            'items.*.cantidad.required' => 'Ingresa la cantidad',
            'items.*.precio.required' => 'Ingresa un precio',
            'items.*.total.required' => 'Ingresa un precio',
            'items.array' => 'Ingresa como minimo un producto',
            'items.between' => 'Ingresa como minimo un producto'
        ];

        return $messages;
    }
}
