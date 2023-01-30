<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRecibosPagos extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_recibos_pagos';
    protected $casts = [
        'cantidad' => 'float',
    ];
    //Relacion uno a muchos inversa

    public function recibos()
    {
        return $this->belongsTo(RecibosPagosVarios::class, 'recibos_id');
    }
}
