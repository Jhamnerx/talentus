<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wig extends Model
{
    use HasFactory;

    protected $table = 'wigs';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'meta'         => 'decimal:2',
        'valor_actual' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class)->withoutGlobalScope(EmpresaScope::class);
    }

    /**
     * Porcentaje de cumplimiento del WIG
     */
    public function getPorcentajeAttribute(): float
    {
        if ($this->meta <= 0) {
            return 0;
        }
        return round(min(($this->valor_actual / $this->meta) * 100, 100), 1);
    }

    /**
     * Semáforo del WIG basado en porcentaje
     */
    public function getSemaforoAttribute(): string
    {
        $pct = $this->porcentaje;
        if ($pct >= 97) {
            return 'verde';
        }
        if ($pct >= 80) {
            return 'amarillo';
        }
        return 'rojo';
    }

    /**
     * Clases CSS del semáforo
     */
    public function getSemaforoCssAttribute(): string
    {
        return match ($this->semaforo) {
            'verde'    => 'bg-emerald-500',
            'amarillo' => 'bg-amber-500',
            'rojo'     => 'bg-red-500',
            default    => 'bg-gray-400',
        };
    }
}
