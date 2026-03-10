<?php

namespace App\Models;

use App\Enums\CobroEstado;
use App\Scopes\EmpresaScope;
use App\Observers\CobrosObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(CobrosObserver::class)]
class Cobros extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    public const VENCIDOS = '2';

    protected $table = 'cobros';
    protected $casts = [
        'clientes_id' => 'integer',
        'vehiculos_id' => 'integer',
        'contratos_id' => 'integer',
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'vencido' => 'boolean',
        'auto_renovar' => 'boolean',
        'estado_cobro' => CobroEstado::class,
    ];
    //SCOPE GLOBAL DE EMPRES
    protected static function booted()
    {
        //
        static::addGlobalScope(new EmpresaScope);
    }


    public function scopeVencido($query, $estado = NULL)
    {
        return $query->where('vencido', $estado);
    }

    public function scopeEstado($query, $estado = NULL)
    {
        return $query->where('estado', $estado);
    }

    public function scopeStatus($query, $estado = NULL)
    {
        return $query->orwhere('estado', $estado);
    }

    public function scopeVerificado($query, $estado = 0)
    {
        return $query->where('verificado', $estado);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado_cobro', CobroEstado::ACTIVO);
    }

    public function scopeSuspendidos($query)
    {
        return $query->where('estado_cobro', CobroEstado::SUSPENDIDO);
    }

    public function scopeCancelados($query)
    {
        return $query->where('estado_cobro', CobroEstado::CANCELADO);
    }

    public function scopeEstadoCobro($query, CobroEstado $estado)
    {
        return $query->where('estado_cobro', $estado);
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withTrashed();
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed();
    }


    public function contrato()
    {
        return $this->belongsTo(Contratos::class, 'contratos_id');
    }


    public function payments()
    {
        return $this->hasMany(Payments::class, 'cobros_id');
    }

    //relacion uno a muchos
    public function detalle()
    {
        return $this->hasMany(DetalleCobros::class, 'cobros_id');
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }

    public static function createItems(Cobros $cobro, $cobroItems, $type = 'create')
    {

        foreach ($cobroItems as $cobroItem) {

            $cobroItem['cobros_id'] = $cobro->id;

            // Si existe plan_id, calcular monto_unidad y cantidad_unidades
            if (isset($cobroItem['plan_id'])) {
                $plan = \App\Models\Plan::find($cobroItem['plan_id']);

                if ($plan) {
                    // Sistema NUEVO: No llenar campo 'plan' legacy cuando se usa plan_id
                    // El accessor getMontoCalculadoAttribute() calcula el monto desde la relación
                    $cobroItem['plan'] = null;
                }
            }

            // Guardar el monto convertido (ya incluye tipo de cambio + descuento RECIBO)
            if (isset($cobroItem['monto']) && $cobroItem['monto'] > 0) {
                $cobroItem['monto_unidad'] = $cobroItem['monto'];
            }

            // Remover campos que no son de la tabla
            unset($cobroItem['placa']);
            unset($cobroItem['monto']);
            unset($cobroItem['monto_base']);

            $cobro->detalle()->create($cobroItem);
        }

        return $cobro->ventaDetalles;
    }
}
