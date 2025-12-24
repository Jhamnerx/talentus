<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SelectsController;
use App\Http\Controllers\Api\WorkOrderController;
use App\Http\Controllers\Admin\UtilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| Autenticación de Usuario
|--------------------------------------------------------------------------
| Obtiene los datos del usuario autenticado mediante token Sanctum.
| Header requerido: Authorization: Bearer {token}
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| FCM TOKENS API
|--------------------------------------------------------------------------
| API para gestionar tokens de Firebase Cloud Messaging (notificaciones push)
*/

Route::middleware('auth:sanctum')->prefix('fcm')->name('api.fcm.')->group(function () {
    Route::post('token', [App\Http\Controllers\Api\FcmTokenController::class, 'store'])->name('token.store');
    Route::delete('token', [App\Http\Controllers\Api\FcmTokenController::class, 'destroy'])->name('token.destroy');
});

/*
|--------------------------------------------------------------------------
| WORK ORDERS API
|--------------------------------------------------------------------------
| API REST para gestión de órdenes de trabajo técnicas.
| Todas las rutas requieren autenticación con Laravel Sanctum.
| 
| AUTENTICACIÓN:
| Header: Authorization: Bearer {token}
| Header: Accept: application/json
|
| DOCUMENTACIÓN COMPLETA: Ver WORK_ORDERS_API_DOCS.md
|--------------------------------------------------------------------------
*/

