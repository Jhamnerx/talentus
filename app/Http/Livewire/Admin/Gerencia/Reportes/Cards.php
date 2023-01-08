<?php

namespace App\Http\Livewire\Admin\Gerencia\Reportes;

use Livewire\Component;

class Cards extends Component
{
    public function render()
    {
        return view('livewire.admin.gerencia.reportes.cards');
    }

    public function openModalReporteProductos()
    {
        $this->emit('openModalReporteProductos');
    }
    public function openModalReporteLineas()
    {
        $this->emit('openModalReporteLineas');
    }
    public function openModalReporteClientes()
    {
        $this->emit('openModalReporteClientes');
    }
    public function openModalReporteVehiculos()
    {
        $this->emit('openModalReporteVehiculos');
    }
}
