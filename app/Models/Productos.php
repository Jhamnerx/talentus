<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Productos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'productos';

    protected $guarded = ['id', 'created_at', 'updated_at'];


    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    public function scopeVelocimetro($query)
    {
        return $query->whereHas('categoria', function ($query) {
            $query->where('nombre', 'like', '%VELOCIMETROS DIGITALES%');
        });
    }

    // GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    //Relacion uno a muchos inversa

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id')->withTrashed();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_code');
    }


    //Relacion uno a muchos inversa

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    //Relacion uno A UNO POLIMORFICA

    public function image()
    {

        return $this->morphOne(Imagen::class, 'imageable');
    }
}
