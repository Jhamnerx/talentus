<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detracciones extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detracciones';


    protected $casts = [
        'id' => 'integer',
        'metodo_pago_id' => 'string',
        'venta_id' => 'integer',
        'porcentaje' => 'decimal:4',
        'monto' => 'decimal:4',
        'cuenta_bancaria' => 'string',
    ];


    public function venta(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Ventas::class);
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(PaymentMethods::class, 'metodo_pago_id', 'codigo');
    }

    public function codigo(): BelongsTo
    {
        return $this->belongsTo(CodigosDetracciones::class, 'codigo_detraccion', 'codigo');
    }
}
