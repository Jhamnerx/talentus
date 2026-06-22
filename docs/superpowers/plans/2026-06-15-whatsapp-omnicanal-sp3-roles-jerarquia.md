# SP#3 WhatsApp Omnicanal — Roles y Jerarquía: Plan de Implementación

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Añadir control de acceso de grano fino al inbox WhatsApp con tres niveles (Agente/Supervisor/Gerente) usando permisos Spatie y los Teams existentes, sin crear roles nuevos.

**Architecture:** Un scope `scopeVisibleTo` en `WhatsappConversation` calcula qué conversaciones puede ver cada usuario; una `WhatsappConversationPolicy` autoriza acciones individuales; los componentes Livewire llaman `Gate::authorize()` antes de ejecutar y las Actions añaden una guarda defensiva `Gate::forUser($actor)->authorize()`. El canal Reverb también verifica la policy. No hay `AuthServiceProvider`—todo va en `AppServiceProvider::boot()`.

**Tech Stack:** Laravel 12, Spatie Permissions, Livewire 4, Gate facade, DB::table (no Eloquent para las queries de `team_user`). Validación: `php -l` (NUNCA `php artisan test`). Correr semilla con `php artisan db:seed --class=...`.

---

## Contexto crítico para el implementador

- **Roles reales en la BD:** `admin, administracion, asistente administracion, cliente, contabilidad, finanzas, monitoreo, tecnico, ventas`. No existe `agente`, `supervisor`, ni `super-admin`.
- **`Gate::before`** en `AppServiceProvider::boot()` (línea 76): `return $user->email == 'jhamnerx1x@gmail.com' ?? null` — este usuario siempre pasa todos los gates. No modificar esto.
- **No existe `AuthServiceProvider.php`** — registrar la Policy en `AppServiceProvider::boot()` con `Gate::policy(...)`.
- **`Team::leaders()`** en el modelo usa `'leader'` (bug, no usar). Las queries directas usan `role_in_team = 'lider'` (con tilde).
- **`WhatsappConversation` no tiene `EmpresaScope`** como scope global — usa `scopeForTenant(int $empresaId)` explícito.
- **SP#1** ya creó el permiso `ver-whatsapp` y lo asignó al rol `admin`. Este seeder es idempotente (`firstOrCreate`).
- **NUNCA** `php artisan test`. Solo `php -l` para validar PHP.

---

## Mapa de archivos

| Acción | Archivo | Responsabilidad |
|--------|---------|-----------------|
| Crear | `database/seeders/WhatsappRolesPermissionsSeeder.php` | 3 permisos → rol admin |
| Modificar | `app/Models/WhatsFleep/WhatsappConversation.php` | + `scopeVisibleTo` |
| Crear | `app/Policies/WhatsFleep/WhatsappConversationPolicy.php` | Todas las reglas de acceso |
| Modificar | `app/Providers/AppServiceProvider.php` | `Gate::policy(...)` |
| Modificar | `routes/channels.php` | Canal conversation + policy check |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/ConversationList.php` | + `visibleTo` en la query |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/ConversationHeader.php` | `Gate::authorize` + agentes filtrados |
| Modificar | `resources/views/livewire/admin/whats-fleep/inbox/conversation-header.blade.php` | `@can` guards en botones |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php` | `Gate::authorize('view')` en mount |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/MessageComposer.php` | `Gate::authorize('reply')` en sends |
| Modificar | `app/Actions/WhatsFleep/AssignConversationAction.php` | guarda defensiva `reassign` |
| Modificar | `app/Actions/WhatsFleep/ChangeConversationStatusAction.php` | guarda defensiva `changeStatus` |
| Modificar | `app/Actions/WhatsFleep/SendWhatsappMessageAction.php` | guarda defensiva `reply` |
| Modificar | `app/Actions/WhatsFleep/SendWhatsappMediaAction.php` | guarda defensiva `reply` |

---

## Task 1: Seeder de permisos WhatsApp (idempotente)

