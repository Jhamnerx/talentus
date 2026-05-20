<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Operador;
use App\Casts\SafeEnumCast;
use App\Enums\LineasStatus;
use App\Scopes\EmpresaScope;
use App\Models\OldSimCardLinea;
use App\Observers\LineasObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(LineasObserver::class)]
class Lineas extends Model
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
    //protected $guarded = array();


    protected $casts = [
        'estado'   => LineasStatus::class,
    ];

    /** Si el número de línea está vinculado físicamente al chip (M2M, CUY, IOT). */
    public function getNumeroFijoAttribute(): bool
    {
        return $this->operador?->numero_fijo ?? false;
    }

    /** Si las líneas suspendidas se reactivarán automáticamente (solo CLARO). */
    public function getAutoReactivacionAttribute(): bool
    {
        return $this->operador?->have_api ?? false;
    }



    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    // Scope local de activo
    public function scopeOperador($query, $operador)
    {
        return $query->where('operador_id', $operador);
    }

    public function operador()
    {
        return $this->belongsTo(Operador::class, 'operador_id');
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

    public function old_sim_cards()
    {

        return $this->hasMany(OldSimCardLinea::class, 'linea_id');
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

    /**
     * Obtener días transcurridos desde la suspensión
     */
    public function getDiasSuspendidoAttribute()
    {
        if (!$this->fecha_suspencion) {
            return null;
        }

        return (int) abs(Carbon::now()->diffInDays($this->fecha_suspencion, false));
    }

    /**
     * Verificar si aún puede reactivarse sin costo
     */
    public function getPuedeReactivarseAttribute()
    {
        if (!$this->fecha_suspencion || !$this->date_to_suspend) {
            return false;
        }

        return Carbon::now()->lte($this->date_to_suspend);
    }

    /**
     * Días restantes para reactivación gratuita
     */
    public function getDiasRestantesReactivacionAttribute()
    {
        if (!$this->date_to_suspend) {
            return null;
        }

        $dias = Carbon::now()->diffInDays($this->date_to_suspend, false);
        return (int) ($dias >= 0 ? $dias : 0);
    }

    /**
     * Estado de suspensión legible
     */
    public function getEstadoSuspencionTextoAttribute()
    {
        if ($this->estado != 2) {
            return null;
        }

        $diasRestantes = $this->dias_restantes_reactivacion;

        if ($diasRestantes === null) {
            return 'Suspendida';
        }

        if ($diasRestantes > 30) {
            return 'Suspendida - Reactivable';
        } elseif ($diasRestantes > 7) {
            return 'Suspendida - ' . round($diasRestantes) . ' días para baja';
        } elseif ($diasRestantes > 0) {
            return '⚠️ Suspendida - ' . round($diasRestantes) . ' días críticos';
        } else {
            return '❌ Baja definitiva';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'numero', 'numero')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }
}
