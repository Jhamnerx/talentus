<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\Contact;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Delete extends Component
{
    use WireUiActions;

    public ?int    $contactId     = null;
    public ?string $contactName   = null;
    public ?string $contactNumber = null;
    public bool    $showModal     = false;

    protected $listeners = ['open-delete-contact-modal' => 'openModal'];

    public function openModal(int $contactId): void
    {
        $contact = Contact::where('user_id', auth()->id())->findOrFail($contactId);

        $this->contactId     = $contact->id;
        $this->contactName   = $contact->name ?: $contact->number;
        $this->contactNumber = $contact->number;
        $this->showModal     = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->contactId     = null;
        $this->contactName   = null;
        $this->contactNumber = null;
    }

    public function delete(): void
    {
        Contact::where('user_id', auth()->id())->findOrFail($this->contactId)->delete();

        $this->dispatch('contactDeleted');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.contacts.delete');
    }
}
