<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use App\Observers\PaymentsObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PaymentMethodType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(PaymentsObserver::class)]
class Payments extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha' => 'date:Y/m/d',
    ];

    protected $fillable = [
        'numero',
        'numero_operacion',
        'fecha',
        'nota',
        'documento',
        'divisa',
        'monto',
        'tipo_cambio',
        'type_movement',
        'description',
        'payment_method_id',
        'bank_account_id',
        'cobros_id',
        'paymentable_type',
        'paymentable_id',
        'destination_type', // Relación polimórfica: 'App\Models\Cash' o 'App\Models\BankAccount'
        'destination_id', // ID del destino polimórfico
        'user_id',
        'empresa_id',
    ];


    // protected function empresaId(): Attribute
    // {
    //     return new Attribute(
    //         get: function ($empresa_id, $attributes) {
    //             return '1';
    //         },
    //         set: function ($empresa_id, $attributes) {
    //             return session('empresa');
    //         }
    //     );
    // }

    public function getRouteKeyName()
    {
        return 'numero';
    }


    protected static function booted()
    {
        //
        static::addGlobalScope(new EmpresaScope);
    }

    protected function empresaId(): Attribute
    {
        return new Attribute(
            set: fn($empresa_id) => session('empresa'),
        );
    }

    // protected function userId(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => Auth::user()->id,
    //     );
    // }
    protected function userId(): Attribute
    {
        return new Attribute(
            set: fn($user_id) => Auth::user()->id,
        );
    }

    /**
     * Accessor para type_movement
     * Calcula automáticamente si es INGRESO o EGRESO basándose en paymentable_type
     * cuando no está asignado (para registros antiguos)
     */
    protected function typeMovement(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                // Si ya tiene valor asignado, retornarlo
                if (!empty($value)) {
                    return $value;
                }

                // Calcular dinámicamente basándose en paymentable_type
                $paymentableType = $this->attributes['paymentable_type'] ?? null;

                // Ingresos: Ventas, Recibos, Facturas
                if (in_array($paymentableType, [
                    'App\\Models\\Ventas',
                    'App\\Models\\Recibos',
                    'App\\Models\\Factura'
                ])) {
                    return 'INGRESO';
                }

                // Egresos: Compras, RecibosPagosVarios
                if (in_array($paymentableType, [
                    'App\\Models\\Compras',
                    'App\\Models\\RecibosPagosVarios'
                ])) {
                    return 'EGRESO';
                }

                // Por defecto, si no se puede determinar
                return $value;
            }
        );
    }


    // public function setEmpresaIdAttribute($empresa)
    // {
    //     $this->attributes['empresa_id'] = session('empresa');
    // }

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function cobros()
    {
        return $this->belongsTo(Cobros::class, 'cobros_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethodType::class, 'payment_method_id', 'id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image()
    {
        return $this->morphOne(Imagen::class, 'imageable');
    }

    /**
     * Destino del pago (Cash o BankAccount) - relación polimórfica
     */
    public function destination()
    {
        return $this->morphTo();
    }

    /**
     * Determinar si el pago es un ingreso
     */
    public function isIncome()
    {
        if (!$this->paymentable) {
            return false;
        }

        $ingresos = [
            'App\\Models\\Recibos',
            'App\\Models\\Factura',
            'App\\Models\\Ventas',
        ];

        return in_array($this->paymentable_type, $ingresos);
    }

    /**
     * Determinar si el pago es un egreso
     */
    public function isExpense()
    {
        if (!$this->paymentable) {
            return false;
        }

        $egresos = [
            'App\\Models\\Compras',
            'App\\Models\\RecibosPagosVarios', // Recibos de egreso/salidas
        ];

        return in_array($this->paymentable_type, $egresos);
    }
    /**
     * Accessors para reportes financieros
     */

    /**
     * Obtener descripción del destino
     */
    public function getDestinationDescriptionAttribute(): string
    {
        if (!$this->destination) {
            return 'Sin destino';
        }

        if ($this->destination instanceof Cash) {
            return 'CAJA: ' . ($this->destination->nombre ?? 'CAJA GENERAL');
        }

        if ($this->destination instanceof BankAccount) {
            $banco  = $this->destination->bank?->description ?? 'Banco';
            $cuenta = $this->destination->description ?? '';
            return 'BANCO: ' . $banco . ($cuenta ? ' — ' . $cuenta : '');
        }

        return 'Destino desconocido';
    }

    /**
     * Obtener número de documento del paymentable
     */
    public function getDocumentNumberAttribute(): ?string
    {
        if (!$this->paymentable) {
            return null;
        }

        // Ventas
        if (isset($this->paymentable->serie_correlativo)) {
            return $this->paymentable->serie_correlativo;
        }

        // Recibos
        if (isset($this->paymentable->serie_numero)) {
            return $this->paymentable->serie_numero;
        }

        // Compras
        if (isset($this->paymentable->numero)) {
            return $this->paymentable->numero;
        }

        return null;
    }

    /**
     * Obtener nombre de la persona (cliente/proveedor)
     */
    public function getPersonNameAttribute(): ?string
    {
        if (!$this->paymentable) {
            return null;
        }

        try {
            // Recibos usa clientes() (plural)
            if (method_exists($this->paymentable, 'clientes') && $this->paymentable->clientes) {
                return $this->paymentable->clientes->nombre
                    ?? $this->paymentable->clientes->razon_social
                    ?? '-';
            }

            // Ventas/Compras usan cliente() o proveedor()
            if (method_exists($this->paymentable, 'cliente') && $this->paymentable->cliente) {
                return $this->paymentable->cliente->nombre
                    ?? $this->paymentable->cliente->razon_social
                    ?? '-';
            }

            if (method_exists($this->paymentable, 'proveedor') && $this->paymentable->proveedor) {
                return $this->paymentable->proveedor->nombre
                    ?? $this->paymentable->proveedor->razon_social
                    ?? '-';
            }

            // Fallback
            return $this->paymentable->nombre_completo ?? '-';
        } catch (\Exception $e) {
            return '-';
        }
    }

    /**
     * Obtener descripción del tipo de documento
     */
    public function getPaymentTypeDescriptionAttribute(): string
    {
        if (!$this->paymentable) {
            return 'Pago sin documento';
        }

        $class = class_basename($this->paymentable);
        $mapping = [
            'Recibos' => 'Recibo',
            'Factura' => 'Factura',
            'Ventas' => 'Venta',
            'RecibosPagosVarios' => 'Recibo Pago',
            'Compras' => 'Compra',
            'ExpensePayment' => 'Gasto',
        ];

        return $mapping[$class] ?? $class;
    }

    /**
     * Obtener descripción del tipo de instancia (en mayúsculas)
     */
    public function getInstanceTypeDescriptionAttribute(): string
    {
        if (!$this->paymentable) {
            return 'PAGO SIN DOCUMENTO';
        }

        $class = class_basename($this->paymentable);
        $mapping = [
            'Recibos' => 'RECIBO',
            'Factura' => 'FACTURA',
            'Ventas' => 'VENTA',
            'RecibosPagosVarios' => 'RECIBO PAGO',
            'Compras' => 'COMPRA',
            'ExpensePayment' => 'GASTO',
            'WorkOrder' => 'ORDEN DE TRABAJO',
        ];

        return $mapping[$class] ?? strtoupper($class);
    }

    /**
     * Obtener moneda del documento
     */
    public function getMonedaAttribute(): string
    {
        // Primero intentar obtener del campo divisa del payment
        if ($this->divisa) {
            return $this->divisa;
        }

        // Si no, obtener del documento paymentable
        if ($this->paymentable && isset($this->paymentable->divisa)) {
            return $this->paymentable->divisa;
        }

        if ($this->paymentable && isset($this->paymentable->moneda)) {
            return $this->paymentable->moneda;
        }

        return 'PEN'; // Por defecto
    }

    /**
     * Obtener fecha formateada
     */
    public function getFechaFormateadaAttribute(): string
    {
        return $this->created_at?->format('d/m/Y H:i') ?? '-';
    }

    /**
     * Query Scopes para filtros
     */

    public function scopeWhereDateBetween($query, $dateStart, $dateEnd)
    {
        return $query->whereBetween('fecha', [$dateStart, $dateEnd]);
    }

    public function scopeIngresos($query)
    {
        return $query->where('type_movement', 'INGRESO');
    }

    public function scopeEgresos($query)
    {
        return $query->where('type_movement', 'EGRESO');
    }

    public function scopeByDestinationType($query, $type)
    {
        return $query->where('destination_type', $type);
    }

    public function scopeByCash($query, $cashId)
    {
        return $query->where('destination_type', Cash::class)->where('destination_id', $cashId);
    }

    public function scopeByBankAccount($query, $bankAccountId)
    {
        return $query->where('destination_type', BankAccount::class)->where('destination_id', $bankAccountId);
    }

    /**
     * Filtrar por empresa (útil para queries directas sin EmpresaScope)
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
     * Scope para eager loading optimizado en reportes
     */
    public function scopeWithRelationsForReport($query)
    {
        return $query->with([
            'destination',
            'paymentable',
            'user:id,name',
            'bankAccount'
        ]);
    }

    /**
     * Scope para ordenar por fecha descendente
     */
    public function scopeLatestPayments($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
