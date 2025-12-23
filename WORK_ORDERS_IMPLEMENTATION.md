# Módulo de Órdenes de Trabajo - Guía de Implementación

## 📋 Resumen Ejecutivo

Sistema completo de órdenes de trabajo técnicas para gestión de dispositivos GPS, con evidencia fotográfica, firma digital y trazabilidad completa. Diseñado para ser **legalmente defendible** ante reclamos.

## 🏗️ Arquitectura Implementada

### Modelos Creados

1. **WorkOrderType** - Tipos de órdenes configurables
2. **WorkOrder** - Orden principal (núcleo del sistema)
3. **DeviceHistory** - Historial inmutable de dispositivos
4. **ChecklistTemplate** - Catálogo de ítems de inspección
5. **WorkOrderChecklist** - Checklist ejecutado (BEFORE/AFTER)
6. **WorkOrderPhoto** - Evidencias fotográficas con GPS
7. **WorkOrderSignature** - Firmas digitales con hash SHA256
8. **WorkOrderAccessory** - Accesorios instalados/retirados

### Enums Creados

-   `WorkOrderStatus` (pendiente, en_proceso, finalizado, cancelado)
-   `ChecklistResultado` (ok, observado, no_aplica)
-   `ChecklistCategoria` (vehiculo, tablero, luces, accesorios, motor, neumaticos, documentos, otros)

## 🚀 Pasos de Implementación

### 1. Ejecutar Migraciones

```bash
php artisan migrate
```

Esto creará 8 tablas nuevas:

-   `work_order_types`
-   `work_orders`
-   `device_history`
-   `checklist_templates`
-   `work_order_checklists`
-   `work_order_photos`
-   `work_order_signatures`
-   `work_order_accessories`

### 2. Ejecutar Seeders

```bash
php artisan db:seed --class=WorkOrderTypeSeeder
php artisan db:seed --class=ChecklistTemplateSeeder
```

Esto creará:

-   7 tipos de órdenes predefinidas
-   ~20 ítems de checklist categorizados

### 3. Configurar Storage Disk (Importante)

Agregar en `config/filesystems.php`:

```php
'disks' => [
    // ... otros disks

    'private' => [
        'driver' => 'local',
        'root' => storage_path('app/private'),
        'throw' => false,
    ],
],
```

### 4. Agregar Rutas

En `routes/admin.php`:

```php
use App\Http\Controllers\Admin\WorkOrderController;

Route::prefix('work-orders')->name('work-orders.')->group(function () {
    Route::get('/', [WorkOrderController::class, 'index'])->name('index');
    Route::get('/{workOrder}', [WorkOrderController::class, 'show'])->name('show');
    Route::post('/', [WorkOrderController::class, 'store'])->name('store');
    Route::patch('/{workOrder}', [WorkOrderController::class, 'update'])->name('update');

    // Acciones específicas
    Route::post('/{workOrder}/iniciar', [WorkOrderController::class, 'iniciar'])->name('iniciar');
    Route::post('/{workOrder}/finalizar', [WorkOrderController::class, 'finalizar'])->name('finalizar');
    Route::post('/{workOrder}/cerrar', [WorkOrderController::class, 'cerrar'])->name('cerrar');
    Route::post('/{workOrder}/cancelar', [WorkOrderController::class, 'cancelar'])->name('cancelar');

    // Checklist
    Route::post('/{workOrder}/checklist', [WorkOrderController::class, 'guardarChecklist'])->name('checklist.save');

    // Fotos
    Route::post('/{workOrder}/photos', [WorkOrderController::class, 'subirFoto'])->name('photos.upload');
    Route::delete('/photos/{photo}', [WorkOrderController::class, 'eliminarFoto'])->name('photos.delete');

    // Firma
    Route::post('/{workOrder}/signature', [WorkOrderController::class, 'guardarFirma'])->name('signature.save');

    // PDF
    Route::get('/{workOrder}/pdf', [WorkOrderController::class, 'generarPDF'])->name('pdf');
});
```

### 5. Crear Permisos

```php
// En tu seeder de permisos o consola
use Spatie\Permission\Models\Permission;

Permission::create(['name' => 'work-orders.index']);
Permission::create(['name' => 'work-orders.create']);
Permission::create(['name' => 'work-orders.edit']);
Permission::create(['name' => 'work-orders.delete']);
Permission::create(['name' => 'work-orders.iniciar']);
Permission::create(['name' => 'work-orders.finalizar']);
Permission::create(['name' => 'work-orders.cerrar']);
```

