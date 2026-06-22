# Post-Venta: Mensajes Automáticos WhatsApp

**Fecha:** 2026-06-12  
**Área:** Post-Venta / Work Orders  
**Estado:** Aprobado — listo para implementación

---

## Resumen

Cuando un administrador cierra y bloquea una Orden de Trabajo (OT), el sistema:

1. Envía automáticamente un mensaje WhatsApp de bienvenida al contacto gerente del cliente, usando la plantilla configurada para el sector del vehículo.
2. Cada mañana envía un resumen diario de las OTs cerradas el día anterior a todos los usuarios con rol post-venta o ventas.

---

## 1. Modelo de Datos

### 1a. Modificación a `devices`

Agregar columna `es_postventa` (boolean, nullable, default `false`).

- Solo un device por empresa puede tener `es_postventa = true` a la vez.
- Al activarlo desde la UI, el componente desactiva los demás devices de esa empresa.
- El device con `interno = true` (ya existente) se usa para el resumen diario interno.
- El device con `es_postventa = true` se usa para mensajes al cliente.

### 1b. Nueva tabla `postventa_plantillas`

```
id                  bigint PK
empresa_id          FK empresas (con EmpresaScope)
sector_id           FK sectores, nullable  ← null = plantilla por defecto
cuerpo              text                   ← soporta variables: {placa} {cliente} {fecha_instalacion} {fecha_cierre}
archivo_url         string nullable        ← ruta en storage/app/public/postventa/
archivo_tipo        enum('pdf','video') nullable
activo              boolean default true
created_at / updated_at
```

**Resolución de plantilla en runtime:**

1. Busca plantilla activa con `sector_id = {sector del vehículo}` y `empresa_id` coincidente.
2. Si no existe → busca plantilla activa con `sector_id = null` (default).
3. Si tampoco → log warning, no se envía mensaje al cliente (sin fallo visible).

### 1c. Modelo `PostventaPlantilla`

- `app/Models/PostventaPlantilla.php`
- Aplica `EmpresaScope` global.
- `casts`: `activo → boolean`, `archivo_tipo → string`.
- Relaciones: `belongsTo Sector`, `belongsTo Empresa`.

---

## 2. Pipeline Evento → Listener → Jobs

### Disparo del evento

En `app/Models/WorkOrder.php`, método `cerrar()`, al final:

```php
event(new \App\Events\WorkOrderCerrada($this));
```

### Evento `WorkOrderCerrada`

- `app/Events/WorkOrderCerrada.php`
- Payload: `WorkOrder $workOrder`
- Implementa `ShouldBroadcast`: no. Solo evento interno.

### Listener `EnviarMensajePostventaListener`

- `app/Listeners/EnviarMensajePostventaListener.php`
- Implementa `ShouldQueue` (async, no bloquea al admin).
- Lógica:
  1. Busca `Device` con `es_postventa = true` cuyo `user->empresa_id` coincida con la OT (Device no tiene empresa_id propio; se filtra vía `whereHas('user', fn($q) => $q->where('empresa_id', $workOrder->empresa_id))`).
  2. Si no hay device activo → `Log::warning(...)`, return.
  3. Despacha `EnviarMensajeClienteJob::dispatch($workOrder, $device)`.
- Registrado en `app/Providers/EventServiceProvider.php`.

### Job `EnviarMensajeClienteJob`

- `app/Jobs/EnviarMensajeClienteJob.php`
- Constructor: `WorkOrder $workOrder`, `Device $device`
- Reintentos: `public $tries = 3`, `public $backoff = [30, 60, 120]`
- Lógica del `handle()`:
  1. **Destinatarios:** carga `$workOrder->cliente->contactos()->where('is_gerente', true)->get()`. Si vacío, usa `[$workOrder->cliente->telefono]`. Si ambos vacíos → log warning, return.
  2. **Plantilla:** `WorkOrder::sector` es un string con nombres de sectores separados por comas. Se parsea el primer nombre, se busca el `Sector` por nombre y `empresa_id`, y se usa su `id` para la consulta de plantilla. Fallback a `sector_id = null` si no hay coincidencia o el campo está vacío. Si no hay plantilla → log warning, return.
  3. **Variables:** reemplaza `{placa}`, `{cliente}`, `{fecha_instalacion}`, `{fecha_cierre}` en `$plantilla->cuerpo`.
  4. **Envío:** para cada número destino:
     - Si `$plantilla->archivo_url` → `WhatsappService::sendMedia($device->body, $numero, $plantilla->archivo_tipo, url($plantilla->archivo_url), $cuerpo)`
     - Si no → `WhatsappService::sendText($device->body, $numero, $cuerpo)`

### Job `EnviarResumenDiarioPostventaJob`

- `app/Jobs/EnviarResumenDiarioPostventaJob.php`
- Registrado en `app/Console/Kernel.php` → `->dailyAt('08:00')`
- Lógica del `handle()`:
  1. Consulta OTs: `WorkOrder::withoutGlobalScopes()->where('bloqueado', true)->whereBetween('fecha_cerrado', [ayer 00:00, ayer 23:59])->get()`.
  2. Agrupa por `empresa_id`.
  3. Para cada empresa:
     - Busca device con `interno = true` cuyo `user->empresa_id` coincida con la empresa. Si no hay → log warning, continua.
     - Busca usuarios con rol `post-venta` o `ventas` que tengan `telefono` no nulo.
     - Si no hay OTs ese día → no envía.
     - Arma el mensaje con el formato definido.
     - Envía a cada usuario vía `WhatsappService::sendText($device->body, $user->telefono, $mensaje)`.

