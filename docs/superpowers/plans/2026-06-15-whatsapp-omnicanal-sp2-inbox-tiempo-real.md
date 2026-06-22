# WhatsApp Omnicanal · SP#2 Inbox en Tiempo Real (UI + Reverb) — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Un inbox multiagente en vivo estilo WhatsApp Web sobre el backend de SP#1, con Reverb cableado, asignación, composer (texto/adjuntos/quick replies) y media privada.

**Architecture:** Se instala y cablea Laravel Reverb para que los eventos `ShouldBroadcast` de SP#1 lleguen al navegador vía Echo. La UI son 6 componentes Livewire 4 pequeños bajo un contenedor full-page, comunicados por eventos Livewire y refrescados por canales privados `whatsapp.empresa.{id}` y `whatsapp.conversation.{uuid}`. El envío saliente (texto/adjuntos) reusa/extiende las Actions de SP#1; los adjuntos viven en disco privado y se sirven por ruta autenticada.

**Tech Stack:** Laravel 12, Livewire 4, Reverb, laravel-echo + pusher-js, Tailwind v4, Alpine, MySQL, Node/Baileys.

> **Restricción de validación (OVERRIDE del usuario):** NUNCA ejecutar `php artisan test` (usa la BD real con `RefreshDatabase`). Validar PHP con `php -l`, JS con `node --check`, assets con `npm run build`. `php artisan migrate`/`route:list`/`config:clear` son seguros. No hacer push salvo que el usuario lo pida.
>
> **Skills de UI:** en cada tarea de Blade, ACTIVAR las skills `frontend-design` (`.agents/skills/frontend-design/SKILL.md`) y `tailwindcss-development` para el acabado visual (WhatsApp Web profesional, dark mode). El plan fija el **contrato funcional** (bindings `wire:`, hooks de tiempo real, estructura); la estética se genera con esas skills.

**Spec:** `docs/superpowers/specs/2026-06-15-whatsapp-omnicanal-sp2-inbox-tiempo-real-design.md`
**Rama:** continuar en `feature/whatsapp-omnicanal-sp1` (o nueva `feature/whatsapp-omnicanal-sp2` desde ella — a decidir al ejecutar).

---

## File Structure

**Infra tiempo real**
- `composer require laravel/reverb` → genera `config/reverb.php`, edita `config/broadcasting.php`
- Modify `.env` / `.env.example` (`BROADCAST_DRIVER=reverb`)
- Modify `resources/js/bootstrap.js` (Echo→Reverb)
- Modify `routes/channels.php` (2 canales)

**SP#1 cleanup**
- Modify `routes/web.php` + `app/Models/WhatsFleep/WhatsappMessage.php` (rename `admin.whatsapp.media`→`whatsapp.media`)

**Quick replies**
- Create migración `*_create_whatsapp_quick_replies_table.php`, modelo `WhatsappQuickReply.php`
- Create `app/Livewire/Admin/Ajustes/WhatsApp/QuickReplies/{Index,Save,Delete}.php` + Blade

**Backend Actions**
- Create `app/Actions/WhatsFleep/{SendWhatsappMediaAction,MarkConversationReadAction,AssignConversationAction,ChangeConversationStatusAction}.php`

**Inbox**
- Create `app/Http/Controllers/Admin/WhatsFleep/InboxController.php`; Modify `routes/web.php`
- Create `database/seeders/WhatsappPermissionsSeeder.php`
- Create `app/Livewire/Admin/WhatsFleep/Inbox/{Index,ConversationList,ConversationHeader,ConversationView,MessageComposer,ContactPanel}.php` + Blade
- Create vista contenedora `resources/views/admin/whatsapp/inbox.blade.php`

---

## Task 1: Instalar y configurar Reverb (backend)

**Files:**
- Run: `composer require laravel/reverb`
- Modify: `.env`, `.env.example`, `config/broadcasting.php` (lo edita el installer)

- [ ] **Step 1: Instalar Reverb**

Run: `composer require laravel/reverb`
Expected: instala `laravel/reverb`; aparece en `composer.json`.

- [ ] **Step 2: Ejecutar el instalador**

Run: `php artisan reverb:install --no-interaction`
Expected: crea `config/reverb.php`, añade la conexión `reverb` a `config/broadcasting.php`, registra broadcasting y descomenta `routes/channels.php`. Si pregunta por sobrescribir, aceptar defaults.

- [ ] **Step 3: Verificar/forzar el driver**

`config/broadcasting.php` (estructura Laravel 10) puede seguir leyendo `BROADCAST_DRIVER`. Confirma que el default de broadcasting apunte a `reverb`. Si el archivo usa `env('BROADCAST_DRIVER', ...)`, añade a `.env` y `.env.example`:
```
BROADCAST_DRIVER=reverb
```
(Mantén `BROADCAST_CONNECTION=reverb` si ya existe.)

- [ ] **Step 4: Verificar**

Run: `php artisan config:clear && php -r "require 'vendor/autoload.php'; \$a=require 'bootstrap/app.php'; \$a->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); echo config('broadcasting.default').PHP_EOL;"`
Expected: imprime `reverb`.
Run: `php artisan list | grep reverb`
Expected: aparece `reverb:start`.

- [ ] **Step 5: Commit**

```bash
git add composer.json composer.lock config/reverb.php config/broadcasting.php .env.example
git commit -m "feat(wa): install and configure Laravel Reverb broadcaster"
```

---

## Task 2: Canales de broadcasting

**Files:**
- Modify: `routes/channels.php`

