<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\WaTag;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Edit extends Component
{
    use WireUiActions;

    public ?int   $contactId  = null;
    public string $name       = '';
    public string $number     = '';
    public string $tag_id     = '';
    public bool   $showModal  = false;

    protected function rules(): array
    {
        return [
            'name'   => 'nullable|string|max:255',
            'number' => 'required|string|max:20',
            'tag_id' => 'required|exists:tags,id',
        ];
    }

    #[On('open-edit-contact-modal')]
    public function openModal(int $contactId): void
    {
        $contact = Contact::where('user_id', Auth::id())->findOrFail($contactId);

        $this->contactId = $contact->id;
        $this->name      = $contact->name ?? '';
        $this->number    = $contact->number;
        $this->tag_id    = (string) $contact->tag_id;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['contactId', 'name', 'number', 'tag_id']);
        $this->resetValidation();
    }

    public function update(): void
    {
        $validated = $this->validate();

        $contact = Contact::where('user_id', Auth::id())->findOrFail($this->contactId);
        $tag = WaTag::where('id', $validated['tag_id'])->where('user_id', Auth::id())->firstOrFail();

        $exists = Contact::where('user_id', Auth::id())
            ->where('number', $validated['number'])
            ->where('tag_id', $tag->id)
            ->where('id', '!=', $this->contactId)
            ->exists();

        if ($exists) {
            $this->notification()->error(
                title: '¡Error!',
                description: 'Ya existe un contacto con este número en el grupo'
            );
            return;
        }

        $contact->update([
            'name'   => $validated['name'],
            'number' => $validated['number'],
            'tag_id' => $tag->id,
        ]);

        $this->dispatch('contactUpdated');
        $this->closeModal();
    }

    public function render()
    {
        $tags = Auth::user()->waTags()->get();

        return view('livewire.admin.whats-fleep.contacts.edit', compact('tags'));
    }
}
