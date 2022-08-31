<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cobros extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;
    use SoftDeletes;

    protected $table = 'cobros';
    protected $casts = [

        'fecha_vencimiento' => 'date:Y-m-d',
        'vencido' => 'boolean',

    ];

    public function scopeVencido($query,$estado = NULL)
    {
        return $query->where('vencido', $estado);
    }

    public function scopeEstado($query,$estado = NULL)
    {
        return $query->where('estado', $estado);
    }
    
    public function scopeVerificado($query,$estado = 0)
    {
        return $query->where('verificado', $estado);
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withTrashed();
    }

    public function vehiculos(){
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed();
    }



    public function contrato()
    {
        return $this->belongsTo(Contratos::class, 'contratos_id');
    }
}
