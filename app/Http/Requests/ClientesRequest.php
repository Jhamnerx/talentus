<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientesRequest extends FormRequest
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


        $rules = [
            'razon_social' => 'required',
            'numero_documento' => 'required|digits_between:8,11|numeric|unique:clientes',
            'telefono' => 'nullable|digits_between:6,9|numeric',
            'email' => 'email|nullable'
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
            'razon_social.required' => 'No dejes vacio este campo',
            'numero_documento.required' => 'Ingresa un documento',
            'numero_documento.digits_between' => 'Ingresa como minimo 8 caracteres',
            'numero_documento.numeric' => 'El numero documento debe ser un numero',
            'numero_documento.unique' => 'El cliente ya esta registrado',
            'telefono.digits_between' => 'Ingresa como maximo 9 caracteres numericos',
            'telefono.numeric' => 'El numero de telefono debe ser un numero',
            'email.email' => 'Debe tener formato de correo electronico',
        ];
    }
}
