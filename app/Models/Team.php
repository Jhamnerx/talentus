<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Observers\TeamObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(TeamObserver::class)]
class Team extends Model
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

    // Áreas KPI del MOF: comercial | operaciones | administracion | postventa | monitoreo | gerencia
    public const KPI_AREAS = [
        'comercial'      => 'Comercial',
        'operaciones'    => 'Operaciones',
        'administracion' => 'Administración',
        'postventa'      => 'Post Venta & Reclamos',
        'monitoreo'      => 'Monitoreo GPS',
        'gerencia'       => 'Gerencia',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Global Scope Empresa
    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    // Relaciones
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user')
            ->withTimestamps()
            ->withPivot('role_in_team');
    }

    public function leaders(): BelongsToMany
    {
        return $this->users()->wherePivot('role_in_team', 'leader');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'team_id')->withoutGlobalScope(EmpresaScope::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
