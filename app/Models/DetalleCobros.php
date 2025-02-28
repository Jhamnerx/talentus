<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DetalleCobros extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalles_cobros';

    protected $casts = [
        'cobros_id' => 'integer',
        'vehiculos_id' => 'integer',
        'cantidad_unidades' => 'integer',
        'monto_unidad' => 'decimal:2',
        'fecha' => 'date:Y-m-d',
        'estado' => 'boolean',
    ];



    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class);
    }

    //Relacion uno a muchos inversa

    public function cobro()
    {
        return $this->belongsTo(Cobros::class, 'cobros_id')->withTrashed();
    }

    // Atributo personalizado para obtener los detalles vencidos
    public function scopeVencidos($query)
    {
        return $query->where('fecha', '<', Carbon::now());
    }
}
