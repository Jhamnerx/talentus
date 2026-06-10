# Mantenimiento Module Redesign

**Date:** 2026-06-10  
**Status:** Approved

## Overview

Mejora completa del módulo de mantenimientos de vehículos. Mantiene el enfoque de modales sobre el índice (sin página de detalle separada). Agrega generación de órdenes de trabajo vinculadas, auto-creación del siguiente mantenimiento al completar, y rediseño visual de la tabla.

## Sección 1: Rediseño del índice

### Filtros por estado

Tabs encima de la tabla con contadores en tiempo real:
`Todos (N) | PENDIENTE (N) | COMPLETADA (N) | CANCELADO (N)`

- Propiedad `$statusFilter = ''` en `Index.php`
- Al cambiar tab se llama `resetPage()`
- La query aplica `->when($this->statusFilter, fn($q) => $q->where('estado', $this->statusFilter))`

### Query mejorada (N+1 fix)

```php
Mantenimiento::with(['vehiculo.cliente', 'user', 'workOrderActivo'])
    ->whereHas('vehiculo', ...)
    ->orWhere(...)
    ->when($this->statusFilter, ...)
    ->orderBy('id', 'desc')
    ->paginate(12)
```

### Tabla rediseñada

Cada fila muestra:

| Columna | Contenido |
|---|---|
| # | Número (`MT2026-0001`) + fecha de creación pequeña |
| Vehículo / Cliente | Placa en bold + razon_social debajo en gris |
| Detalle | Texto truncado (max 60 chars) |
| Fecha programada | Fecha + badge de urgencia: `VENCIDO` (rojo, pasó la fecha), `HOY` (naranja), `PRÓXIMO` (amarillo, ≤7 días) |
| Estado | Badge colored usando `$mantenimiento->estado->color()` |
| OT | Si `workOrderActivo` existe: badge azul con número OT. Si no: botón "Crear OT" |
| Acciones | Menú dropdown: Editar, Crear OT, Crear Tarea Técnico, Marcar estado, Eliminar |

### Bug fix

`Index.php::markAs()` tiene `if ($value = "COMPLETADA")` (asignación). Se corrige a `===`.

## Sección 2: Crear OT desde mantenimiento

### Estrategia

Reutilizar el `CreateModal` de work orders existente añadiendo un nuevo listener que pre-rellena datos desde un mantenimiento.

### Cambios en `CreateModal.php`

Nuevo método:

```php
#[On('open-create-modal-from-mantenimiento')]
public function openFromMantenimiento(int $mantenimientoId): void
{
    $this->resetProps();
    $mantenimiento = Mantenimiento::with('vehiculo.cliente')->find($mantenimientoId);
    if (!$mantenimiento) return;

    $this->mantenimiento_id   = $mantenimiento->id;
    $this->vehiculo_id        = $mantenimiento->vehiculo_id;
    $this->fecha_programada   = $mantenimiento->fecha_hora_mantenimiento->format('Y-m-d H:i');
    $this->updatedVehiculoId($this->vehiculo_id); // carga cliente y contactos
    $this->modalSave = true;
}
```

### En el índice de mantenimientos

- Fila: si no hay OT → botón "Crear OT" que dispara `open-create-modal-from-mantenimiento` con el `$mantenimiento->id`
- Fila: si hay OT → badge azul con número de OT (e.g. `OT #00042`)
- Menú dropdown: item "Crear OT" siempre visible (permite crear múltiples OT si la anterior se cerró)

### En el modal de edición (`Edit.php` / `edit.blade.php`)

Sección inferior del modal:
- Si `$mantenimiento->workOrderActivo` existe: muestra número de OT con enlace
- Si no: botón "Crear OT" que dispara `open-create-modal-from-mantenimiento`

## Sección 3: Auto-crear siguiente mantenimiento al completar

### Flujo

1. Usuario hace clic en "Marcar como Completada" → `Index::markAs($id, 'COMPLETADA')`
2. `markAs` actualiza el estado y dispara `open-siguiente-mantenimiento` con el modelo
3. Nuevo componente `CreateSiguienteMantenimiento` escucha el evento y abre el modal pre-rellenado
4. Usuario ajusta fecha (o acepta) → guarda → se crea nuevo mantenimiento con número auto-generado
5. Si el usuario cierra sin guardar → el mantenimiento actual igual queda COMPLETADA (sin bloqueo)

### Nuevo componente `CreateSiguienteMantenimiento`

**Archivo:** `app/Livewire/Admin/Vehiculos/Mantenimiento/CreateSiguienteMantenimiento.php`
**Vista:** `resources/views/livewire/admin/vehiculos/mantenimiento/create-siguiente-mantenimiento.blade.php`

Propiedades:
- `$modalOpen = false`
- `$mantenimiento_origen_id` — id del mantenimiento completado
- `$vehiculo_id`, `$detalle_trabajo`, `$nota`, `$notify_admin`, `$notify_client`
- `$fecha_hora_mantenimiento` — pre-rellenado con fecha origen + 1 año

Listener `#[On('open-siguiente-mantenimiento')]`:
- Recibe el `$mantenimientoId`
- Carga el mantenimiento origen y pre-rellena todos los campos
- Abre el modal

Método `guardar()`:
- Valida y crea el nuevo `Mantenimiento` usando `generarNumeroSeguro()` (misma lógica que `Save.php`)
- Dispatch `update-table` para refrescar el índice
- Muestra toast de éxito

## Componentes que se modifican

| Archivo | Cambio |
|---|---|
| `app/Livewire/Admin/Vehiculos/Mantenimiento/Index.php` | `$statusFilter`, N+1 fix, bug fix `===`, nuevo `createWorkOrder()` |
| `resources/views/livewire/admin/vehiculos/mantenimiento/index.blade.php` | Tabs de filtro, tabla rediseñada con badges de urgencia y OT |
| `app/Livewire/Admin/Vehiculos/Mantenimiento/Edit.php` | Cargar `workOrderActivo` al abrir modal |
| `resources/views/livewire/admin/vehiculos/mantenimiento/edit.blade.php` | Sección OT en pie del modal |
| `app/Livewire/Admin/WorkOrders/CreateModal.php` | Nuevo método `openFromMantenimiento()` |

## Componentes nuevos

| Archivo | Descripción |
|---|---|
| `app/Livewire/Admin/Vehiculos/Mantenimiento/CreateSiguienteMantenimiento.php` | Modal auto-create siguiente mantenimiento |
| `resources/views/livewire/admin/vehiculos/mantenimiento/create-siguiente-mantenimiento.blade.php` | Vista del modal |

## Consideraciones

- El componente `CreateSiguienteMantenimiento` se registra en la vista del índice con `@livewire('admin.vehiculos.mantenimiento.create-siguiente-mantenimiento')`
- El `CreateModal` de work orders ya está registrado globalmente en el layout; no necesita re-incluirse
- No se modifican los estados del enum `mantenimientoStatus` (PENDIENTE, COMPLETADA, CANCELADO son suficientes)
- No se agregan nuevos campos a la tabla `mantenimientos`
