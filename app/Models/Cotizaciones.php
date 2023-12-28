<?php

namespace App\Models;

use App\Models\CotizacionesDetalle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotizaciones extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'cotizaciones';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cliente_id' => 'integer',
        'fecha_emision' => 'date',
        'fecha_hora_emision' => 'datetime',
        'tipo_cambio' => 'decimal:2',
        'metodo_pago_id' => 'integer',
        'op_gravadas' => 'decimal:2',
        'op_exoneradas' => 'decimal:2',
        'op_inafectas' => 'decimal:2',
        'op_gratuitas' => 'decimal:2',
        'igv_op' => 'decimal:2',
        'descuento' => 'decimal:',
        'descuento_factor' => 'decimal:5',
        'icbper' => 'decimal:2',
        'igv' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'total' => 'decimal:2',
        'user_id' => 'integer',
    ];

    public function cotizacionesDetalles(): HasMany
    {
        return $this->hasMany(CotizacionesDetalle::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Clientes::class);
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id', 'codigo');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
