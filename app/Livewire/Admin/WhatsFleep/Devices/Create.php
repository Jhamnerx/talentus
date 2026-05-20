<?php

namespace App\Livewire\Admin\WhatsFleep\Devices;

use App\Models\WhatsFleep\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Create extends Component
{
    use WireUiActions;

    public bool   $showModal = false;
    public string $body      = '';
    public string $webhook   = '';
    public bool   $interno   = false;

    protected function rules(): array
    {
        return [
            'body'    => 'required|string|max:255|unique:devices,body',
            'webhook' => 'nullable|url|max:500',
        ];
    }

    protected $messages = [
        'body.required' => 'El número de teléfono es obligatorio',
        'body.unique'   => 'Este número ya está registrado',
        'webhook.url'   => 'La URL del webhook debe ser válida',
    ];

    #[On('open-wa-create-device-modal')]
    public function openModal(): void
    {
        $this->reset(['body', 'webhook', 'interno']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['body', 'webhook', 'interno']);
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        // Si se marca como interno, desmarcar el dispositivo anterior
        if ($this->interno) {
            \App\Models\WhatsFleep\Device::where('interno', true)->update(['interno' => false]);
        }

        Device::create([
            'body'     => $this->body,
            'webhook'  => $this->webhook,
            'api_key'  => Str::random(32),
            'status'   => 'Disconnect',
            'user_id'  => Auth::id(),
            'interno'  => $this->interno,
        ]);

        $this->notification()->success(
            title: '¡Dispositivo creado!',
            description: 'El dispositivo se ha creado correctamente'
        );

        $this->dispatch('waDeviceCreated');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.devices.create');
    }
}
