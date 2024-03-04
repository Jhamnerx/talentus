<?php

namespace App\Models;

use App\Models\Productos;
use App\Scopes\EliminadoScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetallePresupuestos extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_presupuestos';

    protected $casts = [
        'cantidad' => 'float',
    ];

    //Relacion uno a muchos inversa

    public function presupuestos()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuestos_id')->withoutGlobalScope(EliminadoScope::class);
    }

    public function info_producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id')->withoutGlobalScope(EliminadoScope::class);
    }
}
