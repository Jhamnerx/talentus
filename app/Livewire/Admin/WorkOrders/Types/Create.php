<?php

namespace App\Livewire\Admin\WorkOrders\Types;

use App\Models\User;
use App\Models\WorkOrderType;
use App\Models\WorkOrderTypeCost;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Create extends Component
{
    use WireUiActions;

    public $showModal = false;
    public $editingId = null;
    public $nombre = '';
    public $descripcion = '';
    public $costo_base = 0;
    public $requiere_imei = false;
    public $requiere_sim = false;
    public $requiere_accesorios = false;
    public $requiere_checklist = true;
    public $active = true;
    public $es_mantenimiento_programado = false;
    public $muestra_sector = true;
    public $muestra_plan = true;
    public $muestra_accesorios_instalar = true;

    // Costos por técnico: [tecnico_id => costo]
    public array $costosPorTecnico = [];

    /**
     * Variables disponibles para usar en la descripción del tipo de orden.
     * Estas variables serán reemplazadas al crear/mostrar la orden de trabajo con los datos reales.
     * 
     * Ejemplo de uso en descripción:
     * "Instalación de GPS %modelo_gps% en vehículo: %placa%, Fecha instalación: %fecha% - Hora: %hora%"
     * 
     * Al crear la orden se reemplazará por:
     * "Instalación de GPS Concox GT06N en vehículo: ABC-123, Fecha instalación: 24/12/2025 - Hora: 14:30"
     */
    public $variablesDisponibles = [
        '%cliente%' => 'Nombre/Razón Social del cliente',
        '%placa%' => 'Placa del vehículo',
        '%modelo_gps%' => 'Modelo del GPS/dispositivo',
        '%imei%' => 'IMEI del dispositivo',
        '%sim%' => 'Número de SIM/ICCID',
        '%fecha%' => 'Fecha programada',
        '%hora%' => 'Hora programada',
        '%tecnico%' => 'Nombre del técnico asignado',
        '%velo_modelo%' => 'Modelo del vehículo',
    ];

    #[On('open-tipo-modal')]
    public function openModal($tipoId = null): void
    {
        if ($tipoId) {
            $tipo = WorkOrderType::with('costs')->findOrFail($tipoId);
            $this->editingId = $tipo->id;
            $this->nombre = $tipo->nombre;
            $this->descripcion = $tipo->descripcion;
            $this->costo_base = $tipo->costo_base;
            $this->requiere_imei = $tipo->requiere_imei;
            $this->requiere_sim = $tipo->requiere_sim;
            $this->requiere_accesorios = $tipo->requiere_accesorios;
            $this->requiere_checklist = $tipo->requiere_checklist;
            $this->active = $tipo->active;
            $this->es_mantenimiento_programado = $tipo->es_mantenimiento_programado;
            $this->muestra_sector = $tipo->muestra_sector;
            $this->muestra_plan = $tipo->muestra_plan;
            $this->muestra_accesorios_instalar = $tipo->muestra_accesorios_instalar;

            // Cargar costos existentes por técnico
            $this->costosPorTecnico = $tipo->costs->pluck('costo', 'tecnico_id')->map(fn($c) => (string) $c)->toArray();
        } else {
            $this->reset([
                'editingId',
                'nombre',
                'descripcion',
                'costo_base',
                'requiere_imei',
                'requiere_sim',
                'requiere_accesorios',
                'requiere_checklist',
                'active',
                'es_mantenimiento_programado',
                'muestra_sector',
                'muestra_plan',
                'muestra_accesorios_instalar',
                'costosPorTecnico',
            ]);
            $this->requiere_checklist = true;
            $this->active = true;
            $this->muestra_sector = true;
            $this->muestra_plan = true;
            $this->muestra_accesorios_instalar = true;
        }

        $this->showModal = true;
    }

    public function insertarVariable($variable): void
    {
        $this->descripcion .= $variable;
    }

    public function guardar(): void
    {
        $validated = $this->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'costo_base' => 'nullable|numeric|min:0',
            'requiere_imei' => 'boolean',
            'requiere_sim' => 'boolean',
            'requiere_accesorios' => 'boolean',
            'requiere_checklist' => 'boolean',
            'active' => 'boolean',
            'es_mantenimiento_programado' => 'boolean',
            'muestra_sector' => 'boolean',
            'muestra_plan' => 'boolean',
            'muestra_accesorios_instalar' => 'boolean',
            'costosPorTecnico' => 'nullable|array',
            'costosPorTecnico.*' => 'nullable|numeric|min:0',
        ]);

        $data = [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'costo_base' => $this->costo_base ?? 0,
            'requiere_imei' => $this->requiere_imei,
            'requiere_sim' => $this->requiere_sim,
            'requiere_accesorios' => $this->requiere_accesorios,
            'requiere_checklist' => $this->requiere_checklist,
            'active' => $this->active,
            'es_mantenimiento_programado' => $this->es_mantenimiento_programado,
            'muestra_sector' => $this->muestra_sector,
            'muestra_plan' => $this->muestra_plan,
            'muestra_accesorios_instalar' => $this->muestra_accesorios_instalar,
            'empresa_id' => session('empresa'),
        ];

        if ($this->editingId) {
            $tipo = WorkOrderType::findOrFail($this->editingId);
            $tipo->update($data);
            $mensaje = 'Tipo de orden actualizado correctamente';
        } else {
            $tipo = WorkOrderType::create($data);
            $mensaje = 'Tipo de orden creado correctamente';
        }

        // Guardar costos por técnico (upsert)
        $empresaId = session('empresa');
        foreach ($this->costosPorTecnico as $tecnicoId => $costo) {
            if ($costo !== null && $costo !== '') {
                WorkOrderTypeCost::withoutGlobalScope(\App\Scopes\EmpresaScope::class)
                    ->updateOrCreate(
                        ['work_order_type_id' => $tipo->id, 'tecnico_id' => (int) $tecnicoId],
                        ['costo' => (float) $costo, 'empresa_id' => $empresaId]
                    );
            } else {
                // Si se dejó vacío, eliminar el costo específico (usará costo_base)
                WorkOrderTypeCost::withoutGlobalScope(\App\Scopes\EmpresaScope::class)
                    ->where('work_order_type_id', $tipo->id)
                    ->where('tecnico_id', (int) $tecnicoId)
                    ->delete();
            }
        }

        $this->showModal = false;

        $this->dispatch('tipo-guardado');

        $this->notification()->success('EXITO', $mensaje);
    }

    public function render()
    {
        $tecnicos = User::role('tecnico')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.admin.work-orders.types.create', compact('tecnicos'));
    }
}
