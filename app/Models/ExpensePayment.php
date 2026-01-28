<?php

namespace App\Models;

use App\Observers\ExpensePaymentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

#[ObservedBy(ExpensePaymentObserver::class)]
class ExpensePayment extends Model
{
    use LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected $fillable = [
        'expense_id',
        'date_of_payment',
        'expense_method_type_id',
        'has_card',
        'card_brand_id',
        'reference',
        'payment',
    ];

    protected $casts = [
        'date_of_payment' => 'date',
        'has_card' => 'boolean',
        'payment' => 'decimal:2',
    ];

    /**
     * Gasto/Compra asociado al pago
     */
    public function expense(): BelongsTo
    {
        return $this->belongsTo(Compras::class, 'expense_id');
    }

    /**
     * Método de pago usado
     */
    public function expenseMethodType(): BelongsTo
    {
        return $this->belongsTo(ExpenseMethodType::class);
    }

    /**
     * Marca de tarjeta (si aplica)
     */
    public function cardBrand(): BelongsTo
    {
        return $this->belongsTo(CardBrand::class);
    }

    /**
     * Movimiento financiero global relacionado
     */
    public function globalPayment(): MorphOne
    {
        return $this->morphOne(GlobalPayment::class, 'payment');
    }

    /**
     * Verifica si el pago usa tarjeta
     */
    public function usesCard(): bool
    {
        return $this->has_card && $this->card_brand_id !== null;
    }

    /**
     * Obtiene el nombre del método de pago
     */
    public function getMethodNameAttribute(): string
    {
        return $this->expenseMethodType->description ?? 'Sin método';
    }

    /**
     * Obtiene descripción completa del pago
     */
    public function getFullDescriptionAttribute(): string
    {
        $desc = $this->method_name;

        if ($this->usesCard() && $this->cardBrand) {
            $desc .= ' - ' . $this->cardBrand->description;
        }

        if ($this->reference) {
            $desc .= ' - Ref: ' . $this->reference;
        }

        return $desc;
    }
}
