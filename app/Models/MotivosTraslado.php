<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivosTraslado extends Model
{
    use HasFactory;
    protected $table = 'motivos_traslado';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;


    //Relacion uno a muchos inversa

    public function guias()
    {
        return $this->belongsTo(GuiaRemision::class, 'motivo_traslado');
    }
}
