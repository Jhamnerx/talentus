<?php

namespace App\Models;

use Carbon\Carbon;
use App\Observers\SubscriptionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Laravelcm\Subscriptions\Models\Subscription as BaseSubscription;

#[ObservedBy(SubscriptionObserver::class)]
class Subscription extends BaseSubscription
{
    protected $fillable = [
        'subscriber_id',
        'subscriber_type',
        'plan_id',
        'slug',
        'name',
        'description',
        'empresa_id',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'canceled_at',
        'periodo',
    ];

    /**
     * Meses reales según el período del cobro.
     * Sobreescribe el período del plan para que renew() calcule correctamente.
     */
    protected function mesesDePeriodo(): int
    {
        return match ($this->periodo ?? 'MENSUAL') {
            'BIMENSUAL'  => 2,
            'TRIMESTRAL' => 3,
            'SEMESTRAL'  => 6,
            'ANUAL'      => 12,
            default      => 1, // MENSUAL
        };
    }

    /**
     * Sobreescribe setNewPeriod() para usar el `periodo` guardado en la suscripción
     * en lugar del invoice_period/invoice_interval fijo del Plan.
     */
    protected function setNewPeriod(string $invoice_interval = '', ?int $invoice_period = null, ?Carbon $start = null): static
    {
        // Si se pasan parámetros explícitos (ej: desde changePlan()) los respetamos
        $count  = $invoice_period ?? $this->mesesDePeriodo();
        $start  = $start ?? Carbon::now();

        // Usamos NoOverflow para que 31-ene + 1 mes = 28-feb (no 03-mar)
        $endsAt = match ($invoice_interval ?: 'month') {
            'year'  => $start->copy()->addYearsNoOverflow((int) ceil($count / 12)),
            default => $start->copy()->addMonthsNoOverflow($count),
        };

        $this->fill([
            'starts_at' => $start,
            'ends_at'   => $endsAt,
        ]);

        return $this;
    }
}
