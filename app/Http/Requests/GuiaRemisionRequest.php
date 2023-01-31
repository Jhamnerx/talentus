<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuiaRemisionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules($guia = null)
    {

        $rules = [
            'serie_numero' => [
                'required', Rule::unique('guia_remision', 'serie_numero')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),
            ],
            'fecha_emision' => 'required|date',
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'razon_social' => 'required',
            'motivo_traslado' => 'required',
            'modalidad_traslado' => 'required',
            'fecha_inicio_traslado' => 'required|date',
            'peso' => 'required',
            'cantidad_items' => 'required|gte:1',
            'numero_contenedor' => 'nullable',
            'code_puerto' => 'nullable',
            'direccion_partida' => 'required',
            'ubigeo_partida' => 'required',
            'direccion_llegada' => 'required',
            'ubigeo_llegada' => 'required',
            'factura_id' => 'nullable',
            'asignarTecnico' => 'nullable',
            'items' => 'array|between:1,100',
            'items.*.producto_id' => 'required',
            'items.*.codigo' => 'required',
            'items.*.cantidad' => 'required|gte:1',
            'items.*.unidad_medida' => 'required',
            'items.*.descripcion' => 'required',

            'imeis_add' => 'exclude_if:asignarTecnico,false|array',
            'sim_add' => 'exclude_if:asignarTecnico,false|array',
            'users_id' => 'exclude_if:asignarTecnico,false|required_if:asignarTecnico,"true"'
        ];

        if ($guia) {

            $rules['serie_numero'] = [
                'required',
                Rule::unique('guia_remision', 'serie_numero')->where(fn ($query) => $query->where('empresa_id', session('empresa')))
                    ->ignore($guia->id),

            ];
        }

        return $rules;
    }
    public function messages()
    {

        $messages = [
            'items.*.producto_id.required' => 'Ingresa el producto',
            'items.*.codigo.required' => 'Ingresa la cantidad',
            'items.*.cantidad.required' => 'Ingresa una cantidad',
            'items.*.cantidad.gte' => 'Ingresa como minimo 1',
            'items.*.unidad_medida.required' => 'Producto sin unidad de medida',
            'items.*.descripcion.required' => 'Ingrese una descripción',

            'imeis_add.required_if' => 'Si asignar tecnico esta activado, debes ingresar los imei a asignar',
            'users_id.required_if' => 'Debe seleccionar un usuario de rol Tecnico',

            'imeis_add.min' => 'Ingresa como minimo un imei',
        ];

        return $messages;
    }
}
