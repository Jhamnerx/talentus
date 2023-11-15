<?php

namespace App\Livewire\Admin\Certificados\Gps;

use App\Models\Certificados;
use Livewire\Component;

class Delete extends Component
{
    public Certificados $certificado;
    public $openModalDelete;

    protected $listeners = [
        'EliminarCertificado' => 'openModalDelete'
    ];

    public function delete()
    {
        $this->certificado->delete();
        $this->dispatch('certificado-delete');
        $this->dispatch('updateTable');
    }
    public function openModalDelete(Certificados $certificado)
    {
        $this->openModalDelete = true;
        $this->certificado = $certificado;
    }

    public function render()
    {
        return view('livewire.admin.certificados.gps.delete');
    }
}
