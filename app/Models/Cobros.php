<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cobros extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;
    use SoftDeletes;

    protected $table = 'cobros';
    protected $casts = [

        'fecha_vencimiento' => 'date:Y/m/d',

    ];



    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withTrashed();
    }

    public function vehiculos(){
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed();
    }
}
