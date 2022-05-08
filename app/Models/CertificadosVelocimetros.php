<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Database\Factories\CertificadosVelocimetrosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificadosVelocimetros extends Model
{
    //Definir Factory
    protected static function newFactory()
    {
        return CertificadosVelocimetrosFactory::new();
    }

    use HasFactory;
    protected $table = 'certificados_velocimetros';

    //Relacion uno a muchos inversa


    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EliminadoScope::class);
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
