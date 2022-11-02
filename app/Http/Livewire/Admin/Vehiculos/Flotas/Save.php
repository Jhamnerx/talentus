<?php

namespace App\Http\Livewire\Admin\Vehiculos\Flotas;

use App\Models\Flotas;
use Livewire\Component;

class Save extends Component
{

    public $nombre;
    public $nombre_cliente, $descripcion;
    public $clientes_id;
    public $modalOpen = false;

    protected $listeners = ['ChangeCliente'];

    protected $rules = [
        'nombre' => 'required|unique:flotas,nombre',
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

    public function openModal()
    {

        $this->modalOpen = true;
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

        $validatedDate = $this->validate();
        Flotas::create([
            'nombre' => $this->nombre,
            'clientes_id' => $this->clientes_id,
        ]);


        $this->resetInputFields();
        $this->modalOpen = false;
        $this->emit('render');
        return redirect()->route('admin.vehiculos.flotas.index')->with('store', 'Se guardo con exito');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function updatingArray($value, $key)
    {
    }
}
