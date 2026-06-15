<?php

namespace App\Services\Portal;

use App\Enums\CobroEstado;
use App\Models\Vehiculos;

/**
 * Determina si un vehículo es accesible para el cliente en el portal.
 *
 * Reglas (basta una): el vehículo tiene un cobro vigente (ACTIVO o CORTESÍA),
 * o el cliente tiene un recibo pendiente de pago (acceso en mora permitido).
 */
class VehiculoAccesoService
{
    /**
     * @return array{accesible: bool, motivo: ?string, plan: ?array<string, mixed>}
     */
    public function evaluar(Vehiculos $vehiculo, bool $clienteTieneReciboPendiente = false): array
    {
        $cobros = $vehiculo->relationLoaded('cobros')
            ? $vehiculo->cobros
            : $vehiculo->cobros()->with('plan')->get();

        $cobroVigente = $cobros->first(
            fn ($cobro) => in_array($cobro->estado, [CobroEstado::ACTIVO, CobroEstado::CORTESIA], true)
        );

        $accesible = $cobroVigente !== null || $clienteTieneReciboPendiente;

        return [
            'accesible' => $accesible,
            'motivo' => $accesible ? null : $this->motivo($cobros),
            'plan' => $cobroVigente ? [
                'nombre' => $cobroVigente->plan_nombre,
                'estado' => $cobroVigente->estado->value,
                'vence' => optional($cobroVigente->fecha_vencimiento)->format('Y-m-d'),
                'dias_restantes' => $cobroVigente->dias_restantes,
            ] : null,
        ];
    }

    /**
     * @param  \Illuminate\Support\Collection<int, \App\Models\Cobros>  $cobros
     */
    protected function motivo($cobros): string
    {
        if ($cobros->contains(fn ($cobro) => $cobro->estado === CobroEstado::SUSPENDIDO)) {
            return 'suspendido';
        }

        if ($cobros->contains(fn ($cobro) => $cobro->estado === CobroEstado::CANCELADO)) {
            return 'cancelado';
        }

        return 'sin_cobro';
    }
}
