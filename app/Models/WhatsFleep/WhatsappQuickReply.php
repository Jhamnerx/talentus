<?php

namespace App\Models\WhatsFleep;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WhatsappQuickReply extends Model
{
    protected $fillable = [
        'empresa_id',
        'shortcut',
        'title',
        'body',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);

        static::creating(function (self $reply) {
            $reply->empresa_id = $reply->empresa_id ?: session('empresa', 1);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}
