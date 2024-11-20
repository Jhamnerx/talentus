<?php

namespace App\Livewire\Admin\Vehiculos\Mantenimiento;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Vehiculos;
use App\Models\Mantenimiento;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\MantenimientoController;
use Livewire\Attributes\On;

class Save extends Component
{

    public $modalOpen = false;


    public $numero, $detalle_trabajo, $fecha_hora_mantenimiento, $notify_admin = true, $notify_client = false, $nota, $estado, $vehiculo_id;
    public $updates;

    protected function rules()
    {

        return  [
            'numero' =>
            [
                'required',
                Rule::unique('mantenimientos', 'numero')
                    ->where(fn($query) => $query->where('empresa_id', session('empresa'))),
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

    #[On('open-modal-save-mantenimiento')]
    public function openModalSaveMantenimiento($from, Vehiculos $vehiculo = null)
    {

        $this->numero =  $this->getNextSequenceNumber();
        $this->fecha_hora_mantenimiento = Carbon::now()->addYear()->format('Y-m-d');

        if ($vehiculo) {
            $this->vehiculo_id = $vehiculo->id;
        }
        $this->openModal();;
    }


    public function getNextSequenceNumber()
    {
        $maxNumero = Mantenimiento::max('numero');
        return $maxNumero ? $maxNumero + 1 : 1;
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
        $this->afterSave($mantenimiento->vehiculo->placa);
    }

    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'MANTENIMIENTO REGISTRADO',
            mensaje: 'Se registro correctamente el mantenimiento para' . $placa,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }


    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
    }

    #[On(['open-modal-mantenimiento'])]
    public function listenUpdatedNumero($placa)
    {
        $this->numero =  $this->getNextSequenceNumber();
        $this->fecha_hora_mantenimiento = Carbon::now()->addYear()->format('Y-m-d');
        $this->vehiculo_id = Vehiculos::where('placa', $placa)->first()->id;
        $this->openModal();
    }
}
