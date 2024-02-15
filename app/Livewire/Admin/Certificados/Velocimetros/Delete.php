<?php

namespace App\Livewire\Admin\Certificados\Velocimetros;

use App\Models\CertificadosVelocimetros;
use Livewire\Component;

class Delete extends Component
{
    public CertificadosVelocimetros $certificado;
    public $openModalDelete;

    protected $listeners = [
        'EliminarCertificado' => 'openModalDelete'
    ];

    public function delete()
    {
        $this->certificado->delete();
        $this->afterDelete();
    }
    public function openModalDelete(CertificadosVelocimetros $certificado)
    {
        $this->openModalDelete = true;
        $this->certificado = $certificado;
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
    public function closeModal()
    {

        $this->openModalDelete = false;
    }

    public function render()
    {
        return view('livewire.admin.certificados.velocimetros.delete');
    }
}
