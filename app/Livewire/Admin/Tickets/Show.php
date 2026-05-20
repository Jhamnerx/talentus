<?php

namespace App\Livewire\Admin\Tickets;

use App\Enums\TicketEventType;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Mail\TicketCustomerMail;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Models\TicketEvent;
use App\Models\TicketMessage;
use App\Models\TicketRelation;
use App\Models\TicketTemplate;
use App\Models\User;
use App\Services\TicketWhatsAppService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class Show extends Component
{
    use WireUiActions, WithFileUploads;

    public Ticket $ticket;

    // Mensaje
    public $newMessage      = '';
    public $isInternal      = false;
    public $selectedTemplate = '';

    // Adjuntos
    public $attachments = [];

    // Acciones rÃ¡pidas
    public $newStatus     = '';
    public $newPriority   = '';
    public $newAssignedTo = '';
    public $newCategoryId = '';

    // Ticket relacionado
    public $relatedTicketCode = '';

    public function mount(Ticket $ticket): void
    {
        $this->ticket        = $ticket;
        $this->newStatus     = $ticket->status->value;
        $this->newPriority   = $ticket->priority->value;
        $this->newAssignedTo = $ticket->assigned_to;
        $this->newCategoryId = $ticket->category_id ?? '';
        $this->refreshTicket();
    }

    public function refreshTicket(): void
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
            'attachments',
            'relatedTickets.relatedTicket.customer',
        ]);
    }

    // â”€â”€ Plantilla de respuesta â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function applyTemplate(): void
    {
        if ($this->selectedTemplate) {
            $template = TicketTemplate::find($this->selectedTemplate);
            if ($template) {
                $this->newMessage = $template->body;
            }
        }
    }

    // â”€â”€ Agregar mensaje â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function addMessage(): void
    {
        $this->validate(['newMessage' => 'required|string|max:5000']);

        TicketMessage::create([
            'ticket_id'   => $this->ticket->id,
            'author_id'   => Auth::id(),
            'body'        => $this->newMessage,
            'is_internal' => $this->isInternal,
        ]);

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type'      => $this->isInternal ? TicketEventType::INTERNAL_NOTE->value : TicketEventType::MESSAGE_ADDED->value,
            'actor_id'  => Auth::id(),
            'payload'   => ['message_preview' => substr($this->newMessage, 0, 100)],
        ]);

        // Registrar primera respuesta
        if (! $this->ticket->first_response_at && Auth::id() !== $this->ticket->created_by) {
            $this->ticket->update(['first_response_at' => now()]);
        }

        $this->ticket->touch('last_activity_at');

        // Notificar al cliente por email si el mensaje es pÃºblico
        if (! $this->isInternal) {
            $this->sendCustomerEmail($this->newMessage, 'update');
        }

        $this->reset(['newMessage', 'isInternal', 'selectedTemplate']);
        $this->refreshTicket();
        $this->notification()->success('Mensaje agregado');
    }

    // â”€â”€ Subir archivos â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function uploadAttachments(): void
    {
        $this->validate(['attachments.*' => 'required|file|max:10240']);

        foreach ($this->attachments as $file) {
            $path = $file->store('tickets/' . $this->ticket->id, 'local');

            TicketAttachment::create([
                'ticket_id'   => $this->ticket->id,
                'uploaded_by' => Auth::id(),
                'file_name'   => $file->getClientOriginalName(),
                'file_path'   => $path,
                'file_size'   => $file->getSize(),
                'mime_type'   => $file->getMimeType(),
            ]);

            TicketEvent::create([
                'ticket_id' => $this->ticket->id,
                'type'      => TicketEventType::ATTACHMENT_ADDED->value,
                'actor_id'  => Auth::id(),
                'payload'   => ['file_name' => $file->getClientOriginalName()],
            ]);
        }

        $this->ticket->touch('last_activity_at');
        $this->reset('attachments');
        $this->refreshTicket();
        $this->notification()->success('Archivos adjuntados');
    }

    // â”€â”€ Cambiar estado â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function changeStatus(): void
    {
        $this->validate([
            'newStatus' => 'required|in:' . implode(',', array_column(TicketStatus::cases(), 'value')),
        ]);

        $oldStatus  = $this->ticket->status->value;
        $timestamps = [];

        if ($this->newStatus === 'resolved') {
            $timestamps['resolved_at'] = now();
        } elseif ($this->newStatus === 'closed') {
            $timestamps['closed_at'] = now();
        }

        $this->ticket->update(array_merge(['status' => $this->newStatus], $timestamps));

        $eventType = match ($this->newStatus) {
            'closed'   => TicketEventType::CLOSED->value,
            'resolved' => TicketEventType::RESOLVED->value,
            default    => TicketEventType::STATUS_CHANGED->value,
        };

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type'      => $eventType,
            'actor_id'  => Auth::id(),
            'payload'   => ['before' => $oldStatus, 'after' => $this->newStatus],
        ]);

        // WhatsApp al agente asignado
        try {
            app(TicketWhatsAppService::class)->notifyStatusChanged($this->ticket, $oldStatus, $this->newStatus);
        } catch (\Throwable) {
        }

        // Email al cliente en cambios relevantes
        if (in_array($this->newStatus, ['resolved', 'closed', 'open', 'in_progress'])) {
            $statusLabel = TicketStatus::from($this->newStatus)->label();
            $this->sendCustomerEmail("El estado de tu ticket ha cambiado a: {$statusLabel}.", $this->newStatus);
        }

        // CSAT al cerrar/resolver
        if (in_array($this->newStatus, ['resolved', 'closed'])) {
            $this->sendCsatWhatsApp();
        }

        $this->refreshTicket();
        $this->notification()->success('Estado actualizado');
    }

    // â”€â”€ Cambiar prioridad â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function changePriority(): void
    {
        $this->validate([
            'newPriority' => 'required|in:' . implode(',', array_column(TicketPriority::cases(), 'value')),
        ]);

        $oldPriority = $this->ticket->priority->value;
        $this->ticket->update(['priority' => $this->newPriority]);

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type'      => TicketEventType::PRIORITY_CHANGED->value,
            'actor_id'  => Auth::id(),
            'payload'   => ['before' => $oldPriority, 'after' => $this->newPriority],
        ]);

        $this->refreshTicket();
        $this->notification()->success('Prioridad actualizada');
    }

    // â”€â”€ Asignar usuario â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function assignTicket(): void
    {
        $this->validate(['newAssignedTo' => 'nullable|exists:users,id']);

        $oldUser = $this->ticket->assigned_to ? User::find($this->ticket->assigned_to) : null;
        $newUser = $this->newAssignedTo ? User::find($this->newAssignedTo) : null;

        $this->ticket->update(['assigned_to' => $this->newAssignedTo ?: null]);

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type'      => TicketEventType::ASSIGNED_CHANGED->value,
            'actor_id'  => Auth::id(),
            'payload'   => [
                'before'      => $oldUser?->id,
                'before_name' => $oldUser?->name ?? 'Sin asignar',
                'after'       => $newUser?->id,
                'after_name'  => $newUser?->name ?? 'Sin asignar',
            ],
        ]);

        if ($newUser) {
            try {
                app(TicketWhatsAppService::class)->notifyAssigned($this->ticket, $newUser);
            } catch (\Throwable) {
            }
        }

        $this->refreshTicket();
        $this->notification()->success('Ticket reasignado');
    }

    // â”€â”€ Cambiar categorÃ­a â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function changeCategory(): void
    {
        $this->validate(['newCategoryId' => 'nullable|exists:ticket_categories,id']);

        $oldCategory = $this->ticket->category?->name ?? 'Sin categorÃ­a';
        $this->ticket->update(['category_id' => $this->newCategoryId ?: null]);
        $this->ticket->refresh();
        $newCategory = $this->ticket->category?->name ?? 'Sin categorÃ­a';

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type'      => TicketEventType::CATEGORY_CHANGED->value,
            'actor_id'  => Auth::id(),
            'payload'   => ['before' => $oldCategory, 'after' => $newCategory],
        ]);

        $this->refreshTicket();
        $this->notification()->success('CategorÃ­a actualizada');
    }

    // â”€â”€ Reabrir ticket â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function reopen(): void
    {
        if (! $this->ticket->canBeReopened()) {
            $this->notification()->error('Este ticket no puede reabrirse.');
            return;
        }

        $this->ticket->update([
            'status'      => TicketStatus::OPEN->value,
            'resolved_at' => null,
            'closed_at'   => null,
        ]);

        TicketEvent::create([
            'ticket_id' => $this->ticket->id,
            'type'      => TicketEventType::REOPENED->value,
            'actor_id'  => Auth::id(),
            'payload'   => ['reopened_by' => Auth::user()->name],
        ]);

        $this->newStatus = TicketStatus::OPEN->value;
        $this->refreshTicket();
        $this->notification()->success('Ticket reabierto');
    }

    // â”€â”€ Tickets relacionados â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function linkRelatedTicket(): void
    {
        $this->validate(['relatedTicketCode' => 'required|string']);

        $related = Ticket::where('code', strtoupper(trim($this->relatedTicketCode)))->first();

        if (! $related) {
            $this->notification()->error('No se encontrÃ³ un ticket con ese cÃ³digo.');
            return;
        }

        if ($related->id === $this->ticket->id) {
            $this->notification()->error('No puedes relacionar un ticket consigo mismo.');
            return;
        }

        $exists = TicketRelation::where('ticket_id', $this->ticket->id)
            ->where('related_ticket_id', $related->id)->exists();

        if ($exists) {
            $this->notification()->warning('Ese ticket ya estÃ¡ vinculado.');
            return;
        }

        TicketRelation::create([
            'ticket_id'         => $this->ticket->id,
            'related_ticket_id' => $related->id,
            'created_by'        => Auth::id(),
        ]);

        $this->reset('relatedTicketCode');
        $this->refreshTicket();
        $this->notification()->success("Ticket {$related->code} vinculado.");
    }

    public function unlinkRelatedTicket(int $relationId): void
    {
        TicketRelation::where('id', $relationId)
            ->where('ticket_id', $this->ticket->id)
            ->delete();

        $this->refreshTicket();
        $this->notification()->success('VÃ­nculo eliminado.');
    }

    // â”€â”€ Email al cliente â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    private function sendCustomerEmail(string $body, string $eventType = 'update'): void
    {
        $email = $this->ticket->customer?->email;
        if (! $email) {
            return;
        }

        try {
            Mail::to($email)->queue(new TicketCustomerMail($this->ticket, $body, $eventType));
        } catch (\Throwable) {
        }
    }

    // â”€â”€ CSAT por WhatsApp â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    private function sendCsatWhatsApp(): void
    {
        $phone = $this->ticket->customer?->telefonos ?? null;
        if (! $phone) {
            return;
        }

        $statusLabel = $this->ticket->status->label();
        $message = "âœ… *Tu ticket ha sido {$statusLabel}*\n\n"
            . "Ticket: *{$this->ticket->code}*\n"
            . "Asunto: {$this->ticket->subject}\n\n"
            . "Â¿CÃ³mo calificarÃ­as la atenciÃ³n recibida?\n"
            . "1ï¸âƒ£ Excelente  2ï¸âƒ£ Buena  3ï¸âƒ£ Regular  4ï¸âƒ£ Mala\n\n"
            . "Responde con el nÃºmero. Â¡Gracias por tu opiniÃ³n!";

        try {
            app(TicketWhatsAppService::class)->sendMessage($phone, $message);
        } catch (\Throwable) {
        }
    }

    // â”€â”€ Timeline â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    public function getTimelineItemsProperty()
    {
        $events = $this->ticket->events->map(fn($event) => [
            'type'      => 'event',
            'data'      => $event,
            'timestamp' => $event->created_at,
        ]);

        $messages = $this->ticket->messages->map(fn($message) => [
            'type'      => 'message',
            'data'      => $message,
            'timestamp' => $message->created_at,
        ]);

        return collect($events)
            ->merge($messages)
            ->sortBy('timestamp')
            ->values();
    }

    public function formatEventDescription($event): string
    {
        $beforeStatus = isset($event->payload['before'])
            ? TicketStatus::tryFrom($event->payload['before'])?->label() ?? $event->payload['before']
            : null;
        $afterStatus = isset($event->payload['after'])
            ? TicketStatus::tryFrom($event->payload['after'])?->label() ?? $event->payload['after']
            : null;

        return match ($event->type->value) {
            'created'          => 'creÃ³ el ticket',
            'status_changed'   => 'cambiÃ³ el estado de ' . ($beforeStatus ?? 'N/A') . ' a ' . ($afterStatus ?? 'N/A'),
            'priority_changed' => 'cambiÃ³ la prioridad de '
                . (isset($event->payload['before']) ? TicketPriority::tryFrom($event->payload['before'])?->label() : 'N/A')
                . ' a '
                . (isset($event->payload['after']) ? TicketPriority::tryFrom($event->payload['after'])?->label() : 'N/A'),
            'assigned_changed' => 'reasignÃ³ el ticket a ' . ($event->payload['after_name'] ?? 'Sin asignar'),
            'team_changed'     => 'cambiÃ³ el equipo',
            'message_added'    => 'agregÃ³ un mensaje',
            'internal_note'    => 'agregÃ³ una nota interna',
            'attachment_added' => 'adjuntÃ³ un archivo: ' . ($event->payload['file_name'] ?? ''),
            'reopened'         => 'reabriÃ³ el ticket',
            'closed'           => 'cerrÃ³ el ticket',
            'resolved'         => 'resolviÃ³ el ticket',
            'category_changed' => 'cambiÃ³ la categorÃ­a de '
                . ($event->payload['before'] ?? 'N/A') . ' a ' . ($event->payload['after'] ?? 'N/A'),
            'escalated'        => 'ticket escalado â€” nivel ' . ($event->payload['level'] ?? '?')
                . ': ' . ($event->payload['reason'] ?? ''),
            default            => 'realizÃ³ una acciÃ³n',
        };
    }

    public function render()
    {
        $users      = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'agente']))->orderBy('name')->get();
        $categories = TicketCategory::active()->orderBy('name')->get();
        $templates  = TicketTemplate::active()->orderBy('name')->get(['id', 'name', 'body']);

        return view('livewire.admin.tickets.show', [
            'timelineItems' => $this->timelineItems,
            'users'         => $users,
            'categories'    => $categories,
            'templates'     => $templates,
        ]);
    }
}
