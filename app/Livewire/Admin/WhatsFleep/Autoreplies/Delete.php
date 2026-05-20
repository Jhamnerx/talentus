<?php

namespace App\Livewire\Admin\WhatsFleep\Autoreplies;

use App\Models\WhatsFleep\Autoreply;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Delete extends Component
{
    use WireUiActions;

    public bool   $showModal   = false;
    public ?int   $autoreplyId = null;
    public string $keyword     = '';

    #[On('open-autoreply-delete')]
    public function openModal(int $id): void
    {
        $ar = Autoreply::where('user_id', auth()->id())->findOrFail($id);

        $this->autoreplyId = $ar->id;
        $this->keyword     = $ar->keyword;
        $this->showModal   = true;
    }

    public function delete(): void
    {
        Autoreply::where('user_id', auth()->id())->findOrFail($this->autoreplyId)->delete();

        $this->notification()->success('Eliminado', 'Auto-respuesta eliminada.');
        $this->dispatch('autoreplyDeleted');
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.autoreplies.delete');
    }
}
