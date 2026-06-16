# SP#3 WhatsApp Omnicanal — Políticas, Roles y Jerarquía

**Fecha:** 2026-06-15
**Rama:** `feature/whatsapp-omnicanal-sp1`
**Contexto:** Construye sobre SP#1 (backend de persistencia) y SP#2 (inbox en tiempo real). Añade control de acceso de grano fino sin modificar el sistema de roles existente.

---

## 1. Objetivo

Restringir qué conversaciones puede ver y accionar cada usuario según su nivel de permiso de WhatsApp, usando la infraestructura de Teams y Spatie Permissions ya existente. Sin roles nuevos.

---

## 2. Niveles de acceso

Tres permisos Spatie, asignables independientemente a cualquier rol o usuario:

| Permiso | Nivel | Alcance de visibilidad |
|---------|-------|------------------------|
| `ver-whatsapp` | Agente | Sus conversaciones asignadas + pool sin asignar |
| `ver-whatsapp-area` | Supervisor | Conversaciones de miembros de sus Teams (lider) + pool sin asignar + las suyas |
| `ver-whatsapp-todos` | Gerente | Todas las conversaciones de la empresa |

**Reglas de prioridad:**
- Un usuario con `ver-whatsapp-todos` pasa directamente al nivel Gerente, sin importar otros permisos.
- Un usuario con `ver-whatsapp-area` (y sin `ver-whatsapp-todos`) es Supervisor.
- Un usuario solo con `ver-whatsapp` es Agente.
- El rol `admin` (Spatie) obtiene `ver-whatsapp-todos` automáticamente vía seeder.
- Sin ningún permiso WhatsApp → el gate `can:ver-whatsapp` de la ruta ya bloquea el acceso.

**Área del Supervisor:** Los Teams donde el usuario tiene `role_in_team = 'lider'` (pivote de `team_user`). El "área" se deriva en runtime: `$user->teams()->wherePivot('role_in_team', 'lider')->pluck('id')` → lista de `user_id` de esos equipos.

---

## 3. Scope de visibilidad — `WhatsappConversation::scopeVisibleTo`

Método `scopeVisibleTo(Builder $query, User $user): Builder` añadido al modelo `WhatsappConversation`.

```
Gerente (ver-whatsapp-todos):
    → sin restricción adicional (forTenant ya filtra por empresa_id)

Supervisor (ver-whatsapp-area, sin todos):
    → WHERE (assigned_user_id IN (miembros de mis Teams liderados))
         OR (assigned_user_id = $user->id)
         OR (assigned_user_id IS NULL)

Agente (solo ver-whatsapp):
    → WHERE (assigned_user_id = $user->id)
         OR (assigned_user_id IS NULL)
```

La query de `ConversationList` en SP#2 cambia de `->forTenant($empresaId)` a `->forTenant($empresaId)->visibleTo(Auth::user())`.

---

## 4. Policy — `WhatsappConversationPolicy`

**Archivo:** `app/Policies/WhatsFleep/WhatsappConversationPolicy.php`
**Registro:** en `app/Providers/AuthServiceProvider.php` → `$policies` array.

Métodos y reglas:

| Método | Gerente | Supervisor | Agente |
|--------|---------|------------|--------|
| `viewAny` | ✅ | ✅ | ✅ |
| `view($conversation)` | ✅ | si en su área o es suya o sin asignar | si es suya o sin asignar |
| `reply($conversation)` | = view | = view | = view |
| `changeStatus($conversation)` | ✅ | = view | = view |
| `setPriority($conversation)` | ✅ | = view | = view |
| `assignToSelf($conversation)` | ✅ | = view | = view (solo a sí mismo) |
| `reassign($conversation)` | ✅ (cualquier agente) | ✅ (solo a miembros de su área) | ❌ |

**Lógica de `view`:** delega a `scopeVisibleTo` — si la conversación existe en el resultado del scope, el usuario puede verla. Implementación: consulta si `WhatsappConversation::forTenant()->visibleTo($user)->where('id', $conversation->id)->exists()`.

---

## 5. Aplicación del control de acceso

### 5.1 Componentes Livewire (SP#2)

`ConversationHeader` (assign, reassign, setStatus, setPriority):
- Cada método llama `$this->authorize('permiso', $conversation)` antes de ejecutar la Action.
- La vista oculta/deshabilita botones que el usuario no puede usar (evalúa `Auth::user()->can('reassign', $conversation)` etc. en Blade).

`ConversationView` (mount + markRead):
- `mount()` verifica `$this->authorize('view', $conversation)` — si falla, Livewire lanza 403.

`MessageComposer` (sendText, sendAttachment):
- `$this->authorize('reply', $conversation)` al inicio de cada método.

