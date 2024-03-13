<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class DispositivosUsers extends Pivot
{
    protected $table = 'dispositivos_users';
    public $incrementing = true;

    protected $casts = [
        'created_at' => 'datetime',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
