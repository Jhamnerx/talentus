<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flotas extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'flotas';
    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
        static::addGlobalScope(new EliminadoScope);
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withoutGlobalScope(EliminadoScope::class, ActiveScope::class);
    }
    //relacion uno a muchos

    public function vehiculos()
    {
        return $this->hasMany(Vehiculos::class, 'flotas_id');
    }

    //relacion uno a muchos

    public function contactos()
    {
        return $this->hasMany(Contactos::class, 'flotas_id');
    }


    //Relacion uno A UNO POLIMORFICA

    public function delete()
    {

        return $this->morphMany(Eliminados::class, 'delete');
    }
}
