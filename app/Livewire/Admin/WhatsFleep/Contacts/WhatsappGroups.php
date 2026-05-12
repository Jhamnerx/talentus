<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\Contact;
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

    public bool    $syncing          = false;
    public ?string $error            = null;
    public ?string $selectedDevice   = null;
    public bool    $deviceConnected  = false;
    public string  $groupSearch      = '';
    public ?int    $importingGroupId = null;

    public function mount(): void
    {
        // Seleccionar primer dispositivo conectado por defecto
        $device = Auth::user()->waDevices()
            ->where('status', 'Connected')
            ->first()
            ?? Auth::user()->waDevices()->first();

        if ($device) {
            $this->selectedDevice  = $device->body;
            $this->deviceConnected = $device->status === 'Connected';
        }
    }

    public function updatedSelectedDevice(): void
    {
        $this->resetPage();
        $this->deviceConnected = Device::where('body', $this->selectedDevice)
            ->where('user_id', Auth::id())
            ->where('status', 'Connected')
            ->exists();
    }

    public function syncGroups(): void
    {
        $this->error = null;

        if (!$this->selectedDevice || !$this->deviceConnected) {
            $this->notification()->error(
                title: 'Error',
                description: 'Selecciona un dispositivo conectado'
            );
            return;
        }

        $this->syncing = true;

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
                title: '!Grupos sincronizados!',
                description: count($groups) . ' grupos obtenidos'
            );
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->notification()->error(title: 'Error', description: $e->getMessage());
        } finally {
            $this->syncing = false;
        }
    }

    public function importAsContacts(int $groupId): void
    {
        $group = WhatsappGroup::where('id', $groupId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$group) {
            $this->notification()->error(title: 'Error', description: 'Grupo no encontrado');
            return;
        }

        if (!$this->selectedDevice || !$this->deviceConnected) {
            $this->notification()->error(title: 'Error', description: 'El dispositivo no está conectado');
            return;
        }

        $this->importingGroupId = $groupId;

        try {
            $response = Http::timeout(30)->post(
                config('whatsapp.node_server_url') . '/api/fetch-groups',
                ['token' => $this->selectedDevice]
            );

            if (!$response->successful() || !$response->json('status')) {
                throw new \Exception($response->json('message', 'Error al obtener grupos'));
            }

            // Buscar el grupo específico por group_id
            $remoteGroup = collect($response->json('groups', []))
                ->first(fn($g) => ($g['id'] ?? $g['jid'] ?? '') === $group->group_id);

            if (!$remoteGroup) {
                throw new \Exception('Grupo no encontrado en el dispositivo. Vuelve a sincronizar.');
            }

            $participants = $remoteGroup['participants'] ?? [];

            if (empty($participants)) {
                $this->notification()->warning(
                    title: 'Sin participantes',
                    description: 'El grupo no tiene participantes registrados'
                );
                return;
            }

            $imported = 0;
            foreach ($participants as $participant) {
                // El servidor Node devuelve: { number, name, isAdmin }
                $number = $participant['number'] ?? '';
                $number = preg_replace('/\D/', '', $number);

                if (!$number) continue;

                Contact::firstOrCreate(
                    ['user_id' => Auth::id(), 'number' => $number],
                    [
                        'name'        => $participant['name'] ?? $number,
                        'device_body' => $this->selectedDevice,
                    ]
                );
                $imported++;
            }

            $this->notification()->success(
                title: '¡Contactos importados!',
                description: "{$imported} contactos importados del grupo \"{$group->name}\""
            );
        } catch (\Exception $e) {
            $this->notification()->error(title: 'Error', description: $e->getMessage());
        } finally {
            $this->importingGroupId = null;
        }
    }

    public function openSendMessage(string $groupId, string $groupName): void
    {
        $this->dispatch('open-send-group-message-modal', groupId: $groupId, groupName: $groupName);
    }

    public function render()
    {
        $devices = Auth::user()->waDevices()->get();

        $groups = WhatsappGroup::where('user_id', Auth::id())
            ->where('device_body', $this->selectedDevice)
            ->when($this->groupSearch, fn($q) => $q->where('name', 'like', '%' . $this->groupSearch . '%'))
            ->latest('synced_at')
            ->paginate(20);

        return view('livewire.admin.whats-fleep.contacts.whatsapp-groups', compact('groups', 'devices'));
    }
}
