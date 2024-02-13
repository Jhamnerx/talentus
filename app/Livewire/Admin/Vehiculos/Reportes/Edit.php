<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Http\Requests\ReportesRequest;
use App\Models\Reportes;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{

    public $vehiculos_id, $hora_t, $fecha_t, $detalle;

    public $reporte = null;
    public $openModalEdit = false;



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
    #[On('editarReporte')]
    public function openModal(Reportes $reporte)
    {

        $this->openModalEdit = true;

        $this->reporte = $reporte;
        $this->vehiculos_id = $this->reporte->vehiculos_id;
        $this->hora_t = $reporte->hora_t;
        $this->fecha_t = $reporte->fecha_t->format('Y-m-d');
        $this->detalle = $reporte->detalle;
    }

    public function save()

    {
        $requestReporte = new ReportesRequest();
        $values = $this->validate($requestReporte->rules($this->reporte), $requestReporte->messages());

        try {

            $this->reporte->update(
                [
                    'hora_t' => $values['hora_t'],
                    'fecha_t' => $values['fecha_t'],
                    'detalle' => $values['detalle'],
                ]
            );

            $this->afterSave($this->reporte->vehiculos->placa);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                tittle: 'ERROR AL ACTUALIZAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }

    public function updated($label)
    {
        $requestReporte = new ReportesRequest();
        $this->validateOnly($label, $requestReporte->rules($this->reporte), $requestReporte->messages());
    }

    public function changeStatus($estado)
    {

        $this->reporte->update([
            'estado' => $estado,
        ]);

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'ESTADO ACTUALIZADO',
            mensaje: 'Se cambio el estado del reporte de la unidad: ' . $this->reporte->vehiculos->placa,
        );

        $this->dispatch('update-table');
    }

    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'REPORTE ACTUALIZADO',
            mensaje: 'Se actualizo el reporte de la unidad: ' . $placa,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
}
