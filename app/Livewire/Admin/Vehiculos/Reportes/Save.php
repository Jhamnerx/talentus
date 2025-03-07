<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use Livewire\Component;
use App\Models\Reportes;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use App\Http\Requests\ReportesRequest;
use Carbon\Carbon;

class Save extends Component
{

    public $vehiculos_id, $hora_t, $fecha_t, $detalle;
    public $openModalSave = false;

    public Collection $info;
    public Collection $acciones;

    public $accion;
    public $text_add;

    public function mount()
    {
        $now = Carbon::now();
        $this->hora_t = $now->format('H:i');
        $this->fecha_t = $now->format('Y-m-d');
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
        $this->reset('vehiculos_id', 'detalle', 'text_add', 'accion');
        $this->resetErrorBag();
    }


    #[On('open-modal-save')]
    public function openModal()
    {
        $this->openModalSave = true;
    }

    public function save()
    {
        $reporteRequest = new ReportesRequest();
        $this->validate($reporteRequest->rules(), $reporteRequest->messages());

        $reporte = new Reportes;

        $reporte->vehiculos_id = $this->vehiculos_id;
        $reporte->hora_t = $this->hora_t;
        $reporte->fecha_t = $this->fecha_t;
        $reporte->fecha = today();
        $reporte->detalle = $this->detalle;
        $reporte->user_id = auth()->user()->id;
        $reporte->empresa_id = session('empresa');
        $reporte->save();

        $this->afterSave($reporte->vehiculos->placa);
    }


    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'REPORTE REGISTRADO',
            mensaje: 'Se registro el reporte de la unidad: ' . $placa,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
    public function updated($label)
    {
        $reporteRequest = new ReportesRequest();
        $this->validateOnly($label, $reporteRequest->rules(), $reporteRequest->messages());
    }
}
