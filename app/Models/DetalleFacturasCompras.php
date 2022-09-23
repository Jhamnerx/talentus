<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFacturasCompras extends Model
{
    use HasFactory;

    protected $table = 'detalle_compras';
    protected $guarded = ['id', 'created_at', 'updated_at'];


    //Relacion uno a muchos inversa a facturas compras

    public function facturas()
    {

        return $this->belongsTo(ComprasFacturas::class, 'facturas_id');
    }
}
