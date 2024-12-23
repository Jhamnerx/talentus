<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use App\Observers\FlotasObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(FlotasObserver::class)]
class Flotas extends Model
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

    protected $table = 'flotas';

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }
    //relacion uno a muchos

    // public function vehiculos()
    // {
    //     return $this->hasMany(Vehiculos::class, 'flotas_id');
    // }
    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculos::class, 'vehiculos_flotas', 'flotas_id', 'vehiculos_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }


    //Relacion uno A UNO POLIMORFICA

    // public function delete()
    // {

    //     return $this->morphMany(Eliminados::class, 'delete');
    // }
}
