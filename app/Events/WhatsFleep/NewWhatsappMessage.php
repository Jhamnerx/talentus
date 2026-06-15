<?php

namespace App\Events\WhatsFleep;

use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewWhatsappMessage implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public WhatsappMessage $message)
    {
    }

    /**
     * @return array<int, PrivateChannel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('whatsapp.conversation.' . $this->message->conversation->uuid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'wa.message.new';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'uuid' => $this->message->uuid,
            'conversation_id' => $this->message->conversation_id,
            'sender_type' => $this->message->sender_type->value,
            'type' => $this->message->type->value,
            'body' => $this->message->body,
            'media_url' => $this->message->mediaUrl(),
            'status' => $this->message->status->value,
            'created_at' => $this->message->created_at?->toIso8601String(),
        ];
    }
}
