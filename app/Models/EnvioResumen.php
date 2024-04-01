<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class EnvioResumen extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'envio_resumen';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    protected function clase(): Attribute
    {
        return new Attribute(
            get: fn ($nota) => unserialize($nota),
            set: fn ($nota) => serialize($nota),
        );
    }

    public function envioResumenDetalles(): HasMany
    {
        return $this->hasMany(EnvioResumenDetalle::class);
    }

    public function ventas(): HasOne
    {
        return $this->hasOne(Ventas::class, 'id_baja');
    }
}
