<?php

namespace App\Livewire\Admin\Certificados\Antifatiga;

use App\Models\CertificadosAntifatiga;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public CertificadosAntifatiga $certificado;
    public $openModalDelete = false;

    public function delete()
    {
        $this->certificado->delete();
        $this->afterDelete();
    }

    #[On('EliminarAntifatiga')]
    public function openModalDelete(CertificadosAntifatiga $certificado)
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
            title: 'CERTIFICADO ELIMINADO',
            mensaje: 'Se eliminó correctamente el certificado de antifatiga.'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.certificados.antifatiga.delete');
    }
}
