<?php

namespace App\Notifications\Portal;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PortalAccesoActualizadoNotification extends Notification
{
    use Queueable;

    public function __construct(public string $estado, public ?string $motivo = null)
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
        $mail = (new MailMessage())->greeting("Hola {$notifiable->name},");

        return match ($this->estado) {
            'aprobado' => $mail
                ->subject('Tu acceso al portal fue aprobado')
                ->line('¡Buenas noticias! Tu acceso al portal de cliente fue aprobado.')
                ->action('Ingresar al portal', rtrim(config('portal.url'), '/') . '/login')
                ->line('Ya puedes iniciar sesión con tu correo y contraseña.'),

            'rechazado' => $mail
                ->subject('Tu solicitud de acceso al portal')
                ->line('Lamentamos informarte que tu solicitud de acceso fue rechazada.')
                ->when($this->motivo, fn (MailMessage $m) => $m->line("Motivo: {$this->motivo}"))
                ->line('Si crees que es un error, contáctanos.'),

            'suspendido' => $mail
                ->subject('Tu acceso al portal fue suspendido')
                ->line('Tu acceso al portal ha sido suspendido temporalmente.')
                ->when($this->motivo, fn (MailMessage $m) => $m->line("Motivo: {$this->motivo}"))
                ->line('Contáctanos para más información.'),

            default => $mail
                ->subject('Actualización de tu acceso al portal')
                ->line('El estado de tu acceso al portal ha cambiado.'),
        };
    }
}
