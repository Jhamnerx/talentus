<?php

namespace App\Livewire\Admin\Tecnico\Tareas;

use App\Models\Lineas;
use App\Models\Productos;
use App\Models\Tareas;
use App\Models\tipoTareas;
use App\Models\User;
use App\Models\Vehiculos;
use Carbon\Carbon;
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

    public $tipo_tarea_id = 0, $vehiculos_id, $cliente_id, $dispositivo,
        $dispositivo_id, $numero, $nuevo_numero, $sim_card,
        $nuevo_sim_card, $fecha_hora, $modelo_velocimetro = 0, $tecnico_id;


    public function resetProp()
    {

        $this->tipo_tarea_id = 0;
        $this->vehiculos_id = null;
        $this->cliente_id = null;
        $this->dispositivo = null;
        $this->dispositivo_id = null;
        $this->numero = null;
        $this->nuevo_numero = null;
        $this->sim_card = null;
        $this->nuevo_sim_card = null;
        $this->fecha_hora = Carbon::now();
        $this->modelo_velocimetro = null;
        $this->tecnico_id = null;
    }
    protected function rules()
    {
        $rules =  [
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

        if (auth()->user()->hasRole('tecnico')) {
            $rules['tecnico_id'] = 'nullable';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'tipo_tarea_id.required' => 'Selecciona un tarea',
            'tipo_tarea_id.gt' => 'Selecciona una tarea valida',
            'vehiculos_id.required' => 'Selecciona un vehículo',
            'tecnico_id.required' => 'Selecciona un tecnico',
            'cliente_id.required' => 'Selecciona un vehículo que tenga asignado a un cliente (Pedir a administración)',
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

        $this->fecha_hora = Carbon::now();
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
        if ($id) {
            $this->titulo = tipoTareas::find($id)->nombre;
        }
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

    public function updatedNumero($numero)
    {

        if ($numero) {

            $linea = Lineas::where('numero', $numero)->first();
            $this->sim_card = $linea->sim_card ? $linea->sim_card->sim_card : null;
        }
    }
    public function updatedNuevoNumero($numero)
    {

        if ($numero) {

            $linea = Lineas::where('numero', $numero)->first();
            $this->nuevo_sim_card = $linea->sim_card ? $linea->sim_card->sim_card : null;
        }
    }

    public function updated($name, $value)
    {
        $this->validateOnly($name, $this->rules(), $this->messages());
    }

    public function save()
    {

        $data = $this->validate();

        if (auth()->user()->hasRole('tecnico')) {
            $data['tecnico_id'] = auth()->user()->id;
        }

        try {
            $tarea = Tareas::create($data);

            if ($tarea) {

                $tarea->informe()->create([
                    'message' => '',
                    'user_id' => Auth::user()->id,
                ]);
            }
            $this->afterSave($tarea->token);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL GUARDAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }

    public function afterSave($numero)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'TAREA REGISTRADA',
            mensaje: 'Se registro correctamente la tarea #' . $numero,
        );
        $this->closeModal();
        $this->resetProp();
        $this->dispatch('update-table-save-task');
    }
}
