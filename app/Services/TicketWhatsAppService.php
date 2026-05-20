<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WhatsFleep\Device;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TicketWhatsAppService
{
    private function getInternalDevice(): ?Device
    {
        return Device::where('interno', true)
            ->where('status', 'Connected')
            ->first();
    }

    public function sendMessage(string $phone, string $message): bool
    {
        $device = $this->getInternalDevice();

        if (!$device) {
            Log::warning('TicketWhatsAppService: No hay dispositivo interno conectado.');
            return false;
        }

        $serverUrl = config('whatsapp.node_server_url', 'http://localhost:3000');

        try {
            $response = Http::timeout(10)->post("{$serverUrl}/api/send-message", [
                'token'   => $device->body,
                'number'  => $phone,
                'message' => $message,
            ]);

            if (!$response->successful()) {
                Log::warning('TicketWhatsAppService: Respuesta no exitosa.', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }

            return $response->successful();
        } catch (\Throwable $th) {
            Log::error('TicketWhatsAppService: Error al enviar mensaje.', [
                'error' => $th->getMessage(),
                'phone' => $phone,
            ]);
            return false;
        }
    }

    /**
     * Notifica al usuario asignado que el estado del ticket cambió.
     */
    public function notifyStatusChanged(Ticket $ticket, string $oldStatus, string $newStatus): void
    {
        $assignedUser = $ticket->assignedTo;

        if (!$assignedUser || !$assignedUser->telefonos) {
            return;
        }

        $oldLabel = TicketStatus::tryFrom($oldStatus)?->label() ?? $oldStatus;
        $newLabel = TicketStatus::tryFrom($newStatus)?->label() ?? $newStatus;

        $customer = $ticket->customer?->razon_social ?? 'N/A';
        $url      = route('admin.tickets.show', $ticket);

        $message = "🎫 *Actualización de Ticket*\n\n"
            . "Código: *{$ticket->code}*\n"
            . "Asunto: {$ticket->subject}\n"
            . "Cliente: {$customer}\n\n"
            . "Estado: {$oldLabel} → *{$newLabel}*\n\n"
            . "🔗 {$url}";

        $this->sendMessage($assignedUser->telefonos, $message);
    }

    /**
     * Notifica al usuario que se le asignó un ticket.
     */
    public function notifyAssigned(Ticket $ticket, User $assignedUser): void
    {
        if (!$assignedUser->telefonos) {
            return;
        }

        $priority = TicketPriority::tryFrom($ticket->priority->value)?->label() ?? $ticket->priority->value;
        $customer = $ticket->customer?->razon_social ?? 'N/A';
        $url      = route('admin.tickets.show', $ticket);

        $message = "🎫 *Se te asignó un ticket*\n\n"
            . "Código: *{$ticket->code}*\n"
            . "Asunto: {$ticket->subject}\n"
            . "Cliente: {$customer}\n"
            . "Prioridad: *{$priority}*\n\n"
            . "🔗 {$url}";

        $this->sendMessage($assignedUser->telefonos, $message);
    }
}