**Files:**
- Create: `database/seeders/WhatsappRolesPermissionsSeeder.php`

- [ ] **Step 1: Crear el seeder**

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WhatsappRolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'ver-whatsapp',       // Agente: SP#1 ya lo creó — firstOrCreate lo tolera
            'ver-whatsapp-area',  // Supervisor
            'ver-whatsapp-todos', // Gerente
        ];

        $createdPermissions = [];
        foreach ($permissions as $name) {
            $createdPermissions[] = Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($createdPermissions);
        }
    }
}
```

- [ ] **Step 2: Validar sintaxis**

```bash
php -l database/seeders/WhatsappRolesPermissionsSeeder.php
```

Esperado: `No syntax errors detected`

- [ ] **Step 3: Correr el seeder**

```bash
php artisan db:seed --class=WhatsappRolesPermissionsSeeder
```

Esperado: proceso completo sin errores.

- [ ] **Step 4: Verificar que los 3 permisos existen y están en admin**

```bash
php -r "require 'vendor/autoload.php'; \$a=require 'bootstrap/app.php'; \$a->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo Spatie\Permission\Models\Role::where('name','admin')->first()->permissions->pluck('name')->implode(', ').PHP_EOL;"
```

Esperado: la salida incluye `ver-whatsapp, ver-whatsapp-area, ver-whatsapp-todos` (entre otros permisos).

- [ ] **Step 5: Commit**

```bash
git add database/seeders/WhatsappRolesPermissionsSeeder.php
git commit -m "feat(wa-sp3): idempotent permissions seeder (ver-whatsapp-area, ver-whatsapp-todos)"
```

---

## Task 2: `scopeVisibleTo` en `WhatsappConversation`

**Files:**
- Modify: `app/Models/WhatsFleep/WhatsappConversation.php`

El scope evalúa el nivel del usuario y aplica la cláusula WHERE correcta. Usa `DB::table('team_user')` directamente (no el método `leaders()` del modelo Team, que tiene un bug usando `'leader'` en vez de `'lider'`).

- [ ] **Step 1: Añadir el scope al modelo**

Añadir estos imports al bloque `use` del archivo:

```php
use Illuminate\Support\Facades\DB;
```

Luego añadir el método al final del modelo, antes del cierre de la clase `}`:

```php
/**
 * Filtra conversaciones según el nivel de acceso del usuario.
 * Requiere que forTenant() se haya aplicado antes (empresa_id ya filtrado).
 *
 * Gerente (ver-whatsapp-todos): todo.
 * Supervisor (ver-whatsapp-area): miembros de sus Teams liderados + propias + sin asignar.
 * Agente (ver-whatsapp): propias + sin asignar.
 */
public function scopeVisibleTo(Builder $query, User $user): Builder
{
    if ($user->can('ver-whatsapp-todos')) {
        return $query;
    }

    if ($user->can('ver-whatsapp-area')) {
        $leaderTeamIds = DB::table('team_user')
            ->where('user_id', $user->id)
            ->where('role_in_team', 'lider')
            ->pluck('team_id');

        $memberIds = DB::table('team_user')
            ->whereIn('team_id', $leaderTeamIds)
            ->pluck('user_id')
            ->unique()
            ->all();

        return $query->where(function (Builder $q) use ($user, $memberIds) {
            $q->whereIn('assigned_user_id', $memberIds)
              ->orWhere('assigned_user_id', $user->id)
              ->orWhereNull('assigned_user_id');
        });
    }

    // Agente: solo sus conversaciones + el pool sin asignar
    return $query->where(function (Builder $q) use ($user) {
        $q->where('assigned_user_id', $user->id)
          ->orWhereNull('assigned_user_id');
    });
}
```

- [ ] **Step 2: Validar sintaxis**

```bash
php -l app/Models/WhatsFleep/WhatsappConversation.php
```

Esperado: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Models/WhatsFleep/WhatsappConversation.php
git commit -m "feat(wa-sp3): scopeVisibleTo on WhatsappConversation (3-level access)"
```

---

