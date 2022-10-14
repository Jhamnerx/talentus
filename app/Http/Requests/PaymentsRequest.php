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
     * 
     */


    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        //dd($divisa);

        $rules = [
            'numero' => ['required', Rule::unique('payments', 'numero')->where(fn ($query) => $query->where('empresa_id', session('empresa')))],
            "numero_operacion" => 'required',
            "monto" => 'required|numeric',
            "divisa" => 'same:divisaDoc',
            "payment_method_id" => 'required',
            "paymentable_id" => 'required',
        ];

        return $rules;
    }

    public function messages()
    {

        $messages = [

            'numero.required' => 'El número es obligatorio',
            'monto.required' => 'Ingresa el monto del pago',
            'monto.numeric' => 'Ingresa datos correctos',
            'divisa.same' => 'La divisa del documento y el cobro deben coincidir',
            'numero_operacion.required' => 'Ingresa un dato correcto',
            'payment_method_id.required' => 'Elige un metodo de pago',
            'paymentable_id.required' => 'Elige un documento a pagar',

        ];

        return $messages;
    }
}
