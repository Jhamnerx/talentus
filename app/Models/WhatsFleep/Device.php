<?php

namespace App\Models\WhatsFleep;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body',
        'webhook',
        'status',
        'message_sent',
        'api_key',
        'interno',
        'es_postventa',
    ];

    protected $casts = [
        'message_sent' => 'integer',
        'interno'      => 'boolean',
        'es_postventa' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function autoreplies()
    {
        return $this->hasMany(Autoreply::class, 'device', 'body');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'sender', 'body');
    }

    public function messageHistories()
    {
        return $this->hasMany(MessageHistory::class);
    }
}
