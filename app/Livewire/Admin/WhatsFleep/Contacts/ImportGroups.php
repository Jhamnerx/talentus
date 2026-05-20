<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WaTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class ImportGroups extends Component
{
    use WireUiActions;

    public string $device_body = '';
    public bool   $showModal   = false;
    public bool   $importing   = false;

    protected $listeners = ['open-import-groups-modal' => 'openModal'];

    protected function rules(): array
    {
        return ['device_body' => 'required|exists:devices,body'];
    }

    public function openModal(): void
    {
        $this->reset(['device_body']);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['device_body']);
    }

    public function import(): void
    {
        $validated = $this->validate();

        $device = Device::where('body', $validated['device_body'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($device->status !== 'Connected') {
            $this->notification()->error(title: '¡Error!', description: 'El dispositivo no está conectado');
            return;
        }

        $this->importing = true;

        try {
            $response = Http::timeout(60)->post(
                config('whatsapp.node_server_url') . '/api/fetch-groups',
                ['token' => $device->body]
            );

            if (!$response->successful()) {
                throw new \Exception('Error al comunicar con el servidor de WhatsApp');
            }

            $groups = $response->json('groups', []);

            if (empty($groups)) {
                $this->notification()->warning(title: 'Sin grupos', description: 'No se encontraron grupos');
                return;
            }

            $defaultTag = WaTag::firstOrCreate(
                ['user_id' => Auth::id(), 'name' => 'Grupos WA']
            );

            $imported = 0;
            foreach ($groups as $g) {
                $number = preg_replace('/\D/', '', $g['id'] ?? $g['jid'] ?? '');
                if (!$number) continue;

                Contact::firstOrCreate(
                    ['user_id' => Auth::id(), 'number' => $number],
                    ['name' => $g['name'] ?? $g['subject'] ?? 'Grupo', 'tag_id' => $defaultTag->id]
                );
                $imported++;
            }

            $this->dispatch('groupsImported', count: $imported);
            $this->closeModal();
        } catch (\Exception $e) {
            $this->notification()->error(title: '¡Error!', description: $e->getMessage());
        } finally {
            $this->importing = false;
        }
    }

    public function render()
    {
        $devices = Auth::user()->waDevices()->where('status', 'Connected')->get();

        return view('livewire.admin.whats-fleep.contacts.import-groups', compact('devices'));
    }
}
