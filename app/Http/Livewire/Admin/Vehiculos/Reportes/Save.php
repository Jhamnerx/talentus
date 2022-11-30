<?php

namespace App\Http\Livewire\Admin\Vehiculos\Reportes;

use App\Http\Requests\ReportesRequest;
use App\Models\Reportes;
use Livewire\Component;

class Save extends Component
{

    public $vehiculos_id, $hora_t, $fecha_t, $detalle;
    public $openModalSave = false;

    protected $listeners = [
        'guardarReporte' => 'openModal'
    ];


    public function render()
    {

        return view('livewire.admin.vehiculos.reportes.save');
    }
    public function closeModal()
    {
        $this->openModalSave = false;
        $this->reset();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function openModal()
    {

        $this->dispatchBrowserEvent('open-modal');
        $this->openModalSave = true;
    }

    public function GuardarReporte()
    {

        $reporteRequest = new ReportesRequest();
        $values = $this->validate($reporteRequest->rules(), $reporteRequest->messages());

        $reporte = new Reportes;

        $reporte->vehiculos_id = $this->vehiculos_id;
        $reporte->hora_t = $this->hora_t;
        $reporte->fecha_t = $this->fecha_t;
        $reporte->fecha = today();
        $reporte->detalle = $this->detalle;
        $reporte->user_id = auth()->user()->id;
        $reporte->empresa_id = session('empresa');
        $reporte->save();
        $this->openModalSave = false;
        $this->dispatchBrowserEvent('reporte-save', ['vehiculo' => $reporte->vehiculos->placa]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $reporteRequest = new ReportesRequest();
        $this->validateOnly($label, $reporteRequest->rules(), $reporteRequest->messages());
    }
}
