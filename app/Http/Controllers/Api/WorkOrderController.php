<?php

namespace App\Http\Controllers\Api;

use App\Models\WorkOrder;
use App\Models\WorkOrderPhoto;
use App\Models\WorkOrderSignature;
use App\Models\WorkOrderAccessory;
use App\Models\WorkOrderChecklist;
use App\Models\DeviceHistory;
use App\Models\ChecklistTemplate;
use App\Enums\WorkOrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $ordenes = WorkOrder::query()
            ->with(['tipo', 'vehiculo', 'cliente', 'tecnico'])
            ->when($request->estado, fn($q) => $q->estado($request->estado))
            ->when($request->tecnico_id, fn($q) => $q->tecnico($request->tecnico_id))
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->where('codigo', 'like', "%{$search}%")
                        ->orWhereHas('vehiculo', fn($q) => $q->where('placa', 'like', "%{$search}%"));
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $ordenes
        ]);
    }

    public function show(WorkOrder $workOrder)
    {
        $workOrder->load([
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
            'accessories.producto'
        ]);

        return response()->json([
            'success' => true,
            'data' => $workOrder
        ]);
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
                    'inspeccionado_by' => auth()->id(),
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
                'uploaded_by' => auth()->id(),
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
                'tecnico_id' => auth()->id(),
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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer|min:1',
            'serial' => 'nullable|string|max:100',
            'accion' => 'required|in:instalado,retirado,reemplazado',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        if (!$workOrder->puedeEditar()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar una orden bloqueada o finalizada'
            ], 422);
        }

        try {
            $accessory = WorkOrderAccessory::create([
                'work_order_id' => $workOrder->id,
                'producto_id' => $request->producto_id,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'cantidad' => $request->cantidad,
                'serial' => $request->serial,
                'accion' => $request->accion,
                'precio_unitario' => $request->precio_unitario,
                // El subtotal se calcula automáticamente en el Observer
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

        $total = $accesorios->sum('subtotal');

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $accesorios,
                'total' => $total
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
}
