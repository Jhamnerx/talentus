<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Illuminate\Support\Facades\Log;

class FirebaseChannel
{
    public function __construct(
        protected Messaging $messaging
    ) {}

    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        // Verificar que el usuario tenga token FCM
        if (!$notifiable->fcm_token) {
            return;
        }

        // Verificar que la notificación tenga el método toFirebase
        if (!method_exists($notification, 'toFirebase')) {
            return;
        }

        // Obtener el mensaje de Firebase
        $message = $notification->toFirebase($notifiable);

        // Si no hay mensaje, salir
        if (!$message) {
            return;
        }

        try {
            // Enviar mensaje
            $this->messaging->send($message);

            Log::info('Notificación FCM enviada exitosamente', [
                'notifiable_id' => $notifiable->id,
                'notification_class' => get_class($notification),
            ]);
        } catch (MessagingException $e) {
            // Error específico de mensajería (token inválido, expirado, etc.)
            Log::error('Error enviando notificación FCM', [
                'notifiable_id' => $notifiable->id,
                'notification_class' => get_class($notification),
                'error' => $e->getMessage(),
                'token' => substr($notifiable->fcm_token, 0, 20) . '...',
            ]);

            // Si el token es inválido, limpiarlo
            if ($this->isInvalidToken($e)) {
                $notifiable->update(['fcm_token' => null]);
                Log::info('Token FCM inválido limpiado', [
                    'notifiable_id' => $notifiable->id,
                ]);
            }
        } catch (FirebaseException $e) {
            // Error general de Firebase
            Log::error('Error de Firebase', [
                'notifiable_id' => $notifiable->id,
                'notification_class' => get_class($notification),
                'error' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error inesperado enviando notificación FCM', [
                'notifiable_id' => $notifiable->id,
                'notification_class' => get_class($notification),
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Determinar si el error es por token inválido
     */
    protected function isInvalidToken(MessagingException $e): bool
    {
        $message = $e->getMessage();

        return str_contains($message, 'Requested entity was not found') ||
            str_contains($message, 'registration-token-not-registered') ||
            str_contains($message, 'invalid-registration-token') ||
            str_contains($message, 'InvalidRegistration');
    }
}
