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

    public function movements(): HasMany
    {
        return $this->hasMany(CashMovement::class);
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

        foreach ($this->cashDocuments as $doc) {
            $documento = $doc->getDocumento();

            if (!$documento) continue;

            // Convertir a PEN si es necesario
            $total = $this->convertirAPen($documento->total_a_pagar ?? $documento->total ?? 0, $documento->moneda ?? 'PEN');

            // Determinar si es ingreso o egreso
            if ($doc->factura_id || $doc->recibo_id || $doc->venta_id) {
                $ingresos += $total;
            } elseif ($doc->expense_payment_id || $doc->compra_id) {
                $egresos += $total;
            }
        }

        return [
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'saldo_final' => $this->saldo_inicial + $ingresos - $egresos,
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
}
