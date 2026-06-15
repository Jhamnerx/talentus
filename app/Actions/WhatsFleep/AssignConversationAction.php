<?php

namespace App\Actions\WhatsFleep;

use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappAssignment;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\DB;

class AssignConversationAction
{
    /**
     * Asigna/reasigna la conversación a un usuario y registra la auditoría.
     * Sin filtrado por rol (SP#3 lo añade).
     */
    public function execute(WhatsappConversation $conversation, ?int $toUserId, User $actor): WhatsappConversation
    {
        $fromUserId = $conversation->assigned_user_id;

        if ($fromUserId === $toUserId) {
            return $conversation;
        }

        DB::transaction(function () use ($conversation, $fromUserId, $toUserId, $actor) {
            $conversation->forceFill(['assigned_user_id' => $toUserId])->save();

            WhatsappAssignment::create([
                'empresa_id' => $conversation->empresa_id,
                'conversation_id' => $conversation->id,
                'from_user_id' => $fromUserId,
                'to_user_id' => $toUserId,
                'assigned_by' => $actor->id,
                'created_at' => now(),
            ]);
        });

        broadcast(new ConversationUpdated($conversation));

        return $conversation;
    }
}