- [ ] **Step 1: Añadir los 2 canales al final de `routes/channels.php`**

```php
use App\Models\WhatsFleep\WhatsappConversation;

Broadcast::channel('whatsapp.empresa.{empresaId}', function ($user, $empresaId) {
    return (int) session('empresa', 1) === (int) $empresaId;
});

Broadcast::channel('whatsapp.conversation.{uuid}', function ($user, $uuid) {
    $conversation = WhatsappConversation::where('uuid', $uuid)->first();

    return $conversation !== null
        && (int) $conversation->empresa_id === (int) session('empresa', 1);
});
```

- [ ] **Step 2: Verificar**

Run: `php -l routes/channels.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Commit**

```bash
git add routes/channels.php
git commit -m "feat(wa): broadcast channels for empresa and conversation"
```

---

## Task 3: Echo → Reverb en el front

**Files:**
- Modify: `resources/js/bootstrap.js`

- [ ] **Step 1: Reemplazar la config de Echo (bloque Pusher) por Reverb**

Lee el archivo. Sustituye el bloque `window.Echo = new Echo({ broadcaster: "pusher", ... })` por:

```js
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
});
```
Conserva cualquier otro import/uso existente. NO dupliques imports de `Pusher` si ya estaba.

- [ ] **Step 2: Verificar build**

Run: `npm run build`
Expected: compila sin errores; genera el manifest con el nuevo `bootstrap`.

- [ ] **Step 3: Commit**

```bash
git add resources/js/bootstrap.js public/build
git commit -m "feat(wa): point laravel-echo to Reverb"
```

---

## Task 4: Limpieza SP#1 — renombrar ruta de media

**Files:**
- Modify: `routes/web.php`, `app/Models/WhatsFleep/WhatsappMessage.php`

- [ ] **Step 1: Renombrar la ruta**

En `routes/web.php`, cambia el nombre de la ruta de media:
```php
    // WHATSAPP OMNICANAL — adjuntos privados (solo con sesión; rol fino en SP#3)
    Route::get('whatsapp/media/{message:uuid}', [\App\Http\Controllers\Admin\WhatsFleep\WhatsappMediaController::class, 'show'])
        ->name('whatsapp.media');
```

- [ ] **Step 2: Actualizar `mediaUrl()`**

En `app/Models/WhatsFleep/WhatsappMessage.php`, dentro de `mediaUrl()`:
```php
        return route('whatsapp.media', $this->uuid);
```

- [ ] **Step 3: Verificar**

Run: `php -l routes/web.php && php -l app/Models/WhatsFleep/WhatsappMessage.php`
Expected: dos `No syntax errors detected`.
Run: `php artisan route:list --name=whatsapp.media`
Expected: la ruta aparece como `whatsapp.media`.

- [ ] **Step 4: Commit**

```bash
git add routes/web.php app/Models/WhatsFleep/WhatsappMessage.php
git commit -m "refactor(wa): rename media route to whatsapp.media (drop admin prefix)"
```

---

## Task 5: Migración + modelo `WhatsappQuickReply`

**Files:**
- Create: `database/migrations/2026_06_15_110001_create_whatsapp_quick_replies_table.php`
- Create: `app/Models/WhatsFleep/WhatsappQuickReply.php`

- [ ] **Step 1: Migración**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_quick_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->index();
            $table->string('shortcut');
            $table->string('title');
            $table->text('body');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['empresa_id', 'shortcut']);
            $table->index(['empresa_id', 'active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_quick_replies');
    }
};
```

- [ ] **Step 2: Modelo**

```php
<?php

namespace App\Models\WhatsFleep;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WhatsappQuickReply extends Model
{
    protected $fillable = [
        'empresa_id',
        'shortcut',
        'title',
        'body',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);

        static::creating(function (self $reply) {
            $reply->empresa_id = $reply->empresa_id ?: session('empresa', 1);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}
```

- [ ] **Step 3: Verificar y migrar**

Run: `php -l database/migrations/2026_06_15_110001_create_whatsapp_quick_replies_table.php && php -l app/Models/WhatsFleep/WhatsappQuickReply.php`
Expected: dos `No syntax errors detected`.
Run: `php artisan migrate --force`
Expected: corre `create_whatsapp_quick_replies_table` con `DONE`.

- [ ] **Step 4: Commit**

```bash
git add database/migrations/2026_06_15_110001_create_whatsapp_quick_replies_table.php app/Models/WhatsFleep/WhatsappQuickReply.php
git commit -m "feat(wa): WhatsappQuickReply migration + model"
```

---

## Task 6: Permiso `ver-whatsapp` (seeder)

**Files:**
- Create: `database/seeders/WhatsappPermissionsSeeder.php`

- [ ] **Step 1: Seeder** (sigue el patrón de `PortalAccesosPermissionsSeeder`)

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WhatsappPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permission = Permission::firstOrCreate([
            'name' => 'ver-whatsapp',
            'guard_name' => 'web',
        ]);

        $admin = Role::where('name', 'Admin')->first();

        if ($admin) {
            $admin->givePermissionTo($permission);
        }
    }
}
```

> Verifica el nombre real del rol admin (puede ser `Admin`, `super-admin`, etc.) leyendo `PortalAccesosPermissionsSeeder.php`; usa el mismo.

- [ ] **Step 2: Verificar y ejecutar**

Run: `php -l database/seeders/WhatsappPermissionsSeeder.php`
Expected: `No syntax errors detected`.
Run: `php artisan db:seed --class=WhatsappPermissionsSeeder --force`
Expected: `DONE` / sin error (idempotente).

- [ ] **Step 3: Commit**

```bash
git add database/seeders/WhatsappPermissionsSeeder.php
git commit -m "feat(wa): ver-whatsapp permission seeder"
```

---

## Task 7: Action — `MarkConversationReadAction`

**Files:**
- Create: `app/Actions/WhatsFleep/MarkConversationReadAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\WhatsFleep\WhatsappConversation;

