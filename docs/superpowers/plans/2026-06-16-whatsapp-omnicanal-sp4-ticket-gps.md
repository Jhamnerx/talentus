# WhatsApp Omnicanal SP#4 — Ticket Integration + GPS Panel — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Vincular/crear tickets de soporte directamente desde el inbox de WhatsApp y mostrar la flota GPS del cliente en el panel derecho (`ContactPanel`).

**Architecture:** Tres nuevos `Action` classes manejan la lógica de negocio (link/unlink/create). `ContactPanel` Livewire absorbe las nuevas propiedades y métodos. La vista blade agrega dos secciones nuevas (ticket + vehículos) y un modal de creación de ticket. Sin migraciones — `whatsapp_conversations.ticket_id` ya existe.

**Tech Stack:** Laravel 12 (estructura L10), Livewire 4, Tailwind v4, WireUI (`x-form.modal.card`), Spatie Permissions (SP#3 ya configurado), `ConversationUpdated` Reverb event (SP#2).

**Restricciones críticas:**
- ❌ NO ejecutar `php artisan test` (destruye BD de producción con RefreshDatabase)
- ❌ NO ejecutar `php artisan migrate`
- ✅ Validar sintaxis PHP con `php -l <archivo>`
- ✅ Sin tests (instrucción del usuario)

---

## File Map

| Acción | Archivo | Responsabilidad |
|--------|---------|----------------|
| Crear | `app/Actions/WhatsFleep/LinkConversationToTicketAction.php` | Vincula `ticket_id` con guard multi-tenant |
| Crear | `app/Actions/WhatsFleep/UnlinkConversationFromTicketAction.php` | Limpia `ticket_id` |
| Crear | `app/Actions/WhatsFleep/CreateTicketFromConversationAction.php` | Crea ticket + vincula en transacción |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php` | Nuevas props + 4 métodos + render actualizado |
| Modificar | `resources/views/livewire/admin/whats-fleep/inbox/contact-panel.blade.php` | Sección ticket + sección vehículos + modal |

---

## Task 1: `LinkConversationToTicketAction`

**Files:**
- Create: `app/Actions/WhatsFleep/LinkConversationToTicketAction.php`

**Contexto:** Establece `whatsapp_conversations.ticket_id`. Verifica que el ticket sea de la misma empresa antes de vincular. Lanza `ConversationUpdated` para que el `ConversationList` refresque en tiempo real (Reverb, patrón de SP#2).

- [ ] **Step 1: Crear el archivo**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Gate;

class LinkConversationToTicketAction
{
    public function execute(WhatsappConversation $conversation, int $ticketId, User $actor): void
    {
        Gate::forUser($actor)->authorize('reply', $conversation);

        $ticket = Ticket::withoutGlobalScope(EmpresaScope::class)->findOrFail($ticketId);

        if ((int) $ticket->empresa_id !== (int) $conversation->empresa_id) {
            throw new \InvalidArgumentException('El ticket no pertenece a la misma empresa que la conversación.');
        }

        $conversation->forceFill(['ticket_id' => $ticketId])->save();

        broadcast(new ConversationUpdated($conversation));
    }
}
```

- [ ] **Step 2: Validar sintaxis**

```powershell
php -l app/Actions/WhatsFleep/LinkConversationToTicketAction.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```powershell
git add app/Actions/WhatsFleep/LinkConversationToTicketAction.php
git commit -m "feat(wa-sp4): LinkConversationToTicketAction with empresa guard"
```

---

## Task 2: `UnlinkConversationFromTicketAction`

**Files:**
- Create: `app/Actions/WhatsFleep/UnlinkConversationFromTicketAction.php`

**Contexto:** Limpia `ticket_id`. Misma autorización `reply` que el link — cualquier agente que puede conversar puede desvincular.

- [ ] **Step 1: Crear el archivo**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Events\WhatsFleep\ConversationUpdated;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Gate;

class UnlinkConversationFromTicketAction
{
    public function execute(WhatsappConversation $conversation, User $actor): void
    {
        Gate::forUser($actor)->authorize('reply', $conversation);

        $conversation->forceFill(['ticket_id' => null])->save();

        broadcast(new ConversationUpdated($conversation));
    }
}
```

- [ ] **Step 2: Validar sintaxis**

```powershell
php -l app/Actions/WhatsFleep/UnlinkConversationFromTicketAction.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```powershell
git add app/Actions/WhatsFleep/UnlinkConversationFromTicketAction.php
git commit -m "feat(wa-sp4): UnlinkConversationFromTicketAction"
```

---

## Task 3: `CreateTicketFromConversationAction`

**Files:**
- Create: `app/Actions/WhatsFleep/CreateTicketFromConversationAction.php`

**Contexto:** Orquesta la creación de ticket + vinculación. Delega a `CreateTicketAction` (ya existente en `app/Actions/Tickets/`) usando el `cliente_id` de la conversación como `customer_id`. Luego vincula con `LinkConversationToTicketAction`.

`CreateTicketAction::execute(array $data, int $createdByUserId): Ticket` — ya genera código `TK-YYYY-NNNNNN` y registra evento `CREATED`.

- [ ] **Step 1: Crear el archivo**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Actions\Tickets\CreateTicketAction;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Support\Facades\Gate;

class CreateTicketFromConversationAction
{
    public function __construct(
        private readonly CreateTicketAction $createTicket,
        private readonly LinkConversationToTicketAction $linkToTicket,
    ) {}

    public function execute(WhatsappConversation $conversation, array $data, User $actor): Ticket
    {
        Gate::forUser($actor)->authorize('reply', $conversation);

        if (! $conversation->cliente_id) {
            throw new \LogicException('No se puede crear un ticket sin cliente vinculado a la conversación.');
        }

        $ticket = $this->createTicket->execute([
            'empresa_id'  => $conversation->empresa_id,
            'subject'     => $data['subject'],
            'description' => $data['description'],
            'priority'    => $data['priority'],
            'category_id' => $data['category_id'] ?? null,
            'customer_id' => $conversation->cliente_id,
        ], $actor->id);

        $this->linkToTicket->execute($conversation, $ticket->id, $actor);

        return $ticket;
    }
}
```

- [ ] **Step 2: Validar sintaxis**

```powershell
php -l app/Actions/WhatsFleep/CreateTicketFromConversationAction.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```powershell
git add app/Actions/WhatsFleep/CreateTicketFromConversationAction.php
git commit -m "feat(wa-sp4): CreateTicketFromConversationAction"
```

---

## Task 4: `ContactPanel` — nuevas propiedades y métodos

**Files:**
- Modify: `app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php`

**Contexto:** El componente actual solo muestra contact + cliente + otras conversaciones. Se agregan 6 propiedades, 4 métodos y se actualiza `render()`. La validación del formulario de creación de ticket usa `$this->validate()` inline con las reglas nombradas `createSubject`, `createPriority`, `createCategoryId`, `createDescription`.

`TicketCategory` usa `EmpresaScope` → se usa `withoutGlobalScope(EmpresaScope::class)` + `where('empresa_id', $empresaId)` para ser explícitos.

`Ticket` también usa `EmpresaScope` → misma estrategia.

`$cliente->vehiculos()` ya tiene `withoutGlobalScope(EmpresaScope::class)` en la relación de `Clientes` (verificable en `app/Models/Clientes.php` línea 99-101), por lo que no se repite.

- [ ] **Step 1: Reemplazar el archivo completo**

```php
<?php

namespace App\Livewire\Admin\WhatsFleep\Inbox;

use App\Actions\WhatsFleep\CreateTicketFromConversationAction;
use App\Actions\WhatsFleep\LinkConversationToTicketAction;
use App\Actions\WhatsFleep\UnlinkConversationFromTicketAction;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\WhatsFleep\WhatsappConversation;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactPanel extends Component
{
    public string $uuid;

    // Ticket linking
    public string $ticketSearch = '';
    public bool $showCreateTicketModal = false;
    public string $createSubject = '';
    public string $createPriority = 'medium';
    public ?int $createCategoryId = null;
    public string $createDescription = '';

    public function mount(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function openConversation(string $uuid): void
    {
        $this->dispatch('conversation-selected', uuid: $uuid);
    }

    public function linkTicket(int $ticketId): void
    {
        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        app(LinkConversationToTicketAction::class)->execute($conversation, $ticketId, Auth::user());
        $this->reset('ticketSearch');
    }

    public function unlinkTicket(): void
    {
        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        app(UnlinkConversationFromTicketAction::class)->execute($conversation, Auth::user());
    }

    public function openCreateTicketModal(): void
    {
        $conversation = $this->conversation();
        if (! $conversation || ! $conversation->cliente_id) {
            return;
        }

        $this->reset(['createSubject', 'createCategoryId', 'createDescription']);
        $this->createPriority = 'medium';
        $this->resetValidation();
        $this->showCreateTicketModal = true;
    }

    public function createAndLinkTicket(): void
    {
        $this->validate([
            'createSubject'     => ['required', 'string', 'max:255'],
            'createPriority'    => ['required', 'in:low,medium,high,urgent'],
            'createCategoryId'  => ['nullable', 'integer', 'exists:ticket_categories,id'],
            'createDescription' => ['required', 'string', 'max:5000'],
        ]);

        $conversation = $this->conversation();
        if (! $conversation) {
            return;
        }

        app(CreateTicketFromConversationAction::class)->execute(
            $conversation,
            [
                'subject'     => $this->createSubject,
                'description' => $this->createDescription,
                'priority'    => $this->createPriority,
                'category_id' => $this->createCategoryId,
            ],
            Auth::user()
        );

        $this->showCreateTicketModal = false;
        $this->reset(['createSubject', 'createCategoryId', 'createDescription']);
        $this->createPriority = 'medium';
    }

    private function conversation(): ?WhatsappConversation
    {
        return WhatsappConversation::where('uuid', $this->uuid)->first();
    }

    public function render()
    {
        $conversation = WhatsappConversation::with(['contact.cliente', 'ticket'])
            ->where('uuid', $this->uuid)
            ->first();

        $cliente   = $conversation?->contact?->cliente;
        $empresaId = $conversation?->empresa_id ?? session('empresa', 1);

        $otras = collect();
        if ($conversation) {
            $otras = WhatsappConversation::where('contact_id', $conversation->contact_id)
                ->where('id', '!=', $conversation->id)
                ->latest('last_message_at')
                ->limit(10)
                ->get();
        }

        $ticketResults = $this->ticketSearch !== ''
            ? Ticket::withoutGlobalScope(EmpresaScope::class)
                ->where('empresa_id', $empresaId)
                ->where(fn ($q) => $q
                    ->where('code', 'like', $this->ticketSearch . '%')
                    ->orWhere('subject', 'like', '%' . $this->ticketSearch . '%'))
                ->whereNull('deleted_at')
                ->limit(5)
                ->get(['id', 'code', 'subject'])
            : collect();

        $vehiculos = $cliente
            ? $cliente->vehiculos()->whereNull('deleted_at')->limit(8)->get(['id', 'placa', 'gpswox_active', 'marca', 'modelo'])
            : collect();

        $categories = TicketCategory::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $empresaId)
            ->active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.admin.whats-fleep.inbox.contact-panel', [
            'conversation'  => $conversation,
            'otras'         => $otras,
            'ticketResults' => $ticketResults,
            'vehiculos'     => $vehiculos,
            'categories'    => $categories,
        ]);
    }
}
```

- [ ] **Step 2: Validar sintaxis**

```powershell
php -l app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```powershell
git add app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php
git commit -m "feat(wa-sp4): ContactPanel — ticket link/create/unlink + vehicles"
```

