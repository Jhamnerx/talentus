<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\AssignConversationAction;
use App\Actions\WhatsFleep\ChangeConversationStatusAction;
use App\Enums\WhatsFleep\ConversationPriority;
use App\Enums\WhatsFleep\ConversationStatus;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ConversationHeader extends Component
{
    public string $uuid;
    public ?int $reassignTo = null;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function assignToMe(): void
    {
        $conversation = $this->conversation();
        if ($conversation) {
            app(AssignConversationAction::class)->execute($conversation, Auth::id(), Auth::user());
            $this->dispatch('conversation-updated');
        }
    }

    public function reassign(): void
    {
        $conversation = $this->conversation();
        if ($conversation && $this->reassignTo) {
            app(AssignConversationAction::class)->execute($conversation, $this->reassignTo, Auth::user());
            $this->reset('reassignTo');
            $this->dispatch('conversation-updated');
        }
    }

    public function setStatus(string $status): void
    {
        $conversation = $this->conversation();
        if ($conversation) {
            app(ChangeConversationStatusAction::class)->execute($conversation, ConversationStatus::from($status));
            $this->dispatch('conversation-updated');
        }
    }

    public function setPriority(string $priority): void
    {
        $conversation = $this->conversation();
        if ($conversation) {
            $conversation->forceFill(['priority' => ConversationPriority::from($priority)])->save();
            $this->dispatch('conversation-updated');
        }
    }

    private function conversation(): ?WhatsappConversation
    {
        return WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $conversation = WhatsappConversation::with(['contact', 'cliente', 'assignedUser'])
            ->where('uuid', $this->uuid)
            ->first();

        $agents = User::orderBy('name')->get(['id', 'name']);

        return view('livewire.admin.whats-fleep.inbox.conversation-header', [
            'conversation' => $conversation,
            'agents' => $agents,
        ]);
    }
}
