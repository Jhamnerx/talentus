<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class WhatsappGroups extends Component
{
    use WireUiActions, WithPagination;

    public bool   $loading         = false;
    public ?string $selectedDevice = null;
    public bool   $deviceConnected = false;
    public string $groupSearch     = '';

    public function mount(): void
    {
        if (session()->has('selectedDevice')) {
            $this->selectedDevice = session('selectedDevice')['device_body'];
        } else {
            $device = Auth::user()->waDevices()->first();
            if ($device) {
                $this->selectedDevice = $device->body;
            }
        }

        if ($this->selectedDevice) {
            $this->deviceConnected = Device::where('body', $this->selectedDevice)
                ->where('user_id', Auth::id())
                ->where('status', 'Connected')
                ->exists();
        }
    }

    public function fetchGroups(): void
    {
        if (!$this->selectedDevice || !$this->deviceConnected) {
            $this->notification()->error(
                title: 'Error',
                description: 'Selecciona un dispositivo conectado'
            );
            return;
        }

        $this->loading = true;

        try {
            $response = Http::timeout(30)->post(
                config('whatsapp.node_server_url') . '/api/fetch-groups',
                ['token' => $this->selectedDevice]
            );

            if (!$response->successful() || !$response->json('status')) {
                throw new \Exception($response->json('message', 'Error al obtener grupos'));
            }

            $groups = $response->json('groups', []);
            $now    = now();

            foreach ($groups as $group) {
                WhatsappGroup::updateOrCreate(
                    [
                        'user_id'     => Auth::id(),
                        'device_body' => $this->selectedDevice,
                        'group_id'    => $group['id'] ?? $group['jid'] ?? '',
                    ],
                    [
                        'name'              => $group['name'] ?? $group['subject'] ?? 'Sin nombre',
                        'participant_count' => $group['participants_count'] ?? count($group['participants'] ?? []),
                        'synced_at'         => $now,
                    ]
                );
            }

            $this->notification()->success(
                title: '¡Grupos sincronizados!',
                description: count($groups) . ' grupos obtenidos'
            );
        } catch (\Exception $e) {
            $this->notification()->error(title: 'Error', description: $e->getMessage());
        } finally {
            $this->loading = false;
        }
    }

    public function openSendMessageModal(string $groupId, string $groupName): void
    {
        $this->dispatch('open-send-group-message-modal', groupId: $groupId, groupName: $groupName);
    }

    public function render()
    {
        $groups = WhatsappGroup::where('user_id', Auth::id())
            ->where('device_body', $this->selectedDevice)
            ->when($this->groupSearch, fn($q) => $q->where('name', 'like', '%' . $this->groupSearch . '%'))
            ->latest('synced_at')
            ->paginate(20);

        $devices = Auth::user()->waDevices()->get();

        return view('livewire.admin.whats-fleep.contacts.whatsapp-groups', compact('groups', 'devices'));
    }
}
