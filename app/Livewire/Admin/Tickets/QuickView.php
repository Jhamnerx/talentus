<?php

namespace App\Livewire\Admin\Tickets;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use App\Enums\TicketPriority;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class QuickView extends Component
{
    use WireUiActions;

    public bool $showModal = false;
    public ?Ticket $ticket = null;

    protected $listeners = ['open-ticket-quickview' => 'openModal'];

    public function openModal(int $ticketId): void
    {
        $ticket = Ticket::with([
            'customer',
            'category',
            'assignedTo',
            'createdBy',
            'vehiculo',
            'events.actor',
            'messages.author',
        ])->find($ticketId);

        if (!$ticket) {
            $this->notification()->error('Error', 'Ticket no encontrado.');
            return;
        }

        $this->ticket = $ticket;
        $this->showModal = true;
    }

    public function getTimelineItemsProperty(): \Illuminate\Support\Collection
    {
        if (!$this->ticket) {
            return collect();
        }

        $events = $this->ticket->events->map(fn($event) => [
            'type' => 'event',
            'data' => $event,
            'timestamp' => $event->created_at,
        ]);

        $messages = $this->ticket->messages->map(fn($message) => [
            'type' => 'message',
            'data' => $message,
            'timestamp' => $message->created_at,
        ]);

        return collect($events)
            ->merge($messages)
            ->sortBy('timestamp')
            ->values();
    }

    public function formatEventDescription($event): string
    {
        $beforeStatus = isset($event->payload['before']) ? TicketStatus::tryFrom($event->payload['before'])?->label() ?? $event->payload['before'] : null;
        $afterStatus  = isset($event->payload['after'])  ? TicketStatus::tryFrom($event->payload['after'])?->label()  ?? $event->payload['after']  : null;

        return match ($event->type->value) {
            'created'          => 'creó el ticket',
            'status_changed'   => 'cambió el estado de ' . ($beforeStatus ?? 'N/A') . ' a ' . ($afterStatus ?? 'N/A'),
            'priority_changed' => 'cambió la prioridad de ' . (isset($event->payload['before']) ? TicketPriority::tryFrom($event->payload['before'])?->label() : 'N/A') . ' a ' . (isset($event->payload['after']) ? TicketPriority::tryFrom($event->payload['after'])?->label() : 'N/A'),
            'assigned_changed' => 'reasignó el ticket a ' . ($event->payload['after_name'] ?? 'Sin asignar'),
            'message_added'    => 'agregó un mensaje',
            'internal_note'    => 'agregó una nota interna',
            'attachment_added' => 'adjuntó un archivo: ' . ($event->payload['file_name'] ?? ''),
            'reopened'         => 'reabrió el ticket',
            'closed'           => 'cerró el ticket',
            'resolved'         => 'resolvió el ticket',
            'customer_replied' => 'el cliente respondió',
            default            => 'realizó una acción',
        };
    }

    public function render()
    {
        return view('livewire.admin.tickets.quick-view', [
            'timelineItems' => $this->timelineItems,
        ]);
    }
}
