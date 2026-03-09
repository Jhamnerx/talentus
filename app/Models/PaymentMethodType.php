<?php

namespace App\Models;

use App\Scopes\EmpresaScope;

class PaymentMethodType extends ModelCatalog
{
    protected $table = "payment_method_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'description',
        'has_card',
        'number_days',
        'charge',
        'is_credit',
        'is_cash',
    ];

    protected $casts = [
        'active' => 'boolean',
        'has_card' => 'boolean',
        'number_days' => 'integer',
        'charge' => 'decimal:2',
        'is_credit' => 'boolean',
        'is_cash' => 'boolean',
    ];



    protected static function booted()
    {
        //
        static::addGlobalScope(new EmpresaScope);
    }



    /**
     * Verifica si el método es a crédito
     */
    public function isCredit(): bool
    {
        return $this->is_credit;
    }

    /**
     * Verifica si el método es efectivo
     */
    public function isCash(): bool
    {
        return $this->is_cash;
    }

    /**
     * Verifica si el método requiere tarjeta
     */
    public function hasCard(): bool
    {
        return $this->has_card;
    }

    /**
     * Obtiene los días de crédito
     */
    public function getCreditDays(): ?int
    {
        return $this->number_days;
    }

    /**
     * Obtiene el cargo/comisión
     */
    public function getCharge(): ?float
    {
        return $this->charge;
    }

    /**
     * Verifica si tiene cargo/comisión
     */
    public function hasCharge(): bool
    {
        return $this->charge !== null && $this->charge > 0;
    }
}