---

## Task 5: Blade — sección ticket + vehículos + modal

**Files:**
- Modify: `resources/views/livewire/admin/whats-fleep/inbox/contact-panel.blade.php`

**Contexto:**
- La blade actual tiene `<aside>` como elemento raíz único (requerido por Livewire 4).
- La sección a reemplazar es solo las 3 últimas líneas: el placeholder `{{-- SP#4 --}}`, el `</div>` del scrollable body y el `</aside>` de cierre.
- El modal `<x-form.modal.card wire:model.live="showCreateTicketModal">` usa el patrón idéntico de `resources/views/livewire/admin/ajustes/whats-app/quick-replies/save.blade.php`.
- `@can('reply', $conversation)` usa la `WhatsappConversationPolicy` registrada en SP#3 vía `AppServiceProvider`.
- `$ticket->status->statusColor()` y `$ticket->status->label()` existen en `App\Enums\TicketStatus`.
- `$ticket->priority->statusColor()` y `$ticket->priority->label()` existen en `App\Enums\TicketPriority`.
- El botón "Crear ticket" solo aparece si `$conversation?->cliente_id` existe — sin cliente no hay `customer_id` para el ticket.

- [ ] **Step 1: Reemplazar las últimas 3 líneas del blade**

Ubicar el bloque exacto (líneas 103-105 del archivo actual):
```
        {{-- SP#4: panel de vehículos/GPS/tickets aquí --}}
    </div>
</aside>
```

