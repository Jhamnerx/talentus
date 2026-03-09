<?php

namespace App\Events;

use App\Models\WorkOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorkOrderUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public WorkOrder $workOrder,
        public array $changes = []
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [
            new PrivateChannel('user.' . $this->workOrder->tecnico_id),
            new PrivateChannel('empresa.' . $this->workOrder->empresa_id),
        ];

        // También notificar al creador si es diferente del técnico
        if ($this->workOrder->created_by && $this->workOrder->created_by !== $this->workOrder->tecnico_id) {
            $channels[] = new PrivateChannel('user.' . $this->workOrder->created_by);
        }

        return $channels;
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'work-order.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->workOrder->id,
            'codigo' => $this->workOrder->codigo,
            'estado' => $this->workOrder->estado->value,
            'changes' => $this->changes,
            'vehiculo_placa' => $this->workOrder->vehiculo->placa ?? null,
            'url' => route('admin.work-orders.show', $this->workOrder),
            'updated_at' => $this->workOrder->updated_at->toISOString(),
        ];
    }
}
