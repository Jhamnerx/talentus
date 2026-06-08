<?php

namespace App\Http\Controllers\Api;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use App\Models\DeviceHistory;
use App\Enums\WorkOrderStatus;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderPhoto;
use App\Models\ChecklistTemplate;
use App\Models\Categoria;
use App\Models\Productos;
use App\Models\WorkOrderAccessory;
use App\Models\WorkOrderChecklist;
use App\Models\WorkOrderSignature;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'estado'       => ['nullable', 'string'],
            'tecnico_id'   => ['nullable', 'integer'],
            'search'       => ['nullable', 'string', 'max:100'],
            'fecha_desde'  => ['nullable', 'date'],
            'fecha_hasta'  => ['nullable', 'date', 'after_or_equal:fecha_desde'],
            'per_page'     => ['nullable', 'integer', 'min:5', 'max:100'],
        ]);

        // La app móvil sólo muestra las órdenes del técnico autenticado
        // salvo que se indique otro tecnico_id explícitamente (admin override)
        $tecnicoId = $request->tecnico_id ?? $request->user()->id;

        $ordenes = WorkOrder::query()
            ->with(['tipo', 'vehiculo', 'cliente', 'tecnico'])
            ->tecnico($tecnicoId)
            ->when($request->estado, fn($q) => $q->estado($request->estado))
            ->when($request->fecha_desde, fn($q) => $q->whereDate('fecha_programada', '>=', $request->fecha_desde))
            ->when($request->fecha_hasta, fn($q) => $q->whereDate('fecha_programada', '<=', $request->fecha_hasta))
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->where('codigo', 'like', "%{$search}%")
                        ->orWhereHas('vehiculo', fn($q) => $q->where('placa', 'like', "%{$search}%"))
                        ->orWhere('titulo_proyecto', 'like', "%{$search}%");
                });
            })
            ->orderBy('fecha_programada', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        $ordenes->getCollection()->transform(function ($orden) {
            if ($orden->es_proyecto) {
                $orden->items_count = $orden->items()->count();
            }
            return $orden;
        });

        return response()->json([
            'success' => true,
            'data' => $ordenes,
        ]);
    }

    /**
     * GET /api/work-orders/stats
     * Resumen de órdenes para el dashboard del técnico autenticado.
     */
    public function stats(Request $request)
    {
        $tecnicoId = $request->user()->id;

        $base = WorkOrder::query()->tecnico($tecnicoId);

        $pendientes = (clone $base)->pendientes()->count();
        $enProceso  = (clone $base)->enProceso()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'pendientes'      => $pendientes,
                'en_proceso'      => $enProceso,
                'total_activas'   => $pendientes + $enProceso,
                'finalizadas_hoy' => (clone $base)->finalizadas()
                    ->whereDate('fecha_finalizacion', today())
                    ->count(),
                'finalizadas_mes' => (clone $base)->finalizadas()
                    ->whereMonth('fecha_finalizacion', now()->month)
                    ->whereYear('fecha_finalizacion', now()->year)
                    ->count(),
            ],
        ]);
    }

    public function show(WorkOrder $workOrder)
    {
        $relations = [
            'tipo',
            'vehiculo.cliente',
            'cliente',
            'tecnico',
            'creador',
            'deviceHistory.dispositivo',
            'deviceHistory.simCard',
            'checklists.template',
            'checklists.photos',
            'photos',
            'signatures',
            'accessories.producto',
        ];

        if ($workOrder->es_proyecto) {
            $relations[] = 'items.vehiculo';
            $relations[] = 'items.tipo';
        }

        $workOrder->load($relations);

        $modeloNombre    = null;
        $modeloTecnologia = null;
        $modeloDispId = $workOrder->metadata['modelo_dispositivo_id'] ?? null;
        if ($modeloDispId) {
            $modelo = \App\Models\ModelosDispositivo::find((int) $modeloDispId);
            if ($modelo) {
                $modeloNombre    = trim(strtoupper(($modelo->marca ?? '') . ' ' . ($modelo->modelo ?? '')));
                $modeloTecnologia = $modelo->tecnologia ?? null;
            }
        }

        return response()->json([
            'success' => true,
            'data' => array_merge($workOrder->toArray(), [
                'modelo_dispositivo_nombre'     => $modeloNombre,
                'modelo_dispositivo_tecnologia' => $modeloTecnologia,
            ])
        ]);
    }

    /**
     * PATCH /api/work-orders/{workOrder}
     * Actualiza campos editables desde la app móvil (imei_gps, imei_sim, etc.)
     */
    public function update(Request $request, WorkOrder $workOrder)
    {
        abort_if($workOrder->bloqueado, 422, 'La orden está bloqueada y no puede modificarse.');

        $data = $request->validate([
            'imei'          => ['sometimes', 'nullable', 'string', 'max:20'],
            'iccid'         => ['sometimes', 'nullable', 'string', 'max:22'],
            'observaciones' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'contacto'      => ['sometimes', 'nullable', 'string', 'max:200'],
            'sector'        => ['sometimes', 'nullable', 'string', 'max:200'],
        ]);

        $workOrder->update($data);

        return response()->json(['success' => true, 'data' => $workOrder->fresh()]);
    }

    public function iniciar(WorkOrder $workOrder)
    {
        try {
            $workOrder->iniciar();

            return response()->json([
                'success' => true,
                'message' => 'Orden de trabajo iniciada correctamente',
                'data' => $workOrder->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function finalizar(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'observaciones_final' => 'nullable|string',
        ]);

        try {
            if ($request->observaciones_final) {
                $workOrder->observaciones_final = $request->observaciones_final;
                $workOrder->save();
            }

            $workOrder->finalizar();

            return response()->json([
                'success' => true,
                'message' => 'Orden de trabajo finalizada correctamente',
                'data' => $workOrder->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function cerrar(WorkOrder $workOrder)
    {
        try {
            $workOrder->cerrar();

            return response()->json([
                'success' => true,
                'message' => 'Orden de trabajo cerrada y bloqueada correctamente',
                'data' => $workOrder->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function cancelar(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'motivo_cancelacion' => 'required|string|max:500',
        ]);

        try {
            $workOrder->cancelar($request->motivo_cancelacion);

            return response()->json([
                'success' => true,
                'message' => 'Orden de trabajo cancelada correctamente',
                'data' => $workOrder->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function guardarChecklist(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'checklist_template_id' => 'required|exists:checklist_templates,id',
            'fase' => 'required|in:before,after',
            'resultado' => 'required|in:ok,observado,no_aplica',
            'observaciones' => 'nullable|string',
        ]);

        if (!$workOrder->puedeEditar()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar una orden bloqueada o finalizada'
            ], 422);
        }

        try {
            $checklist = WorkOrderChecklist::updateOrCreate(
                [
                    'work_order_id' => $workOrder->id,
                    'checklist_template_id' => $request->checklist_template_id,
                    'fase' => $request->fase,
                ],
                [
                    'resultado' => $request->resultado,
                    'observaciones' => $request->observaciones,
                    'inspeccionado_at' => now(),
                    'inspeccionado_by' => Auth::user()->id,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Checklist guardado correctamente',
                'data' => $checklist->load('template')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar checklist: ' . $e->getMessage()
            ], 500);
        }
    }

    public function subirFoto(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'foto' => 'required|image|max:5120', // 5MB max
            'tipo' => 'required|in:checklist,general,evidencia',
            'fase' => 'nullable|in:before,after,proceso',
            'work_order_checklist_id' => 'nullable|exists:work_order_checklists,id',
            'descripcion' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if (!$workOrder->puedeEditar()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar una orden bloqueada o finalizada'
            ], 422);
        }

        try {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(
                'work-orders/' . $workOrder->id . '/photos',
                $filename,
                'private'
            );

            $photo = WorkOrderPhoto::create([
                'work_order_id' => $workOrder->id,
                'work_order_checklist_id' => $request->work_order_checklist_id,
                'filename' => $filename,
                'path' => $path,
                'disk' => 'private',
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'tipo' => $request->tipo,
                'fase' => $request->fase,
                'descripcion' => $request->descripcion,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'uploaded_by' => Auth::user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto subida correctamente',
                'data' => $photo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir foto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarFoto(WorkOrderPhoto $photo)
    {
        if (!$photo->workOrder->puedeEditar()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar una orden bloqueada o finalizada'
            ], 422);
        }

        try {
            $photo->eliminarArchivo();
            $photo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar foto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function descargarFoto(WorkOrderPhoto $photo)
    {
        if (!Storage::disk($photo->disk)->exists($photo->path)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::disk($photo->disk)->download($photo->path, $photo->filename);
    }

    public function guardarFirma(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'tipo' => 'required|in:recepcion,conformidad',
            'firma_base64' => 'required|string', // Base64 de la imagen
            'nombre_firmante' => 'required|string|max:255',
            'tipo_firmante' => 'required|string|max:100',
            'documento_firmante' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if (!$workOrder->puedeEditar() && $request->tipo !== 'conformidad') {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar una orden bloqueada o finalizada'
            ], 422);
        }

        try {
            // Verificar si ya existe una firma del mismo tipo
            $existingSignature = WorkOrderSignature::where('work_order_id', $workOrder->id)
                ->where('tipo', $request->tipo)
                ->first();

            if ($existingSignature) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una firma de ' . $request->tipo . ' para esta orden'
                ], 422);
            }

            // Decodificar base64
            $firmaData = $request->firma_base64;
            if (preg_match('/^data:image\/(\w+);base64,/', $firmaData, $type)) {
                $firmaData = substr($firmaData, strpos($firmaData, ',') + 1);
                $type = strtolower($type[1]);
            } else {
                $type = 'png';
            }

            $firmaData = base64_decode($firmaData);

            if ($firmaData === false) {
                throw new \Exception('Datos de firma inválidos');
            }

            // Guardar archivo
            $filename = 'firma_' . $request->tipo . '_' . time() . '.' . $type;
            $path = 'work-orders/' . $workOrder->id . '/signatures/' . $filename;

            Storage::disk('private')->put($path, $firmaData);

            // Crear registro
            $signature = WorkOrderSignature::create([
                'work_order_id' => $workOrder->id,
                'tipo' => $request->tipo,
                'filename' => $filename,
                'path' => $path,
                'disk' => 'private',
                'nombre_firmante' => $request->nombre_firmante,
                'tipo_firmante' => $request->tipo_firmante,
                'documento_firmante' => $request->documento_firmante,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'firmado_at' => now(),
                'tecnico_id' => Auth::user()->id,
            ]);

            // El hash se genera automáticamente en el Observer

            return response()->json([
                'success' => true,
                'message' => 'Firma guardada correctamente',
                'data' => $signature
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar firma: ' . $e->getMessage()
            ], 500);
        }
    }

    public function descargarFirma(WorkOrderSignature $signature)
    {
        if (!Storage::disk($signature->disk)->exists($signature->path)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::disk($signature->disk)->download($signature->path, $signature->filename);
    }

    public function guardarDispositivo(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'dispositivo_id' => 'nullable|exists:dispositivos,id',
            'imei' => 'nullable|string|max:20',
            'accion_imei' => 'required|in:instalado,retirado,reemplazado,ninguna',
            'sim_card_id' => 'nullable|exists:sim_card,id',
            'iccid' => 'nullable|string|max:25',
            'numero_linea' => 'nullable|string|max:20',
            'accion_sim' => 'required|in:instalado,retirado,reemplazado,ninguna',
            'dispositivo_anterior_id' => 'nullable|exists:dispositivos,id',
            'sim_card_anterior_id' => 'nullable|exists:sim_card,id',
            'observaciones' => 'nullable|string',
        ]);

        if (!$workOrder->puedeEditar()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar una orden bloqueada o finalizada'
            ], 422);
        }

        try {
            $history = DeviceHistory::create([
                'work_order_id' => $workOrder->id,
                'vehiculo_id' => $workOrder->vehiculo_id,
                'dispositivo_id' => $request->dispositivo_id,
                'imei' => $request->imei,
                'accion_imei' => $request->accion_imei,
                'sim_card_id' => $request->sim_card_id,
                'iccid' => $request->iccid,
                'numero_linea' => $request->numero_linea,
                'accion_sim' => $request->accion_sim,
                'dispositivo_anterior_id' => $request->dispositivo_anterior_id,
                'sim_card_anterior_id' => $request->sim_card_anterior_id,
                'fecha_instalacion' => in_array($request->accion_imei, ['instalado', 'reemplazado']) ? now() : null,
                'fecha_retiro' => $request->accion_imei === 'retirado' ? now() : null,
                'observaciones' => $request->observaciones,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dispositivo registrado correctamente',
                'data' => $history->load(['dispositivo', 'simCard'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar dispositivo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardarAccesorio(Request $request, WorkOrder $workOrder)
    {
        $request->validate([
            'producto_id' => 'nullable|exists:productos,id',
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cantidad'    => 'required|integer|min:1',
            'accion'      => 'required|in:instalado,retirado,reemplazado',
        ]);

        if (!$workOrder->puedeEditar()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar una orden bloqueada o finalizada'
            ], 422);
        }

        // Validar stock disponible para salidas de almacén
        if ($request->producto_id && in_array($request->accion, ['instalado', 'reemplazado'])) {
            $producto = Productos::withoutGlobalScope(EmpresaScope::class)
                ->where('id', $request->producto_id)
                ->where('empresa_id', $workOrder->empresa_id)
                ->where('tipo', 'producto')
                ->first();

            if ($producto && $producto->stock < $request->cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuficiente. Disponible: {$producto->stock}, solicitado: {$request->cantidad}.",
                ], 422);
            }
        }

        try {
            $accessory = WorkOrderAccessory::create([
                'work_order_id'   => $workOrder->id,
                'producto_id'     => $request->producto_id,
                'nombre'          => $request->nombre,
                'descripcion'     => $request->descripcion,
                'cantidad'        => $request->cantidad,
                'accion'          => $request->accion,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Accesorio guardado correctamente',
                'data' => $accessory->load('producto')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar accesorio: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarAccesorio(WorkOrderAccessory $accessory)
    {
        if (!$accessory->workOrder->puedeEditar()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar una orden bloqueada o finalizada'
            ], 422);
        }

        try {
            $accessory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Accesorio eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar accesorio: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listarChecklist(WorkOrder $workOrder)
    {
        $checklists = $workOrder->checklists()
            ->with('template')
            ->orderBy('fase')
            ->get()
            ->groupBy('fase');

        return response()->json([
            'success' => true,
            'data' => [
                'before' => $checklists->get('before', []),
                'after' => $checklists->get('after', [])
            ]
        ]);
    }

    public function listarFotos(WorkOrder $workOrder)
    {
        $fotos = $workOrder->photos()
            ->with('uploader')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $fotos
        ]);
    }

    public function listarFirmas(WorkOrder $workOrder)
    {
        $firmas = $workOrder->signatures()
            ->with('tecnico')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $firmas
        ]);
    }

    public function listarDispositivos(WorkOrder $workOrder)
    {
        $dispositivos = $workOrder->deviceHistory()
            ->with(['dispositivo', 'simCard', 'dispositivoAnterior', 'simCardAnterior'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $dispositivos
        ]);
    }

    public function listarAccesorios(WorkOrder $workOrder)
    {
        $accesorios = $workOrder->accessories()
            ->with('producto')
            ->get();

        $categoriaAccesorios = Categoria::withoutGlobalScope(EmpresaScope::class)
            ->where('es_accesorios', true)
            ->where('empresa_id', $workOrder->empresa_id)
            ->first();

        $productosDisponibles = collect();
        if ($categoriaAccesorios) {
            $productosDisponibles = Productos::withoutGlobalScope(EmpresaScope::class)
                ->where('empresa_id', $workOrder->empresa_id)
                ->where('categoria_id', $categoriaAccesorios->id)
                ->where('tipo', 'producto')
                ->orderBy('descripcion')
                ->get(['id', 'descripcion', 'valor_unitario', 'stock']);
        }

        $metadata = $workOrder->metadata ?? [];
        $accesoriosRequeridos = $metadata['accesorios'] ?? [];

        return response()->json([
            'success' => true,
            'data' => [
                'items'                 => $accesorios,
                'productos_disponibles' => $productosDisponibles,
                'accesorios_requeridos' => $accesoriosRequeridos,
            ]
        ]);
    }

    public function listarChecklistTemplates()
    {
        $templates = ChecklistTemplate::active()
            ->ordenado()
            ->get()
            ->groupBy('categoria');

        return response()->json([
            'success' => true,
            'data' => $templates
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Ítems del Proyecto (WorkOrderItem)
    // Solo disponibles cuando work_order.es_proyecto = true
    // ─────────────────────────────────────────────────────────────────────

    public function listarItems(WorkOrder $workOrder)
    {
        abort_unless($workOrder->es_proyecto, 422, 'Esta orden no es de tipo proyecto.');

        $items = $workOrder->items()
            ->with(['vehiculo', 'tipo'])
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        $completados = $items->where('estado', 'completado')->count();
        $total       = $items->count();

        return response()->json([
            'success' => true,
            'data' => [
                'items'       => $items,
                'total'       => $total,
                'completados' => $completados,
                'omitidos'    => $items->where('estado', 'omitido')->count(),
                'pendientes'  => $items->where('estado', 'pendiente')->count(),
                'progreso'    => $total > 0 ? round($completados / $total * 100) : 0,
            ],
        ]);
    }

    public function agregarItem(Request $request, WorkOrder $workOrder)
    {
        abort_unless($workOrder->es_proyecto, 422, 'Esta orden no es de tipo proyecto.');
        abort_if($workOrder->bloqueado, 422, 'La orden está bloqueada.');

        $data = $request->validate([
            'placa'              => 'required|string|max:20',
            'work_order_type_id' => 'required|exists:work_order_types,id',
            'notas'              => 'nullable|string|max:500',
        ]);

        $placa    = strtoupper(trim($data['placa']));
        $vehiculo = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('placa', $placa)->first();

        $item = $workOrder->items()->create([
            'vehiculo_id'        => $vehiculo?->id,
            'cliente_id'         => $vehiculo?->clientes_id,
            'placa'              => $placa,
            'cliente_nombre'     => $vehiculo?->cliente?->razon_social,
            'work_order_type_id' => $data['work_order_type_id'],
            'notas'              => $data['notas'] ?? null,
            'estado'             => 'pendiente',
            'orden'              => $workOrder->items()->count(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Unidad {$placa} agregada al proyecto.",
            'data'    => $item->load(['vehiculo', 'tipo']),
        ], 201);
    }

    public function toggleEstadoItem(Request $request, WorkOrder $workOrder, WorkOrderItem $item)
    {
        abort_unless($workOrder->es_proyecto, 422, 'Esta orden no es de tipo proyecto.');
        abort_if($workOrder->bloqueado, 422, 'La orden está bloqueada.');
        abort_if($item->work_order_id !== $workOrder->id, 404, 'Ítem no pertenece a esta orden.');

        $item->estado = match ($item->estado) {
            'pendiente'  => 'completado',
            'completado' => 'omitido',
            default      => 'pendiente',
        };
        $item->save();

        return response()->json([
            'success' => true,
            'data'    => $item->fresh(['vehiculo', 'tipo']),
        ]);
    }

    public function guardarDispositivoItem(Request $request, WorkOrder $workOrder, WorkOrderItem $item)
    {
        abort_unless($workOrder->es_proyecto, 422, 'Esta orden no es de tipo proyecto.');
        abort_if($workOrder->bloqueado, 422, 'La orden está bloqueada.');
        abort_if($item->work_order_id !== $workOrder->id, 404, 'Ítem no pertenece a esta orden.');

        $data = $request->validate([
            'imei'       => 'nullable|string|max:20',
            'numero_sim' => 'nullable|string|max:22',
        ]);

        $item->update([
            'imei'       => trim($data['imei'] ?? '') ?: null,
            'numero_sim' => trim($data['numero_sim'] ?? '') ?: null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dispositivo asignado correctamente.',
            'data'    => $item->fresh(['vehiculo', 'tipo']),
        ]);
    }

    public function eliminarItem(WorkOrder $workOrder, WorkOrderItem $item)
    {
        abort_unless($workOrder->es_proyecto, 422, 'Esta orden no es de tipo proyecto.');
        abort_if($workOrder->bloqueado, 422, 'La orden está bloqueada.');
        abort_if($item->work_order_id !== $workOrder->id, 404, 'Ítem no pertenece a esta orden.');

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unidad eliminada del proyecto.',
        ]);
    }
}
