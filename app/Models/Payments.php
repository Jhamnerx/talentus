<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use App\Observers\PaymentsObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        return $this->belongsTo(PaymentMethods::class, 'payment_method_id', 'codigo');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function image()
    {

        return $this->morphOne(Imagen::class, 'imageable');
    }
}
