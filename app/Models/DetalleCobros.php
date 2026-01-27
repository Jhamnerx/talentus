<?php

namespace App\Models;

use App\Enums\CobroEstado;
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
        'fecha_facturado' => 'date:Y-m-d',
        'estado' => 'boolean',
        'estado_detalle' => CobroEstado::class,
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

    public function scopeActivos($query)
    {
        return $query->where('estado_detalle', CobroEstado::ACTIVO);
    }

    public function scopeSuspendidos($query)
    {
        return $query->where('estado_detalle', CobroEstado::SUSPENDIDO);
    }

    public function scopePendientesPago($query)
    {
        return $query->where('estado', 1)
            ->where('estado_detalle', CobroEstado::ACTIVO)
            ->whereNull('factura_id');
    }

    public function scopePorVencer($query, $dias = 7)
    {
        $hoy = Carbon::now();
        return $query->where('estado', 1)
            ->where('estado_detalle', CobroEstado::ACTIVO)
            ->whereBetween('fecha', [$hoy->format('Y-m-d'), $hoy->copy()->addDays($dias)->format('Y-m-d')]);
    }
}
