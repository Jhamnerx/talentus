<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Database\Factories\ContactosFlotasFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ContactosFlotasFactory::new();
    }

    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'contacto_flotas';
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

    public function flotas()
    {
        return $this->belongsTo(Flotas::class, 'flotas_id')->withoutGlobalScope(EliminadoScope::class);
    }
}
