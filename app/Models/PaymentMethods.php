<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;


    public function payments()
    {


        return $this->hasOne(Payments::class, 'payment_method_id');
    }
}
