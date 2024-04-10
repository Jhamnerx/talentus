<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SimCard extends Model
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

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'sim_card';


    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    //relacion uno a muchos

    public function vehiculos()
    {
        return $this->hasOne(Vehiculos::class, 'sim_card_id');
    }

    public function linea()
    {
        return $this->belongsTo(Lineas::class, 'lineas_id');
    }

    //relacion uno a muchos

    public function cambios()
    {
        return $this->hasMany(CambiosLineas::class, 'sim_card');
    }

    //relacion many to many
    public function users()
    {

        return $this->hasOne(User::class, 'user_id')->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion many to many guia
    public function guia()
    {
        return $this->belongsToMany(SimCardUsers::class, 'sim_card_users', 'guia_remision_id', 'sim_card')->using(SimCardUsers::class);
    }

    public static function asignarSimCard(User $user, $items, GuiaRemision $guia)
    {

        $user->sim_cards()->attach(
            $items,
            [
                'guia_remision_id' => $guia->id,
                'user_id' => auth()->user()->id
            ]
        );
    }

    public static function updateAsignarSimCard(User $user, $items, GuiaRemision $guia)
    {

        //$user->dispositivos()->sync([1 => ['guia_remision_id' => $guia->id], 2, 3]);
        $user->sim_cards()->syncWithPivotValues(
            $items,
            [
                'guia_remision_id' => $guia->id,
                'user_id' => auth()->user()->id
            ]
        );
    }
}
