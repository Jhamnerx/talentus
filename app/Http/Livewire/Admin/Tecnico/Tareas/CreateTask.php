<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use App\Models\Lineas;
use App\Models\Productos;
use App\Models\Tareas;
use App\Models\tipoTareas;
use App\Models\User;
use App\Models\Vehiculos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateTask extends Component
{

    public $modalSave = false;

    protected $listeners = [
        'addTask',
    ];

    public $titulo = '';
    public $ErrorMsgVehiculo;

    public $tipo_tarea_id = 0, $vehiculos_id, $cliente_id, $dispositivo, $numero, $nuevo_numero, $sim_card, $nuevo_sim_card, $fecha_hora, $modelo_velocimetro = 0, $tecnico_id;

    protected function rules()
    {
        return [
            'tipo_tarea_id' => 'required|gt:0',
            'vehiculos_id' => 'required',
            'tecnico_id' => 'required',
            'cliente_id' => 'required',
            'dispositivo' => 'exclude_if:tipo_tarea_id,2|exclude_if:tipo_tarea_id,4|required',
            'numero' => 'exclude_if:tipo_tarea_id,4|exclude_if:tipo_tarea_id,5|required',
            'nuevo_numero' => 'required_if:tipo_tarea_id,2',
            'sim_card' => 'exclude_if:tipo_tarea_id,4|exclude_if:tipo_tarea_id,5|required',
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
            'tecnico_id.required' => 'Selecciona un tecnico',
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

    public function render()
    {
        $tipo_tareas = tipoTareas::pluck('nombre', 'id');

        $velocimetros = Productos::velocimetro()->get();

        $tecnicos = User::role('tecnico')->get();

        return view('livewire.admin.tecnico.tareas.create-task', compact('tipo_tareas', 'velocimetros', 'tecnicos'));
    }

    public function addTask()
    {
        $this->modalSave = true;
    }
    public function closeModal()
    {
        $this->modalSave = false;
    }
    public function updatedTipoTareaId($id)
    {
        $this->titulo = tipoTareas::find($id)->nombre;
        $this->dispatchBrowserEvent('change-tipo-tarea', ['value' => $id]);
    }
    public function updatedVehiculosId($value)
    {
        $vehiculo = vehiculos::findOrFail($value);
        if ($vehiculo->cliente) {

            $this->cliente_id = $vehiculo->cliente->id;
            $this->numero = $vehiculo->numero;
            $this->sim_card = $vehiculo->sim_card ? $vehiculo->sim_card->sim_card : '';
            $this->reset('ErrorMsgVehiculo');
        } else {
            $this->ErrorMsgVehiculo = "No se encuentra el cliente";
        };
    }

    // public function updatedNumero($value)
    // {
    //     $linea = Lineas::where('numero', $value)->first();

    //     dd($linea);
    // }

    public function updated($name, $value)
    {
        $this->validateOnly($name, $this->rules(), $this->messages());
    }

    public function save()
    {
        $data = $this->validate();
        $tarea = Tareas::create($data);
        if ($tarea) {

            $tarea->informe()->create([
                'message' => '',
                'user_id' => Auth::user()->id,
            ]);
        }
        $this->dispatchBrowserEvent('save-task', ['tarea' => $tarea]);
        $this->reset();
        $this->emit('updateIndex');
    }
}
