<?php

namespace App\Http\Livewire\Admin\Certificados\Velocimetros;

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
        $this->dispatchBrowserEvent('certificado-delete');
        $this->emit('updateTable');
    }
    public function openModalDelete(CertificadosVelocimetros $certificado)
    {
        $this->openModalDelete = true;
        $this->certificado = $certificado;
    }
    public function render()
    {
        return view('livewire.admin.certificados.velocimetros.delete');
    }
}
