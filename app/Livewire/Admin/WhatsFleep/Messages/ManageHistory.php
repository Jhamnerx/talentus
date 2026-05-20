<?php

namespace App\Livewire\Admin\WhatsFleep\Messages;

use App\Models\WhatsFleep\MessageHistory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class ManageHistory extends Component
{
    use WithPagination, WireUiActions;

    public string $search       = '';
    public string $filterStatus = 'all';
    public string $filterDevice = '';
    public string $filterType   = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }
    public function updatingFilterDevice(): void
    {
        $this->resetPage();
    }
    public function updatingFilterType(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Auth::user()->waMessageHistories();

        if ($this->filterDevice) {
            $query->where('device_id', $this->filterDevice);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('status', 'like', '%' . $this->search . '%')
                    ->orWhere('note', 'like', '%' . $this->search . '%');
            });
        }

        $histories = $query->with('device')->latest()->paginate(20);
        $devices   = Auth::user()->waDevices()->get();

        return view('livewire.admin.whats-fleep.messages.manage-history', compact('histories', 'devices'));
    }
}