class MarkConversationReadAction
{
    /**
     * Marca como leídos (solo interno) los mensajes entrantes no leídos de la
     * conversación y pone unread_count=0. No envía "visto" al cliente.
     */
    public function execute(WhatsappConversation $conversation): void
    {
        if ($conversation->unread_count === 0) {
            return;
        }

        $conversation->messages()
            ->where('sender_type', MessageSenderType::Contact->value)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversation->forceFill(['unread_count' => 0])->save();

        broadcast(new ConversationUpdated($conversation));
    }
}
```

- [ ] **Step 2: Verificar**

Run: `php -l app/Actions/WhatsFleep/MarkConversationReadAction.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Commit**

```bash
git add app/Actions/WhatsFleep/MarkConversationReadAction.php
git commit -m "feat(wa): MarkConversationReadAction (internal read, no blue tick)"
```

---

## Task 8: Action — `AssignConversationAction`

**Files:**
- Create: `app/Actions/WhatsFleep/AssignConversationAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappAssignment;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\DB;

class AssignConversationAction
{
    /**
     * Asigna/reasigna la conversación a un usuario y registra la auditoría.
     * Sin filtrado por rol (SP#3 lo añade).
     */
    public function execute(WhatsappConversation $conversation, ?int $toUserId, User $actor): WhatsappConversation
    {
        $fromUserId = $conversation->assigned_user_id;

        if ($fromUserId === $toUserId) {
            return $conversation;
        }

        DB::transaction(function () use ($conversation, $fromUserId, $toUserId, $actor) {
            $conversation->forceFill(['assigned_user_id' => $toUserId])->save();

            WhatsappAssignment::create([
                'empresa_id' => $conversation->empresa_id,
                'conversation_id' => $conversation->id,
                'from_user_id' => $fromUserId,
                'to_user_id' => $toUserId,
                'assigned_by' => $actor->id,
                'created_at' => now(),
            ]);
        });

        broadcast(new ConversationUpdated($conversation));

        return $conversation;
    }
}
```

- [ ] **Step 2: Verificar**

Run: `php -l app/Actions/WhatsFleep/AssignConversationAction.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Commit**

```bash
git add app/Actions/WhatsFleep/AssignConversationAction.php
git commit -m "feat(wa): AssignConversationAction (assign/reassign + audit)"
```

---

## Task 9: Action — `ChangeConversationStatusAction`

**Files:**
- Create: `app/Actions/WhatsFleep/ChangeConversationStatusAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\ConversationStatus;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\WhatsFleep\WhatsappConversation;

class ChangeConversationStatusAction
{
    public function execute(WhatsappConversation $conversation, ConversationStatus $status): WhatsappConversation
    {
        $conversation->forceFill([
            'status' => $status,
            'closed_at' => $status === ConversationStatus::Closed ? now() : null,
        ])->save();

        broadcast(new ConversationUpdated($conversation));

        return $conversation;
    }
}
```

- [ ] **Step 2: Verificar**

Run: `php -l app/Actions/WhatsFleep/ChangeConversationStatusAction.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Commit**

```bash
git add app/Actions/WhatsFleep/ChangeConversationStatusAction.php
git commit -m "feat(wa): ChangeConversationStatusAction (open/close/pending)"
```

---

## Task 10: Action — `SendWhatsappMediaAction`

**Files:**
- Create: `app/Actions/WhatsFleep/SendWhatsappMediaAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Models\WhatsFleep\WhatsappMessage;
use App\Services\WhatsFleep\WhatsappService;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SendWhatsappMediaAction
{
    public function __construct(private WhatsappService $whatsapp)
    {
    }

    /**
     * Persiste un mensaje saliente con adjunto (ya guardado en disco privado) y
     * lo envía por el Node pasando la RUTA LOCAL del archivo (disco compartido).
     *
     * @param  array{media_path:string, mime_type:?string, file_name:?string, file_size:?int, caption:?string}  $media
     */
    public function execute(WhatsappConversation $conversation, User $sender, MessageType $type, array $media): WhatsappMessage
    {
        $message = WhatsappMessage::create([
            'empresa_id' => $conversation->empresa_id,
            'conversation_id' => $conversation->id,
            'device_id' => $conversation->device_id,
            'contact_id' => $conversation->contact_id,
            'sender_type' => MessageSenderType::Agent,
            'sender_user_id' => $sender->id,
            'type' => $type,
            'body' => $media['caption'] ?? null,
            'media_path' => $media['media_path'],
            'mime_type' => $media['mime_type'] ?? null,
            'file_name' => $media['file_name'] ?? null,
            'file_size' => $media['file_size'] ?? null,
            'status' => MessageStatus::Pending,
        ]);

        try {
            $device = $conversation->device;
            $number = $conversation->contact->number;
            $absolutePath = Storage::disk(config('whatsapp.media_disk', 'local'))->path($media['media_path']);

            $response = $this->whatsapp->sendMedia(
                $device->body,
                $number,
                $type->value,
                $absolutePath,
                $media['caption'] ?? '',
                $media['file_name'] ?? ''
            );

            $waMessageId = data_get((array) $response, 'key.id') ?? data_get((array) $response, 'messageId');

            $message->forceFill([
                'wa_message_id' => $waMessageId,
                'status' => MessageStatus::Sent,
                'sent_at' => now(),
            ])->save();
        } catch (Throwable $e) {
            $message->forceFill([
                'status' => MessageStatus::Failed,
                'metadata' => ['error' => $e->getMessage()],
            ])->save();
        }

        return $message;
    }
}
```

