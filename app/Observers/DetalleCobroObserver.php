<?php

namespace App\Observers;

use App\Models\DetalleCobros;
use Carbon\Carbon;

/**
 * Observer para DetalleCobros
 *
 * Maneja la lógica de renovación automática y sincronización de suscripciones
 * del paquete laravelcm/laravel-subscriptions con los DetalleCobros.
 */
class DetalleCobroObserver
{
    /**
     * Cuando se crea un DetalleCobro → crear o actualizar la suscripción del vehículo.
     */
    public function created(DetalleCobros $detalleCobro): void
    {
        $this->sincronizarSuscripcion($detalleCobro);
    }

    /**
     * Antes de guardar cambios: resetea estado cuando cambia fecha_facturacion
     * a una fecha futura (renovación de período).
     *
     * Nota: el avance de fecha cuando se paga ahora se gestiona desde
     * NotificacionCobro::marcarComoPagado(), no desde este observer.
     */
    public function updating(DetalleCobros $detalleCobro): void
    {
        // Si cambió fecha_facturacion → resetear para nueva facturación
        if ($detalleCobro->isDirty('fecha_facturacion')) {
            $fechaOriginal = $detalleCobro->getOriginal('fecha_facturacion');
            $fechaNueva = $detalleCobro->fecha_facturacion;

            if ($fechaOriginal !== $fechaNueva && Carbon::parse($fechaNueva)->isFuture()) {
                $detalleCobro->estado_facturacion = 'SIN_FACTURAR';
                $detalleCobro->venta_id = null;
                $detalleCobro->recibo_id = null;
                $detalleCobro->fecha_pago = null;

                activity()
                    ->performedOn($detalleCobro)
                    ->withProperties([
                        'fecha_anterior' => $fechaOriginal,
                        'fecha_nueva' => $fechaNueva,
                        'accion' => 'renovacion_automatica',
                    ])
                    ->log('Cobro renovado automáticamente - fecha actualizada de ' .
                        Carbon::parse($fechaOriginal)->format('d/m/Y') . ' a ' .
                        Carbon::parse($fechaNueva)->format('d/m/Y'));
            }
        }
    }

    /**
     * Después de guardar cambios: sincronizar suscripción si cambiaron
     * el plan o las fechas, o renovar cuando se pagó.
     */
    public function updated(DetalleCobros $detalleCobro): void
    {
        // Si cambió plan, fecha de inicio o vencimiento → re-sincronizar
        if ($detalleCobro->wasChanged(['plan_id', 'fecha_inicio', 'fecha_vencimiento'])) {
            $this->sincronizarSuscripcion($detalleCobro);
        }

        // Si se acaba de marcar como PAGADO → renovar ends_at de la suscripción
        if (
            $detalleCobro->wasChanged('estado_facturacion') &&
            $detalleCobro->estado_facturacion === 'PAGADO'
        ) {
            $this->renovarSuscripcion($detalleCobro);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers privados
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Crea o actualiza la suscripción del vehículo para reflejar el DetalleCobro.
     *
     * Se usa 'gps-tracking' como slug de identificación de la suscripción.
     */
    private function sincronizarSuscripcion(DetalleCobros $detalleCobro): void
    {
        if (!$detalleCobro->plan_id || !$detalleCobro->vehiculo_id) {
            return;
        }

        $vehiculo = $detalleCobro->vehiculo;
        if (!$vehiculo) {
            return;
        }

        $plan = \App\Models\Plan::find($detalleCobro->plan_id);
        if (!$plan) {
            return;
        }

        $startsAt = $detalleCobro->fecha_inicio
            ? Carbon::parse($detalleCobro->fecha_inicio)
            : Carbon::now();

        $endsAt = $detalleCobro->fecha_vencimiento
            ? Carbon::parse($detalleCobro->fecha_vencimiento)
            : $startsAt->copy()->addMonth();

        $subscription = $vehiculo->planSubscription('gps-tracking');

        if ($subscription) {
            // Cambiar plan y ajustar fechas manualmente
            $subscription->changePlan($plan);
            $subscription->forceFill([
                'starts_at'   => $startsAt,
                'ends_at'     => $endsAt,
                'canceled_at' => null,
            ])->save();
        } else {
            // Crear nueva suscripción usando el método oficial del paquete
            $subscription = $vehiculo->newPlanSubscription('gps-tracking', $plan, $startsAt);
            $subscription->forceFill([
                'ends_at' => $endsAt,
            ])->save();
        }
    }

    /**
     * Cuando se registra un pago (PAGADO), avanza ends_at de la suscripción
     * a la nueva fecha_facturacion calculada.
     */
    private function renovarSuscripcion(DetalleCobros $detalleCobro): void
    {
        if (!$detalleCobro->vehiculo_id) {
            return;
        }

        $vehiculo = $detalleCobro->vehiculo;
        $subscription = $vehiculo?->planSubscription('gps-tracking');

        if (!$subscription) {
            return;
        }

        // La nueva ends_at es la nueva fecha_facturacion (ya avanzada por updating())
        $nuevaFecha = Carbon::parse($detalleCobro->fecha_facturacion);

        $subscription->forceFill([
            'ends_at'     => $nuevaFecha,
            'canceled_at' => null,
        ])->save();
    }
}
