<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use App\Models\TicketEvent;
use App\Enums\TicketEventType;
use Illuminate\Support\Facades\DB;

class ChangeTicketStatusAction
{
    /**
     * Change ticket status and update related timestamps.
     *
     * @param Ticket $ticket
     * @param string $newStatus
     * @param int $actorId
     * @param string|null $comment
     * @return Ticket
     */
    public function execute(Ticket $ticket, string $newStatus, int $actorId, ?string $comment = null): Ticket
    {
        return DB::transaction(function () use ($ticket, $newStatus, $actorId, $comment) {
            $oldStatus = $ticket->status;
            $newStatusEnum = TicketStatus::from($newStatus);

            // Validar transición (básico)
            // TODO: Implementar lógica de transiciones más estricta si es necesario

            // Actualizar el estado
            $updateData = [
                'status' => $newStatusEnum,
                'last_activity_at' => now(),
            ];

            // Actualizar timestamps según el estado
            if ($newStatusEnum === TicketStatus::RESOLVED && !$ticket->resolved_at) {
                $updateData['resolved_at'] = now();
            }

            if ($newStatusEnum === TicketStatus::CLOSED && !$ticket->closed_at) {
                $updateData['closed_at'] = now();
            }

            // Si se reabre, limpiar timestamps de cierre
            if (in_array($newStatusEnum, [TicketStatus::OPEN, TicketStatus::IN_PROGRESS])) {
                if ($ticket->resolved_at || $ticket->closed_at) {
                    $updateData['resolved_at'] = null;
                    $updateData['closed_at'] = null;
                }
            }

            $ticket->update($updateData);

            // Registrar evento
            $eventType = ($oldStatus === TicketStatus::CLOSED || $oldStatus === TicketStatus::RESOLVED)
                && in_array($newStatusEnum, [TicketStatus::OPEN, TicketStatus::IN_PROGRESS])
                ? TicketEventType::REOPENED
                : TicketEventType::STATUS_CHANGED;

            TicketEvent::create([
                'ticket_id' => $ticket->id,
                'actor_id' => $actorId,
                'type' => $eventType->value,
                'payload' => [
                    'before' => $oldStatus->value,
                    'after' => $newStatusEnum->value,
                    'comment' => $comment,
                ],
                'created_at' => now(),
            ]);

            return $ticket->fresh();
        });
    }
}
