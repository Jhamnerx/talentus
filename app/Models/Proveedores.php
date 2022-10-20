<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedores extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'proveedores';

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    //relacion uno a muchos

    public function compras_factura()
    {
        return $this->hasMany(ComprasFacturas::class, 'proveedores_id');
    }
}
