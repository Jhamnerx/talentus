<?php

namespace App\Livewire\Admin\Vehiculos\Flotas;

use App\Models\Flotas;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public Flotas $flota;

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
        return view('livewire.admin.vehiculos.flotas.edit');
    }

    #[On('open-modal-edit')]
    public function openModal(Flotas $flota)
    {
        $this->modalOpen = true;
        $this->flota = $flota;
        $this->nombre = $flota->nombre;
        $this->clientes_id = $flota->clientes_id;
        $this->descripcion = $flota->descripcion;
    }

    public function closeModal()
    {

        $this->modalOpen = false;
    }

    private function resetInputFields()
    {
        $this->descripcion = '';
        $this->clientes_id = '';
        $this->nombre = '';
    }

    public function save()
    {

        $validatedData = $this->validate();

        $this->flota->update($validatedData);

        $this->afterSave($this->flota);
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
            tittle: 'FLOTA ACTUALIZADA',
            mensaje: 'La Flota ' . $flota->nombre . ' fue actualizada correctamente'
        );
        $this->dispatch('update-table');
        $this->resetInputFields();
    }
}
