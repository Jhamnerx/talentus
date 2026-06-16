<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\MarkConversationReadAction;
use App\Models\WhatsFleep\WhatsappConversation;
use Livewire\Component;

class ConversationView extends Component
{
    public string $uuid;
    public int $perPage = 30;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
        $this->markRead();
    }

    /**
     * @return array<string, string>
     */
    public function getListeners(): array
    {
        return [
            "echo-private:whatsapp.conversation.{$this->uuid},wa.message.new" => 'onNewMessage',
        ];
    }

    public function onNewMessage(): void
    {
        $this->markRead();
        $this->dispatch('messages-refreshed');
    }

    public function loadMore(): void
    {
        $this->perPage += 30;
    }

    private function markRead(): void
    {
        $conversation = $this->conversation();
        if ($conversation) {
            app(MarkConversationReadAction::class)->execute($conversation);
        }
    }

    private function conversation(): ?WhatsappConversation
    {
        return WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $conversation = $this->conversation();

        $messages = $conversation
            ? $conversation->messages()->with('senderUser')->latest()->limit($this->perPage)->get()->reverse()->values()
            : collect();

        return view('livewire.admin.whats-fleep.inbox.conversation-view', [
            'messages' => $messages,
        ]);
    }
}
