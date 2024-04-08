<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detracciones extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'detracciones';


    protected $casts = [
        'id' => 'integer',
        'metodo_pago_id' => 'integer',
        'venta_id' => 'integer',
        'porcentaje' => 'decimal:4',
        'monto' => 'decimal:4',
        'cuenta_bancaria' => 'string',
    ];
}
