<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Support\Carbon;

class PersistIncomingMessageAction
{
    /**
     * Persiste el mensaje entrante de forma idempotente y actualiza la conversación.
     *
     * @param  array<string, mixed>  $payload
     */
    public function execute(
        WhatsappConversation $conversation,
        Device $device,
        Contact $contact,
        array $payload
    ): WhatsappMessage {
        $type = MessageType::tryFrom($payload['type'] ?? 'text') ?? MessageType::Text;
        $sentAt = isset($payload['timestamp'])
            ? Carbon::createFromTimestamp((int) $payload['timestamp'], config('app.timezone'))
            : now();

        $message = WhatsappMessage::firstOrCreate(
            [
                'device_id' => $device->id,
                'wa_message_id' => $payload['wa_message_id'],
            ],
            [
                'empresa_id' => $conversation->empresa_id,
                'conversation_id' => $conversation->id,
                'contact_id' => $contact->id,
                'sender_type' => MessageSenderType::Contact,
                'type' => $type,
                'body' => $payload['body'] ?? null,
                'media_path' => $payload['media_path'] ?? null,
                'mime_type' => $payload['mime_type'] ?? null,
                'file_name' => $payload['file_name'] ?? null,
                'file_size' => $payload['file_size'] ?? null,
                'status' => MessageStatus::Delivered,
                'is_read' => false,
                'sent_at' => $sentAt,
                'delivered_at' => now(),
            ]
        );

        if (! $message->wasRecentlyCreated) {
            return $message;
        }

        $conversation->forceFill([
            'last_message_id' => $message->id,
            'last_message_at' => $message->sent_at,
            'unread_count' => $conversation->unread_count + 1,
        ])->save();

        return $message;
    }
}
