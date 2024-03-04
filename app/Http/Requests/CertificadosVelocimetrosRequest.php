<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificadosVelocimetrosRequest extends FormRequest
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
    public function rules($certificado = null)
    {
        if ($certificado) {
            $rules = [
                'numero' => 'required|unique:certificados_velocimetros,numero,' . $certificado->id,
                'vehiculos_id' => 'required',
                'velocimetro_modelo' => 'required',
                "ciudades_id" => 'required',
                "observacion" => 'nullable',
                "fondo" => 'nullable',
                "sello" => 'nullable',
            ];
        } else {
            $rules = [
                'numero' => 'required|unique:certificados_velocimetros',
                'vehiculos_id' => 'required',
                'velocimetro_modelo' => 'required',
                "ciudades_id" => 'required',
                "observacion" => 'nullable',
                "fondo" => 'nullable',
                "sello" => 'nullable',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'numero.required' => 'El número es obligatorio',
            'numero.unique' => 'Este numero ya esta registrado',
            'velocimetro_modelo.required' => 'Selecciona un modelo de velocimetro',
            'vehiculos_id.required' => 'Debe seleccionar un vehiculo',
            'ciudades_id.required' => 'Debe seleccionar una ciudad',

        ];

        return $messages;
    }
}
