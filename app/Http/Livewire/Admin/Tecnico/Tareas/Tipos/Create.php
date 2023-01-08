<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas\Tipos;

use App\Models\tipoTareas;
use Livewire\Component;

class Create extends Component
{

    public $modalSave = false;

    public $nombre, $costo = 0;

    protected $listeners = [
        'addTipoTask',
    ];

    protected function rules()
    {
        return [
            'nombre' => 'required',
            'costo' => 'required',
        ];
    }
    protected function messages()
    {
        return [
            'nombre.required' => 'Escribe una descripcion',
            'costo.required' => 'Ingresa un costo',

        ];
    }

    public function render()
    {
        return view('livewire.admin.tecnico.tareas.tipos.create');
    }

    public function addTipoTask()
    {
        $this->modalSave = true;
    }
    public function closeModal()
    {
        $this->modalSave = false;
    }

    public function updated($name, $value)
    {
        $this->validateOnly($name, $this->rules(), $this->messages());
    }

    public function save()
    {
        $data = $this->validate();
        $tarea = tipoTareas::create($data);
        $this->reset();
        $this->emit('updateIndex');
    }
}
