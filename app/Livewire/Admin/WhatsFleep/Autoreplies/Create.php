<?php

namespace App\Livewire\Admin\WhatsFleep\Autoreplies;

use App\Models\WhatsFleep\Autoreply;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Create extends Component
{
    use WireUiActions;

    public bool   $showModal    = false;
    public string $device       = '';
    public string $keyword      = '';
    public string $type_keyword = 'Equal';
    public string $reply_when   = 'All';
    public string $type         = 'text';
    public bool   $status       = true;
    public bool   $is_quoted    = false;

    public string $replyText         = '';
    public string $replyImageUrl     = '';
    public string $replyImageCaption = '';

    protected function rules(): array
    {
        $uniqueRule = 'unique:autoreplies,keyword,NULL,id,device,' . $this->device;
        $replyRules = $this->type === 'text'
            ? ['replyText' => 'required|string|max:1000']
            : ['replyImageUrl' => 'required|url|max:500', 'replyImageCaption' => 'nullable|string|max:500'];

        return array_merge([
            'device'       => 'required|exists:devices,body',
            'keyword'      => ['required', 'string', 'max:255', $uniqueRule],
            'type_keyword' => 'required|in:Equal,Contain',
            'reply_when'   => 'required|in:Group,Personal,All',
            'type'         => 'required|in:text,image',
            'status'       => 'boolean',
            'is_quoted'    => 'boolean',
        ], $replyRules);
    }

    #[On('open-autoreply-create')]
    public function openModal(): void
    {
        $this->reset(['keyword', 'replyText', 'replyImageUrl', 'replyImageCaption']);
        $this->device       = session('selectedDevice.device_body', '');
        $this->type_keyword = 'Equal';
        $this->reply_when   = 'All';
        $this->type         = 'text';
        $this->status       = true;
        $this->is_quoted    = false;
        $this->resetValidation();
        $this->showModal    = true;
    }

    public function updatedType(): void
    {
        $this->reset(['replyText', 'replyImageUrl', 'replyImageCaption']);
        $this->resetValidation(['replyText', 'replyImageUrl', 'replyImageCaption']);
    }

    public function save(): void
    {
        $this->validate();

        $reply = $this->type === 'image'
            ? ['image' => ['url' => $this->replyImageUrl], 'caption' => $this->replyImageCaption]
            : ['text' => $this->replyText];

        Autoreply::create([
            'user_id'      => auth()->id(),
            'device'       => $this->device,
            'keyword'      => $this->keyword,
            'type_keyword' => $this->type_keyword,
            'reply_when'   => $this->reply_when,
            'type'         => $this->type,
            'reply'        => $reply,
            'status'       => $this->status,
            'is_quoted'    => $this->is_quoted,
        ]);

        $this->notification()->success('Creado', 'Auto-respuesta creada exitosamente.');
        $this->dispatch('autoreplyCreated');
        $this->showModal = false;
    }

    public function render()
    {
        $devices = auth()->user()->waDevices()->where('status', 'Connected')->get();

        return view('livewire.admin.whats-fleep.autoreplies.create', compact('devices'));
    }
}
