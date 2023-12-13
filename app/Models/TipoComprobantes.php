<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoComprobantes extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'tipo_comprobantes';

    public function compras(): HasMany
    {
        return $this->hasMany(Compras::class);
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Ventas::class);
    }

    public function notaCreditos(): HasMany
    {
        return $this->hasMany(NotaCredito::class);
    }

    public function notaDebitos(): HasMany
    {
        return $this->hasMany(NotaDebito::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class, 'tipo_comprobante_id', 'codigo');
    }
}
