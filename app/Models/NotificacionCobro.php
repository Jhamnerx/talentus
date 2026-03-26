<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Scopes\EmpresaScope;
use App\Models\Empresa;
use App\Models\DetalleCobros;
use App\Models\Cobros;
use App\Models\Clientes;
use App\Models\Vehiculos;
use App\Models\Ventas;
use App\Models\Recibos;

/**
 * Notificaciones de Cobro
 * 
 * Documento intermedio generado automáticamente cuando un DetalleCobro
 * está próximo a su fecha de facturación. 
 * 
 * Cuando se registra el pago de esta notificación (creando Venta/Recibo),
 * se actualiza el DetalleCobro correspondiente.
 */
class NotificacionCobro extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'notificaciones_cobro';

    protected $fillable = [
        'empresa_id',
        'detalle_cobro_id',
        'cobro_id',
        'cliente_id',
        'vehiculo_id',
        'fecha_vencimiento',
        'fecha_inicio',
        'fecha_fin',
        'monto',
        'moneda',
        'descripcion',
        'estado', // PENDIENTE, FACTURADO, PAGADO, CANCELADO
        'venta_id',
        'recibo_id',
        'fecha_facturacion',
        'fecha_pago',
        'observaciones',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'fecha_inicio'      => 'date',
        'fecha_fin'         => 'date',
        'fecha_facturacion' => 'datetime',
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:4',
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['estado', 'venta_id', 'recibo_id', 'fecha_pago'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Boot del modelo - Aplica scope global de empresa
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    // ========== RELACIONES ==========

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function detalleCobro(): BelongsTo
    {
        return $this->belongsTo(DetalleCobros::class, 'detalle_cobro_id')->withTrashed();
    }

    public function cobro(): BelongsTo
    {
        return $this->belongsTo(Cobros::class, 'cobro_id')->withTrashed();
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')->withTrashed();
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id');
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }

    public function recibo(): BelongsTo
    {
        return $this->belongsTo(Recibos::class, 'recibo_id')->withTrashed();
    }

    // ========== SCOPES ==========

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

    public function scopeVencidos($query)
    {
        return $query->where('estado', 'PENDIENTE')
            ->where('fecha_vencimiento', '<', now());
    }

    public function scopePorVencer($query, $dias = 7)
    {
        return $query->where('estado', 'PENDIENTE')
            ->whereBetween('fecha_vencimiento', [now(), now()->addDays($dias)]);
    }

    // ========== MÉTODOS ==========

    /**
     * Marca la notificación como facturada y vincula el documento
     */
    public function marcarComoFacturado($documentoId, $tipo = 'venta'): void
    {
        $this->estado = 'FACTURADO';
        $this->fecha_facturacion = now();

        if ($tipo === 'venta') {
            $this->venta_id = $documentoId;
        } else {
            $this->recibo_id = $documentoId;
        }

        $this->save();
    }

    /**
     * Marca la notificación como pagada.
     *
     * Solo avanza el período del DetalleCobro cuando es una notificación de RENOVACIÓN,
     * identificada porque fecha_fin > fecha_vencimiento:
     *
     * - Notificación INICIAL (Save/Edit): fecha_fin == fecha_vencimiento
     *   → el período activo ya está configurado desde el registro del cobro, no avanzar.
     *   → el job generará la notificación de renovación 7 días antes del vencimiento.
     *
     * - Notificación de RENOVACIÓN (job diario): fecha_inicio >= det.fecha_vencimiento
     *   → el job genera fecha_vencimiento = fecha_fin = fin del siguiente período.
     *   → fecha_inicio es el nuevo starts_at, fecha_fin es el nuevo ends_at.
     *   → pagar esta notificación extiende la suscripción al nuevo período.
     *   → el DetalleCobroObserver sincroniza ends_at de la suscripción automáticamente.
     *
     * Criterio de renovación: fecha_inicio de la notif >= fecha_vencimiento actual del DetalleCobro.
     * - Notif INICIAL (Save/Edit): fecha_inicio = 23/03 < det.fecha_vencimiento = 23/04 → no avanza.
     * - Notif RENOVACIÓN (job):    fecha_inicio = 23/04 = det.fecha_vencimiento = 23/04 → avanza.
     */
    public function marcarComoPagado(): void
    {
        $this->estado    = 'PAGADO';
        $this->fecha_pago = now();
        $this->save();

        $det = $this->detalleCobro;

        // Solo avanzar si la notificación cubre un período futuro (renovación)
        if (
            $det && $this->fecha_inicio && $det->fecha_vencimiento
            && $this->fecha_inicio->gte($det->fecha_vencimiento)
        ) {
            $det->update([
                'fecha_inicio'      => $this->fecha_inicio,
                'fecha_vencimiento' => $this->fecha_fin,
            ]);
            // DetalleCobroObserver::updated() detecta wasChanged(['fecha_inicio','fecha_vencimiento'])
            // y llama sincronizarSuscripcion() → actualiza subscription.ends_at
        }
    }

    /**
     * Cancela la notificación
     */
    public function cancelar($observacion = null): void
    {
        $this->estado = 'CANCELADO';
        if ($observacion) {
            $this->observaciones = $observacion;
        }
        $this->save();
    }

    /**
     * Revierte la facturación: quita el venta_id/recibo_id y vuelve a PENDIENTE.
     * Se llama cuando se anula la venta o se emite una nota de crédito/débito sobre ella.
     */
    public function resetFacturacion(): void
    {
        $this->update([
            'venta_id'          => null,
            'recibo_id'         => null,
            'estado'            => 'PENDIENTE',
            'fecha_facturacion' => null,
        ]);
    }
}
