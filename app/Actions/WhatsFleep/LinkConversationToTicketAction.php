<?php

namespace App\Actions\WhatsFleep;

use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Gate;

class LinkConversationToTicketAction
{
    public function execute(WhatsappConversation $conversation, int $ticketId, User $actor): void
    {
        Gate::forUser($actor)->authorize('reply', $conversation);

        $ticket = Ticket::withoutGlobalScope(EmpresaScope::class)->findOrFail($ticketId);

        if ((int) $ticket->empresa_id !== (int) $conversation->empresa_id) {
            throw new \InvalidArgumentException('El ticket no pertenece a la misma empresa que la conversación.');
        }

        $conversation->forceFill(['ticket_id' => $ticketId])->save();

        broadcast(new ConversationUpdated($conversation));
    }
}
