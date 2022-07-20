<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasFacturas extends Model
{
    use HasFactory;
    protected $table = 'compras_factura';



    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        //
    }

    //Relacion uno a muchos inversa

    public function proveedores()
    {
        return $this->belongsTo(Proveedores::class, 'proveedores_id')->withoutGlobalScope(EliminadoScope::class);
    }
}
