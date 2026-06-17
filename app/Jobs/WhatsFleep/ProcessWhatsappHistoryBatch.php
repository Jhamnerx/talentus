<?php

namespace App\Jobs\WhatsFleep;

use App\Actions\WhatsFleep\ResolveConversationAction;
use App\Actions\WhatsFleep\ResolveWhatsappContactAction;
use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Events\WhatsFleep\HistorySynced;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessWhatsappHistoryBatch implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(public array $payload)
    {
        $this->onQueue('whatsapp');
    }

    public function handle(
        ResolveWhatsappContactAction $resolveContact,
        ResolveConversationAction $resolveConversation
    ): void {
        $device = Device::where('body', $this->payload['device'])->first();

        if (! $device) {
            Log::warning('WA history: device not found', ['device' => $this->payload['device']]);
            return;
        }

        /** @var array<string, array{contact: \App\Models\WhatsFleep\Contact, conversation: \App\Models\WhatsFleep\WhatsappConversation}> $resolvedByJid */
        $resolvedByJid = [];

        foreach ($this->payload['messages'] as $messagePayload) {
            $waJid = $messagePayload['wa_jid'] ?? null;
            if (! $waJid) {
                continue;
            }

            DB::transaction(function () use (
                $messagePayload,
                $waJid,
                $device,
                $resolveContact,
                $resolveConversation,
                &$resolvedByJid
            ) {
                if (! isset($resolvedByJid[$waJid])) {
                    $resolved = $resolveContact->execute(
                        $device,
                        $messagePayload['from'],
                        $waJid,
                        $messagePayload['push_name'] ?? null
                    );

                    $conversation = $resolveConversation->execute(
                        $device,
                        $resolved['contact'],
                        $resolved['empresa_id'],
                        $resolved['cliente_id']
                    );

                    $resolvedByJid[$waJid] = ['contact' => $resolved['contact'], 'conversation' => $conversation];
                }

                ['contact' => $contact, 'conversation' => $conversation] = $resolvedByJid[$waJid];

                $type = MessageType::tryFrom($messagePayload['type'] ?? 'text') ?? MessageType::Text;
                $sentAt = isset($messagePayload['timestamp'])
                    ? Carbon::createFromTimestamp((int) $messagePayload['timestamp'])
                    : now();
                $fromMe = (bool) ($messagePayload['from_me'] ?? false);

                WhatsappMessage::firstOrCreate(
                    [
                        'device_id' => $device->id,
                        'wa_message_id' => $messagePayload['wa_message_id'],
                    ],
                    [
                        'empresa_id' => $conversation->empresa_id,
                        'conversation_id' => $conversation->id,
                        'contact_id' => $contact->id,
                        'sender_type' => $fromMe ? MessageSenderType::Agent : MessageSenderType::Contact,
                        'type' => $type,
                        'body' => $messagePayload['body'] ?? null,
                        // Los mensajes históricos no deben generar "no leídos" para
                        // algo que ya ocurrió antes de que el agente sincronizara.
                        'status' => $fromMe ? MessageStatus::Sent : MessageStatus::Delivered,
                        'is_read' => true,
                        'sent_at' => $sentAt,
                    ]
                );
            });
        }

        foreach ($resolvedByJid as ['conversation' => $conversation]) {
            $latest = $conversation->messages()->latest('sent_at')->first();

            if ($latest) {
                $conversation->forceFill([
                    'last_message_id' => $latest->id,
                    'last_message_at' => $latest->sent_at,
                ])->save();
            }

            broadcast(new HistorySynced($conversation));
        }
    }
}
