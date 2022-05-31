<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuestos extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'presupuestos';
    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
        static::addGlobalScope(new EliminadoScope);
    }

    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withoutGlobalScope(EliminadoScope::class, ActiveScope::class);
    }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetallePresupuestos::class, 'presupuestos_id');
    }



    public static function createItems($presupuesto, $presupuestoItems)
    {
        foreach ($presupuestoItems as $presupuestoItem) {

            $presupuestoItem['presupuestos_id'] = $presupuesto->id;

            $item = $presupuesto->detalles()->create($presupuestoItem);
        }
    }
}
