<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Reportes;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{

    public Reportes $reporte;

    public $openModalDelete = false;
    public $field = "eliminado";

    public $eliminado;
    protected $listeners = [
        'EliminarReporte' => 'openModal'
    ];


    public function delete()
    {
        $this->reporte->setAttribute($this->field, '1')->save();
        $this->reporte->delete();
        // return redirect()->route('admin.vehiculos.index');
        $this->dispatch('reporte-delete', ['vehiculo' => $this->reporte->vehiculos->placa]);

        $this->dispatch('updateTable');
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.delete');
    }

    public function openModal(Reportes $reportes)
    {
        $this->openModalDelete = true;
        $this->reporte = $reportes;
    }
}
