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
                    // Obtener la última acta creada para este vehículo
                    $ultima_acta = $vehiculo->actas()
                        ->orderBy('created_at', 'desc')
                        ->first();

                    // Obtener todos los contratos del vehículo
                    $contratos = $vehiculo->contratos()
                        ->orderBy('created_at', 'desc')
                        ->get();

                    // Mantener los datos originales y agregar los datos del cliente y acta
                    foreach ($this->devices as &$group) {
                        foreach ($group['items'] as &$device) {
                            if (isset($device['device_data'])) {
                                // Agregar datos del cliente a los datos existentes
                                $device['device_data']['object_owner'] = $vehiculo->cliente->razon_social;
                                $device['device_data']['owner_tipo_documento'] = $vehiculo->cliente->tipo_documento_id == '6' ? 'RUC' : 'DNI';
                                $device['device_data']['owner_document_number'] = $vehiculo->cliente->tipo_documento_id == '6' ? $vehiculo->cliente->numero_documento : 'N/A';

                                // Agregar datos de la última acta si existe
                                if ($ultima_acta) {
                                    $device['device_data']['ultima_acta'] = [
                                        'numero' => $ultima_acta->numero ?? 'N/A',
                                        'fecha_creacion' => $ultima_acta->created_at->format('d/m/Y H:i:s'),
                                        'estado' => $ultima_acta->estado ?? 'N/A',
                                        'tipo' => $ultima_acta->tipo ?? 'N/A',
                                        'id' => $ultima_acta->id,
                                        'codigo' => $ultima_acta->codigo ?? 'N/A'
                                    ];
                                } else {
                                    $device['device_data']['ultima_acta'] = null;
                                }

                                // Agregar datos de contratos si existen
                                if ($contratos->count() > 0) {
                                    $device['device_data']['contratos'] = $contratos->map(function ($contrato) {
                                        return [
                                            'id' => $contrato->id,
                                            'numero' => $contrato->numero ?? 'N/A',
                                            'unique_hash' => $contrato->unique_hash,
                                            'fecha_inicio' => $contrato->fecha ? $contrato->fecha->format('d/m/Y') : 'N/A',
                                            'fecha_fin' => $contrato->fecha_emision ? $contrato->fecha_emision->format('d/m/Y') : 'N/A',
                                            'estado' => $contrato->estado ? 'activo' : 'inactivo',
                                            'tipo' => $contrato->tipo ?? 'N/A',
                                            'monto' => $contrato->detalle->first()->plan ?? 'N/A'
                                        ];
                                    })->toArray();
                                } else {
                                    $device['device_data']['contratos'] = [];
                                }
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

    public function verActaPDF($actaId)
    {
        try {
            $acta = \App\Models\Actas::findOrFail($actaId);

            // Usar el método getPDFData() que ya retorna el PDF renderizado
            return $acta->getPDFData();
        } catch (\Exception $e) {
            $this->error = 'Error al mostrar el PDF: ' . $e->getMessage();
            return null;
        }
    }

    public function verContratoPDF($contratoId)
    {
        try {
            $contrato = \App\Models\Contratos::findOrFail($contratoId);

            // Si el contrato tiene un método para generar PDF, usarlo
            // Sino, redirigir a una ruta específica de contratos
            return redirect()->route('admin.pdf.contrato', ['contrato' => $contrato->id]);
        } catch (\Exception $e) {
            $this->error = 'Error al mostrar el contrato: ' . $e->getMessage();
            return null;
        }
    }

    public function render()
    {
        return view('livewire.app.consultas.transmision.consulta-placa');
    }
}
