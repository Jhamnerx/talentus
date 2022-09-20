<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprasFacturas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'compras_factura';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'numero' => 'string',
        'fecha_emision' => 'date:Y/m/d',

    ];




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

    public function detalles()
    {
        return $this->hasMany(DetalleFacturasCompras::class, 'facturas_id');
    }


    public static function createItems($factura, $items)
    {
        foreach ($items as $item) {

            $item['facturas_id'] = $factura->id;

            $factura->detalles()->create($item);
        }
    }
}
