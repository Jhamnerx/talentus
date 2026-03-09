<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $description
 * @property bool $active
 * @property-read \Illuminate\Database\Eloquent\Collection|ExpensePayment[] $expensePayments
 */
class CardBrand extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Pagos de gastos que usan esta marca de tarjeta
     */
    public function expensePayments(): HasMany
    {
        return $this->hasMany(ExpensePayment::class);
    }

    /**
     * Scope para marcas activas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Obtiene solo marcas activas
     */
    public static function getActive()
    {
        return self::where('active', true)->orderBy('description')->get();
    }
}
