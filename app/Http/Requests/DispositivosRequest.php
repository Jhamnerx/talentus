<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispositivosRequest extends FormRequest
{

    public function rules($dispositivo = null)
    {

        $rules = [
            'items.*.imei' => 'required|unique:dispositivos|numeric|distinct',
            'items.*.modelo_id' => 'required'
        ];

        if ($dispositivo) {

            $rules['imei'] = 'required|unique:dispositivos,imei,' . $dispositivo->id;
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'items.*.imei.required' => 'El imei es requerido',
            'items.*.imei.unique' => 'El imei ingresaso ya existe',
            'items.*.imei.distinct' => 'ya estas registrando este imei',
            'items.*.imei.numeric' => 'El campo no debe contener letras',
            'items.*.modelo_id.required' => 'El operador es requerido',

        ];

        return $messages;
    }
}
