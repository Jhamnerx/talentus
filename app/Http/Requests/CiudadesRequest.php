<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CiudadesRequest extends FormRequest
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
    public function rules($ciudad = null)
    {
        
        $rules = [
            'nombre' => 'required|unique:ciudades',
            'prefijo' => 'required|unique:ciudades'
        ];


        if ($ciudad) {

            $rules['nombre'] = 'required|unique:ciudades,nombre,' . $ciudad->id;
            $rules['prefijo'] = 'required|unique:ciudades,prefijo,' . $ciudad->id;
        }
        // if ($this->status == 2) {

        //     $rules = array_merge($rules, [

        //         'categoria_id' => 'required',
        //         'tags' => 'required',
        //         'extract' => 'required',
        //         'body' => 'required'
        //     ]);
        // }

        return $rules;
    }

    public function messages()
    {
        return [
            'nombre.required' => 'No dejes vacio este campo',
            'prefijo.required' => 'Ingresa un prefijo',
            'nombre.unique' => 'Ya existe esta ciudad',
            'prefijo.unique' => 'Ingresa un prefijo distinto',
        ];
    }
}
