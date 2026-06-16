<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Models\WhatsFleep\WhatsappConversation;
use Livewire\Component;

class ContactPanel extends Component
{
    public string $uuid;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function openConversation(string $uuid): void
    {
        $this->dispatch('conversation-selected', uuid: $uuid);
    }

    public function render()
    {
        $conversation = WhatsappConversation::with(['contact.cliente'])
            ->where('uuid', $this->uuid)
            ->first();

        $otras = collect();
        if ($conversation) {
            $otras = WhatsappConversation::where('contact_id', $conversation->contact_id)
                ->where('id', '!=', $conversation->id)
                ->latest('last_message_at')
                ->limit(10)
                ->get();
        }

        return view('livewire.admin.whats-fleep.inbox.contact-panel', [
            'conversation' => $conversation,
            'otras' => $otras,
        ]);
    }
}
