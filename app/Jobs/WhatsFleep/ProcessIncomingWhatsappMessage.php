<?php

namespace App\Jobs\WhatsFleep;

use App\Actions\WhatsFleep\PersistIncomingMessageAction;
use App\Actions\WhatsFleep\ResolveConversationAction;
use App\Actions\WhatsFleep\ResolveWhatsappContactAction;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Events\WhatsFleep\NewWhatsappMessage;
use App\Models\WhatsFleep\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessIncomingWhatsappMessage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(public array $payload)
    {
        $this->onQueue('whatsapp');
    }

    public function handle(
        ResolveWhatsappContactAction $resolveContact,
        ResolveConversationAction $resolveConversation,
        PersistIncomingMessageAction $persistMessage
    ): void {
        if (! empty($this->payload['is_group'])) {
            return;
        }

        $device = Device::where('body', $this->payload['device'])->first();

        if (! $device) {
            Log::warning('WA ingest: device not found', ['device' => $this->payload['device']]);
            return;
        }

        [$message, $conversation] = DB::transaction(function () use (
            $device,
            $resolveContact,
            $resolveConversation,
            $persistMessage
        ) {
            $resolved = $resolveContact->execute(
                $device,
                $this->payload['from'],
                $this->payload['wa_jid'] ?? null,
                $this->payload['push_name'] ?? null
            );

            $conversation = $resolveConversation->execute(
                $device,
                $resolved['contact'],
                $resolved['empresa_id'],
                $resolved['cliente_id']
            );

            $message = $persistMessage->execute(
                $conversation,
                $device,
                $resolved['contact'],
                $this->payload
            );

            return [$message, $conversation->refresh()];
        });

        broadcast(new NewWhatsappMessage($message));
        broadcast(new ConversationUpdated($conversation));
    }
}
