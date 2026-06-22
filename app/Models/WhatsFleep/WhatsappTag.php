<?php

namespace App\Models\WhatsFleep;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WhatsappTag extends Model
{
    protected $fillable = [
        'empresa_id',
        'name',
        'slug',
        'color',
    ];

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(
            WhatsappConversation::class,
            'whatsapp_conversation_tag',
            'whatsapp_tag_id',
            'whatsapp_conversation_id'
        );
    }
}
