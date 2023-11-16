<?php

namespace App\Livewire\Admin\Vehiculos\Mantenimiento;

use App\Models\Mantenimiento;
use Livewire\Component;

class Delete extends Component
{
    public Mantenimiento $mantenimiento;
    public $openModalDelete;

    protected $listeners = [
        'EliminarMantenimiento' => 'openModalDelete'
    ];

    public function render()
    {
        return view('livewire.admin.vehiculos.mantenimiento.delete');
    }


    public function delete()
    {
        $this->mantenimiento->delete();
        $this->dispatch('mantenimiento-delete');
        $this->dispatch('update-mantenimiento');
    }

    public function openModalDelete(Mantenimiento $mantenimiento)
    {
        $this->openModalDelete = true;
        $this->mantenimiento = $mantenimiento;
    }
}