<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function paymentable()
    {

        return $this->morphTo();
    }

    public function cobros()
    {

        return $this->belongsTo(Cobros::class, 'cobros_id');
    }
}
