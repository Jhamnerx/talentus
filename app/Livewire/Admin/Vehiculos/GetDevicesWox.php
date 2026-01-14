<?php

namespace App\Livewire\Admin\Vehiculos;

use Gpswox\Wox;
use App\Models\Vehiculos;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class GetDevicesWox extends Component
{
    use WireUiActions;

    public $openModal = false;
    public $showComparison = false;
    public $mismatches = [];

    public function render()
    {
        return view('livewire.admin.vehiculos.get-devices-wox');
    }

    #[On('get-devices-wox')]
    public function openModal()
    {
        $this->openModal = true;
    }

    /**
     * Sincroniza y compara los dispositivos de GPSWox con la base de datos local
     * Consulta vehículo por vehículo desde local hacia GPSWox (evita timeouts)
     * Sincronización unidireccional: GPSWox → Local (actualiza campos locales con datos de GPSWox)
     * Útil cuando se actualizan datos en la plataforma GPSWox que no se reflejan en local
     */
    public function sincronizar()
    {
        $this->mismatches = [];

        // Obtener vehículos locales primero
        $vehiculosLocales = Vehiculos::with(['dispositivosAsignados', 'sim_card'])
            ->whereNotNull('placa')
            ->get();

        if ($vehiculosLocales->isEmpty()) {
            $this->notification()->info('Sin vehículos', 'No hay vehículos con placa en la base de datos local');
            return;
        }

        $wox = new Wox(
            config('services.gpswox.base_uri'),
            config('services.gpswox.api_hash')
        );

        $totalProcesados = 0;
        $totalEncontrados = 0;

        // Consultar GPSWox por cada vehículo local (uno por uno)
        foreach ($vehiculosLocales as $vehiculoLocal) {
            $totalProcesados++;
            $placa = strtoupper(trim($vehiculoLocal->placa));

            try {
                // Buscar este vehículo específico en GPSWox por placa
                $response = $wox->device()->listDevices([
                    's' => $placa, // Búsqueda por placa
                    'limit' => 10
                ]);

                $deviceGpswox = null;

                // Buscar en los resultados
                foreach ($response as $group) {
                    if (isset($group['items']) && is_array($group['items'])) {
                        foreach ($group['items'] as $item) {
                            // Solo dispositivos activos
                            if (isset($item['device_data']['active']) && $item['device_data']['active'] == 1) {
                                $placaApi = strtoupper(trim($item['device_data']['plate_number'] ?? ''));
                                if ($placaApi === $placa) {
                                    $deviceGpswox = $item;
                                    $totalEncontrados++;
                                    break 2;
                                }
                            }
                        }
                    }
                }

                // Si no se encuentra en GPSWox, continuar con el siguiente
                if (!$deviceGpswox) {
                    continue;
                }

                // Comparar datos
                $gpswoxId = $deviceGpswox['device_data']['id'] ?? null;
                $imeiGpswox = $deviceGpswox['device_data']['imei'] ?? null;
                $simGpswox = $deviceGpswox['device_data']['sim_number'] ?? null;
                $dispositivo = $vehiculoLocal->dispositivosAsignados->first();

                // Validar si gpswox_id cambió de placa (reasignación)
                if ($gpswoxId && $vehiculoLocal->gpswox_id != $gpswoxId) {
                    $vehiculoAntiguo = Vehiculos::where('gpswox_id', $gpswoxId)
                        ->where('id', '!=', $vehiculoLocal->id)
                        ->first();

                    if ($vehiculoAntiguo) {
                        $this->mismatches[] = [
                            'tipo' => 'REASIGNACION_GPSWOX_ID',
                            'placa' => $placa,
                            'mensaje' => "GPSWox ID {$gpswoxId} estaba asignado a {$vehiculoAntiguo->placa}, ahora está en {$placa}",
                            'placa_antigua' => $vehiculoAntiguo->placa,
                            'placa_nueva' => $placa,
                            'gpswox_id' => $gpswoxId,
                            'vehiculo_antiguo_id' => $vehiculoAntiguo->id,
                            'vehiculo_nuevo_id' => $vehiculoLocal->id,
                        ];
                    }
                }

                // Comparar IMEI
                if ($dispositivo && $imeiGpswox && $dispositivo->imei !== $imeiGpswox) {
                    $this->mismatches[] = [
                        'tipo' => 'IMEI_DIFERENTE',
                        'placa' => $placa,
                        'mensaje' => 'IMEI diferente entre local y GPSWox',
                        'local_imei' => $dispositivo->imei ?: 'Sin IMEI',
                        'api_imei' => $imeiGpswox,
                        'vehiculo_id' => $vehiculoLocal->id,
                        'dispositivo_id' => $dispositivo->id,
                    ];
                }

                // Comparar SIM
                if ($simGpswox && $vehiculoLocal->numero !== $simGpswox) {
                    $this->mismatches[] = [
                        'tipo' => 'SIM_DIFERENTE',
                        'placa' => $placa,
                        'mensaje' => 'SIM diferente entre local y GPSWox',
                        'local_sim' => $vehiculoLocal->numero ?: 'Sin SIM',
                        'api_sim' => $simGpswox,
                        'vehiculo_id' => $vehiculoLocal->id,
                    ];
                }
            } catch (\Exception $e) {
                // Si falla una consulta individual, continuar con el siguiente
                \Log::warning("Error consultando GPSWox para placa {$placa}: " . $e->getMessage());
                continue;
            }
        }

        $this->showComparison = true;

        // Notificar resultado
        $totalInconsistencias = count($this->mismatches);

        if ($totalInconsistencias > 0) {
            $this->notification()->warning(
                "Se encontraron {$totalInconsistencias} diferencias",
                "De {$totalProcesados} vehículos locales, {$totalEncontrados} están en GPSWox"
            );
        } else {
            $this->notification()->success(
                '✓ Sincronización perfecta',
                "Los {$totalEncontrados} vehículos encontrados en GPSWox coinciden con tu base de datos local"
            );
        }
    }

    /**
     * Actualizar IMEI, SIM y gpswox_id de un vehículo específico desde GPSWox
     * Sincronización unidireccional: GPSWox → Local
     * Maneja reasignación de gpswox_id cuando la placa cambió en GPSWox
     */
    public function actualizarDesdeGpswox($placa)
    {
        try {
            $vehiculo = Vehiculos::with(['dispositivosAsignados', 'sim_card'])
                ->where('placa', $placa)
                ->first();

            if (!$vehiculo) {
                $this->notification()->error('Vehículo no encontrado', $placa);
                return;
            }

            // Buscar dispositivo en GPSWox usando búsqueda por placa (más rápido)
            $wox = new Wox(
                config('services.gpswox.base_uri'),
                config('services.gpswox.api_hash')
            );

            // Búsqueda optimizada: solo buscar esta placa específica
            $response = $wox->device()->listDevices([
                'plate_number' => $placa, // Parámetro de búsqueda
                'limit' => 10
            ]);

            $deviceGpswox = null;

            // Buscar en los resultados filtrados
            foreach ($response as $group) {
                if (isset($group['items'])) {
                    foreach ($group['items'] as $item) {
                        if (isset($item['device_data']['active']) && $item['device_data']['active'] == 1) {
                            $placaApi = strtoupper(trim($item['device_data']['plate_number'] ?? ''));
                            if ($placaApi === strtoupper($placa)) {
                                $deviceGpswox = $item;
                                break 2;
                            }
                        }
                    }
                }
            }

            if (!$deviceGpswox) {
                $this->notification()->error('No encontrado en GPSWox', $placa);
                return;
            }

            $cambios = [];
            $gpswoxId = $deviceGpswox['device_data']['id'] ?? null;
            $imeiGpswox = $deviceGpswox['device_data']['imei'] ?? null;
            $simGpswox = $deviceGpswox['device_data']['sim_number'] ?? null;

            // VALIDAR REASIGNACIÓN DE GPSWOX_ID
            if ($gpswoxId) {
                $vehiculoAntiguo = Vehiculos::where('gpswox_id', $gpswoxId)
                    ->where('id', '!=', $vehiculo->id)
                    ->first();

                if ($vehiculoAntiguo) {
                    // Quitar gpswox_id del vehículo antiguo
                    $vehiculoAntiguo->gpswox_id = null;
                    $vehiculoAntiguo->save();
                    $cambios[] = "GPSWox ID removido de {$vehiculoAntiguo->placa}";
                }

                // Asignar gpswox_id al nuevo vehículo
                if ($vehiculo->gpswox_id != $gpswoxId) {
                    $vehiculo->gpswox_id = $gpswoxId;
                    $vehiculo->save();
                    $cambios[] = 'GPSWox ID asignado';
                }
            }

            // ACTUALIZAR IMEI del dispositivo
            $dispositivo = $vehiculo->dispositivosAsignados->first();
            if ($dispositivo && $imeiGpswox) {
                if ($imeiGpswox !== $dispositivo->imei) {
                    $dispositivo->imei = $imeiGpswox;
                    $dispositivo->save();
                    $cambios[] = 'IMEI actualizado';
                }
            }

            // ACTUALIZAR SIM (en vehiculos.numero)
            if ($simGpswox && $simGpswox !== $vehiculo->numero) {
                $vehiculo->numero = $simGpswox;
                $vehiculo->save();
                $cambios[] = 'SIM actualizado';
            }

            if (!empty($cambios)) {
                $this->notification()->success(
                    '✓ Sincronizado desde GPSWox',
                    implode(' • ', $cambios)
                );
                $this->sincronizar();
            } else {
                $this->notification()->info('Sin cambios', 'Los datos ya están sincronizados');
            }
        } catch (\Exception $e) {
            $this->notification()->error('Error al sincronizar', $e->getMessage());
        }
    }
}
