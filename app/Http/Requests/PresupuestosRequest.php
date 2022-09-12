<?php

namespace App\Http\Requests;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()


    {


       // dd(Rule::unique('presupuestos', 'numero')->ignore(session('empresa'), 'empresa_id')->where('empresa_id', session('empresa')));
        $presupuesto = $this->route()->parameter('presupuesto');

        $rules = [
            'clientes_id' => 'required',
            'numero' => ['required', Rule::unique('presupuestos', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),],
            'fecha' => 'required',
            'fecha_caducidad' => 'required',
            'divisa' => 'required',
            'items.*.producto' => 'required',
            'items.*.cantidad' => 'required',
            'items.*.precio' => 'required',
            'items.*.importe' => 'required',
        ];

        if ($presupuesto) {


            $rules['numero'] = 'required|unique:presupuestos,numero,' . $presupuesto->id;

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
            'fecha_caducidad.required' => 'Selecciona una fecha de Caducidad',
            'divisa.required' => 'Debe seleccionar una divisa',
            'items.*.producto.required' => 'Ingresa el producto',
            'items.*.cantidad.required' => 'Ingresa la cantidad',
            'items.*.precio.required' => 'Ingresa un precio',
        ];

        return $messages;
    }
}
