<?php

namespace App\Livewire\Admin\Certificados\Actas;

use App\Models\Actas;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public Actas $acta;
    public $openModalDelete;

    public function delete()
    {
        $this->acta->delete();
        $this->afterDelete();
    }

    #[On('EliminarActa')]
    public function openModalDelete(Actas $acta)
    {
        $this->openModalDelete = true;
        $this->acta = $acta;
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
            tittle: 'ACTA ELIMINADA',
            mensaje: 'se elimino correctamente el acta'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.certificados.actas.delete');
    }
}
