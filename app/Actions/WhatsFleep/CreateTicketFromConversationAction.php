<?php

namespace App\Actions\WhatsFleep;

use App\Actions\Tickets\CreateTicketAction;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Gate;

class CreateTicketFromConversationAction
{
    public function __construct(
        private readonly CreateTicketAction $createTicket,
        private readonly LinkConversationToTicketAction $linkToTicket,
    ) {}

    public function execute(WhatsappConversation $conversation, array $data, User $actor): Ticket
    {
        Gate::forUser($actor)->authorize('reply', $conversation);

        if (! $conversation->cliente_id) {
            throw new \LogicException('No se puede crear un ticket sin cliente vinculado a la conversación.');
        }

        $ticket = $this->createTicket->execute([
            'empresa_id'  => $conversation->empresa_id,
            'subject'     => $data['subject'],
            'description' => $data['description'],
            'priority'    => $data['priority'],
            'category_id' => $data['category_id'] ?? null,
            'customer_id' => $conversation->cliente_id,
        ], $actor->id);

        $this->linkToTicket->execute($conversation, $ticket->id, $actor);

        return $ticket;
    }
}
