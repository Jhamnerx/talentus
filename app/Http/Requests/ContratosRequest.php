<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratosRequest extends FormRequest
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
        $contrato = $this->route()->parameter('contrato');

        $rules = [
            'clientes_id' => 'required',
            'fecha' => 'required',
            'ciudades_id' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {

        $messages = [

            'clientes_id.required' => 'Debes Seleccionar un Cliente',
            'fecha.required' => 'Selecciona una fecha',
            'ciudades_id.required' => 'Debe seleccionar una ciudad',
        ];

        return $messages;
    }
}
