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
        'cash_id_processed',
        // 'factura_id', // Campo existe en DB por compatibilidad con FactuPRO, pero NO se usa en Talentus
        'recibo_id',
        'venta_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relaciones
    public function cash(): BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }

    public function cashProcessed(): BelongsTo
    {
        return $this->belongsTo(Cash::class, 'cash_id_processed');
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
     * Obtiene el documento asociado (Recibo o Venta)
     * Nota: En Talentus NO existe modelo Factura, solo Recibos y Ventas
     * El campo factura_id existe en la tabla pero NO se usa
     */
    public function getDocumento()
    {
        return $this->recibo ?? $this->venta;
    }

    /**
     * Verifica si el crédito está pendiente de pago
     */
    public function isPending(): bool
    {
        return $this->status === 'PENDING';
    }

    /**
     * Verifica si el crédito ya fue procesado
     */
    public function isProcessed(): bool
    {
        return $this->status === 'PROCESSED';
    }

    /**
     * Marca el crédito como procesado en una caja
     */
    public function markAsProcessed($cashId): void
    {
        $this->update([
            'cash_id_processed' => $cashId,
            'status' => 'PROCESSED',
        ]);
    }

    /**
     * Scope para obtener créditos pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    /**
     * Scope para obtener créditos procesados
     */
    public function scopeProcessed($query)
    {
        return $query->where('status', 'PROCESSED');
    }

    /**
     * Scope para obtener créditos de una caja específica
     */
    public function scopeByCash($query, $cashId)
    {
        return $query->where('cash_id', $cashId);
    }
}
