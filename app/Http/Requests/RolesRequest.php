<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules($rol = null)
    {
        
        $rules = [
            'name' => 'required|unique:roles',
            'permission' => 'required',
        ];


        if ($rol) {

            $rules['name'] = 'required|unique:roles,name,' . $rol->id;
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
            'name.required' => 'Escribe el nombre de rol.',
            'name.unique' => 'El rol ya existe.',
            'permission.required' => 'Selecciona al menos 1 permiso.',
        ];
    }
}
