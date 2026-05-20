<?php

namespace App\Jobs;

use App\Enums\TicketEventType;
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
        // ── Nivel 0 → 1: primer aviso por SLA vencido ──
        Ticket::withoutGlobalScope(EmpresaScope::class)
            ->open()
            ->whereNotNull('due_at')
            ->where('due_at', '<', now())
            ->where('escalation_level', 0)
            ->with(['assignedTo', 'customer'])
            ->each(function (Ticket $ticket) use ($wa) {
                if ($ticket->assignedTo && $ticket->assignedTo->telefonos) {
                    $wa->sendMessage(
                        $ticket->assignedTo->telefonos,
                        "⚠️ *TICKET SLA VENCIDO*\n\n"
                            . "Ticket: *{$ticket->code}*\n"
                            . "Asunto: {$ticket->subject}\n"
                            . "Cliente: " . ($ticket->customer->razon_social ?? 'N/A') . "\n"
                            . "Venció: " . $ticket->due_at->format('d/m/Y H:i') . "\n\n"
                            . "Por favor atiende este ticket urgentemente."
                    );
                }

                $ticket->withoutTimestamps(fn() => $ticket->update(['escalation_level' => 1]));

                TicketEvent::create([
                    'ticket_id' => $ticket->id,
                    'type'      => TicketEventType::ESCALATED->value,
                    'actor_id'  => null,
                    'payload'   => ['level' => 1, 'reason' => 'SLA vencido — aviso al agente'],
                ]);
            });

        // ── Nivel 1 → 2: escalar a administradores (24h después del primer aviso) ──
        Ticket::withoutGlobalScope(EmpresaScope::class)
            ->open()
            ->whereNotNull('due_at')
            ->where('due_at', '<', now()->subHours(24))
            ->where('escalation_level', 1)
            ->with(['assignedTo', 'customer'])
            ->each(function (Ticket $ticket) use ($wa) {
                // Notificar a todos los admins de la empresa
                User::whereHas('roles', fn($q) => $q->where('name', 'admin'))
                    ->whereNotNull('telefonos')
                    ->each(function (User $admin) use ($ticket, $wa) {
                        $wa->sendMessage(
                            $admin->telefonos,
                            "🚨 *ESCALAMIENTO CRÍTICO*\n\n"
                                . "Ticket: *{$ticket->code}*\n"
                                . "Asunto: {$ticket->subject}\n"
                                . "Cliente: " . ($ticket->customer->razon_social ?? 'N/A') . "\n"
                                . "Asignado a: " . ($ticket->assignedTo->name ?? 'Sin asignar') . "\n"
                                . "SLA vencido: " . $ticket->due_at->format('d/m/Y H:i') . "\n\n"
                                . "Este ticket requiere atención inmediata."
                        );
                    });

                $ticket->withoutTimestamps(fn() => $ticket->update(['escalation_level' => 2]));

                TicketEvent::create([
                    'ticket_id' => $ticket->id,
                    'type'      => TicketEventType::ESCALATED->value,
                    'actor_id'  => null,
                    'payload'   => ['level' => 2, 'reason' => 'Escalado a administrador'],
                ]);
            });
    }
}
