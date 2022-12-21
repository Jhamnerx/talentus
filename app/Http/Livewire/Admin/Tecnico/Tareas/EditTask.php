<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Livewire\Component;
use App\Models\Productos;
use App\Models\tipoTareas;

class EditTask extends Component
{

    public $modalEdit = false;

    protected $listeners = [
        'openModalEdit' => 'openModal',
    ];

    public $titulo = '';
    public $ErrorMsgVehiculo;

    public $tipo_tarea_id = 0, $vehiculos_id, $cliente_id, $dispositivo, $numero, $nuevo_numero, $sim_card, $nuevo_sim_card, $fecha_hora, $modelo_velocimetro = 0;

    public Tareas $task;
    protected function rules()
    {
        return [
            'tipo_tarea_id' => 'required|gt:0',
            'vehiculos_id' => 'required',
            'cliente_id' => 'required',
            'dispositivo' => 'exclude_if:tipo_tarea_id,2|exclude_if:tipo_tarea_id,4|required',
            'numero' => 'exclude_if:tipo_tarea_id,4|required',
            'nuevo_numero' => 'required_if:tipo_tarea_id,2',
            'sim_card' => 'exclude_if:tipo_tarea_id,4|required',
            'nuevo_sim_card' => 'required_if:tipo_tarea_id,2',
            'modelo_velocimetro' => 'required_if:tipo_tarea_id,4',
            'fecha_hora' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'tipo_tarea_id.required' => 'Selecciona un tarea',
            'tipo_tarea_id.gt' => 'Selecciona una tarea valida',
            'vehiculos_id.required' => 'Selecciona un vehículo',
            'cliente_id.required' => 'Selecciona un vehículo que tenga asignado a un cliente',
            'dispositivo.required' => 'Selecciona un dispositivo',
            'numero.required' => 'Ingresa un número de linea',
            'sim_card.required' => 'Ingresa un sim card',
            'nuevo_numero.required_if' => 'Ingresa un nuevo número de linea',
            'nuevo_sim_card.required_if' => 'Ingresa un nuevo número de linea',
            'fecha_hora.required' => 'Ingresa la fecha y hora',
            'modelo_velocimetro.required_if' => 'Seleccione un modelo',
        ];
    }
    public function mount()
    {
    }

    public function render()
    {
        $tipo_tareas = tipoTareas::pluck('nombre', 'id');

        $velocimetros = Productos::velocimetro()->get();
        return view('livewire.admin.tecnico.tareas.edit-task', compact('tipo_tareas', 'velocimetros'));
    }

    public function openModal(Tareas $task)
    {
        $this->task = $task;
        $this->vehiculos_id = $task->vehiculos_id;
        $this->cliente_id = $task->cliente_id;
        $this->placa = $task->vehiculo->placa;
        $this->tipo_tarea_id = $task->tipo_tarea_id;
        $this->dispositivo = $task->dispositivo;
        $this->modelo_velocimetro = $task->modelo_velocimetro;
        $this->numero = $task->numero;
        $this->sim_card = $task->sim_card;
        $this->nuevo_numero = $task->nuevo_numero;
        $this->nuevo_sim_card = $task->nuevo_sim_card;
        $this->fecha_hora = $task->fecha_hora->format('Y-m-d h:i');
        $this->modalEdit = true;

        $this->dispatchBrowserEvent('put-items', ['dispositivo' => $task->dispositivo]);
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
        $this->task->update($data);
        $this->dispatchBrowserEvent('edit-task', ['tarea' => $this->task]);
        $this->closeModal();
        $this->emit('updateIndex');
    }
}
