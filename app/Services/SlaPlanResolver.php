<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Ticket;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;

class SlaPlanResolver
{
    /**
     * Ranking de perfiles SLA, de menos a más exigente.
     * Se usa para elegir el "mejor plan" del cliente cuando un ticket no tiene vehículo.
     */
    const TIER_RANK = [
        'basico'   => 1,
        'estandar' => 2,
        'mininter' => 3,
        'premium'  => 4,
    ];

    const DEFAULT_TIER = 'basico';

    /**
     * Resuelve el perfil SLA aplicable a un ticket.
     * 1) Si el ticket tiene vehículo → perfil del plan de su suscripción activa.
     * 2) Si no → mejor perfil entre los vehículos del cliente con suscripción activa.
     * 3) Fallback → básico.
     */
    public function tierForTicket(Ticket $ticket): string
    {
        if (!empty($ticket->vehiculo_id)) {
            $tier = $this->tierForVehiculoId($ticket->vehiculo_id);
            if ($tier) {
                return $tier;
            }
        }

        if (!empty($ticket->customer_id)) {
            $tier = $this->bestTierForCustomer($ticket->customer_id);
            if ($tier) {
                return $tier;
            }
        }

        return self::DEFAULT_TIER;
    }

    /**
     * Perfil SLA del plan de la suscripción activa de un vehículo.
     */
    public function tierForVehiculoId(int $vehiculoId): ?string
    {
        $vehiculo = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->with('planSubscriptions')
            ->find($vehiculoId);

        if (!$vehiculo) {
            return null;
        }

        return $this->tierForVehiculo($vehiculo);
    }

    public function tierForVehiculo(Vehiculos $vehiculo): ?string
    {
        $activeSub = $vehiculo->planSubscriptions
            ->first(fn ($sub) => $sub->active());

        if (!$activeSub) {
            return null;
        }

        return Plan::withoutGlobalScope(EmpresaScope::class)
            ->where('id', $activeSub->plan_id)
            ->value('sla_tier');
    }

    /**
     * Mejor perfil SLA entre todos los vehículos del cliente con suscripción activa.
     */
    public function bestTierForCustomer(int $customerId): ?string
    {
        $vehiculos = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('clientes_id', $customerId)
            ->with('planSubscriptions')
            ->get();

        $best = null;
        $bestRank = 0;

        foreach ($vehiculos as $vehiculo) {
            $tier = $this->tierForVehiculo($vehiculo);
            if (!$tier) {
                continue;
            }

            $rank = self::TIER_RANK[$tier] ?? 0;
            if ($rank > $bestRank) {
                $bestRank = $rank;
                $best     = $tier;
            }
        }

        return $best;
    }
}