> **Verificación de integración:** `WhatsappService::sendMedia($token,$number,$type,$url,$caption,$fileName)` ya existe (SP#1). El Node usa Baileys `{ url }` que acepta ruta local del disco compartido. Si en pruebas el Node no encuentra el archivo, confirmar que `WA_MEDIA_ROOT`/disco apuntan al mismo path absoluto que `Storage::disk('local')->path()`.

- [ ] **Step 2: Verificar**

Run: `php -l app/Actions/WhatsFleep/SendWhatsappMediaAction.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Commit**

```bash
git add app/Actions/WhatsFleep/SendWhatsappMediaAction.php
git commit -m "feat(wa): SendWhatsappMediaAction (persist + send via local path)"
```

---

## Task 11: Ruta + controlador + vista contenedora del inbox

**Files:**
- Create: `app/Http/Controllers/Admin/WhatsFleep/InboxController.php`
- Modify: `routes/web.php`
- Create: `resources/views/admin/whatsapp/inbox.blade.php`

- [ ] **Step 1: Controlador**

```php
<?php

namespace App\Http\Controllers\Admin\WhatsFleep;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class InboxController extends Controller
{
    public function index(): View
    {
        return view('admin.whatsapp.inbox');
    }
}
```

- [ ] **Step 2: Ruta** (dentro del grupo `auth:sanctum,verified`, junto a la ruta de media)

```php
    Route::get('whatsapp', [\App\Http\Controllers\Admin\WhatsFleep\InboxController::class, 'index'])
        ->name('whatsapp.inbox')
        ->middleware('can:ver-whatsapp');
```

- [ ] **Step 3: Vista contenedora** — usa el layout admin y monta el componente full-page

ACTIVAR skills `frontend-design` + `tailwindcss-development`. Estructura mínima (contrato):
```blade
<x-admin-layout> {{-- o el layout/directiva que usen las otras vistas admin; revisar una vista admin existente --}}
    <livewire:admin.whats-fleep.inbox.index />
</x-admin-layout>
```
Revisa una vista admin existente (ej. la de tickets) para usar el MISMO mecanismo de layout (componente `<x-...>`, `@extends`, o `#[Layout]`).

- [ ] **Step 4: Verificar**

Run: `php -l app/Http/Controllers/Admin/WhatsFleep/InboxController.php && php -l routes/web.php`
Expected: dos `No syntax errors detected`.
Run: `php artisan route:list --name=whatsapp.inbox`
Expected: la ruta aparece con middleware `auth:sanctum`, `verified`, `can:ver-whatsapp`.

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/Admin/WhatsFleep/InboxController.php routes/web.php resources/views/admin/whatsapp/inbox.blade.php
git commit -m "feat(wa): inbox route, controller and container view"
```

---

## Task 12: Componente `Index` (contenedor del inbox)

**Files:**
- Create: `app/Livewire/Admin/WhatsFleep/Inbox/Index.php`
- Create: `resources/views/livewire/admin/whats-fleep/inbox/index.blade.php`

- [ ] **Step 1: Componente** (mantiene la conversación seleccionada y orquesta el layout)

```php
<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    #[Url]
    public ?string $conversation = null; // uuid

    #[On('conversation-selected')]
    public function selectConversation(string $uuid): void
    {
        $this->conversation = $uuid;
    }

    public function render()
    {
        return view('livewire.admin.whats-fleep.inbox.index');
    }
}
```

- [ ] **Step 2: Vista** — layout de 3 paneles, responsive. ACTIVAR `frontend-design` + `tailwindcss-development`.

Contrato (estructura/bindings):
```blade
<div class="flex h-[calc(100vh-Xrem)] ...">
    {{-- Panel izquierdo --}}
    <livewire:admin.whats-fleep.inbox.conversation-list />

    {{-- Panel central --}}
    <div class="flex-1 flex flex-col ...">
        @if ($conversation)
            <livewire:admin.whats-fleep.inbox.conversation-header :uuid="$conversation" :key="'header-'.$conversation" />
            <livewire:admin.whats-fleep.inbox.conversation-view :uuid="$conversation" :key="'view-'.$conversation" />
            <livewire:admin.whats-fleep.inbox.message-composer :uuid="$conversation" :key="'composer-'.$conversation" />
        @else
            {{-- estado vacío estilo WhatsApp ("Selecciona una conversación") --}}
        @endif
    </div>

    {{-- Panel derecho --}}
    @if ($conversation)
        <livewire:admin.whats-fleep.inbox.contact-panel :uuid="$conversation" :key="'panel-'.$conversation" />
    @endif
</div>
```
Responsive: en móvil, mostrar solo lista o solo conversación según `$conversation` (clases Tailwind `hidden md:flex`, etc.). El `:key` por uuid fuerza el remount de los subcomponentes al cambiar de conversación.

- [ ] **Step 3: Verificar**

Run: `php -l app/Livewire/Admin/WhatsFleep/Inbox/Index.php`
Expected: `No syntax errors detected`.

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/Index.php resources/views/livewire/admin/whats-fleep/inbox/index.blade.php
git commit -m "feat(wa): inbox container component + 3-pane layout"
```

---

