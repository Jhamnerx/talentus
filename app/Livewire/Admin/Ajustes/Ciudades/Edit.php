<?php

namespace App\Livewire\Admin\Ajustes\Ciudades;

use App\Http\Requests\CiudadesRequest;
use App\Models\Ciudades;
use Livewire\Component;

class Edit extends Component
{
    public $openModalEdit = false;

    public $nombre, $prefijo;
    public Ciudades $ciudad;

    protected $listeners = [
        'openModalEdit' => 'openModal'
    ];


    public function openModal(Ciudades $ciudad)
    {
        $this->openModalEdit = true;
        $this->ciudad = $ciudad;
        $this->nombre = $ciudad->nombre;
        $this->prefijo = $ciudad->prefijo;
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

        try {

            $this->updateCiudad($values);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Ocurrio un error al actualizar la ciudad',
            );
        }

        $this->afterSave($this->ciudad->nombre);
    }

    public function updateCiudad($values)
    {
        $this->ciudad->update($values);
    }

    public function afterSave($name)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'CIUDAD ACTUALIZADA',
            mensaje: 'Se actualizo la ciudad: ' . $name,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }

    public function updated($label)
    {
        $requestCiudades = new CiudadesRequest();
        $this->validateOnly($label, $requestCiudades->rules($this->ciudad), $requestCiudades->messages());
        //dd($label);
    }
}
