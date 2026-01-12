<?php

namespace App\Notifications;

use App\Models\WorkOrder;
use App\Enums\WorkOrderStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

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
        $channels = ['database', 'broadcast'];

        // Solo enviar por Firebase si el usuario tiene token FCM
        if ($notifiable->fcm_token) {
            $channels[] = \App\Channels\FirebaseChannel::class;
        }

        return $channels;
    }

    /**
     * Get the Firebase Cloud Messaging representation of the notification.
     */
    public function toFirebase(object $notifiable): ?CloudMessage
    {
        // Si el usuario no tiene token FCM, retornar null
        if (!$notifiable->fcm_token) {
            return null;
        }

        $emoji = match ($this->workOrder->estado) {
            WorkOrderStatus::EN_PROCESO => '🚀',
            WorkOrderStatus::FINALIZADO => '✅',
            WorkOrderStatus::CANCELADO => '❌',
            default => '📋',
        };

        $notification = FirebaseNotification::create(
            sprintf('%s Orden %s', $emoji, $this->workOrder->codigo),
            sprintf(
                'Estado: %s → %s',
                $this->estadoAnterior->value,
                $this->workOrder->estado->value
            )
        );

        $data = [
            'work_order_id' => (string) $this->workOrder->id,
            'work_order_codigo' => $this->workOrder->codigo,
            'estado_anterior' => $this->estadoAnterior->value,
            'estado_actual' => $this->workOrder->estado->value,
            'vehiculo_placa' => $this->workOrder->vehiculo->placa ?? '',
            'action' => 'work_order_status_changed',
            'url' => route('admin.work-orders.show', $this->workOrder),
        ];

        return CloudMessage::new()
            ->toToken($notifiable->fcm_token)
            ->withNotification($notification)
            ->withData($data)
            ->withAndroidConfig([
                'priority' => 'high',
                'notification' => [
                    'sound' => 'default',
                    'channel_id' => 'work_orders',
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
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
