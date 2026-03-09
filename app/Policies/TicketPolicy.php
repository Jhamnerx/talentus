<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     * Admin: puede ver todos
     * Agente: ve tickets de su equipo o asignados a él
     * Cliente: no usa este método (no accede al índice completo)
     */
    public function viewAny(User $user): bool
    {
        // Super-admin y admin pueden ver todos
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Agentes pueden ver listado (filtrado por su alcance)
        if ($user->hasRole('agente')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     * Admin: todo
     * Agente: si está asignado o pertenece a un equipo del ticket
     * Cliente: si el ticket pertenece a su cliente (via user->clientes relation o similar)
     */
    public function view(User $user, Ticket $ticket): bool
    {
        // Super-admin y admin pueden ver todo
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Agente: puede ver si está asignado o si el ticket pertenece a uno de sus equipos
        if ($user->hasRole('agente')) {
            if ($ticket->assigned_to === $user->id) {
                return true;
            }

            // Verificar si el usuario pertenece al equipo del ticket
            if ($ticket->team_id && $user->teams->contains($ticket->team_id)) {
                return true;
            }
        }

        // Cliente: puede ver si el ticket es de su cliente
        // Asumiendo que el cliente tiene relación con User (ej: user_id en clientes)
        // Ajustar según la lógica real de tu aplicación
        if ($user->hasRole('cliente')) {
            // TODO: Implementar lógica específica para clientes
            // Por ejemplo: return $ticket->customer->user_id === $user->id;
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     * Admin y agentes pueden crear tickets
     * Clientes también pueden crear tickets (de su propia empresa/cuenta)
     */
    public function create(User $user): bool
    {
        // Admin, agentes y clientes pueden crear tickets
        return $user->hasRole(['super-admin', 'admin', 'agente', 'cliente']);
    }

    /**
     * Determine whether the user can update the model.
     * Admin: todo
     * Agente: solo si tiene acceso al ticket
     * Cliente: solo para agregar mensajes, no para editar ticket
     */
    public function update(User $user, Ticket $ticket): bool
    {
        // Super-admin y admin pueden editar todo
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Agente: puede editar si tiene acceso al ticket
        if ($user->hasRole('agente')) {
            if ($ticket->assigned_to === $user->id) {
                return true;
            }

            if ($ticket->team_id && $user->teams->contains($ticket->team_id)) {
                return true;
            }
        }

        // Clientes no pueden editar tickets directamente
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * Solo admin puede eliminar tickets
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can add messages to the ticket.
     * Admin y agentes con acceso pueden agregar mensajes
     * Clientes pueden responder en sus propios tickets
     */
    public function addMessage(User $user, Ticket $ticket): bool
    {
        // Admin siempre puede
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Agente: si tiene acceso al ticket
        if ($user->hasRole('agente')) {
            return $this->view($user, $ticket);
        }

        // Cliente: si el ticket es suyo
        if ($user->hasRole('cliente')) {
            // TODO: Implementar lógica para clientes
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can change status.
     * Solo admin y agentes con acceso
     */
    public function changeStatus(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        if ($user->hasRole('agente')) {
            return $this->view($user, $ticket);
        }

        return false;
    }

    /**
     * Determine whether the user can assign/reassign tickets.
     * Solo admin y agentes con acceso
     */
    public function assign(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        if ($user->hasRole('agente')) {
            return $this->view($user, $ticket);
        }

        return false;
    }

    /**
     * Determine whether the user can add attachments.
     * Admin, agentes con acceso, y clientes en sus tickets
     */
    public function addAttachment(User $user, Ticket $ticket): bool
    {
        return $this->addMessage($user, $ticket);
    }
}


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
