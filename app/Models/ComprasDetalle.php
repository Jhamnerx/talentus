<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComprasDetalle extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'compras_detalle';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'compra_id' => 'integer',
        'cantidad' => 'decimal:2',
        'valor_unitario' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'icbper' => 'decimal:2',
        'igv' => 'decimal:2',
        'descuento' => 'decimal:',
        'descuento_factor' => 'decimal:5',
        'valor_total' => 'decimal:2',
        'importe_total' => 'decimal:2',
    ];

    public function compra(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Compras::class);
    }
}
