<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Models\WhatsFleep\WhatsappMessage;
use App\Services\WhatsFleep\WhatsappService;
use Illuminate\Support\Facades\Gate;
use Throwable;

class SendWhatsappMessageAction
{
    public function __construct(private WhatsappService $whatsapp)
    {
    }

    /**
     * Persiste el mensaje del agente ANTES de enviarlo y delega el envío al
     * WhatsappService existente. El estado evoluciona con los acks vía /status.
     */
    public function execute(WhatsappConversation $conversation, User $sender, string $body): WhatsappMessage
    {
        Gate::forUser($sender)->authorize('reply', $conversation);

        $message = WhatsappMessage::create([
            'empresa_id' => $conversation->empresa_id,
            'conversation_id' => $conversation->id,
            'device_id' => $conversation->device_id,
            'contact_id' => $conversation->contact_id,
            'sender_type' => MessageSenderType::Agent,
            'sender_user_id' => $sender->id,
            'type' => MessageType::Text,
            'body' => $body,
            'status' => MessageStatus::Pending,
        ]);

        try {
            $device = $conversation->device;
            $number = $conversation->contact->number;
            $response = $this->whatsapp->sendText($device->body, $number, $body);

            $waMessageId = data_get((array) $response, 'key.id')
                ?? data_get((array) $response, 'messageId');

            $message->forceFill([
                'wa_message_id' => $waMessageId,
                'status' => MessageStatus::Sent,
                'sent_at' => now(),
            ])->save();
        } catch (Throwable $e) {
            $message->forceFill([
                'status' => MessageStatus::Failed,
                'metadata' => ['error' => $e->getMessage()],
            ])->save();
        }

        return $message;
    }
}
