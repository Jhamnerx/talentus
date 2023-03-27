<?php

namespace App\Models;

use App\Models\Lineas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OldSimCardLinea extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'old_sim_card_linea';


    public function linea()
    {
        return $this->belongsTo(Lineas::class, 'linea_id');
    }
}
