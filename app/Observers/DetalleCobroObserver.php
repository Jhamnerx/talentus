<?php

namespace App\Observers;

use App\Models\DetalleCobros;
use Carbon\Carbon;

/**
 * Observer para DetalleCobros
 * 
 * Maneja la lógica de renovación automática cuando cambia la fecha de facturación
 */
class DetalleCobroObserver
{
    /**
     * Detecta cuando se actualiza la fecha de facturación
     * Si la nueva fecha es futura, reinicia el estado para permitir nueva facturación
     */
    public function updating(DetalleCobros $detalleCobro): void
    {
        // Verificar si cambió la fecha_facturacion
        if ($detalleCobro->isDirty('fecha_facturacion')) {
            $fechaOriginal = $detalleCobro->getOriginal('fecha_facturacion');
            $fechaNueva = $detalleCobro->fecha_facturacion;

            // Solo renovar si la nueva fecha es diferente y futura
            if ($fechaOriginal !== $fechaNueva && Carbon::parse($fechaNueva)->isFuture()) {
                // Reset estado de facturación
                $detalleCobro->estado_facturacion = 'SIN_FACTURAR';

                // Limpiar referencias de documentos anteriores
                $detalleCobro->venta_id = null;
                $detalleCobro->recibo_id = null;
                $detalleCobro->fecha_pago = null;

                // Log de la renovación
                activity()
                    ->performedOn($detalleCobro)
                    ->withProperties([
                        'fecha_anterior' => $fechaOriginal,
                        'fecha_nueva' => $fechaNueva,
                        'accion' => 'renovacion_automatica'
                    ])
                    ->log('Cobro renovado automáticamente - fecha actualizada de ' .
                        Carbon::parse($fechaOriginal)->format('d/m/Y') . ' a ' .
                        Carbon::parse($fechaNueva)->format('d/m/Y'));
            }
        }
    }

    /**
     * Detecta cuando se marca un detalle como PAGADO manualmente
     * y actualiza la fecha para el próximo período
     */
    public function updating_estado_facturacion(DetalleCobros $detalleCobro): void
    {
        // Si se marca como PAGADO y tiene un cobro recurrente asociado
        if (
            $detalleCobro->isDirty('estado_facturacion') &&
            $detalleCobro->estado_facturacion === 'PAGADO' &&
            $detalleCobro->cobro
        ) {

            $cobro = $detalleCobro->cobro;
            $fechaActual = Carbon::parse($detalleCobro->fecha_facturacion);

            // Avanzar fecha según el período del cobro
            switch ($cobro->periodo) {
                case 'DIARIO':
                    $nuevaFecha = $fechaActual->addDay();
                    break;
                case 'SEMANAL':
                    $nuevaFecha = $fechaActual->addWeek();
                    break;
                case 'QUINCENAL':
                    $nuevaFecha = $fechaActual->addDays(15);
                    break;
                case 'MENSUAL':
                    $nuevaFecha = $fechaActual->addMonth();
                    break;
                case 'BIMESTRAL':
                    $nuevaFecha = $fechaActual->addMonths(2);
                    break;
                case 'TRIMESTRAL':
                    $nuevaFecha = $fechaActual->addMonths(3);
                    break;
                case 'SEMESTRAL':
                    $nuevaFecha = $fechaActual->addMonths(6);
                    break;
                case 'ANUAL':
                    $nuevaFecha = $fechaActual->addYear();
                    break;
                default:
                    $nuevaFecha = $fechaActual->addMonth(); // Por defecto mensual
            }

            // Actualizar la fecha para el próximo cobro
            $detalleCobro->fecha_facturacion = $nuevaFecha->format('Y-m-d');

            // Registrar fecha de pago actual
            if (!$detalleCobro->fecha_pago) {
                $detalleCobro->fecha_pago = now();
            }
        }
    }
}
