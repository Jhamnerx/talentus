<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\WhatsFleep\WhatsappConversation;

class MarkConversationReadAction
{
    /**
     * Marca como leídos (solo interno) los mensajes entrantes no leídos de la
     * conversación y pone unread_count=0. No envía "visto" al cliente.
     */
    public function execute(WhatsappConversation $conversation): void
    {
        if ($conversation->unread_count === 0) {
            return;
        }

        $conversation->messages()
            ->where('sender_type', MessageSenderType::Contact->value)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversation->forceFill(['unread_count' => 0])->save();

        broadcast(new ConversationUpdated($conversation));
    }
}
