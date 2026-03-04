<?php

namespace App\Jobs;

use App\Models\DetalleCobros;
use App\Models\NotificacionCobro;
use App\Models\Vehiculos;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Job que genera notificaciones de cobro diariamente
 * 
 * Se ejecuta automáticamente para detectar DetalleCobros que están
 * próximos a su fecha de facturación y crea NotificacionCobro para
 * cada uno de ellos.
 * 
 * Configurar en app/Console/Kernel.php:
 * $schedule->job(new GenerarNotificacionesCobro)->daily();
 */
class GenerarNotificacionesCobro implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Días de anticipación para generar notificación
     * Por defecto 7 días antes del vencimiento
     */
    protected int $diasAnticipacion;

    /**
     * Create a new job instance.
     */
    public function __construct(int $diasAnticipacion = 7)
    {
        $this->diasAnticipacion = $diasAnticipacion;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fechaLimite = Carbon::now()->addDays($this->diasAnticipacion);

        Log::info('Iniciando generación de notificaciones de cobro', [
            'fecha_limite' => $fechaLimite->format('Y-m-d'),
            'dias_anticipacion' => $this->diasAnticipacion
        ]);

        // Buscar DetalleCobros activos cuya suscripción del vehículo vence dentro del período
        $detallesProximos = DetalleCobros::with([
            'cobro',
            'cobro.clientes',
            'vehiculo.planSubscriptions',
        ])
            ->where('estado', 1)
            ->whereHas('vehiculo.planSubscriptions', function ($q) use ($fechaLimite) {
                $q->whereNull('canceled_at')
                    ->whereBetween('ends_at', [
                        Carbon::now()->startOfDay(),
                        $fechaLimite->endOfDay(),
                    ]);
            })
            // No generar si ya existe una notificación pendiente o facturada
            ->whereDoesntHave('notificaciones', function ($query) {
                $query->whereIn('estado', ['PENDIENTE', 'FACTURADO']);
            })
            ->get();

        $notificacionesCreadas = 0;
        $errores = 0;

        foreach ($detallesProximos as $detalle) {
            try {
                $this->crearNotificacion($detalle);
                $notificacionesCreadas++;
            } catch (\Exception $e) {
                $errores++;
                Log::error('Error al crear notificación de cobro', [
                    'detalle_cobro_id' => $detalle->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info('Generación de notificaciones completada', [
            'notificaciones_creadas' => $notificacionesCreadas,
            'errores' => $errores,
            'total_procesados' => $detallesProximos->count()
        ]);
    }

    /**
     * Crea una notificación de cobro para un DetalleCobro
     */
    protected function crearNotificacion(DetalleCobros $detalle): void
    {
        $cobro = $detalle->cobro;
        $cliente = $cobro->clientes;

        // Calcular descripción
        $descripcion = $this->generarDescripcion($detalle, $cobro);

        // Tomar ends_at de la suscripción activa del vehículo; fallback a detalle->fecha
        $subscription    = $detalle->vehiculo
            ?->planSubscriptions
            ->whereNull('canceled_at')
            ->sortBy('ends_at')
            ->first();
        $fechaVencimiento = $subscription?->ends_at
            ? Carbon::parse($subscription->ends_at)
            : Carbon::parse($detalle->fecha);

        NotificacionCobro::create([
            'empresa_id'        => $cliente->empresa_id,
            'detalle_cobro_id'  => $detalle->id,
            'cobro_id'          => $cobro->id,
            'cliente_id'        => $cliente->id,
            'vehiculo_id'       => $detalle->vehiculo_id,
            'fecha_vencimiento' => $fechaVencimiento,
            // monto_efectivo descuenta IGV cuando el cobro es tipo RECIBO
            'monto'             => $detalle->monto_efectivo ?: 0,
            'moneda'            => $cobro->moneda ?? $cobro->divisa ?? 'PEN',
            'descripcion'       => $descripcion,
            'estado'            => 'PENDIENTE',
        ]);

        Log::info('Notificación de cobro creada', [
            'detalle_cobro_id'  => $detalle->id,
            'cliente'           => $cliente->razon_social,
            'vehiculo'          => $detalle->vehiculo?->placa,
            'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
            'subscription_id'   => $subscription?->id,
            'monto_efectivo'    => $detalle->monto_efectivo,
            'tipo_pago'         => $cobro->tipo_pago,
        ]);
    }

    /**
     * Genera descripción automática para la notificación
     */
    protected function generarDescripcion(DetalleCobros $detalle, $cobro): string
    {
        $placa = $detalle->vehiculo?->placa ?? 'Sin vehículo';
        $servicio = $cobro->producto?->nombre ?? $cobro->comentario ?? 'Servicio';
        $periodo = strtolower($cobro->periodo ?? 'mensual');

        return "Cobro {$periodo} - {$servicio} - Vehículo: {$placa}";
    }

    /**
     * Manejo de fallo del job
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Fallo al generar notificaciones de cobro', [
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
