<?php

namespace App\Http\Livewire\Admin\Certificados\Actas;

use App\Models\Actas;
use Livewire\Component;

class Delete extends Component
{
    public Actas $acta;
    public $openModalDelete;

    protected $listeners = [
        'EliminarActa' => 'openModalDelete'
    ];

    public function delete()
    {
        $this->acta->delete();
        $this->dispatchBrowserEvent('acta-delete');
        $this->emit('updateTable');
    }
    public function openModalDelete(Actas $acta)
    {
        $this->openModalDelete = true;
        $this->acta = $acta;
    }
    public function render()
    {
        return view('livewire.admin.certificados.actas.delete');
    }
}
