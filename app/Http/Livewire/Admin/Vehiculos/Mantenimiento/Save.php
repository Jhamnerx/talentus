<?php

namespace App\Http\Livewire\Admin\Vehiculos\Mantenimiento;

use App\Http\Controllers\Admin\MantenimientoController;
use App\Models\Mantenimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Save extends Component
{

    public $modalOpen = false;


    public $numero, $detalle_trabajo, $fecha_hora_mantenimiento, $notify_admin = true, $notify_client = false, $nota, $estado, $vehiculo_id;

    protected $listeners = [
        'openModalSaveMantenimiento',
    ];

    protected function rules()
    {

        return  [
            'numero' =>
            [
                'required',
                Rule::unique('mantenimientos', 'numero')
                    ->where(fn ($query) => $query->where('empresa_id', session('empresa'))),
            ],
            'detalle_trabajo' => 'nullable',
            'fecha_hora_mantenimiento' => 'date|required',
            'notify_admin' => 'boolean|required',
            'notify_client' => 'boolean|required',
            'nota' => 'nullable',
            'vehiculo_id' => 'required|exists:vehiculos,id',
        ];
    }

    protected function messages()
    {

        return [
            'numero.required' => 'El campo número es obligatorio',
            'numero.unique' => 'Número ya esta registrado',
            'vehiculo_id.required' => 'Selecciona un vehículo',
            'notify_admin.boolean' => 'Debe ser verdadero o false',
            'notify_client.boolean' => 'Debe ser verdadero o false',
        ];
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.mantenimiento.save');
    }

    public function openModalSaveMantenimiento()
    {
        $this->openModal();
        $ctr = new MantenimientoController();
        $this->numero =  $ctr->setNextSequenceNumber();
        $this->fecha_hora_mantenimiento = Carbon::now()->addYear()->format('Y-m-d');
    }


    public function openModal()
    {

        $this->modalOpen = true;
    }
    public function updatedNotifyAdmin($value)
    {
        $value == "1" ?  $this->notify_admin = true : $this->notify_admin = false;
    }
    public function updatedNotifyClient($value)
    {
        $value == "1" ?  $this->notify_client = true : $this->notify_client = false;
    }

    public function guardar()
    {
        $values = $this->validate();

        $mantenimiento = Mantenimiento::create($values);
        $this->closeModal();
        $this->dispatchBrowserEvent('mantenimiento-save');
    }
    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
    }
}
