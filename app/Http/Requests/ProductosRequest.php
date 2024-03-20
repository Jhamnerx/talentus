<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
    public function rules($producto = null): array
    {
        $rules = [
            'descripcion' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'codigo' => 'required|unique:productos,codigo',
            'unit_code' => 'required|exists:units,codigo',
            'stock' => 'numeric',
            'valor_unitario' => 'numeric',
            'afecto_icbper' => 'boolean',
            'divisa' => 'required',
            'tipo' => 'required',
            'modelo_id' => [
                'required_if:categoria_id,1', Rule::unique('productos', 'modelo_id')->where(fn ($query) => $query->where('empresa_id', session('empresa')))
            ]
        ];

        if ($producto) {
            $rules = [
                'descripcion' => 'required',
                'categoria_id' => 'required|exists:categorias,id',
                'codigo' => 'required|unique:productos,codigo,' . $producto->id,
                // 'tipo_afectacion_id' => 'required|exists:tipo_afectacion,codigo',
                'unit_code' => 'required|exists:units,codigo',
                'stock' => 'numeric',
                'valor_unitario' => 'numeric',
                'afecto_icbper' => 'boolean',
                'divisa' => 'required',
                'tipo' => 'required',
                'modelo_id' => [
                    'required_if:categoria_id,1', Rule::unique('productos', 'modelo_id')->ignore($producto->id)->where(fn ($query) => $query->where('empresa_id', session('empresa')))
                ]
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'categoria_id.required' => 'El campo categoría es obligatorio',
            'tipo.required' => 'El campo tipo es obligatorio',
            'modelo_id.required_if' => 'El campo modelo es obligatorio si la categoría es "Dispositivos"',
            'modelo_id.unique' => 'Solo un producto debe ser vinculado a un modelo',
        ];
    }
}
