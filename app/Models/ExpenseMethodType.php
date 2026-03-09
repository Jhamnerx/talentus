<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseMethodType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'description',
        'has_card',
    ];

    protected $casts = [
        'has_card' => 'boolean',
    ];

    /**
     * Pagos de gastos que usan este método
     */
    public function expensePayments(): HasMany
    {
        return $this->hasMany(ExpensePayment::class);
    }

    /**
     * Verifica si el método requiere tarjeta
     */
    public function requiresCard(): bool
    {
        return $this->has_card;
    }

    /**
     * Verifica si es caja (ID 1)
     */
    public function isCash(): bool
    {
        return $this->id === 1;
    }

    /**
     * Verifica si es transferencia bancaria (ID 4)
     */
    public function isTransfer(): bool
    {
        return $this->id === 4;
    }
}
