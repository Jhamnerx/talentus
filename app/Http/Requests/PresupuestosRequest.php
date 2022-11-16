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
            'clientes_id' => 'required',
            'numero' => [
                'required', Rule::unique('presupuestos', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),
            ],
            'fecha' => 'required|date',
            'fecha_caducidad' => 'required|date',
            'divisa' => 'required',
            'sub_total' => 'required',
            'impuesto' => 'required',
            'total' => 'required',
            'sub_total_soles' => 'required',
            'impuesto_soles' => 'required',
            'total_soles' => 'required',
            'nota' => 'nullable',
            'items' => 'array|between:1,100',
            'items.*.producto' => 'required',
            'items.*.descripcion' => 'nullable',
            'items.*.cantidad' => 'required|digits_between:1,100',
            'items.*.precio' => 'required',
            'items.*.total' => 'required',
        ];

        if ($presupuesto) {

            $rules['numero'] = [
                'required',
                Rule::unique('presupuestos', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa')))
                    ->ignore($presupuesto->id),

            ];
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'clientes_id.required' => 'Debes Seleccionar un Cliente',
            'numero.required' => 'Debes Ingresar un numero',
            'numero.unique' => 'Este número ya esta registrado',
            'fecha.required' => 'Selecciona una fecha',
            'fecha.date' => 'El campo debe ser una fecha',
            'fecha_caducidad.required' => 'Selecciona una fecha de Caducidad',
            'fecha_caducidad.date' => 'El campo debe ser una fecha',
            'divisa.required' => 'Debe seleccionar una divisa',
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
