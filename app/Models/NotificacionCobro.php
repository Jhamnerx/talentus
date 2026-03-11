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
     * Marca la notificación como pagada y renueva el período del DetalleCobro.
     *
     * Mismo cálculo que Emitir.php: fecha_vencimiento de la notif es el nuevo
     * inicio, y se avanza con NoOverflow para evitar desbordamientos de mes
     * (ej: 30-ene + 1 mes = 28-feb, no 02-mar).
     * El DetalleCobroObserver se dispara sobre fecha_vencimiento y sincroniza
     * la suscripción del vehículo automáticamente.
     */
    public function marcarComoPagado(): void
    {
        $this->estado    = 'PAGADO';
        $this->fecha_pago = now();
        $this->save();

        $det   = $this->detalleCobro;
        $cobro = $this->cobro;

        if ($det && $cobro) {
            // El nuevo inicio es la fecha de vencimiento de esta notificación
            $nuevoInicio = $this->fecha_vencimiento->copy();

            // Período: fuente correcta es el DetalleCobro (no el Cobro)
            $periodo = strtoupper($det->periodo ?? $cobro->periodo ?? 'MENSUAL');

            $nuevoFin = match ($periodo) {
                'DIARIO'     => $nuevoInicio->copy()->addDay(),
                'SEMANAL'    => $nuevoInicio->copy()->addWeek(),
                'QUINCENAL'  => $nuevoInicio->copy()->addDays(15),
                'BIMENSUAL'  => $nuevoInicio->copy()->addMonthsNoOverflow(2),
                'TRIMESTRAL' => $nuevoInicio->copy()->addMonthsNoOverflow(3),
                'SEMESTRAL'  => $nuevoInicio->copy()->addMonthsNoOverflow(6),
                'ANUAL'      => $nuevoInicio->copy()->addYearNoOverflow(),
                default      => $nuevoInicio->copy()->addMonthNoOverflow(), // MENSUAL
            };

            // Actualiza fecha_inicio y fecha_vencimiento;
            // el DetalleCobroObserver sincroniza la suscripción del vehículo
            $det->update([
                'fecha_inicio'      => $nuevoInicio,
                'fecha_vencimiento' => $nuevoFin,
            ]);
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
}