`ContactPanel`:
- Solo lectura, no requiere autorización extra (ya cubierta por el canal Reverb).

### 5.2 Actions (guarda defensiva)

Las Actions de SP#2 añaden un check interno como segunda línea de defensa:
- `AssignConversationAction`: verifica que el actor pueda `reassign` la conversación.
- `ChangeConversationStatusAction`: verifica `changeStatus`.
- `SendWhatsappMessageAction` / `SendWhatsappMediaAction`: verifican `reply`.
- `MarkConversationReadAction`: sin restricción (cualquiera que vea puede marcar).

Las Actions lanzan `AuthorizationException` si el check falla — no devuelven false silenciosamente.

### 5.3 Canal Reverb `whatsapp.conversation.{uuid}`

`routes/channels.php` — callback del canal `whatsapp.conversation.{uuid}` se actualiza para también verificar que el usuario pueda ver la conversación:

```php
return $conversation !== null
    && (int) $conversation->empresa_id === (int) session('empresa', 1)
    && $user->can('view', $conversation);
```

---

## 6. Lista de agentes en ConversationHeader

`ConversationHeader::render()` actualmente hace `User::orderBy('name')->get(['id','name'])` sin filtro.

Se reemplaza por usuarios que tengan alguno de los permisos de WhatsApp en la empresa activa:

```php
$agents = User::whereHas('permissions', fn($q) =>
    $q->whereIn('name', ['ver-whatsapp', 'ver-whatsapp-area', 'ver-whatsapp-todos'])
)->orWhereHas('roles.permissions', fn($q) =>
    $q->whereIn('name', ['ver-whatsapp', 'ver-whatsapp-area', 'ver-whatsapp-todos'])
)->orderBy('name')->get(['id', 'name']);
```

Además, si el actor es Supervisor, el selector de reasignación solo muestra usuarios de su área (miembros de sus Teams).

---

## 7. Seeder — `WhatsappRolesPermissionsSeeder`

Crea los 3 permisos si no existen y los asigna:

```
ver-whatsapp        → rol 'admin'
ver-whatsapp-area   → rol 'admin'
ver-whatsapp-todos  → rol 'admin'
```

(SP#1 ya creó `ver-whatsapp` en `WhatsappPermissionsSeeder`. Este seeder usa `firstOrCreate` y es idempotente.)

El seeder se registra en `DatabaseSeeder` y puede correr en producción con `php artisan db:seed --class=WhatsappRolesPermissionsSeeder`.

---

## 8. Fuera del alcance (próximos SPs)

- Notificaciones push/email al asignar (SP#5).
- Analítica y tiempos de respuesta.
- Corrección de `TicketPolicy` (que referencia roles inexistentes como `agente/super-admin` — deuda pre-existente).
- SLA / escalaciones automáticas.

---

## 9. Archivos a crear/modificar

| Acción | Archivo |
|--------|---------|
| Crear | `app/Policies/WhatsFleep/WhatsappConversationPolicy.php` |
| Crear | `database/seeders/WhatsappRolesPermissionsSeeder.php` |
| Modificar | `app/Models/WhatsFleep/WhatsappConversation.php` — añadir `scopeVisibleTo` |
| Modificar | `app/Providers/AuthServiceProvider.php` — registrar Policy |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/ConversationList.php` — usar `visibleTo` |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/ConversationHeader.php` — authorize + agentes filtrados |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php` — authorize view |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/MessageComposer.php` — authorize reply |
| Modificar | `app/Actions/WhatsFleep/AssignConversationAction.php` — guarda defensiva |
| Modificar | `app/Actions/WhatsFleep/ChangeConversationStatusAction.php` — guarda defensiva |
| Modificar | `app/Actions/WhatsFleep/SendWhatsappMessageAction.php` — guarda defensiva |
| Modificar | `app/Actions/WhatsFleep/SendWhatsappMediaAction.php` — guarda defensiva |
| Modificar | `routes/channels.php` — canal conversation con policy check |
| Modificar | Blades de ConversationHeader — ocultar botones según permisos |

---

## 10. Criterios de aceptación

- Un usuario solo con `ver-whatsapp` no ve conversaciones asignadas a otros, y no puede reasignar.
- Un usuario con `ver-whatsapp-area` ve conversaciones de su equipo y puede reasignar dentro de él.
- Un usuario con `ver-whatsapp-todos` ve todo y puede reasignar a cualquiera.
- El canal Reverb `whatsapp.conversation.{uuid}` no autoriza a usuarios sin acceso a esa conversación.
- Asignar/cerrar/contestar desde el Inbox devuelve 403 si el usuario no tiene permiso (tanto en Livewire como en la Action).
- El seeder es idempotente (se puede correr varias veces sin duplicar permisos).
