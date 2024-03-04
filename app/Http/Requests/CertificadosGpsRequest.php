<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificadosGpsRequest extends FormRequest
{

    public function authorize()
    {
        return false;
    }

    public function rules($certificado = null)
    {
        if ($certificado) {

            $rules = [
                'numero' => 'required|unique:certificados,numero,' . $certificado->id,
                'vehiculos_id' => 'required',
                "fecha_instalacion" => 'required',
                "fin_cobertura" => 'required',
                "ciudades_id" => 'required',
                "accesorios" => 'nullable',
                "fondo" => 'nullable',
                "sello" => 'nullable',
            ];
        } else {

            $rules = [
                'numero' => 'required|unique:certificados',
                'vehiculos_id' => 'required',
                "fin_cobertura" => 'required',
                "fecha_instalacion" => 'required',
                "ciudades_id" => 'required',
                "fondo" => 'nullable',
                "sello" => 'nullable',
                "accesorios" => 'nullable',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'numero.required' => 'El número es obligatorio',
            'numero.unique' => 'Este numero ya esta registrado',
            'vehiculos_id.required' => 'Debe seleccionar un vehiculo',
            'fecha_instalacion.required' => 'La fecha de instalación es obligatoria',
            'fin_cobertura.required' => 'La fecha es obligatoria',
            'ciudades_id.required' => 'Debe seleccionar una ciudad',
        ];

        return $messages;
    }
}
