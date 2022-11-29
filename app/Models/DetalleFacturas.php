<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFacturas extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_facturas';

    protected $casts = [
        'cantidad' => 'float',
    ];
    //Relacion uno a muchos inversa

    public function facturas()
    {
        return $this->belongsTo(Facturas::class, 'facturas_id');
    }
}
