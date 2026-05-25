<?php

namespace App\Mail;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Ticket $ticket,
        public string $messageBody,
        public string $eventType = 'update'  // 'created' | 'closed'
    ) {}

    public function envelope(): Envelope
    {
        $fromEmail = config('mail.from.address', '') ?? '';
        $fromName  = config('mail.from.name', 'Soporte') ?? 'Soporte';

        $subjectPrefix = match ($this->eventType) {
            'created' => '[Nuevo ticket]',
            'closed'  => '[Cerrado]',
            default   => '[Actualización]',
        };

        return new Envelope(
            from: new Address($fromEmail, $fromName),
            subject: "{$subjectPrefix} [{$this->ticket->code}] {$this->ticket->subject}",
        );
    }

    public function content(): Content
    {
        $history = collect();

        if ($this->eventType === 'closed') {
            $this->ticket->loadMissing(['events.actor', 'messages.author', 'assignedTo', 'category']);

            $events = $this->ticket->events->map(fn($e) => [
                'type'        => 'event',
                'timestamp'   => $e->created_at,
                'actor'       => $e->actor?->name ?? 'Sistema',
                'description' => $this->describeEvent($e),
                'body'        => null,
            ]);

            $messages = $this->ticket->messages->where('is_internal', false)->map(fn($m) => [
                'type'        => 'message',
                'timestamp'   => $m->created_at,
                'actor'       => $m->author?->name ?? 'Agente',
                'description' => 'Mensaje',
                'body'        => $m->body,
            ]);

            $history = $events->merge($messages)->sortBy('timestamp')->values();
        }

        return new Content(
            view: 'mail.tickets.customer-update',
            with: ['history' => $history],
        );
    }

    private function describeEvent($event): string
    {
        return match ($event->type->value) {
            'created'          => 'Ticket creado',
            'status_changed'   => 'Estado cambiado a ' . (TicketStatus::tryFrom($event->payload['after'] ?? '')?->label() ?? ($event->payload['after'] ?? '')),
            'priority_changed' => 'Prioridad cambiada a ' . (TicketPriority::tryFrom($event->payload['after'] ?? '')?->label() ?? ($event->payload['after'] ?? '')),
            'assigned_changed' => 'Asignado a ' . ($event->payload['after_name'] ?? 'Sin asignar'),
            'message_added'    => 'Mensaje agregado',
            'attachment_added' => 'Archivo adjunto: ' . ($event->payload['file_name'] ?? ''),
            'reopened'         => 'Ticket reabierto',
            'closed'           => 'Ticket cerrado',
            'resolved'         => 'Ticket resuelto',
            default            => 'Acción registrada',
        };
    }
}
