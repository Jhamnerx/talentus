<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Tipos;

use App\Models\tipoTareas;
use Livewire\Component;

class Edit extends Component
{

    public $modalEdit = false;
    public $nombre, $costo = 0, $descripcion = "";
    public $afecta_mantenimiento = false;

    public tipoTareas $tipo_tarea;
    protected $listeners = [
        'openModalEditTipoTask' => 'openModal',
    ];

    protected function rules()
    {
        return [
            'nombre' => 'required',
            'costo' => 'required',
            'descripcion' => 'required',
            'afecta_mantenimiento' => 'boolean',
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
        $this->descripcion = $tipo_tarea->descripcion;
        $this->afecta_mantenimiento = $tipo_tarea->afecta_mantenimiento;
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
        try {
            $this->tipo_tarea->update($data);
            $this->closeModal();
            $this->dispatch('updateIndex');
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Mensaje: ' . $th->getMessage() . "."
            );
        }
    }
}
