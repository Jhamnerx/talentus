<?php

namespace App\Livewire\Admin\Vehiculos\Mantenimiento;

use App\Exports\MantenimientosExport;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Component
{

    public $openModalExport = false;

    public $fecha_inicio;
    public $fecha_fin;
    public $estado;



    protected $listeners = [
        'openModalExport' => 'openModal'
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

    public function mount()
    {

        $this->fecha_inicio = Carbon::now()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->addMonth()->format('Y-m-d');
        $this->estado = 'PENDIENTE';
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.mantenimiento.export');
    }

    public function openModal()
    {
        $this->openModalExport = true;
    }

    public function closeModal()
    {
        $this->openModalExport = false;
        $this->reset();
        $this->resetErrorBag();
    }

    public function ExportReport()
    {

        $this->validate();
        return Excel::download(new MantenimientosExport($this->estado, $this->fecha_inicio, $this->fecha_fin), 'mantenimientos_reportes.xlsx');
    }

    public function updated($label)
    {
        $this->validateOnly($label);
    }
}
