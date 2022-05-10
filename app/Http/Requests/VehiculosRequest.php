<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehiculosRequest extends FormRequest
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

        $vehiculo = $this->route()->parameter('vehiculo');

        $rules = [
            'placa' => 'required|unique:vehiculos',
            "flotas_id"  => "required",
            "numero" => "required|unique:vehiculos",
            "dispositivos_id" => "required|unique:vehiculos",

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
            'placa.required' => 'La placa es requerida',
            'placa.unique' => 'Esta placa ya esta registrada',
            'flotas_id.required' => 'Debe seleccionar una flota',
            'numero.required' => 'El numero es requerido',
            'numero.unique' => 'ya estas registrando este sim',
            'dispositivos_id.required' => 'El imei es requerido',
            'dispositivos_id.unique' => 'Este imei ya esta registrado',

        ];
    }
}
