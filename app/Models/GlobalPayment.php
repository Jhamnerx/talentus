<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GlobalPayment extends Model
{
    use HasFactory, LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    protected function empresaId(): Attribute
    {
        return new Attribute(
            set: fn($empresa_id) => session('empresa'),
        );
    }

    // ==================== RELACIONES ====================

    /**
     * Relación polimórfica con el destino (Cash o BankAccount)
     */
    public function destination(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relación polimórfica con el pago
     */
    public function payment(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Usuario que registró el movimiento
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ==================== ACCESSORS ====================

    /**
     * Determinar si es INGRESO o EGRESO
     */
    protected function typeMovement(): Attribute
    {
        return new Attribute(
            get: function () {
                if (!$this->payment) {
                    return 'DESCONOCIDO';
                }

                // Si es un pago de documento de venta -> INGRESO
                if ($this->payment_type === Payments::class) {
                    $paymentable = $this->payment->paymentable;
                    if ($paymentable) {
                        $ingresos = ['Recibos', 'Factura', 'Ventas', 'RecibosPagosVarios'];
                        $class = class_basename($paymentable);
                        return in_array($class, $ingresos) ? 'INGRESO' : 'EGRESO';
                    }
                }

                return 'EGRESO'; // Por defecto
            }
        );
    }

    /**
     * Obtener monto del pago
     */
    protected function monto(): Attribute
    {
        return new Attribute(
            get: fn() => $this->payment?->payment ?? 0
        );
    }

    /**
     * Obtener descripción del destino
     */
    protected function destinationDescription(): Attribute
    {
        return new Attribute(
            get: function () {
                if (!$this->destination) {
                    return 'Sin destino';
                }

                if ($this->destination_type === Cash::class) {
                    return "CAJA - {$this->destination->nombre}";
                }

                if ($this->destination_type === BankAccount::class) {
                    return "{$this->destination->bank->description} - {$this->destination->number}";
                }

                return 'Destino desconocido';
            }
        );
    }

    /**
     * Obtener descripción del tipo de pago
     */
    protected function paymentTypeDescription(): Attribute
    {
        return new Attribute(
            get: function () {
                if (!$this->payment) {
                    return 'Sin pago';
                }

                $paymentable = $this->payment->paymentable;
                if (!$paymentable) {
                    return 'Pago sin documento';
                }

                $class = class_basename($paymentable);
                $mapping = [
                    'Recibos' => 'Recibo',
                    'Factura' => 'Factura',
                    'Ventas' => 'Venta',
                    'RecibosPagosVarios' => 'Recibo Pago',
                    'Compras' => 'Compra',
                ];

                return $mapping[$class] ?? $class;
            }
        );
    }

    /**
     * Obtener número de documento
     */
    protected function documentNumber(): Attribute
    {
        return new Attribute(
            get: function () {
                $paymentable = $this->payment?->paymentable;
                return $paymentable?->numero ?? $paymentable?->numero_comprobante ?? '-';
            }
        );
    }

    /**
     * Obtener cliente/proveedor
     */
    protected function personName(): Attribute
    {
        return new Attribute(
            get: function () {
                $paymentable = $this->payment?->paymentable;
                if (!$paymentable) {
                    return '-';
                }

                try {
                    // Recibos usa clientes() (plural)
                    if (method_exists($paymentable, 'clientes') && $paymentable->clientes) {
                        return $paymentable->clientes->nombre
                            ?? $paymentable->clientes->razon_social
                            ?? '-';
                    }
                    // Ventas/Compras usan cliente() o proveedor()
                    if (method_exists($paymentable, 'cliente') && $paymentable->cliente) {
                        return $paymentable->cliente->nombre
                            ?? $paymentable->cliente->razon_social
                            ?? '-';
                    }
                    if (method_exists($paymentable, 'proveedor') && $paymentable->proveedor) {
                        return $paymentable->proveedor->nombre
                            ?? $paymentable->proveedor->razon_social
                            ?? '-';
                    }
                    // Fallback
                    return $paymentable->nombre_completo ?? '-';
                } catch (\Exception $e) {
                    return '-';
                }
            }
        );
    }

    /**
     * Obtener descripción del tipo de instancia
     * Similar a instance_type_description de FactuPRO
     */
    protected function instanceTypeDescription(): Attribute
    {
        return new Attribute(
            get: function () {
                if (!$this->payment) {
                    return 'DESCONOCIDO';
                }

                $paymentable = $this->payment->paymentable;
                if (!$paymentable) {
                    return 'PAGO SIN DOCUMENTO';
                }

                $class = class_basename($paymentable);
                $mapping = [
                    'Recibos' => 'RECIBO',
                    'Factura' => 'FACTURA',
                    'Ventas' => 'VENTA',
                    'RecibosPagosVarios' => 'RECIBO PAGO',
                    'Compras' => 'COMPRA',
                    'ExpensePayments' => 'GASTO',
                ];

                return $mapping[$class] ?? strtoupper($class);
            }
        );
    }

    /**
     * Obtener moneda del pago
     */
    protected function moneda(): Attribute
    {
        return new Attribute(
            get: function () {
                $paymentable = $this->payment?->paymentable;
                return $paymentable?->moneda ?? 'PEN';
            }
        );
    }

    /**
     * Obtener fecha del pago formateada
     */
    protected function fechaFormateada(): Attribute
    {
        return new Attribute(
            get: fn() => $this->created_at?->format('d/m/Y H:i')
        );
    }

    // ==================== SCOPES ====================

    /**
     * Filtrar por rango de fechas
     */
    public function scopeWhereDateBetween($query, $dateStart, $dateEnd)
    {
        return $query->whereBetween('created_at', [
            $dateStart . ' 00:00:00',
            $dateEnd . ' 23:59:59'
        ]);
    }

    /**
     * Filtrar por empresa (aunque ya está en EmpresaScope, útil para queries directas)
     */
    public function scopeByEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    /**
     * Filtrar por usuario
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para eager loading optimizado
     * No cargamos cliente/proveedor aquí porque los modelos usan nombres diferentes
     * (Recibos usa 'clientes', Ventas usa 'cliente', etc.)
     */
    public function scopeWithRelationsForReport($query)
    {
        return $query->with([
            'destination',
            'payment.paymentable',
            'user:id,name'
        ]);
    }

    /**
     * Filtrar solo pagos con destino Cash
     */
    public function scopeWhereCashDestination($query)
    {
        return $query->where('destination_type', Cash::class);
    }

    /**
     * Filtrar solo pagos con destino BankAccount
     */
    public function scopeWhereBankDestination($query)
    {
        return $query->where('destination_type', BankAccount::class);
    }

    /**
     * Scope para ordenar por fecha de pago descendente
     */
    public function scopeLatestPayments($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeIngresos($query)
    {
        return $query->whereHas('payment', function ($q) {
            $q->whereHasMorph('paymentable', ['App\Models\Recibos', 'App\Models\Factura', 'App\Models\Ventas']);
        });
    }

    public function scopeEgresos($query)
    {
        return $query->whereHas('payment', function ($q) {
            $q->whereHasMorph('paymentable', ['App\Models\Compras']);
        });
    }

    public function scopeByDestinationType($query, $type)
    {
        return $query->where('destination_type', $type);
    }

    public function scopeByCash($query, $cashId)
    {
        return $query->where('destination_type', Cash::class)
            ->where('destination_id', $cashId);
    }
}
