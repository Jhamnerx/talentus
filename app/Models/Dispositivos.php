<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use App\Observers\DispositivosObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(DispositivosObserver::class)]
class Dispositivos extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

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

    public function scopeMarca($query, $marca)
    {
        return $query->where('modelos_dispositivos.marca', '=', $marca);
    }
    //GLOBAL SCOPES
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    public static function asignarDispositivos(User $user, $items, GuiaRemision $guia)
    {

        $user->dispositivos()->attach(
            $items,
            [
                'guia_remision_id' => $guia->id,
                'user_id' => auth()->user()->id
            ]
        );
    }

    public static function updateAsignarDispositivos(User $user, $items, GuiaRemision $guia)
    {

        //$user->dispositivos()->sync([1 => ['guia_remision_id' => $guia->id], 2, 3]);
        $user->dispositivos()->syncWithPivotValues(
            $items,
            [
                'guia_remision_id' => $guia->id,
                'user_id' => auth()->user()->id,
            ]
        );
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
    // public function users()
    // {
    //     //return $this->belongsToMany(User::class, 'dispositivos_users', 'user_id', 'user_id', null, 'id');
    //     return $this->hasOne(User::class, 'user_id')->withoutGlobalScope(EmpresaScope::class);
    // }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_id')->withoutGlobalScope(EmpresaScope::class)->using(DispositivosUsers::class);
    }

    public function user()
    {
        //return $this->belongsToMany(User::class, 'dispositivos_users', 'user_id', 'user_id', null, 'id');
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion many to many guia
    public function guia()
    {
        return $this->belongsToMany(DispositivosUsers::class, 'dispositivos_users', 'guia_remision_id', 'imei')->using(DispositivosUsers::class);
    }
}
