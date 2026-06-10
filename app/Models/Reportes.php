<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
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

    public const ESTADO_ABIERTA     = 1;
    public const ESTADO_EN_ATENCION = 2;
    public const ESTADO_CERRADA     = 3;

    public const ORIGEN_MANUAL = 'manual';
    public const ORIGEN_AUTO   = 'auto';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table   = 'reportes';

    protected $casts = [
        'fecha_t'              => 'date:Y/m/d',
        'fecha'                => 'date:Y/m/d',
        'atendido_at'          => 'datetime',
        'cerrado_at'           => 'datetime',
        'horas_sin_transmision' => 'float',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

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

    public function atendidoPor()
    {
        return $this->belongsTo(User::class, 'atendido_por');
    }

    public function getEstadoLabelAttribute(): string
    {
        return match ((int) $this->estado) {
            self::ESTADO_ABIERTA     => 'Abierta',
            self::ESTADO_EN_ATENCION => 'En atención',
            self::ESTADO_CERRADA     => 'Cerrada',
            default                  => 'Desconocido',
        };
    }

    public function getOrigenLabelAttribute(): string
    {
        return $this->origen === self::ORIGEN_AUTO ? 'Automática' : 'Manual';
    }

    public function scopeAbiertas($query)
    {
        return $query->where('estado', self::ESTADO_ABIERTA);
    }

    public function scopeEnAtencion($query)
    {
        return $query->where('estado', self::ESTADO_EN_ATENCION);
    }

    public function scopeCerradas($query)
    {
        return $query->where('estado', self::ESTADO_CERRADA);
    }
}
