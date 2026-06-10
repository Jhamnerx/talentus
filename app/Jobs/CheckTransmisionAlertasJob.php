<?php

namespace App\Jobs;

use App\Models\Reportes;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use App\Services\GpsWoxService;
use App\Services\ReporteAlertaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

/**
 * Se ejecuta cada 15 minutos.
 * Consulta GPSWox para detectar vehículos con ≥2 horas sin transmisión
 * y crea alertas automáticas + notifica a usuarios con rol 'monitoreo' via WhatsApp.
 */
class CheckTransmisionAlertasJob implements ShouldQueue
{
    use Queueable;

    private const HORAS_UMBRAL = 2.0;

    public function __construct() {}

    public function handle(GpsWoxService $gpsWox, ReporteAlertaService $alertaService): void
    {
        try {
            $response = $gpsWox->getDevicesTransmissionStatus(false);
        } catch (\Throwable $th) {
            Log::error('[CheckTransmisionAlertas] Error al consultar GPSWox', ['error' => $th->getMessage()]);
            return;
        }

        if (($response['status'] ?? 0) !== 1) {
            Log::warning('[CheckTransmisionAlertas] GPSWox no disponible', ['response' => $response]);
            return;
        }

        $categories = $response['categories'] ?? [];

        // Recopilar todos los dispositivos fuera de 'ok' y 'never_connected'
        $dispositivosCriticos = collect($categories)
            ->whereIn('key', ['warning', 'critical', 'emergency'])
            ->flatMap(fn($cat) => $cat['items'] ?? []);

        if ($dispositivosCriticos->isEmpty()) {
            Log::info('[CheckTransmisionAlertas] Todos los dispositivos transmiten correctamente.');
            return;
        }

        $creadas   = 0;
        $omitidas  = 0;

        foreach ($dispositivosCriticos as $device) {
            $horasOffline = (float) ($device['hours_offline'] ?? 0);

            if ($horasOffline < self::HORAS_UMBRAL) {
                continue;
            }

            $placa = strtoupper(trim($device['plate_number'] ?? ''));
            if (blank($placa)) {
                continue;
            }

            $vehiculo = Vehiculos::withoutGlobalScope(EmpresaScope::class)
                ->where('placa', $placa)
                ->where('estado', 1)
                ->first();

            if (!$vehiculo) {
                continue;
            }

            $reporte = $alertaService->crearAlertaAuto(
                vehiculo:              $vehiculo,
                horasSinTransmision:   $horasOffline,
                ultimaConexion:        $device['last_connection'] ?? '—',
                imei:                  $device['imei'] ?? '',
                sim:                   $device['sim_number'] ?? '',
            );

            if ($reporte === null) {
                $omitidas++;
                continue;
            }

            $alertaService->notificarMonitoreo($reporte);
            $creadas++;
        }

        Log::info('[CheckTransmisionAlertas] Ciclo completado', [
            'dispositivos_criticos' => $dispositivosCriticos->count(),
            'alertas_creadas'       => $creadas,
            'omitidas_ya_existen'   => $omitidas,
        ]);
    }
}
