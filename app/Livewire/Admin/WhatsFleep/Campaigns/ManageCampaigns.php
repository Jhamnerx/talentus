<?php

namespace App\Livewire\Admin\WhatsFleep\Campaigns;

use App\Models\WhatsFleep\Campaign;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class ManageCampaigns extends Component
{
    use WithPagination, WireUiActions;

    public string $filterStatus = 'all';
    public string $filterDevice = '';

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }
    public function updatingFilterDevice(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Auth::user()->waCampaigns();

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterDevice) {
            $query->where('sender', $this->filterDevice);
        }

        $campaigns  = $query->with(['device', 'phonebook'])->latest()->paginate(15);
        $devices    = Auth::user()->waDevices()->where('status', 'Connected')->get();
        $phonebooks = Auth::user()->waTags()->withCount('contacts')->get();

        return view('livewire.admin.whats-fleep.campaigns.manage-campaigns', compact('campaigns', 'devices', 'phonebooks'));
    }
}
