# Reprogramación de OT — Enviar mensaje nuevo al pasar la ventana de edición

**Fecha:** 2026-06-23
**Componente principal:** `App\Livewire\Admin\WorkOrders\EditModal`
**Servicio:** `App\Services\WorkOrderNotificationService`

## Problema

Al editar una orden de trabajo (`EditModal::save()`), si hubo cambios relevantes
(fecha, técnico, vehículo, dirección, sector, plan) el sistema **edita** el mensaje
de WhatsApp original ya enviado al grupo del técnico (`editarMensaje()`).

WhatsApp solo permite **editar un mensaje durante ~15 minutos** después de enviarlo.
Pasada esa ventana, la edición falla en silencio y el usuario ve "ACTUALIZADO
PARCIALMENTE". El técnico nunca se entera del cambio — crítico cuando se **reprograma**
una OT (cambio de fecha) de una orden antigua.

## Objetivo

Cuando se cambian datos relevantes de una OT y **el mensaje de WhatsApp ya no puede
editarse** (ventana de edición vencida, o la orden está en un estado no editable),
enviar un **mensaje nuevo** al grupo en lugar de intentar editar el existente.

## Decisiones tomadas

1. **Disparador:** solo como *fallback*. Dentro de la ventana se sigue editando el
   mensaje existente. Solo si ya no se puede editar se envía un mensaje nuevo.
2. **Detección:** por tiempo. Se agrega `wa_sent_at` y un umbral configurable (~15 min).
3. **Estados:** se usa el `WorkOrderStatus::canEdit()` existente — `finalizado` y
   `cancelado` no son editables y fuerzan mensaje nuevo. `en_proceso` y `pendiente`
   permiten editar dentro de la ventana de tiempo.
4. **Contenido del mensaje nuevo:** banner + mensaje estándar completo.
   - `🔄 *OT REPROGRAMADA*` si cambió la fecha.
   - `✏️ *OT ACTUALIZADA*` si cambiaron otros datos pero no la fecha.

## Sección 1 — Detección y modelo de datos

### Migración

Nueva migración: añade columna `wa_sent_at` (`timestamp`, nullable) a `work_orders`,
después de `wa_group_id`.

- Órdenes existentes quedan con `wa_sent_at = null`. Se interpreta `null` como
  "ventana vencida" → se enviará mensaje nuevo si se reprograman (comportamiento
  correcto para órdenes viejas).

### Cast en el modelo

`WorkOrder::$casts` → `'wa_sent_at' => 'datetime'`.

### Configuración

`config/whatsapp.php`:

```php
'edit_window_minutes' => (int) env('WA_EDIT_WINDOW_MINUTES', 14),
```

Se usa 14 (menos de los 15 reales de WhatsApp) para dar margen ante latencia/relojes.

### Helper en el modelo

`WorkOrder::puedeEditarMensaje(): bool`

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

Notas:
- `$this->estado` ya está casteado a `WorkOrderStatus`.
- `wa_sent_at === null` → no editable (cubre órdenes antiguas y mensajes nunca enviados).

## Sección 2 — Flujo de envío/edición

### `WorkOrderNotificationService::enviarAlGrupo()`

- Añadir parámetro opcional `?string $prefijo = null` (firma:
  `enviarAlGrupo(WorkOrder $orden, ?Device $device = null, ?string $prefijo = null)`).
- Si `$prefijo` no es nulo, anteponerlo al mensaje: `$mensaje = $prefijo . "\n\n" . $mensaje;`
  (mismo patrón que `editarMensaje`).
- En el `update()` que persiste `wa_message_id` y `wa_group_id`, agregar
  `'wa_sent_at' => now()`. Así, tanto el envío inicial como cada reenvío de fallback
  refrescan la marca de tiempo, y futuras ediciones dentro de la ventana del **nuevo**
  mensaje vuelven a funcionar.

### `WorkOrderNotificationService::editarMensaje()`

Sin cambios (ya soporta `$prefijo`).

### `EditModal::save()`

Reemplazar el bloque actual de "editar mensaje WA si hubo cambios" por:

