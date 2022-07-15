<?php

namespace App\Http\Livewire\Admin\Ajustes\Ciudades;

use App\Http\Requests\CiudadesRequest;
use App\Models\Ciudades;
use Livewire\Component;

class Edit extends Component
{
    public $openModalEdit = false;

    public $nombre, $prefijo;
    public $ciudad;

    protected $listeners = [
        'openModalEdit' => 'openModal'
    ];


    public function openModal(Ciudades $ciudad)
    {
        $this->openModalEdit = true;
        $this->ciudad = $ciudad;
        $this->nombre = $ciudad->nombre;
        $this->prefijo = $ciudad->prefijo;

        //dd($ciudad);

    }

    public function closeModal()
    {
        $this->openModalEdit = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.ciudades.edit');
    }


    public function update()

    {
        $requestCiudades = new CiudadesRequest();
        $values = $this->validate($requestCiudades->rules($this->ciudad), $requestCiudades->messages());

        $update = Ciudades::find($this->ciudad->id);
        $update->nombre = $values["nombre"];
        $update->prefijo = $values["prefijo"];
        $update->save();

        $this->openModalEdit = false;
        $this->dispatchBrowserEvent('ciudades-edit', ['ciudad' => $this->ciudad->nombre]);
        $this->emit('render');
        $this->reset();
    }

    public function updated($label)
    {
        $requestCiudades = new CiudadesRequest();
        $this->validateOnly($label, $requestCiudades->rules($this->ciudad), $requestCiudades->messages());
        //dd($label);
    }
}
