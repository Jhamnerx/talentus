<?php

namespace App\Livewire\Admin\Gerencia\Reportes;

use Livewire\Component;

class Cards extends Component
{
    public function render()
    {
        return view('livewire.admin.gerencia.reportes.cards');
    }

    public function openModalReporteProductos()
    {
        $this->dispatch('openModalReporteProductos');
    }
    public function openModalReporteLineas()
    {
        $this->dispatch('openModalReporteLineas');
    }
    public function openModalReporteClientes()
    {
        $this->dispatch('openModalReporteClientes');
    }
    public function openModalReporteVehiculos()
    {
        $this->dispatch('openModalReporteVehiculos');
    }
}
