<?php

namespace App\Models;

use App\Observers\CashObserver;
use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(CashObserver::class)]
class Cash extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    protected $table = 'cash';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'saldo_inicial' => 'decimal:2',
        'saldo_actual' => 'decimal:2',
        'fecha_apertura' => 'date:Y-m-d',
        'fecha_cierre' => 'date:Y-m-d',
        'estado' => 'boolean',
    ];

    // Accessors
    protected function currencyTypeId(): Attribute
    {
        return new Attribute(
            get: fn() => $this->moneda ?? 'PEN',
        );
    }

    protected function numberFull(): Attribute
    {
        return new Attribute(
            get: fn() => 'CAJA GENERAL' . ($this->reference_number ? ' N° ' . $this->reference_number : ''),
        );
    }

    // Accessor para compatibilidad (genera nombre dinámico)
    protected function nombre(): Attribute
    {
        return new Attribute(
            get: fn() => 'CAJA GENERAL',
        );
    }

    protected function stateDescription(): Attribute
    {
        return new Attribute(
            get: fn() => $this->estado ? 'Abierta' : 'Cerrada',
        );
    }

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

    protected function userId(): Attribute
    {
        return new Attribute(
            set: fn($user_id) => Auth::user()->id,
        );
    }

    public function scopeAbierta($query)
    {
        return $query->where('estado', 1);
    }

    public function scopeCerrada($query)
    {
        return $query->where('estado', 0);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Nuevas relaciones para el sistema de Caja Chica
    public function cashDocuments(): HasMany
    {
        return $this->hasMany(CashDocument::class);
    }

    public function cashDocumentPayments(): HasMany
    {
        return $this->hasMany(CashDocumentPayment::class);
    }

    public function cashDocumentCredits(): HasMany
    {
        return $this->hasMany(CashDocumentCredit::class);
    }

    public function globalDestination()
    {
        return $this->morphMany(GlobalPayment::class, 'destination');
    }

    // Métodos de negocio
    public function aperturar(float $saldoInicial, string $nombre, ?string $descripcion = null)
    {
        $this->saldo_inicial = $saldoInicial;
        $this->saldo_actual = $saldoInicial;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fecha_apertura = now()->toDateString();
        $this->estado = 1;
        $this->save();

        return $this;
    }

    public function cerrar()
    {
        $totales = $this->calcularTotales();

        $this->fecha_cierre = now()->toDateString();
        $this->saldo_actual = $this->saldo_inicial + $totales['ingresos'] - $totales['egresos'];
        $this->estado = 0;
        $this->save();

        return $this;
    }

    public function calcularTotales(): array
    {
        $ingresos = 0;
        $egresos = 0;

        // Cargar los pagos desde global_payments usando la relación polimórfica
        foreach ($this->globalDestination()->with('payment.paymentable')->get() as $globalPayment) {
            $monto = $globalPayment->payment?->monto ?? 0;

            if (!$monto) continue;

            // Usar el accessor type_movement que ya determina INGRESO/EGRESO
            if ($globalPayment->type_movement === 'INGRESO') {
                $ingresos += $monto;
            } else {
                $egresos += $monto;
            }
        }

        return [
            'ingresos' => round($ingresos, 2),
            'egresos' => round($egresos, 2),
            'saldo_final' => round($this->saldo_inicial + $ingresos - $egresos, 2),
        ];
    }

    private function convertirAPen(float $monto, string $moneda): float
    {
        if ($moneda === 'PEN') {
            return $monto;
        }

        // Obtener tipo de cambio del día
        $tipoCambio = \App\Models\TipoCambio::whereDate('fecha', now())->first();

        return $monto * ($tipoCambio->venta ?? 3.80); // Fallback a 3.80 si no hay TC
    }

    /**
     * Obtener total de ingresos por tipo de documento
     * Útil para reportes de resumen
     */
    public function getTotalsIncomeSummary(): array
    {
        $recibosTotalPayments = 0;
        $ventasTotalPayments = 0;
        $otrosIngresos = 0;

        foreach ($this->globalDestination()->with('payment.paymentable')->get() as $globalPayment) {
            if ($globalPayment->type_movement !== 'INGRESO') continue;

            $monto = $globalPayment->payment?->monto ?? 0;
            $paymentable = $globalPayment->payment?->paymentable;

            if (!$paymentable || !$monto) continue;

            $class = class_basename($paymentable);

            if ($class === 'Recibos' || $class === 'RecibosPagosVarios') {
                $recibosTotalPayments += $monto;
            } elseif ($class === 'Ventas' || $class === 'Factura') {
                $ventasTotalPayments += $monto;
            } else {
                $otrosIngresos += $monto;
            }
        }

        return [
            'recibos_total_payments' => round($recibosTotalPayments, 2),
            'ventas_total_payments' => round($ventasTotalPayments, 2),
            'otros_ingresos' => round($otrosIngresos, 2),
            'total_income' => round($recibosTotalPayments + $ventasTotalPayments + $otrosIngresos, 2),
        ];
    }

    /**
     * Obtener comprobantes y documentos ordenados para reporte de ingresos
     * Útil para reportes cronológicos
     */
    public function getIncomePaymentsData(): array
    {
        $ingresos = $this->globalDestination()
            ->with('payment.paymentable')
            ->get()
            ->filter(fn($gp) => $gp->type_movement === 'INGRESO')
            ->sortBy('created_at');

        $recibos = $ingresos->filter(function ($gp) {
            $class = class_basename($gp->payment?->paymentable);
            return in_array($class, ['Recibos', 'RecibosPagosVarios']);
        });

        $ventas = $ingresos->filter(function ($gp) {
            $class = class_basename($gp->payment?->paymentable);
            return in_array($class, ['Ventas', 'Factura']);
        });

        return [
            'recibos' => $recibos,
            'ventas' => $ventas,
            'ingresos' => $ingresos,
            'all_sorted' => $ingresos,
        ];
    }

    /**
     * Scope para filtrar cajas activas del usuario
     */
    public function scopeWhereActive($query)
    {
        return $query->where('user_id', Auth::id())->where('estado', true);
    }

    /**
     * Scope para obtener cajas por estado
     */
    public function scopeByStatus($query, bool $status)
    {
        return $query->where('estado', $status);
    }
}
