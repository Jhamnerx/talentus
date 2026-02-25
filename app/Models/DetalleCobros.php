<?php

namespace App\Models;

use App\Enums\CobroEstado;
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
        'plan_id' => 'integer',
        'fecha' => 'date:Y-m-d',
        'fecha_facturado' => 'date:Y-m-d',
        'fecha_facturacion' => 'date:Y-m-d',
        'fecha_pago' => 'date:Y-m-d',
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'estado' => 'boolean',
        'estado_detalle' => CobroEstado::class,
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

    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class);
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

    /**
     * Obtener el nombre del plan con lógica de fallback
     * 
     * Sistema NUEVO: plan_id tiene valor, campo 'plan' = NULL → usar relación
     * Sistema LEGACY: plan_id = NULL, campo 'plan' tiene texto → usar campo legacy
     * 
     * @return string
     */
    public function getPlanNombreAttribute(): string
    {
        // Sistema NUEVO: Si plan_id está presente → usar relación con tabla plans
        if ($this->plan_id && $this->plan) {
            return $this->plan->name ?? 'Plan #' . $this->plan_id;
        }

        // Sistema LEGACY: Si campo 'plan' tiene texto (no numérico) → usar legacy
        if (!empty($this->attributes['plan']) && !is_numeric($this->attributes['plan'])) {
            return $this->attributes['plan'];
        }

        return 'Sin plan';
    }

    /**
     * Obtener el monto calculado con lógica de fallback
     *
     * Sistema NUEVO:  plan_id presente → price del plan × multiplicador de período
     * Sistema LEGACY: campo 'plan' numérico → usar ese valor directamente
     *
     * @return float
     */
    public function getMontoCalculadoAttribute(): float
    {
        // Sistema NUEVO: calcular desde la relación con plans
        if ($this->plan_id && $this->plan) {
            $precioUnitario = (float) ($this->plan->price ?? 0);

            $multiplicador = 1;
            if ($this->cobro && $this->cobro->periodo) {
                $multiplicador = match ($this->cobro->periodo) {
                    'BIMENSUAL'  => 2,
                    'TRIMESTRAL' => 3,
                    'SEMESTRAL'  => 6,
                    'ANUAL'      => 12,
                    default      => 1,
                };
            }

            return $precioUnitario * $multiplicador;
        }

        // Sistema LEGACY: si campo 'plan' era numérico (guardaba el monto)
        if (!empty($this->attributes['plan']) && is_numeric($this->attributes['plan'])) {
            return (float) $this->attributes['plan'];
        }

        return 0.0;
    }


    // Scopes para facturación
    public function scopeSinFacturar($query)
    {
        return $query->whereNull('venta_id')->whereNull('recibo_id');
    }

    public function scopeFacturado($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('venta_id')->orWhereNotNull('recibo_id');
        });
    }

    public function scopePagado($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('venta_id')->orWhereNotNull('recibo_id');
        });
    }

    public function scopeFacturadosPendientesPago($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('venta_id')->orWhereNotNull('recibo_id');
        })
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
