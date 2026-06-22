<?php

namespace App\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyPortalEmailNotification extends Notification
{
    use Queueable;

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage())
            ->subject('Verifica tu correo — Portal de Cliente')
            ->greeting("Hola {$notifiable->name},")
            ->line('Gracias por registrarte en el portal. Confirma tu correo para continuar.')
            ->action('Verificar correo', $url)
            ->line('Tras verificar, tu cuenta quedará en revisión hasta que un administrador la apruebe.')
            ->line('Si no creaste esta cuenta, ignora este mensaje.');
    }

    protected function verificationUrl(object $notifiable): string
    {
        return URL::temporarySignedRoute(
            'api.portal.auth.verify',
            now()->addMinutes((int) config('portal.signed_link_minutes', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->email),
            ]
        );
    }
}
