<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivos extends Model
{
    use HasFactory;


    public const VENDIDO = 'VENDIDO';
    public const STOCK = 'STOCK';
    public const IS_EMPRESA = 0;


    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'dispositivos';


    //LOCAL SCOPES
    public function scopeVendido($query)
    {
        return $query->where('estado', '=', $this::VENDIDO);
    }

    public function scopeStock($query)
    {
        return $query->where('estado', '=', $this::STOCK);
    }

    public function scopeEmpresa($query)
    {
        return $query->where('of_client', '=', $this::IS_EMPRESA);
    }

    public function scopeModelo($query, $modelo)
    {
        return $query->where('modelo_id', '=', $modelo);
    }
    //GLOBAL SCOPES
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    //Relacion uno a muchos inversa

    public function modelo()
    {
        return $this->belongsTo(ModelosDispositivo::class, 'modelo_id');
    }
    public function vehiculos()
    {
        return $this->hasOne(Vehiculos::class)->withoutGlobalScope(EliminadoScope::class)->withoutGlobalScope(EliminadoScope::class);
    }
    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'dispositivos_id');
    }
}
