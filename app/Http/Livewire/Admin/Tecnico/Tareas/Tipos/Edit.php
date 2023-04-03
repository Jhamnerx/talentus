<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas\Tipos;

use App\Models\tipoTareas;
use Livewire\Component;

class Edit extends Component
{

    public $modalEdit = false;
    public $nombre, $costo = 0;


    public tipoTareas $tipo_tarea;
    protected $listeners = [
        'openModalEditTipoTask' => 'openModal',
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
        return view('livewire.admin.tecnico.tareas.tipos.edit');
    }


    public function openModal(tipoTareas $tipo_tarea)
    {

        $this->nombre = $tipo_tarea->nombre;
        $this->costo = $tipo_tarea->costo;
        $this->tipo_tarea = $tipo_tarea;
        $this->modalEdit = true;
    }
    public function closeModal()
    {

        $this->modalEdit = false;
    }

    public function updated($name, $value)
    {
        $this->validateOnly($name, $this->rules(), $this->messages());
    }

    public function save()
    {
        $data = $this->validate();
        $this->tipo_tarea->update($data);
        $this->closeModal();
        $this->emit('updateIndex');
    }
}
