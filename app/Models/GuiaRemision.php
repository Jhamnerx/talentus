<?php

namespace App\Models;

use App\Enums\ModalidadTraslado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuiaRemision extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'guia_remision';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cliente_id' => 'integer',
        'fecha_emision' => 'date',
        'venta_id' => 'integer',
        'fecha_inicio_traslado' => 'date',
        'user_id' => 'integer',
        'modalidad_traslado' => ModalidadTraslado::class,
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Clientes::class);
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Ventas::class);
    }

    public function motivoTraslado(): BelongsTo
    {
        return $this->belongsTo(MotivoTraslado::class, 'motivo_traslado_id', 'codigo');
    }

    public function modalidadTransporte(): BelongsTo
    {
        return $this->belongsTo(ModalidadTransporte::class, 'modalidad_transporte_id', 'codigo');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
