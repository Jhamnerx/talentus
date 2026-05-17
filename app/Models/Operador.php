<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'operadores';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'have_api' => 'boolean',
    ];
}
