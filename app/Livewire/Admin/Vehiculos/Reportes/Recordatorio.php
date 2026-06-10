<?php

namespace App\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Admin\Recordatorios;
use App\Models\Reportes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Recordatorio extends Component
{
    public bool $openModalRecordatorio = false;

    #[Validate('required', message: 'Debes ingresar una fecha.')]
    public string $fecha_recordatorio = '';

    public string $nota = '';

    public ?int $reporteId = null;

    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.recordatorio');
    }

    #[On('crearRecordatorio')]
    public function openModal(int $reporte): void
    {
        $this->reporteId             = $reporte;
        $this->fecha_recordatorio    = Carbon::now()->addDays(14)->format('Y-m-d');
        $this->nota                  = '';
        $this->openModalRecordatorio = true;
    }

    public function closeModal(): void
    {
        $this->openModalRecordatorio = false;
        $this->reset(['reporteId', 'fecha_recordatorio', 'nota']);
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->validate();

        $reporte = Reportes::findOrFail($this->reporteId);

        Recordatorios::create([
            'tipo'        => 'reporte',
            'data'        => $this->nota,
            'fecha'       => $this->fecha_recordatorio,
            'user_id'     => Auth::id(),
            'reportes_id' => $reporte->id,
        ]);

        if ($reporte->estado == Reportes::ESTADO_ABIERTA) {
            $reporte->update(['estado' => Reportes::ESTADO_EN_ATENCION]);
        }

        $placa = $reporte->vehiculos?->placa ?? '—';

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'RECORDATORIO CREADO',
            mensaje: "Recordatorio registrado para la unidad {$placa}",
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }

    public function updated(string $label): void
    {
        $this->validateOnly($label);
    }
}
