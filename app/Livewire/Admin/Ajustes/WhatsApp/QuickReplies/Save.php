<?php

namespace App\Livewire\Admin\Ajustes\WhatsApp\QuickReplies;

use App\Models\WhatsFleep\WhatsappQuickReply;
use Livewire\Attributes\On;
use Livewire\Component;

class Save extends Component
{
    public bool $showModal = false;
    public ?int $replyId = null;
    public string $shortcut = '';
    public string $title = '';
    public string $body = '';
    public bool $active = true;

    protected function rules(): array
    {
        return [
            'shortcut' => ['required', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'max:2000'],
            'active' => ['boolean'],
        ];
    }

    #[On('open-quick-reply-modal')]
    public function open(?int $id = null): void
    {
        $this->reset(['replyId', 'shortcut', 'title', 'body']);
        $this->active = true;
        $this->resetValidation();

        if ($id) {
            $reply = WhatsappQuickReply::findOrFail($id);
            $this->replyId = $reply->id;
            $this->shortcut = $reply->shortcut;
            $this->title = $reply->title;
            $this->body = $reply->body;
            $this->active = $reply->active;
        }

        $this->showModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        WhatsappQuickReply::updateOrCreate(['id' => $this->replyId], $data);

        $this->showModal = false;
        $this->dispatch('quick-reply-saved');
    }

    public function render()
    {
        return view('livewire.admin.ajustes.whats-app.quick-replies.save');
    }
}
