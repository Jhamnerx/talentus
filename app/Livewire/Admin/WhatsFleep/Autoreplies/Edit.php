<?php

namespace App\Livewire\Admin\WhatsFleep\Autoreplies;

use App\Models\WhatsFleep\Autoreply;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Edit extends Component
{
    use WireUiActions;

    public bool   $showModal    = false;
    public ?int   $autoreplyId  = null;
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
        $uniqueRule = 'unique:autoreplies,keyword,' . $this->autoreplyId . ',id,device,' . $this->device;
        $replyRules = $this->type === 'text'
            ? ['replyText' => 'required|string|max:1000']
            : ['replyImageUrl' => 'required|url|max:500', 'replyImageCaption' => 'nullable|string|max:500'];

        return array_merge([
            'device'       => 'required|exists:devices,body',
            'keyword'      => ['required', 'string', 'max:255', $uniqueRule],
            'type_keyword' => 'required|in:Equal,Contain',
            'reply_when'   => 'required|in:Group,Personal,All',
            'type'         => 'required|in:text,image',
        ], $replyRules);
    }

    #[On('open-autoreply-edit')]
    public function openModal(int $id): void
    {
        $ar = Autoreply::where('user_id', auth()->id())->findOrFail($id);

        $this->autoreplyId  = $ar->id;
        $this->device       = $ar->device;
        $this->keyword      = $ar->keyword;
        $this->type_keyword = $ar->type_keyword ?? 'Equal';
        $this->reply_when   = $ar->reply_when   ?? 'All';
        $this->type         = $ar->type;
        $this->status       = (bool) $ar->status;
        $this->is_quoted    = (bool) $ar->is_quoted;

        $reply = is_array($ar->reply) ? $ar->reply : (json_decode($ar->reply, true) ?? []);

        if ($this->type === 'text') {
            $this->replyText = $reply['text'] ?? '';
        } else {
            $imgData = $reply['image'] ?? [];
            $this->replyImageUrl     = is_array($imgData) ? ($imgData['url'] ?? '') : (string) $imgData;
            $this->replyImageCaption = $reply['caption'] ?? '';
        }

        $this->resetValidation();
        $this->showModal = true;
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

        Autoreply::where('user_id', auth()->id())
            ->findOrFail($this->autoreplyId)
            ->update([
                'device'       => $this->device,
                'keyword'      => $this->keyword,
                'type_keyword' => $this->type_keyword,
                'reply_when'   => $this->reply_when,
                'type'         => $this->type,
                'reply'        => $reply,
                'status'       => $this->status,
                'is_quoted'    => $this->is_quoted,
            ]);

        $this->notification()->success('Actualizado', 'Auto-respuesta actualizada correctamente.');
        $this->dispatch('autoreplyUpdated');
        $this->showModal = false;
    }

    public function render()
    {
        $devices = auth()->user()->waDevices()->where('status', 'Connected')->get();

        return view('livewire.admin.whats-fleep.autoreplies.edit', compact('devices'));
    }
}
