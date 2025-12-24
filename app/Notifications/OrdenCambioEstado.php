<?php

namespace App\Notifications;

use App\Models\WorkOrder;
use App\Enums\WorkOrderStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class OrdenCambioEstado extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public WorkOrder $workOrder,
        public WorkOrderStatus $estadoAnterior
    ) {}

    /**
     * Get the notification's delivery channels.
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
        $emoji = match ($this->workOrder->estado) {
            WorkOrderStatus::EN_PROCESO => '🚀',
            WorkOrderStatus::FINALIZADO => '✅',
            WorkOrderStatus::CANCELADO => '❌',
            default => '📋',
        };

        return (new FcmMessage(notification: new FcmNotification(
            title: sprintf('%s Orden %s', $emoji, $this->workOrder->codigo),
            body: sprintf(
                'Estado: %s → %s',
                $this->estadoAnterior->value,
                $this->workOrder->estado->value
            ),
        )))
            ->data([
                'work_order_id' => $this->workOrder->id,
                'work_order_codigo' => $this->workOrder->codigo,
                'estado_anterior' => $this->estadoAnterior->value,
                'estado_actual' => $this->workOrder->estado->value,
                'vehiculo_placa' => $this->workOrder->vehiculo->placa ?? null,
                'action' => 'work_order_status_changed',
                'url' => route('admin.work-orders.show', $this->workOrder),
            ])
            ->custom([
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'sound' => 'default',
                        'channel_id' => 'work_orders',
                    ],
                ],
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'work_order_id' => $this->workOrder->id,
            'work_order_codigo' => $this->workOrder->codigo,
            'estado_anterior' => $this->estadoAnterior->value,
            'estado_actual' => $this->workOrder->estado->value,
            'vehiculo_placa' => $this->workOrder->vehiculo->placa ?? null,
            'fecha_cambio' => now()->format('Y-m-d H:i:s'),
            'url' => route('admin.work-orders.show', $this->workOrder),
            'icon' => 'bell-alert',
            'color' => $this->workOrder->estado->statusColor(),
        ];
    }
}
