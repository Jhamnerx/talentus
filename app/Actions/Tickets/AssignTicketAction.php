<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Models\TicketEvent;
use App\Enums\TicketEventType;
use Illuminate\Support\Facades\DB;

class AssignTicketAction
{
    /**
     * Assign ticket to team and/or agent.
     *
     * @param Ticket $ticket
     * @param array $data
     * @param int $actorId
     * @return Ticket
     */
    public function execute(Ticket $ticket, array $data, int $actorId): Ticket
    {
        return DB::transaction(function () use ($ticket, $data, $actorId) {
            $oldTeamId = $ticket->team_id;
            $oldAssignedTo = $ticket->assigned_to;

            // Actualizar asignación
            $ticket->update([
                'team_id' => $data['team_id'] ?? $ticket->team_id,
                'assigned_to' => $data['assigned_to'] ?? $ticket->assigned_to,
                'last_activity_at' => now(),
            ]);

            // Registrar evento de cambio de equipo si cambió
            if (array_key_exists('team_id', $data) && $oldTeamId !== $data['team_id']) {
                TicketEvent::create([
                    'ticket_id' => $ticket->id,
                    'actor_id' => $actorId,
                    'type' => TicketEventType::TEAM_CHANGED->value,
                    'payload' => [
                        'before' => $oldTeamId,
                        'after' => $data['team_id'],
                    ],
                    'created_at' => now(),
                ]);
            }

            // Registrar evento de cambio de agente si cambió
            if (array_key_exists('assigned_to', $data) && $oldAssignedTo !== $data['assigned_to']) {
                TicketEvent::create([
                    'ticket_id' => $ticket->id,
                    'actor_id' => $actorId,
                    'type' => TicketEventType::ASSIGNED_CHANGED->value,
                    'payload' => [
                        'before' => $oldAssignedTo,
                        'after' => $data['assigned_to'],
                    ],
                    'created_at' => now(),
                ]);
            }

            return $ticket->fresh(['team', 'assignedTo']);
        });
    }
}
