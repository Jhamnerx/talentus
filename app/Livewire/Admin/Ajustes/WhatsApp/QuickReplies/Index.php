<?php

namespace App\Livewire\Admin\Ajustes\WhatsApp\QuickReplies;

use App\Models\WhatsFleep\WhatsappQuickReply;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    #[On('quick-reply-saved')]
    #[On('quick-reply-deleted')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $replies = WhatsappQuickReply::query()
            ->when($this->search !== '', fn ($q) => $q->where('shortcut', 'like', '%'.$this->search.'%')->orWhere('title', 'like', '%'.$this->search.'%'))
            ->orderBy('shortcut')
            ->paginate(15);

        return view('livewire.admin.ajustes.whats-app.quick-replies.index', [
            'replies' => $replies,
        ]);
    }
}
