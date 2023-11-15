<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use Livewire\Component;

class Delete extends Component
{
    public Cobros $cobro;
    public $openModalDelete = false;

    protected $listeners = [
        'openModalDelete'
    ];

    public function delete()
    {

        $this->cobro->delete();
        $this->dispatch('cobro-delete');
        $this->dispatch('render');
    }

    public function openModalDelete(Cobros $cobro)
    {

        $this->openModalDelete = true;
        $this->cobro = $cobro;
    }

    public function render()
    {
        return view('livewire.admin.cobros.delete');
    }
}
