<?php

namespace App\Http\Livewire\Admin\Ventas\Contratos;

use App\Models\Clientes;
use Carbon\Carbon;
use Livewire\Component;

class Save extends Component
{
    public $clientes_id, $ciudades_id, $fondo, $sello;
    public  $fecha;
    public $panelVehiculosOpen = false;

    public function mount()
    {
        $this->fecha = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.save');
    }


    public function openPanelVehiculos()
    {
        $this->panelVehiculosOpen = true;
    }

    public function updatedClientesId($cliente)
    {

        $this->emit('openPanelVehiculos', $cliente);
    }
}
