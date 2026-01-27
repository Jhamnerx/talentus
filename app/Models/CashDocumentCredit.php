<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo para registrar documentos vendidos a crédito en la caja
 * Estos documentos no afectan el saldo inmediato de la caja
 */
class CashDocumentCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_id',
        'factura_id',
        'recibo_id',
        'venta_id',
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

    /**
     * Obtiene el documento asociado
     */
    public function getDocumento()
    {
        return $this->factura ?? $this->recibo ?? $this->venta;
    }

    /**
     * Scope para obtener créditos de una caja específica
     */
    public function scopeByCash($query, $cashId)
    {
        return $query->where('cash_id', $cashId);
    }
}
