<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibos extends Model
{
    use HasFactory;
    protected $table = 'recibos';
        protected $guarded = ['id', 'created_at', 'updated_at'];
    // SCOPE DE EMPRESA

    protected static function booted()
    {
        //
       // static::addGlobalScope(new EliminadoScope);
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withoutGlobalScope(EliminadoScope::class, ActiveScope::class);
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuestos_id');
    }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetalleRecibos::class, 'recibos_id');
    }


    public static function createItems($recibo, $reciboItems)
    {
        foreach ($reciboItems as $reciboItem) {

            $reciboItem['recibos_id'] = $recibo->id;

            $item = $recibo->detalles()->create($reciboItem);
        }
    }


}
