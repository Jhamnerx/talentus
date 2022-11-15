<?php

namespace App\Models;

use App\Enums\LineasStatus;
use App\Scopes\EmpresaScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lineas extends Model
{
    use HasFactory;
    // protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $guarded = array();


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
}
