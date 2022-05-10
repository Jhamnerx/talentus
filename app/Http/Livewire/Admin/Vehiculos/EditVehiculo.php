<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Models\Flotas;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class EditVehiculo extends Component
{
    public $data;

    public Model $vehiculo;

    public $modalEditOpen = false;

    public function mount()
    {
    }


    public function openModal()
    {

        $this->modalEditOpen = true;
    }
    public function closeModal()
    {

        $this->modalEditOpen = false;
    }

    public function save()
    {
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.edit-vehiculo');
    }
}
