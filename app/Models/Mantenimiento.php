<?php

namespace App\Models;

use App\Enums\mantenimientoStatus;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mantenimiento extends Model
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
    protected $table = 'mantenimientos';

    protected $casts = [
        'fecha_hora_mantenimiento' => 'date',
        'estado' => mantenimientoStatus::class,
    ];

    //Relacion uno a muchos inversa
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tareas::class, 'mantenimiento_id')->withoutGlobalScope(EmpresaScope::class);
    }
}