## Task 13: Componente `ConversationList` (sidebar)

**Files:**
- Create: `app/Livewire/Admin/WhatsFleep/Inbox/ConversationList.php`
- Create: `resources/views/livewire/admin/whats-fleep/inbox/conversation-list.blade.php`

- [ ] **Step 1: Componente**

```php
<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ConversationList extends Component
{
    use WithPagination;

    #[Url]
    public string $estado = 'open';      // open | pending | closed

    #[Url]
    public string $asignacion = 'todas'; // mias | sin_asignar | todas

    #[Url]
    public string $search = '';

    public ?string $selected = null;

    /**
     * Canal dinámico de empresa para refrescar la lista en vivo.
     *
     * @return array<string, string>
     */
    public function getListeners(): array
    {
        $empresaId = (int) session('empresa', 1);

        return [
            "echo-private:whatsapp.empresa.{$empresaId},wa.conversation.updated" => '$refresh',
        ];
    }

    public function updated($name): void
    {
        if (in_array($name, ['estado', 'asignacion', 'search'], true)) {
            $this->resetPage();
        }
    }

    public function select(string $uuid): void
    {
        $this->selected = $uuid;
        $this->dispatch('conversation-selected', uuid: $uuid);
    }

    public function render()
    {
        $empresaId = (int) session('empresa', 1);

        $query = WhatsappConversation::query()
            ->forTenant($empresaId)
            ->with(['contact', 'cliente', 'lastMessage', 'assignedUser'])
            ->where('status', $this->estado);

        if ($this->asignacion === 'mias') {
            $query->where('assigned_user_id', Auth::id());
        } elseif ($this->asignacion === 'sin_asignar') {
            $query->whereNull('assigned_user_id');
        }

        if ($this->search !== '') {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->whereHas('contact', fn ($c) => $c->where('name', 'like', $term)->orWhere('number', 'like', $term))
                  ->orWhereHas('cliente', fn ($c) => $c->where('razon_social', 'like', $term));
            });
        }

        $conversations = $query->orderByDesc('last_message_at')->paginate(20);

        return view('livewire.admin.whats-fleep.inbox.conversation-list', [
            'conversations' => $conversations,
        ]);
    }
}
```

> Verifica el nombre real de la columna de nombre de cliente en `clientes` (`razon_social` u otra) leyendo el modelo/SQL; ajusta el `whereHas('cliente', ...)`.

- [ ] **Step 2: Vista** — ACTIVAR `frontend-design` + `tailwindcss-development`.

Contrato: tabs de `estado` (`wire:click="$set('estado','open')"`), segmented de `asignacion`, input `wire:model.live.debounce.300ms="search"`, lista `@foreach($conversations as $c)` con `wire:click="select('{{ $c->uuid }}')"`, badge `$c->unread_count` si > 0, chip `$c->assignedUser?->name`, preview `$c->lastMessage?->body`, hora `$c->last_message_at?->diffForHumans()`. Paginación `{{ $conversations->links() }}`. Resaltar el ítem `selected`.

- [ ] **Step 3: Verificar**

Run: `php -l app/Livewire/Admin/WhatsFleep/Inbox/ConversationList.php`
Expected: `No syntax errors detected`.

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/ConversationList.php resources/views/livewire/admin/whats-fleep/inbox/conversation-list.blade.php
git commit -m "feat(wa): ConversationList sidebar (filters, search, live updates)"
```

---

## Task 14: Componente `ConversationView` (historial + tiempo real)

**Files:**
- Create: `app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php`
- Create: `resources/views/livewire/admin/whats-fleep/inbox/conversation-view.blade.php`

- [ ] **Step 1: Componente**

```php
<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\MarkConversationReadAction;
use App\Models\WhatsFleep\WhatsappConversation;
use Livewire\Component;

class ConversationView extends Component
{
    public string $uuid;
    public int $perPage = 30;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
        $this->markRead();
    }

    /**
     * @return array<string, string>
     */
    public function getListeners(): array
    {
        return [
            "echo-private:whatsapp.conversation.{$this->uuid},wa.message.new" => 'onNewMessage',
        ];
    }

    public function onNewMessage(): void
    {
        $this->markRead();
        $this->dispatch('messages-refreshed');
    }

    public function loadMore(): void
    {
        $this->perPage += 30;
    }

    private function markRead(): void
    {
        $conversation = $this->conversation();
        if ($conversation) {
            app(MarkConversationReadAction::class)->execute($conversation);
        }
    }

    private function conversation(): ?WhatsappConversation
    {
        return WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $conversation = $this->conversation();

        $messages = $conversation
            ? $conversation->messages()->with('senderUser')->latest()->limit($this->perPage)->get()->reverse()->values()
            : collect();

        return view('livewire.admin.whats-fleep.inbox.conversation-view', [
            'messages' => $messages,
        ]);
    }
}
```

- [ ] **Step 2: Vista** — ACTIVAR `frontend-design` + `tailwindcss-development`.

Contrato: contenedor scrollable con `@foreach($messages as $m)` → burbuja izquierda si `$m->sender_type->value === 'contact'`, derecha si no. Mostrar `$m->body`; si `$m->media_path`, render según `$m->type` usando `<img src="{{ $m->mediaUrl() }}">` / `<audio>` / link de documento (ruta autenticada). Hora `$m->created_at->format('H:i')`. En salientes, icono de estado por `$m->status->value` (pending=spinner, sent=✓, delivered=✓✓, read=✓✓ azul, failed=⚠). Separadores por fecha. Botón "cargar más" `wire:click="loadMore"` arriba. Autoscroll al fondo con Alpine al montar y en `messages-refreshed` (escuchar `Livewire.on`). 

- [ ] **Step 3: Verificar**

Run: `php -l app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php`
Expected: `No syntax errors detected`.

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php resources/views/livewire/admin/whats-fleep/inbox/conversation-view.blade.php
git commit -m "feat(wa): ConversationView (history, media, live append, mark read)"
```

