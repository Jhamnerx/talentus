<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\AssignConversationAction;
use App\Actions\WhatsFleep\ChangeConversationStatusAction;
use App\Enums\WhatsFleep\ConversationPriority;
use App\Enums\WhatsFleep\ConversationStatus;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ConversationHeader extends Component
{
    public string $uuid;
    public ?int $reassignTo = null;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function assignToMe(): void
    {
        $conversation = $this->conversation();
        if (!$conversation) {
            return;
        }

        Gate::authorize('assignToSelf', $conversation);

        app(AssignConversationAction::class)->execute($conversation, Auth::id(), Auth::user());
        $this->dispatch('conversation-updated');
    }

    public function reassign(): void
    {
        $conversation = $this->conversation();
        if (!$conversation || !$this->reassignTo) {
            return;
        }

        Gate::authorize('reassign', $conversation);

        app(AssignConversationAction::class)->execute($conversation, $this->reassignTo, Auth::user());
        $this->reset('reassignTo');
        $this->dispatch('conversation-updated');
    }

    public function setStatus(string $status): void
    {
        $conversation = $this->conversation();
        if (!$conversation) {
            return;
        }

        Gate::authorize('changeStatus', $conversation);

        app(ChangeConversationStatusAction::class)->execute($conversation, ConversationStatus::from($status), Auth::user());
        $this->dispatch('conversation-updated');
    }

    public function setPriority(string $priority): void
    {
        $conversation = $this->conversation();
        if (!$conversation) {
            return;
        }

        Gate::authorize('setPriority', $conversation);

        $conversation->forceFill(['priority' => ConversationPriority::from($priority)])->save();
        $this->dispatch('conversation-updated');
    }

    private function conversation(): ?WhatsappConversation
    {
        return WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $conversation = WhatsappConversation::with(['contact', 'cliente', 'assignedUser'])
            ->where('uuid', $this->uuid)
            ->first();

        $user = Auth::user();
        $agents = $this->resolveAgentsList($user);

        return view('livewire.admin.whats-fleep.inbox.conversation-header', [
            'conversation' => $conversation,
            'agents' => $agents,
        ]);
    }

    /**
     * Gerente: todos los usuarios con algún permiso WhatsApp.
     * Supervisor: solo miembros de sus equipos liderados.
     * Agente: lista vacía (no puede reasignar).
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    private function resolveAgentsList(User $user): \Illuminate\Database\Eloquent\Collection
    {
        if ($user->can('ver-whatsapp-todos')) {
            return User::permission(['ver-whatsapp', 'ver-whatsapp-area', 'ver-whatsapp-todos'])
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        if ($user->can('ver-whatsapp-area')) {
            $leaderTeamIds = DB::table('team_user')
                ->where('user_id', $user->id)
                ->where('role_in_team', 'lider')
                ->pluck('team_id');

            $memberIds = DB::table('team_user')
                ->whereIn('team_id', $leaderTeamIds)
                ->pluck('user_id')
                ->unique()
                ->all();

            return User::whereIn('id', $memberIds)
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        return collect();
    }
}
