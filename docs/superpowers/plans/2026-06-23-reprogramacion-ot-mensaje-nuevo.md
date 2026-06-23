# Reprogramación de OT — Mensaje nuevo al vencer ventana de edición — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Cuando se cambian datos relevantes de una OT y el mensaje de WhatsApp ya no puede editarse (ventana de ~15 min vencida o estado no editable), enviar un mensaje nuevo al grupo con un banner, en vez de editar el existente.

**Architecture:** Se agrega `wa_sent_at` a `work_orders` para saber cuándo se envió el mensaje actual. Un helper `WorkOrder::puedeEditarMensaje()` decide editar vs. reenviar usando un umbral configurable y `WorkOrderStatus::canEdit()`. `EditModal::save()` ramifica entre `editarMensaje()` (con prefijo banner) y `enviarAlGrupo()` (mensaje nuevo, refresca `wa_sent_at`).

**Tech Stack:** Laravel 12, Livewire 4, PHPUnit 11, MySQL (server real), servidor Node WhatsApp vía HTTP.

> **Restricción de testing (preferencia del usuario):** NO ejecutar `php artisan test` con `RefreshDatabase` — borra la BD real de desarrollo (las líneas DB de `phpunit.xml` están comentadas). Validar archivos tocados con `php -l`. El test del helper es **sin BD** (modelo en memoria) y es seguro de ejecutar con filtro.

---

## File Structure

- `database/migrations/2026_06_23_120000_add_wa_sent_at_to_work_orders.php` — **crear**. Columna `wa_sent_at`.
- `app/Models/WorkOrder.php` — **modificar**. Cast `wa_sent_at` + helper `puedeEditarMensaje()`.
- `config/whatsapp.php` — **modificar**. Clave `edit_window_minutes`.
- `app/Services/WorkOrderNotificationService.php` — **modificar**. `enviarAlGrupo()` acepta `$prefijo` y setea `wa_sent_at`.
- `app/Livewire/Admin/WorkOrders/EditModal.php` — **modificar**. Decisión editar vs. mensaje nuevo en `save()`.
- `tests/Unit/Models/WorkOrderPuedeEditarMensajeTest.php` — **crear**. Test del helper (sin BD).

---

## Task 1: Migración `wa_sent_at`

**Files:**
- Create: `database/migrations/2026_06_23_120000_add_wa_sent_at_to_work_orders.php`

- [ ] **Step 1: Crear la migración**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // Momento en que se envió el wa_message_id actual.
            // Sirve para saber si aún estamos dentro de la ventana de edición de WhatsApp.
            $table->timestamp('wa_sent_at')->nullable()->after('wa_group_id')
                ->comment('Cuándo se envió el wa_message_id actual (ventana de edición WA)');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('wa_sent_at');
        });
    }
};
```

- [ ] **Step 2: Validar sintaxis**

Run: `php -l database/migrations/2026_06_23_120000_add_wa_sent_at_to_work_orders.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Ejecutar la migración (solo estructura, no borra datos)**

Run: `php artisan migrate --no-interaction`
Expected: corre `2026_06_23_120000_add_wa_sent_at_to_work_orders ... DONE`

> Nota: `migrate` (no `migrate:fresh`) solo añade la columna; es seguro sobre la BD real.

- [ ] **Step 4: Commit**

```bash
git add database/migrations/2026_06_23_120000_add_wa_sent_at_to_work_orders.php
git commit -m "feat(work-orders): columna wa_sent_at para ventana de edicion WA"
```

---

## Task 2: Config `edit_window_minutes`

**Files:**
- Modify: `config/whatsapp.php`

- [ ] **Step 1: Añadir la clave**

En `config/whatsapp.php`, dentro del array `return [...]`, después de `'country_code' => ...`, agregar:

```php
    // Minutos durante los que WhatsApp permite editar un mensaje (real ~15 min).
    // Se usa 14 por margen ante latencia/relojes. Pasado el umbral se envía mensaje nuevo.
    'edit_window_minutes' => (int) env('WA_EDIT_WINDOW_MINUTES', 14),
```