Reemplazarlo con:

```blade
        {{-- ── Ticket vinculado ──────────────────────────────────── --}}
        <section>
            <h3 class="mb-2 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                <svg class="h-3 w-3 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a3 3 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                </svg>
                Ticket
            </h3>

            @if ($conversation?->ticket_id && $conversation->ticket)
                @php $ticket = $conversation->ticket; @endphp
                <div class="rounded-xl bg-indigo-50/70 p-3 ring-1 ring-indigo-100 dark:bg-indigo-500/[0.06] dark:ring-indigo-500/20">
                    <div class="mb-2 flex items-center justify-between gap-2">
                        <span class="shrink-0 rounded bg-indigo-100 px-1.5 py-0.5 text-[10px] font-bold tabular-nums text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                            {{ $ticket->code }}
                        </span>
                        <span @class(['inline-flex shrink-0 items-center rounded-md px-1.5 py-0.5 text-[10px] font-semibold', $ticket->status->statusColor()])>
                            {{ $ticket->status->label() }}
                        </span>
                    </div>
                    <p class="mb-2 line-clamp-2 text-xs font-medium text-gray-800 dark:text-gray-100">{{ $ticket->subject }}</p>
                    <span @class(['inline-flex items-center rounded-md px-1.5 py-0.5 text-[10px] font-semibold', $ticket->priority->statusColor()])>
                        {{ $ticket->priority->label() }}
                    </span>
                    <div class="mt-3 flex items-center justify-between gap-2">
                        <a
                            href="{{ route('admin.tickets.show', $ticket) }}"
                            target="_blank"
                            class="text-xs font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200"
                        >
                            Ver ticket →
                        </a>
                        @can('reply', $conversation)
                            <button
                                type="button"
                                wire:click="unlinkTicket"
                                class="text-xs text-gray-400 hover:text-red-500 dark:text-gray-500 dark:hover:text-red-400"
                            >
                                Desvincular
                            </button>
                        @endcan
                    </div>
                </div>
            @else
                @can('reply', $conversation)
                    <div class="space-y-2">
                        <div class="relative">
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="ticketSearch"
                                placeholder="Buscar por código o asunto…"
                                class="form-input w-full rounded-lg text-xs"
                            />
                            @if ($ticketResults->isNotEmpty())
                                <ul class="absolute z-10 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                    @foreach ($ticketResults as $t)
                                        <li wire:key="tr-{{ $t->id }}">
                                            <button
                                                type="button"
                                                wire:click="linkTicket({{ $t->id }})"
                                                class="flex w-full items-start gap-2 px-3 py-2 text-left text-xs hover:bg-gray-50 dark:hover:bg-gray-700"
                                            >
                                                <span class="shrink-0 font-mono font-semibold text-indigo-600 dark:text-indigo-400">{{ $t->code }}</span>
                                                <span class="truncate text-gray-700 dark:text-gray-200">{{ $t->subject }}</span>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if ($conversation?->cliente_id)
                            <button
                                type="button"
                                wire:click="openCreateTicketModal"
                                class="flex w-full items-center justify-center gap-1 rounded-lg border border-dashed border-indigo-300 py-2 text-xs font-medium text-indigo-600 transition hover:border-indigo-400 hover:bg-indigo-50 dark:border-indigo-600 dark:text-indigo-400 dark:hover:bg-indigo-500/10"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                Crear ticket
                            </button>
                        @endif
                    </div>
                @else
                    <p class="rounded-lg border border-dashed border-gray-200 px-3 py-4 text-center text-xs text-gray-400 dark:border-gray-700 dark:text-gray-500">
                        Sin ticket vinculado.
                    </p>
                @endcan
            @endif
        </section>

        {{-- ── Vehículos del cliente ──────────────────────────────── --}}
        @if ($vehiculos->isNotEmpty())
            <section>
                <h3 class="mb-2 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                    <svg class="h-3 w-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    Vehículos
                </h3>
                <ul class="space-y-1.5">
                    @foreach ($vehiculos as $v)
                        <li wire:key="vh-{{ $v->id }}" class="flex items-center gap-2 rounded-lg border border-gray-100 bg-white px-3 py-2 dark:border-gray-800 dark:bg-gray-800/40">
                            <span @class([
                                'h-2 w-2 shrink-0 rounded-full',
                                'bg-emerald-400' => $v->gpswox_active,
                                'bg-gray-300 dark:bg-gray-600' => ! $v->gpswox_active,
                            ])></span>
                            <span class="font-mono text-xs font-semibold text-gray-800 dark:text-gray-100">{{ $v->placa }}</span>
                            <span class="truncate text-[11px] text-gray-500 dark:text-gray-400">{{ trim(($v->marca ?? '') . ' ' . ($v->modelo ?? '')) ?: '—' }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>

    {{-- ── Modal: Crear ticket ────────────────────────────────────── --}}
    <x-form.modal.card title="Crear ticket" max-width="lg" wire:model.live="showCreateTicketModal" align="center">
        <form autocomplete="off">
            <div class="grid grid-cols-12 gap-4 px-5 py-4">
                <div class="col-span-12">
                    <label class="mb-1 block text-sm font-medium">Asunto <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="createSubject" class="form-input w-full" placeholder="Ej: Falla en dispositivo GPS" />
                    @error('createSubject') <p class="mt-1 text-sm text-pink-600">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label class="mb-1 block text-sm font-medium">Prioridad <span class="text-red-500">*</span></label>
                    <select wire:model="createPriority" class="form-select w-full">
                        <option value="low">Baja</option>
                        <option value="medium">Media</option>
                        <option value="high">Alta</option>
                        <option value="urgent">Urgente</option>
                    </select>
                    @error('createPriority') <p class="mt-1 text-sm text-pink-600">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label class="mb-1 block text-sm font-medium">Categoría</label>
                    <select wire:model="createCategoryId" class="form-select w-full">
                        <option value="">— Sin categoría —</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('createCategoryId') <p class="mt-1 text-sm text-pink-600">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-12">
                    <label class="mb-1 block text-sm font-medium">Descripción <span class="text-red-500">*</span></label>
                    <textarea wire:model="createDescription" rows="4" class="form-textarea w-full" placeholder="Describe el problema o solicitud…"></textarea>
                    @error('createDescription') <p class="mt-1 text-sm text-pink-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </form>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cancelar" x-on:click.prevent="$wire.set('showCreateTicketModal', false)" />
                <x-form.button primary label="Crear y vincular" wire:click.prevent="createAndLinkTicket" spinner="createAndLinkTicket" />
            </div>
        </x-slot>
    </x-form.modal.card>
</aside>
```

