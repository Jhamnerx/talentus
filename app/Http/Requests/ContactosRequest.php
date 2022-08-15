<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactosRequest extends FormRequest
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

        $contacto = $this->route()->parameter('contacto');

        $rules = [
            'nombre' => 'required',
            'clientes_id' => 'required',
            'telefono' => 'nullable|digits_between:6,9|numeric',

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
            'nombre.required' => 'No dejes vacio este campo',
            'clientes_id.required' => 'Ingresa un cliente',
            'telefono.digits_between' => 'Ingresa como maximo 9 caracteres numericos',
            'telefono.numeric' => 'El numero de telefono debe ser un numero',

        ];
    }
}
