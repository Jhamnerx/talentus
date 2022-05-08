<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LineasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->empresa_id == session('empresa')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $lineas = $this->route()->parameter('lineas');

        $rules = [
            "sim_card"  => 'nullable|unique:lineas',
            'numero' => 'nullable|unique:lineas',
            'operador' => 'required',
        ];

        if ($lineas) {

            $rules['sim_card'] = 'required|unique:lineas,sim_card,' . $lineas->id;
            $rules['numero'] = 'required|unique:lineas,numero,' . $lineas->id;
        }


        return $rules;
    }
}
