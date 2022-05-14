<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportesRequest extends FormRequest
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
            'vehiculos_id' => 'required',
            "fecha_t" => 'required|date',
            "hora_t" => 'required',
            "detalle" => 'nullable',
            // "dispositivos_id" => "required|unique:vehiculos",
        ];


        return $rules;
    }

    public function messages()
    {


        $messages = [
            'vehiculos_id.required' => 'La placa es requerida',
            'fecha_t.required' => 'La fecha es requerida',
            'fecha_t.date' => 'No tiene un formato de fecha',
            'hora_t.required' => 'La hora es requerida',



        ];

        return $messages;
    }
}