- [ ] **Step 2: Verificar que el blade cierra correctamente**

Abrir el archivo resultante y confirmar que:
- El `<aside>` de la línea 15 tiene su `</aside>` al final del archivo.
- El `<div class="min-h-0 flex-1 ...">` (scrollable body, línea 28) tiene su `</div>` justo antes del modal.
- No hay etiquetas sin cerrar.

- [ ] **Step 3: Commit**

```powershell
git add resources/views/livewire/admin/whats-fleep/inbox/contact-panel.blade.php
git commit -m "feat(wa-sp4): ContactPanel blade — ticket section, vehicles panel, create modal"
```

---

## Task 6: Build assets

**Files:** (solo build — no cambios de código)

**Contexto:** No se modificaron archivos JS/CSS en SP#4, pero si el usuario ve un error de Vite manifest hay que re-buildear.

- [ ] **Step 1: Si hay errores de Vite en el browser, ejecutar**

```powershell
npm run build
```

Expected: `✓ built in Xs`

- [ ] **Step 2: Si todo funciona sin build, omitir este task**

---

## Checklist de verificación manual (sin tests)

Una vez implementado, verificar en el browser abriendo una conversación con cliente vinculado:

1. **Panel sin ticket:** Se muestra el input de búsqueda + botón "Crear ticket" (solo si hay cliente).
2. **Búsqueda:** Escribir "TK-" en el input → aparece dropdown con tickets de la empresa.
3. **Vincular:** Hacer click en un ticket del dropdown → el panel muestra el ticket vinculado con código, estado y prioridad.
4. **Desvincular:** Click en "Desvincular" → vuelve a mostrar el buscador.
5. **Crear ticket:** Click en "Crear ticket" → modal se abre; llenar asunto + descripción + click "Crear y vincular" → modal cierra, ticket aparece vinculado en el panel con código nuevo (TK-YYYY-NNNNNN).
6. **Ver ticket:** Link "Ver ticket →" abre `admin.tickets.show` en nueva pestaña.
7. **Vehículos:** Si el cliente tiene vehículos, aparece sección "Vehículos" con dot verde/gris + placa + marca modelo.
8. **Permisos:** Un usuario sin permiso `reply` no ve los controles de vincular/desvincular/crear.
