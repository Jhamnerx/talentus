<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Http\Requests\ReportesRequest;
use App\Models\Reportes;
use Illuminate\Support\Collection;
use Livewire\Component;

class Save extends Component
{

    public $vehiculos_id, $hora_t, $fecha_t, $detalle, $text_add;
    public $openModalSave = false;

    protected $listeners = [
        'guardarReporte' => 'openModal'
    ];

    public Collection $info;
    public Collection $acciones;
    public $accion;

    public function mount()
    {
        $this->info = collect([
            [
                'detalle' => 'Unidad en cochera',
                'descripcion' =>  'Unidad en cochera hasta el dia %dia%'
            ],
            [
                'detalle' => 'Unidad en mantenimiento',
                'descripcion' => 'Unidad en mantenimiento hasta el dia %dia%'
            ],
            [
                'detalle' => 'Unidad sin cobertura',
                'descripcion' => 'Unidad sin cobertura...'
            ],
        ]);
        $this->acciones = collect([
            [
                'detalle' => 'Espera de confirmación',
                'descripcion' =>  'Se espera la confirmacion del cliente'
            ],
            [
                'detalle' => 'Verificar actualización',
                'descripcion' => 'Verificar Actualización el dia %dia%'
            ],
            [
                'detalle' => 'Crear recordatorio',
                'descripcion' => 'Se creó un recordatorio para el dia %dia%'
            ],
        ]);
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.save');
    }

    public function updatedTextAdd($value)
    {
        $this->detalle = $value;
    }

    public function updatedAccion($value)
    {

        $this->detalle = $this->detalle . " " . $value;
    }
    public function closeModal()
    {
        $this->openModalSave = false;
        $this->reset('vehiculos_id', 'hora_t', 'fecha_t', 'detalle', 'text_add');
        $this->resetErrorBag();
        $this->dispatch('close-modal');
    }

    public function openModal()
    {

        $this->dispatch('open-modal');
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
        $this->dispatch('reporte-save', ['vehiculo' => $reporte->vehiculos->placa]);
        $this->dispatch('updateTable');
        $this->closeModal();
    }

    public function updated($label)
    {
        $reporteRequest = new ReportesRequest();
        $this->validateOnly($label, $reporteRequest->rules(), $reporteRequest->messages());
    }
}
