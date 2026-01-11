<?php

namespace App\Livewire\Admin\WorkOrders;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Exports\WorkOrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportModal extends Component
{
    public $modalExport = false;
    public $export_tecnico_id = '';
    public $export_fecha_inicial = '';
    public $export_fecha_final = '';
    public $export_estado = '';

    protected function rules()
    {
        return [
            'export_tecnico_id' => 'required|exists:users,id',
            'export_fecha_inicial' => 'required|date',
            'export_fecha_final' => 'required|date|after_or_equal:export_fecha_inicial',
        ];
    }

    protected function messages()
    {
        return [
            'export_tecnico_id.required' => 'Debe seleccionar un técnico',
            'export_fecha_inicial.required' => 'La fecha inicial es requerida',
            'export_fecha_final.required' => 'La fecha final es requerida',
            'export_fecha_final.after_or_equal' => 'La fecha final debe ser posterior a la inicial',
        ];
    }

    public function mount()
    {
        $this->export_fecha_inicial = now()->startOfMonth()->format('Y-m-d');
        $this->export_fecha_final = now()->format('Y-m-d');
    }

    public function render()
    {
        $tecnicos = User::role('tecnico')->where('is_active', true)->orderBy('name')->get();

        return view('livewire.admin.work-orders.export-modal', compact('tecnicos'));
    }

    #[On('open-export-modal')]
    public function openModal()
    {
        $this->export_tecnico_id = '';
        $this->export_fecha_inicial = now()->startOfMonth()->format('Y-m-d');
        $this->export_fecha_final = now()->format('Y-m-d');
        $this->export_estado = '';
        $this->modalExport = true;
    }

    public function closeModal()
    {
        $this->modalExport = false;
        $this->resetValidation();
    }

    public function exportarOrdenes()
    {
        $this->validate();

        try {
            $this->closeModal();

            return Excel::download(
                new WorkOrdersExport(
                    $this->export_tecnico_id,
                    $this->export_fecha_inicial,
                    $this->export_fecha_final,
                    $this->export_estado
                ),
                'ordenes_trabajo_' . now()->format('Y-m-d_His') . '.xlsx'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Error al exportar: ' . $e->getMessage()
            );
        }
    }
}
