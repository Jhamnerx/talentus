<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WorkOrderController;
use App\Http\Controllers\Api\ConsultasApiController;
use App\Http\Controllers\Api\ContactoApiController;
use App\Http\Controllers\Api\MobileAuthController;
use App\Http\Controllers\Api\WorkOrderTrackingController;
use App\Http\Controllers\Api\PublicWorkOrderController;

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
| Autenticación Móvil (Técnicos)
|--------------------------------------------------------------------------
| Endpoints de autenticación para la app móvil de técnicos.
| El login devuelve un Bearer token Sanctum de larga duración.
| No requieren autenticación previa.
*/

Route::prefix('auth')->name('api.auth.')->group(function () {
    // POST /api/auth/login
    Route::post('login', [MobileAuthController::class, 'login'])->name('login');
});

Route::prefix('auth')->name('api.auth.')->middleware('auth:sanctum')->group(function () {
    // POST /api/auth/logout
    Route::post('logout', [MobileAuthController::class, 'logout'])->name('logout');

    // GET /api/auth/me
    Route::get('me', [MobileAuthController::class, 'me'])->name('me');
});

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
| ENDPOINTS PÚBLICOS (sin autenticación)
|--------------------------------------------------------------------------
| Usados por talentus-web para verificación de órdenes de trabajo.
*/

Route::prefix('public')->name('api.public.')->group(function () {
    Route::get('work-orders/{hash}', [PublicWorkOrderController::class, 'show'])->name('work-orders.show');
    Route::post('work-orders/{hash}/verify', [PublicWorkOrderController::class, 'verify'])->name('work-orders.verify');
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

    // PATCH /api/work-orders/{workOrder}
    // Actualizar campos editables desde la app móvil (imei_gps, imei_sim, contacto, etc.)
    Route::patch('/{workOrder}', [WorkOrderController::class, 'update'])->name('update');

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

    /*
    |--------------------------------------------------------------------------
    | Ítems del Proyecto (WorkOrderItem)
    |--------------------------------------------------------------------------
    | Solo disponibles cuando work_order.es_proyecto = true
    | Cada ítem representa un vehículo dentro del proyecto
    */

    // GET /api/work-orders/{workOrder}/items
    // Listar todos los ítems del proyecto con estado e info de dispositivo
    Route::get('/{workOrder}/items', [WorkOrderController::class, 'listarItems'])->name('items.listar');

    // POST /api/work-orders/{workOrder}/items
    // Agregar un vehículo al proyecto
    // Body: { "placa": "ABC-123", "work_order_type_id": 1, "notas": "string" }
    Route::post('/{workOrder}/items', [WorkOrderController::class, 'agregarItem'])->name('items.agregar');

    // PATCH /api/work-orders/{workOrder}/items/{item}/estado
    // Cambiar estado del ítem: pendiente → completado → omitido → pendiente
    Route::patch('/{workOrder}/items/{item}/estado', [WorkOrderController::class, 'toggleEstadoItem'])->name('items.estado');

    // PATCH /api/work-orders/{workOrder}/items/{item}/dispositivo
    // Asignar IMEI y/o SIM a un vehículo del proyecto
    // Body: { "imei": "string", "numero_sim": "string" }
    Route::patch('/{workOrder}/items/{item}/dispositivo', [WorkOrderController::class, 'guardarDispositivoItem'])->name('items.dispositivo');

    // DELETE /api/work-orders/{workOrder}/items/{item}
    // Eliminar un ítem del proyecto (solo si la orden no está bloqueada)
    Route::delete('/{workOrder}/items/{item}', [WorkOrderController::class, 'eliminarItem'])->name('items.eliminar');

    /*
    |--------------------------------------------------------------------------
    | Tracking GPS del Técnico
    |--------------------------------------------------------------------------
    */

    // POST /api/work-orders/{workOrder}/tracking
    // El técnico envía su posición GPS cada ~1 minuto
    // Body: { "lat": numeric, "lng": numeric, "accuracy": numeric, "speed": numeric }
    Route::post('/{workOrder}/tracking', [WorkOrderTrackingController::class, 'update'])->name('tracking');

    // PATCH /api/work-orders/{workOrder}/ubicacion
    // El administrador establece la ubicación del servicio
    // Body: { "lat": numeric, "lng": numeric, "direccion": "string" }
    Route::patch('/{workOrder}/ubicacion', [WorkOrderTrackingController::class, 'setUbicacion'])->name('ubicacion');
});

