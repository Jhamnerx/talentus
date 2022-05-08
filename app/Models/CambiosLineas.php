<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambiosLineas extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'cambios_lineas';


    //Relacion uno a muchos inversa

    public function sim_card()
    {
        return $this->belongsTo(SimCard::class, 'sim_card_id');
    }

    public function linea_new()
    {
        return $this->belongsTo(Lineas::class, 'new_numero');
    }

    public function linea_old()
    {
        return $this->belongsTo(Lineas::class, 'old_numero');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
