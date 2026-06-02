<?php

namespace App\Livewire\Admin\WorkOrders;

use Livewire\Component;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderType;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Show extends Component
{
    use WireUiActions;

    public WorkOrder $workOrder;

    public bool $modalFirma = false;
    public string $nombreFirmante = '';
    public string $tipoFirmante = 'cliente';
    public string $documentoFirmante = '';
    public ?string $signatureData = null;

    // Propiedades para captura de dispositivos
    public bool $modalDispositivo = false;
    public string $tipoDispositivo = 'imei'; // 'imei' o 'sim'
    public string $codigoDispositivo = '';
    public string $accionDispositivo = 'instalado'; // 'instalado', 'retirado', 'reemplazado'
    public string $observacionesDispositivo = '';
    public string $ubicacionInstalacion = '';
    public string $ubicacionPersonalizada = '';

    // ── Gestión de ítems del proyecto ────────────────────────────────────
    public string $nuevoItemPlaca = '';
    public ?int $nuevoItemTipoTrabajo = null;
    public string $nuevoItemNotas = '';
    public bool $mostrarAddItem = false;

    public const UBICACIONES = [
        'TABLERO CENTRAL',
        'TABLERO LADO DERECHO',
        'TABLERO LADO IZQUIERDO',
        'DEBAJO DEL ASIENTO',
        'MALETERO / BAÚL',
        'CABINA DEL CONDUCTOR',
        'BAJO EL CAPÓ (MOTOR)',
        'PUERTA DELANTERA DERECHA',
        'PUERTA DELANTERA IZQUIERDA',
        'OTRO',
    ];

    protected $listeners = [
        'work-order-updated' => 'refreshWorkOrder',
        'codigo-escaneado' => 'recibirCodigoEscaneado',
    ];

    public function mount(WorkOrder $workOrder)
    {
        $this->workOrder = $workOrder->load([
            'tipo',
            'vehiculo.cliente',
            'cliente',
            'tecnico',
            'creador',
            'mantenimiento.vehiculo',
            'deviceHistory.dispositivo',
            'deviceHistory.simCard',
            'checklists.template',
            'checklists.photos',
            'photos',
            'signatures',
            'accessories.producto',
            'items.vehiculo',
            'items.tipo',
        ]);
    }

    public function refreshWorkOrder()
    {
        $this->workOrder->refresh();
        $this->workOrder->load([
            'tipo',
            'vehiculo.cliente',
            'cliente',
            'tecnico',
            'creador',
            'mantenimiento.vehiculo',
            'deviceHistory.dispositivo',
            'deviceHistory.simCard',
            'checklists.template',
            'checklists.photos',
            'photos',
            'signatures',
            'accessories.producto',
            'items.vehiculo',
            'items.tipo',
        ]);
    }

    // ── Métodos de gestión de ítems (proyecto) ───────────────────────────

    public function agregarItem(): void
    {
        $this->validate([
            'nuevoItemPlaca'       => 'required|string|max:20',
            'nuevoItemTipoTrabajo' => 'required|exists:work_order_types,id',
        ], [
            'nuevoItemPlaca.required'       => 'La placa es obligatoria.',
            'nuevoItemTipoTrabajo.required' => 'El tipo de trabajo es obligatorio.',
            'nuevoItemTipoTrabajo.exists'   => 'Tipo de trabajo no válido.',
        ]);

        $placa    = strtoupper(trim($this->nuevoItemPlaca));
        $vehiculo = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('placa', $placa)->first();

        $this->workOrder->items()->create([
            'vehiculo_id'         => $vehiculo?->id,
            'cliente_id'          => $vehiculo?->cliente_id,
            'placa'               => $placa,
            'cliente_nombre'      => $vehiculo?->cliente?->razon_social,
            'work_order_type_id'  => $this->nuevoItemTipoTrabajo,
            'tipo_trabajo'        => null,
            'notas'               => trim($this->nuevoItemNotas) ?: null,
            'estado'              => 'pendiente',
            'orden'               => $this->workOrder->items()->count(),
        ]);

        $this->nuevoItemPlaca       = '';
        $this->nuevoItemNotas       = '';
        $this->nuevoItemTipoTrabajo = null;
        $this->mostrarAddItem       = false;
        $this->refreshWorkOrder();
        $this->notification()->success('ÍTEM AGREGADO', "Unidad {$placa} registrada en la orden");
    }

    public function toggleItemEstado(int $itemId): void
    {
        $item = WorkOrderItem::findOrFail($itemId);
        $item->estado = match ($item->estado) {
            'pendiente'  => 'completado',
            'completado' => 'omitido',
            default      => 'pendiente',
        };
        $item->save();
        $this->refreshWorkOrder();
    }

    public function guardarImeiItem(int $itemId, string $imei, string $sim = ''): void
    {
        $item = WorkOrderItem::findOrFail($itemId);
        $item->update([
            'imei'       => trim($imei) ?: null,
            'numero_sim' => trim($sim)  ?: null,
        ]);
        $this->refreshWorkOrder();
        $this->notification()->success('GUARDADO', 'Datos del dispositivo actualizados.');
    }

    public function eliminarItem(int $itemId): void
    {
        WorkOrderItem::findOrFail($itemId)->delete();
        $this->refreshWorkOrder();
    }

    public function iniciar()
    {
        try {
            $this->workOrder->iniciar();
            $this->refreshWorkOrder();

            $this->notification()->success(
                title: 'ORDEN INICIADA',
                description: "Orden {$this->workOrder->codigo} iniciada correctamente"
            );
        } catch (\Exception $e) {
            $this->notification()->error(
                title: 'ERROR',
                description: $e->getMessage()
            );
        }
    }

    public function finalizar($observaciones = null)
    {
        try {
            if ($observaciones) {
                $this->workOrder->observaciones_final = $observaciones;
                $this->workOrder->save();
            }

            $this->workOrder->finalizar();
            $this->refreshWorkOrder();

            $this->notification()->success(
                title: 'ORDEN FINALIZADA',
                description: "Orden {$this->workOrder->codigo} finalizada correctamente"
            );
        } catch (\Exception $e) {
            $this->notification()->error(
                title: 'ERROR',
                description: $e->getMessage()
            );
        }
    }

    public function cerrar()
    {
        try {
            $this->workOrder->cerrar();
            $this->refreshWorkOrder();

            $this->notification()->success(
                title: 'ORDEN CERRADA',
                description: "Orden {$this->workOrder->codigo} cerrada y bloqueada"
            );
        } catch (\Exception $e) {
            $this->notification()->error(
                title: 'ERROR',
                description: $e->getMessage()
            );
        }
    }

    public function cancelar($motivo)
    {
        try {
            $this->workOrder->cancelar($motivo);
            $this->refreshWorkOrder();

            $this->notification()->success(
                title: 'ORDEN CANCELADA',
                description: "Orden {$this->workOrder->codigo} cancelada correctamente"
            );
        } catch (\Exception $e) {
            $this->notification()->error(
                title: 'ERROR',
                description: $e->getMessage()
            );
        }
    }

    public function verChecklist(string $fase)
    {
        $this->redirect(route('admin.work-orders.checklist', [
            'workOrder' => $this->workOrder,
            'fase' => $fase
        ]));
    }

    public function descargarPDF()
    {
        return redirect()->route('admin.work-orders.pdf', $this->workOrder);
    }

    public function abrirModalDispositivo(string $tipo, string $accion = 'instalado')
    {
        $this->modalDispositivo = true;
        $this->tipoDispositivo = $tipo;
        $this->accionDispositivo = $accion;
        $this->codigoDispositivo = '';
        $this->observacionesDispositivo = '';
        $this->ubicacionInstalacion = '';
        $this->ubicacionPersonalizada = '';
    }

    public function recibirCodigoEscaneado($codigo)
    {
        $this->codigoDispositivo = $codigo;
    }

    public function guardarDispositivo()
    {
        $this->validate([
            'codigoDispositivo' => 'required|string',
            'accionDispositivo' => 'required|in:instalado,retirado,reemplazado',
            'ubicacionInstalacion' => 'required|string',
            'ubicacionPersonalizada' => 'required_if:ubicacionInstalacion,OTRO|nullable|string|max:255',
        ], [
            'codigoDispositivo.required' => 'El código es obligatorio',
            'ubicacionInstalacion.required' => 'La ubicación de instalación es obligatoria',
            'ubicacionPersonalizada.required_if' => 'Debes especificar la ubicación personalizada',
        ]);

        try {
            $ubicacion = $this->ubicacionInstalacion === 'OTRO'
                ? $this->ubicacionPersonalizada
                : $this->ubicacionInstalacion;

            $data = [
                'work_order_id' => $this->workOrder->id,
                'vehiculo_id' => $this->workOrder->vehiculo_id,
                'fecha_instalacion' => now(),
                'observaciones' => $this->observacionesDispositivo,
                'ubicacion_instalacion' => $ubicacion,
            ];

            if ($this->tipoDispositivo === 'imei') {
                $data['imei'] = $this->codigoDispositivo;
                $data['accion_imei'] = $this->accionDispositivo;
                $data['accion_sim'] = 'ninguna';
            } else {
                $data['iccid'] = $this->codigoDispositivo;
                $data['numero_linea'] = $this->codigoDispositivo;
                $data['accion_sim'] = $this->accionDispositivo;
                $data['accion_imei'] = 'ninguna';
            }

            $this->workOrder->deviceHistory()->create($data);

            $this->modalDispositivo = false;
            $this->refreshWorkOrder();

            $this->notification()->success(
                title: 'DISPOSITIVO REGISTRADO',
                description: strtoupper($this->tipoDispositivo) . ' ' . $this->accionDispositivo . ' correctamente'
            );
        } catch (\Exception $e) {
            $this->notification()->error(
                title: 'ERROR',
                description: 'No se pudo registrar: ' . $e->getMessage()
            );
        }
    }

    public function abrirModalFirma()
    {
        $this->modalFirma = true;
        $this->nombreFirmante = '';
        $this->tipoFirmante = 'cliente';
        $this->documentoFirmante = '';
        $this->signatureData = null;
    }

    public function guardarFirma()
    {
        $this->validate([
            'nombreFirmante' => 'required|string|max:255',
            'tipoFirmante' => 'required|in:cliente,conductor,encargado,supervisor',
            'signatureData' => 'required',
        ], [
            'nombreFirmante.required' => 'El nombre del firmante es obligatorio',
            'signatureData.required' => 'Debe firmar en el recuadro',
        ]);

        try {
            // Decodificar la firma base64
            $signatureImage = str_replace('data:image/png;base64,', '', $this->signatureData);
            $signatureImage = str_replace(' ', '+', $signatureImage);
            $signatureData = base64_decode($signatureImage);

            // Generar nombre de archivo
            $filename = "firma_conformidad_{$this->workOrder->codigo}_" . time() . ".png";
            $path = "work-orders/{$this->workOrder->id}/signatures/{$filename}";

            // Guardar archivo
            Storage::disk('private')->put($path, $signatureData);

            // Calcular hash
            $hash = hash('sha256', $signatureData);

            // Crear registro en la base de datos
            $this->workOrder->signatures()->create([
                'tipo' => 'conformidad',
                'filename' => $filename,
                'path' => $path,
                'disk' => 'private',
                'nombre_firmante' => $this->nombreFirmante,
                'tipo_firmante' => $this->tipoFirmante,
                'documento_firmante' => $this->documentoFirmante ?: null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'latitude' => null, // Puede obtenerse con JavaScript
                'longitude' => null,
                'firmado_at' => now(),
                'tecnico_id' => Auth::user()->id,
                'hash' => $hash,
            ]);

            $this->modalFirma = false;
            $this->refreshWorkOrder();

            $this->notification()->success(
                title: 'FIRMA GUARDADA',
                description: 'La firma de conformidad se registró correctamente'
            );
        } catch (\Exception $e) {
            $this->notification()->error(
                title: 'ERROR',
                description: 'No se pudo guardar la firma: ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        // Construir timeline
        $timeline = collect();

        // Creación
        $timeline->push([
            'tipo' => 'creacion',
            'titulo' => 'Orden Creada',
            'descripcion' => 'Por ' . ($this->workOrder->creador->name ?? 'Sistema'),
            'fecha' => $this->workOrder->created_at,
            'icono' => 'plus-circle',
            'color' => 'blue',
        ]);

        // Inicio
        if ($this->workOrder->fecha_inicio) {
            $timeline->push([
                'tipo' => 'inicio',
                'titulo' => 'Trabajo Iniciado',
                'descripcion' => 'Técnico comenzó el trabajo',
                'fecha' => $this->workOrder->fecha_inicio,
                'icono' => 'play',
                'color' => 'green',
            ]);
        }

        // Checklist BEFORE
        $checklistBefore = $this->workOrder->checklists->where('fase', 'before');
        if ($checklistBefore->isNotEmpty()) {
            $timeline->push([
                'tipo' => 'checklist_before',
                'titulo' => 'Checklist Inicial Completado',
                'descripcion' => $checklistBefore->count() . ' ítems verificados',
                'fecha' => $checklistBefore->max('created_at'),
                'icono' => 'clipboard-document-check',
                'color' => 'purple',
            ]);
        }

        // Fotos subidas
        foreach ($this->workOrder->photos as $photo) {
            $timeline->push([
                'tipo' => 'foto',
                'titulo' => 'Evidencia Fotográfica',
                'descripcion' => $photo->descripcion ?? 'Foto subida',
                'fecha' => $photo->created_at,
                'icono' => 'camera',
                'color' => 'yellow',
                'data' => $photo,
            ]);
        }

        // Checklist AFTER
        $checklistAfter = $this->workOrder->checklists->where('fase', 'after');
        if ($checklistAfter->isNotEmpty()) {
            $timeline->push([
                'tipo' => 'checklist_after',
                'titulo' => 'Checklist Final Completado',
                'descripcion' => $checklistAfter->count() . ' ítems verificados',
                'fecha' => $checklistAfter->max('created_at'),
                'icono' => 'clipboard-document-check',
                'color' => 'purple',
            ]);
        }

        // Firmas
        foreach ($this->workOrder->signatures as $signature) {
            $timeline->push([
                'tipo' => 'firma',
                'titulo' => 'Firma ' . ucfirst($signature->tipo),
                'descripcion' => 'Por ' . $signature->nombre_firmante,
                'fecha' => $signature->created_at,
                'icono' => 'pencil-square',
                'color' => 'indigo',
                'data' => $signature,
            ]);
        }

        // Finalización
        if ($this->workOrder->fecha_finalizacion) {
            $timeline->push([
                'tipo' => 'finalizacion',
                'titulo' => 'Trabajo Finalizado',
                'descripcion' => 'Trabajo completado exitosamente',
                'fecha' => $this->workOrder->fecha_finalizacion,
                'icono' => 'check-circle',
                'color' => 'green',
            ]);
        }

        // Cierre
        if ($this->workOrder->bloqueado) {
            $timeline->push([
                'tipo' => 'cierre',
                'titulo' => 'Orden Cerrada',
                'descripcion' => 'Orden bloqueada para edición',
                'fecha' => $this->workOrder->updated_at,
                'icono' => 'lock-closed',
                'color' => 'gray',
            ]);
        }

        // Ordenar por fecha
        $timeline = $timeline->sortBy('fecha');

        return view('livewire.admin.work-orders.show', [
            'timeline'   => $timeline,
            'tiposOrden' => WorkOrderType::orderBy('nombre')->get(['id', 'nombre']),
        ]);
    }
}
