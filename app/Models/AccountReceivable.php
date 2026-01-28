<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $empresa_id
 * @property int $cliente_id
 * @property int|null $venta_id
 * @property int|null $recibo_id
 * @property int|null $cobro_id
 * @property string|null $numero_documento
 * @property \Carbon\Carbon $fecha_emision
 * @property \Carbon\Carbon $fecha_vencimiento
 * @property float $monto_total
 * @property float $monto_pagado
 * @property float $saldo_pendiente
 * @property PaymentStatus $estado
 * @property string|null $observaciones
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read Clientes $cliente
 * @property-read Ventas|null $venta
 * @property-read Recibos|null $recibo
 * @property-read Cobros|null $cobro
 * @property-read int|null $dias_mora
 * @property-read float $total_pendiente_real
 * @property-read bool $esta_vencida
 */
class AccountReceivable extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    protected $table = 'accounts_receivable';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_emision' => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'monto_total' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
        'estado' => PaymentStatus::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    protected function empresaId(): Attribute
    {
        return new Attribute(
            set: fn($empresa_id) => session('empresa'),
        );
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', PaymentStatus::PENDIENTE);
    }

    public function scopePagados($query)
    {
        return $query->where('estado', PaymentStatus::PAGADO);
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', PaymentStatus::VENCIDO);
    }

    public function scopeParciales($query)
    {
        return $query->where('estado', PaymentStatus::PARCIAL);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }

    public function recibo(): BelongsTo
    {
        return $this->belongsTo(Recibos::class, 'recibo_id');
    }

    public function cobro(): BelongsTo
    {
        return $this->belongsTo(Cobros::class, 'cobro_id');
    }

    /**
     * Calcula los días de mora desde la fecha de vencimiento
     *
     * @return int|null
     */
    public function getDiasMoraAttribute(): ?int
    {
        if ($this->saldo_pendiente <= 0) {
            return null;
        }

        if (!$this->fecha_vencimiento) {
            return null;
        }

        $now = now();
        $vencimiento = $this->fecha_vencimiento;

        if ($now->gt($vencimiento)) {
            return $now->diffInDays($vencimiento);
        }

        return null;
    }

    /**
     * Obtiene el total real pendiente considerando todos los factores
     *
     * @return float
     */
    public function getTotalPendienteRealAttribute(): float
    {
        return max(0, $this->monto_total - $this->monto_pagado);
    }

    /**
     * Verifica si la cuenta está vencida
     *
     * @return bool
     */
    public function getEstaVencidaAttribute(): bool
    {
        if ($this->saldo_pendiente <= 0) {
            return false;
        }

        if (!$this->fecha_vencimiento) {
            return false;
        }

        return now()->gt($this->fecha_vencimiento);
    }

    /**
     * Scope para cuentas vencidas
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConMora($query)
    {
        return $query->where('saldo_pendiente', '>', 0)
            ->whereNotNull('fecha_vencimiento')
            ->where('fecha_vencimiento', '<', now());
    }
}
