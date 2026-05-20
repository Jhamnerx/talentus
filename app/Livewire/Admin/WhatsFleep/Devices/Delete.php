<?php

namespace App\Livewire\Admin\WhatsFleep\Devices;

use App\Models\WhatsFleep\Device;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Delete extends Component
{
    use WireUiActions;

    public bool    $showModal  = false;
    public ?int    $deviceId   = null;
    public string  $deviceName = '';

    #[On('open-wa-delete-device-modal')]
    public function openModal(int $deviceId): void
    {
        $device = Device::findOrFail($deviceId);

        $this->deviceId   = $deviceId;
        $this->deviceName = $device->body;
        $this->showModal  = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['deviceId', 'deviceName']);
    }

    public function delete(): void
    {
        $device = Device::findOrFail($this->deviceId);
        $device->delete();

        $this->notification()->success(
            title: '¡Dispositivo eliminado!',
            description: 'El dispositivo se ha eliminado correctamente'
        );

        $this->dispatch('waDeviceDeleted');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.devices.delete');
    }
}
