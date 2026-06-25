<?php

namespace App\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitacionPortalNotification extends Notification
{
    use Queueable;

    public function __construct(public string $token, public ?string $empresa = null)
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

        $empresa = $this->empresa ? " de {$this->empresa}" : '';
        $expira = config('auth.passwords.cliente_users.expire', 60);

        return (new MailMessage())
            ->subject('Te invitaron al Portal de Clientes — Talentus')
            ->greeting("Hola {$notifiable->name},")
            ->line("Te invitaron a acceder al Portal de Clientes{$empresa}.")
            ->line('Para activar tu acceso, establece tu contraseña con el siguiente botón:')
            ->action('Establecer mi contraseña', $url)
            ->line("Este enlace expira en {$expira} minutos. Si expira, usa la opción «¿Olvidaste tu contraseña?» en la pantalla de acceso para recibir uno nuevo.");
    }
}
