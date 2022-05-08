<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eliminados extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;




    //Relacion polimorfica

    public function delete()
    {

        return $this->morphTo();
    }
}
