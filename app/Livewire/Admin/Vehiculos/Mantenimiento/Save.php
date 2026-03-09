<?php

namespace App\Livewire\Admin\Vehiculos\Mantenimiento;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Vehiculos;
use App\Models\Mantenimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class Save extends Component
{

    public $modalOpen = false;


    public $detalle_trabajo, $fecha_hora_mantenimiento, $notify_admin = true, $notify_client = false, $nota, $estado, $vehiculo_id;

    protected function rules()
    {
        return [
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
        $this->fecha_hora_mantenimiento = Carbon::now()->addYear()->format('Y-m-d');

        if ($vehiculo) {
            $this->vehiculo_id = $vehiculo->id;
        }
        $this->openModal();
    }


    private function generarNumeroSeguro(): string
    {
        $anio = now()->year;
        $prefijo = "MT{$anio}-";
        $pos = strlen($prefijo) + 1;

        $ultimo = Mantenimiento::where('numero', 'like', $prefijo . '%')
            ->lockForUpdate()
            ->orderByRaw("CAST(SUBSTRING(numero, {$pos}) AS UNSIGNED) DESC")
            ->value('numero');

        $siguiente = $ultimo
            ? (int) substr($ultimo, strlen($prefijo)) + 1
            : 1;

        return $prefijo . str_pad($siguiente, 4, '0', STR_PAD_LEFT);
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

        $mantenimiento = DB::transaction(function () use ($values) {
            $values['numero'] = $this->generarNumeroSeguro();
            return Mantenimiento::create($values);
        });

        $this->afterSave($mantenimiento->vehiculo->placa);
    }

    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'MANTENIMIENTO REGISTRADO',
            mensaje: 'Se registro correctamente el mantenimiento para ' . $placa,
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
        $this->fecha_hora_mantenimiento = Carbon::now()->addYear()->format('Y-m-d');
        $this->vehiculo_id = Vehiculos::where('placa', $placa)->first()->id;
        $this->openModal();
    }
}
