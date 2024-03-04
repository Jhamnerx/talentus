<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\DetalleReportes;
use App\Models\Reportes;
use Facade\FlareClient\Report;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowDetalle extends Component
{

    public $openModalDetalle = false;
    public $detalle;
    public $detalles = [];
    public Reportes $reporte;

    protected  $rules = [
        'detalle' => 'required',
    ];

    protected $messages = [
        'detalle.required' => 'Debes rellenar este campo',

    ];

    public function closeModal()
    {
        $this->openModalDetalle = false;
        $this->reset();
        $this->resetErrorBag();
    }


    public function render()
    {


        return view('livewire.admin.vehiculos.reportes.show-detalle');
    }


    #[On('verDetalleReporte')]
    public function openModal(Reportes $reporte)
    {
        $this->reporte = $reporte;
        $this->detalles = DetalleReportes::where('reportes_id', $reporte->id)->orderBy('id', 'desc')->get();
        $this->openModalDetalle = true;
    }

    public function addDetalle()
    {
        $this->validate();

        try {

            $this->reporte->detalle()->create([
                'detalle' => $this->detalle,
                'user_id' => $this->reporte->user_id = auth()->user()->id,
            ]);
            $this->afterSave($this->reporte->vehiculos->placa);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR DETALLE',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
        $this->detalle = "";
    }


    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'DETALLE REGISTRADO',
            mensaje: 'Se registro el detalle del reporte de la placa: ' . $placa,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }

    public function updated($label)
    {

        $this->validateOnly($label);
    }
}
