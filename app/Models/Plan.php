<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Observers\PlanObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravelcm\Subscriptions\Models\Plan as BasePlan;

#[ObservedBy(PlanObserver::class)]
class Plan extends BasePlan
{
    protected $fillable = [
        'producto_id',
        'empresa_id',
        'name',
        'slug',
        'description',
        'is_active',
        'price',
        'signup_fee',
        'currency',
        'trial_period',
        'trial_interval',
        'trial_mode',
        'grace_period',
        'grace_interval',
        'invoice_period',
        'invoice_interval',
        'tier',
        'prorate_day',
        'prorate_period',
        'prorate_extend_due',
        'active_subscribers_limit',
        'sort_order',
        'default',
    ];

    protected $casts = [
        'name' => 'json',
        'description' => 'json',
        'is_active' => 'boolean',
        'default' => 'boolean',
        'price' => 'decimal:4',
        'signup_fee' => 'decimal:4',
        'trial_period' => 'integer',
        'grace_period' => 'integer',
        'invoice_period' => 'integer',
        'prorate_day' => 'integer',
        'prorate_period' => 'integer',
        'prorate_extend_due' => 'integer',
        'active_subscribers_limit' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Apply the empresa scope globally
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    /**
     * Relación con el producto (servicio de cobro)
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Productos::class, 'producto_id')->withTrashed();
    }

    /**
     * Relación con la empresa
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
