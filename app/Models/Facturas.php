<?php

namespace App\Models;

use App\Scopes\ActiveScope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{


    use HasFactory;

    protected $table = 'facturas';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'numero' => 'string',
        'sequence_number' => 'integer',

    ];

    
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withoutGlobalScope(EliminadoScope::class, ActiveScope::class);
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuestos_id');
    }

    public function getSerie(){

        return plantilla::get('serie')->where('empresas_id', session('empresa'));

    }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetalleFacturas::class, 'facturas_id');
    }


    public static function createItems($factura, $facturaItems)
    {
        foreach ($facturaItems as $facturaItem) {

            $facturaItem['facturas_id'] = $factura->id;

            $item = $factura->detalles()->create($facturaItem);
        }
    }

}
