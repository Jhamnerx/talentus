<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
