<?php

namespace App\Models;


use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;
    use SoftDeletes;



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

    public function changes()
    {

        return $this->morphMany(ChangesModels::class, 'changes');
    }

    public function cambios(){
        return $this->hasMany(ChangesModels::class, 'change_id');
    }

    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
       // static::addGlobalScope(new EliminadoScope);
        static::addGlobalScope(new EmpresaScope);
    }
    public function getKey() {
        return $this->id;
    }
}
