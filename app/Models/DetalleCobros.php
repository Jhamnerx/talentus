<?php

namespace App\Models;

use App\Enums\CobroEstado;
use App\Enums\EstadoFacturacion;
use App\Observers\DetalleCobroObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Carbon\Carbon;

#[ObservedBy(DetalleCobroObserver::class)]
class DetalleCobros extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalles_cobros';

    protected $casts = [
        'cobros_id' => 'integer',
        'vehiculos_id' => 'integer',
        'venta_id' => 'integer',
        'recibo_id' => 'integer',
        'cantidad_unidades' => 'integer',
        'monto_unidad' => 'decimal:2',
        'fecha' => 'date:Y-m-d',
        'fecha_facturado' => 'date:Y-m-d',
        'fecha_facturacion' => 'date:Y-m-d',
        'fecha_pago' => 'date:Y-m-d',
        'estado' => 'boolean',
        'estado_detalle' => CobroEstado::class,
        'estado_facturacion' => EstadoFacturacion::class,
    ];



    public function vehiculo()
    {
        return $this->belongsTo(\App\Models\Vehiculos::class);
    }

    public function cobro()
    {
        return $this->belongsTo(\App\Models\Cobros::class, 'cobros_id')->withTrashed();
    }

    public function venta()
    {
        return $this->belongsTo(\App\Models\Ventas::class);
    }

    public function recibo()
    {
        return $this->belongsTo(\App\Models\Recibos::class);
    }

    /**
     * Notificaciones de cobro generadas para este detalle
     */
    public function notificaciones()
    {
        return $this->hasMany(\App\Models\NotificacionCobro::class, 'detalle_cobro_id');
    }

    /**
     * Obtener el documento asociado (Venta o Recibo)
     */
    public function getDocumentoAttribute()
    {
        return $this->venta ?? $this->recibo;
    }

    /**
     * Obtener el número completo del documento
     */
    public function getNumeroDocumentoAttribute(): ?string
    {
        if ($this->venta) {
            return $this->venta->numero_completo ?? $this->venta->serie . '-' . $this->venta->correlativo;
        }
        if ($this->recibo) {
            return $this->recibo->numero_completo ?? $this->recibo->serie . '-' . $this->recibo->correlativo;
        }
        return null;
    }


    // Scopes para estado_facturacion
    public function scopeSinFacturar($query)
    {
        return $query->where('estado_facturacion', EstadoFacturacion::SIN_FACTURAR);
    }

    public function scopeFacturado($query)
    {
        return $query->where('estado_facturacion', EstadoFacturacion::FACTURADO);
    }

    public function scopePagado($query)
    {
        return $query->where('estado_facturacion', EstadoFacturacion::PAGADO);
    }

    public function scopeFacturadosPendientesPago($query)
    {
        return $query->where('estado_facturacion', EstadoFacturacion::FACTURADO)
            ->where('estado', 1)
            ->where('estado_detalle', CobroEstado::ACTIVO);
    }
    // Atributo personalizado para obtener los detalles vencidos
    public function scopeVencidos($query)
    {
        return $query->where('fecha', '<', Carbon::now());
    }

    public function scopeActivos($query)
    {
        return $query->where('estado_detalle', CobroEstado::ACTIVO);
    }

    public function scopeSuspendidos($query)
    {
        return $query->where('estado_detalle', CobroEstado::SUSPENDIDO);
    }

    public function scopePendientesPago($query)
    {
        return $query->where('estado', 1)
            ->where('estado_detalle', CobroEstado::ACTIVO)
            ->whereNull('factura_id');
    }

    public function scopePorVencer($query, $dias = 7)
    {
        $hoy = Carbon::now();
        return $query->where('estado', 1)
            ->where('estado_detalle', CobroEstado::ACTIVO)
            ->whereBetween('fecha', [$hoy->format('Y-m-d'), $hoy->copy()->addDays($dias)->format('Y-m-d')]);
    }
}
