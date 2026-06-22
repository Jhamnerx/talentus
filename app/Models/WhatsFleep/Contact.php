<?php

namespace App\Models\WhatsFleep;

use App\Models\Clientes;
use App\Models\User;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'user_id',
        'tag_id',
        'name',
        'number',
        'wa_jid',
        'push_name',
        'profile_pic_url',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(WaTag::class, 'tag_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')
            ->withTrashed()
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(WhatsappConversation::class, 'contact_id');
    }
}
