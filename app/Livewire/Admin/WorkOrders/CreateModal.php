<?php

namespace App\Livewire\Admin\WorkOrders;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Ciudades;
use App\Models\Contactos;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Vehiculos;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use Livewire\Attributes\On;
use App\Models\WorkOrderType;
use App\Enums\WorkOrderStatus;
use App\Models\Mantenimiento;
use App\Services\WorkOrderNotificationService;
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

    // Nuevos campos de integración WA
    public ?int $ciudad_filter = null;   // filtro visual, no se guarda
    public string $sector = '';
    public string $sector_especifico = ''; // cuando sector === 'OTROS'
    public ?int $plan_id = null;         // se resuelve al guardar → columna plan (string)
    public ?int $contacto_id = null;     // se resuelve al guardar → columna contacto (string)
    public array $accesorios = [];       // ['buzzer', 'corte_motor']
    public array $contactos = [];        // se puebla cuando cambia vehiculo_id

    // Flags del tipo de orden (controlan visibilidad de campos)
    public bool $tipoMuestraSector = true;
    public bool $tipoMuestraPlan = true;
    public bool $tipoMuestraAccesorios = true;

    // Flags de requisitos del tipo
    public bool $tipoRequiereAccesorios = false;

    // Costo estimado según tipo + técnico seleccionados
    public ?float $costoEstimado = null;
    public bool $costoPersonalizado = false;

    // Ubicación del servicio
    public ?float $ubicacion_lat = null;
    public ?float $ubicacion_lng = null;
    public string $ubicacion_direccion = '';

    // ── Modo proyecto (múltiples vehículos) ─────────────────────────────
    public bool $esProyecto = false;
    public string $tituloProyecto = '';
    public string $placasTexto = '';        // Pegado de placas una por línea
    public string $itemsTipoTrabajo = 'mantenimiento'; // Tipo por defecto para todos los ítems

    protected function rules()
    {
        return [
            'work_order_type_id'  => 'required|exists:work_order_types,id',
            'vehiculo_id'         => $this->esProyecto ? 'nullable' : 'required|exists:vehiculos,id',
            'cliente_id'          => $this->esProyecto ? 'nullable' : 'required|exists:clientes,id',
            'tecnico_id'          => 'required|exists:users,id',
            'fecha_programada'    => 'required|date|after_or_equal:today',
            'observaciones_inicial' => 'nullable|string|max:1000',
            'mantenimiento_id'    => 'nullable|exists:mantenimientos,id',
            'sector'              => 'nullable|string|max:100',
            'sector_especifico'   => 'nullable|string|max:200',
            'plan_id'             => 'nullable|exists:plans,id',
            'contacto_id'         => 'nullable|exists:contactos,id',
            'accesorios'          => ($this->tipoRequiereAccesorios ? 'required|array|min:1' : 'nullable|array'),
            'accesorios.*'        => 'in:buzzer,corte_motor,apertura_puertas,telemetria,combustible,temperatura,horas_motor,rpm,acelerometro,camara',
            'tituloProyecto'      => $this->esProyecto ? 'required|string|max:255' : 'nullable',
            'placasTexto'         => $this->esProyecto ? 'nullable|string' : 'nullable',
        ];
    }

    protected function messages()
    {
        return [
            'work_order_type_id.required' => 'Debe seleccionar un tipo de orden',
            'vehiculo_id.required' => 'Debe seleccionar un vehículo',
            'cliente_id.required'  => 'Debe seleccionar un cliente',
            'tecnico_id.required'  => 'Debe asignar un técnico',
            'fecha_programada.required'     => 'La fecha programada es requerida',
            'fecha_programada.after_or_equal' => 'La fecha no puede ser anterior a hoy',
            'accesorios.required'  => 'Seleccione al menos un accesorio para este tipo de orden',
            'accesorios.min'       => 'Seleccione al menos un accesorio',
            'tituloProyecto.required' => 'El título del proyecto es obligatorio',
        ];
    }

    public function mount()
    {
        $this->fecha_programada = Carbon::now()->format('Y-m-d H:i');
    }

    public function render()
    {
        $tipos = WorkOrderType::active()->get();

        $tecnicosQuery = User::role('tecnico')->where('is_active', true);
        if ($this->ciudad_filter) {
            $tecnicosQuery->where('ciudad_id', $this->ciudad_filter);
        }
        $tecnicos = $tecnicosQuery->get();

        $ciudades = Ciudades::where('is_active', true)->orderBy('nombre')->get();

        $mantenimientosPendientes = collect();
        if ($this->tipoRequiereMantenimiento && $this->vehiculo_id) {
            $mantenimientosPendientes = Mantenimiento::where('vehiculo_id', $this->vehiculo_id)
                ->whereIn('estado', ['PENDIENTE'])
                ->orderBy('fecha_hora_mantenimiento')
                ->get()
                ->map(fn($m) => [
                    'id'    => $m->id,
                    'label' => $m->numero . ' — ' . $m->fecha_hora_mantenimiento->format('d/m/Y') . ($m->detalle_trabajo ? ' | ' . Str::limit($m->detalle_trabajo, 40) : ''),
                ]);
        }

        // Planes del sistema (nombre en español)
        $planes = Plan::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn($p) => [
                'id'   => $p->id,
                'name' => is_array($p->name) ? ($p->name['es'] ?? ($p->name['en'] ?? 'Sin nombre')) : $p->name,
            ]);

        $sectores = WorkOrderNotificationService::ZONAS;
        $accesoriosDisponibles = WorkOrderNotificationService::ACCESORIOS;

        return view(
            'livewire.admin.work-orders.create-modal',
            compact('tipos', 'tecnicos', 'ciudades', 'mantenimientosPendientes', 'sectores', 'accesoriosDisponibles', 'planes')
        );
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

            $this->contactos = Contactos::where('clientes_id', $this->cliente_id)
                ->whereNull('deleted_at')
                ->orderBy('nombre')
                ->get()
                ->map(fn($c) => [
                    'id'    => $c->id,
                    'label' => trim(implode(' — ', array_filter([
                        $c->nombre,
                        ($c->cargo && $c->cargo !== 'NINGUNO') ? $c->cargo : null,
                        $c->telefono ? 'Tel: ' . $c->telefono : null,
                    ]))),
                ])
                ->all();
        } else {
            $this->cliente_id = null;
            $this->cliente_nombre = null;
            $this->contactos = [];
        }
        // Reiniciar mantenimiento y contacto al cambiar vehículo
        $this->mantenimiento_id = null;
        $this->contacto_id = null;
    }

    public function updatedWorkOrderTypeId($value)
    {
        if (!$value) {
            $this->tipoRequiereMantenimiento = false;
            $this->tipoMuestraSector = true;
            $this->tipoMuestraPlan = true;
            $this->tipoMuestraAccesorios = true;
            $this->mantenimiento_id = null;
            $this->costoEstimado = null;
            $this->costoPersonalizado = false;
            return;
        }

        $tipo = WorkOrderType::find($value);
        $this->tipoRequiereMantenimiento = $tipo?->es_mantenimiento_programado ?? false;
        $this->tipoMuestraSector = $tipo?->muestra_sector ?? true;
        $this->tipoMuestraPlan = $tipo?->muestra_plan ?? true;
        $this->tipoMuestraAccesorios = $tipo?->muestra_accesorios_instalar ?? true;

        $this->tipoRequiereAccesorios = $tipo?->requiere_accesorios ?? false;

        $this->recalcularCosto();

        if (!$this->tipoRequiereMantenimiento) {
            $this->mantenimiento_id = null;
        }
        if (!$this->tipoMuestraSector) {
            $this->sector = '';
            $this->sector_especifico = '';
        }
        if (!$this->tipoMuestraPlan) {
            $this->plan_id = null;
        }
        if (!$this->tipoMuestraAccesorios) {
            $this->accesorios = [];
        }
    }

    public function updatedTecnicoId($value): void
    {
        $this->recalcularCosto();
    }

    protected function recalcularCosto(): void
    {
        $this->costoEstimado = null;
        $this->costoPersonalizado = false;

        if (!$this->work_order_type_id) {
            return;
        }

        $tipo = WorkOrderType::find($this->work_order_type_id);
        if (!$tipo) {
            return;
        }

        $costoEspecifico = $this->tecnico_id ? $tipo->costoParaTecnico((int) $this->tecnico_id) : null;

        if ($costoEspecifico !== null) {
            $this->costoEstimado = $costoEspecifico;
            $this->costoPersonalizado = true;
        } else {
            $this->costoEstimado = (float) $tipo->costo_base;
            $this->costoPersonalizado = false;
        }
    }

    public function save()
    {
        $data = $this->validate();

        try {
            $data['empresa_id'] = Auth::user()->empresa_id;
            $data['estado']     = WorkOrderStatus::PENDIENTE;
            $data['es_proyecto'] = $this->esProyecto;

            // Eliminar mantenimiento_id si el tipo no lo requiere
            if (!$this->tipoRequiereMantenimiento) {
                unset($data['mantenimiento_id']);
            }

            // Sector: si es "OTROS" usar la descripción específica
            if ($this->sector === 'OTROS' && $this->sector_especifico) {
                $data['sector'] = 'OTROS: ' . strtoupper(trim($this->sector_especifico));
            }

            // Resolver plan desde ID → nombre (string)
            if ($this->plan_id) {
                $planModel = Plan::find($this->plan_id);
                if ($planModel) {
                    $data['plan'] = is_array($planModel->name)
                        ? ($planModel->name['es'] ?? ($planModel->name['en'] ?? ''))
                        : $planModel->name;
                }
            }
            unset($data['plan_id']);

            // Resolver contacto desde ID → string formateado
            if ($this->contacto_id) {
                $c = Contactos::withoutGlobalScope(\App\Scopes\EmpresaScope::class)->find($this->contacto_id);
                if ($c) {
                    $data['contacto'] = trim(implode(' — ', array_filter([
                        $c->nombre,
                        $c->cargo ?: null,
                        $c->telefono ? 'Tel: ' . $c->telefono : null,
                    ])));
                }
            }
            unset($data['contacto_id']);

            // Guardar accesorios en metadata
            $metadata = [];
            if (!empty($this->accesorios)) {
                $metadata['accesorios'] = $this->accesorios;
            }
            $data['metadata'] = !empty($metadata) ? $metadata : null;

            // Ubicación del servicio
            $data['ubicacion_lat']       = $this->ubicacion_lat ?: null;
            $data['ubicacion_lng']       = $this->ubicacion_lng ?: null;
            $data['ubicacion_direccion'] = $this->ubicacion_direccion ?: null;

            // Modo proyecto: limpiar campos que no aplican
            if ($this->esProyecto) {
                $data['vehiculo_id'] = null;
                $data['cliente_id']  = null;
                $data['titulo_proyecto'] = strtoupper(trim($this->tituloProyecto));
            }

            // Eliminar campos que no son columnas de work_orders
            unset(
                $data['ciudad_filter'],
                $data['sector_especifico'],
                $data['accesorios'],
                $data['tituloProyecto'],
                $data['placasTexto'],
                $data['itemsTipoTrabajo']
            );

            $workOrder = WorkOrder::create($data);

            // Crear ítems si es proyecto y se pegaron placas
            if ($this->esProyecto && trim($this->placasTexto)) {
                $lineas = preg_split('/[\r\n]+/', trim($this->placasTexto));
                $orden  = 0;

                foreach ($lineas as $linea) {
                    $linea = trim($linea);
                    if (empty($linea)) {
                        continue;
                    }

                    // Detectar nota inline: "ABC-123 - cambio de chip"
                    $partes   = preg_split('/\s+-\s+/', $linea, 2);
                    $placa    = strtoupper(trim($partes[0]));
                    $notasItem = isset($partes[1]) ? trim($partes[1]) : null;

                    // Buscar vehículo en el sistema (sin filtro de empresa)
                    $vehiculo = Vehiculos::withoutGlobalScope(\App\Scopes\EmpresaScope::class)
                        ->where('placa', $placa)->first();

                    // Determinar tipo de trabajo: si la nota menciona "cambio de chip" → cambio_chip
                    $tipoItem = $this->itemsTipoTrabajo;
                    if ($notasItem && preg_match('/chip/i', $notasItem)) {
                        $tipoItem = 'cambio_chip';
                    }

                    $workOrder->items()->create([
                        'vehiculo_id'   => $vehiculo?->id,
                        'cliente_id'    => $vehiculo?->cliente_id,
                        'placa'         => $placa,
                        'cliente_nombre' => $vehiculo?->cliente?->razon_social,
                        'tipo_trabajo'  => $tipoItem,
                        'notas'         => $notasItem,
                        'estado'        => 'pendiente',
                        'orden'         => $orden++,
                    ]);
                }
            }

            // Enviar notificación WA solo para órdenes individuales
            if (!$this->esProyecto) {
                app(WorkOrderNotificationService::class)->enviarAlGrupo($workOrder);
            }

            $this->notification()->success('ÉXITO', "Orden " . str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) . " creada correctamente");

            $this->closeModal();
            $this->dispatch('work-order-created');
        } catch (\Throwable $th) {
            $this->notification()->error('ERROR', 'Error: ' . $th->getMessage());
        }
    }

    public function resetProps()
    {
        $this->work_order_type_id  = null;
        $this->vehiculo_id         = null;
        $this->cliente_id          = null;
        $this->cliente_nombre      = null;
        $this->tecnico_id          = null;
        $this->fecha_programada    = Carbon::now()->format('Y-m-d H:i');
        $this->observaciones_inicial = null;
        $this->mantenimiento_id    = null;
        $this->tipoRequiereMantenimiento = false;
        $this->ciudad_filter       = null;
        $this->sector              = '';
        $this->sector_especifico   = '';
        $this->plan_id             = null;
        $this->contacto_id         = null;
        $this->accesorios          = [];
        $this->contactos           = [];
        $this->tipoMuestraSector   = true;
        $this->tipoMuestraPlan     = true;
        $this->tipoMuestraAccesorios = true;
        $this->tipoRequiereAccesorios = false;
        $this->ubicacion_lat       = null;
        $this->ubicacion_lng       = null;
        $this->ubicacion_direccion = '';
        $this->costoEstimado       = null;
        $this->costoPersonalizado  = false;
        // Proyecto
        $this->esProyecto          = false;
        $this->tituloProyecto      = '';
        $this->placasTexto         = '';
        $this->itemsTipoTrabajo    = 'mantenimiento';
    }

    public function setUbicacion(float $lat, float $lng, string $direccion = ''): void
    {
        $this->ubicacion_lat       = $lat;
        $this->ubicacion_lng       = $lng;
        $this->ubicacion_direccion = $direccion;
    }

    public function limpiarUbicacion(): void
    {
        $this->ubicacion_lat       = null;
        $this->ubicacion_lng       = null;
        $this->ubicacion_direccion = '';
    }

    public function addVehiculo($placa)
    {
        $this->dispatch('open-vehiculo-modal', placa: $placa);
    }
}