- [ ] **Step 2: Validar sintaxis**

Run: `php -l config/whatsapp.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add config/whatsapp.php
git commit -m "feat(whatsapp): config edit_window_minutes"
```

---

## Task 3: Helper `WorkOrder::puedeEditarMensaje()` + cast (TDD)

**Files:**
- Modify: `app/Models/WorkOrder.php` (cast en `$casts`, helper nuevo)
- Test: `tests/Unit/Models/WorkOrderPuedeEditarMensajeTest.php`

- [ ] **Step 1: Escribir el test que falla (sin BD)**

Crear `tests/Unit/Models/WorkOrderPuedeEditarMensajeTest.php`:

```php
<?php

namespace Tests\Unit\Models;

use App\Enums\WorkOrderStatus;
use App\Models\WorkOrder;
use Tests\TestCase;

/**
 * Tests en memoria (sin BD): solo ejercitan la lógica de puedeEditarMensaje().
 * No usan RefreshDatabase, por lo que son seguros de ejecutar.
 */
class WorkOrderPuedeEditarMensajeTest extends TestCase
{
    private function orden(array $attrs): WorkOrder
    {
        $orden = new WorkOrder();
        $orden->wa_message_id = 'MSG123';
        $orden->wa_group_id   = '123-456@g.us';
        $orden->estado        = WorkOrderStatus::PENDIENTE;
        $orden->wa_sent_at    = now();

        foreach ($attrs as $key => $value) {
            $orden->{$key} = $value;
        }

        return $orden;
    }

    public function test_editable_dentro_de_la_ventana_y_estado_editable(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['wa_sent_at' => now()->subMinutes(5)]);

        $this->assertTrue($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_paso_la_ventana(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['wa_sent_at' => now()->subMinutes(20)]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_wa_sent_at_es_null(): void
    {
        $orden = $this->orden(['wa_sent_at' => null]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_no_hay_wa_message_id(): void
    {
        $orden = $this->orden(['wa_message_id' => null]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_estado_finalizado(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['estado' => WorkOrderStatus::FINALIZADO, 'wa_sent_at' => now()]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_no_editable_si_estado_cancelado(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['estado' => WorkOrderStatus::CANCELADO, 'wa_sent_at' => now()]);

        $this->assertFalse($orden->puedeEditarMensaje());
    }

    public function test_editable_en_proceso_dentro_de_la_ventana(): void
    {
        config(['whatsapp.edit_window_minutes' => 14]);
        $orden = $this->orden(['estado' => WorkOrderStatus::EN_PROCESO, 'wa_sent_at' => now()->subMinutes(3)]);

        $this->assertTrue($orden->puedeEditarMensaje());
    }
}
```

- [ ] **Step 2: Verificar que el test falla (método inexistente)**

Run: `php artisan test --compact --filter=WorkOrderPuedeEditarMensajeTest`
Expected: FAIL — `Call to undefined method App\Models\WorkOrder::puedeEditarMensaje()`

> Si por política no se ejecuta el suite, al menos `php -l tests/Unit/Models/WorkOrderPuedeEditarMensajeTest.php` debe dar `No syntax errors detected`.

- [ ] **Step 3: Añadir el cast**

En `app/Models/WorkOrder.php`, dentro de `protected $casts = [...]`, después de `'wa_group_id' => 'string',` agregar:

```php
        'wa_sent_at' => 'datetime',
```

- [ ] **Step 4: Implementar el helper**

En `app/Models/WorkOrder.php`, agregar este método público (junto a otros métodos del modelo, p. ej. después de las relaciones):

```php
    public function puedeEditarMensaje(): bool
    {
        if (empty($this->wa_message_id) || empty($this->wa_group_id) || $this->wa_sent_at === null) {
            return false;
        }

        if (! $this->estado->canEdit()) {
            return false;
        }

        return $this->wa_sent_at->diffInMinutes(now()) < (int) config('whatsapp.edit_window_minutes', 14);
    }
```

