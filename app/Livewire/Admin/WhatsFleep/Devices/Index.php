<?php

namespace App\Livewire\Admin\WhatsFleep\Devices;

use App\Models\WhatsFleep\Device;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WireUiActions;

    public string $search = '';

    protected $queryString = ['search'];

    public function mount(): void
    {
        $this->authorize('ver-dispositivos-wa');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->dispatch('open-wa-create-device-modal');
    }

    public function openEditModal(int $deviceId): void
    {
        $this->dispatch('open-wa-edit-device-modal', deviceId: $deviceId);
    }

    public function openDeleteModal(int $deviceId): void
    {
        $this->dispatch('open-wa-delete-device-modal', deviceId: $deviceId);
    }

    public function setSelectedDevice(string $body): void
    {
        $this->redirect(route('admin.whats-fleep.devices.scan', $body));
    }

    #[On('waDeviceCreated')]
    #[On('waDeviceUpdated')]
    #[On('waDeviceDeleted')]
    public function refresh(): void
    {
        $this->resetPage();
    }

    #[On('waApiKeyCopied')]
    public function apiKeyCopied(): void
    {
        $this->notification()->success(
            title: '¡Clave API copiada!',
            description: 'La clave API ha sido copiada al portapapeles'
        );
    }

    public function togglePostventa(int $deviceId): void
    {
        $empresaId = Auth::user()->empresa_id;

        Device::whereHas('user', function ($query) use ($empresaId) {
            $query->where('empresa_id', $empresaId);
        })->update(['es_postventa' => false]);

        Device::findOrFail($deviceId)->update(['es_postventa' => true]);

        $this->notification()->success(
            title: 'Device post-venta actualizado',
            description: 'El número de WhatsApp para mensajes post-venta fue configurado.'
        );
    }

    public function render()
    {
        $devices = Auth::user()->waDevices()
            ->withCount('messageHistories')
            ->when($this->search, function ($query) {
                $query->where('body', 'like', '%' . $this->search . '%')
                    ->orWhere('webhook', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.whats-fleep.devices.index', [
            'devices'       => $devices,
            'totalDevices'  => Auth::user()->waDevices()->count(),
        ]);
    }
}