Route::prefix('work-orders')->name('api.work-orders.')->middleware(['auth:sanctum'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Listado y Detalle de Órdenes
    |--------------------------------------------------------------------------
    */

    // GET /api/work-orders
    // Listar órdenes con filtros: ?estado=pendiente&tecnico_id=1&search=OT25&per_page=15
    Route::get('/', [WorkOrderController::class, 'index'])->name('index');

    // GET /api/work-orders/{workOrder}
    // Ver detalle completo de una orden con todas sus relaciones cargadas
    Route::get('/{workOrder}', [WorkOrderController::class, 'show'])->name('show');

    /*
    |--------------------------------------------------------------------------
    | Acciones de Estado
    |--------------------------------------------------------------------------
    | Cambios de estado del flujo de trabajo:
    | pendiente -> en_proceso -> finalizado -> cerrado (bloqueado)
    */

    // POST /api/work-orders/{workOrder}/iniciar
    // Inicia una orden pendiente (cambia estado a en_proceso)
    Route::post('/{workOrder}/iniciar', [WorkOrderController::class, 'iniciar'])->name('iniciar');

    // POST /api/work-orders/{workOrder}/finalizar
    // Finaliza orden en proceso (requiere firma de conformidad)
    // Body: { "observaciones_final": "string" }
    Route::post('/{workOrder}/finalizar', [WorkOrderController::class, 'finalizar'])->name('finalizar');

    // POST /api/work-orders/{workOrder}/cerrar
    // Cierra y bloquea permanentemente una orden finalizada
    Route::post('/{workOrder}/cerrar', [WorkOrderController::class, 'cerrar'])->name('cerrar');

    // POST /api/work-orders/{workOrder}/cancelar
    // Cancela una orden (requiere motivo)
    // Body: { "motivo_cancelacion": "string" } *requerido
    Route::post('/{workOrder}/cancelar', [WorkOrderController::class, 'cancelar'])->name('cancelar');

    /*
    |--------------------------------------------------------------------------
    | Checklist de Inspección
    |--------------------------------------------------------------------------
    | Inspección del vehículo ANTES y DESPUÉS del trabajo
    */

    // GET /api/work-orders/templates/checklist
    // Obtener plantillas de checklist agrupadas por categoría
    // Respuesta: { vehiculo: [...], tablero: [...], luces: [...] }
    Route::get('/templates/checklist', [WorkOrderController::class, 'listarChecklistTemplates'])->name('templates.checklist');

    // GET /api/work-orders/{workOrder}/checklist
    // Listar checklist completado agrupado por fase (before/after)
    Route::get('/{workOrder}/checklist', [WorkOrderController::class, 'listarChecklist'])->name('checklist.listar');

    // POST /api/work-orders/{workOrder}/checklist
    // Guardar ítem de checklist
    // Body: { "checklist_template_id": 1, "fase": "before|after", "resultado": "ok|observado|no_aplica", "observaciones": "string" }
    Route::post('/{workOrder}/checklist', [WorkOrderController::class, 'guardarChecklist'])->name('checklist.guardar');

    /*
    |--------------------------------------------------------------------------
    | Evidencia Fotográfica
    |--------------------------------------------------------------------------
    | Fotos almacenadas en disco privado con metadata GPS
    */

    // GET /api/work-orders/{workOrder}/fotos
    // Listar todas las fotos de la orden
    Route::get('/{workOrder}/fotos', [WorkOrderController::class, 'listarFotos'])->name('fotos.listar');

    // POST /api/work-orders/{workOrder}/fotos
    // Subir foto (multipart/form-data)
    // Fields: foto (file, max 5MB), tipo (checklist|general|evidencia), fase (before|after|proceso), 
    //         descripcion (string), latitude (numeric), longitude (numeric)
    Route::post('/{workOrder}/fotos', [WorkOrderController::class, 'subirFoto'])->name('fotos.subir');

    // DELETE /api/work-orders/fotos/{photo}
    // Eliminar foto (solo si orden no está bloqueada)
    Route::delete('/fotos/{photo}', [WorkOrderController::class, 'eliminarFoto'])->name('fotos.eliminar');

    // GET /api/work-orders/fotos/{photo}/download
    // Descargar archivo de foto desde storage privado
    Route::get('/fotos/{photo}/download', [WorkOrderController::class, 'descargarFoto'])->name('fotos.descargar');

    /*
    |--------------------------------------------------------------------------
    | Firmas Digitales
    |--------------------------------------------------------------------------
    | Firmas con hash SHA256 y metadata legal (IP, GPS, User-Agent)
    | Tipos: recepcion (inicio) y conformidad (finalización)
    */

    // GET /api/work-orders/{workOrder}/firmas
    // Listar firmas digitales con verificación de integridad
    Route::get('/{workOrder}/firmas', [WorkOrderController::class, 'listarFirmas'])->name('firmas.listar');

    // POST /api/work-orders/{workOrder}/firmas
    // Guardar firma digital
    // Body: { "tipo": "recepcion|conformidad", "firma_base64": "data:image/png;base64,...",
    //         "nombre_firmante": "string", "tipo_firmante": "conductor|cliente|encargado", 
    //         "documento_firmante": "string", "latitude": numeric, "longitude": numeric }
    Route::post('/{workOrder}/firmas', [WorkOrderController::class, 'guardarFirma'])->name('firmas.guardar');

    // GET /api/work-orders/firmas/{signature}/download
    // Descargar archivo PNG de firma desde storage privado
    Route::get('/firmas/{signature}/download', [WorkOrderController::class, 'descargarFirma'])->name('firmas.descargar');

    /*
    |--------------------------------------------------------------------------
    | Historial de Dispositivos GPS/SIM
    |--------------------------------------------------------------------------
    | Registro inmutable (append-only) de instalaciones/retiros
    */

    // GET /api/work-orders/{workOrder}/dispositivos
    // Listar historial de dispositivos GPS y SIM cards
    Route::get('/{workOrder}/dispositivos', [WorkOrderController::class, 'listarDispositivos'])->name('dispositivos.listar');

    // POST /api/work-orders/{workOrder}/dispositivos
    // Registrar instalación/retiro de GPS y/o SIM
    // Body: { "dispositivo_id": int, "imei": "string", "accion_imei": "instalado|retirado|reemplazado|ninguna",
    //         "sim_card_id": int, "iccid": "string", "numero_linea": "string", "accion_sim": "instalado|retirado|reemplazado|ninguna",
    //         "dispositivo_anterior_id": int, "sim_card_anterior_id": int, "observaciones": "string" }
    Route::post('/{workOrder}/dispositivos', [WorkOrderController::class, 'guardarDispositivo'])->name('dispositivos.guardar');

    /*
    |--------------------------------------------------------------------------
    | Accesorios Instalados
    |--------------------------------------------------------------------------
    | Accesorios con cálculo automático de subtotales
    */

    // GET /api/work-orders/{workOrder}/accesorios
    // Listar accesorios con total calculado
    // Respuesta: { "items": [...], "total": 150.00 }
    Route::get('/{workOrder}/accesorios', [WorkOrderController::class, 'listarAccesorios'])->name('accesorios.listar');

    // POST /api/work-orders/{workOrder}/accesorios
    // Agregar accesorio instalado/retirado
    // Body: { "producto_id": int, "nombre": "string", "descripcion": "string", "cantidad": int,
    //         "serial": "string", "accion": "instalado|retirado|reemplazado", "precio_unitario": numeric }
    Route::post('/{workOrder}/accesorios', [WorkOrderController::class, 'guardarAccesorio'])->name('accesorios.guardar');

    // DELETE /api/work-orders/accesorios/{accessory}
    // Eliminar accesorio (solo si orden no está bloqueada)
    Route::delete('/accesorios/{accessory}', [WorkOrderController::class, 'eliminarAccesorio'])->name('accesorios.eliminar');
});