---

## Task 15: Componente `MessageComposer` (texto + adjuntos + quick replies)

**Files:**
- Create: `app/Livewire/Admin/WhatsFleep/Inbox/MessageComposer.php`
- Create: `resources/views/livewire/admin/whats-fleep/inbox/message-composer.blade.php`

- [ ] **Step 1: Componente**

```php
<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\SendWhatsappMediaAction;
use App\Actions\WhatsFleep\SendWhatsappMessageAction;
use App\Enums\WhatsFleep\MessageType;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Models\WhatsFleep\WhatsappQuickReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class MessageComposer extends Component
{
    use WithFileUploads;

    public string $uuid;
    public string $body = '';
    public $attachment = null;
    public string $caption = '';

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function sendText(): void
    {
        $body = trim($this->body);
        if ($body === '') {
            return;
        }

        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        app(SendWhatsappMessageAction::class)->execute($conversation, Auth::user(), $body);

        $this->reset('body');
        $this->dispatch('message-sent');
    }

    public function sendAttachment(): void
    {
        $this->validate([
            'attachment' => ['required', 'file', 'max:16384'],
        ]);

        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        $empresaId = $conversation->empresa_id;
        $ext = $this->attachment->getClientOriginalExtension();
        $path = $this->attachment->storeAs(
            "whatsapp/outgoing/{$empresaId}",
            Str::uuid() . '.' . $ext,
            config('whatsapp.media_disk', 'local')
        );

        app(SendWhatsappMediaAction::class)->execute(
            $conversation,
            Auth::user(),
            $this->resolveType($this->attachment->getMimeType()),
            [
                'media_path' => $path,
                'mime_type' => $this->attachment->getMimeType(),
                'file_name' => $this->attachment->getClientOriginalName(),
                'file_size' => $this->attachment->getSize(),
                'caption' => trim($this->caption) ?: null,
            ]
        );

        $this->reset('attachment', 'caption');
        $this->dispatch('message-sent');
    }

    public function applyQuickReply(int $id): void
    {
        $reply = WhatsappQuickReply::active()->find($id);
        if ($reply) {
            $this->body = trim($this->body . ' ' . $reply->body);
        }
    }

    private function resolveType(?string $mime): MessageType
    {
        return match (true) {
            str_starts_with((string) $mime, 'image/') => MessageType::Image,
            str_starts_with((string) $mime, 'audio/') => MessageType::Audio,
            str_starts_with((string) $mime, 'video/') => MessageType::Video,
            default => MessageType::Document,
        };
    }

    private function conversation(): ?WhatsappConversation
    {
        return WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $quickReplies = WhatsappQuickReply::active()
            ->when($this->body !== '' && str_starts_with($this->body, '/'), function ($q) {
                $q->where('shortcut', 'like', ltrim($this->body, '/') . '%');
            })
            ->orderBy('shortcut')
            ->limit(8)
            ->get();

        return view('livewire.admin.whats-fleep.inbox.message-composer', [
            'quickReplies' => $quickReplies,
        ]);
    }
}
```

- [ ] **Step 2: Vista** — ACTIVAR `frontend-design` + `tailwindcss-development`.

Contrato: textarea `wire:model.live="body"` con autosize (Alpine); Enter→`sendText`, Shift+Enter salto. Botón clip → input file `wire:model="attachment"` con preview + `caption` + botón enviar `wire:click="sendAttachment"` (mostrar `wire:loading` durante subida). Dropdown de quick replies cuando `body` empieza con `/`: `@foreach($quickReplies as $qr)` con `wire:click="applyQuickReply({{ $qr->id }})"` mostrando `title`/`shortcut`. Indicadores `wire:loading` en los botones de envío.

- [ ] **Step 3: Verificar**

Run: `php -l app/Livewire/Admin/WhatsFleep/Inbox/MessageComposer.php`
Expected: `No syntax errors detected`.

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/MessageComposer.php resources/views/livewire/admin/whats-fleep/inbox/message-composer.blade.php
git commit -m "feat(wa): MessageComposer (text, attachments, quick replies)"
```

---

## Task 16: Componente `ConversationHeader` (acciones)

**Files:**
- Create: `app/Livewire/Admin/WhatsFleep/Inbox/ConversationHeader.php`
- Create: `resources/views/livewire/admin/whats-fleep/inbox/conversation-header.blade.php`

- [ ] **Step 1: Componente**

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
        if ($conversation) {
            app(AssignConversationAction::class)->execute($conversation, Auth::id(), Auth::user());
            $this->dispatch('conversation-updated');
        }
    }

    public function reassign(): void
    {
        $conversation = $this->conversation();
        if ($conversation && $this->reassignTo) {
            app(AssignConversationAction::class)->execute($conversation, $this->reassignTo, Auth::user());
            $this->reset('reassignTo');
            $this->dispatch('conversation-updated');
        }
    }

    public function setStatus(string $status): void
    {
        $conversation = $this->conversation();
        if ($conversation) {
            app(ChangeConversationStatusAction::class)->execute($conversation, ConversationStatus::from($status));
            $this->dispatch('conversation-updated');
        }
    }

    public function setPriority(string $priority): void
    {
        $conversation = $this->conversation();
        if ($conversation) {
            $conversation->forceFill(['priority' => ConversationPriority::from($priority)])->save();
            $this->dispatch('conversation-updated');
        }
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

        $agents = User::orderBy('name')->get(['id', 'name']);

        return view('livewire.admin.whats-fleep.inbox.conversation-header', [
            'conversation' => $conversation,
            'agents' => $agents,
        ]);
    }
}
```

