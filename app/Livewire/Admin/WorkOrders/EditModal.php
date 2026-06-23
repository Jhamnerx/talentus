<?php

namespace App\Livewire\Admin\WorkOrders;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Ciudades;
use App\Models\Operador;
use App\Models\ModelosDispositivo;
use Livewire\Component;
use App\Models\Vehiculos;
use App\Models\WorkOrder;
use Livewire\Attributes\On;
use App\Services\WorkOrderNotificationService;
use WireUi\Traits\WireUiActions;

class EditModal extends Component
{
    use WireUiActions;

    public bool $modalOpen = false;
    public ?int $workOrderId = null;

    // Campos editables
    public ?string $fecha_programada = null;
    public ?int $tecnico_id = null;
    public ?int $vehiculo_id = null;
    public string $cliente_nombre = '';
    public string $direccion = '';
    public ?string $observaciones_inicial = null;

    // Sector y Plan
    public array $sector = [];
    public string $sector_especifico = '';
    public ?int $plan_id = null;

    // Campos de equipo / SIM
    public string $operador_sim_orden = '';
    public ?int $modelo_dispositivo_id = null;

    // Flags del tipo de orden (controlan visibilidad)
    public bool $tipoMuestraSector = false;
    public bool $tipoMuestraPlan = false;
    public bool $tipoRequiereOperadorSim = false;
    public bool $tipoRequiereModeloDispositivo = false;
    public ?string $tipoEquipo = null;

    // Flags de UI
    public ?int $ciudad_filter = null;
    public bool $esProyecto = false;

    // Estado del mensaje WA
    public bool $waEnviado = false;

    // Snapshot de valores originales para detectar cambios relevantes
    private array $snapshot = [];

    protected function rules(): array
    {
        return [
            'fecha_programada'      => 'required|date',
            'tecnico_id'            => 'required|exists:users,id',
            'vehiculo_id'           => 'nullable|exists:vehiculos,id',
            'direccion'             => 'nullable|string|max:500',
            'observaciones_inicial' => 'nullable|string|max:1000',
            'sector'                => 'nullable|array',
            'sector.*'              => 'nullable|string|max:100',
            'sector_especifico'     => 'nullable|string|max:200',
            'plan_id'               => 'nullable|exists:plans,id',
            'operador_sim_orden'    => ($this->tipoRequiereOperadorSim ? 'required|string|max:100' : 'nullable|string|max:100'),
            'modelo_dispositivo_id' => ($this->tipoRequiereModeloDispositivo ? 'required|exists:modelos_dispositivos,id' : 'nullable|exists:modelos_dispositivos,id'),
        ];
    }

    protected function messages(): array
    {
        return [
            'fecha_programada.required'      => 'La fecha programada es requerida',
            'tecnico_id.required'            => 'Debe asignar un técnico',
            'operador_sim_orden.required'    => 'Seleccione el operador SIM para esta orden',
            'modelo_dispositivo_id.required' => 'Seleccione el modelo del dispositivo',
        ];
    }

