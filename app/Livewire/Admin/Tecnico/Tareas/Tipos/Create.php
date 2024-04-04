<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Tipos;

use App\Models\User;
use Livewire\Component;
use App\Models\tipoTareas;

class Create extends Component
{

    public $modalSave = false;

    public $nombre, $costo = 0, $descripcion = "Instalación de GPS %modelo_gps% en vehículo: %placa%, Fecha instalación: %fecha% - Hora: %hora%";
    public $user_id = null;
    public $afecta_mantenimiento = false;

    protected $listeners = [
        'addTipoTask',
    ];

    protected function rules()
    {
        $rules = [
            'nombre' => 'required',
            'costo' => 'required',
            'descripcion' => 'required',
            'afecta_mantenimiento' => 'boolean',
            'user_id' => 'required',
        ];

        if (auth()->user()->hasRole('tecnico')) {
            $rules['user_id'] = 'nullable';
        }

        return $rules;
    }
    protected function messages()
    {
        return [
            'nombre.required' => 'Escribe una descripcion',
            'costo.required' => 'Ingresa un costo',
            'user_id.required' => 'Selecciona un tecnico',

        ];
    }

    public function render()
    {
        $tecnicos = User::role('tecnico')->get();

        return view('livewire.admin.tecnico.tareas.tipos.create', compact('tecnicos'));
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

        if (auth()->user()->hasRole('tecnico')) {
            $data['user_id'] = auth()->user()->id;
        }

        try {

            tipoTareas::create($data);
            $this->afterSave();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Mensaje: ' . $th->getMessage() . "."
            );
        }
    }

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'TIPO TAREA REGISTRADA',
            mensaje: 'Se registro correctamente el tipo de tarea ',
        );

        $this->closeModal();
        $this->resetProp();
        $this->dispatch('updateIndex');
    }

    public function resetProp()
    {
        $this->reset([
            'nombre',
            'costo',
            'descripcion',
            'user_id',
            'afecta_mantenimiento',
        ]);
    }
}
