<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almacenes extends Model
{
    use HasFactory;

    protected $table = 'almacenes';

    protected $casts = [
        'id' => 'integer',
        'nombre' => 'string',
    ];

    use LogsActivity;
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    public function productos()
    {
        return $this->hasMany(Productos::class);
    }

    public function dispositivos()
    {
        return $this->hasMany(Dispositivos::class);
    }
}
