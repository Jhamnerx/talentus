<?php

namespace App\Jobs\WhatsFleep;

use App\Models\WhatsFleep\Campaign;
use App\Services\WhatsFleep\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 300;

    public function __construct(
        protected Campaign $campaign,
        protected array $messageData
    ) {}

    public function handle(WhatsappService $whatsappService): void
    {
        try {
            $this->campaign->update(['status' => 'processing']);

            $sender = $this->messageData['sender'];
            $delay  = $this->campaign->delay * 1000;

            $blasts = $this->campaign->blasts()->where('status', 'pending')->get();

            foreach ($blasts as $blast) {
                try {
                    $result = $this->sendMessage($whatsappService, $sender, $blast->receiver, $this->messageData);

                    if (isset($result->status) && $result->status) {
                        $blast->update(['status' => 'sent', 'sent_at' => now()]);
                    } else {
                        $blast->update(['status' => 'failed', 'error' => $result->message ?? 'Error desconocido']);
                    }

                    if ($delay > 0) {
                        usleep($delay * 1000);
                    }
                } catch (\Exception $e) {
                    Log::error("WhatsFleep: Error enviando blast {$blast->id}: " . $e->getMessage());
                    $blast->update(['status' => 'failed', 'error' => $e->getMessage()]);
                }
            }

            $totalBlasts  = $this->campaign->blasts()->count();
            $sentBlasts   = $this->campaign->blasts()->where('status', 'sent')->count();
            $failedBlasts = $this->campaign->blasts()->where('status', 'failed')->count();

            $this->campaign->update([
                'status'       => 'completed',
                'total'        => $totalBlasts,
                'sent'         => $sentBlasts,
                'failed'       => $failedBlasts,
                'completed_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error("WhatsFleep: Error en campaña {$this->campaign->id}: " . $e->getMessage());
            $this->campaign->update(['status' => 'failed']);
            throw $e;
        }
    }

    private function sendMessage(WhatsappService $service, string $sender, string $receiver, array $data): object
    {
        return match ($data['type'] ?? 'text') {
            'text'     => $service->sendText($sender, $receiver, $data['message']),
            'image',
            'video',
            'audio',
            'document' => $service->sendMedia($sender, $receiver, $data['type'], $data['url'], $data['caption'] ?? ''),
            'button'   => $service->sendButton($sender, $receiver, $data['message'], $data['buttons'], $data['footer'] ?? ''),
            'template' => $service->sendTemplate($sender, $receiver, $data['message'], $data['buttons'], $data['footer'] ?? ''),
            'list'     => $service->sendList($sender, $receiver, $data['message'], $data['sections'], $data['footer'] ?? '', $data['title'] ?? '', $data['buttonText'] ?? ''),
            default    => $service->sendText($sender, $receiver, $data['message']),
        };
    }
}