```php
if ($this->waEnviado && $hayCAmbiosWA) {
    $orden->refresh();
    $orden->loadMissing(['tipo', 'vehiculo.cliente', 'cliente', 'tecnico', 'items']);

    $banner  = $hayFechaCambio ? '🔄 *OT REPROGRAMADA*' : '✏️ *OT ACTUALIZADA*';
    $servicio = app(WorkOrderNotificationService::class);

    if ($orden->puedeEditarMensaje()) {
        $editado = $servicio->editarMensaje($orden, prefijo: $banner);

        if ($editado) {
            $this->notification()->success('ACTUALIZADO', "Orden #{$this->workOrderId} actualizada y mensaje WhatsApp editado");
        } else {
            $this->notification()->warning('ACTUALIZADO PARCIALMENTE', "Orden #{$this->workOrderId} actualizada, pero no se pudo editar el mensaje WA");
        }
    } else {
        $nuevoId = $servicio->enviarAlGrupo($orden, prefijo: $banner);

        if ($nuevoId) {
            $this->notification()->success('ACTUALIZADO', "Orden #{$this->workOrderId} actualizada y se envió un aviso nuevo al grupo");
        } else {
            $this->notification()->warning('ACTUALIZADO PARCIALMENTE', "Orden #{$this->workOrderId} actualizada, pero no se pudo enviar el aviso al grupo");
        }
    }
} else {
    $this->notification()->success('ACTUALIZADO', "Orden #{$this->workOrderId} actualizada correctamente");
}
```

- `$hayFechaCambio` ya se calcula al inicio de `save()`.
- `enviarAlGrupo` sobrescribe `wa_message_id` + `wa_sent_at`, dejando el nuevo mensaje
  como referencia para futuras ediciones.

## Flujo de datos

```
EditModal::save()
  ├─ detecta cambios relevantes (incluye hayFechaCambio)
  ├─ orden->update(...)
  └─ si waEnviado && hayCambios:
        ├─ orden->puedeEditarMensaje()?
        │     ├─ sí  → editarMensaje(orden, banner)     [edita el existente]
        │     └─ no  → enviarAlGrupo(orden, banner)     [mensaje nuevo, refresca wa_sent_at]
        └─ notifica resultado
```

## Manejo de errores

- `editarMensaje` y `enviarAlGrupo` ya capturan excepciones y devuelven `false`/`null`
  ante fallos (device desconectado, Node caído). En esos casos se muestra
  "ACTUALIZADO PARCIALMENTE" — la orden sí se guardó.
- `puedeEditarMensaje()` es defensivo ante `wa_sent_at`/`wa_message_id` nulos.

## Pruebas

Test de feature para `EditModal` (`tests/Feature/Admin/WorkOrders/`):

1. **Edita dentro de la ventana:** orden con `wa_sent_at = now()`, estado editable,
   cambia la fecha → se llama `editarMensaje` (no `enviarAlGrupo`).
2. **Fallback fuera de la ventana:** orden con `wa_sent_at = now()->subMinutes(20)`,
   cambia la fecha → se llama `enviarAlGrupo` con banner `OT REPROGRAMADA`.
3. **Fallback por estado no editable:** orden `finalizado`/`cancelado` con cambios →
   `enviarAlGrupo`.
4. **Banner ACTUALIZADA:** fuera de ventana, cambia un dato que no es fecha → banner
   `OT ACTUALIZADA`.

Se mockea `WorkOrderNotificationService` (o se hace `Http::fake`) para verificar qué
método se invoca sin llamar al servidor Node real.

**Ejecución:** por preferencia registrada del usuario, **no** se corre
`php artisan test` (RefreshDatabase borra la BD real de desarrollo). Los archivos
tocados se validan con `php -l`. Los tests quedan en el repo para ejecutarse en un
entorno con BD de pruebas dedicada.

## Archivos afectados

- `database/migrations/XXXX_add_wa_sent_at_to_work_orders.php` (nuevo)
- `config/whatsapp.php` (añade `edit_window_minutes`)
- `app/Models/WorkOrder.php` (cast + helper `puedeEditarMensaje`)
- `app/Services/WorkOrderNotificationService.php` (`enviarAlGrupo` con prefijo + `wa_sent_at`)
- `app/Livewire/Admin/WorkOrders/EditModal.php` (decisión editar vs. mensaje nuevo)
- `tests/Feature/Admin/WorkOrders/...Test.php` (nuevo)

## Fuera de alcance (YAGNI)

- No se cambia el flujo de creación más allá de setear `wa_sent_at`.
- No se reenvía mensaje en cambios irrelevantes (observaciones, etc.) — sigue la lista
  de campos relevantes actual.
- No se muestra el detalle "fecha anterior → nueva" dentro del mensaje (se descartó a
  favor de banner + mensaje completo).