## Task 3: `WhatsappConversationPolicy` + registro en AppServiceProvider

**Files:**
- Create: `app/Policies/WhatsFleep/WhatsappConversationPolicy.php`
- Modify: `app/Providers/AppServiceProvider.php`

- [ ] **Step 1: Crear el directorio si no existe**

```bash
mkdir -p app/Policies/WhatsFleep
```

- [ ] **Step 2: Crear la Policy**

```php
<?php

namespace App\Policies\WhatsFleep;

use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\DB;

class WhatsappConversationPolicy
{
    /** Cualquiera con al menos un permiso WhatsApp puede listar. */
    public function viewAny(User $user): bool
    {
        return $user->canAny(['ver-whatsapp', 'ver-whatsapp-area', 'ver-whatsapp-todos']);
    }

    /** La conversación está en el rango visible del usuario. */
    public function view(User $user, WhatsappConversation $conversation): bool
    {
        if ((int) $conversation->empresa_id !== (int) session('empresa', 1)) {
            return false;
        }

        if ($user->can('ver-whatsapp-todos')) {
            return true;
        }

        if ($user->can('ver-whatsapp-area')) {
            if ($conversation->assigned_user_id === null) {
                return true;
            }
            if ($conversation->assigned_user_id === $user->id) {
                return true;
            }

            $leaderTeamIds = DB::table('team_user')
                ->where('user_id', $user->id)
                ->where('role_in_team', 'lider')
                ->pluck('team_id');

            return DB::table('team_user')
                ->whereIn('team_id', $leaderTeamIds)
                ->where('user_id', $conversation->assigned_user_id)
                ->exists();
        }

        // Agente
        return $conversation->assigned_user_id === $user->id
            || $conversation->assigned_user_id === null;
    }

    /** Enviar un mensaje (texto o adjunto). */
    public function reply(User $user, WhatsappConversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    /** Cambiar estado (cerrar, reabrir, pendiente). */
    public function changeStatus(User $user, WhatsappConversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    /** Cambiar prioridad. */
    public function setPriority(User $user, WhatsappConversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    /** Asignarse a sí mismo. */
    public function assignToSelf(User $user, WhatsappConversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }

    /**
     * Reasignar a otro usuario.
     * Gerente: a cualquiera. Supervisor: a miembros de su área. Agente: no puede.
     */
    public function reassign(User $user, WhatsappConversation $conversation): bool
    {
        if ($user->can('ver-whatsapp-todos')) {
            return true;
        }

        if ($user->can('ver-whatsapp-area')) {
            return $this->view($user, $conversation);
        }

        return false;
    }
}
```

- [ ] **Step 3: Validar sintaxis**

```bash
php -l app/Policies/WhatsFleep/WhatsappConversationPolicy.php
```

Esperado: `No syntax errors detected`

- [ ] **Step 4: Registrar la Policy en `AppServiceProvider::boot()`**

En `app/Providers/AppServiceProvider.php`, al inicio del método `boot()`, después de `Schema::defaultStringLength(191);`, añadir:

```php
Gate::policy(
    \App\Models\WhatsFleep\WhatsappConversation::class,
    \App\Policies\WhatsFleep\WhatsappConversationPolicy::class
);
```

(El `use Illuminate\Support\Facades\Gate;` ya existe en el archivo.)

- [ ] **Step 5: Validar sintaxis**

```bash
php -l app/Providers/AppServiceProvider.php
```

Esperado: `No syntax errors detected`

- [ ] **Step 6: Verificar que la policy se resuelve**

```bash
php -r "require 'vendor/autoload.php'; \$a=require 'bootstrap/app.php'; \$a->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); \$p=app(Illuminate\Contracts\Auth\Access\Gate::class)->getPolicyFor(App\Models\WhatsFleep\WhatsappConversation::class); echo get_class(\$p).PHP_EOL;"
```

Esperado: `App\Policies\WhatsFleep\WhatsappConversationPolicy`

- [ ] **Step 7: Commit**

