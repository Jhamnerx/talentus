<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules($detraccion = false): array
    {
        $rules = [
            'tipo_comprobante_id' => 'required|exists:tipo_comprobantes,codigo',
            'serie' => 'required|exists:series,serie',
            'correlativo' => 'required',
            'tipo_operacion' => 'required',
            'serie_correlativo' => 'required',
            'cliente_id' => 'required|exists:clientes,id',
            'direccion' => 'required',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'divisa' => 'required',
            'tipo_cambio' => 'required_if:divisa,USD',
            'metodo_pago_id' => 'required',
            'comentario' => 'nullable',
            'op_gravadas' => 'required',
            'op_exoneradas' => 'required',
            'op_inafectas' => 'required',
            'op_gratuitas' => 'required',
            'igv_op' => 'nullable',
            'descuento' => 'required',
            'tipo_descuento' => 'required',
            'descuento_factor' => 'nullable',
            'icbper' => 'nullable',
            'igv' => 'required',
            'sub_total' => 'required',
            'adelanto' => 'nullable',
            'total' => 'required',
            'numero_cuotas' => 'exclude_unless:forma_pago,CREDITO|integer|required_if:forma_pago,CREDITO|min:1',
            'vence_cuotas' => 'exclude_unless:forma_pago,CREDITO|integer|required_if:forma_pago,CREDITO|min:1',
            'adelanto' => 'exclude_unless:forma_pago,CREDITO|required_if:forma_pago,CREDITO',
            'detalle_cuotas.*' => 'array|between:1,100|required_if:forma_pago,CREDITO',
            'forma_pago' => 'required',

            'items' => 'array|between:1,1000',
            'items.*.producto_id' => 'required',
            'items.*.codigo' => 'required',
            'items.*.cantidad' => 'required|gte:1',
            'items.*.unit' => 'required',
            'items.*.unit_name' => 'required',
            'items.*.descripcion' => 'required',
            'items.*.valor_unitario' => 'required',
            'items.*.precio_unitario' => 'required',
            'items.*.porcentaje_igv' => 'required',
            'items.*.igv' => 'required',
            'items.*.icbper' => 'required',
            'items.*.total_icbper' => 'required',
            'items.*.sub_total' => 'required',
            'items.*.total' => 'required',
            'items.*.codigo_afectacion' => 'required',
            'items.*.afecto_icbper' => 'required',
            'items.*.tipo' => 'required',

            //  'total_cuotas' => 'exclude_if:forma_pago,CONTADO|required|same:total',
            //'detalle_cuotas.*.importe' => 'required',
        ];

        if ($detraccion) {
            $rules['datosDetraccion.codigo_detraccion'] = 'required';
            $rules['datosDetraccion.porcentaje'] = 'required|min:1';
            $rules['datosDetraccion.monto'] = 'required|min:1';
            $rules['datosDetraccion.metodo_pago_id'] = 'required';
            $rules['datosDetraccion.cuenta_bancaria'] = 'required|alpha_num';
            // $rules['total'] = 'required|same:detraccion.total_venta';
        }


        return $rules;
    }

    public function messages()
    {

        $messages = [
            'total_cuotas.same' => 'la suma de las cuotas debe ser igual al Monto neto',
            'cliente_id.required' => 'Debes Seleccionar un cliente',
            'items.between' => 'Debes Añadir al menos 1 producto o servicio',
            'datosDetraccion.cuenta_bancaria.required' => 'La cuenta bancaria es obligatoria si hay detracción',
            'datosDetraccion.codigo_detraccion.required' => 'El código detracción es obligatorio',
        ];
        return $messages;
    }
}
