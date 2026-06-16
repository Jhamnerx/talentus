<?php

namespace App\Actions\WhatsFleep;

use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Gate;

class UnlinkConversationFromTicketAction
{
    public function execute(WhatsappConversation $conversation, User $actor): void
    {
        Gate::forUser($actor)->authorize('reply', $conversation);

        $conversation->forceFill(['ticket_id' => null])->save();

        broadcast(new ConversationUpdated($conversation));
    }
}
