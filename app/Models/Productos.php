<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Productos extends Model
{
    use HasFactory;



    protected $table = 'productos';

    protected $guarded = ['id', 'created_at', 'updated_at'];


    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
        static::addGlobalScope(new EliminadoScope);
    }


    //Relacion uno a muchos inversa

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id')->withoutGlobalScope(EliminadoScope::class);
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
