<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use App\Models\Productos;
use App\Models\tipoTareas;
use Livewire\Component;

class CreateTask extends Component
{

    public $modalSave = false;

    protected $listeners = [
        'addTask',
    ];

    public $titulo = '';
    public $tipo_tarea_id = 0, $vehiculos_id, $dispositivo, $numero, $nuevo_numero, $sim_card, $nuevo_sim_card, $fecha_hora, $modelo_velocimetro = 0;


    protected function rules()
    {
        return [
            'tipo_tarea_id' => 'required|gt:0',
            'vehiculos_id' => 'required',
            'dispositivo' => 'exclude_if:tipo_tarea_id,2|exclude_if:tipo_tarea_id,4|required',
            'numero' => 'exclude_if:tipo_tarea_id,4|required',
            'nuevo_numero' => 'required_if:tipo_tarea_id,2',
            'sim_card' => 'exclude_if:tipo_tarea_id,4|required',
            'nuevo_sim_card' => 'required_if:tipo_tarea_id,2',
        ];
    }

    protected function messages()
    {
        return [
            'tipo_tarea_id.required' => 'Selecciona un tarea',
            'tipo_tarea_id.gt' => 'Selecciona una tarea valida',
            'vehiculos_id.required' => 'Selecciona un vehículo',
            'dispositivo.required' => 'Selecciona un dispositivo',
            'numero.required' => 'Ingresa un número de linea',
            'sim_card.required' => 'Ingresa un sim card',
            'nuevo_numero.required_if' => 'Ingresa un nuevo número de linea',
            'nuevo_sim_card.required_if' => 'Ingresa un nuevo número de linea',
        ];
    }



    public function render()
    {
        $tipo_tareas = tipoTareas::pluck('nombre', 'id');

        $velocimetros = Productos::velocimetro()->get();

        return view('livewire.admin.tecnico.tareas.create-task', compact('tipo_tareas', 'velocimetros'));
    }

    public function addTask()
    {
        $this->modalSave = true;
    }

    public function updatedTipoTareaId($id)
    {
        $this->titulo = tipoTareas::find($id)->nombre;
        $this->dispatchBrowserEvent('change-tipo-tarea', ['value' => $id]);
    }
    public function updated($name, $value)
    {
        $this->validateOnly($name, $this->rules(), $this->messages());
    }

    public function save()
    {
        $this->validate();
    }
}
