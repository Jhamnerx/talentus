<?php

namespace App\Livewire\App\Consultas\Transmision;

use Livewire\Component;
use App\Http\Controllers\GpsWox\Api\GpsWoxApiController;
use App\Models\Vehiculos;
use Illuminate\Http\Request;

class ConsultaPlaca extends Component
{
    public $plate_number = '';
    public $devices = [];
    public $loading = false;
    public $error = '';

    public function consultarDispositivo()
    {
        $this->loading = true;
        $this->error = '';
        $this->devices = [];

        // Validar que se haya ingresado una placa
        if (empty($this->plate_number)) {
            $this->error = 'Por favor ingrese un número de placa';
            $this->loading = false;
            return;
        }

        try {
            // Crear una instancia del controlador de la API
            $apiController = new GpsWoxApiController();

            // Crear una request simulada con los parámetros necesarios
            $request = new Request([
                'plate_number' => $this->plate_number,
                'limit' => 1
            ]);

            // Llamar al método getDevices del controlador
            $response = $apiController->getDevices($request);

            // Procesar la respuesta
            if (is_array($response) && !empty($response)) {

                $this->devices = $response;
                $vehiculo = Vehiculos::where('placa', $this->plate_number)->first();

                if ($vehiculo) {
                    // Mantener los datos originales y agregar los datos del cliente
                    foreach ($this->devices as &$group) {
                        foreach ($group['items'] as &$device) {
                            if (isset($device['device_data'])) {
                                // Agregar datos del cliente a los datos existentes
                                $device['device_data']['object_owner'] = $vehiculo->cliente->razon_social;
                                $device['device_data']['owner_tipo_documento'] = $vehiculo->cliente->tipo_documento_id == '6' ? 'RUC' : 'DNI';
                                $device['device_data']['owner_document_number'] = $vehiculo->cliente->tipo_documento_id == '6' ? $vehiculo->cliente->numero_documento : 'N/A';
                            }
                        }
                    }
                }
            } else {
                $this->error = 'No se encontraron dispositivos con esa placa';
            }
        } catch (\Exception $e) {
            $this->error = 'Error al consultar: ' . $e->getMessage();
        }

        $this->loading = false;
    }

    public function limpiar()
    {
        $this->plate_number = '';
        $this->devices = [];
        $this->error = '';
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.app.consultas.transmision.consulta-placa');
    }
}
