<?php

namespace App\Models;

class PaymentMethodType extends ModelCatalog
{
    protected $table = "payment_method_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'description',
    ];
}
