<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaDeCreditoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($tipo_comprobante = null): array
    {


        $rules = [
            //DATOS NOTA
            'tipo_comprobante_id' => 'required|exists:tipo_comprobantes,codigo',
            'tipo_operacion' => 'required',
            'serie' => 'required|exists:series,serie',
            'correlativo' => 'required',
            'serie_correlativo' => 'required',
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_emision' => 'required|date',
            'tipo_comprobante_ref' => 'required',
            'serie_correlativo_ref' => 'required',
            'sustento_id' => 'required',
            'sustento_texto' => 'nullable',
            'divisa' => 'required',
            'tipo_cambio' => 'required_if:divisa,USD',
            'op_gravadas' => 'required',
            'op_exoneradas' => 'required',
            'op_inafectas' => 'required',
            'op_gratuitas' => 'required',
            'descuento' => 'required',
            'icbper' => 'nullable',
            'igv' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
            'numero_cuotas' => 'exclude_unless:invoice_forma_pago,CREDITO|integer|required_if:invoice_forma_pago,CREDITO|min:1',
            'vence_cuotas' => 'exclude_unless:invoice_forma_pago,CREDITO|integer|required_if:invoice_forma_pago,CREDITO|min:1',
            'detalle_cuotas.*' => 'array|between:1,100|required_if:invoice_forma_pago,CREDITO',
            'invoice_forma_pago' => 'required',


            'invoice_id' => 'required|exists:ventas,id',
            'serie_ref' => 'required',
            'correlativo_ref' => 'required',
            'serie_correlativo_ref' => 'required',

            'invoice_id_new' => 'nullable',
            'serie_correlativo_ref' => 'required|exists:ventas,serie_correlativo'
        ];

        if ($tipo_comprobante == '01') {

            $rules['serie'] = 'starts_with:F|required|exists:series,serie';
        } else {

            $rules['serie'] = 'starts_with:B|required|exists:series,serie';
            $rules['sustento_id'] = 'required|doesnt_start_with:04,05,08';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'tipo_comprobante_id.required' => 'El tipo de comprobante es necesario',
            'serie.required' => 'Selecciona una serie',
            'correlativo.required' => 'Selecciona un correlativo',
            'serie.starts_with' => 'Debes seleccionar la serie correcta',
            'sustento_id.required' => 'El tipo de nota es obligatorio',
            'sustento_id.doesnt_start_with' => 'Cuando es boleta no puedes seleccionar estos tipos',
        ];
    }
}
