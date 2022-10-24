<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Database\Factories\ContactosFlotasFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactos extends Model
{

    protected static function newFactory()
    {
        return ContactosFlotasFactory::new();
    }

    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'contactos';


    protected $casts = [
        'is_gerente' => 'boolean',
    ];

    // Scope local de activo
    public function scopeGerente($query, $value)
    {
        return $query->where('is_gerente', $value);
    }

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }
}
