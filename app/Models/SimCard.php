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
}
