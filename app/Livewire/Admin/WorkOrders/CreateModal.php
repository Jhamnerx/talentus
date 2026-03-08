<?php

namespace App\Livewire\Admin\WorkOrders;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Vehiculos;
use App\Models\WorkOrder;
use Livewire\Attributes\On;
use App\Models\WorkOrderType;
use App\Enums\WorkOrderStatus;
use App\Models\Mantenimiento;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\WireUiActions;

class CreateModal extends Component
{
    use WireUiActions;

    public $modalSave = false;

    public $work_order_type_id, $vehiculo_id, $cliente_id, $cliente_nombre, $tecnico_id;
    public $fecha_programada, $observaciones_inicial;
    public $mantenimiento_id = null;
    public bool $tipoRequiereMantenimiento = false;

    protected function rules()
    {
        return [
            'work_order_type_id' => 'required|exists:work_order_types,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'required|exists:users,id',
            'fecha_programada' => 'required|date|after_or_equal:today',
            'observaciones_inicial' => 'nullable|string|max:1000',
            'mantenimiento_id' => 'nullable|exists:mantenimientos,id',
        ];
    }

    protected function messages()
    {
        return [
            'work_order_type_id.required' => 'Debe seleccionar un tipo de orden',
            'vehiculo_id.required' => 'Debe seleccionar un vehículo',
            'cliente_id.required' => 'Debe seleccionar un cliente',
            'tecnico_id.required' => 'Debe asignar un técnico',
            'fecha_programada.required' => 'La fecha programada es requerida',
            'fecha_programada.after_or_equal' => 'La fecha no puede ser anterior a hoy',
        ];
    }

    public function mount()
    {
        $this->fecha_programada = Carbon::now()->format('Y-m-d H:i');
    }

    public function render()
    {
        $tipos = WorkOrderType::active()->get();
        $tecnicos = User::role('tecnico')->where('is_active', true)->get();

        $mantenimientosPendientes = collect();
        if ($this->tipoRequiereMantenimiento && $this->vehiculo_id) {
            $mantenimientosPendientes = Mantenimiento::where('vehiculo_id', $this->vehiculo_id)
                ->whereIn('estado', ['PENDIENTE'])
                ->orderBy('fecha_hora_mantenimiento')
                ->get()
                ->map(fn($m) => [
                    'id' => $m->id,
                    'label' => $m->numero . ' — ' . $m->fecha_hora_mantenimiento->format('d/m/Y') . ($m->detalle_trabajo ? ' | ' . \Str::limit($m->detalle_trabajo, 40) : ''),
                ]);
        }

        return view('livewire.admin.work-orders.create-modal', compact('tipos', 'tecnicos', 'mantenimientosPendientes'));
    }

    #[On('open-create-modal')]
    public function openModal()
    {
        $this->resetProps();
        $this->modalSave = true;
    }

    public function closeModal()
    {
        $this->modalSave = false;
        $this->resetProps();
    }

    public function updatedVehiculoId($value)
    {
        $vehiculo = Vehiculos::with('cliente')->find($value);
        if ($vehiculo && $vehiculo->cliente) {
            $this->cliente_id = $vehiculo->cliente->id;
            $this->cliente_nombre = $vehiculo->cliente->razon_social;
        }
        // Reiniciar mantenimiento al cambiar vehículo
        $this->mantenimiento_id = null;
    }

    public function updatedWorkOrderTypeId($value)
    {
        if (!$value) {
            $this->tipoRequiereMantenimiento = false;
            $this->mantenimiento_id = null;
            return;
        }

        $tipo = WorkOrderType::find($value);
        $this->tipoRequiereMantenimiento = $tipo?->es_mantenimiento_programado ?? false;

        if (!$this->tipoRequiereMantenimiento) {
            $this->mantenimiento_id = null;
        }
    }

    public function save()
    {
        $data = $this->validate();

        try {
            $data['empresa_id'] = Auth::user()->empresa_id;
            $data['estado'] = WorkOrderStatus::PENDIENTE;

            // Eliminar mantenimiento_id si el tipo no lo requiere
            if (!$this->tipoRequiereMantenimiento) {
                unset($data['mantenimiento_id']);
            }

            $workOrder = WorkOrder::create($data);

            $this->notification()->success('ÉXITO', "Orden " . str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) . " creada correctamente");

            $this->closeModal();
            $this->dispatch('work-order-created');
        } catch (\Throwable $th) {
            $this->notification()->error('ERROR', 'Error: ' . $th->getMessage());
        }
    }

    public function resetProps()
    {
        $this->work_order_type_id = null;
        $this->vehiculo_id = null;
        $this->cliente_id = null;
        $this->cliente_nombre = null;
        $this->tecnico_id = null;
        $this->fecha_programada = Carbon::now()->format('Y-m-d H:i');
        $this->observaciones_inicial = null;
        $this->mantenimiento_id = null;
        $this->tipoRequiereMantenimiento = false;
    }

    public function addVehiculo($placa)
    {
        $this->dispatch('open-vehiculo-modal', placa: $placa);
    }
}
