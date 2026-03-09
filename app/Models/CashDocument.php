<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo para relacionar documentos con cajas
 * Soporta múltiples tipos de documentos (facturas, recibos, ventas, gastos, compras, etc.)
 */
class CashDocument extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cash_id',
        // 'factura_id', // Campo existe en DB por compatibilidad con FactuPRO, pero NO se usa en Talentus
        'recibo_id',
        'venta_id',
        'expense_payment_id',
        'compra_id',
        'cotizacion_id',
        'orden_trabajo_id',
    ];

    // Relaciones
    public function cash(): BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }

    public function recibo(): BelongsTo
    {
        return $this->belongsTo(Recibos::class);
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Ventas::class);
    }

    /**
     * Pago de gasto asociado (ahora implementado)
     */
    public function expensePayment(): BelongsTo
    {
        return $this->belongsTo(ExpensePayment::class);
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compras::class);
    }

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizaciones::class);
    }

    public function ordenTrabajo(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'orden_trabajo_id');
    }

    /**
     * Obtiene el documento asociado (cualquiera que no sea null)
     * Nota: En Talentus NO existe modelo Factura, solo Recibos y Ventas
     * 
     * @return Model|null
     */
    public function getDocumento()
    {
        return $this->recibo
            ?? $this->venta
            ?? $this->expensePayment
            ?? $this->compra
            ?? $this->cotizacion
            ?? $this->ordenTrabajo;
    }

    /**
     * Obtiene el tipo de documento
     * 
     * @return string|null
     */
    public function getTipoDocumento(): ?string
    {
        // Campo factura_id existe en DB pero NO se usa en Talentus
        if ($this->recibo_id) return 'Recibo';
        if ($this->venta_id) return 'Venta';
        if ($this->expense_payment_id) return 'Gasto';
        if ($this->compra_id) return 'Compra';
        if ($this->cotizacion_id) return 'Cotización';
        if ($this->orden_trabajo_id) return 'Orden de Trabajo';

        return null;
    }

    /**
     * Scope para obtener solo documentos de ingresos
     */
    public function scopeIngresos($query)
    {
        return $query->where(function ($q) {
            // Solo recibos y ventas son ingresos en Talentus (factura_id no se usa)
            $q->whereNotNull('recibo_id')
                ->orWhereNotNull('venta_id');
        });
    }

    /**
     * Scope para obtener solo documentos de egresos
     */
    public function scopeEgresos($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('expense_payment_id')
                ->orWhereNotNull('compra_id');
        });
    }
}
