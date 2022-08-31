<?php

namespace App\Models\Admin;

use App\Models\Reportes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordatorios extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

        //Relacion uno a muchos inversa

    public function reporte()
    {
        return $this->belongsTo(Reportes::class, 'reportes_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
