<?php

namespace App\Livewire\Admin\WhatsFleep\Devices;

use App\Models\WhatsFleep\Device;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Edit extends Component
{
    use WireUiActions;

    public bool   $showModal = false;
    public ?int   $deviceId  = null;
    public string $body      = '';
    public string $webhook   = '';

    protected function rules(): array
    {
        return [
            'body'    => 'required|string|max:255|unique:devices,body,' . $this->deviceId,
            'webhook' => 'nullable|url|max:500',
        ];
    }

    protected $messages = [
        'body.required' => 'El número de teléfono es obligatorio',
        'body.unique'   => 'Este número ya está registrado',
        'webhook.url'   => 'La URL del webhook debe ser válida',
    ];

    #[On('open-wa-edit-device-modal')]
    public function openModal(int $deviceId): void
    {
        $device = Device::findOrFail($deviceId);

        $this->deviceId = $deviceId;
        $this->body     = $device->body;
        $this->webhook  = $device->webhook ?? '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['deviceId', 'body', 'webhook']);
        $this->resetValidation();
    }

    public function update(): void
    {
        $this->validate();

        $device = Device::findOrFail($this->deviceId);
        $device->update([
            'body'    => $this->body,
            'webhook' => $this->webhook,
        ]);

        $this->notification()->success(
            title: '¡Dispositivo actualizado!',
            description: 'El dispositivo se ha actualizado correctamente'
        );

        $this->dispatch('waDeviceUpdated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.devices.edit');
    }
}
