<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRecibos extends Model
{
    use HasFactory;
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_recibos';
    protected $casts = [
        'cantidad' => 'float',
    ];
    //Relacion uno a muchos inversa

    public function recibos()
    {
        return $this->belongsTo(Recibos::class, 'recibos_id');
    }
}
