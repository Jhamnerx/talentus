<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotaDebitoDetalle extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'nota_debito_detalle';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nota_debito_id' => 'integer',
        'producto_id' => 'integer',
        'valor_unitario' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'igv' => 'decimal:2',
        'porcentaje_igv' => 'decimal:2',
        'descuento' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'importe_total' => 'decimal:2',
    ];

    public function notaDebito(): BelongsTo
    {
        return $this->belongsTo(NotaDebito::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Productos::class);
    }
}
