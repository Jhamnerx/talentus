<?php

namespace App\Livewire\Admin\WhatsFleep\Contacts;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class SendGroupMessage extends Component
{
    use WireUiActions;

    public bool    $showModal      = false;
    public string  $groupId        = '';
    public string  $groupName      = '';
    public string  $message        = '';
    public ?string $selectedDevice = null;
    public string  $messageType    = 'text';
    public string  $mediaUrl       = '';
    public string  $caption        = '';
    public string  $filename       = '';
    public bool    $sending        = false;

    protected $rules = [
        'message'  => 'required_if:messageType,text|min:1',
        'mediaUrl' => 'required_if:messageType,image,video,audio,document|url',
    ];

    #[On('open-send-group-message-modal')]
    public function openModal(string $groupId, string $groupName): void
    {
        $this->reset(['message', 'mediaUrl', 'caption', 'filename', 'messageType']);
        $this->groupId   = $groupId;
        $this->groupName = $groupName;

        $device = Auth::user()->waDevices()->where('status', 'Connected')->first();
        if ($device) {
            $this->selectedDevice = $device->body;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset();
    }

    public function sendMessage(): void
    {
        if (!$this->selectedDevice) {
            $this->notification()->error(title: 'Error', description: 'No hay dispositivos conectados');
            return;
        }

        $this->validate();
        $this->sending = true;

        try {
            $data = ['token' => $this->selectedDevice, 'groupId' => $this->groupId];

            if ($this->messageType === 'text') {
                $data['message'] = $this->message;
                $endpoint        = '/api/send-group-message';
            } else {
                $data['url']     = $this->mediaUrl;
                $data['caption'] = $this->caption;
                $data['type']    = $this->messageType;
                if ($this->messageType === 'document' && $this->filename) {
                    $data['filename'] = $this->filename;
                }
                $endpoint = '/api/send-group-media';
            }

            $response = Http::timeout(30)->post(config('whatsapp.node_server_url') . $endpoint, $data);

            if ($response->successful() && $response->json('status')) {
                $this->notification()->success(title: '¡Enviado!', description: 'Mensaje enviado al grupo');
                $this->closeModal();
            } else {
                throw new \Exception($response->json('message', 'Error desconocido'));
            }
        } catch (\Exception $e) {
            $this->notification()->error(title: 'Error', description: $e->getMessage());
        } finally {
            $this->sending = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.contacts.send-group-message');
    }
}
