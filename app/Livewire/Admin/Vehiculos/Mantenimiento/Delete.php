<?php

namespace App\Livewire\Admin\Vehiculos\Mantenimiento;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Mantenimiento;

class Delete extends Component
{
    public Mantenimiento $mantenimiento;
    public $openModalDelete = false;


    public function render()
    {
        return view('livewire.admin.vehiculos.mantenimiento.delete');
    }


    public function delete()
    {
        $this->mantenimiento->delete();
        $this->afterDelete();
    }

    public function closeModal()
    {

        $this->openModalDelete = false;
    }
    public function afterDelete()
    {
        $this->closeModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            tittle: 'REGISTRO MANTENIMIENTO ELIMINADO',
            mensaje: 'se elimino correctamente el registro'
        );
        $this->dispatch('update-table');
    }
    #[On('EliminarMantenimiento')]
    public function openModalDelete(Mantenimiento $mantenimiento)
    {
        $this->openModalDelete = true;
        $this->mantenimiento = $mantenimiento;
    }
}
