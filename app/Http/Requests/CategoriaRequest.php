<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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

        $categoria = $this->route()->parameter('categoria');

        $rules = [
            'nombre' => 'required|unique:categorias'
        ];


        if ($categoria) {

            $rules['nombre'] = 'required|unique:categorias,nombre,' . $categoria->id;
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
}
