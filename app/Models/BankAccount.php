<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    protected $fillable = [
        'bank_id',
        'description',
        'number',
        'cci',
        'currency_type_id',
        'status',
        'initial_balance',
        'show_in_documents',
        'establishment_id',
    ];

    protected $casts = [
        'bank_id' => 'integer',
        'status' => 'boolean',
        'show_in_documents' => 'boolean',
        'initial_balance' => 'decimal:2',
        'establishment_id' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeVisibleInDocuments($query)
    {
        return $query->where('show_in_documents', true);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function getCurrencySymbolAttribute(): string
    {
        return match ($this->currency_type_id) {
            'USD' => '$',
            'PEN' => 'S/',
            default => '',
        };
    }

    public function getCurrencyNameAttribute(): string
    {
        return match ($this->currency_type_id) {
            'USD' => 'Dólares',
            'PEN' => 'Soles',
            default => $this->currency_type_id,
        };
    }
}
