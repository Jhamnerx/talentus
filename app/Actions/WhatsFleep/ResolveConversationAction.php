<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\ConversationStatus;
use App\Models\WhatsFleep\Contact;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappConversation;

class ResolveConversationAction
{
    /**
     * Reabre la conversación abierta de (contacto, device) o crea una nueva.
     * Debe ejecutarse dentro de una transacción (usa lockForUpdate).
     */
    public function execute(Device $device, Contact $contact, int $empresaId, ?int $clienteId): WhatsappConversation
    {
        $conversation = WhatsappConversation::query()
            ->where('device_id', $device->id)
            ->where('contact_id', $contact->id)
            ->where('status', ConversationStatus::Open->value)
            ->lockForUpdate()
            ->first();

        if ($conversation) {
            if ($clienteId && ! $conversation->cliente_id) {
                $conversation->cliente_id = $clienteId;
                $conversation->save();
            }

            return $conversation;
        }

        return WhatsappConversation::create([
            'empresa_id' => $empresaId,
            'device_id' => $device->id,
            'contact_id' => $contact->id,
            'cliente_id' => $clienteId,
            'status' => ConversationStatus::Open,
            'unread_count' => 0,
        ]);
    }
}
