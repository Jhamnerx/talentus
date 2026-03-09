<?php

namespace App\Livewire\Admin\Certificados\Gps;

use App\Models\Certificados;
use Livewire\Attributes\On;
use Livewire\Component;

class EliminarCertificadoGps extends Component
{
    public Certificados $certificado;
    public $mostrarModal = false;

    #[On('EliminarCertificado')]
    public function abrirModal(Certificados $certificado)
    {
        $this->mostrarModal = true;
        $this->certificado = $certificado;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        $this->certificado->delete();
        $this->afterDelete();
    }

    public function afterDelete()
    {
        $this->cerrarModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'CERTIFICADO ELIMINADO',
            mensaje: 'se elimino correctamente el certificado'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.certificados.gps.eliminar-certificado-gps');
    }
}