/*
|--------------------------------------------------------------------------
| CONSULTAS PÚBLICAS API
|--------------------------------------------------------------------------
| API pública para consultar documentos (actas, certificados) por código.
| Estas rutas son públicas y no requieren autenticación.
*/

Route::prefix('consultas')->name('api.consultas.')->group(function () {
    // GET /api/consultas/acta/{codigo}
    // Buscar acta por código
    // Respuesta: { "success": true, "data": { "acta": {...}, "vehiculo": {...}, "cliente": {...} } }
    Route::get('/acta/{codigo}', [ConsultasApiController::class, 'buscarActa'])->name('acta');

    // GET /api/consultas/certificado-gps/{codigo}
    // Buscar certificado GPS por código
    // Respuesta: { "success": true, "data": { "certificado": {...}, "vehiculo": {...}, "cliente": {...} } }
    Route::get('/certificado-gps/{codigo}', [ConsultasApiController::class, 'buscarCertificadoGps'])->name('certificado.gps');

    // GET /api/consultas/certificado-velocimetro/{codigo}
    // Buscar certificado de velocímetro por código
    // Respuesta: { "success": true, "data": { "certificado": {...}, "vehiculo": {...}, "cliente": {...} } }
    Route::get('/certificado-velocimetro/{codigo}', [ConsultasApiController::class, 'buscarCertificadoVelocimetro'])->name('certificado.velocimetro');

    // GET /api/consultas/transmision/{placa}
    // Consultar si un vehículo está transmitiendo
    // Respuesta: { "success": true, "data": { "vehiculo": {...}, "dispositivo": {...}, "transmitiendo": bool } }
    Route::get('/transmision/{placa}', [ConsultasApiController::class, 'consultarTransmision'])->name('transmision');

    // GET /api/consultas/acta/{codigo}/pdf
    // Obtener PDF de acta en base64
    Route::get('/acta/{codigo}/pdf', [ConsultasApiController::class, 'obtenerPdfActa'])->name('acta.pdf');

    // GET /api/consultas/contrato/{hash}/pdf
    // Obtener PDF de contrato en base64
    Route::get('/contrato/{hash}/pdf', [ConsultasApiController::class, 'obtenerPdfContrato'])->name('contrato.pdf');
});

/*
|--------------------------------------------------------------------------
| CONTACTO API
|--------------------------------------------------------------------------
| API pública para recibir mensajes de contacto desde la web.
*/

// POST /api/contacto
// Recibir mensaje de contacto
// Body: { "name": "...", "email": "...", "phone": "...", "company": "...", "message": "...", "g-recaptcha-response": "..." }
// Respuesta: { "success": true, "message": "Mensaje enviado correctamente" }
Route::post('/contacto', [ContactoApiController::class, 'store'])->name('api.contacto.store');

/*
|--------------------------------------------------------------------------
| TRACKING SYSTEM API — Integración con talentus-pro-tracking
|--------------------------------------------------------------------------
| Recibe registros de mantenimiento/suspensión/reactivación desde
| el sistema de tracking GPS. Autenticación via X-API-KEY header.
*/

Route::prefix('tracking')->name('api.tracking.')->group(function () {
    // POST /api/tracking/device-maintenances/sync
    // Recibe un lote de registros desde talentus-pro-tracking
    // Header: X-API-KEY: {TRACKING_API_KEY}
    Route::post('/device-maintenances/sync', [\App\Http\Controllers\Api\DeviceMaintenanceController::class, 'sync'])
        ->name('device-maintenances.sync');

    // GET /api/tracking/device-maintenances
    // Lista paginada (uso interno)
    Route::get('/device-maintenances', [\App\Http\Controllers\Api\DeviceMaintenanceController::class, 'index'])
        ->name('device-maintenances.index')
        ->middleware('auth:sanctum');
});
