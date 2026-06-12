<?php

namespace App\Livewire\Admin\WorkOrders;

use App\Models\WorkOrder;
use Livewire\Component;

class TecnicoMap extends Component
{
    public int $workOrderId;
    public ?string $tecnicoNombre = null;

    public ?float $lat = null;
    public ?float $lng = null;
    public ?string $lastSeenLabel = null;
    public ?int $secondsAgo = null;
    public bool $enProceso = false;

    public function mount(WorkOrder $workOrder): void
    {
        $this->workOrderId   = $workOrder->id;
        $this->tecnicoNombre = $workOrder->tecnico->name ?? null;
        $this->refreshLocation();
    }

    /**
     * Lee la última posición del técnico. Invocado por wire:poll cada 15s.
     */
    public function refreshLocation(): void
    {
        $row = WorkOrder::query()
            ->whereKey($this->workOrderId)
            ->first(['tecnico_lat', 'tecnico_lng', 'tecnico_last_seen', 'estado']);

        if (!$row) {
            return;
        }

        $this->lat           = $row->tecnico_lat;
        $this->lng           = $row->tecnico_lng;
        $this->enProceso     = $row->estado === 'en_proceso';
        $this->lastSeenLabel = $row->tecnico_last_seen?->diffForHumans();
        $this->secondsAgo    = $row->tecnico_last_seen
            ? (int) round($row->tecnico_last_seen->diffInSeconds(now()))
            : null;
    }

    public function render()
    {
        return view('livewire.admin.work-orders.tecnico-map');
    }
}
