<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;


    protected $table = 'empresas';


    //relacion uno a muchos

    public function producto()
    {
        return $this->hasMany(Productos::class, 'empresa_id');
    }

    //relacion uno a muchos

    public function clientes()
    {
        return $this->hasMany(Clientes::class, 'empresa_id');
    }
    //relacion uno a muchos

    public function plantilla()
    {
        return $this->hasOne(plantilla::class, 'empresas_id');
    }
    //Relacion polimorfica



    public function categoriable()
    {

        return $this->morphTo();
    }
}
