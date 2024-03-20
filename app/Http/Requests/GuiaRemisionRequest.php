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

    public function rules($guia = null, $motivo_traslado_id = null, $docu_rel_tipo = null, $numero_docu_empresa = null)
    {

        $rules = [
            'serie_correlativo' => [
                'required', Rule::unique('guia_remision', 'serie_correlativo')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),
            ],
            'serie' => 'required',
            'correlativo' => 'nullable',
            'fecha_emision' => 'required|date',
            'cliente_id' => 'required',
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'razon_social' => 'required',
            'motivo_traslado_id' => 'required',
            'descripcion_motivo_traslado' => 'required_if:motivo_traslado_id,13',
            'modalidad_transporte_id' => 'required',
            'fecha_inicio_traslado' => 'required|date',
            'peso' => 'required',
            'cantidad_items' => 'required|gte:1',
            'numero_contenedor' => 'nullable',
            'code_puerto' => 'nullable',
            'observacion' => 'nullable',

            'direccion_partida' => 'required',
            'ubigeo_partida' => 'required',
            'direccion_llegada' => 'required',
            'ubigeo_llegada' => 'required',
            'venta_id' => 'nullable',
            'asignarTecnico' => 'nullable',

            'codigo_establecimiento_partida' => 'nullable',
            'codigo_establecimiento_llegada' => 'nullable',

            'docu_rel_tipo' => 'nullable',
            'docu_rel_numero' => 'nullable',

            'items' => 'array|between:1,100',
            'items.*.producto_id' => 'required',
            'items.*.codigo' => 'required',
            'items.*.cantidad' => 'required|gte:1',
            'items.*.unidad_medida' => 'required',
            'items.*.descripcion' => 'required',

            'items_dispositivos' => 'exclude_if:asignarTecnico,false|array',
            'items_sim_card' => 'exclude_if:asignarTecnico,false|array',
            'tecnico_id' => 'exclude_if:asignarTecnico,false|required_if:asignarTecnico,"true"'
        ];

        if ($motivo_traslado_id == '08' || $motivo_traslado_id == '09') {
            $rules['docu_rel_tipo'] = 'required';
            $rules['numero_contenedor'] = 'required';
            $rules['data_puerto'] = 'required';

            if ($docu_rel_tipo == '50') {
                $rules['docu_rel_numero'] = 'required|regex:([0-9]{3}-[0-9]{4}-10-[0-9]{1,6})|regex:/^\S*$/u';
            }
            if ($docu_rel_tipo == '52') {
                $rules['docu_rel_numero'] = 'required|regex:([0-9]{3}-[0-9]{4}-18-[0-9]{1,6})|regex:/^\S*$/u';
            }
        }

        if ($motivo_traslado_id == '02') {

            $rules['numero_documento'] = [
                'required',
                'in:' . $numero_docu_empresa
            ];
        }



        if ($guia) {

            $rules['serie_correlativo'] = [
                'required',
                Rule::unique('guia_remision', 'serie_correlativo')->where(fn ($query) => $query->where('empresa_id', session('empresa')))
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
            'tecnico_id.required_if' => 'Selecciona un tecnico',
            'descripcion_motivo_traslado.required_if' => 'Ingresa una descripción del motivo de traslado',
            'docu_rel_numero.regex' => 'El número de documento debe tener el formato 000-0000-10-000000 o 000-0000-18-000000',
            'numero_contenedor.required' => 'El número de contenedor es requerido',
            'numero_documento.in' => 'El número de documento debe ser el mismo que el de la empresa',
        ];

        return $messages;
    }
}
