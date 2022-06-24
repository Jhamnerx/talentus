<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangesModels extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'changes_models';




    //Relacion polimorfica

    public function changes()
    {
        return $this->morphTo();
    }
}
