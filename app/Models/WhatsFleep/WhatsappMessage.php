<?php

namespace App\Models\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMessage extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'uuid',
        'empresa_id',
        'conversation_id',
        'device_id',
        'contact_id',
        'wa_message_id',
        'sender_type',
        'sender_user_id',
        'type',
        'body',
        'media_path',
        'mime_type',
        'file_name',
        'file_size',
        'status',
        'is_read',
        'metadata',
        'sent_at',
        'delivered_at',
        'read_at',
    ];

    /**
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getKeyName(): string
    {
        return 'id';
    }

    protected function casts(): array
    {
        return [
            'sender_type' => MessageSenderType::class,
            'type' => MessageType::class,
            'status' => MessageStatus::class,
            'is_read' => 'boolean',
            'file_size' => 'integer',
            'metadata' => 'array',
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(WhatsappConversation::class, 'conversation_id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function senderUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    /**
     * URL a la ruta autenticada que transmite el adjunto. NO es una URL pública:
     * el archivo vive en disco privado y solo se sirve con sesión (ver WhatsappMediaController).
     */
    public function mediaUrl(): ?string
    {
        if (empty($this->media_path)) {
            return null;
        }

        return route('whatsapp.media', $this->uuid);
    }

    public function scopeFromContact(Builder $query): Builder
    {
        return $query->where('sender_type', MessageSenderType::Contact->value);
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }
}
