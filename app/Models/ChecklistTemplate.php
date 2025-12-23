<?php

namespace App\Models;

use App\Enums\ChecklistCategoria;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistTemplate extends Model
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
        'categoria' => ChecklistCategoria::class,
        'requiere_foto' => 'boolean',
        'is_active' => 'boolean',
        'orden' => 'integer',
    ];

    // Global Scope - Multi-empresa
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    // Relaciones
    public function workOrderChecklists(): HasMany
    {
        return $this->hasMany(WorkOrderChecklist::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('orden')->orderBy('nombre');
    }
}
