<?php

namespace App\Livewire\Admin\WhatsFleep\Messages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class TestMessage extends Component
{
    use WireUiActions;

    public string $sender  = '';
    public string $number  = '';
    public string $type    = 'text';
    public string $message = '';

    // Media
    public string $mediaUrl  = '';
    public string $caption   = '';
    public string $filename  = '';

    // Template/List
    public string $templateTitle      = '';
    public string $templateBody       = '';
    public string $templateFooter     = '';
    public string $templateButtonText = 'Ver opciones';
    public array  $templateSections   = [
        ['title' => 'Sección 1', 'rows' => [['id' => 'row1', 'title' => '', 'description' => '']]],
    ];

    public ?array $result  = null;
    public ?string $error  = null;
    public bool   $sending = false;

    public function mount(): void
    {
        $devices = Auth::user()->waDevices()->where('status', 'Connected')->get();

        if (session()->has('selectedDevice')) {
            $this->sender = session('selectedDevice')['device_body'];
        } elseif ($devices->isNotEmpty()) {
            $this->sender = $devices->first()->body;
        }
    }

    public function addSection(): void
    {
        $this->templateSections[] = [
            'title' => 'Sección ' . (count($this->templateSections) + 1),
            'rows'  => [['id' => 'row' . rand(100, 999), 'title' => '', 'description' => '']],
        ];
    }

    public function removeSection(int $index): void
    {
        array_splice($this->templateSections, $index, 1);
        $this->templateSections = array_values($this->templateSections);
    }

    public function addRow(int $sectionIndex): void
    {
        $this->templateSections[$sectionIndex]['rows'][] = [
            'id' => 'row' . rand(100, 999),
            'title' => '',
            'description' => '',
        ];
    }

    public function removeRow(int $sectionIndex, int $rowIndex): void
    {
        array_splice($this->templateSections[$sectionIndex]['rows'], $rowIndex, 1);
        $this->templateSections[$sectionIndex]['rows'] = array_values($this->templateSections[$sectionIndex]['rows']);
    }

    public function send(): void
    {
        $this->validate([
            'sender' => 'required',
            'number' => 'required|string',
            'type'   => 'required',
        ]);

        $this->sending = true;
        $this->result  = null;
        $this->error   = null;

        $serverUrl = config('whatsapp.node_server_url', 'http://localhost:3000');
        $numbers   = array_filter(array_map('trim', explode('|', $this->number)));

        try {
            $responses = [];

            foreach ($numbers as $num) {
                $response = match ($this->type) {
                    'text'     => Http::timeout(15)->post("{$serverUrl}/api/send-message", [
                        'token'   => $this->sender,
                        'number'  => $num,
                        'message' => $this->message,
                    ]),
                    'image'    => Http::timeout(15)->post("{$serverUrl}/api/send-image", [
                        'token'    => $this->sender,
                        'number'   => $num,
                        'imageUrl' => $this->mediaUrl,
                        'caption'  => $this->caption,
                    ]),
                    'video'    => Http::timeout(15)->post("{$serverUrl}/api/send-video", [
                        'token'    => $this->sender,
                        'number'   => $num,
                        'videoUrl' => $this->mediaUrl,
                        'caption'  => $this->caption,
                    ]),
                    'audio'    => Http::timeout(15)->post("{$serverUrl}/api/send-audio", [
                        'token'    => $this->sender,
                        'number'   => $num,
                        'audioUrl' => $this->mediaUrl,
                    ]),
                    'document' => Http::timeout(15)->post("{$serverUrl}/api/send-document", [
                        'token'       => $this->sender,
                        'number'      => $num,
                        'documentUrl' => $this->mediaUrl,
                        'fileName'    => $this->filename ?: 'document',
                    ]),
                    default    => null,
                };

                if ($response) {
                    $responses[$num] = $response->json();
                }
            }

            $this->result = count($responses) === 1
                ? array_values($responses)[0]
                : $responses;
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $port = parse_url(config('whatsapp.node_server_url', 'http://localhost:3000'), PHP_URL_PORT);
            $this->error = "El servidor WhatsApp no está disponible. Verifica que Node.js esté iniciado en el puerto {$port}.";
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }

        $this->sending = false;
    }

    public function render()
    {
        $devices = Auth::user()->waDevices()->where('status', 'Connected')->get();

        return view('livewire.admin.whats-fleep.messages.test-message', compact('devices'));
    }
}
