<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Reportes;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{

    public Reportes $reporte;

    public $openModalDelete = false;

    public function delete()
    {

        try {
            $this->reporte->delete();
            $this->afterDelete();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                tittle: 'ERROR AL ELIMINAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.delete');
    }

    public function afterDelete()
    {
        $this->closeModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            tittle: 'REPORTE ELIMINADO',
            mensaje: 'se elimino correctamente el reporte'
        );

        $this->dispatch('update-table');
    }

    #[On('EliminarReporte')]
    public function openModal(Reportes $reporte)
    {

        $this->reporte = $reporte;
        $this->openModalDelete = true;
    }

    public function closeModal()
    {
        $this->openModalDelete = false;
    }
}
