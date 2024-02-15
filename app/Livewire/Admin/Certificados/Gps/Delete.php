<?php

namespace App\Livewire\Admin\Certificados\Gps;

use App\Models\Certificados;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public Certificados $certificado;
    public $openModalDelete = false;

    public function delete()
    {
        $this->certificado->delete();
        $this->afterDelete();
    }
    #[On('EliminarCertificado')]
    public function openModalDelete(Certificados $certificado)
    {
        $this->openModalDelete = true;
        $this->certificado = $certificado;
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
            tittle: 'CERTIFICADO ELIMINADO',
            mensaje: 'se elimino correctamente el certificado'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.certificados.gps.delete');
    }
}
