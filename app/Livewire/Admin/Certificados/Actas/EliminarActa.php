<?php

namespace App\Livewire\Admin\Certificados\Actas;

use App\Models\Actas;
use Livewire\Attributes\On;
use Livewire\Component;

class EliminarActa extends Component
{
    public Actas $acta;
    public $mostrarModal = false;

    #[On('EliminarActa')]
    public function abrirModal(Actas $acta)
    {
        $this->mostrarModal = true;
        $this->acta = $acta;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        $this->acta->delete();
        $this->afterDelete();
    }

    public function afterDelete()
    {
        $this->cerrarModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'ACTA ELIMINADA',
            mensaje: 'se elimino correctamente el acta'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.certificados.actas.eliminar-acta');
    }
}
