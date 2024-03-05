<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tipoTareas extends Model
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

    protected $casts = [
        'id' => 'integer',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];
    //relacion tareas

    public function tareas()
    {
        return $this->hasMany(Tareas::class, 'tipo_tarea_id');
    }
}
