<?php

namespace App\Models;

use App\Enums\ChsCategoria;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChsHistorico extends Model
{
    use HasFactory;

    protected $table = 'chs_historico';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'periodo' => 'date',
        'score_final' => 'integer',
        'categoria' => ChsCategoria::class,
        'factores_detalle' => 'array',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }
}