```bash
git add app/Policies/WhatsFleep/WhatsappConversationPolicy.php app/Providers/AppServiceProvider.php
git commit -m "feat(wa-sp3): WhatsappConversationPolicy + register in AppServiceProvider"
```

---

## Task 4: Actualizar canal Reverb `whatsapp.conversation.{uuid}`

**Files:**
- Modify: `routes/channels.php`

El canal actualmente solo verifica `empresa_id`. Añadir verificación de policy `view`.

- [ ] **Step 1: Actualizar el callback del canal**

Reemplazar el canal existente:

```php
Broadcast::channel('whatsapp.conversation.{uuid}', function ($user, $uuid) {
    $conversation = \App\Models\WhatsFleep\WhatsappConversation::where('uuid', $uuid)->first();

    return $conversation !== null
        && (int) $conversation->empresa_id === (int) session('empresa', 1);
});
```

Por:

```php
Broadcast::channel('whatsapp.conversation.{uuid}', function ($user, $uuid) {
    $conversation = \App\Models\WhatsFleep\WhatsappConversation::where('uuid', $uuid)->first();

    if ($conversation === null) {
        return false;
    }

    if ((int) $conversation->empresa_id !== (int) session('empresa', 1)) {
        return false;
    }

    return $user->can('view', $conversation);
});
```

- [ ] **Step 2: Validar sintaxis**

```bash
php -l routes/channels.php
```

Esperado: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add routes/channels.php
git commit -m "feat(wa-sp3): enforce policy view check on conversation broadcast channel"
```

---

## Task 5: `ConversationList` — aplicar `scopeVisibleTo`

**Files:**
- Modify: `app/Livewire/Admin/WhatsFleep/Inbox/ConversationList.php`

- [ ] **Step 1: Actualizar `render()`**

En el método `render()`, cambiar:

```php
$query = WhatsappConversation::query()
    ->forTenant($empresaId)
    ->with(['contact', 'cliente', 'lastMessage', 'assignedUser'])
    ->where('status', $this->estado);
```

Por:

```php
$query = WhatsappConversation::query()
    ->forTenant($empresaId)
    ->visibleTo(Auth::user())
    ->with(['contact', 'cliente', 'lastMessage', 'assignedUser'])
    ->where('status', $this->estado);
```

- [ ] **Step 2: Validar sintaxis**

```bash
php -l app/Livewire/Admin/WhatsFleep/Inbox/ConversationList.php
```

Esperado: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/ConversationList.php
git commit -m "feat(wa-sp3): ConversationList uses visibleTo scope for access-controlled listing"
```

---

## Task 6: `ConversationHeader` — autorización + agentes filtrados

**Files:**
- Modify: `app/Livewire/Admin/WhatsFleep/Inbox/ConversationHeader.php`
- Modify: `resources/views/livewire/admin/whats-fleep/inbox/conversation-header.blade.php`

### PHP

- [ ] **Step 1: Actualizar `ConversationHeader.php`**

Reemplazar el archivo entero con:

