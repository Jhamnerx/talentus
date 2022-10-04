<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payments extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


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



    protected function empresaId(): Attribute
    {
        return new Attribute(
            set: fn ($empresa_id) => session('empresa'),
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
            set: fn ($user_id) => Auth::user()->id,
        );
    }


    // public function setEmpresaIdAttribute($empresa)
    // {
    //     $this->attributes['empresas_id'] = session('empresa');
    // }

    public function paymentable()
    {

        return $this->morphTo();
    }

    public function cobros()
    {

        return $this->belongsTo(Cobros::class, 'cobros_id');
    }
}
