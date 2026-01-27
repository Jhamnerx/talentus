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
        'factura_id',
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

    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

    public function recibo(): BelongsTo
    {
        return $this->belongsTo(Recibos::class);
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Ventas::class);
    }

    public function expensePayment(): BelongsTo
    {
        return $this->belongsTo(ExpensePayment::class);
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class);
    }

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function ordenTrabajo(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'orden_trabajo_id');
    }

    /**
     * Obtiene el documento asociado (cualquiera que no sea null)
     * 
     * @return Model|null
     */
    public function getDocumento()
    {
        return $this->factura
            ?? $this->recibo
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
        if ($this->factura_id) return 'Factura';
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
            $q->whereNotNull('factura_id')
                ->orWhereNotNull('recibo_id')
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
