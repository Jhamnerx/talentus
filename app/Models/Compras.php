<?php

namespace App\Models;

use App\Models\ComprasDetalle;
use App\Models\PaymentMethodType;
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
        return $this->belongsTo(PaymentMethodType::class, 'metodo_pago_id', 'codigo');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedores::class, 'proveedor_id', 'id')->withTrashed();
    }

    /**
     * Pagos de gastos asociados a esta compra
     */
    public function expensePayments(): HasMany
    {
        return $this->hasMany(ExpensePayment::class, 'expense_id', 'id');
    }

    /**
     * Movimientos financieros globales (vía ExpensePayments)
     */
    public function globalPayments()
    {
        return $this->hasManyThrough(
            GlobalPayment::class,
            ExpensePayment::class,
            'expense_id',      // FK en expense_payments
            'payment_id',      // FK en global_payments
            'id',              // PK en compras
            'id'               // PK en expense_payments
        );
    }

    /**
     * Total pagado de esta compra
     */
    public function getTotalPagadoAttribute(): float
    {
        return (float) $this->expensePayments()->sum('payment');
    }

    /**
     * Saldo pendiente de pago
     */
    public function getSaldoPendienteAttribute(): float
    {
        return $this->total - $this->total_pagado;
    }

    /**
     * Verifica si la compra está completamente pagada
     */
    public function isPaid(): bool
    {
        return $this->total_pagado >= $this->total;
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
