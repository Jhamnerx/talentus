<?php

namespace App\Http\Livewire\Admin\Vehiculos\Reportes;

use Livewire\Component;

class Edit extends Component
{

    public $openModalEdit = false;

    protected $listeners = [
        'editarReporte' => 'openModal'
    ];


    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.edit');
    }

    public function openModal()
    {
        $this->openModalEdit = true;
    }
}