```php
<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\AssignConversationAction;
use App\Actions\WhatsFleep\ChangeConversationStatusAction;
use App\Enums\WhatsFleep\ConversationPriority;
use App\Enums\WhatsFleep\ConversationStatus;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ConversationHeader extends Component
{
    public string $uuid;
    public ?int $reassignTo = null;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function assignToMe(): void
    {
        $conversation = $this->conversation();
        if (!$conversation) {
            return;
        }

        Gate::authorize('assignToSelf', $conversation);

        app(AssignConversationAction::class)->execute($conversation, Auth::id(), Auth::user());
        $this->dispatch('conversation-updated');
    }

    public function reassign(): void
    {
        $conversation = $this->conversation();
        if (!$conversation || !$this->reassignTo) {
            return;
        }

        Gate::authorize('reassign', $conversation);

        app(AssignConversationAction::class)->execute($conversation, $this->reassignTo, Auth::user());
        $this->reset('reassignTo');
        $this->dispatch('conversation-updated');
    }

    public function setStatus(string $status): void
    {
        $conversation = $this->conversation();
        if (!$conversation) {
            return;
        }

        Gate::authorize('changeStatus', $conversation);

        app(ChangeConversationStatusAction::class)->execute($conversation, ConversationStatus::from($status));
        $this->dispatch('conversation-updated');
    }

    public function setPriority(string $priority): void
    {
        $conversation = $this->conversation();
        if (!$conversation) {
            return;
        }

        Gate::authorize('setPriority', $conversation);

        $conversation->forceFill(['priority' => ConversationPriority::from($priority)])->save();
        $this->dispatch('conversation-updated');
    }

    private function conversation(): ?WhatsappConversation
    {
        return WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $conversation = WhatsappConversation::with(['contact', 'cliente', 'assignedUser'])
            ->where('uuid', $this->uuid)
            ->first();

        $user = Auth::user();
        $agents = $this->resolveAgentsList($user);

        return view('livewire.admin.whats-fleep.inbox.conversation-header', [
            'conversation' => $conversation,
            'agents' => $agents,
        ]);
    }

    /**
     * Gerente: todos los usuarios con algún permiso WhatsApp.
     * Supervisor: solo miembros de sus equipos liderados.
     * Agente: lista vacía (no puede reasignar).
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    private function resolveAgentsList(User $user): \Illuminate\Database\Eloquent\Collection
    {
        if ($user->can('ver-whatsapp-todos')) {
            return User::permission(['ver-whatsapp', 'ver-whatsapp-area', 'ver-whatsapp-todos'])
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        if ($user->can('ver-whatsapp-area')) {
            $leaderTeamIds = DB::table('team_user')
                ->where('user_id', $user->id)
                ->where('role_in_team', 'lider')
                ->pluck('team_id');

            $memberIds = DB::table('team_user')
                ->whereIn('team_id', $leaderTeamIds)
                ->pluck('user_id')
                ->unique()
                ->all();

            return User::whereIn('id', $memberIds)
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        return collect();
    }
}
```

- [ ] **Step 2: Validar sintaxis**

```bash
php -l app/Livewire/Admin/WhatsFleep/Inbox/ConversationHeader.php
```

Esperado: `No syntax errors detected`

### Blade

- [ ] **Step 3: Añadir `@can` guards en el Blade**

Abrir `resources/views/livewire/admin/whats-fleep/inbox/conversation-header.blade.php`.

Localizar el botón "Asignarme" y envolverlo:

```blade
@can('assignToSelf', $conversation)
    {{-- BOTÓN ASIGNARME (código existente) --}}
@endcan
```

Localizar los botones "Cerrar"/"Reabrir" y envolverlos:

```blade
@can('changeStatus', $conversation)
    {{-- BOTONES CERRAR/REABRIR (código existente) --}}
@endcan
```

Localizar el select de reasignación + su botón y envolverlos:

```blade
@can('reassign', $conversation)
    {{-- SELECT AGENTES + BOTÓN APLICAR (código existente) --}}
@endcan
```

Localizar el menú de prioridad y envolverlo:

```blade
@can('setPriority', $conversation)
    {{-- MENÚ PRIORIDAD (código existente) --}}
@endcan
```

**IMPORTANTE:** Si `$conversation` puede ser `null` (cuando aún no hay conversación seleccionada), usar guard nulo:

