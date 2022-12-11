<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class detalleGuiaRemision extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_guia_remision';

    protected $casts = [
        'cantidad' => 'float',
    ];
    //Relacion uno a muchos inversa

    public function guias()
    {
        return $this->belongsTo(GuiaRemision::class, 'guia_remision_id');
    }
}
