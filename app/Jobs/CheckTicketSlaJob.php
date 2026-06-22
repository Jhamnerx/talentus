<?php

namespace App\Jobs;

use App\Enums\TicketEventType;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketEvent;
use App\Models\User;
use App\Scopes\EmpresaScope;
use App\Services\TicketWhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckTicketSlaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(TicketWhatsAppService $wa): void
    {
        $this->escalateToTeamLeader($wa);
        $this->escalateToGerencia($wa);
    }

    /**
     * Nivel 0 → 1: TR superado sin primera respuesta.
     * Notifica al líder del equipo asignado al ticket.
     * Si el ticket no tiene equipo o el equipo no tiene líder, notifica al agente asignado.
     */
    private function escalateToTeamLeader(TicketWhatsAppService $wa): void
    {
        Ticket::withoutGlobalScope(EmpresaScope::class)
            ->open()
            ->whereNotNull('due_at')
            ->where('due_at', '<', now())
            ->where('escalation_level', 0)
            ->with(['team.leaders', 'assignedTo', 'customer'])
            ->each(function (Ticket $ticket) use ($wa) {
                $notified = false;

                // Intentar notificar al líder del equipo
                if ($ticket->team) {
                    foreach ($ticket->team->leaders as $leader) {
                        if ($leader->telefonos) {
                            $wa->sendMessage(
                                $leader->telefonos,
                                $this->buildLeaderMessage($ticket, $leader->name)
                            );
                            $notified = true;
                        }
                    }
                }

                // Fallback: si no hay equipo ni líder, avisar al agente asignado
                if (!$notified && $ticket->assignedTo?->telefonos) {
                    $wa->sendMessage(
                        $ticket->assignedTo->telefonos,
                        $this->buildLeaderMessage($ticket, $ticket->assignedTo->name)
                    );
                }

                $ticket->withoutTimestamps(fn () => $ticket->update(['escalation_level' => 1]));

                TicketEvent::create([
                    'ticket_id' => $ticket->id,
                    'type'      => TicketEventType::ESCALATED->value,
                    'actor_id'  => null,
                    'payload'   => [
                        'level'     => 1,
                        'reason'    => 'TR (tiempo de respuesta SLA) superado',
                        'due_at'    => $ticket->due_at?->toIso8601String(),
                        'team_name' => $ticket->team?->name,
                    ],
                ]);
            });
    }

    /**
     * Nivel 1 → 2: TS superado, ticket aún sin resolver.
     * Notifica a todos los miembros del equipo de gerencia.
     * Fallback: usuarios con rol 'admin' si no existe equipo gerencia.
     */
    private function escalateToGerencia(TicketWhatsAppService $wa): void
    {
        Ticket::withoutGlobalScope(EmpresaScope::class)
            ->open()
            ->where('escalation_level', 1)
            ->where(function ($q) {
                // Escalar cuando vence ts_at, o bien due_at + 24h si no hay ts_at
                $q->where(fn ($q2) => $q2->whereNotNull('ts_at')->where('ts_at', '<', now()))
                  ->orWhere(fn ($q2) => $q2->whereNull('ts_at')->whereNotNull('due_at')->where('due_at', '<', now()->subHours(24)));
            })
            ->with(['customer', 'assignedTo', 'team'])
            ->each(function (Ticket $ticket) use ($wa) {
                $gerenciaUsers = $this->getGerenciaUsers($ticket->empresa_id);

                foreach ($gerenciaUsers as $manager) {
                    if ($manager->telefonos) {
                        $wa->sendMessage(
                            $manager->telefonos,
                            $this->buildGerenciaMessage($ticket)
                        );
                    }
                }

                $ticket->withoutTimestamps(fn () => $ticket->update(['escalation_level' => 2]));

                TicketEvent::create([
                    'ticket_id' => $ticket->id,
                    'type'      => TicketEventType::ESCALATED->value,
                    'actor_id'  => null,
                    'payload'   => [
                        'level'  => 2,
                        'reason' => 'TS (tiempo de restauración SLA) superado — escalado a gerencia',
                        'ts_at'  => $ticket->ts_at?->toIso8601String(),
                    ],
                ]);
            });
    }

    /**
     * Obtiene los usuarios de gerencia para la empresa del ticket.
     * Primero busca el equipo con kpi_area = 'gerencia'; si no existe, busca roles admin.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    private function getGerenciaUsers(int $empresaId): \Illuminate\Database\Eloquent\Collection
    {
        $gerenciaTeam = Team::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresaId)
            ->where('kpi_area', 'gerencia')
            ->where('is_active', true)
            ->first();

        if ($gerenciaTeam) {
            return $gerenciaTeam->users()->whereNotNull('telefonos')->get();
        }

        // Fallback: usuarios con rol admin (mismo criterio que usaba el job original)
        return User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))
            ->whereNotNull('telefonos')
            ->get();
    }

    private function buildLeaderMessage(Ticket $ticket, string $recipientName): string
    {
        $tier      = app(\App\Services\SlaPlanResolver::class)->tierForTicket($ticket);
        $planLabel = \App\Models\SlaPlanRule::planLabel($tier);

        return "⚠️ *ESCALAMIENTO NIVEL 1 — SLA TR VENCIDO*\n\n"
            . "Hola {$recipientName},\n"
            . "El siguiente ticket superó el tiempo de respuesta comprometido:\n\n"
            . "Ticket: *{$ticket->code}*\n"
            . "Asunto: {$ticket->subject}\n"
            . "Cliente: " . ($ticket->customer?->razon_social ?? 'N/A') . "\n"
            . "Plan SLA: {$planLabel}\n"
            . "Prioridad: " . strtoupper($ticket->priority->value) . "\n"
            . "TR vencido: " . $ticket->due_at?->format('d/m/Y H:i') . "\n"
            . "Asignado a: " . ($ticket->assignedTo?->name ?? 'Sin asignar') . "\n\n"
            . "Por favor revisa y gestiona urgentemente.";
    }

    private function buildGerenciaMessage(Ticket $ticket): string
    {
        return "🚨 *ESCALAMIENTO NIVEL 2 — SLA TS VENCIDO — GERENCIA*\n\n"
            . "Ticket: *{$ticket->code}*\n"
            . "Asunto: {$ticket->subject}\n"
            . "Cliente: " . ($ticket->customer?->razon_social ?? 'N/A') . "\n"
            . "Prioridad: " . strtoupper($ticket->priority->value) . "\n"
            . "TS vencido: " . ($ticket->ts_at ?? $ticket->due_at)?->format('d/m/Y H:i') . "\n"
            . "Asignado a: " . ($ticket->assignedTo?->name ?? 'Sin asignar') . "\n"
            . "Equipo: " . ($ticket->team?->name ?? 'Sin equipo') . "\n\n"
            . "Este ticket requiere atención inmediata de gerencia.";
    }
}