## 📱 API para Aplicación Móvil

### Endpoints Principales

#### 1. Listar Órdenes del Técnico

```http
GET /api/work-orders/my-orders
Authorization: Bearer {token}
```

**Respuesta:**

```json
{
    "data": [
        {
            "id": 1,
            "codigo": "OT25-000001",
            "estado": "pendiente",
            "vehiculo": {
                "id": 123,
                "placa": "ABC-123"
            },
            "cliente": {
                "id": 45,
                "razon_social": "Transportes SAC"
            },
            "fecha_programada": "2025-12-22 09:00:00"
        }
    ]
}
```

#### 2. Obtener Detalle de Orden

```http
GET /api/work-orders/{id}
Authorization: Bearer {token}
```

**Respuesta:** Incluye orden completa, checklist templates, fotos, firmas, etc.

#### 3. Iniciar Orden

```http
POST /api/work-orders/{id}/iniciar
Authorization: Bearer {token}
```

Cambia estado a `en_proceso` y registra `fecha_inicio`.

#### 4. Guardar Checklist BEFORE

```http
POST /api/work-orders/{id}/checklist
Authorization: Bearer {token}
Content-Type: application/json

{
  "fase": "before",
  "items": [
    {
      "checklist_template_id": 1,
      "resultado": "ok",
      "observaciones": null
    },
    {
      "checklist_template_id": 2,
      "resultado": "observado",
      "observaciones": "Rayón en puerta lateral"
    }
  ]
}
```

#### 5. Subir Foto

```http
POST /api/work-orders/{id}/photos
Authorization: Bearer {token}
Content-Type: multipart/form-data

foto: (archivo PNG/JPG)
tipo: "checklist" | "general" | "evidencia"
fase: "before" | "after" | "proceso"
descripcion: "Descripción opcional"
work_order_checklist_id: 123 (opcional, si es de un ítem específico)
latitude: -12.0464
longitude: -77.0428
```

**Lógica en servidor:**

```php
public function subirFoto(Request $request, WorkOrder $workOrder)
{
    $request->validate([
        'foto' => 'required|image|max:5120', // 5MB
        'tipo' => 'required|in:checklist,general,evidencia',
        'fase' => 'nullable|in:before,after,proceso',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    $file = $request->file('foto');
    $filename = Str::uuid() . '.' . $file->extension();
    $path = $file->storeAs("work_orders/{$workOrder->id}/photos", $filename, 'private');

    $photo = $workOrder->photos()->create([
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
        'work_order_checklist_id' => $request->work_order_checklist_id,
        'uploaded_by' => auth()->id(),
    ]);

    return response()->json(['success' => true, 'photo' => $photo]);
}
```

#### 6. Guardar Firma Digital

```http
POST /api/work-orders/{id}/signature
Authorization: Bearer {token}
Content-Type: application/json

{
  "tipo": "recepcion" | "conformidad",
  "firma_base64": "data:image/png;base64,iVBORw0KGg...",
  "nombre_firmante": "Juan Pérez",
  "tipo_firmante": "conductor",
  "documento_firmante": "12345678",
  "latitude": -12.0464,
  "longitude": -77.0428
}
```

**Lógica en servidor:**

```php
public function guardarFirma(Request $request, WorkOrder $workOrder)
{
    $request->validate([
        'tipo' => 'required|in:recepcion,conformidad',
        'firma_base64' => 'required|string',
        'nombre_firmante' => 'required|string|max:255',
        'tipo_firmante' => 'required|string|max:100',
        'documento_firmante' => 'nullable|string|max:20',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    // Decodificar base64
    $imageData = $request->firma_base64;
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $decodedImage = base64_decode($imageData);

    // Guardar archivo
    $filename = "{$workOrder->codigo}_{$request->tipo}_" . time() . '.png';
    $path = "work_orders/{$workOrder->id}/signatures/{$filename}";
    Storage::disk('private')->put($path, $decodedImage);

    // Crear registro
    $signature = $workOrder->signatures()->create([
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

    // Generar hash automáticamente (via Observer o aquí)
    $signature->generarHash();

    return response()->json(['success' => true, 'signature' => $signature]);
}
```

#### 7. Finalizar Orden

```http
POST /api/work-orders/{id}/finalizar
Authorization: Bearer {token}
```

