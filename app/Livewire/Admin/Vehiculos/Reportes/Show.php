<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Reportes;
use Livewire\Component;

class Show extends Component
{


    public Reportes $reporte;


    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.show');
    }

    public function openModalShow(Reportes $reporte)
    {
        $this->dispatch('verDetalleReporte', $reporte);
    }
}
