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
use Illuminate\Support\Facades\Storage;
use Throwable;

class SendWhatsappMediaAction
{
    public function __construct(private WhatsappService $whatsapp)
    {
    }

    /**
     * Persiste un mensaje saliente con adjunto (ya guardado en disco privado) y
     * lo envía por el Node pasando la RUTA LOCAL del archivo (disco compartido).
     *
     * @param  array{media_path:string, mime_type:?string, file_name:?string, file_size:?int, caption:?string}  $media
     */
    public function execute(WhatsappConversation $conversation, User $sender, MessageType $type, array $media): WhatsappMessage
    {
        Gate::forUser($sender)->authorize('reply', $conversation);

        $message = WhatsappMessage::create([
            'empresa_id' => $conversation->empresa_id,
            'conversation_id' => $conversation->id,
            'device_id' => $conversation->device_id,
            'contact_id' => $conversation->contact_id,
            'sender_type' => MessageSenderType::Agent,
            'sender_user_id' => $sender->id,
            'type' => $type,
            'body' => $media['caption'] ?? null,
            'media_path' => $media['media_path'],
            'mime_type' => $media['mime_type'] ?? null,
            'file_name' => $media['file_name'] ?? null,
            'file_size' => $media['file_size'] ?? null,
            'status' => MessageStatus::Pending,
        ]);

        try {
            $device = $conversation->device;
            $number = $conversation->contact->wa_jid ?: $conversation->contact->number;
            $absolutePath = Storage::disk(config('whatsapp.media_disk', 'local'))->path($media['media_path']);

            $response = $this->whatsapp->sendMedia(
                $device->body,
                $number,
                $type->value,
                $absolutePath,
                $media['caption'] ?? '',
                $media['file_name'] ?? ''
            );

            $waMessageId = data_get((array) $response, 'key.id') ?? data_get((array) $response, 'messageId');

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
