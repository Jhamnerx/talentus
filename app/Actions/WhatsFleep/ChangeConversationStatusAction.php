<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\ConversationStatus;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\WhatsFleep\WhatsappConversation;

class ChangeConversationStatusAction
{
    public function execute(WhatsappConversation $conversation, ConversationStatus $status): WhatsappConversation
    {
        $conversation->forceFill([
            'status' => $status,
            'closed_at' => $status === ConversationStatus::Closed ? now() : null,
        ])->save();

        broadcast(new ConversationUpdated($conversation));

        return $conversation;
    }
}
