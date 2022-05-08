<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;



    protected $table = 'categorias';

    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    //relacion uno a muchos

    public function productos()
    {
        return $this->hasMany(Productos::class, 'categoria_id');
    }



    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        static::addGlobalScope(new EliminadoScope);
        static::addGlobalScope(new EmpresaScope);
    }
}
