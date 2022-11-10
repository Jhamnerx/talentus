<?php

namespace App\Http\Requests;

use App\Models\Vehiculos;
use Illuminate\Foundation\Http\FormRequest;

class VehiculosRequest extends FormRequest
{

    public $vehiculo;
    public $vehiculo2;
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($dispositivo_id, $numero, $vehicle = null)
    {

        $this->vehiculo = Vehiculos::where('dispositivos_id', $dispositivo_id)->first();
        $this->vehiculo2 = Vehiculos::where('numero', $numero)->first();

        $rules = [
            'placa' => 'required|unique:vehiculos',
            "marca" => 'nullable',
            "modelo" => 'nullable',
            "tipo" => 'nullable',
            "year" => 'nullable',
            "color" => 'nullable',
            "motor" => 'nullable',
            "serie" => 'nullable',
            "sim_card_id" => 'nullable|required',
            "numero" =>
            'required|unique:vehiculos,numero',
            "clientes_id"  => "required",
            "dispositivos_id" =>
            'nullable|unique:vehiculos',
            "modelo_gps" => 'nullable',
            "operador" => 'nullable',
            "sim_card" => 'nullable',
            "dispositivo_imei" => 'nullable',
            "descripcion" => 'nullable',

            // "dispositivos_id" => "required|unique:vehiculos",

        ];

        if ($vehicle) {

            $rules['placa'] = 'required|unique:vehiculos,placa,' . $vehicle->id;
            $rules['numero'] = 'required|unique:vehiculos,numero,' . $vehicle->id;
            $rules['dispositivos_id'] = 'required|unique:vehiculos,dispositivos_id,' . $vehicle->id;
        }
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        // if ($this->vehiculo->count() >= 1) {
        // }
        $placa = isset($this->vehiculo['placa']) ? $this->vehiculo['placa'] : '';
        $numero = isset($this->vehiculo2['placa']) ? $this->vehiculo2['placa'] : '';

        $messages = [

            'placa.required' => 'La placa es requerida',
            'placa.unique' => 'Esta placa ya esta registrada',
            'clientes_id.required' => 'Debe seleccionar un cliente',
            'sim_card_id.required' => 'Debe seleccionas un numero asignado',
            'numero.required' => 'El numero es requerido',
            'numero.unique' => 'ya estas registrando este sim en la placa ' . $numero . '',
            'dispositivos_id.required' => 'El imei es requerido',
            'dispositivos_id.unique' => 'Este imei ya esta registrado en la placa ' . $placa . '',

        ];

        return $messages;
    }
}
