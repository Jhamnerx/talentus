<?php

namespace App\Http\Requests;

use App\Models\Actas;
use Illuminate\Foundation\Http\FormRequest;

class ActasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {




        $rules = [
            'numero' => 'required|unique:actas',
            'vehiculos_id' => 'required',
            "inicio_cobertura" => 'required',
            "fin_cobertura" => 'required',
            "ciudades_id" => 'required',
            "fondo" => 'nullable',
            "sello" => 'nullable',
        ];


        return $rules;
    }

    public function messages()
    {

        $messages = [

            'numero.required' => 'El número es obligatorio',
            'numero.unique' => 'Este numero ya esta registrado',
            'vehiculos_id.required' => 'Debe seleccionar un vehiculo',
            'inicio_cobertura.required' => 'La fecha es obligatoria',
            'fin_cobertura.required' => 'La fecha es obligatoria',
            'ciudades_id.required' => 'Debe seleccionar una ciudad',

        ];

        return $messages;
    }
}
