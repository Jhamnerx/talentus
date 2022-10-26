<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plantilla extends Model
{
    use HasFactory;
    protected $table = 'plantilla';

    protected $guarded = ['id', 'created_at', 'updated_at'];
    // protected $casts = [
    //     'sunat' => 'json',
    //     'direccion' => 'json',
    //     'series' => 'json',
    // ];

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    protected function sunat(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
    protected function direccion(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    protected function series(): Attribute
    {
        return new Attribute(
            get: fn ($series) => json_decode($series, true),
            set: fn ($series) => json_encode($series),
        );
    }




    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function getSerieFacturaAttribute($value)
    {
        return $value;
    }
}
