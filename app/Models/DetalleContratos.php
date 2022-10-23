<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleContratos extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_contratos';



    //Relacion muchos a muchos

    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id');
    }


    //Relacion uno a muchos inversa

    public function contratos()
    {
        return $this->belongsTo(Contratos::class, 'contratos_id')->withoutGlobalScope(EliminadoScope::class);
    }
}