- [ ] **Step 2: Vista** — ACTIVAR `frontend-design` + `tailwindcss-development`.

Contrato: nombre del contacto/cliente, estado y prioridad; botón "Asignarme" `wire:click="assignToMe"`; selector de agentes `wire:model="reassignTo"` + botón `wire:click="reassign"`; botones cerrar/reabrir `wire:click="setStatus('closed')"`/`'open'`; selector de prioridad `wire:click="setPriority('high')"` etc.

- [ ] **Step 3: Verificar**

Run: `php -l app/Livewire/Admin/WhatsFleep/Inbox/ConversationHeader.php`
Expected: `No syntax errors detected`.

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/ConversationHeader.php resources/views/livewire/admin/whats-fleep/inbox/conversation-header.blade.php
git commit -m "feat(wa): ConversationHeader (assign, reassign, status, priority)"
```

---

## Task 17: Componente `ContactPanel` (panel derecho mínimo)

**Files:**
- Create: `app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php`
- Create: `resources/views/livewire/admin/whats-fleep/inbox/contact-panel.blade.php`

- [ ] **Step 1: Componente**

```php
<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Models\WhatsFleep\WhatsappConversation;
use Livewire\Component;

class ContactPanel extends Component
{
    public string $uuid;

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function openConversation(string $uuid): void
    {
        $this->dispatch('conversation-selected', uuid: $uuid);
    }

    public function render()
    {
        $conversation = WhatsappConversation::with(['contact.cliente'])
            ->where('uuid', $this->uuid)
            ->first();

        $otras = collect();
        if ($conversation) {
            $otras = WhatsappConversation::where('contact_id', $conversation->contact_id)
                ->where('id', '!=', $conversation->id)
                ->latest('last_message_at')
                ->limit(10)
                ->get();
        }

        return view('livewire.admin.whats-fleep.inbox.contact-panel', [
            'conversation' => $conversation,
            'otras' => $otras,
        ]);
    }
}
```

- [ ] **Step 2: Vista** — ACTIVAR `frontend-design` + `tailwindcss-development`.

Contrato (solo lectura): datos del `conversation->contact` (número, push_name) y `conversation->contact->cliente` (nombre/razón social, documento, teléfono) si existe. Lista "Otras conversaciones" `@foreach($otras as $o)` con `wire:click="openConversation('{{ $o->uuid }}')"`. Dejar un comentario `{{-- SP#4: panel de vehículos/GPS/tickets aquí --}}`.

- [ ] **Step 3: Verificar**

Run: `php -l app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php`
Expected: `No syntax errors detected`.

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php resources/views/livewire/admin/whats-fleep/inbox/contact-panel.blade.php
git commit -m "feat(wa): ContactPanel (contact + cliente + other conversations)"
```

---

## Task 18: CRUD de Quick Replies en Ajustes

**Files:**
- Create: `app/Livewire/Admin/Ajustes/WhatsApp/QuickReplies/{Index,Save,Delete}.php` + Blade
- Modify: `routes/web.php` (ruta de gestión)

- [ ] **Step 1: Componente `Index`** (lista + apertura de modal Save/Delete; sigue el patrón de los componentes Plantillas existentes en `app/Livewire/Admin/Ajustes/`)

```php
<?php

namespace App\Livewire\Admin\Ajustes\WhatsApp\QuickReplies;

use App\Models\WhatsFleep\WhatsappQuickReply;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    #[On('quick-reply-saved')]
    #[On('quick-reply-deleted')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $replies = WhatsappQuickReply::query()
            ->when($this->search !== '', fn ($q) => $q->where('shortcut', 'like', '%'.$this->search.'%')->orWhere('title', 'like', '%'.$this->search.'%'))
            ->orderBy('shortcut')
            ->paginate(15);

        return view('livewire.admin.ajustes.whats-app.quick-replies.index', [
            'replies' => $replies,
        ]);
    }
}
```

- [ ] **Step 2: Componente `Save`** (crear/editar en modal)

```php
<?php

namespace App\Livewire\Admin\Ajustes\WhatsApp\QuickReplies;

use App\Models\WhatsFleep\WhatsappQuickReply;
use Livewire\Attributes\On;
use Livewire\Component;

class Save extends Component
{
    public bool $showModal = false;
    public ?int $replyId = null;
    public string $shortcut = '';
    public string $title = '';
    public string $body = '';
    public bool $active = true;

    protected function rules(): array
    {
        return [
            'shortcut' => ['required', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'max:2000'],
            'active' => ['boolean'],
        ];
    }

    #[On('open-quick-reply-modal')]
    public function open(?int $id = null): void
    {
        $this->reset(['replyId', 'shortcut', 'title', 'body']);
        $this->active = true;
        $this->resetValidation();

        if ($id) {
            $reply = WhatsappQuickReply::findOrFail($id);
            $this->replyId = $reply->id;
            $this->shortcut = $reply->shortcut;
            $this->title = $reply->title;
            $this->body = $reply->body;
            $this->active = $reply->active;
        }

        $this->showModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        WhatsappQuickReply::updateOrCreate(['id' => $this->replyId], $data);

        $this->showModal = false;
        $this->dispatch('quick-reply-saved');
    }

