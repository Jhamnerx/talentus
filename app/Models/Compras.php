<?php

namespace App\Models;

use App\Models\ComprasDetalle;
use App\Models\PaymentMethods;
use App\Observers\ComprasObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ComprasObserver::class)]
class Compras extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'compras';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fecha_emision' => 'date:Y-m-d',
        'sub_total' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'user_id' => 'integer',
    ];

    public function detalle(): HasMany
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


    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedores::class, 'proveedor_id', 'id')->withTrashed();
    }

    //CREAR ITEM DETALLE VENTA
    public static function createItems($items, Compras $compra)
    {
        foreach ($items as $item) {
            $item['compras_id'] = $compra->id;

            // Crear o actualizar el detalle de la compra
            $detalleItem = $compra->detalle()->create($item);

            // Incrementar el stock del producto
            $detalleItem->producto->increment('stock', $item['cantidad']);
        }

        return $compra->detalle;
    }
}