    #[On('open-edit-modal')]
    public function openModal(int $workOrderId): void
    {
        $orden = WorkOrder::with(['vehiculo.cliente', 'cliente', 'tecnico', 'tipo'])->findOrFail($workOrderId);

        $this->workOrderId          = $workOrderId;
        $this->fecha_programada     = $orden->fecha_programada->format('Y-m-d H:i');
        $this->tecnico_id           = $orden->tecnico_id;
        $this->vehiculo_id          = $orden->vehiculo_id;
        $this->cliente_nombre       = $orden->vehiculo?->cliente?->razon_social
            ?? $orden->cliente?->razon_social
            ?? '';
        $this->direccion            = $orden->direccion ?? '';
        $this->observaciones_inicial = $orden->observaciones_inicial;
        $this->ciudad_filter        = $orden->tecnico?->ciudad_id;
        $this->esProyecto           = (bool) $orden->es_proyecto;
        $this->waEnviado            = !empty($orden->wa_message_id);

        // Flags del tipo de orden
        $tipo = $orden->tipo;
        $this->tipoMuestraSector           = $tipo?->muestra_sector ?? false;
        $this->tipoMuestraPlan             = $tipo?->muestra_plan ?? false;
        $this->tipoRequiereOperadorSim     = $tipo?->requiere_operador_sim ?? false;
        $this->tipoRequiereModeloDispositivo = $tipo?->requiere_modelo_dispositivo ?? false;
        $this->tipoEquipo                  = $tipo?->tipo_equipo;

        // Sector: parsear string almacenado → array + especifico
        $this->sector = [];
        $this->sector_especifico = '';
        if (!empty($orden->sector)) {
            foreach (explode(', ', $orden->sector) as $parte) {
                if (str_starts_with($parte, 'OTROS: ')) {
                    $this->sector[] = 'OTROS';
                    $this->sector_especifico = substr($parte, 7);
                } else {
                    $this->sector[] = $parte;
                }
            }
        }

        // Plan: buscar ID a partir del nombre almacenado
        $this->plan_id = null;
        if (!empty($orden->plan)) {
            $plan = Plan::where('is_active', true)->get()->first(function ($p) use ($orden) {
                $name = is_array($p->name) ? ($p->name['es'] ?? ($p->name['en'] ?? '')) : $p->name;
                return $name === $orden->plan;
            });
            $this->plan_id = $plan?->id;
        }

        // Metadata: operador SIM y modelo dispositivo
        $metadata = $orden->metadata ?? [];
        $this->operador_sim_orden   = $metadata['operador_sim'] ?? '';
        $this->modelo_dispositivo_id = isset($metadata['modelo_dispositivo_id'])
            ? (int) $metadata['modelo_dispositivo_id']
            : null;

        $this->modalOpen = true;
    }

    public function closeModal(): void
    {
        $this->modalOpen = false;
        $this->reset([
            'workOrderId',
            'fecha_programada',
            'tecnico_id',
            'vehiculo_id',
            'cliente_nombre',
            'direccion',
            'observaciones_inicial',
            'sector',
            'sector_especifico',
            'plan_id',
            'operador_sim_orden',
            'modelo_dispositivo_id',
            'tipoMuestraSector',
            'tipoMuestraPlan',
            'tipoRequiereOperadorSim',
            'tipoRequiereModeloDispositivo',
            'tipoEquipo',
            'ciudad_filter',
            'esProyecto',
            'waEnviado',
        ]);
    }

    public function updatedVehiculoId($value): void
    {
        $vehiculo = Vehiculos::with('cliente')->find($value);
        $this->cliente_nombre = $vehiculo?->cliente?->razon_social ?? '';
    }

