<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
