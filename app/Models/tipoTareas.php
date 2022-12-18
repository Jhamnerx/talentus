<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoTareas extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    //relacion tareas

    public function tareas()
    {
        return $this->hasMany(Tareas::class, 'tipo_tarea_id');
    }
}
