<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    use HasFactory;

    protected $table = 'ciudades';

    //relacion uno a muchos

    public function actas()
    {
        return $this->hasMany(Actas::class, 'ciudades_id');
    }
    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'ciudades_id');
    }
    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
}
