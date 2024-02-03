<?php

namespace App\Http\Requests;

use App\Models\Presupuestos;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PresupuestosRequest extends FormRequest
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

    public function rules($presupuesto = null)
    {
        $rules = [
            'tipo_comprobante_id' => 'required',
            'serie' => 'required|exists:series,serie',
            'correlativo' => 'required',
            'serie_correlativo' => 'required',
            'clientes_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'fecha_caducidad' => 'required|date',
            'divisa' => 'required',
            'tipo_cambio' => 'required_if:divisa,USD',
            'metodo_pago_id' => 'required',
            'comentario' => 'nullable',
            'op_gravadas' => 'required',
            'op_exoneradas' => 'required',
            'op_inafectas' => 'required',
            'op_gratuitas' => 'required',
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

            //SOLES TOTALES
            'sub_total_soles' => 'nullable',
            'op_gravadas_soles' => 'nullable',
            'op_exoneradas_soles' => 'nullable',
            'op_inafectas_soles' => 'nullable',
            'op_gratuitas_soles' => 'nullable',
            'descuento_soles' => 'nullable',
            'igv_soles' => 'nullable',
            'icbper_soles' => 'nullable',
            'total_soles' => 'nullable',


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

            'features' => 'required',

        ];

        if ($presupuesto) {

            $rules['serie_correlativo'] = [
                'required',
                Rule::unique('presupuestos', 'serie_correlativo')->where(fn ($query) => $query->where('empresa_id', session('empresa')))
                    ->ignore($presupuesto->id),

            ];
        }
        return $rules;
    }

    public function messages()
    {

        $messages = [
            'total_cuotas.same' => 'la suma de las cuotas debe ser igual al Monto neto',
            'clientes_id.required' => 'Debes Seleccionar un cliente',
            'items.between' => 'Debes Añadir al menos 1 producto o servicio',
            'divisa.required' => 'Debe seleccionar una divisa',
            'items.*.producto.required' => 'Ingresa el producto',
            'items.*.cantidad.required' => 'Ingresa la cantidad',
            'items.*.precio.required' => 'Ingresa un precio',
            'items.*.total.required' => 'Ingresa un precio',
            'items.array' => 'Ingresa como minimo un producto',
        ];
        return $messages;
    }
}
