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
        $this->vehiculo2 = Vehiculos::where('numero', $numero)->withTrashed()->first();

        $ignoreId = $vehicle ? ',' . $vehicle->id : '';

        return [
            'placa'           => 'required|unique:vehiculos,placa' . $ignoreId,
            'marca'           => 'required',
            'modelo'          => 'required',
            'tipo'            => 'required',
            'year'            => 'required',
            'color'           => 'required',
            'motor'           => 'required',
            'serie'           => 'required',
            'clientes_id'     => 'required',
            'sim_card_id'     => 'required',
            'numero'          => 'required|unique:vehiculos,numero' . $ignoreId,
            // Compatibilidad: el dispositivo principal se maneja desde vehiculos_dispositivos
            'dispositivos_id' => 'nullable',
            'modelo_gps'      => 'nullable',
            'operador'        => 'nullable',
            'sim_card'        => 'nullable',
            'dispositivo_imei' => 'nullable',
            'descripcion'     => 'nullable',
        ];
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

        ];

        return $messages;
    }
}
