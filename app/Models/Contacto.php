<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Contacto extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'mensajes_contacto';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'message',
        'ip_address',
        'user_agent',
        'leido',
        'fecha_leido',
    ];

    protected $casts = [
        'leido' => 'boolean',
        'fecha_leido' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone', 'company', 'message', 'leido'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Marcar como leído
     */
    public function marcarComoLeido(): void
    {
        $this->update([
            'leido' => true,
            'fecha_leido' => now(),
        ]);
    }
}
