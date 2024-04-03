<?php

namespace App\Models;

use App\Models\PaymentMethods;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compras extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'clientes';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'metodo_pago_id' => 'integer',
        'op_gravadas' => 'decimal:2',
        'op_exoneradas' => 'decimal:2',
        'op_inafectas' => 'decimal:2',
        'op_gratuitas' => 'decimal:2',
        'descuento' => 'decimal:2',
        'icbper' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'user_id' => 'integer',
    ];

    public function comprasDetalles(): HasMany
    {
        return $this->hasMany(ComprasDetalle::class);
    }

    public function tipoComprobante(): BelongsTo
    {
        return $this->belongsTo(\App\Models\TipoComprobantes::class, 'tipo_comprobante_id', 'codigo');
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(PaymentMethods::class, 'metodo_pago_id', 'codigo');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
