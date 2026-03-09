<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Vehiculos;
use Gpswox\Wox;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SincronizacionGpswoxNotification;

class SincronizarVehiculosGpswox implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300; // 5 minutos
    public $tries = 1;

    protected $empresaId;

    /**
     * Create a new job instance.
     */
    public function __construct(?int $empresaId = null)
    {
        $this->empresaId = $empresaId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Iniciando sincronización GPSWox', ['empresa_id' => $this->empresaId]);

            // Inicializar GPSWox API
            $wox = new Wox(
                config('services.gpswox.base_uri'),
                config('services.gpswox.api_hash')
            );

            // Obtener todos los dispositivos de GPSWox
            $response = $wox->device()->listDevices();

            if (!isset($response['groups']) || !is_array($response['groups'])) {
                throw new \Exception('Respuesta inválida de GPSWox API');
            }

            // Extraer y filtrar dispositivos activos
            $dispositivosActivos = $this->extraerDispositivosActivos($response['groups']);

            // Obtener vehículos locales
            $query = Vehiculos::query();
            if ($this->empresaId) {
                $query->where('empresa_id', $this->empresaId);
            }
            $vehiculosLocales = $query->get()->keyBy(function ($vehiculo) {
                return strtoupper(trim($vehiculo->placa));
            });

            // Procesar sincronización
            $resumen = $this->sincronizarVehiculos($dispositivosActivos, $vehiculosLocales);

            // Notificar administradores
            $this->notificarAdministradores($resumen);

            Log::info('Sincronización GPSWox completada', $resumen);
        } catch (\Exception $e) {
            Log::error('Error en sincronización GPSWox: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Extraer dispositivos activos de la respuesta GPSWox
     */
    protected function extraerDispositivosActivos(array $groups): array
    {
        $dispositivos = [];

        foreach ($groups as $group) {
            if (isset($group['items']) && is_array($group['items'])) {
                foreach ($group['items'] as $item) {
                    // Solo incluir dispositivos activos
                    if (isset($item['device_data']['active']) && $item['device_data']['active'] == 1) {
                        $placa = strtoupper(trim($item['device_data']['plate_number'] ?? ''));
                        if (!empty($placa)) {
                            $dispositivos[$placa] = $item;
                        }
                    }
                }
            }
        }

        return $dispositivos;
    }

    /**
     * Sincronizar vehículos y generar resumen
     */
    protected function sincronizarVehiculos(array $dispositivosGpswox, $vehiculosLocales): array
    {
        $resumen = [
            'total_gpswox' => count($dispositivosGpswox),
            'total_local' => $vehiculosLocales->count(),
            'actualizados' => [],
            'no_en_local' => [],
            'no_en_gpswox' => [],
            'sin_cambios' => 0,
        ];

        // 1. Actualizar vehículos existentes con diferencias IMEI/SIM
        foreach ($dispositivosGpswox as $placa => $dispositivo) {
            if ($vehiculosLocales->has($placa)) {
                $vehiculo = $vehiculosLocales[$placa];
                $cambios = $this->actualizarVehiculo($vehiculo, $dispositivo);

                if (!empty($cambios)) {
                    $resumen['actualizados'][] = [
                        'placa' => $placa,
                        'cambios' => $cambios,
                    ];
                } else {
                    $resumen['sin_cambios']++;
                }
            } else {
                // Vehículo existe en GPSWox pero no en local
                $resumen['no_en_local'][] = [
                    'placa' => $placa,
                    'imei' => $dispositivo['device_data']['imei'] ?? 'Sin IMEI',
                    'sim' => $dispositivo['device_data']['sim_number'] ?? 'Sin SIM',
                    'modelo' => $dispositivo['device_data']['device_model'] ?? 'N/A',
                ];
            }
        }

        // 2. Identificar vehículos locales que no existen en GPSWox
        foreach ($vehiculosLocales as $placa => $vehiculo) {
            if (!isset($dispositivosGpswox[$placa])) {
                $resumen['no_en_gpswox'][] = [
                    'id' => $vehiculo->id,
                    'placa' => $placa,
                    'imei' => $vehiculo->dispositivosAsignados->first()->imei ?? 'Sin IMEI',
                    'sim' => $vehiculo->dispositivosAsignados->first()->sim ?? 'Sin SIM',
                ];
            }
        }

        return $resumen;
    }

    /**
     * Actualizar IMEI y SIM de un vehículo desde GPSWox
     */
    protected function actualizarVehiculo(Vehiculos $vehiculo, array $dispositivo): array
    {
        $cambios = [];
        $dispositivoLocal = $vehiculo->dispositivosAsignados->first();

        if (!$dispositivoLocal) {
            return $cambios; // No hay dispositivo asignado localmente
        }

        $imeiGpswox = $dispositivo['device_data']['imei'] ?? null;
        $simGpswox = $dispositivo['device_data']['sim_number'] ?? null;

        // Actualizar IMEI si es diferente
        if ($imeiGpswox && $imeiGpswox !== $dispositivoLocal->imei) {
            $cambios['imei'] = [
                'anterior' => $dispositivoLocal->imei,
                'nuevo' => $imeiGpswox,
            ];
            $dispositivoLocal->imei = $imeiGpswox;
        }

        // Actualizar SIM si es diferente
        if ($simGpswox && $simGpswox !== $dispositivoLocal->sim) {
            $cambios['sim'] = [
                'anterior' => $dispositivoLocal->sim,
                'nuevo' => $simGpswox,
            ];
            $dispositivoLocal->sim = $simGpswox;
        }

        // Actualizar gpswox_id si no está establecido
        $gpswoxId = $dispositivo['device_data']['id'] ?? null;
        if ($gpswoxId && $vehiculo->gpswox_id !== $gpswoxId) {
            $cambios['gpswox_id'] = [
                'anterior' => $vehiculo->gpswox_id,
                'nuevo' => $gpswoxId,
            ];
            $vehiculo->gpswox_id = $gpswoxId;
            $vehiculo->save();
        }

        // Guardar cambios en dispositivo
        if (!empty($cambios)) {
            $dispositivoLocal->save();
        }

        return $cambios;
    }

    /**
     * Notificar a administradores sobre el resumen
     */
    protected function notificarAdministradores(array $resumen): void
    {
        // Obtener administradores de la empresa
        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'Admin');
        });

        if ($this->empresaId) {
            $query->where('empresa_id', $this->empresaId);
        }

        $admins = $query->get();

        if ($admins->isEmpty()) {
            Log::warning('No se encontraron administradores para notificar');
            return;
        }

        // Enviar notificación
        Notification::send($admins, new SincronizacionGpswoxNotification($resumen));
    }
}
