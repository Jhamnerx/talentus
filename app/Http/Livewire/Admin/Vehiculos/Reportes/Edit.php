<?php

namespace App\Http\Livewire\Admin\Vehiculos\Reportes;

use App\Http\Requests\ReportesRequest;
use App\Models\Reportes;
use Livewire\Component;

class Edit extends Component
{
    public $vehiculo, $hora_t, $fecha_t, $detalle, $vehiculos_id;

    public $reporte = null;
    public $openModalEdit = false;

    protected $listeners = [
        'editarReporte' => 'openModal'
    ];


    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.edit');
    }

    public function closeModal()
    {

        $this->openModalEdit = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function openModal(Reportes $reportes)
    {

        $this->openModalEdit = true;

        $this->reporte = $reportes;
        //dd($this->reporte);
        $this->vehiculo = $this->reporte->vehiculos->placa;
        $this->hora_t = $this->reporte->hora_t;
        $this->fecha_t = $this->reporte->fecha_t->format('Y-m-d');
        $this->detalle = $this->reporte->detalle;
    }

    public function actualizarReporte()

    {
        $requestReporte = new ReportesRequest();
        $values = $this->validate($requestReporte->rules($this->reporte), $requestReporte->messages());

        $update = Reportes::find($this->reporte->id);
        $update->hora_t = $values["hora_t"];
        $update->fecha_t = $values["fecha_t"];
        $update->detalle = $values["detalle"];

        $update->save();
        $this->openModalEdit = false;
        $this->dispatchBrowserEvent('reporte-edit', ['vehiculo' => $this->reporte->vehiculos->placa]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $requestReporte = new ReportesRequest();
        $this->validateOnly($label, $requestReporte->rules($this->reporte), $requestReporte->messages());
        //dd($label);
    }

    public function changeStatus($estado)
    {

        $update = Reportes::find($this->reporte->id);
        $update->estado = $estado;
        $update->save();
        $this->emit('updateTable');
        $this->dispatchBrowserEvent('reporte-status', ['vehiculo' => $this->reporte->vehiculos->placa, 'estado' => $estado]);
        $this->reset();
    }
}