- [ ] **Step 5: Verificar que el test pasa**

Run: `php artisan test --compact --filter=WorkOrderPuedeEditarMensajeTest`
Expected: PASS (7 tests)
Y: `php -l app/Models/WorkOrder.php` → `No syntax errors detected`

- [ ] **Step 6: Commit**

```bash
git add app/Models/WorkOrder.php tests/Unit/Models/WorkOrderPuedeEditarMensajeTest.php
git commit -m "feat(work-orders): helper puedeEditarMensaje + cast wa_sent_at"
```

---

## Task 4: `enviarAlGrupo()` con prefijo y `wa_sent_at`

**Files:**
- Modify: `app/Services/WorkOrderNotificationService.php`

- [ ] **Step 1: Cambiar la firma y aplicar el prefijo**

En `enviarAlGrupo`, cambiar la firma:

```php
    public function enviarAlGrupo(WorkOrder $orden, ?Device $device = null, ?string $prefijo = null): ?string
```

Inmediatamente después de `$mensaje = $this->formatMensaje($orden);` añadir:

```php
        if ($prefijo) {
            $mensaje = $prefijo . "\n\n" . $mensaje;
        }
```

- [ ] **Step 2: Persistir `wa_sent_at` al enviar**

Dentro de `enviarAlGrupo`, en el bloque que hace el `->update([...])` tras un envío exitoso, agregar la marca de tiempo. Reemplazar:

```php
                    ->update([
                        'wa_message_id' => $messageId,
                        'wa_group_id'   => $tecnico->wa_group_id,
                    ]);
```

por:

```php
                    ->update([
                        'wa_message_id' => $messageId,
                        'wa_group_id'   => $tecnico->wa_group_id,
                        'wa_sent_at'    => now(),
                    ]);
```

- [ ] **Step 3: Validar sintaxis**

Run: `php -l app/Services/WorkOrderNotificationService.php`
Expected: `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Services/WorkOrderNotificationService.php
git commit -m "feat(work-orders): enviarAlGrupo soporta prefijo y registra wa_sent_at"
```

---

## Task 5: Decisión editar vs. mensaje nuevo en `EditModal::save()`

**Files:**
- Modify: `app/Livewire/Admin/WorkOrders/EditModal.php`

- [ ] **Step 1: Reemplazar el bloque de notificación WA**

En `EditModal::save()`, localizar el bloque actual que empieza en:

```php
        // Editar el mensaje WA si hubo cambios relevantes
        $hayCAmbiosWA = $hayTecnicoCambio || $hayFechaCambio || $hayVehiculoCambio
            || $hayDireccionCambio || $haySectorCambio || $hayPlanCambio;

        if ($this->waEnviado && $hayCAmbiosWA) {
            $orden->refresh();
            $orden->loadMissing(['tipo', 'vehiculo.cliente', 'cliente', 'tecnico', 'items']);
            $editado = app(WorkOrderNotificationService::class)->editarMensaje($orden);

            if ($editado) {
                $this->notification()->success(
                    'ACTUALIZADO',
                    "Orden #{$this->workOrderId} actualizada y mensaje WhatsApp editado"
                );
            } else {
                $this->notification()->warning(
                    'ACTUALIZADO PARCIALMENTE',
                    "Orden #{$this->workOrderId} actualizada, pero no se pudo editar el mensaje WA"
                );
            }
        } else {
            $this->notification()->success('ACTUALIZADO', "Orden #{$this->workOrderId} actualizada correctamente");
        }
```

y reemplazarlo completo por:

```php
        // Notificar al grupo si hubo cambios relevantes
        $hayCAmbiosWA = $hayTecnicoCambio || $hayFechaCambio || $hayVehiculoCambio
            || $hayDireccionCambio || $haySectorCambio || $hayPlanCambio;

        if ($this->waEnviado && $hayCAmbiosWA) {
            $orden->refresh();
            $orden->loadMissing(['tipo', 'vehiculo.cliente', 'cliente', 'tecnico', 'items']);

            $banner   = $hayFechaCambio ? '🔄 *OT REPROGRAMADA*' : '✏️ *OT ACTUALIZADA*';
            $servicio = app(WorkOrderNotificationService::class);

            if ($orden->puedeEditarMensaje()) {
                $editado = $servicio->editarMensaje($orden, prefijo: $banner);

                if ($editado) {
                    $this->notification()->success(
                        'ACTUALIZADO',
                        "Orden #{$this->workOrderId} actualizada y mensaje WhatsApp editado"
                    );
                } else {
                    $this->notification()->warning(
                        'ACTUALIZADO PARCIALMENTE',
                        "Orden #{$this->workOrderId} actualizada, pero no se pudo editar el mensaje WA"
                    );
                }
            } else {
                $nuevoId = $servicio->enviarAlGrupo($orden, prefijo: $banner);

                if ($nuevoId) {
                    $this->notification()->success(
                        'ACTUALIZADO',
                        "Orden #{$this->workOrderId} actualizada y se envió un aviso nuevo al grupo"
                    );
                } else {
                    $this->notification()->warning(
                        'ACTUALIZADO PARCIALMENTE',
                        "Orden #{$this->workOrderId} actualizada, pero no se pudo enviar el aviso al grupo"
                    );
                }
            }
        } else {
            $this->notification()->success('ACTUALIZADO', "Orden #{$this->workOrderId} actualizada correctamente");
        }
```

> `editarMensaje($orden, prefijo: $banner)` aprovecha el 3.er parámetro existente (`?string $prefijo`). `$hayFechaCambio` ya se calcula al inicio de `save()`.

- [ ] **Step 2: Validar sintaxis**

Run: `php -l app/Livewire/Admin/WorkOrders/EditModal.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/Admin/WorkOrders/EditModal.php
git commit -m "feat(work-orders): mensaje nuevo al reprogramar cuando no se puede editar"
```

---

## Task 6: Verificación manual (QA)

Sin BD de pruebas dedicada, la rama Livewire se valida manualmente. Pre-requisito: servidor Node WA conectado y un técnico con `wa_group_id`.

- [ ] **Step 1: Editar dentro de la ventana → se edita**

1. Crear una OT (se envía mensaje al grupo).
2. En < 14 min, abrir editar, cambiar la fecha, guardar.
3. Esperado: el mensaje original en el grupo se **edita** y antepone `🔄 *OT REPROGRAMADA*`. Notificación "mensaje WhatsApp editado".

- [ ] **Step 2: Fuera de la ventana → mensaje nuevo**

1. Tomar una OT cuyo mensaje se envió hace > 14 min (o forzar `wa_sent_at` antiguo en BD).
2. Editar, cambiar la fecha, guardar.
3. Esperado: aparece un **mensaje nuevo** en el grupo con banner `🔄 *OT REPROGRAMADA*`. Notificación "se envió un aviso nuevo al grupo". `wa_message_id` y `wa_sent_at` quedan actualizados al nuevo mensaje.

- [ ] **Step 3: Cambio que no es fecha → banner ACTUALIZADA**

1. Fuera de ventana, cambiar solo la dirección o el técnico (no la fecha), guardar.
2. Esperado: mensaje nuevo con banner `✏️ *OT ACTUALIZADA*`.

- [ ] **Step 4: Estado no editable → mensaje nuevo**

1. OT finalizada/cancelada (si la UI lo permite) con cambio relevante.
2. Esperado: mensaje nuevo (no edición), por `canEdit() === false`.

---

## Notas de ejecución

- Orden recomendado: Task 1 → 2 → 3 → 4 → 5 → 6.
- `php -l` en cada archivo tocado antes de commitear.
- El único test automatizado es el del helper (Task 3), seguro porque no toca BD.
- Tests de integración Livewire (rama editar vs. nuevo) quedan como mejora futura: requieren un `WorkOrderFactory` (no existe) + conexión sqlite de pruebas habilitada en `phpunit.xml`.
