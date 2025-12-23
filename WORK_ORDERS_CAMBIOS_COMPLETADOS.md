# Work Orders - Resumen de Implementación Completada

## ✅ Cambios Realizados

### 1. WorkOrderObserver - Generación de Código por ID

-   **Archivo**: `app/Observers/WorkOrderObserver.php`
-   **Cambio**: El código ahora se genera **después** de crear el registro, usando el ID: `OT25-000001`
-   **Lógica**: `'OT' . date('y') . '-' . str_pad($workOrder->id, 6, '0', STR_PAD_LEFT)`
-   **Snapshot de Tipo**: Se guarda automáticamente `tipo_data` JSON con costos y configuración al crear la orden

### 2. Campo tipo_data JSON

-   **Archivo**: `database/migrations/2025_12_21_000002_create_work_orders_table.php`
-   **Propósito**: Preservar costos del tipo de orden aunque se editen posteriormente
-   **Estructura JSON**:
    ```json
    {
        "nombre": "Instalación GPS",
        "descripcion": "...",
        "costo_base": 150.0,
        "requiere_imei": true,
        "requiere_sim": true,
        "requiere_accesorios": false,
        "requiere_checklist": true
    }
    ```

### 3. Disk Private Configurado

-   **Archivo**: `config/filesystems.php`
-   **Configuración**:
    ```php
    'private' => [
        'driver' => 'local',
        'root' => storage_path('app/private'),
        'visibility' => 'private',
        'throw' => false,
    ],
    ```
-   **Uso**: Almacenar firmas digitales y fotos sensibles

### 4. Rutas Agregadas

-   **Archivo**: `routes/admin.php`
-   **Rutas implementadas**:
    -   `GET /work-orders` - Listado
    -   `GET /work-orders/{workOrder}` - Detalle con timeline
    -   `POST /work-orders/{workOrder}/iniciar` - Iniciar orden
    -   `POST /work-orders/{workOrder}/finalizar` - Finalizar orden
    -   `POST /work-orders/{workOrder}/cerrar` - Cerrar y bloquear
    -   `POST /work-orders/{workOrder}/cancelar` - Cancelar orden
    -   `POST /work-orders/{workOrder}/checklist` - Guardar checklist
    -   `POST /work-orders/{workOrder}/fotos` - Subir foto
    -   `DELETE /fotos/{photo}` - Eliminar foto
    -   `POST /work-orders/{workOrder}/firmas` - Guardar firma
    -   `POST /work-orders/{workOrder}/dispositivos` - Guardar dispositivo
    -   `POST /work-orders/{workOrder}/accesorios` - Guardar accesorio
    -   `GET /work-orders/{workOrder}/pdf` - Generar PDF

### 5. WorkOrderController Completo

-   **Archivo**: `app/Http/Controllers/Admin/WorkOrderController.php`
-   **Métodos API implementados**:
    -   `index()` - Vista principal
    -   `show()` - Detalle con todas las relaciones cargadas
    -   `iniciar()` - Valida y ejecuta `$workOrder->iniciar()`
    -   `finalizar()` - Valida firma conformidad y finaliza
    -   `cerrar()` - Bloquea permanentemente la orden
    -   `cancelar()` - Cancela con motivo obligatorio
    -   `guardarChecklist()` - Guarda inspección BEFORE/AFTER
    -   `subirFoto()` - Sube imagen a disk private con metadata GPS
    -   `eliminarFoto()` - Valida permisos y elimina archivo
    -   `descargarFoto()` - Descarga protegida
    -   `guardarFirma()` - Decodifica base64, guarda PNG, genera hash SHA256
    -   `descargarFirma()` - Descarga protegida
    -   `guardarDispositivo()` - Registra en DeviceHistory (append-only)
    -   `guardarAccesorio()` - Crea WorkOrderAccessory con cálculo automático
    -   `eliminarAccesorio()` - Valida permisos y elimina

### 6. Vistas Implementadas

#### `resources/views/admin/work-orders/index.blade.php`

-   Cards de resumen (Pendientes, En Proceso, Finalizadas, Canceladas)
-   Integración con Livewire Tabla component
-   Header con botón "Nueva Orden de Trabajo"

#### `resources/views/admin/work-orders/show.blade.php`

-   **Layout de 2 columnas**:
    -   Columna principal (8/12):
        -   Información general del trabajo
        -   Timeline visual de progreso
        -   Checklist BEFORE/AFTER en grid
        -   Historial de dispositivos
        -   Tabla de accesorios con totales
    -   Columna lateral (4/12):
        -   Acciones según estado (Iniciar, Finalizar, Cerrar, Cancelar)
        -   Evidencia fotográfica (grid)
        -   Firmas digitales con verificación de integridad
        -   Observaciones (inicial, técnico, final)
        -   Botón descarga PDF

### 7. Controlador PDF

-   **Archivo**: `app/Http/Controllers/Admin/PDF/WorkOrderPdfController.php`
-   **Vista PDF**: `resources/views/admin/pdf/work-order.blade.php`
-   **Características**:
    -   Diseño profesional con estilos CSS inline
    -   Timeline de progreso
    -   Tablas de checklist, dispositivos, accesorios
    -   Información de firmas digitales con estado de verificación
    -   Footer con fecha de generación