Valida que exista firma de conformidad, cambia estado a `finalizado`.

#### 8. Registrar Historial de Dispositivos

```http
POST /api/work-orders/{id}/device-history
Authorization: Bearer {token}
Content-Type: application/json

{
  "vehiculo_id": 123,
  "dispositivo_id": 45,
  "imei": "123456789012345",
  "accion_imei": "instalado",
  "sim_card_id": 67,
  "iccid": "89510000000000000001",
  "numero_linea": "987654321",
  "accion_sim": "instalado",
  "fecha_instalacion": "2025-12-21 10:30:00",
  "observaciones": "Instalado sin problemas"
}
```

## 🔒 Seguridad y Validaciones

### Reglas de Negocio Implementadas

1. **No edición después del cierre**

    ```php
    if ($workOrder->bloqueado) {
        throw new \Exception('Orden bloqueada');
    }
    ```

2. **Firma obligatoria antes de finalizar**

    ```php
    if (!$workOrder->signatures()->where('tipo', 'conformidad')->exists()) {
        throw new \Exception('Requiere firma de conformidad');
    }
    ```

3. **Historial append-only**

    ```php
    // NUNCA usar update() o delete() en DeviceHistory
    DeviceHistory::create([...]); // Solo create()
    ```

4. **Hash de integridad en firmas**
    ```php
    $signature->verificarIntegridad(); // Retorna true/false
    ```

## 📊 Consultas Útiles

### Historial completo de un vehículo

```php
$historial = DeviceHistory::where('vehiculo_id', $vehiculo->id)
    ->with(['workOrder', 'dispositivo', 'simCard'])
    ->orderBy('fecha_instalacion', 'desc')
    ->get();
```

### Órdenes pendientes de un técnico

```php
$ordenes = WorkOrder::where('tecnico_id', $tecnico->id)
    ->pendientes()
    ->with(['vehiculo', 'cliente', 'tipo'])
    ->get();
```

### Checklist incompleto

```php
$pendientes = $workOrder->checklists()
    ->pendiente() // whereNull('resultado')
    ->where('fase', 'before')
    ->with('template')
    ->get();
```

## 🧪 Testing

### Ejemplo de Test

```php
public function test_no_puede_finalizar_sin_firma_conformidad()
{
    $orden = WorkOrder::factory()->create(['estado' => WorkOrderStatus::EN_PROCESO]);

    $this->expectException(\Exception::class);
    $orden->finalizar();
}

public function test_genera_codigo_unico_automaticamente()
{
    $orden = WorkOrder::factory()->create();

    $this->assertNotNull($orden->codigo);
    $this->assertStringStartsWith('OT', $orden->codigo);
}
```

## 📄 Generación de PDF

Crear `app/Http/Controllers/Admin/PDF/WorkOrderPdfController.php`:

```php
public function generate(WorkOrder $workOrder)
{
    $pdf = PDF::loadView('pdf.work-order', [
        'orden' => $workOrder->load([
            'tipo', 'vehiculo', 'cliente', 'tecnico',
            'checklists.template', 'photos', 'signatures', 'deviceHistory'
        ])
    ])->setPaper('a4', 'portrait');

    return $pdf->stream("orden_{$workOrder->codigo}.pdf");
}
```

## 🎯 Próximos Pasos Sugeridos

1. Crear controlador `WorkOrderController` con todos los métodos
2. Implementar API RESTful completa para móvil
3. Crear vistas de detalle con timeline visual
4. Implementar notificaciones push al técnico
5. Agregar soporte offline en app móvil con sincronización
6. Dashboard con KPIs de órdenes (tiempo promedio, tasa de finalización, etc.)
7. Exportar reportes a Excel con filtros avanzados

## 🐛 Troubleshooting

**Problema**: No se guardan las fotos

-   Verificar permisos en `storage/app/private`
-   Ejecutar `php artisan storage:link`

**Problema**: Error al generar hash de firma

-   Verificar que el archivo existe en disk
-   Revisar configuración de `filesystems.php`

**Problema**: No se puede finalizar orden

-   Verificar que existe firma de conformidad
-   Verificar que checklist AFTER está completo

## 📞 Soporte

Para dudas o problemas con la implementación, revisar:

-   `.github/copilot-instructions.md`
-   Logs en `storage/logs/laravel.log`
-   Activity log con `Spatie\Activitylog`
