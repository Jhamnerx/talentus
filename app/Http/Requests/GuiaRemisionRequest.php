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

    public function rules($guia = null, $motivo_traslado_id = null, $docu_rel_tipo = null, $numero_docu_empresa = null, $modalidad_transporte_id = null, $is_transport_m1l = false)
    {

        $rules = [
            'serie_correlativo' => [
                'required',
                'regex:/^[T][A-Z0-9]{3}-[0-9]{1,8}$/', // ERROR 1001
                Rule::unique('guia_remision', 'serie_correlativo')->where(fn($query) => $query->where('empresa_id', session('empresa'))
                    ->whereNull('deleted_at')),
            ],
            'serie' => 'required',
            'correlativo' => 'nullable',
            'fecha_emision' => ['required', 'date_format:Y-m-d', 'before_or_equal:today', 'after_or_equal:2022-07-13'], // ERROR 3436, 2329
            'cliente_id' => 'required',
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'razon_social' => 'required|max:250', // OBSERV 4338
            'motivo_traslado_id' => 'required',
            'descripcion_motivo_traslado' => 'nullable|min:3|max:100|required_if:motivo_traslado_id,13', // OBSERV 4190
            'modalidad_transporte_id' => 'required',
            'fecha_inicio_traslado' => 'required|date|after_or_equal:fecha_emision', // ERROR 3343
            'peso' => 'required',
            'cantidad_items' => 'required|gte:1',
            'numero_contenedor' => 'nullable',
            'code_puerto' => 'nullable',
            'observacion' => 'nullable|string|max:250',

            'direccion_partida' => 'required',
            'ubigeo_partida' => ['required', 'regex:/^[0-9]{6}$/'], // ERROR 2776
            'direccion_llegada' => 'required',
            'ubigeo_llegada' => ['required', 'regex:/^[0-9]{6}$/'], // ERROR 2776
            'venta_id' => 'nullable',
            'asignarTecnico' => 'nullable',

            'codigo_establecimiento_partida' => 'nullable',
            'codigo_establecimiento_llegada' => 'nullable',

            'docu_rel_tipo' => 'nullable',
            'docu_rel_numero' => 'nullable',

            // Campos de transportista / conductor (siempre presentes, nullable)
            'transp_tipo_doc'          => 'nullable',
            'transp_numero_doc'        => 'nullable',
            'transp_razon_social'      => 'nullable',
            'transp_placa'             => ['nullable', 'regex:/^(?!0+$)[A-Z0-9]{6,8}$/'], // ERROR 2567
            'transp_numero_mtc'        => 'nullable',
            'placa_semirremolque'      => ['nullable', 'regex:/^(?!0+$)[A-Z0-9]{6,8}$/'], // ERROR 2567
            'tipo_doc_chofer'          => 'nullable',
            'numero_doc_chofer'        => 'nullable',
            'chofer_nombre'            => 'nullable',
            'chofer_apellidos'          => 'nullable',
            'chofer_licencia'          => 'nullable',
            'has_transport_driver_01'  => 'nullable',
            'is_transport_m1l'         => 'nullable',
            'fecha_entrega_transportista' => 'nullable|date',
            'driver_id'     => 'nullable',
            'transport_id'  => 'nullable',
            'dispatcher_id' => 'nullable',

            'items' => 'array|between:1,100',
            'items.*.producto_id' => 'required',
            'items.*.codigo' => 'required',
            'items.*.cantidad' => 'required|gte:1',
            'items.*.unidad_medida' => 'required',
            'items.*.descripcion' => 'required|min:3|max:500', // OBSERV 4084

            'items_dispositivos' => 'exclude_if:asignarTecnico,false|array',
            'items_sim_card' => 'exclude_if:asignarTecnico,false|array',
            'tecnico_id' => 'exclude_if:asignarTecnico,false|required_if:asignarTecnico,"true"'
        ];

        if ($motivo_traslado_id == '08' || $motivo_traslado_id == '09') {
            $rules['docu_rel_tipo'] = 'required';
            $rules['numero_contenedor'] = 'required';
            $rules['data_puerto'] = 'required';

            // ERROR 3441: formato DAM/DS varía según motivo de traslado
            // Motivo 08 (Importación): tipo 50 → régimen 10, tipo 52 → régimen 18
            // Motivo 09 (Exportación): tipo 50 → régimen 40, tipo 52 → régimen 48
            if ($docu_rel_tipo == '50') {
                $regimen = $motivo_traslado_id == '08' ? '10' : '40';
                $rules['docu_rel_numero'] = ['required', 'regex:/^[0-9]{3}-[0-9]{4}-' . $regimen . '-[0-9]{1,6}$/'];
            }
            if ($docu_rel_tipo == '52') {
                $regimen = $motivo_traslado_id == '08' ? '18' : '48';
                $rules['docu_rel_numero'] = ['required', 'regex:/^[0-9]{3}-[0-9]{4}-' . $regimen . '-[0-9]{1,6}$/'];
            }
        }

        if ($motivo_traslado_id == '02') {

            $rules['numero_documento'] = [
                'required',
                'in:' . $numero_docu_empresa
            ];
        }
        if ($motivo_traslado_id == '14') {

            $rules['numero_documento'] = [
                'required',
                'not_in:' . $numero_docu_empresa
            ];
        }

        // Transporte Público (01): requiere datos del transportista y fecha entrega
        if ($modalidad_transporte_id == '01') {
            $rules['transp_numero_doc'] = 'required';
            $rules['transp_razon_social'] = 'required';
            $rules['fecha_entrega_transportista'] = 'required|date';
        }

        // Transporte Privado (02): requiere placa y datos del chofer
        if ($modalidad_transporte_id == '02') {
            $rules['transp_placa'] = ['required', 'regex:/^(?!0+$)[A-Z0-9]{6,8}$/']; // ERROR 2566, 2567
            $rules['tipo_doc_chofer'] = 'required';
            $rules['numero_doc_chofer'] = 'required';
            // Licencia obligatoria si NO es vehículo M1L (ERROR 2572 / formato ERROR 2573)
            if (!$is_transport_m1l) {
                $rules['chofer_licencia'] = ['required', 'regex:/^(?!0+$)[A-Z0-9]{9,10}$/'];
            }
        }



        if ($guia) {

            $rules['serie_correlativo'] = [
                'required',
                Rule::unique('guia_remision', 'serie_correlativo')->where(fn($query) => $query->where('empresa_id', session('empresa'))
                    ->whereNull('deleted_at'))
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
            'numero_documento.not_in' => 'Cual el motivo es por traslado de bienes vendidos, el número de documento no puede ser el mismo que el de la empresa',

            'fecha_emision.required'         => 'La fecha de emisión es obligatoria',
            'fecha_emision.date_format'       => 'La fecha de emisión debe tener el formato YYYY-MM-DD (error SUNAT 3436)',
            'fecha_emision.before_or_equal'   => 'La fecha de emisión no puede ser futura (error SUNAT 2329)',
            'fecha_emision.after_or_equal'    => 'La fecha de emisión no puede ser anterior al 13/07/2022 (error SUNAT 2329)',
            'transp_placa.regex'        => 'La placa debe ser 6-8 caracteres alfanuméricos en mayúsculas, sin guiones ni espacios (error SUNAT 2567)',
            'placa_semirremolque.regex' => 'La placa semirremolque debe ser 6-8 caracteres alfanuméricos en mayúsculas, sin guiones ni espacios (error SUNAT 2567)',
            'chofer_licencia.required'  => 'El número de licencia de conducir es obligatorio (error SUNAT 2572)',
            'chofer_licencia.regex'     => 'La licencia debe ser 9-10 caracteres alfanuméricos en mayúsculas, sin guiones (error SUNAT 2573)',
        ];

        return $messages;
    }
}
