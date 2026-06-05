<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiResultado extends Model
{
    use HasFactory;

    protected $table = 'kpi_resultados';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'periodo_inicio' => 'date',
        'periodo_fin'    => 'date',
        'valor_actual'   => 'decimal:2',
        'valor_meta'     => 'decimal:2',
        'cumplimiento'   => 'decimal:2',
        'calculado_at'   => 'datetime',
    ];

    public function kpi(): BelongsTo
    {
        return $this->belongsTo(Kpi::class);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class)->withoutGlobalScope(EmpresaScope::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por')->withoutGlobalScope(EmpresaScope::class);
    }

    /**
     * Clases CSS del semáforo
     */
    public function semaforoCss(): string
    {
        return match ($this->semaforo) {
            'verde'    => 'bg-emerald-100 text-emerald-700 border-emerald-300',
            'amarillo' => 'bg-amber-100 text-amber-700 border-amber-300',
            'rojo'     => 'bg-red-100 text-red-700 border-red-300',
            default    => 'bg-gray-100 text-gray-700 border-gray-300',
        };
    }

    /**
     * Ícono del semáforo
     */
    public function semaforoIcono(): string
    {
        return match ($this->semaforo) {
            'verde'    => '✅',
            'amarillo' => '⚠️',
            'rojo'     => '🔴',
            default    => '⚪',
        };
    }
}
