<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Models\TicketEvent;
use App\Models\TicketMessage;
use App\Enums\TicketEventType;
use Illuminate\Support\Facades\DB;

class AddMessageAction
{
    /**
     * Add a message to a ticket and log the event.
     *
     * @param Ticket $ticket
     * @param array $data
     * @param int $authorId
     * @return TicketMessage
     */
    public function execute(Ticket $ticket, array $data, int $authorId): TicketMessage
    {
        return DB::transaction(function () use ($ticket, $data, $authorId) {
            // Crear el mensaje
            $message = TicketMessage::create([
                'ticket_id' => $ticket->id,
                'author_id' => $authorId,
                'body' => $data['body'],
                'is_internal' => $data['is_internal'] ?? false,
            ]);

            // Actualizar last_activity_at del ticket
            $ticket->update(['last_activity_at' => now()]);

            // Si es el primer mensaje de staff (no interno), actualizar first_response_at
            if (!$message->is_internal && !$ticket->first_response_at) {
                // Verificar si el autor es staff (no el cliente que creó el ticket)
                if ($authorId !== $ticket->created_by) {
                    $ticket->update(['first_response_at' => now()]);
                }
            }

            // Registrar evento
            TicketEvent::create([
                'ticket_id' => $ticket->id,
                'actor_id' => $authorId,
                'type' => $message->is_internal ? TicketEventType::INTERNAL_NOTE->value : TicketEventType::MESSAGE_ADDED->value,
                'payload' => [
                    'message_id' => $message->id,
                    'body_preview' => substr($message->body, 0, 100),
                ],
                'created_at' => now(),
            ]);

            return $message->fresh('author');
        });
    }
}
