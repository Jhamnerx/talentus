<?php

namespace App\Actions\WhatsFleep;

use App\Models\WhatsFleep\WhatsappConversation;
use App\Services\WhatsFleep\WhatsappService;

class SyncWhatsappHistoryAction
{
    public function __construct(private WhatsappService $whatsapp)
    {
    }

    /**
     * Pide a Baileys los 50 mensajes anteriores al más antiguo que ya
     * tenemos para esta conversación. No hace nada si no hay ningún
     * mensaje conocido (no hay punto de referencia desde donde pedir).
     */
    public function execute(WhatsappConversation $conversation): void
    {
        $oldest = $conversation->messages()->oldest('sent_at')->first();

        if (! $oldest || ! $oldest->wa_message_id) {
            return;
        }

        $device = $conversation->device;
        $jid = $conversation->contact->wa_jid ?: $conversation->contact->number;

        $this->whatsapp->syncHistory(
            $device->body,
            $jid,
            50,
            [
                'remoteJid' => $jid,
                'fromMe' => $oldest->sender_type->value === 'agent',
                'id' => $oldest->wa_message_id,
            ],
            $oldest->sent_at->getTimestampMs()
        );
    }
}