## 🔄 Diferencias con Tareas (Módulo Antiguo)

| Aspecto                    | Tareas               | Work Orders                            |
| -------------------------- | -------------------- | -------------------------------------- |
| **Código**                 | Manual o IdGenerator | Automático basado en ID: OT25-000001   |
| **Soft Delete**            | ✅ Sí                | ✅ Sí (admin puede borrar)             |
| **Bloqueo**                | No tiene             | Campo `bloqueado` para impedir edición |
| **Costos**                 | No preserva          | JSON `tipo_data` preserva costos       |
| **Historial Dispositivos** | Sobrescribe          | DeviceHistory append-only (inmutable)  |
| **Firmas**                 | No tiene             | Hash SHA256 + metadata GPS/IP          |
| **Checklist**              | No tiene             | Dinámico BEFORE/AFTER con fotos        |
| **Fotos**                  | Campo texto          | Tabla completa con GPS + disk private  |

## 📋 Próximos Pasos Sugeridos

### Paso 1: Ejecutar Migraciones

```bash
php artisan migrate
```

### Paso 2: Ejecutar Seeders

```bash
php artisan db:seed --class=ChecklistTemplateSeeder
php artisan db:seed --class=WorkOrderTypeSeeder
```

### Paso 3: Crear Directorio Private

```bash
mkdir storage/app/private
```

### Paso 4: Configurar Permisos (Opcional)

Agregar permisos Spatie para work orders:

```php
Permission::create(['name' => 'work-orders.index']);
Permission::create(['name' => 'work-orders.create']);
Permission::create(['name' => 'work-orders.edit']);
Permission::create(['name' => 'work-orders.delete']);
```

### Paso 5: Agregar al Menú Administrativo

En el archivo de navegación, agregar enlace:

```blade
<x-nav-link href="{{ route('admin.work-orders.index') }}" :active="request()->routeIs('admin.work-orders.*')">
    <x-icon name="clipboard-list" class="w-5 h-5" />
    Órdenes de Trabajo
</x-nav-link>
```

## 🎯 Funcionalidades Listas para Usar

### Para Técnicos

-   ✅ Ver órdenes asignadas
-   ✅ Iniciar trabajo con un clic
-   ✅ Completar checklist BEFORE/AFTER
-   ✅ Subir fotos con GPS
-   ✅ Registrar dispositivos instalados/retirados
-   ✅ Agregar accesorios con precios
-   ✅ Finalizar con firma digital del cliente

### Para Administradores

-   ✅ Crear órdenes de trabajo
-   ✅ Asignar técnicos
-   ✅ Ver timeline completo
-   ✅ Cerrar y bloquear órdenes finalizadas
-   ✅ Cancelar con motivo
-   ✅ Generar PDF para cliente
-   ✅ Verificar integridad de firmas (SHA256)
-   ✅ Auditar historial inmutable de dispositivos

### Para Clientes (Futuro)

-   🔜 Portal para ver estado de orden
-   🔜 Notificaciones WhatsApp de progreso
-   🔜 Descarga de PDF con firma digital

## 🔐 Seguridad Implementada

1. **Campo bloqueado**: Impide edición después de cerrar
2. **Soft Deletes**: Admin puede recuperar órdenes borradas
3. **Observer validación**: Lanza excepción al editar orden bloqueada
4. **Firmas SHA256**: Verificación de integridad
5. **Metadata legal**: IP, User-Agent, GPS en firmas
6. **Disk private**: Fotos y firmas no públicas
7. **tipo_data JSON**: Preserva costos aunque se editen tipos

## 📊 Modelo de Datos por Técnico (Nueva Funcionalidad)

Para costos diferentes por técnico, se puede implementar:

```php
// Migración adicional (opcional):
Schema::create('work_order_type_technician_prices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('work_order_type_id')->constrained();
    $table->foreignId('tecnico_id')->constrained('users');
    $table->decimal('costo_tecnico', 10, 2);
    $table->timestamps();

    $table->unique(['work_order_type_id', 'tecnico_id']);
});
```

Al crear la orden:

```php
$costoTecnico = WorkOrderTypeTechnicianPrice::where([
    'work_order_type_id' => $request->work_order_type_id,
    'tecnico_id' => $request->tecnico_id
])->first();

$workOrder->tipo_data['costo_tecnico'] = $costoTecnico?->costo_tecnico ?? $tipo->costo_base;
```

## ✨ Ventajas del Sistema Implementado

1. **Auditable**: Historial inmutable de dispositivos
2. **Legal**: Firmas verificables con SHA256
3. **Flexible**: Checklist dinámico por empresa
4. **Escalable**: JSON metadata permite extensiones
5. **Robusto**: Validaciones en Observer + Controller
6. **Trazable**: Timeline completo con fechas
7. **Seguro**: Archivos en disk private
8. **Profesional**: PDF con diseño corporativo

---

**Implementación completada el**: {{ now()->format('d/m/Y H:i') }}
**Módulo listo para**: Producción (ejecutar migraciones y seeders)
