<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\WorkOrderTypeCost;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderType extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'requiere_imei' => 'boolean',
        'requiere_sim' => 'boolean',
        'requiere_accesorios' => 'boolean',
        'requiere_checklist' => 'boolean',
        'active' => 'boolean',
        'es_mantenimiento_programado' => 'boolean',
        'muestra_sector' => 'boolean',
        'muestra_plan' => 'boolean',
        'muestra_accesorios_instalar' => 'boolean',
        'costo_base' => 'decimal:2',
    ];

    // Global Scope - Multi-empresa
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    // Relaciones
    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function costs(): HasMany
    {
        return $this->hasMany(WorkOrderTypeCost::class);
    }

    /**
     * Devuelve el costo específico para un técnico, o null si no tiene costo especial.
     */
    public function costoParaTecnico(?int $tecnicoId): ?float
    {
        if (!$tecnicoId) {
            return null;
        }

        $registro = $this->costs->isNotEmpty()
            ? $this->costs->firstWhere('tecnico_id', $tecnicoId)
            : WorkOrderTypeCost::withoutGlobalScope(\App\Scopes\EmpresaScope::class)
            ->where('work_order_type_id', $this->id)
            ->where('tecnico_id', $tecnicoId)
            ->first();

        return $registro ? (float) $registro->costo : null;
    }

    /**
     * Costo resuelto: usa el costo del técnico si existe, sino el costo_base.
     */
    public function costoResuelto(?int $tecnicoId): float
    {
        return $this->costoParaTecnico($tecnicoId) ?? (float) $this->costo_base;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeMantenimientoProgramado($query)
    {
        return $query->where('es_mantenimiento_programado', true);
    }
}
