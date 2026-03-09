<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use NotificationChannels\Fcm\FcmChannel;

class DeleteExpiredFcmTokens
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationFailed $event): void
    {
        if ($event->channel === FcmChannel::class) {
            $report = Arr::get($event->data, 'report');

            if ($report) {
                $target = $report->target();

                // Limpiar el token FCM del usuario
                $event->notifiable->update([
                    'fcm_token' => null,
                ]);

                \Log::warning('Token FCM expirado eliminado', [
                    'user_id' => $event->notifiable->id,
                    'token' => $target->value(),
                ]);
            }
        }
    }
}
