<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelosDispositivosRequest extends FormRequest
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
    public function rules($model)
    {
        $rules = [
            'modelo' => 'required|unique:modelos_dispositivos,modelo,' . $model->id . '',
            "marca" => 'nullable',
            "certificado" => 'nullable',
        ];



        return $rules;
    }
    public function messages()
    {
        return [
            'modelo.required' => 'El modelo es requerido',
            'modelo.unique' => 'Este Modelo ya esta registrado',

        ];
    }
}
