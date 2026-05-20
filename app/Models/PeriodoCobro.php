<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PeriodoCobro extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'periodos_cobros';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_inicio'     => 'date:Y-m-d',
        'fecha_fin'        => 'date:Y-m-d',
        'fecha_pago'       => 'datetime',
        'monto'            => 'decimal:4',
        'empresa_id'       => 'integer',
        'cobros_id'        => 'integer',
        'cliente_id'       => 'integer',
        'vehiculo_id'      => 'integer',
        'venta_id'         => 'integer',
        'recibo_id'        => 'integer',
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['estado', 'venta_id', 'recibo_id', 'fecha_pago'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);

        static::creating(function (self $periodo) {
            $periodo->empresa_id = session('empresa');
        });
    }

    // Relaciones

    public function cobro()
    {
        return $this->belongsTo(Cobros::class, 'cobros_id')->withTrashed();
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')->withTrashed();
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id')->withTrashed();
    }

    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }

    public function recibo()
    {
        return $this->belongsTo(Recibos::class, 'recibo_id');
    }

    // Accessors

    public function getDiasRestantesAttribute(): int
    {
        return max(0, (int) Carbon::today()->diffInDays($this->fecha_fin, false));
    }

    public function getVencidoAttribute(): bool
    {
        return Carbon::today()->gt($this->fecha_fin);
    }

    public function getEstaFacturadoAttribute(): bool
    {
        return in_array($this->estado, ['FACTURADO', 'PAGADO'])
            || $this->venta_id !== null
            || $this->recibo_id !== null;
    }

    // Scopes

    public function scopePendientes($query)
    {
        return $query->where('estado', 'PENDIENTE');
    }

    public function scopeFacturados($query)
    {
        return $query->where('estado', 'FACTURADO');
    }

    public function scopePagados($query)
    {
        return $query->where('estado', 'PAGADO');
    }

    public function scopeProximosAVencer($query, int $dias = 7)
    {
        return $query->where('estado', 'PENDIENTE')
            ->whereBetween('fecha_fin', [
                Carbon::today(),
                Carbon::today()->addDays($dias),
            ]);
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', 'PENDIENTE')
            ->where('fecha_fin', '<', Carbon::today());
    }

    // Métodos de negocio

    public function marcarComoFacturado(?int $ventaId = null, ?int $reciboId = null): void
    {
        $this->update([
            'estado'    => 'FACTURADO',
            'venta_id'  => $ventaId ?? $this->venta_id,
            'recibo_id' => $reciboId ?? $this->recibo_id,
        ]);
    }

    public function marcarComoPagado(?int $ventaId = null, ?int $reciboId = null): void
    {
        $this->update([
            'estado'    => 'PAGADO',
            'venta_id'  => $ventaId ?? $this->venta_id,
            'recibo_id' => $reciboId ?? $this->recibo_id,
            'fecha_pago' => now(),
        ]);
    }

    /**
     * Revierte el vínculo con un comprobante (al anular/eliminar una venta o recibo).
     * Vuelve el período a estado PENDIENTE sin comprobante asociado.
     */
    public function resetFacturacion(): void
    {
        $this->update([
            'estado'    => 'PENDIENTE',
            'venta_id'  => null,
            'recibo_id' => null,
            'fecha_pago' => null,
        ]);
    }
}
