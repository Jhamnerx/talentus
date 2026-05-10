<?php

namespace App\Models\WhatsFleep;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoreply extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'reply'     => 'array',
        'status'    => 'boolean',
        'is_quoted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device', 'body');
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(fn() => self::clearNodeCache());
        static::created(fn() => self::clearNodeCache());
        static::deleted(fn() => self::clearNodeCache());
    }

    protected static function clearNodeCache(): void
    {
        if (function_exists('clearCacheNode')) {
            clearCacheNode();
        }
    }
}
