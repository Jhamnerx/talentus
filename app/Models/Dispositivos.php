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


    public static function asignarDispositivos(User $user, $items, GuiaRemision $guia)
    {

        $user->dispositivos()->attach($items, ['guia_remision_id' => $guia->id]);
    }

    public static function updateAsignarDispositivos(User $user, $items, GuiaRemision $guia)
    {

        //$user->dispositivos()->sync([1 => ['guia_remision_id' => $guia->id], 2, 3]);
        $guia->dispositivos()->syncWithPivotValues($items, ['guia_remision_id' => $guia->id, 'user_id' => $user->id]);
    }



    //Relacion uno a muchos inversa

    public function modelo()
    {
        return $this->belongsTo(ModelosDispositivo::class, 'modelo_id')->withoutGlobalScope(EmpresaScope::class);
    }
    public function vehiculos()
    {
        return $this->hasOne(Vehiculos::class)->withoutGlobalScope(EmpresaScope::class);
    }
    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'dispositivos_id')->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion many to many dipositivos
    public function users()
    {
        //return $this->belongsToMany(User::class, 'dispositivos_users', 'user_id', 'user_id', null, 'id');
        return $this->hasOne(DispositivosUsers::class, 'user_id')->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion many to many guia
    public function guia()
    {
        return $this->belongsToMany(User::class, 'dispositivos_users', 'guia_remision_id', 'imei')->using(DispositivosUsers::class);
    }
}
