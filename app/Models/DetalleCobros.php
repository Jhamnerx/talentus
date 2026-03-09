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
        'plan_id' => 'integer',
        'fecha' => 'date:Y-m-d',
        'fecha_facturado' => 'date:Y-m-d',
        'fecha_facturacion' => 'date:Y-m-d',
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'estado' => 'boolean',
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
     * Alias sin conflicto de nombre de columna.
     * Usar este método cuando se necesite la relación Eloquent con Plan,
     * ya que la columna legacy 'plan' en la tabla oculta la relación magic.
     */
    public function planModel()
    {
        return $this->belongsTo(\App\Models\Plan::class, 'plan_id');
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
        // Sistema NUEVO: Si plan_id está presente → usar relación planModel (sin conflicto de columna)
        if ($this->plan_id) {
            $plan = $this->relationLoaded('planModel')
                ? $this->getRelation('planModel')
                : $this->planModel()->first();
            if ($plan) {
                return $plan->name ?? 'Plan #' . $this->plan_id;
            }
        }

        // Sistema LEGACY: Si campo 'plan' tiene texto (no numérico) → usar legacy
        if (!empty($this->attributes['plan']) && !is_numeric($this->attributes['plan'])) {
            return $this->attributes['plan'];
        }

        return 'Sin plan';
    }

    /**
     * Monto bruto (con IGV incluido), SOLO USO INTERNO.
     * Las vistas deben usar monto_efectivo, que ya incluye la conversión de divisa y el ajuste RECIBO.
     *
     * Sistema NUEVO:  monto_unidad guardado → lo retorna directamente
     * Sistema NUEVO:  plan_id sin monto_unidad → price del plan × multiplicador de período
     * Sistema LEGACY: campo 'plan' numérico → usar ese valor directamente
     *
     * @internal Usar monto_efectivo en vistas y reportes
     * @return float
     */
    public function getMontoCalculadoAttribute(): float
    {
        // Prioridad 1: monto_unidad guardado (incluye conversión de divisa y ajuste RECIBO)
        // Se guarda al crear/editar el cobro con el importe ya calculado para la divisa del cobro
        if (!empty($this->attributes['monto_unidad']) && (float) $this->attributes['monto_unidad'] > 0) {
            return (float) $this->attributes['monto_unidad'];
        }

        // Prioridad 2 (fallback): calcular desde la relación con plans (precio base en PEN)
        // Se usa planModel() para evitar el conflicto con la columna legacy 'plan'
        if ($this->plan_id) {
            $plan = $this->relationLoaded('planModel')
                ? $this->getRelation('planModel')
                : $this->planModel()->first();

            if ($plan) {
                $precioUnitario = (float) ($plan->price ?? 0);

                $multiplicador = match ($this->periodo ?? 'MENSUAL') {
                    'BIMENSUAL'  => 2,
                    'TRIMESTRAL' => 3,
                    'SEMESTRAL'  => 6,
                    'ANUAL'      => 12,
                    default      => 1,
                };

                return $precioUnitario * $multiplicador;
            }
        }

        // Sistema LEGACY: si campo 'plan' era numérico (guardaba el monto)
        if (!empty($this->attributes['plan']) && is_numeric($this->attributes['plan'])) {
            return (float) $this->attributes['plan'];
        }

        return 0.0;
    }

    /**
     * Monto efectivo a cobrar al cliente.
     *
     * Si monto_unidad ya está guardado, ya contiene el ajuste de divisa y RECIBO.
     * Si viene del fallback de plan (precio en PEN), aplicar descuento RECIBO si corresponde.
     */
    public function getMontoEfectivoAttribute(): float
    {
        // Si monto_unidad está guardado, ya es el importe final (conversión + RECIBO incluidos)
        if (!empty($this->attributes['monto_unidad']) && (float) $this->attributes['monto_unidad'] > 0) {
            return (float) $this->attributes['monto_unidad'];
        }

        // Fallback: calcular desde plan y aplicar RECIBO si corresponde
        $monto = $this->monto_calculado;

        if (
            $monto > 0
            && $this->cobro
            && $this->cobro->tipo_pago === 'RECIBO'
        ) {
            return round($monto / 1.18, 2);
        }

        return $monto;
    }
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

    // Atributo personalizado para obtener los detalles vencidos
    public function scopeVencidos($query)
    {
        return $query->where('fecha', '<', Carbon::now());
    }
}
