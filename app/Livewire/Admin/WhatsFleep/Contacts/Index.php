<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\WaTag;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WireUiActions;

    public string $search      = '';
    public string $selectedTag = '';

    protected $queryString = ['search'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingSelectedTag(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->dispatch('open-create-contact-modal');
    }
    public function openEditModal(int $id): void
    {
        $this->dispatch('open-edit-contact-modal', contactId: $id);
    }
    public function openDeleteModal(int $id): void
    {
        $this->dispatch('open-delete-contact-modal', contactId: $id);
    }
    public function openImportModal(): void
    {
        $this->dispatch('open-import-contacts-modal');
    }
    public function openImportGroupsModal(): void
    {
        $this->dispatch('open-import-groups-modal');
    }
    public function openSyncContactsModal(): void
    {
        $this->dispatch('open-sync-contacts-modal');
    }
    public function openCreateTagModal(): void
    {
        $this->dispatch('open-create-tag-modal');
    }

    #[On('contactCreated')]
    #[On('contactUpdated')]
    #[On('contactDeleted')]
    public function refresh(): void
    {
        $this->resetPage();
    }

    #[On('contactsImported')]
    public function contactsImported(int $count): void
    {
        $this->resetPage();
        $this->notification()->success(
            title: '¡Contactos importados!',
            description: "Se importaron {$count} contactos exitosamente"
        );
    }

    #[On('tagCreated')]
    public function tagCreated(): void
    {
        $this->notification()->success(
            title: '¡Grupo creado!',
            description: 'El grupo ha sido creado exitosamente'
        );
    }

    public function render()
    {
        $query = Auth::user()->waContacts();

        if ($this->selectedTag) {
            $query->where('tag_id', $this->selectedTag);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('number', 'like', '%' . $this->search . '%');
            });
        }

        $contacts      = $query->with('tag')->latest()->paginate(20);
        $tags          = Auth::user()->waTags()->withCount('contacts')->get();
        $totalContacts = Auth::user()->waContacts()->count();

        return view('livewire.admin.whats-fleep.contacts.index', compact('contacts', 'tags', 'totalContacts'));
    }
}
