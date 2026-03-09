<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use App\Models\TicketEvent;
use App\Enums\TicketEventType;
use App\Models\TicketSequence;
use Illuminate\Support\Facades\DB;

class CreateTicketAction
{
    /**
     * Create a new ticket with code generation and event logging.
     *
     * @param array $data
     * @param int $createdByUserId
     * @return Ticket
     */
    public function execute(array $data, int $createdByUserId): Ticket
    {
        return DB::transaction(function () use ($data, $createdByUserId) {
            // Generar código único para el ticket
            $code = $this->generateTicketCode($data['empresa_id']);

            // Crear el ticket
            $ticket = Ticket::create([
                'empresa_id' => $data['empresa_id'],
                'code' => $code,
                'subject' => $data['subject'],
                'description' => $data['description'],
                'status' => TicketStatus::NEW->value,
                'priority' => $data['priority'],
                'category_id' => $data['category_id'] ?? null,
                'customer_id' => $data['customer_id'],
                'created_by' => $createdByUserId,
                'team_id' => $data['team_id'] ?? null,
                'assigned_to' => $data['assigned_to'] ?? null,
                'last_activity_at' => now(),
            ]);

            // Registrar evento de creación
            TicketEvent::create([
                'ticket_id' => $ticket->id,
                'actor_id' => $createdByUserId,
                'type' => TicketEventType::CREATED->value,
                'payload' => [
                    'subject' => $ticket->subject,
                    'priority' => $ticket->priority->value,
                    'customer_id' => $ticket->customer_id,
                ],
                'created_at' => now(),
            ]);

            // Si se asignó equipo o agente, registrar esos eventos
            if ($ticket->team_id) {
                TicketEvent::create([
                    'ticket_id' => $ticket->id,
                    'actor_id' => $createdByUserId,
                    'type' => TicketEventType::TEAM_CHANGED->value,
                    'payload' => [
                        'before' => null,
                        'after' => $ticket->team_id,
                    ],
                    'created_at' => now(),
                ]);
            }

            if ($ticket->assigned_to) {
                TicketEvent::create([
                    'ticket_id' => $ticket->id,
                    'actor_id' => $createdByUserId,
                    'type' => TicketEventType::ASSIGNED_CHANGED->value,
                    'payload' => [
                        'before' => null,
                        'after' => $ticket->assigned_to,
                    ],
                    'created_at' => now(),
                ]);
            }

            return $ticket->fresh(['customer', 'createdBy', 'team', 'assignedTo', 'category']);
        });
    }

    /**
     * Generate unique ticket code: TK-{YEAR}-{SEQUENCE}
     *
     * @param int $empresaId
     * @return string
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
}
