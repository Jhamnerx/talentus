<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ConversationList extends Component
{
    use WithPagination;

    #[Url]
    public string $estado = 'open';      // open | pending | closed

    #[Url]
    public string $asignacion = 'todas'; // mias | sin_asignar | todas

    #[Url]
    public string $search = '';

    public ?string $selected = null;

    /**
     * Canal dinámico de empresa para refrescar la lista en vivo.
     *
     * @return array<string, string>
     */
    public function getListeners(): array
    {
        $empresaId = (int) session('empresa', 1);

        return [
            "echo-private:whatsapp.empresa.{$empresaId},wa.conversation.updated" => '$refresh',
        ];
    }

    public function updated($name): void
    {
        if (in_array($name, ['estado', 'asignacion', 'search'], true)) {
            $this->resetPage();
        }
    }

    public function select(string $uuid): void
    {
        $this->selected = $uuid;
        $this->dispatch('conversation-selected', uuid: $uuid);
    }

    public function render()
    {
        $empresaId = (int) session('empresa', 1);

        $query = WhatsappConversation::query()
            ->forTenant($empresaId)
            ->with(['contact', 'cliente', 'lastMessage', 'assignedUser'])
            ->where('status', $this->estado);

        if ($this->asignacion === 'mias') {
            $query->where('assigned_user_id', Auth::id());
        } elseif ($this->asignacion === 'sin_asignar') {
            $query->whereNull('assigned_user_id');
        }

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->whereHas('contact', fn ($c) => $c->where('name', 'like', $term)->orWhere('number', 'like', $term))
                  ->orWhereHas('cliente', fn ($c) => $c->where('razon_social', 'like', $term));
            });
        }

        $conversations = $query->orderByDesc('last_message_at')->paginate(20);

        return view('livewire.admin.whats-fleep.inbox.conversation-list', [
            'conversations' => $conversations,
        ]);
    }
}
