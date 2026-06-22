<?php

namespace App\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPortalPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(public string $token)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = rtrim(config('portal.url'), '/')
            . '/reset-password?token=' . $this->token
            . '&email=' . urlencode($notifiable->email);

        return (new MailMessage())
            ->subject('Restablece tu contraseña — Portal de Cliente')
            ->greeting("Hola {$notifiable->name},")
            ->line('Recibimos una solicitud para restablecer tu contraseña.')
            ->action('Restablecer contraseña', $url)
            ->line('Este enlace expira en ' . config('auth.passwords.cliente_users.expire', 60) . ' minutos.')
            ->line('Si no solicitaste esto, ignora este mensaje.');
    }
}