**Formato del resumen:**
```
📋 RESUMEN POST-VENTA | {fecha de ayer}
OTs cerradas: {total}

1. 🚗 {PLACA} — {CLIENTE}
   👤 {CONTACTO} | {TELÉFONO}
   📅 Instalación: {fecha_inicio} | Cierre: {fecha_cerrado}

2. 🚗 ...

Enviado por el sistema Talentus
```

---

## 3. UI de Configuración

### 3a. Toggle post-venta en lista de Devices

- Archivo: `app/Livewire/Admin/WhatsFleep/Devices/Index.php` (modificación)
- Vista: `resources/views/livewire/admin/whats-fleep/devices/index.blade.php` (modificación)
- Agregar columna "Post-Venta" con toggle `wire:click="togglePostventa($device->id)"`.
- Método `togglePostventa(int $deviceId)`:
  1. Desactiva `es_postventa` en todos los devices de la empresa.
  2. Activa `es_postventa = true` en el device seleccionado.
  3. Notificación `$this->notification()->success(...)`.

### 3b. CRUD Plantillas Post-Venta

Nueva ruta en `routes/web.php`:
```
/admin/ajustes/postventa → admin.ajustes.postventa
```

Nueva entrada en el navigation de ajustes (`x-admin.settings.navigation`).

**Componentes:**

| Archivo | Responsabilidad |
|---|---|
| `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Index.php` | Lista plantillas con search, toggle activo/inactivo, acciones |
| `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php` | Modal crear plantilla |
| `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php` | Modal editar plantilla |
| `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Delete.php` | Modal confirmar eliminación |

**Campos del formulario Save/Edit:**

- **Sector** — `x-form.select` con los sectores activos de la empresa. Opción "— Plantilla por defecto —" guarda `sector_id = null`.
- **Cuerpo del mensaje** — `textarea` con hint: `Variables disponibles: {placa} {cliente} {fecha_instalacion} {fecha_cierre}`.
- **Archivo adjunto** — file input con `wire:model` + `Livewire\WithFileUploads`. Acepta PDF y video (mp4, max 16 MB). Muestra nombre del archivo actual en Edit.
- **Activo** — toggle boolean.

Archivos guardados en: `storage/app/public/postventa/` vía `$file->store('postventa', 'public')`.

---

## 4. Manejo de Errores

| Situación | Comportamiento |
|---|---|
| No hay device `es_postventa` activo | `Log::warning`, Listener retorna sin error visible |
| Cliente sin contacto gerente ni teléfono | `Log::warning`, Job termina sin envío |
| No hay plantilla para sector ni default | `Log::warning`, Job termina sin envío |
| Fallo en API WhatsApp | Job reintenta 3 veces (backoff: 30s, 60s, 120s) |
| No hay device `interno` para resumen diario | `Log::warning`, empresa omitida en el ciclo |
| No hay OTs cerradas el día anterior | Job no envía ningún mensaje |

---

## 5. Archivos a Crear / Modificar

### Nuevos
```
app/Events/WorkOrderCerrada.php
app/Listeners/EnviarMensajePostventaListener.php
app/Jobs/EnviarMensajeClienteJob.php
app/Jobs/EnviarResumenDiarioPostventaJob.php
app/Models/PostventaPlantilla.php
app/Livewire/Admin/Ajustes/Postventa/Plantillas/Index.php
app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php
app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php
app/Livewire/Admin/Ajustes/Postventa/Plantillas/Delete.php
resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php
resources/views/livewire/admin/ajustes/postventa/plantillas/save.blade.php
resources/views/livewire/admin/ajustes/postventa/plantillas/edit.blade.php
resources/views/livewire/admin/ajustes/postventa/plantillas/delete.blade.php
resources/views/admin/ajustes/postventa.blade.php
database/migrations/YYYY_MM_DD_add_es_postventa_to_devices_table.php
database/migrations/YYYY_MM_DD_create_postventa_plantillas_table.php
```

### Modificados
```
app/Models/WorkOrder.php                          ← event(new WorkOrderCerrada($this))
app/Providers/EventServiceProvider.php            ← registrar listener
app/Console/Kernel.php                            ← schedule job diario
app/Livewire/Admin/WhatsFleep/Devices/Index.php   ← método togglePostventa
resources/views/livewire/admin/whats-fleep/devices/index.blade.php  ← columna toggle
resources/views/components/admin/settings/navigation.blade.php      ← enlace Post-Venta
routes/web.php                                    ← nueva ruta ajustes/postventa
```

---

## 6. Fuera de Alcance

- Historial de mensajes enviados (se puede agregar en fase 2).
- Preview del mensaje antes de cerrar la OT.
- Envío manual de la plantilla desde la OT.
- Confirmación de lectura / reply tracking.
