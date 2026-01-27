<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo para registrar los pagos asociados a documentos en caja
 * Cada pago de un documento queda registrado individualmente
 */
class CashDocumentPayment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cash_id',
        'payment_id',
        'cash_document_id',
    ];

    // Relaciones
    public function cash(): BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payments::class);
    }

    public function cashDocument(): BelongsTo
    {
        return $this->belongsTo(CashDocument::class);
    }

    /**
     * Scope para obtener pagos de una caja específica
     */
    public function scopeByCash($query, $cashId)
    {
        return $query->where('cash_id', $cashId);
    }
}
