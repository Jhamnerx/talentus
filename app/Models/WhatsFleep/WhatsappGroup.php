<?php

namespace App\Models\WhatsFleep;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class WhatsappGroup extends Model
{
    protected $fillable = [
        'user_id',
        'device_body',
        'group_id',
        'name',
        'participant_count',
        'synced_at',
    ];

    protected $casts = [
        'synced_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
