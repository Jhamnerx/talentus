<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Spatie\Activitylog\LogOptions;
use App\Models\Admin\Recordatorios;
use App\Observers\ReportesObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ReportesObserver::class)]
class Reportes extends Model
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
    protected $table = 'reportes';


    protected $casts = [

        'fecha_t' => 'date:Y/m/d',
        'fecha' => 'date:Y/m/d',

    ];



    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    //relacion uno a muchos

    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }


    //relacion uno a muchos

    public function detalle()
    {
        return $this->hasMany(DetalleReportes::class, 'reportes_id');
    }

    public function recordatorios()
    {
        return $this->hasMany(Recordatorios::class, 'reportes_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
