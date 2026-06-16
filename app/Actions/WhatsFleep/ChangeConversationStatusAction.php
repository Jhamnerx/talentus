<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\ConversationStatus;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Gate;

class ChangeConversationStatusAction
{
    public function execute(WhatsappConversation $conversation, ConversationStatus $status, User $actor): WhatsappConversation
    {
        Gate::forUser($actor)->authorize('changeStatus', $conversation);

        $conversation->forceFill([
            'status' => $status,
            'closed_at' => $status === ConversationStatus::Closed ? now() : null,
        ])->save();

        broadcast(new ConversationUpdated($conversation));

        return $conversation;
    }
}
