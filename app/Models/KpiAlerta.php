<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiAlerta extends Model
{
    use HasFactory;

    protected $table = 'kpi_alertas';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'resuelto'    => 'boolean',
        'resuelto_at' => 'datetime',
    ];

    public function kpi(): BelongsTo
    {
        return $this->belongsTo(Kpi::class);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class)->withoutGlobalScope(EmpresaScope::class);
    }

    public function nivelCss(): string
    {
        return match ($this->nivel) {
            'info'        => 'bg-blue-100 text-blue-700',
            'advertencia' => 'bg-amber-100 text-amber-700',
            'critico'     => 'bg-red-100 text-red-700',
            default       => 'bg-gray-100 text-gray-700',
        };
    }
}
