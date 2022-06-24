<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductosRequest extends FormRequest
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

        $rules = [
            'nombre' => 'required',
            'categoria_id' => 'required',
            'precio' => 'required',
            'file' => 'image'
        ];

        if ($this->tipo == 'Producto') {
            $rules = array_merge($rules, [

                'stock' => 'required',
            ]);
        }

        return $rules;
    }
}
