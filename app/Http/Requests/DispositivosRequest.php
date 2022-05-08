<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispositivosRequest extends FormRequest
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
        $dispositivo = $this->route()->parameter('dispositivo');

        $rules = [
            'imei' => 'required|unique:dispositivos'
        ];


        if ($dispositivo) {

            $rules['imei'] = 'required|unique:dispositivos,imei,' . $dispositivo->id;
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
