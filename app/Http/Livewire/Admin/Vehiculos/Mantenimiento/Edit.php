<?php

namespace App\Http\Livewire\Admin\Vehiculos\Mantenimiento;

use App\Models\Mantenimiento;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{

    public $modalOpen = false;
    public $numero, $detalle_trabajo, $fecha_hora_mantenimiento, $notify_admin = true, $notify_client = false, $nota, $estado, $vehiculo_id;

    public $placa;
    public $mantenimiento;

    protected $listeners = [
        'openModalEditMantenimiento'
    ];
    protected function rules()
    {

        return  [
            'numero' =>
            [
                'required',

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
        return view('livewire.admin.vehiculos.mantenimiento.edit');
    }


    public function openModalEditMantenimiento(Mantenimiento $mantenimiento)
    {
        $this->openModal();
        $this->numero = $mantenimiento->numero;
        $this->mantenimiento = $mantenimiento;
        $this->detalle_trabajo = $mantenimiento->detalle_trabajo;
        $this->fecha_hora_mantenimiento = $mantenimiento->fecha_hora_mantenimiento->format('Y-m-d ');
        $this->notify_admin = $mantenimiento->notify_admin;
        $this->notify_client = $mantenimiento->notify_client;
        $this->nota = $mantenimiento->nota;
        $this->vehiculo_id = $mantenimiento->vehiculo_id;

        $this->dispatchBrowserEvent('set-vehiculo', ['vehiculo' => $mantenimiento->vehiculo]);
    }

    public function openModal()
    {
        $this->modalOpen = true;
    }
    public function closeModal()
    {
        $this->modalOpen = false;
    }
    public function guardar()
    {
        $values = $this->validate();
        $mantenimiento = Mantenimiento::findOrFail($this->mantenimiento->id);
        $mantenimiento->update($values);

        $this->closeModal();
        $this->dispatchBrowserEvent('mantenimiento-update');
        $this->emit('update-mantenimiento');
    }
}
