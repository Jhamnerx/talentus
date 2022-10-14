<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelosDispositivo extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'modelos_dispositivos';

    protected $appends = ['porcentaje'];

    //LOCAL SCOPES


    // protected function getPorcentaje()
    // {
    //     $porcentaje = ($this->dispositivo()->vendido()->empresa()->get()->count() * 100) / $this->dispositivo()->empresa()->get()->count();
    //     return $porcentaje;
    // }


    protected function porcentaje(): Attribute
    {

        $total = (int) $this->dispositivo()->empresa()->get()->count();
        $vendidos = (int) $this->dispositivo()->vendido()->empresa()->get()->count();

        if ($vendidos == 0) {
            $porcentaje = 0;
        } else {
            $porcentaje = number_format(($vendidos / $total) * 100, 2);
        }



        return new Attribute(
            get: fn () => $porcentaje,
        );
    }

    //relacion uno a muchos


    public function dispositivo()
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
