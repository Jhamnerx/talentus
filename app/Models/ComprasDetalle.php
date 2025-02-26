<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComprasDetalle extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_compras';

    protected $casts = [
        'id' => 'integer',
        'compra_id' => 'integer',
        'producto_id' => 'integer',
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

    public function producto(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Productos::class, 'producto_id', 'id');
    }
}
