<?php

namespace App\Http\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Reportes;
use Livewire\Component;

class Recordatorio extends Component
{
    public $openModalRecordatorio = false;

    public $fecha_recordatorio, $reporte = null;

    protected $listeners = [
        'crearRecordatorio' => 'openModal'
    ];

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

    public function openModal(Reportes $reporte)
    {
        $this->openModalRecordatorio = true;
        $this->reporte = $reporte;
              
        //dd($flota->contactos);
    }

    public function closeModal()
    {
        $this->openModalRecordatorio = false;
        $this->reset('fecha_recordatorio');
        $this->reset();
    }
    public function GuardarRecordatorio()
    {

        $this->validate();

        $this->reporte->recordatorios()->create([
            'tipo' => 'reporte',
            'data' => '',
            'fecha' => $this->fecha_recordatorio,
            'user_id' => auth()->user()->id,
        
        ]);
        $this->reporte->estado = 2;
        $this->reporte->save();
        //dd($this->reporte->vehiculos->placa);

        $this->dispatchBrowserEvent('recordatorio-save', ['vehiculo' => $this->reporte->vehiculos->placa]);
        $this->resetErrorBag();
        $this->closeModal();
        $this->emit('updateTable');
    }

    public function updated($label)
    {
    
        $this->validateOnly($label);
    }
}
