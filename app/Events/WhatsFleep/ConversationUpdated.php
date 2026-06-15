<?php

namespace App\Events\WhatsFleep;

use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationUpdated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public WhatsappConversation $conversation)
    {
    }

    /**
     * @return array<int, PrivateChannel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('whatsapp.empresa.' . $this->conversation->empresa_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'wa.conversation.updated';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->conversation->id,
            'uuid' => $this->conversation->uuid,
            'status' => $this->conversation->status->value,
            'unread_count' => $this->conversation->unread_count,
            'assigned_user_id' => $this->conversation->assigned_user_id,
            'last_message_at' => $this->conversation->last_message_at?->toIso8601String(),
        ];
    }
}
