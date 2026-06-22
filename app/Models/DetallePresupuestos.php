<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Productos;
use App\Scopes\EliminadoScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePresupuestos extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_presupuestos';

    protected $casts = [
        'cantidad' => 'float',
        'plan_features' => 'array',
    ];

    //Relacion uno a muchos inversa

    public function presupuestos()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuestos_id')->withoutGlobalScope(EliminadoScope::class);
    }

    public function info_producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id')->withTrashed();
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id')->withoutGlobalScopes();
    }
}
