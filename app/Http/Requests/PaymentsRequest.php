<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'numero' => ['required', Rule::unique('payments', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa')))],
            "numero_operacion" => 'required',
            "payment_method_id" => 'required',
            "paymentable_id" => 'required',
        ];

        return $rules;
    }

    public function messages()
    {

        $messages = [

            'numero.required' => 'El número es obligatorio',
            'numero_operacion.required' => 'Selecciona un vehiculo',
            'payment_method_id.required' => 'Elige un metodo de pago',
            'paymentable_id.required' => 'Elige un documento a pagar',

        ];

        return $messages;
    }
}
