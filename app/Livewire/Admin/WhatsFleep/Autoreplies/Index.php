<?php

namespace App\Livewire\Admin\WhatsFleep\Autoreplies;

use App\Models\WhatsFleep\Autoreply;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WireUiActions;

    public string $search       = '';
    public string $filterDevice = '';

    public function mount(): void
    {
        if (session()->has('selectedDevice')) {
            $this->filterDevice = session('selectedDevice')['device_body'];
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->dispatch('open-autoreply-create');
    }
    public function openEditModal(int $id): void
    {
        $this->dispatch('open-autoreply-edit', id: $id);
    }
    public function openDeleteModal(int $id): void
    {
        $this->dispatch('open-autoreply-delete', id: $id);
    }

    public function toggleStatus(int $id): void
    {
        $ar = Autoreply::where('user_id', auth()->id())->findOrFail($id);
        $ar->update(['status' => !$ar->status]);
    }

    public function toggleQuoted(int $id): void
    {
        $ar = Autoreply::where('user_id', auth()->id())->findOrFail($id);
        $ar->update(['is_quoted' => !$ar->is_quoted]);
    }

    #[On('autoreplyCreated')]
    #[On('autoreplyUpdated')]
    #[On('autoreplyDeleted')]
    public function refresh(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = auth()->user()->waAutoreplies();

        if ($this->filterDevice) {
            $query->where('device', $this->filterDevice);
        }

        if ($this->search) {
            $query->where('keyword', 'like', '%' . $this->search . '%');
        }

        $autoreplies = $query->latest()->paginate(10);
        $devices     = auth()->user()->waDevices()->where('status', 'Connected')->get();

        return view('livewire.admin.whats-fleep.autoreplies.index', compact('autoreplies', 'devices'));
    }
}
