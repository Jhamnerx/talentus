<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeTareas extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'informe_tarea';


    public function tarea()
    {
        return $this->belongsTo(Tareas::class, 'tarea_id');
    }
}
