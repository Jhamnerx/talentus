<?php

namespace App\Models;

use App\Enums\TareasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tareas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'tareas';

    protected $casts = [

        'estado' => TareasStatus::class,
        'fecha_hora' => 'datetime',
        'fecha_termino' => 'datetime',
        'respuesta' => 'boolean',
    ];

    //relacion con tipo de tareas

    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }


    public function tipo_tarea()
    {
        return $this->belongsTo(tipoTareas::class, 'tipo_tarea_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    //Relacion uno A UNO POLIMORFICA IMAGEN
    public function imagen()
    {
        return $this->morphOne(Imagen::class, 'imageable');
    }
}
