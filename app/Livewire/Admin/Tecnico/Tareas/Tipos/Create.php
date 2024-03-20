<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Tipos;

use App\Models\tipoTareas;
use Livewire\Component;

class Create extends Component
{

    public $modalSave = false;

    public $nombre, $costo = 0, $descripcion = "Instalación de GPS %modelo_gps% en vehículo: %placa%, Fecha instalación: %fecha% - Hora: %hora%";

    public $afecta_mantenimiento = false;

    protected $listeners = [
        'addTipoTask',
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
        try {

            tipoTareas::create($data);
            $this->reset();
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