```blade
@if($conversation)
    @can('assignToSelf', $conversation)
        ...
    @endcan
@endif
```

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/ConversationHeader.php resources/views/livewire/admin/whats-fleep/inbox/conversation-header.blade.php
git commit -m "feat(wa-sp3): ConversationHeader authorize actions + filtered agents by permission level"
```

---

## Task 7: `ConversationView` y `MessageComposer` — authorize

**Files:**
- Modify: `app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php`
- Modify: `app/Livewire/Admin/WhatsFleep/Inbox/MessageComposer.php`

### ConversationView

- [ ] **Step 1: Añadir `Gate::authorize('view')` en `mount()`**

Añadir `use Illuminate\Support\Facades\Gate;` al bloque de imports.

Reemplazar el método `mount()`:

```php
public function mount(string $uuid): void
{
    $this->uuid = $uuid;

    $conversation = $this->conversation();
    if ($conversation) {
        Gate::authorize('view', $conversation);
    }

    $this->markRead();
}
```

- [ ] **Step 2: Validar sintaxis**

```bash
php -l app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php
```

Esperado: `No syntax errors detected`

### MessageComposer

- [ ] **Step 3: Añadir `Gate::authorize('reply')` en los métodos de envío**

Añadir `use Illuminate\Support\Facades\Gate;` al bloque de imports.

Reemplazar el inicio de `sendText()`:

```php
public function sendText(): void
{
    $body = trim($this->body);
    if ($body === '') {
        return;
    }

    $conversation = $this->conversation();
    if (!$conversation) {
        return;
    }

    Gate::authorize('reply', $conversation);

    app(SendWhatsappMessageAction::class)->execute($conversation, Auth::user(), $body);

    $this->reset('body');
    $this->dispatch('message-sent');
}
```

Reemplazar el inicio de `sendAttachment()`:

```php
public function sendAttachment(): void
{
    $this->validate([
        'attachment' => ['required', 'file', 'max:16384'],
    ]);

    $conversation = $this->conversation();
    if (!$conversation) {
        return;
    }

    Gate::authorize('reply', $conversation);

    // ... resto del método sin cambios ...
```

- [ ] **Step 4: Validar sintaxis**

```bash
php -l app/Livewire/Admin/WhatsFleep/Inbox/MessageComposer.php
```

Esperado: `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php app/Livewire/Admin/WhatsFleep/Inbox/MessageComposer.php
git commit -m "feat(wa-sp3): ConversationView + MessageComposer enforce Gate authorize on view/reply"
```

---

## Task 8: Guardas defensivas en las 4 Actions

**Files:**
- Modify: `app/Actions/WhatsFleep/AssignConversationAction.php`
- Modify: `app/Actions/WhatsFleep/ChangeConversationStatusAction.php`
- Modify: `app/Actions/WhatsFleep/SendWhatsappMessageAction.php`
- Modify: `app/Actions/WhatsFleep/SendWhatsappMediaAction.php`

Cada Action recibe el actor (User) y verifica el permiso con `Gate::forUser($actor)->authorize(...)` antes de ejecutar la lógica. Esto es una segunda línea de defensa (el componente ya autorizó).

### AssignConversationAction

- [ ] **Step 1: Añadir guarda defensiva**

Añadir `use Illuminate\Support\Facades\Gate;` a los imports.

Añadir al inicio de `execute()`, antes del bloque `if ($fromUserId === $toUserId)`:

```php
Gate::forUser($actor)->authorize('reassign', $conversation);
```

El método `execute()` queda:

```php
public function execute(WhatsappConversation $conversation, ?int $toUserId, User $actor): WhatsappConversation
{
    Gate::forUser($actor)->authorize('reassign', $conversation);

    $fromUserId = $conversation->assigned_user_id;

    if ($fromUserId === $toUserId) {
        return $conversation;
    }
    // ... resto sin cambios
```

### ChangeConversationStatusAction

- [ ] **Step 2: Añadir guarda defensiva**

La firma actual es `execute(WhatsappConversation $conversation, ConversationStatus $status)` — no recibe actor. Necesitamos añadir el actor. Cambiar la firma:

```php
public function execute(WhatsappConversation $conversation, ConversationStatus $status, User $actor): WhatsappConversation
{
    Gate::forUser($actor)->authorize('changeStatus', $conversation);

    $conversation->forceFill([
        'status' => $status,
        'closed_at' => $status === ConversationStatus::Closed ? now() : null,
    ])->save();

    broadcast(new ConversationUpdated($conversation));

    return $conversation;
}
```

Añadir `use App\Models\User;` y `use Illuminate\Support\Facades\Gate;` a los imports.

**Actualizar la llamada en `ConversationHeader::setStatus()`** para pasar el actor:

```php
app(ChangeConversationStatusAction::class)->execute($conversation, ConversationStatus::from($status), Auth::user());
```

### SendWhatsappMessageAction

- [ ] **Step 3: Añadir guarda defensiva**

La firma actual es `execute(WhatsappConversation $conversation, User $sender, string $body)`. Añadir al inicio de `execute()`:

```php
Gate::forUser($sender)->authorize('reply', $conversation);
```

Añadir `use Illuminate\Support\Facades\Gate;` a los imports.

### SendWhatsappMediaAction

- [ ] **Step 4: Añadir guarda defensiva**

La firma actual es `execute(WhatsappConversation $conversation, User $sender, MessageType $type, array $media)`. Añadir al inicio de `execute()`:

```php
Gate::forUser($sender)->authorize('reply', $conversation);
```

Añadir `use Illuminate\Support\Facades\Gate;` a los imports.

- [ ] **Step 5: Validar sintaxis de las 4 Actions**

```bash
php -l app/Actions/WhatsFleep/AssignConversationAction.php
php -l app/Actions/WhatsFleep/ChangeConversationStatusAction.php
php -l app/Actions/WhatsFleep/SendWhatsappMessageAction.php
php -l app/Actions/WhatsFleep/SendWhatsappMediaAction.php
```

Esperado: `No syntax errors detected` en cada uno.

- [ ] **Step 6: Commit**

```bash
git add app/Actions/WhatsFleep/AssignConversationAction.php app/Actions/WhatsFleep/ChangeConversationStatusAction.php app/Actions/WhatsFleep/SendWhatsappMessageAction.php app/Actions/WhatsFleep/SendWhatsappMediaAction.php
git commit -m "feat(wa-sp3): defensive Gate::authorize guards in all 4 WhatsApp Actions"
```

---

## Verificación final de humo

- [ ] **Listar todas las rutas WhatsApp para confirmar que no hay regresiones:**

```bash
php artisan route:list 2>&1 | grep -v "imagick" | grep -i whatsapp
```

Esperado: `whatsapp.inbox`, `whatsapp.media`, `whatsapp.quick-replies.index` aparecen con sus middleware correctos.

- [ ] **Verificar que la Policy se resuelve correctamente:**

```bash
php -r "require 'vendor/autoload.php'; \$a=require 'bootstrap/app.php'; \$a->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo get_class(app(Illuminate\Contracts\Auth\Access\Gate::class)->getPolicyFor(App\Models\WhatsFleep\WhatsappConversation::class)).PHP_EOL;"
```

Esperado: `App\Policies\WhatsFleep\WhatsappConversationPolicy`

- [ ] **Verificar permisos del rol admin:**

```bash
php -r "require 'vendor/autoload.php'; \$a=require 'bootstrap/app.php'; \$a->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo Spatie\Permission\Models\Role::where('name','admin')->first()->permissions->whereIn('name',['ver-whatsapp','ver-whatsapp-area','ver-whatsapp-todos'])->pluck('name')->implode(', ').PHP_EOL;"
```

Esperado: `ver-whatsapp, ver-whatsapp-area, ver-whatsapp-todos`

---

## Notas de implementación

1. **`ChangeConversationStatusAction` requiere un cambio de firma** (Task 8 step 2). Actualizar la llamada en `ConversationHeader::setStatus()` en la misma operación o el compilador fallará.

2. **`Gate::before` en `AppServiceProvider`** concede todo a `jhamnerx1x@gmail.com`. Esto significa que en desarrollo el propietario pasa todos los gates independientemente — útil para probar sin asignar permisos.

3. **`php -l` no valida el comportamiento en runtime** — verifica solo la sintaxis PHP. La prueba de humo final confirma que los módulos se resuelven correctamente.

4. **Permisos Spatie se cachean.** En producción, después de correr el seeder: `php artisan permission:cache-reset` (o `php artisan cache:clear`).
