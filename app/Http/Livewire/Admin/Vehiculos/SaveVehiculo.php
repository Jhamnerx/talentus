<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Models\Flotas;
use Livewire\Component;

class SaveVehiculo extends Component
{
    public $data;

    public $modalOpen = false;

    public function mount()
    {
        $querys = Flotas::all();

        $flotas = [];
        //$data = [];


        foreach ($querys as $query) {

            $flotas[$query->id] = $query->nombre;
        }

        //$data['data'] = $flotas;



        $this->data = $flotas;
    }
    public function render()
    {


        return view('livewire.admin.vehiculos.save-vehiculo');
    }

    public function openModal()
    {

        $this->modalOpen = true;
    }
    public function closeModal()
    {

        $this->modalOpen = false;
    }

    public function save()
    {
    }
}
