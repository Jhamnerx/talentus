<?php

namespace App\Livewire\Admin\Ajustes\WhatsApp\QuickReplies;

use App\Models\WhatsFleep\WhatsappQuickReply;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public bool $showModal = false;
    public ?int $replyId = null;

    #[On('confirm-delete-quick-reply')]
    public function confirm(int $id): void
    {
        $this->replyId = $id;
        $this->showModal = true;
    }

    public function delete(): void
    {
        if ($this->replyId) {
            WhatsappQuickReply::whereKey($this->replyId)->delete();
        }

        $this->showModal = false;
        $this->dispatch('quick-reply-deleted');
    }

    public function render()
    {
        return view('livewire.admin.ajustes.whats-app.quick-replies.delete');
    }
}
