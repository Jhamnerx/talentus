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

class WorkOrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public WorkOrder $workOrder
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->workOrder->tecnico_id),
            new PrivateChannel('empresa.' . $this->workOrder->empresa_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'work-order.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->workOrder->id,
            'codigo' => $this->workOrder->codigo,
            'tipo' => $this->workOrder->tipo->nombre ?? null,
            'vehiculo_placa' => $this->workOrder->vehiculo->placa ?? null,
            'cliente_nombre' => $this->workOrder->cliente->razon_social ?? null,
            'tecnico_nombre' => $this->workOrder->tecnico->name ?? null,
            'fecha_programada' => $this->workOrder->fecha_programada?->format('Y-m-d H:i'),
            'estado' => $this->workOrder->estado->value,
            'url' => route('admin.work-orders.show', $this->workOrder),
            'created_at' => $this->workOrder->created_at->toISOString(),
        ];
    }
}
