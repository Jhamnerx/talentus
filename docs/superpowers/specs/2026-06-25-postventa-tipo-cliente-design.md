# Plantillas post-venta segmentadas por tipo de cliente — Diseño

**Fecha:** 2026-06-25
**Módulo:** Post-venta (notificación al cerrar orden de trabajo)
**Enfoque elegido:** A — `tipo_cliente` en las plantillas + detección en `Clientes` + resolución en el job existente. Umbral configurable por empresa.

## Problema

Al **cerrar** una orden de trabajo se dispara `WorkOrderCerrada` → [EnviarMensajePostventaListener](../../../app/Listeners/EnviarMensajePostventaListener.php) → [EnviarMensajeClienteJob](../../../app/Jobs/EnviarMensajeClienteJob.php), que envía un WhatsApp al cliente usando una [PostventaPlantilla](../../../app/Models/PostventaPlantilla.php).

Hoy la plantilla se resuelve **solo por sector** ([resolverPlantilla()](../../../app/Jobs/EnviarMensajeClienteJob.php#L107)). El usuario necesita enviar mensajes distintos según el **tipo de cliente** (nuevo vs recurrente), además del sector.

## Regla de negocio (definida con el usuario)

- **NUEVO** = el cliente tiene **exactamente 1 vehículo no eliminado** (el de esta OT) **Y** fue **registrado hace ≤ N días** (`created_at`).
- **RECURRENTE** = cualquier otro caso.
- **N** por defecto **30 días**, **configurable por empresa**.
- Las plantillas pueden marcarse como `nuevo`, `recurrente` o **`ambos`** (comodín que aplica a cualquier tipo).

## Objetivo

Resolver la plantilla por **(sector × tipo de cliente)** con fallback, sin romper el comportamiento actual (default `ambos`).

## No-objetivos (YAGNI)

- No se cambia el disparador (sigue siendo `WorkOrderCerrada`).
- No se agregan nuevas variables de plantilla.
- No se crea una tabla genérica de settings: el umbral vive en `empresas`.
- No se segmenta por antigüedad en más de dos tramos (solo nuevo/recurrente).

## Diseño

### 1. Base de datos

**Migración 1 — `postventa_plantillas`:**
```php
$table->enum('tipo_cliente', ['nuevo', 'recurrente', 'ambos'])
      ->default('ambos')
      ->after('sector_id');
```
Filas existentes quedan en `ambos` → siguen aplicando a todos (compatibilidad total).
Actualizar el índice/consultas: la resolución filtrará por `empresa_id`, `sector_id`, `tipo_cliente`, `activo`.

**Migración 2 — `empresas`:**
```php
$table->unsignedSmallInteger('postventa_dias_cliente_nuevo')->default(30);
```
(Se agrega al final de la tabla; no requiere `after()` específico.)

### 2. Detección del segmento (`Clientes`)

Nuevo método en el modelo `Clientes`:
```php
public function tipoPostventa(int $umbralDias): string
{
    $esPrimerVehiculo = $this->vehiculos()->count() === 1;          // no eliminados (soft-deletes excluidos)
    $recienRegistrado = $this->created_at !== null
        && $this->created_at->gte(now()->subDays($umbralDias));

    return ($esPrimerVehiculo && $recienRegistrado) ? 'nuevo' : 'recurrente';
}
```
Devuelve siempre `nuevo` o `recurrente` (nunca `ambos`; `ambos` es solo para las plantillas).

### 3. Resolución de plantilla (job)

En [EnviarMensajeClienteJob::resolverPlantilla()](../../../app/Jobs/EnviarMensajeClienteJob.php#L107):

1. Obtener el umbral: `$umbral = Empresa::find($workOrder->empresa_id)?->postventa_dias_cliente_nuevo ?? 30;`
2. `$tipo = $workOrder->cliente?->tipoPostventa($umbral) ?? 'recurrente';`
3. Buscar la **primera plantilla activa** en este orden (todas con `empresa_id` y `activo = true`):
   1. `sector_id = $sectorId` **y** `tipo_cliente = $tipo`
   2. `sector_id = $sectorId` **y** `tipo_cliente = 'ambos'`
   3. `sector_id IS NULL` **y** `tipo_cliente = $tipo`
   4. `sector_id IS NULL` **y** `tipo_cliente = 'ambos'`
4. Si ninguna → loguea `no hay plantilla` y no envía (igual que hoy).

`$sectorId` se resuelve como hoy (nombre del sector de la OT → `sectores.id`; null si no hay match).

### 4. CRUD (Ajustes → Postventa)

- **`Save`** y **`Edit`** ([Save.php](../../../app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php), [Edit.php](../../../app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php)):
  - Propiedad `public string $tipo_cliente = 'ambos';`
  - `rules()`: `'tipo_cliente' => 'required|in:nuevo,recurrente,ambos'`
  - Incluir `tipo_cliente` en `create()` / `update()` y en `open()` (Edit) y en el reset (Save).
  - Blade: un `<x-form.select>` "Tipo de cliente" (Nuevo / Recurrente / Ambos).
- **`Index`** ([index.blade](../../../resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php)): mostrar una etiqueta del `tipo_cliente` junto al sector.
- **Umbral:** componente Livewire nuevo y pequeño `Admin\Ajustes\Postventa\ConfiguracionPostventa` con un input numérico "Días para considerar cliente nuevo", que lee/guarda `empresas.postventa_dias_cliente_nuevo` (de la empresa de `session('empresa')`). Se embebe arriba en [postventa.blade.php](../../../resources/views/admin/ajustes/postventa.blade.php). Validación: `integer|min:1|max:3650`. Verificar que la columna sea asignable en el modelo `Empresa` (guarded/fillable).

### 5. Pruebas

**Solo prueba manual** (sin BD de pruebas segura, igual que el cambio de cobros), salvo que se indique lo contrario. Validar con `php -l` + navegador:

- Cliente con 1 vehículo y `created_at` de hoy → resuelve plantilla `nuevo` del sector (o fallback).
- Cliente con 2+ vehículos → resuelve `recurrente`.
- Cliente con 1 vehículo pero registrado hace > N días → `recurrente`.
- Sin plantilla por tipo pero con plantilla `ambos` → usa `ambos`.
- Cambiar el umbral en Ajustes y reflejarse en la clasificación.
- Plantillas existentes (todas `ambos`) → siguen enviándose como antes.

## Archivos afectados

- `database/migrations/...` — 2 migraciones (postventa_plantillas, empresas).
- `app/Models/Clientes.php` — método `tipoPostventa()`.
- `app/Models/PostventaPlantilla.php` — (opcional) const de valores del enum.
- `app/Models/Empresa.php` — asegurar columna asignable.
- `app/Jobs/EnviarMensajeClienteJob.php` — `resolverPlantilla()` por tipo + cálculo del tipo.
- `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php` + blade — selector tipo_cliente.
- `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php` + blade — selector tipo_cliente.
- `resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php` — etiqueta tipo.
- `app/Livewire/Admin/Ajustes/Postventa/ConfiguracionPostventa.php` + blade (nuevo) — input del umbral.
- `resources/views/admin/ajustes/postventa.blade.php` — embeber el componente de configuración.

## Compatibilidad

Default `tipo_cliente = 'ambos'` + cadena de fallback ⇒ si el usuario no crea plantillas por tipo, todo funciona exactamente como hoy.
