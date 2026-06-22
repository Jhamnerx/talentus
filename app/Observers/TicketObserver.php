<?php

namespace App\Observers;

use App\Enums\TicketPriority;
use App\Models\Ticket;
use App\Models\TicketSequence;
use App\Models\TicketEvent;
use App\Enums\TicketEventType;
use App\Models\User;
use App\Scopes\EmpresaScope;
use App\Services\SlaCalculatorService;
use App\Services\SlaPlanResolver;

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

        // Calcular due_at (TR) y ts_at (TS) según el plan SLA del cliente
        if (empty($ticket->due_at) && !empty($ticket->priority)) {
            $sla       = app(SlaCalculatorService::class);
            $priority  = $ticket->priority instanceof TicketPriority ? $ticket->priority->value : $ticket->priority;
            $planType  = $this->resolveSlaPlan($ticket);
            $startTime = $sla->slaStartsAt($ticket->scheduled_at, now());

            $ticket->due_at = $sla->calculateDueAt($planType, $priority, $startTime);
            $ticket->ts_at  = $sla->calculateTsAt($planType, $priority, $startTime);
        }

        // Auto-asignar si no hay asignado: agente con menos tickets abiertos
        if (empty($ticket->assigned_to)) {
            $ticket->assigned_to = $this->getAutoAssignUser($ticket->empresa_id);
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
                    'assigned_name' => $ticket->assignedTo->name ?? 'N/A',
                ],
            ]);
        }
    }

    /**
     * Resolves the SLA tier for a ticket from the plan of its vehicle/customer.
     */
    protected function resolveSlaPlan(Ticket $ticket): string
    {
        return app(SlaPlanResolver::class)->tierForTicket($ticket);
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
     * Auto-asignar al agente con menos tickets abiertos en la empresa.
     */
    protected function getAutoAssignUser(int $empresaId): ?int
    {
        return User::whereHas('roles', fn($q) => $q->whereIn('name', ['agente', 'admin']))
            ->withCount(['assignedTickets as open_count' => function ($q) use ($empresaId) {
                $q->withoutGlobalScope(EmpresaScope::class)
                    ->where('empresa_id', $empresaId)
                    ->whereNotIn('status', ['resolved', 'closed']);
            }])
            ->orderBy('open_count')
            ->value('id');
    }

    /**
     * Handle the Ticket "updating" event.
     * Recalcula los plazos SLA cuando cambia la prioridad o la fecha programada.
     */
    public function updating(Ticket $ticket): void
    {
        if (!$ticket->isDirty('priority') && !$ticket->isDirty('scheduled_at')) {
            return;
        }

        $sla       = app(SlaCalculatorService::class);
        $priority  = $ticket->priority instanceof TicketPriority ? $ticket->priority->value : $ticket->priority;
        $planType  = $this->resolveSlaPlan($ticket);
        $startTime = $sla->slaStartsAt($ticket->scheduled_at, $ticket->created_at ?? now());

        $ticket->due_at = $sla->calculateDueAt($planType, $priority, $startTime);
        $ticket->ts_at  = $sla->calculateTsAt($planType, $priority, $startTime);

        // Si el ticket sigue abierto y se reprograma a futuro, ya no está vencido:
        // reiniciar el nivel de escalamiento para que el reloj corra desde cero.
        if ($ticket->isOpen() && $startTime->isFuture()) {
            $ticket->escalation_level = 0;
        }
    }

    /**
     * Handle the Ticket "updated" event.
     * Registra el recálculo de SLA para mantener la trazabilidad.
     */
    public function updated(Ticket $ticket): void
    {
        if (!$ticket->wasChanged('due_at') && !$ticket->wasChanged('ts_at')) {
            return;
        }

        TicketEvent::create([
            'ticket_id' => $ticket->id,
            'type'      => TicketEventType::SLA_RECALCULATED->value,
            'actor_id'  => \Illuminate\Support\Facades\Auth::id(),
            'payload'   => [
                'scheduled_at' => $ticket->scheduled_at?->toIso8601String(),
                'due_at'       => $ticket->due_at?->toIso8601String(),
                'ts_at'        => $ticket->ts_at?->toIso8601String(),
                'priority'     => $ticket->priority instanceof TicketPriority ? $ticket->priority->value : $ticket->priority,
            ],
        ]);
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
