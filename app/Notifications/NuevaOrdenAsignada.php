<?php

namespace App\Notifications;

use App\Models\WorkOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class NuevaOrdenAsignada extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public WorkOrder $workOrder
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    /**
     * Get the FCM representation of the notification.
     */
    public function toFcm(object $notifiable): FcmMessage
    {
        return (new FcmMessage(notification: new FcmNotification(
            title: '🔧 Nueva Orden de Trabajo Asignada',
            body: sprintf(
                'Orden %s - %s | Vehículo: %s',
                $this->workOrder->codigo,
                $this->workOrder->tipo->nombre ?? 'Sin tipo',
                $this->workOrder->vehiculo->placa ?? 'N/A'
            ),
        )))
            ->data([
                'work_order_id' => $this->workOrder->id,
                'work_order_codigo' => $this->workOrder->codigo,
                'tipo' => $this->workOrder->tipo->nombre ?? null,
                'vehiculo_placa' => $this->workOrder->vehiculo->placa ?? null,
                'vehiculo_id' => $this->workOrder->vehiculo_id,
                'cliente_nombre' => $this->workOrder->cliente->razon_social ?? null,
                'fecha_programada' => $this->workOrder->fecha_programada?->format('Y-m-d H:i'),
                'observaciones' => $this->workOrder->observaciones,
                'action' => 'work_order_assigned',
                'url' => route('admin.work-orders.show', $this->workOrder),
            ])
            ->custom([
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'sound' => 'default',
                        'channel_id' => 'work_orders',
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                            'badge' => 1,
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Get the array representation of the notification (database).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'work_order_id' => $this->workOrder->id,
            'work_order_codigo' => $this->workOrder->codigo,
            'tipo' => $this->workOrder->tipo->nombre ?? null,
            'vehiculo_placa' => $this->workOrder->vehiculo->placa ?? null,
            'vehiculo_id' => $this->workOrder->vehiculo_id,
            'cliente_nombre' => $this->workOrder->cliente->razon_social ?? null,
            'fecha_programada' => $this->workOrder->fecha_programada?->format('Y-m-d H:i:s'),
            'observaciones' => $this->workOrder->observaciones,
            'estado' => $this->workOrder->estado->value,
            'url' => route('admin.work-orders.show', $this->workOrder),
            'icon' => 'clipboard-document-list',
            'color' => 'info',
        ];
    }
}
