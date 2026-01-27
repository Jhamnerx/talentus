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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image()
    {
        return $this->morphOne(Imagen::class, 'imageable');
    }

    /**
     * Relación con GlobalPayment
     */
    public function globalPayment()
    {
        return $this->morphOne(GlobalPayment::class, 'payment');
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
            'App\\Models\\RecibosPagosVarios',
        ];

        return in_array($this->paymentable_type, $ingresos);
    }

    /**
     * Determinar si el pago es un egreso
     */
    public function isExpense()
    {
        return !$this->isIncome();
    }
}
