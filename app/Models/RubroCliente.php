<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RubroCliente extends Model
{
    protected $table = 'rubros_cliente';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'empresa_id' => 'integer',
        'is_active'  => 'boolean',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);

        static::creating(function (self $rubro) {
            $rubro->empresa_id = session('empresa');
        });
    }

    public function scopeActivos($query)
    {
        return $query->where('is_active', true)->orderBy('nombre');
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(Clientes::class, 'rubro_id');
    }
}
