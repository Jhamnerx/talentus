<?php

namespace App\Models;

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


    public static function createItems(Cobros $cobro, $cobroItems, $type = 'create')
    {

        foreach ($cobroItems as $cobroItem) {

            $cobroItem['cobros_id'] = $cobro->id;
            // if ($type == 'create') {
            //     $cobroItem['estado'] = 1;
            // } else {
            //     $cobroItem['estado'] = 0;
            // }

            $cobro->detalle()->create($cobroItem);
        }

        return $cobro->ventaDetalles;
    }
}
