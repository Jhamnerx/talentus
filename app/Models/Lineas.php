<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\LineasStatus;
use App\Scopes\EmpresaScope;
use App\Models\OldSimCardLinea;
use App\Observers\LineasObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(LineasObserver::class)]
class Lineas extends Model
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
    //protected $guarded = array();


    protected $casts = [

        'estado' => LineasStatus::class,
    ];



    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    // Scope local de activo
    public function scopeOperador($query, $operador)
    {
        return $query->where('operador', $operador);
    }

    public function sim_card()
    {

        return $this->hasOne(SimCard::class, 'lineas_id');
    }
    public function sim()
    {

        return $this->hasOne(SimCard::class, 'lineas_id');
    }

    public function cambios_old()
    {

        return $this->hasMany(CambiosLineas::class);
    }

    public function cambios_new()
    {

        return $this->hasMany(CambiosLineas::class, 'new_numero');
    }

    public function old_sim_cards()
    {

        return $this->hasMany(OldSimCardLinea::class, 'linea_id');
    }



    public function getFechaSuspencionAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value);
        } else {
            return $value;
        }
    }
    public function getDateToSuspendAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value);
        } else {
            return $value;
        }
    }
    public function getNowAttribute()
    {
        return Carbon::now();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'numero', 'numero')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }
}
