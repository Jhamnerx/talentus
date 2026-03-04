<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class ModalVerSuscripcion extends Component
{
    use WireUiActions;

    public bool $open = false;
    public ?Vehiculos $vehiculo = null;

    public function render()
    {
        return view('livewire.admin.vehiculos.modal-ver-suscripcion');
    }

    #[On('abrir-modal-suscripcion')]
    public function abrir(int $vehiculoId): void
    {
        $this->vehiculo = Vehiculos::with(['planSubscriptions.plan', 'cliente'])->find($vehiculoId);

        if (!$this->vehiculo) {
            $this->notification()->error('No encontrado', 'Vehículo no encontrado.');
            return;
        }

        $this->open = true;
    }

    public function cerrar(): void
    {
        $this->reset(['open', 'vehiculo']);
    }
}
