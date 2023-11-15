<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\DetalleReportes;
use App\Models\Reportes;
use Facade\FlareClient\Report;
use Livewire\Component;

class ShowDetalle extends Component
{

    public $reporte_id = null;
    public $openModalDetalle = false;
    public $detalle;
    public $reportes;

    protected $listeners = [
        'verDetalleReporte' => 'openModal'
    ];

    protected  $rules = [
        'detalle' => 'required',


        // "dispositivos_id" => "required|unique:vehiculos",

    ];

    protected $messages = [
        'detalle.required' => 'Debes rellenar este campo',


    ];
    public function closeModal()
    {

        // $this->openModalDetalle = false;
        $this->reset();
        $this->resetErrorBag();
    }


    public function render()
    {
        $detalles = DetalleReportes::where('reportes_id', $this->reporte_id)->orderBy('id', 'desc')->get();

        return view('livewire.admin.vehiculos.reportes.show-detalle', compact('detalles'));
    }


    public function openModal(Reportes $reportes)
    {
        $this->openModalDetalle = true;
        $this->reporte_id = $reportes->id;
        $this->reportes = $reportes;
    }

    public function addDetalle()
    {
        $reporte = Reportes::find($this->reportes->id);

        $this->validate();

        $reporte->detalle()->create([
            'detalle' => $this->detalle,
            'user_id' => $this->reportes->user_id = auth()->user()->id,
        ]);

        $this->dispatch('detalle-reporte');
        $this->detalle = "";
    }

    public function updated($label)
    {

        $this->validateOnly($label);
        //dd($label);
    }
}
