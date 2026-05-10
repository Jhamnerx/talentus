<?php

namespace App\Models\WhatsFleep;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blast extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender',
        'campaign_id',
        'receiver',
        'message',
        'type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('D M Y H:i:s');
    }
}
