<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

/**
 * Notificación parametrizada para los eventos del ciclo de vida de una orden
 * que NO son cambios de estado: reprogramada, retirada (reasignada a otro) y eliminada.
 *
 * Recibe un snapshot escalar de la orden en lugar del modelo, para que sea
 * seguro en cola incluso cuando la orden fue eliminada (soft delete).
 */
class OrdenEventoTecnico extends Notification implements ShouldQueue
{
    use Queueable;

    public const REPROGRAMADA = 'reprogramada';
    public const RETIRADA     = 'retirada';
    public const ELIMINADA    = 'eliminada';

    /**
     * @param array{
     *     id:int, codigo:string, tipo:?string, placa:?string,
     *     cliente:?string, fecha:?string, motivo:?string, url:string
     * } $orden
     */
    public function __construct(
        public string $evento,
        public array $orden
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database', 'broadcast'];

        if ($notifiable->fcm_token) {
            $channels[] = \App\Channels\FirebaseChannel::class;
        }

        return $channels;
    }

    public function toFirebase(object $notifiable): ?CloudMessage
    {
        if (!$notifiable->fcm_token) {
            return null;
        }

        [$titulo, $cuerpo] = $this->mensaje();

        $notification = FirebaseNotification::create($titulo, $cuerpo);

        $data = [
            'work_order_id'     => (string) $this->orden['id'],
            'work_order_codigo' => $this->orden['codigo'] ?? '',
            'evento'            => $this->evento,
            'action'            => 'work_order_' . $this->evento,
            'vehiculo_placa'    => $this->orden['placa'] ?? '',
            'fecha_programada'  => $this->orden['fecha'] ?? '',
            'motivo'            => $this->orden['motivo'] ?? '',
            'url'               => $this->orden['url'] ?? '',
        ];

        return CloudMessage::new()
            ->toToken($notifiable->fcm_token)
            ->withNotification($notification)
            ->withData($data)
            ->withAndroidConfig([
                'priority' => 'high',
                'notification' => [
                    'sound'        => 'default',
                    'channel_id'   => 'work_orders',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ],
            ])
            ->withApnsConfig([
                'payload' => [
                    'aps' => [
                        'sound' => 'default',
                        'badge' => 1,
                    ],
                ],
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        [$titulo, $cuerpo] = $this->mensaje();

        return [
            'work_order_id'     => $this->orden['id'],
            'work_order_codigo' => $this->orden['codigo'] ?? null,
            'evento'            => $this->evento,
            'titulo'            => $titulo,
            'mensaje'           => $cuerpo,
            'vehiculo_placa'    => $this->orden['placa'] ?? null,
            'fecha_programada'  => $this->orden['fecha'] ?? null,
            'motivo'            => $this->orden['motivo'] ?? null,
            'url'               => $this->orden['url'] ?? null,
            'icon'              => $this->icono(),
            'color'             => $this->color(),
        ];
    }

    /**
     * @return array{0:string, 1:string}
     */
    protected function mensaje(): array
    {
        $codigo = $this->orden['codigo'] ?? 'la orden';
        $placa  = $this->orden['placa'] ?? null;

        return match ($this->evento) {
            self::REPROGRAMADA => [
                '📅 Orden reprogramada',
                sprintf('La orden %s se reprogramó para %s.', $codigo, $this->orden['fecha'] ?? 'una nueva fecha'),
            ],
            self::RETIRADA => [
                '↩️ Orden reasignada',
                sprintf('La orden %s ya no está asignada a ti; fue reasignada a otro técnico.', $codigo),
            ],
            self::ELIMINADA => [
                '🗑️ Orden eliminada',
                sprintf('La orden %s%s fue eliminada.', $codigo, $placa ? " ({$placa})" : ''),
            ],
            default => ['Orden actualizada', sprintf('La orden %s cambió.', $codigo)],
        };
    }

    protected function icono(): string
    {
        return match ($this->evento) {
            self::REPROGRAMADA => 'calendar-days',
            self::RETIRADA     => 'arrow-uturn-left',
            self::ELIMINADA    => 'trash',
            default            => 'bell',
        };
    }

    protected function color(): string
    {
        return match ($this->evento) {
            self::REPROGRAMADA => 'warning',
            self::RETIRADA     => 'gray',
            self::ELIMINADA    => 'danger',
            default            => 'info',
        };
    }
}
