<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\TicketSequence;
use App\Models\TicketEvent;
use App\Enums\TicketEventType;

class TicketObserver
{
    /**
     * Handle the Ticket "creating" event.
     */
    public function creating(Ticket $ticket): void
    {
        // Asignar empresa_id desde la sesión si no tiene
        if (empty($ticket->empresa_id)) {
            $ticket->empresa_id = session('empresa', 1);
        }

        // Generar código único si no tiene
        if (empty($ticket->code)) {
            $ticket->code = $this->generateTicketCode($ticket->empresa_id);
        }

        // Establecer timestamps iniciales
        $ticket->last_activity_at = now();
    }

    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        // Registrar evento de creación
        TicketEvent::create([
            'ticket_id' => $ticket->id,
            'type' => TicketEventType::CREATED->value,
            'actor_id' => $ticket->created_by,
            'payload' => [
                'status' => $ticket->status->value,
                'priority' => $ticket->priority->value,
            ],
        ]);

        // Registrar evento de asignación de equipo si aplica
        if ($ticket->team_id) {
            TicketEvent::create([
                'ticket_id' => $ticket->id,
                'type' => TicketEventType::TEAM_CHANGED->value,
                'actor_id' => $ticket->created_by,
                'payload' => [
                    'team_id' => $ticket->team_id,
                    'team_name' => $ticket->team->name,
                ],
            ]);
        }

        // Registrar evento de asignación de usuario si aplica
        if ($ticket->assigned_to) {
            TicketEvent::create([
                'ticket_id' => $ticket->id,
                'type' => TicketEventType::ASSIGNED_CHANGED->value,
                'actor_id' => $ticket->created_by,
                'payload' => [
                    'assigned_to' => $ticket->assigned_to,
                    'assigned_name' => $ticket->assignedTo->name,
                ],
            ]);
        }
    }

    /**
     * Generate unique ticket code: TK-{YEAR}-{SEQUENCE}
     */
    protected function generateTicketCode(int $empresaId): string
    {
        $year = now()->year;

        // Obtener o crear secuencia para este año y empresa (con lock para evitar duplicados)
        $sequence = TicketSequence::lockForUpdate()
            ->firstOrCreate(
                ['empresa_id' => $empresaId, 'year' => $year],
                ['last_number' => 0]
            );

        // Incrementar el número
        $sequence->increment('last_number');
        $sequence->refresh();

        // Formatear código: TK-2026-000001
        return sprintf('TK-%d-%06d', $year, $sequence->last_number);
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
