<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy(\App\Observers\DetalleCobroObserver::class)]
class DetalleCobros extends Model
{
    use HasFactory, SoftDeletes;
    use LogsActivity;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalles_cobros';

    protected $casts = [
        'empresa_id'        => 'integer',
        'cliente_id'        => 'integer',
        'cobros_id'         => 'integer',
        'vehiculo_id'       => 'integer',
        'plan_id'           => 'integer',
        'monto'             => 'decimal:4',
        'descuento'         => 'decimal:2',
        'fecha_inicio'      => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'estado'            => 'boolean',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    // Relaciones

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')->withTrashed();
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class)->withTrashed();
    }

    public function cobro()
    {
        return $this->belongsTo(Cobros::class, 'cobros_id')->withTrashed();
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function periodos()
    {
        return $this->hasMany(PeriodoCobro::class, 'detalle_cobro_id');
    }

    public function periodoActual()
    {
        return $this->hasOne(PeriodoCobro::class, 'detalle_cobro_id')
            ->whereIn('estado', ['PENDIENTE', 'PAGADO'])
            ->latest('fecha_fin');
    }

    public function ultimoPeriodoPagado()
    {
        return $this->hasOne(PeriodoCobro::class, 'detalle_cobro_id')
            ->where('estado', 'PAGADO')
            ->latest('fecha_fin');
    }

    // Accessors

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

    public function getDiasRestantesAttribute(): int
    {
        if (!$this->fecha_vencimiento) {
            return 0;
        }
        return max(0, (int) Carbon::today()->diffInDays($this->fecha_vencimiento, false));
    }

    public function getVencidoAttribute(): bool
    {
        return $this->fecha_vencimiento && Carbon::today()->gt($this->fecha_vencimiento);
    }

    // Scopes

    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', true)
            ->where('fecha_vencimiento', '<', Carbon::today());
    }

    public function scopeProximosAVencer($query, int $dias = 7)
    {
        return $query->where('estado', true)
            ->whereBetween('fecha_vencimiento', [
                Carbon::today(),
                Carbon::today()->addDays($dias),
            ]);
    }
}
