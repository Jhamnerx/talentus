<?php

namespace App\Livewire\Admin\Ajustes\Ciudades;

use App\Http\Requests\CiudadesRequest;
use App\Models\Ciudades;
use Livewire\Component;

class Save extends Component
{
    public $openModalSave = false;

    public $nombre, $prefijo;

    protected $listeners = [
        'openModalSave' => 'openModal'
    ];


    public function openModal()
    {
        $this->openModalSave = true;
    }

    public function closeModal()
    {
        $this->openModalSave = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.ciudades.save');
    }

    public function updated($label)
    {
        $ciudadesRequest = new CiudadesRequest();
        $this->validateOnly($label, $ciudadesRequest->rules(), $ciudadesRequest->messages());
    }

    public function save(){

        $ciudadesRequest = new CiudadesRequest();
        $values = $this->validate($ciudadesRequest->rules(), $ciudadesRequest->messages());

        $ciudad = Ciudades::create($values);

        $this->dispatch('ciudad-save', ['ciudad' => $ciudad->nombre]);
        $this->dispatch('render');
        $this->reset();
        $this->resetErrorBag();
    }



}
