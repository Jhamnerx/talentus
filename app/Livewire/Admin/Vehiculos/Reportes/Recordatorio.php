<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Reportes;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Recordatorio extends Component
{
    public $openModalRecordatorio = false;

    public $fecha_recordatorio;
    public $nota;
    public $reporte = null;

    protected $rules = [
        'fecha_recordatorio' => 'required',


    ];

    protected $messages = [

        'fecha_recordatorio.required' => 'Debes Ingresar una fecha',

    ];

    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.recordatorio');
    }


    #[On('crearRecordatorio')]
    public function openModal(Reportes $reporte)
    {
        $this->openModalRecordatorio = true;
        $this->fecha_recordatorio = Carbon::now()->addDays(14)->format('Y-m-d');
        $this->reporte = $reporte;
    }

    public function closeModal()
    {
        $this->openModalRecordatorio = false;
        $this->reset('fecha_recordatorio');
        $this->reset();
    }
    public function save()
    {
        $this->validate();

        $this->reporte->recordatorios()->create([
            'tipo' => 'reporte',
            'data' => $this->nota,
            'fecha' => $this->fecha_recordatorio,
            'user_id' => auth()->user()->id,

        ]);

        $this->reporte->estado = '2';
        $this->reporte->save();
        $this->afterSave($this->reporte->vehiculos->placa);
    }

    public function updated($label)
    {

        $this->validateOnly($label);
    }


    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'RECORDATORIO CREADO',
            mensaje: 'Se registro correctamente el recordatoria para la unidad ' . $placa,
        );
        $this->closeModal();
        $this->resetErrorBag();
        $this->dispatch('update-table');
    }
}
