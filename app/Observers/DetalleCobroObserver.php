<?php

namespace App\Observers;

use App\Models\DetalleCobros;
use App\Models\NotificacionCobro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        // Si cambió plan, periodo, fecha de inicio o vencimiento → re-sincronizar suscripción
        if ($detalleCobro->wasChanged(['plan_id', 'periodo', 'fecha_inicio', 'fecha_vencimiento'])) {
            $this->sincronizarSuscripcion($detalleCobro);
        }

        // Si cambió el período de facturación → cancelar notificaciones futuras PENDIENTES para que
        // el job las regenere con las fechas correctas del nuevo período (ej: anual → mensual).
        if ($detalleCobro->wasChanged('periodo')) {
            NotificacionCobro::where('detalle_cobro_id', $detalleCobro->id)
                ->where('estado', 'PENDIENTE')
                ->where('fecha_inicio', '>=', Carbon::today())
                ->get()
                ->each->delete();
        }

        // Si cambió fecha_facturacion → renovar ends_at de la suscripción (nuevo período pagado)
        if ($detalleCobro->wasChanged('fecha_facturacion')) {
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

        $periodo = $detalleCobro->periodo ?? 'MENSUAL';

        // 1. Si ya tiene subscription_id guardado, actualizar esa suscripción directamente.
        //    Esto garantiza que cada detalle gestiona su propia suscripción sin pisar la de otros.
        if ($detalleCobro->subscription_id) {
            $subscription = \Laravelcm\Subscriptions\Models\Subscription::find($detalleCobro->subscription_id);
            if ($subscription) {
                $subscription->changePlan($plan);
                $subscription->forceFill([
                    'starts_at'   => $startsAt,
                    'ends_at'     => $endsAt,
                    'canceled_at' => null,
                    'periodo'     => $periodo,
                ])->save();
                return;
            }
        }

        // 2. Sin subscription_id: crear suscripción propia con slug único por detalle.
        //    Slug 'detalle-{id}' → permite al vehículo tener N suscripciones simultáneas
        //    (una por servicio/cliente), sin que compartan el mismo slot 'gps-tracking'.
        $slug = 'detalle-' . $detalleCobro->id;

        $subscription = $vehiculo->planSubscription($slug);

        if ($subscription) {
            $subscription->changePlan($plan);
            $subscription->forceFill([
                'starts_at'   => $startsAt,
                'ends_at'     => $endsAt,
                'canceled_at' => null,
                'periodo'     => $periodo,
            ])->save();
        } else {
            $subscription = $vehiculo->newPlanSubscription($slug, $plan, $startsAt);
            $subscription->forceFill([
                'ends_at' => $endsAt,
                'periodo' => $periodo,
            ])->save();
        }

        // Guardar el vínculo usando DB::table para no re-disparar este observer.
        DB::table('detalles_cobros')
            ->where('id', $detalleCobro->id)
            ->update(['subscription_id' => $subscription->id]);

        $detalleCobro->subscription_id = $subscription->id;
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

        // Usar la suscripción propia del detalle (subscription_id) para no
        // afectar por error las suscripciones de otros detalles del mismo vehículo.
        $subscription = $detalleCobro->subscription_id
            ? \Laravelcm\Subscriptions\Models\Subscription::find($detalleCobro->subscription_id)
            : null;

        // Fallback legacy: vehículos migrados que aún apuntan a 'gps-tracking'
        if (!$subscription) {
            $vehiculo = $detalleCobro->vehiculo;
            $subscription = $vehiculo?->planSubscription('gps-tracking');
        }

        if (!$subscription) {
            return;
        }

        $nuevaFecha = Carbon::parse($detalleCobro->fecha_facturacion);

        $subscription->forceFill([
            'ends_at'     => $nuevaFecha,
            'canceled_at' => null,
        ])->save();
    }
}
