<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigosDetracciones extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'codigos_detracciones';

    protected $primaryKey = "codigo";

    protected $casts = [
        'codigo' => 'string',
        'porcentaje' => 'decimal:2',
        'descripcion' => 'string',
    ];
}
