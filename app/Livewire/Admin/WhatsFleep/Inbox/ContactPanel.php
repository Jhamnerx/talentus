<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\CreateTicketFromConversationAction;
use App\Actions\WhatsFleep\LinkConversationToTicketAction;
use App\Actions\WhatsFleep\UnlinkConversationFromTicketAction;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ContactPanel extends Component
{
    public string $uuid;

    // Ticket linking
    public string $ticketSearch = '';
    public bool $showCreateTicketModal = false;
    public string $createSubject = '';
    public string $createPriority = 'medium';
    public ?int $createCategoryId = null;
    public string $createDescription = '';

    private ?WhatsappConversation $cachedConversation = null;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function openConversation(string $uuid): void
    {
        $this->dispatch('conversation-selected', uuid: $uuid);
    }

    public function linkTicket(int $ticketId): void
    {
        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        app(LinkConversationToTicketAction::class)->execute($conversation, $ticketId, Auth::user());
        $this->reset('ticketSearch');
    }

    public function unlinkTicket(): void
    {
        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        app(UnlinkConversationFromTicketAction::class)->execute($conversation, Auth::user());
    }

    public function openCreateTicketModal(): void
    {
        $conversation = $this->conversation();
        if (! $conversation || ! $conversation->cliente_id) {
            return;
        }

        $this->reset(['createSubject', 'createCategoryId', 'createDescription']);
        $this->createPriority = 'medium';
        $this->resetValidation();
        $this->showCreateTicketModal = true;
    }

    public function createAndLinkTicket(): void
    {
        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        $this->validate([
            'createSubject'     => ['required', 'string', 'max:255'],
            'createPriority'    => ['required', 'in:low,medium,high,urgent'],
            'createCategoryId'  => [
                'nullable', 'integer',
                Rule::exists('ticket_categories', 'id')
                    ->where('empresa_id', $conversation->empresa_id)
                    ->whereNull('deleted_at'),
            ],
            'createDescription' => ['required', 'string', 'max:5000'],
        ]);

        app(CreateTicketFromConversationAction::class)->execute(
            $conversation,
            [
                'subject'     => $this->createSubject,
                'description' => $this->createDescription,
                'priority'    => $this->createPriority,
                'category_id' => $this->createCategoryId,
            ],
            Auth::user()
        );

        $this->showCreateTicketModal = false;
        $this->reset(['createSubject', 'createCategoryId', 'createDescription']);
        $this->createPriority = 'medium';
    }

    private function conversation(): ?WhatsappConversation
    {
        return $this->cachedConversation ??= WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $conversation = WhatsappConversation::with(['contact.cliente', 'ticket'])
            ->where('uuid', $this->uuid)
            ->first();

        $cliente   = $conversation?->contact?->cliente;
        $empresaId = $conversation?->empresa_id ?? session('empresa', 1);

        $otras = collect();
        if ($conversation) {
            $otras = WhatsappConversation::where('contact_id', $conversation->contact_id)
                ->where('id', '!=', $conversation->id)
                ->latest('last_message_at')
                ->limit(10)
                ->get();
        }

        $ticketResults = $this->ticketSearch !== ''
            ? Ticket::withoutGlobalScope(EmpresaScope::class)
                ->where('empresa_id', $empresaId)
                ->where(fn ($q) => $q
                    ->where('code', 'like', $this->ticketSearch . '%')
                    ->orWhere('subject', 'like', '%' . $this->ticketSearch . '%'))
                ->whereNull('deleted_at')
                ->limit(5)
                ->get(['id', 'code', 'subject'])
            : collect();

        $vehiculos = $cliente
            ? $cliente->vehiculos()->whereNull('deleted_at')->limit(8)->get(['id', 'placa', 'gpswox_active', 'marca', 'modelo'])
            : collect();

        $categories = TicketCategory::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresaId)
            ->active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.admin.whats-fleep.inbox.contact-panel', [
            'conversation'  => $conversation,
            'otras'         => $otras,
            'ticketResults' => $ticketResults,
            'vehiculos'     => $vehiculos,
            'categories'    => $categories,
        ]);
    }
}