    public function render()
    {
        return view('livewire.admin.ajustes.whats-app.quick-replies.save');
    }
}
```

- [ ] **Step 3: Componente `Delete`**

```php
<?php

namespace App\Livewire\Admin\Ajustes\WhatsApp\QuickReplies;

use App\Models\WhatsFleep\WhatsappQuickReply;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public bool $showModal = false;
    public ?int $replyId = null;

    #[On('confirm-delete-quick-reply')]
    public function confirm(int $id): void
    {
        $this->replyId = $id;
        $this->showModal = true;
    }

    public function delete(): void
    {
        if ($this->replyId) {
            WhatsappQuickReply::whereKey($this->replyId)->delete();
        }

        $this->showModal = false;
        $this->dispatch('quick-reply-deleted');
    }

    public function render()
    {
        return view('livewire.admin.ajustes.whats-app.quick-replies.delete');
    }
}
```

- [ ] **Step 4: Vistas + ruta** — ACTIVAR `frontend-design` + `tailwindcss-development`. Crea las 3 Blade (lista con tabla + botones que despachan `open-quick-reply-modal` / `confirm-delete-quick-reply`; modales Save/Delete con WireUi si el proyecto lo usa). Añade la ruta en `routes/web.php` dentro del grupo auth:
```php
    Route::view('ajustes/whatsapp/quick-replies', 'admin.ajustes.whatsapp.quick-replies')
        ->name('whatsapp.quick-replies.index')
        ->middleware('can:ver-whatsapp');
```
Y la vista contenedora `resources/views/admin/ajustes/whatsapp/quick-replies.blade.php` que monta `<livewire:admin.ajustes.whats-app.quick-replies.index />` + `<livewire:...save />` + `<livewire:...delete />`.

- [ ] **Step 5: Verificar**

Run: `php -l` en los 3 componentes y `php -l routes/web.php`.
Expected: `No syntax errors detected` en todos.
Run: `php artisan route:list --name=whatsapp.quick-replies.index`
Expected: aparece la ruta.

- [ ] **Step 6: Commit**

```bash
git add app/Livewire/Admin/Ajustes/WhatsApp/ resources/views/livewire/admin/ajustes/whats-app/ resources/views/admin/ajustes/whatsapp/ routes/web.php
git commit -m "feat(wa): quick replies CRUD in Ajustes"
```

---

## Task 19: Build, navegación y smoke

**Files:**
- Modify: `resources/views/components/admin/sidebar.blade.php` (enlace de navegación)

- [ ] **Step 1: Enlace en el sidebar admin**

Añade un ítem de navegación al inbox (sigue el patrón de los otros enlaces del sidebar, condicionado a `@can('ver-whatsapp')`), apuntando a `route('whatsapp.inbox')`. Revisa cómo se añadieron los enlaces existentes (ej. portal/accesos).

- [ ] **Step 2: Build de assets**

Run: `npm run build`
Expected: compila (incluye Echo→Reverb y vistas del inbox vía Livewire).

- [ ] **Step 3: Verificación estática final**

Run: `php artisan route:list | grep -E "whatsapp"`
Expected: `whatsapp.inbox`, `whatsapp.media`, `whatsapp.quick-replies.index`.

- [ ] **Step 4: Commit**

```bash
git add resources/views/components/admin/sidebar.blade.php public/build
git commit -m "feat(wa): inbox nav link + build assets"
```

- [ ] **Step 5: Smoke en vivo (a cargo del usuario, NO automatizar)**

Documenta para el usuario: arrancar `php artisan reverb:start`, el worker `php artisan queue:work --queue=whatsapp`, el servidor Node, abrir `route('whatsapp.inbox')`, enviar un WhatsApp entrante de prueba y verificar que aparece en vivo; responder con texto y con un adjunto; tomar/cerrar la conversación.

---

## Self-Review (completado al escribir el plan)

- **Cobertura del spec:** §3 Reverb (T1-T3), canales (T2), §4 componentes (T11-T17), §5 lista (T13), §6 vista/lectura (T14, T7), §7 composer/adjuntos/quick replies (T15, T10, T5), §8 header/asignación/panel (T16, T8, T9, T17), §9 quick replies + permiso + rename (T5, T6, T18, T4), §10 estética (delegada a frontend-design en cada Blade), §13 inventario cubierto. Smoke §11 (T19).
- **Placeholders:** las vistas Blade delegan el acabado a las skills frontend-design/tailwindcss-development con contrato funcional explícito (bindings/directivas), no son "TODO"; toda la lógica PHP está completa.
- **Consistencia de tipos/firmas:** `SendWhatsappMessageAction::execute($conversation,$user,$body)` y `SendWhatsappMediaAction::execute($conversation,$user,MessageType,$mediaArray)` usados igual en MessageComposer. `AssignConversationAction::execute($conversation,?int,$actor)`, `ChangeConversationStatusAction::execute($conversation,ConversationStatus)`, `MarkConversationReadAction::execute($conversation)` coinciden con sus invocaciones. Eventos Livewire (`conversation-selected`, `conversation-updated`, `message-sent`) consistentes emisor/receptor. Canales Echo coinciden con los `broadcastOn()` de SP#1.
- **Verificaciones señaladas para implementación:** nombre de columna de cliente (`razon_social`), mecanismo de layout admin (componente vs `@extends`), nombre del rol admin en el seeder, que el Node acepte ruta local en `sendMedia`.
