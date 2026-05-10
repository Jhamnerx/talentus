<?php

namespace App\Models\WhatsFleep;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tag_id',
        'name',
        'number',
    ];

    public function tag()
    {
        return $this->belongsTo(WaTag::class, 'tag_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
