<?php

declare(strict_types=1);

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceMaintenance extends Model
{
    use HasFactory;
    use SoftDeletes;

    const TIPO_MANTENIMIENTO = 'mantenimiento';
    const TIPO_SUSPENSION    = 'suspension';
    const TIPO_REACTIVACION  = 'reactivacion';

    const SOURCE_MANUAL   = 'manual';
    const SOURCE_TRACKING = 'tracking';

    protected $table = 'device_maintenances';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha' => 'date',
    ];

    // ── Global Scope ──────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    // ── Relaciones ────────────────────────────────────────────────────────────

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id')->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeOfTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeFromTracking($query)
    {
        return $query->where('source', self::SOURCE_TRACKING);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            self::TIPO_SUSPENSION   => 'Suspensión',
            self::TIPO_REACTIVACION => 'Reactivación',
            default                 => 'Mantenimiento',
        };
    }

    public function getTipoBadgeColorAttribute(): string
    {
        return match ($this->tipo) {
            self::TIPO_SUSPENSION   => 'red',
            self::TIPO_REACTIVACION => 'green',
            default                 => 'blue',
        };
    }
}
