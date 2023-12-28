<?php

namespace App\Models;

use App\Models\Compras;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MetodoPago extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'metodo_pago';

    public function compras(): HasMany
    {
        return $this->hasMany(Compras::class);
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Ventas::class);
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizaciones::class);
    }
}
