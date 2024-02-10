<?php

namespace App\Livewire\Admin\Vehiculos\Flotas;

use App\Models\Flotas;
use Livewire\Attributes\On;
use Livewire\Component;

class Save extends Component
{

    public $nombre, $descripcion, $clientes_id;

    public $modalOpen = false;

    protected $listeners = ['ChangeCliente'];

    protected $rules = [
        'nombre' => 'required',
        'descripcion' => 'nullable',
        'clientes_id' => 'required|exists:clientes,id',
    ];

    protected $messages = [

        'nombre.required' => 'El nombre es requerido',
        'nombre.unique' => 'Esta flota ya existe',
        'clientes_id.required' => 'El cliente es requerido',
        'clientes_id.exists' => 'El cliente debe estar registrado',

    ];

    public function render()
    {
        return view('livewire.admin.vehiculos.flotas.save');
    }

    #[On('open-modal-save')]
    public function openModal()
    {

        $this->modalOpen = true;
    }


    private function resetInputFields()
    {
        $this->descripcion = '';
        $this->clientes_id = '';
        $this->nombre = '';
        $this->descripcion = '';
    }

    public function save()
    {

        $validatedDate = $this->validate();

        $flota = Flotas::create([
            'nombre' => $validatedDate['nombre'],
            'clientes_id' => $validatedDate['clientes_id'],
            'descripcion' => $validatedDate['descripcion'],
        ]);




        $this->afterSave($flota);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function afterSave($flota)
    {
        $this->closeModal();
        $this->dispatch(
            'notify',
            icon: 'success',
            tittle: 'FLOTA REGISTRADA',
            mensaje: 'La Flota ' . $flota->nombre . ' fue guardada correctamente'
        );
        $this->dispatch('update-table');
        $this->resetInputFields();
    }

    public function closeModal()
    {

        $this->modalOpen = false;
    }
}
