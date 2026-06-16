<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\SendWhatsappMediaAction;
use App\Actions\WhatsFleep\SendWhatsappMessageAction;
use App\Enums\WhatsFleep\MessageType;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Models\WhatsFleep\WhatsappQuickReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class MessageComposer extends Component
{
    use WithFileUploads;

    public string $uuid;
    public string $body = '';
    public $attachment = null;
    public string $caption = '';

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function sendText(): void
    {
        $body = trim($this->body);
        if ($body === '') {
            return;
        }

        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        Gate::authorize('reply', $conversation);

        app(SendWhatsappMessageAction::class)->execute($conversation, Auth::user(), $body);

        $this->reset('body');
        $this->dispatch('message-sent');
    }

    public function sendAttachment(): void
    {
        $this->validate([
            'attachment' => ['required', 'file', 'max:16384'],
        ]);

        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        Gate::authorize('reply', $conversation);

        $empresaId = $conversation->empresa_id;
        $ext = $this->attachment->getClientOriginalExtension();
        $path = $this->attachment->storeAs(
            "whatsapp/outgoing/{$empresaId}",
            Str::uuid() . '.' . $ext,
            config('whatsapp.media_disk', 'local')
        );

        app(SendWhatsappMediaAction::class)->execute(
            $conversation,
            Auth::user(),
            $this->resolveType($this->attachment->getMimeType()),
            [
                'media_path' => $path,
                'mime_type' => $this->attachment->getMimeType(),
                'file_name' => $this->attachment->getClientOriginalName(),
                'file_size' => $this->attachment->getSize(),
                'caption' => trim($this->caption) ?: null,
            ]
        );

        $this->reset('attachment', 'caption');
        $this->dispatch('message-sent');
    }

    public function applyQuickReply(int $id): void
    {
        $reply = WhatsappQuickReply::active()->find($id);
        if ($reply) {
            // Si el textarea contiene el filtro "/atajo", reemplazarlo por el cuerpo;
            // de lo contrario, anexar.
            $this->body = str_starts_with($this->body, '/')
                ? $reply->body
                : trim($this->body . ' ' . $reply->body);
        }
    }

    private function resolveType(?string $mime): MessageType
    {
        return match (true) {
            str_starts_with((string) $mime, 'image/') => MessageType::Image,
            str_starts_with((string) $mime, 'audio/') => MessageType::Audio,
            str_starts_with((string) $mime, 'video/') => MessageType::Video,
            default => MessageType::Document,
        };
    }

    private function conversation(): ?WhatsappConversation
    {
        return WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $quickReplies = WhatsappQuickReply::active()
            ->when($this->body !== '' && str_starts_with($this->body, '/'), function ($q) {
                $q->where('shortcut', 'like', ltrim($this->body, '/') . '%');
            })
            ->orderBy('shortcut')
            ->limit(8)
            ->get();

        return view('livewire.admin.whats-fleep.inbox.message-composer', [
            'quickReplies' => $quickReplies,
        ]);
    }
}
