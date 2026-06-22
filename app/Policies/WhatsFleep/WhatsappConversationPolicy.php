<?php

namespace App\Policies\WhatsFleep;

use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\DB;

class WhatsappConversationPolicy
{
    /** Cualquiera con al menos un permiso WhatsApp puede listar. */
    public function viewAny(User $user): bool
    {
        return $user->canAny(['ver-whatsapp', 'ver-whatsapp-area', 'ver-whatsapp-todos']);
    }

    /** La conversación está en el rango visible del usuario. */
    public function view(User $user, WhatsappConversation $conversation): bool
    {
        if ((int) $conversation->empresa_id !== (int) session('empresa', 1)) {
            return false;
        }

        if ($user->can('ver-whatsapp-todos')) {
            return true;
        }

        if ($user->can('ver-whatsapp-area')) {
            if ($conversation->assigned_user_id === null) {
                return true;
            }
            if ($conversation->assigned_user_id === $user->id) {
                return true;
            }

            $leaderTeamIds = DB::table('team_user')
                ->where('user_id', $user->id)
                ->where('role_in_team', 'lider')
                ->pluck('team_id');

            return DB::table('team_user')
                ->whereIn('team_id', $leaderTeamIds)
                ->where('user_id', $conversation->assigned_user_id)
                ->exists();
        }

        // Agente
        return $conversation->assigned_user_id === $user->id
            || $conversation->assigned_user_id === null;
    }

    /** Enviar un mensaje (texto o adjunto). */
    public function reply(User $user, WhatsappConversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    /** Cambiar estado (cerrar, reabrir, pendiente). */
    public function changeStatus(User $user, WhatsappConversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    /** Cambiar prioridad. */
    public function setPriority(User $user, WhatsappConversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    /** Asignarse a sí mismo. */
    public function assignToSelf(User $user, WhatsappConversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    /**
     * Reasignar a otro usuario.
     * Gerente: a cualquiera. Supervisor: a miembros de su área. Agente: no puede.
     */
    public function reassign(User $user, WhatsappConversation $conversation): bool
    {
        if ($user->can('ver-whatsapp-todos')) {
            return true;
        }

        if ($user->can('ver-whatsapp-area')) {
            return $this->view($user, $conversation);
        }

        return false;
    }
}
