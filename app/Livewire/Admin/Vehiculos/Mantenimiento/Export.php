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
    public $estado = "TODAS";
    public $clientes_id;



    protected $listeners = [
        'openModalExport' => 'openModal'
    ];

    protected  $rules = [
        'fecha_inicio' => 'required',
        'fecha_fin' => 'required',
        "estado" => 'required',
        "clientes_id" => 'required',


    ];

    protected $messages = [
        'fecha_inicio.required' => 'La fecha es requerida',
        'fecha_fin.required' => 'La fecha es requerida',
        'estado.required' => 'El estado es requerido',
        'clientes_id.required' => 'Selecciona un cliente',


    ];

    public function mount()
    {

        $this->fecha_inicio = Carbon::now()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->addMonth()->format('Y-m-d');
        $this->estado = 'TODAS';
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

    public function exportReport()
    {

        $this->validate();
        return Excel::download(new MantenimientosExport($this->estado, $this->fecha_inicio, $this->fecha_fin, $this->clientes_id), 'mantenimientos_reportes.xlsx');
    }

    public function updated($label)
    {
        $this->validateOnly($label);
    }
}
