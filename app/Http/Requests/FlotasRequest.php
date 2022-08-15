<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlotasRequest extends FormRequest
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

        $flota = $this->route()->parameter('flota');

        $rules = [
            'nombre' => 'required|unique:flotas,nombre,' . $flota->id,
            'clientes_id' => 'required|exists:clientes,id',
        ];



        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [

            'nombre.required' => 'El nombre es requerido',
            'nombre.unique' => 'Esta flota ya existe',
            'clientes_id.required' => 'El cliente es requerido',
            'clientes_id.exists' => 'El cliente debe estar registrado',

        ];
    }
}
