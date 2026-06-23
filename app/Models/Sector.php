<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    protected $table = 'sectores';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'empresa_id' => 'integer',
        'is_active'  => 'boolean',
        'orden'      => 'integer',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);

        static::creating(function (self $sector) {
            $sector->empresa_id = session('empresa');
        });
    }

    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('orden')->orderBy('nombre');
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function vehiculos(): BelongsToMany
    {
        return $this->belongsToMany(Vehiculos::class, 'sector_vehiculo', 'sector_id', 'vehiculo_id');
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(Clientes::class, 'sector_id');
    }
}
