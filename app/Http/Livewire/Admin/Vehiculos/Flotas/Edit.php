<?php

namespace App\Http\Livewire\Admin\Vehiculos\Flotas;

use App\Models\Flotas;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Edit extends Component
{
    public Model $model;
    public $nombre;
    public $nombre_cliente, $descripcion;
    public $empresa_id;
    public $clientes_id;
    public $modalOpenEdit = false;

    protected $listeners = ['ChangeCliente'];

    protected $rules = [

        'nombre' => [
            'required',
        ],

        'nombre_cliente' => 'required',
        'empresa_id' => 'required',
        'clientes_id' => 'required|exists:clientes,id',


    ];

    protected $messages = [
        'nombre.required' => 'El nombre es requerido',
        'nombre.unique' => 'Esta flota ya existe',
        'clientes_id.required' => 'El cliente es requerido',
        'clientes_id.exists' => 'El cliente debe estar registrado',

    ];




    public function mount()
    {
        $this->empresa_id = session('empresa');
        $this->nombre = $this->model->nombre;
        $this->empresa_id = $this->model->empresa_id;
        $this->clientes_id = $this->model->clientes_id;
        $this->descripcion = $this->model->descripcion;
        $this->nombre_cliente = $this->model->clientes->razon_social;
    }
    public function ChangeClienteEdit($id, $nombre)
    {
        $this->clientes_id = $id;
        $this->nombre_cliente = $nombre;
    }


    public function openModal()
    {

        $this->modalOpenEdit = true;
    }
    public function closeModal()
    {

        $this->modalOpenEdit = false;
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    private function resetInputFields()
    {
        $this->descripcion = '';
        $this->clientes_id = '';
        $this->nombre = '';
        $this->nombre_cliente = '';
    }

    public function save()
    {


        $validatedDate = $this->validate();
        // dd($this->clientes_id);


        Flotas::create([
            'nombre' => $this->nombre,
            'clientes_id' => $this->clientes_id,
            'empresa_id' => $this->empresa_id,
        ]);


        $this->resetInputFields();
        $this->modalOpenEdit = false;
        $this->emit('render');
        //  return redirect()->route('admin.vehiculos.flotas.index')->with('store', 'Se guardo con exito');

    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.flotas.edit');
    }
}
