<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    #[Url]
    public ?string $conversation = null; // uuid

    #[On('conversation-selected')]
    public function selectConversation(string $uuid): void
    {
        $this->conversation = $uuid;
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.inbox.index');
    }
}
