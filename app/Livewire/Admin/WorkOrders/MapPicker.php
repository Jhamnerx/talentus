<?php

declare(strict_types=1);

namespace App\Livewire\Admin\WorkOrders;

use App\Models\WorkOrder;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class MapPicker extends Component
{
    public int $workOrderId;
    public bool $open = false;

    public float|null $lat = null;
    public float|null $lng = null;
    public string $direccion = '';

    public function mount(int $workOrderId): void
    {
        $this->workOrderId = $workOrderId;

        $wo = WorkOrder::findOrFail($workOrderId);
        $this->lat       = $wo->ubicacion_lat;
        $this->lng       = $wo->ubicacion_lng;
        $this->direccion = $wo->ubicacion_direccion ?? '';
    }

    public function openModal(): void
    {
        $this->open = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    /**
     * Called from the blade via Alpine.js $wire.seleccionarUbicacion(lat, lng, direccion)
     */
    public function seleccionarUbicacion(float $lat, float $lng, string $direccion = ''): void
    {
        $this->lat       = $lat;
        $this->lng       = $lng;
        $this->direccion = $direccion;
    }

    public function guardar(): void
    {
        $wo = WorkOrder::findOrFail($this->workOrderId);
        Gate::authorize('update', $wo);

        $this->validate([
            'lat'       => ['required', 'numeric', 'between:-90,90'],
            'lng'       => ['required', 'numeric', 'between:-180,180'],
            'direccion' => ['nullable', 'string', 'max:500'],
        ]);

        $wo->update([
            'ubicacion_lat'       => $this->lat,
            'ubicacion_lng'       => $this->lng,
            'ubicacion_direccion' => $this->direccion ?: null,
        ]);

        $this->open = false;
        $this->dispatch('notify', type: 'success', message: 'Ubicación guardada correctamente.');
        $this->dispatch('ubicacion-actualizada', workOrderId: $this->workOrderId);
    }

    public function limpiar(): void
    {
        $wo = WorkOrder::findOrFail($this->workOrderId);
        Gate::authorize('update', $wo);

        $wo->update([
            'ubicacion_lat'       => null,
            'ubicacion_lng'       => null,
            'ubicacion_direccion' => null,
        ]);

        $this->lat       = null;
        $this->lng       = null;
        $this->direccion = '';

        $this->dispatch('notify', type: 'success', message: 'Ubicación eliminada.');
        $this->dispatch('ubicacion-actualizada', workOrderId: $this->workOrderId);
    }

    public function render()
    {
        return view('livewire.admin.work-orders.map-picker');
    }
}