    public function save(): void
    {
        $this->validate();

        $orden = WorkOrder::findOrFail($this->workOrderId);

        // Detectar cambios relevantes para WA antes de actualizar
        $hayTecnicoCambio   = $orden->tecnico_id !== (int) $this->tecnico_id;
        $hayFechaCambio     = $orden->fecha_programada->format('Y-m-d H:i') !== $this->fecha_programada;
        $hayVehiculoCambio  = $orden->vehiculo_id !== $this->vehiculo_id;
        $hayDireccionCambio = ($orden->direccion ?? '') !== $this->direccion;

        // Construir string de sector
        $sectorStr = null;
        if (!empty($this->sector)) {
            $sectoresTexto = $this->sector;
            if (in_array('OTROS', $sectoresTexto) && $this->sector_especifico) {
                $sectoresTexto = array_map(
                    fn($s) => $s === 'OTROS' ? 'OTROS: ' . strtoupper(trim($this->sector_especifico)) : $s,
                    $sectoresTexto
                );
            }
            $sectorStr = implode(', ', $sectoresTexto);
        }
        $haySectorCambio = ($orden->sector ?? '') !== ($sectorStr ?? '');

        // Resolver plan ID → nombre
        $planNombre = null;
        if ($this->plan_id) {
            $planModel = Plan::find($this->plan_id);
            if ($planModel) {
                $planNombre = is_array($planModel->name)
                    ? ($planModel->name['es'] ?? ($planModel->name['en'] ?? ''))
                    : $planModel->name;
            }
        }
        $hayPlanCambio = ($orden->plan ?? '') !== ($planNombre ?? '');

        // Actualizar metadata (conservar otros campos existentes)
        $metadata = $orden->metadata ?? [];
        if ($this->operador_sim_orden) {
            $metadata['operador_sim'] = $this->operador_sim_orden;
        } else {
            unset($metadata['operador_sim']);
        }
        if ($this->modelo_dispositivo_id) {
            $metadata['modelo_dispositivo_id'] = $this->modelo_dispositivo_id;
        } else {
            unset($metadata['modelo_dispositivo_id']);
        }

        $orden->update([
            'fecha_programada'    => $this->fecha_programada,
            'tecnico_id'          => $this->tecnico_id,
            'vehiculo_id'         => $this->vehiculo_id ?: $orden->vehiculo_id,
            'direccion'           => $this->direccion ?: null,
            'observaciones_inicial' => $this->observaciones_inicial,
            'sector'              => $sectorStr,
            'plan'                => $planNombre,
            'metadata'            => !empty($metadata) ? $metadata : null,
        ]);

        // Notificar al grupo si hubo cambios relevantes
        $hayCAmbiosWA = $hayTecnicoCambio || $hayFechaCambio || $hayVehiculoCambio
            || $hayDireccionCambio || $haySectorCambio || $hayPlanCambio;

        if ($this->waEnviado && $hayCAmbiosWA) {
            $orden->refresh();
            $orden->loadMissing(['tipo', 'vehiculo.cliente', 'cliente', 'tecnico', 'items']);

            $banner   = $hayFechaCambio ? '🔄 *OT REPROGRAMADA*' : '✏️ *OT ACTUALIZADA*';
            $servicio = app(WorkOrderNotificationService::class);

            if ($orden->puedeEditarMensaje()) {
                $editado = $servicio->editarMensaje($orden, prefijo: $banner);

                if ($editado) {
                    $this->notification()->success(
                        'ACTUALIZADO',
                        "Orden #{$this->workOrderId} actualizada y mensaje WhatsApp editado"
                    );
                } else {
                    $this->notification()->warning(
                        'ACTUALIZADO PARCIALMENTE',
                        "Orden #{$this->workOrderId} actualizada, pero no se pudo editar el mensaje WA"
                    );
                }
            } else {
                $nuevoId = $servicio->enviarAlGrupo($orden, prefijo: $banner);

                if ($nuevoId) {
                    $this->notification()->success(
                        'ACTUALIZADO',
                        "Orden #{$this->workOrderId} actualizada y se envió un aviso nuevo al grupo"
                    );
                } else {
                    $this->notification()->warning(
                        'ACTUALIZADO PARCIALMENTE',
                        "Orden #{$this->workOrderId} actualizada, pero no se pudo enviar el aviso al grupo"
                    );
                }
            }
        } else {
            $this->notification()->success('ACTUALIZADO', "Orden #{$this->workOrderId} actualizada correctamente");
        }

        $this->closeModal();
        $this->dispatch('work-order-updated');
    }

    public function render()
    {
        $tecnicosQuery = User::role('tecnico')->where('is_active', true);
        if ($this->ciudad_filter) {
            $tecnicosQuery->where('ciudad_id', $this->ciudad_filter);
        }
        $tecnicos = $tecnicosQuery->get();
        $ciudades = Ciudades::where('is_active', true)->orderBy('nombre')->get();

        $sectores = collect(WorkOrderNotificationService::ZONAS)
            ->map(fn($label, $key) => ['value' => $key, 'label' => $label])
            ->values()
            ->all();

        $planes = Plan::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn($p) => [
                'id'   => $p->id,
                'name' => is_array($p->name) ? ($p->name['es'] ?? ($p->name['en'] ?? 'Sin nombre')) : $p->name,
            ]);

        $operadores = Operador::orderBy('name')->get(['id', 'name']);

        $modelosDispositivo = $this->tipoRequiereModeloDispositivo
            ? ModelosDispositivo::orderBy('marca')->orderBy('modelo')->get()
            ->map(fn($m) => ['id' => $m->id, 'name' => ($m->marca ? $m->marca . ' — ' : '') . $m->modelo])
            : collect();

        return view('livewire.admin.work-orders.edit-modal', compact(
            'tecnicos',
            'ciudades',
            'sectores',
            'planes',
            'operadores',
            'modelosDispositivo'
        ));
    }
}
