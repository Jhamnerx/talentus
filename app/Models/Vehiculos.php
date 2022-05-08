<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculos extends Model
{
    use HasFactory;
    protected $table = 'vehiculos';
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
    //relacion uno a muchos a modelos
    public function lineas()
    {
        return $this->belongsTo(SimCard::class, 'numero')->withoutGlobalScope(EliminadoScope::class);
    }
    //relacion uno a muchos a modelos dispositivos
    public function modelos_dispositivos()
    {
        return $this->belongsTo(ModelosDispositivo::class, 'modelos_dispositivos_id')->withoutGlobalScope(EliminadoScope::class);
    }
    //relacion uno a muchos a dispositivos
    public function dispositivos()
    {
        return $this->belongsTo(Dispositivos::class);
    }
    //relacion uno a muchos a reportes
    public function reportes()
    {
        return $this->hasMany(Reportes::class, 'vehiculos_id');
    }
    //relacion uno a muchos a actas
    public function actas()
    {
        return $this->hasMany(Actas::class, 'vehiculos_id');
    }
    //relacion uno a muchos a actas
    public function cert_velocimetros()
    {
        return $this->hasMany(CertificadosVelocimetros::class, 'vehiculos_id');
    }
}
