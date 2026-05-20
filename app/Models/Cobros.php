<?php

namespace App\Models;

use App\Enums\CobroEstado;
use App\Scopes\EmpresaScope;
use App\Observers\CobrosObserver;
use Carbon\Carbon;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

/**
 * Cobros — un registro por vehículo.
 *
 * Campos clave: clientes_id, vehiculos_id, plan_id, periodo,
 *               monto, descuento, divisa, tipo_pago,
 *               fecha_inicio, fecha_vencimiento, estado (CobroEstado)
 */
#[ObservedBy(CobrosObserver::class)]
class Cobros extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    protected $table = 'cobros';

    protected $casts = [
        'clientes_id'      => 'integer',
        'vehiculos_id'     => 'integer',
        'plan_id'          => 'integer',
        'monto'            => 'decimal:4',
        'descuento'        => 'decimal:2',
        'fecha_inicio'     => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'estado'           => CobroEstado::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('estado', CobroEstado::ACTIVO);
    }

    public function scopeSuspendidos($query)
    {
        return $query->where('estado', CobroEstado::SUSPENDIDO);
    }

    public function scopeCancelados($query)
    {
        return $query->where('estado', CobroEstado::CANCELADO);
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', CobroEstado::ACTIVO)
            ->where('fecha_vencimiento', '<', Carbon::today());
    }

    public function scopeProximosAVencer($query, int $dias = 7)
    {
        return $query->where('estado', CobroEstado::ACTIVO)
            ->whereBetween('fecha_vencimiento', [Carbon::today(), Carbon::today()->addDays($dias)]);
    }

    // ─── Relaciones ───────────────────────────────────────────────────────────

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withTrashed();
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed();
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function periodos()
    {
        return $this->hasMany(PeriodoCobro::class, 'cobros_id');
    }

    public function periodoActual()
    {
        return $this->hasOne(PeriodoCobro::class, 'cobros_id')
            ->whereIn('estado', ['PENDIENTE', 'PAGADO'])
            ->latest('fecha_fin');
    }

    public function ultimoPeriodoPagado()
    {
        return $this->hasOne(PeriodoCobro::class, 'cobros_id')
            ->where('estado', 'PAGADO')
            ->latest('fecha_fin');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'cobros_id');
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getPlanNombreAttribute(): string
    {
        if ($this->plan_id) {
            $plan = $this->relationLoaded('plan')
                ? $this->getRelation('plan')
                : $this->plan()->first();
            return $plan?->name ?? 'Plan #' . $this->plan_id;
        }
        return 'Sin plan';
    }

    public function getDiasRestantesAttribute(): ?int
    {
        if (!$this->fecha_vencimiento) {
            return null;
        }
        return (int) Carbon::today()->diffInDays($this->fecha_vencimiento, false);
    }

    public function getVencidoAttribute(): bool
    {
        return $this->fecha_vencimiento && Carbon::today()->gt($this->fecha_vencimiento);
    }

    public function getEsActivoAttribute(): bool
    {
        return $this->estado === CobroEstado::ACTIVO;
    }
}
