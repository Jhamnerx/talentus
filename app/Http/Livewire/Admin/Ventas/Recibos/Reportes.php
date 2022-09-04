<?php

namespace App\Http\Livewire\Admin\Ventas\Recibos;

use App\Exports\RecibosExport;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Reportes extends Component
{
    public $openModalReporte = false;

    public $fecha_inicio;
    public $fecha_fin;
    public $estado;



    protected $listeners = [
        'openModalReporte' => 'openModal'
    ];

        protected  $rules = [
        'fecha_inicio' => 'required',
        'fecha_fin' => 'required',
        "estado" => 'required',


    ];

    protected $messages = [
        'fecha_inicio.required' => 'La fecha es requerida',
        'fecha_fin.required' => 'La fecha es requerida',
        'estado.required' => 'El estado es requerido',


    ];
    public function mount(){

        $this->fecha_inicio = Carbon::now()->format('Y-m-d');
        $this->fecha_fin = date('Y-m-d');
        $this->estado = 'PAID';
    }

    public function render()
    {
        return view('livewire.admin.ventas.recibos.reportes');
    }


    public function openModal()
    {  // dd('hola');
        $this->openModalReporte = true;
    }

    public function closeModal()
    {
        $this->openModalReporte = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function ExportReport(){

        $this->validate();
        return Excel::download(new RecibosExport($this->estado, $this->fecha_inicio, $this->fecha_fin), 'recibos_reportes.xlsx');
    }

    public function updated($label)
    {
        $this->validateOnly($label);

    }
}
