<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelosDispositivo extends Model
{
    use HasFactory;
    protected $table = 'modelos_dispositivos';


    //relacion uno a muchos

    public function dipositivo()
    {
        return $this->hasMany(Dispositivos::class, 'modelo_id');
    }
    //Relacion uno A UNO POLIMORFICA

    public function image()
    {

        return $this->morphOne(Imagen::class, 'imageable');
    }
    public function vehiculos()
    {
        return $this->hasMany(Vehiculos::class, 'modelos_dispositivos_id');
    }
}
