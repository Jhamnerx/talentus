<?php

namespace App\Livewire\Admin\Tickets;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketAttachment;
use App\Models\TicketEvent;
use App\Models\User;
use App\Enums\TicketStatus;
use App\Enums\TicketPriority;
use App\Enums\TicketEventType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class Show extends Component
{
    use WireUiActions, WithFileUploads;

    public Ticket $ticket;

    // Mensaje
    public $newMessage = '';
    public $isInternal = false;

    // Adjuntos
    public $attachments = [];

    // Acciones rápidas
    public $newStatus = '';
    public $newPriority = '';
    public $newAssignedTo = '';

    public function mount(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $this->ticket = $ticket;

        // Inicializar valores actuales
        $this->newStatus = $ticket->status->value;
        $this->newPriority = $ticket->priority->value;
        $this->newAssignedTo = $ticket->assigned_to;

        $this->refreshTicket();
    }

    public function refreshTicket()
    {
        $this->ticket->load([
            'customer',
            'category',
            'team',
            'assignedTo',
            'createdBy',
            'vehiculo',
            'events.actor',
            'messages.author',
            'attachments'
        ]);
    }

    public function addMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:5000',
        ]);

        $this->authorize('addMessage', $this->ticket);

        TicketMessage::create([
            'ticket_id' => $this->ticket->id,
            'author_id' => Auth::user()->id,
            'body' => $this->newMessage,
            'is_internal' => $this->isInternal,
        ]);

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type' => $this->isInternal ? TicketEventType::INTERNAL_NOTE->value : TicketEventType::MESSAGE_ADDED->value,
            'actor_id' => Auth::user()->id,
            'payload' => ['message_preview' => substr($this->newMessage, 0, 100)],
        ]);

        $this->ticket->touch('last_activity_at');

        $this->reset(['newMessage', 'isInternal']);
        $this->refreshTicket();
        $this->notification()->success('Mensaje agregado');
    }

    public function uploadAttachments()
    {
        $this->validate([
            'attachments.*' => 'required|file|max:10240', // 10MB
        ]);

        $this->authorize('addAttachment', $this->ticket);

        foreach ($this->attachments as $file) {
            $path = $file->store('tickets/' . $this->ticket->id, 'local');

            TicketAttachment::create([
                'ticket_id' => $this->ticket->id,
                'uploaded_by' => Auth::user()->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);

            TicketEvent::create([
                'ticket_id' => $this->ticket->id,
                'type' => TicketEventType::ATTACHMENT_ADDED->value,
                'actor_id' => Auth::user()->id,
                'payload' => ['file_name' => $file->getClientOriginalName()],
            ]);
        }

        $this->ticket->touch('last_activity_at');

        $this->reset('attachments');
        $this->refreshTicket();
        $this->notification()->success('Archivos adjuntados');
    }

    public function changeStatus()
    {
        $this->validate([
            'newStatus' => 'required|in:' . implode(',', array_column(TicketStatus::cases(), 'value')),
        ]);

        $this->authorize('changeStatus', $this->ticket);

        $oldStatus = $this->ticket->status->value;
        $this->ticket->update(['status' => $this->newStatus]);

        $eventType = match ($this->newStatus) {
            'closed' => TicketEventType::CLOSED->value,
            'resolved' => TicketEventType::RESOLVED->value,
            default => TicketEventType::STATUS_CHANGED->value,
        };

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type' => $eventType,
            'actor_id' => Auth::user()->id,
            'payload' => [
                'before' => $oldStatus,
                'after' => $this->newStatus,
            ],
        ]);

        $this->reset('newStatus');
        $this->refreshTicket();
        $this->notification()->success('Estado actualizado');
    }

    public function changePriority()
    {
        $this->validate([
            'newPriority' => 'required|in:' . implode(',', array_column(TicketPriority::cases(), 'value')),
        ]);

        $this->authorize('update', $this->ticket);

        $oldPriority = $this->ticket->priority->value;
        $this->ticket->update(['priority' => $this->newPriority]);

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type' => TicketEventType::PRIORITY_CHANGED->value,
            'actor_id' => Auth::user()->id,
            'payload' => [
                'before' => $oldPriority,
                'after' => $this->newPriority,
            ],
        ]);

        $this->reset('newPriority');
        $this->refreshTicket();
        $this->notification()->success('Prioridad actualizada');
    }

    public function assignTicket()
    {
        $this->validate([
            'newAssignedTo' => 'nullable|exists:users,id',
        ]);

        $this->authorize('assign', $this->ticket);

        $oldUser = $this->ticket->assigned_to ? User::find($this->ticket->assigned_to) : null;
        $newUser = $this->newAssignedTo ? User::find($this->newAssignedTo) : null;

        $this->ticket->update(['assigned_to' => $this->newAssignedTo ?: null]);

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type' => TicketEventType::ASSIGNED_CHANGED->value,
            'actor_id' => Auth::user()->id,
            'payload' => [
                'before'      => $oldUser?->id,
                'before_name' => $oldUser?->name ?? 'Sin asignar',
                'after'       => $newUser?->id,
                'after_name'  => $newUser?->name ?? 'Sin asignar',
            ],
        ]);

        $this->refreshTicket();
        $this->notification()->success('Ticket reasignado');
    }

    public function getTimelineItemsProperty()
    {
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

    public function formatEventDescription($event)
    {
        $beforeStatus = isset($event->payload['before']) ? TicketStatus::tryFrom($event->payload['before'])?->label() ?? $event->payload['before'] : null;
        $afterStatus = isset($event->payload['after']) ? TicketStatus::tryFrom($event->payload['after'])?->label() ?? $event->payload['after'] : null;

        return match ($event->type->value) {
            'created' => 'creó el ticket',
            'status_changed' => 'cambió el estado de ' . ($beforeStatus ?? 'N/A') . ' a ' . ($afterStatus ?? 'N/A'),
            'priority_changed' => 'cambió la prioridad de ' . (isset($event->payload['before']) ? TicketPriority::tryFrom($event->payload['before'])?->label() : 'N/A') . ' a ' . (isset($event->payload['after']) ? TicketPriority::tryFrom($event->payload['after'])?->label() : 'N/A'),
            'assigned_changed' => 'reasignó el ticket a ' . ($event->payload['after_name'] ?? 'Sin asignar'),
            'team_changed' => 'cambió el equipo',

            'message_added' => 'agregó un mensaje',
            'internal_note' => 'agregó una nota interna',
            'attachment_added' => 'adjuntó un archivo: ' . ($event->payload['file_name'] ?? ''),
            'reopened' => 'reabrió el ticket',
            'closed' => 'cerró el ticket',
            'resolved' => 'resolvió el ticket',
            'customer_replied' => 'el cliente respondió',
            default => 'realizó una acción',
        };
    }

    public function render()
    {
        $users = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'agente']))
            ->orderBy('name')->get();

        return view('livewire.admin.tickets.show', [
            'timelineItems' => $this->timelineItems,
            'users' => $users,
        ]);
    }
}
