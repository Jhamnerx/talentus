<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReportes extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;



    protected $table = 'detalle_reportes';



    //Relacion uno a muchos inversa

    public function reporte()
    {
        return $this->belongsTo(Reportes::class, 'reportes_id');
    }
}
