<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kpi extends Model
{
    use HasFactory;

    protected $table = 'kpis';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'meta'       => 'decimal:2',
        'meta_minima' => 'decimal:2',
        'activo'     => 'boolean',
        'es_wig'     => 'boolean',
        'orden'      => 'integer',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class)->withoutGlobalScope(EmpresaScope::class);
    }

    public function resultados(): HasMany
    {
        return $this->hasMany(KpiResultado::class, 'kpi_id');
    }

    public function ultimoResultado(): HasMany
    {
        return $this->hasMany(KpiResultado::class, 'kpi_id')->latest('periodo_inicio')->limit(1);
    }

    public function alertas(): HasMany
    {
        return $this->hasMany(KpiAlerta::class, 'kpi_id');
    }

    /**
     * Área formateada para mostrar
     */
    public function areaNombre(): string
    {
        return match ($this->area) {
            'comercial'      => 'Comercial',
            'operaciones'    => 'Operaciones',
            'administracion' => 'Administración',
            'postventa'      => 'Postventa',
            'monitoreo'      => 'Monitoreo GPS',
            'gerencia'       => 'Gerencia',
            default          => ucfirst($this->area),
        };
    }

    /**
     * Color del área para UI
     */
    public function areaColor(): string
    {
        return match ($this->area) {
            'comercial'      => 'blue',
            'operaciones'    => 'orange',
            'administracion' => 'purple',
            'postventa'      => 'teal',
            'monitoreo'      => 'indigo',
            'gerencia'       => 'rose',
            default          => 'gray',
        };
    }
}
