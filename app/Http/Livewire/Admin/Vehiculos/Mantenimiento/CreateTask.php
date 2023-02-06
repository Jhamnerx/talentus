<?php

namespace App\Http\Livewire\Admin\Vehiculos\Mantenimiento;

use App\Models\User;
use Livewire\Component;
use App\Models\Mantenimiento;

class CreateTask extends Component
{
    public $modalCreateTask = false;

    public $tipo_tarea_id = 0, $vehiculos_id, $cliente_id, $dispositivo, $fecha_hora, $tecnico_id;
    public $placa;
    public Mantenimiento $mantenimiento;
    protected $listeners = [
        'openModalCreateTask'
    ];


    protected function rules()
    {
        return [
            'tipo_tarea_id' => 'required|gt:0',
            'vehiculos_id' => 'required',
            'tecnico_id' => 'required',
            'cliente_id' => 'required',
            'dispositivo' => 'required|exists:modelos_dispositivos,modelo',
            'fecha_hora' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'tipo_tarea_id.required' => 'Selecciona un tarea',
            'tipo_tarea_id.gt' => 'Selecciona una tarea valida',
            'vehiculos_id.required' => 'Selecciona un vehículo',
            'tecnico_id.required' => 'Selecciona un tecnico',
            'cliente_id.required' => 'Selecciona un vehículo que tenga asignado a un cliente',
            'dispositivo.required' => 'Selecciona un dispositivo',
            'dispositivo.exists' => 'Escribe un modelo registrado',
        ];
    }
    public function render()
    {
        $tecnicos = User::role('tecnico')->get();
        return view('livewire.admin.vehiculos.mantenimiento.create-task', compact('tecnicos'));
    }

    public function openModalCreateTask(Mantenimiento $mantenimiento)
    {
        $this->mantenimiento = $mantenimiento;
        $this->placa = $mantenimiento->vehiculo->placa;
        $this->cliente_id = $mantenimiento->vehiculo->cliente ? $mantenimiento->vehiculo->cliente->id : null;
        $this->tipo_tarea_id = 5;
        $this->vehiculos_id = $mantenimiento->vehiculo_id;
        $this->dispositivo = $mantenimiento->vehiculo->dispositivos ?  $mantenimiento->vehiculo->dispositivos->modelo->modelo : 'Actualiza el vehiculo o ingresa el modelo';
        $this->fecha_hora = $mantenimiento->fecha_hora_mantenimiento->format('Y-m-d H:i');
        $this->openModal();
        $this->dispatchBrowserEvent('openModal', ['fecha_hora' => $mantenimiento->fecha_hora_mantenimiento->format('Y-m-d H:i')]);
    }

    public function openModal()
    {
        $this->modalCreateTask = true;
    }

    public function closeModal()
    {
        $this->modalCreateTask = false;
    }


    public function updated($field)
    {

        $this->validateOnly($field);
    }

    public function save()
    {
        $data = $this->validate();

        $tarea = $this->mantenimiento->tareas()->create($data);

        $this->closeModal();
        $this->dispatchBrowserEvent('save-task', ['tarea' => $tarea]);
    }
}
