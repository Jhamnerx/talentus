<?php

namespace App\Http\Requests;

use App\Models\Productos;
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
                'required_if:es_dispositivo,true',
                Rule::unique('productos', 'modelo_id')->where(
                    fn($query) =>
                    $query->where('empresa_id', session('empresa'))
                        ->whereNotNull('modelo_id')
                )
            ],
            'es_servicio_cobro' => [
                'boolean',
                function ($attribute, $value, $fail) {
                    if ($value == true || $value == '1') {
                        $exists = Productos::where('empresa_id', session('empresa'))
                            ->where('es_servicio_cobro', true)
                            ->exists();

                        if ($exists) {
                            $fail('Ya existe un servicio marcado como servicio de cobro. Solo puede haber uno.');
                        }
                    }
                }
            ],
            'es_dispositivo' => 'boolean',
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
                    'required_if:es_dispositivo,true',
                    Rule::unique('productos', 'modelo_id')->ignore($producto->id)->where(fn($query) => $query->where('empresa_id', session('empresa'))
                        ->whereNotNull('modelo_id'))
                ],
                'es_servicio_cobro' => [
                    'boolean',
                    function ($attribute, $value, $fail) use ($producto) {
                        if ($value == true || $value == '1') {
                            $exists = Productos::where('empresa_id', session('empresa'))
                                ->where('es_servicio_cobro', true)
                                ->where('id', '!=', $producto->id)
                                ->exists();

                            if ($exists) {
                                $fail('Ya existe un servicio marcado como servicio de cobro. Solo puede haber uno.');
                            }
                        }
                    }
                ],
                'es_dispositivo' => 'boolean',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'categoria_id.required' => 'El campo categoría es obligatorio',
            'tipo.required' => 'El campo tipo es obligatorio',
            'modelo_id.required_if' => 'El campo modelo es obligatorio si es un dispositivo',
            'modelo_id.unique' => 'Solo un producto debe ser vinculado a un modelo',
        ];
    }
}
