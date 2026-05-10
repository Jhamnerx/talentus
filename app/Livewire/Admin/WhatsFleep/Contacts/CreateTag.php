<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\WaTag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class CreateTag extends Component
{
    use WireUiActions;

    public string $name     = '';
    public bool   $showModal = false;

    protected $listeners = ['open-create-tag-modal' => 'openModal'];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:tags,name,NULL,id,user_id,' . auth()->id(),
        ];
    }

    public function openModal(): void
    {
        $this->name = '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->name = '';
        $this->resetValidation();
    }

    public function save(): void
    {
        $validated = $this->validate();

        WaTag::create(['user_id' => Auth::id(), 'name' => $validated['name']]);

        $this->dispatch('tagCreated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.contacts.create-tag');
    }
}
