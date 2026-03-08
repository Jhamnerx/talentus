<?php

namespace App\Livewire\Admin\WorkOrders\Types;

use App\Models\WorkOrderType;
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
            $tipo = WorkOrderType::findOrFail($tipoId);
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
            ]);
            $this->requiere_checklist = true;
            $this->active = true;
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
            'empresa_id' => session('empresa'),
        ];

        if ($this->editingId) {
            $tipo = WorkOrderType::findOrFail($this->editingId);
            $tipo->update($data);
            $mensaje = 'Tipo de orden actualizado correctamente';
        } else {
            WorkOrderType::create($data);
            $mensaje = 'Tipo de orden creado correctamente';
        }

        $this->showModal = false;

        $this->dispatch('tipo-guardado');

        $this->notification()->success('ÉXITO', $mensaje);
    }

    public function render()
    {
        return view('livewire.admin.work-orders.types.create');
    }
}
