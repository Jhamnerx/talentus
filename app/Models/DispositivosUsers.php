<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DispositivosUsers extends Pivot
{
    protected $table = 'dispositivos_users';
    public $incrementing = true;
}
