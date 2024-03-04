<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCobros extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalles_cobros';




    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class);
    }

    //Relacion uno a muchos inversa

    public function cobro()
    {
        return $this->belongsTo(Cobros::class, 'cobros_id')->withTrashed();
    }
}
