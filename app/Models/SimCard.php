<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    use HasFactory;
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
}
