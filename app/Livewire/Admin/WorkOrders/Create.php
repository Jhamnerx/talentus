<?php

namespace App\Livewire\Admin\WorkOrders;

use App\Models\WorkOrder;
use App\Models\WorkOrderType;
use App\Models\User;
use App\Models\Vehiculos;
use App\Models\Clientes;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public $modalSave = false;

    public $work_order_type_id, $vehiculo_id, $cliente_id, $tecnico_id;
    public $fecha_programada, $observaciones_inicial;

    protected function rules()
    {
        return [
            'work_order_type_id' => 'required|exists:work_order_types,id',
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'required|exists:users,id',
            'fecha_programada' => 'required|date|after_or_equal:today',
            'observaciones_inicial' => 'nullable|string|max:1000',
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
        $tipos = WorkOrderType::active()->pluck('nombre', 'id');
        $tecnicos = User::role('tecnico')->where('is_active', true)->get();

        return view('livewire.admin.work-orders.create', compact('tipos', 'tecnicos'));
    }

    public function openModal()
    {
        $this->modalSave = true;
    }

    public function closeModal()
    {
        $this->modalSave = false;
        $this->resetProps();
    }

    public function updatedVehiculoId($value)
    {
        $vehiculo = Vehiculos::find($value);
        if ($vehiculo && $vehiculo->cliente) {
            $this->cliente_id = $vehiculo->cliente->id;
        }
    }

    public function save()
    {
        $data = $this->validate();

        try {
            $workOrder = WorkOrder::create($data);

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN CREADA',
                mensaje: "Orden {$workOrder->codigo} creada correctamente"
            );

            $this->closeModal();
            $this->dispatch('work-order-created');
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Error: ' . $th->getMessage()
            );
        }
    }

    public function resetProps()
    {
        $this->work_order_type_id = null;
        $this->vehiculo_id = null;
        $this->cliente_id = null;
        $this->tecnico_id = null;
        $this->fecha_programada = Carbon::now()->format('Y-m-d H:i');
        $this->observaciones_inicial = null;
    }
}
