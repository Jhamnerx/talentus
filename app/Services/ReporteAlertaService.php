<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Reportes;
use App\Models\User;
use App\Models\Vehiculos;
use Illuminate\Support\Facades\Log;

class ReporteAlertaService
{
    public function __construct(private readonly TicketWhatsAppService $whatsapp) {}

    /**
     * Crea una alerta automática para un vehículo sin transmisión.
     * Devuelve null si ya existe una alerta abierta o en atención para ese vehículo.
     */
    public function crearAlertaAuto(
        Vehiculos $vehiculo,
        float $horasSinTransmision,
        string $ultimaConexion,
        string $imei = '',
        string $sim = ''
    ): ?Reportes {
        // No crear si ya existe un reporte abierto/en atención (cualquier edad),
        // o uno cerrado de las últimas 24 horas (mismo incidente).
        $yaExiste = Reportes::withoutGlobalScope(\App\Scopes\EmpresaScope::class)
            ->where('vehiculos_id', $vehiculo->id)
            ->where(function ($q) {
                $q->whereIn('estado', [Reportes::ESTADO_ABIERTA, Reportes::ESTADO_EN_ATENCION])
                    ->orWhere(function ($q2) {
                        $q2->where('estado', Reportes::ESTADO_CERRADA)
                            ->where('created_at', '>=', now()->subHours(24));
                    });
            })
            ->exists();

        if ($yaExiste) {
            return null;
        }

        $cliente  = $vehiculo->cliente?->razon_social ?? 'Sin cliente';
        $diasText = $horasSinTransmision >= 24
            ? number_format($horasSinTransmision / 24, 1) . ' días'
            : number_format($horasSinTransmision, 1) . ' horas';

        $detalle = "⚠️ Alerta automática: sin transmisión\n"
            . "Placa: {$vehiculo->placa} | Cliente: {$cliente}\n"
            . "Sin señal: {$diasText} | Última conexión: {$ultimaConexion}"
            . ($imei ? "\nIMEI: {$imei}" : '')
            . ($sim  ? " | SIM: {$sim}"  : '');

        $reporte = Reportes::withoutGlobalScope(\App\Scopes\EmpresaScope::class)->create([
            'vehiculos_id'           => $vehiculo->id,
            'empresa_id'             => $vehiculo->empresa_id,
            'user_id'                => null,
            'fecha_t'                => now()->toDateString(),
            'hora_t'                 => now()->toTimeString(),
            'fecha'                  => now()->toDateString(),
            'detalle'                => $detalle,
            'estado'                 => Reportes::ESTADO_ABIERTA,
            'origen'                 => Reportes::ORIGEN_AUTO,
            'horas_sin_transmision'  => $horasSinTransmision,
            'eliminado'              => 0,
        ]);

        return $reporte;
    }

    /**
     * Envía WhatsApp a todos los usuarios con rol 'monitoreo' de una empresa.
     */
    public function notificarMonitoreo(Reportes $reporte): void
    {
        $reporte->load('vehiculos.cliente');

        $vehiculo = $reporte->vehiculos;
        $placa    = $vehiculo?->placa ?? 'N/D';
        $cliente  = $vehiculo?->cliente?->razon_social ?? 'Sin cliente';

        $diasText = $reporte->horas_sin_transmision
            ? ($reporte->horas_sin_transmision >= 24
                ? number_format($reporte->horas_sin_transmision / 24, 1) . ' días'
                : number_format($reporte->horas_sin_transmision, 1) . ' horas')
            : '';

        $url = route('admin.vehiculos.reportes.index');

        $message = "🚨 *Alerta de Monitoreo*\n\n"
            . "Vehículo: *{$placa}*\n"
            . "Cliente: {$cliente}\n"
            . ($diasText ? "Sin señal: *{$diasText}*\n" : '')
            . "Fecha: " . now()->format('d/m/Y H:i') . "\n\n"
            . "🔗 {$url}";

        $usuarios = User::role('monitoreo')
            ->where('empresa_id', $reporte->empresa_id)
            ->whereNotNull('telefonos')
            ->where('telefonos', '!=', '')
            ->get();

        foreach ($usuarios as $usuario) {
            try {
                $this->whatsapp->sendMessage($usuario->telefonos, $message);
            } catch (\Throwable $th) {
                Log::warning("ReporteAlertaService: no se pudo notificar a {$usuario->name}", [
                    'error' => $th->getMessage(),
                ]);
            }
        }
    }
}
