# WhatsApp Omnicanal SP#4 — Integración Tickets + Panel GPS/Vehículos

**Fecha:** 2026-06-16  
**Rama:** `feature/whatsapp-omnicanal-sp1`  
**Sprint:** SP#4 (Ticket integration + GPS panel)

---

## Contexto

El inbox ya muestra contacto, cliente vinculado y otras conversaciones (SP#2). Las políticas y jerarquía están implementadas (SP#3). SP#4 conecta el mundo WhatsApp con el sistema de tickets y con la flota GPS del cliente, todo en el panel derecho (`ContactPanel`).

El modelo `WhatsappConversation` ya tiene `ticket_id` (FK nullable) y la relación `ticket()` declarada — solo falta UI + acciones.

---

## Alcance SP#4

1. **Vincular / desvincular** una conversación a un ticket existente.
2. **Crear un ticket nuevo** directamente desde la conversación (pre-rellena `customer_id`).
3. **Panel de vehículos del cliente**: muestra la flota con estado GPS local (sin llamadas API en tiempo real).

---

## Sección 1: Capa de datos — Acciones

**Sin migraciones nuevas.** `whatsapp_conversations.ticket_id` ya existe.

### Nuevos Actions en `app/Actions/WhatsFleep/`

#### `LinkConversationToTicketAction`

```php
public function execute(WhatsappConversation $conversation, int $ticketId, User $actor): void
```

- Autorización: `Gate::forUser($actor)->authorize('reply', $conversation)`
- Carga el `Ticket` con `->withoutGlobalScope(EmpresaScope::class)` para evitar que EmpresaScope bloquee
- Verifica que `$ticket->empresa_id === $conversation->empresa_id` (guard multi-tenant explícito)
- Hace `$conversation->forceFill(['ticket_id' => $ticketId])->save()`
- Emite `broadcast(new ConversationUpdated($conversation))`

#### `UnlinkConversationFromTicketAction`

```php
public function execute(WhatsappConversation $conversation, User $actor): void
```

- Autorización: `Gate::forUser($actor)->authorize('reply', $conversation)`
- Hace `$conversation->forceFill(['ticket_id' => null])->save()`
- Emite `broadcast(new ConversationUpdated($conversation))`

#### `CreateTicketFromConversationAction`

```php
public function execute(WhatsappConversation $conversation, array $data, User $actor): Ticket
```

- Autorización: `Gate::forUser($actor)->authorize('reply', $conversation)`
- Requiere que `$conversation->cliente_id` no sea null (falla con excepción descriptiva si lo es)
- Llama a `CreateTicketAction::execute()` con:
  ```php
  [
      'empresa_id'  => $conversation->empresa_id,
      'subject'     => $data['subject'],
      'description' => $data['description'],
      'priority'    => $data['priority'],
      'category_id' => $data['category_id'] ?? null,
      'customer_id' => $conversation->cliente_id,
  ]
  ```
- Luego llama a `LinkConversationToTicketAction::execute($conversation, $ticket->id, $actor)`
- Retorna el `Ticket` recién creado

**Autorización en los tres actions:** `reply` — cualquier agente que puede responder puede vincular tickets. Esto es consistente con el flujo omnicanal donde el agente gestiona la conversación de extremo a extremo.

---

## Sección 2: Componente `ContactPanel`

### Archivo: `app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php`

#### Nuevas propiedades públicas

```php
public string $ticketSearch = '';
public bool $showCreateTicketModal = false;
public string $createSubject = '';
public string $createPriority = 'medium';
public ?int $createCategoryId = null;
public string $createDescription = '';
```

#### Nuevas reglas de validación

```php
protected function createTicketRules(): array
{
    return [
        'createSubject'     => ['required', 'string', 'max:255'],
        'createPriority'    => ['required', 'in:low,medium,high,urgent'],
        'createCategoryId'  => ['nullable', 'integer', 'exists:ticket_categories,id'],
        'createDescription' => ['required', 'string', 'max:5000'],
    ];
}
```

#### Nuevos métodos

```php
public function linkTicket(int $ticketId): void
{
    $conversation = $this->conversation();
    if (! $conversation) { return; }
    app(LinkConversationToTicketAction::class)->execute($conversation, $ticketId, Auth::user());
    $this->reset('ticketSearch');
}

public function unlinkTicket(): void
{
    $conversation = $this->conversation();
    if (! $conversation) { return; }
    app(UnlinkConversationFromTicketAction::class)->execute($conversation, Auth::user());
}

public function openCreateTicketModal(): void
{
    $conversation = $this->conversation();
    if (! $conversation || ! $conversation->cliente_id) { return; }
    $this->reset(['createSubject', 'createPriority', 'createCategoryId', 'createDescription']);
    $this->createPriority = 'medium';
    $this->resetValidation();
    $this->showCreateTicketModal = true;
}

public function createAndLinkTicket(): void
{
    $this->validate($this->createTicketRules());
    $conversation = $this->conversation();
    if (! $conversation) { return; }
    app(CreateTicketFromConversationAction::class)->execute($conversation, [
        'subject'     => $this->createSubject,
        'description' => $this->createDescription,
        'priority'    => $this->createPriority,
        'category_id' => $this->createCategoryId,
    ], Auth::user());
    $this->showCreateTicketModal = false;
    $this->reset(['createSubject', 'createPriority', 'createCategoryId', 'createDescription']);
}
```

#### Cambios en `render()`

```php
public function render()
{
    $conversation = WhatsappConversation::with(['contact.cliente', 'ticket'])
        ->where('uuid', $this->uuid)
        ->first();

    $cliente  = $conversation?->contact?->cliente;
    $empresaId = $conversation?->empresa_id ?? session('empresa', 1);

    $otras = /* ... igual que antes ... */;

    // Búsqueda en vivo de tickets para vincular
    $ticketResults = $this->ticketSearch !== ''
        ? Ticket::where('empresa_id', $empresaId)
              ->where(fn ($q) => $q
                  ->where('code', 'like', $this->ticketSearch . '%')
                  ->orWhere('subject', 'like', '%' . $this->ticketSearch . '%'))
              ->whereNull('deleted_at')
              ->limit(5)
              ->get(['id', 'code', 'subject', 'status', 'priority'])
        : collect();

    // Vehículos del cliente (estado GPS local, sin llamada API)
    $vehiculos = $cliente
        ? $cliente->vehiculos()->limit(8)->get(['id', 'placa', 'gpswox_active', 'marca', 'modelo'])
        : collect();

    // Categorías para el formulario de creación
    $categories = TicketCategory::where('empresa_id', $empresaId)
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
```

**Nota:** `Ticket` usa `EmpresaScope` (filtra por `session('empresa', 1)`), pero para evitar dependencia implícita de la sesión dentro de un componente Livewire, se filtra explícitamente por `empresa_id`. Se usa `withoutGlobalScope(EmpresaScope::class)` + `->where('empresa_id', $empresaId)` para ser explícitos.

---

## Sección 3: Vista `contact-panel.blade.php`

### Sección "Ticket vinculado" (reemplaza el placeholder SP#4)

**Cuando hay ticket vinculado:**
```
┌─────────────────────────────────────────┐
│ 🎫 Ticket vinculado                    │
│ TK-2026-000042  [En Progreso] [Alta]   │
│ "Falla en el dispositivo GPS de camión"│
│                 [Ver →]  [Desvincular] │
└─────────────────────────────────────────┘
```
- Código en badge morado/indigo + subject truncado
- `status->statusColor()` para el chip de estado
- `priority->statusColor()` para el chip de prioridad
- "Ver →" → `route('admin.tickets.show', $conversation->ticket)` (target `_blank`)
- "Desvincular" → `wire:click="unlinkTicket"` (solo si `@can('reply', $conversation)`)

**Cuando no hay ticket:**
```
┌─────────────────────────────────────────┐
│ 🎫 Ticket                              │
│ [🔍 Buscar por código o asunto...    ] │
│   TK-2026-000040 · Problema señal GPS  │  ← dropdown vivo
│   TK-2026-000038 · Revisión preventiva │
│ [+ Crear ticket]                        │
└─────────────────────────────────────────┘
```
- Input `wire:model.live.debounce.300ms="ticketSearch"`
- Dropdown con hasta 5 resultados; cada uno tiene un botón `wire:click="linkTicket({{ $t->id }})"`
- Botón "+ Crear ticket" → `wire:click="openCreateTicketModal"` (solo si `$cliente` existe, ya que el ticket requiere `customer_id`)

### Sección "Vehículos" (solo si `$vehiculos->isNotEmpty()`)

```
VEHÍCULOS DEL CLIENTE
• ● ADE-450   Toyota Hilux
• ○ BCF-221   Hyundai H100
• ● ADF-730   Volvo FH
```
- `●` verde = `gpswox_active = true`, `○` gris = false
- Placa en `font-mono text-xs`, marca/modelo en `text-[11px] text-gray-500`

### Modal "Crear ticket"

Usa `<x-form.modal.card title="Crear ticket" wire:model.live="showCreateTicketModal">`:
- **Asunto** (requerido, text input)
- **Prioridad** (select: Baja / Media / Alta / Urgente)
- **Categoría** (select opcional, opciones de `$categories`)
- **Descripción** (textarea, requerida)
- Footer: `[Cancelar]` (`$wire.set('showCreateTicketModal', false)`) + `[Crear y vincular]` (`wire:click="createAndLinkTicket"`)

---

## Sección 4: Límites de alcance (fuera de SP#4)

- **No** live GPS position/mapa en el inbox
- **No** crear tickets sin cliente vinculado (el botón "+ Crear ticket" se oculta si no hay `$cliente`)
- **No** editar tickets desde el inbox (solo ver + vincular/crear)
- **No** nueva ruta ni nuevo controlador
- **No** nueva migración

---

## Archivos afectados

| Acción | Archivo |
|--------|---------|
| Crear | `app/Actions/WhatsFleep/LinkConversationToTicketAction.php` |
| Crear | `app/Actions/WhatsFleep/UnlinkConversationFromTicketAction.php` |
| Crear | `app/Actions/WhatsFleep/CreateTicketFromConversationAction.php` |
| Modificar | `app/Livewire/Admin/WhatsFleep/Inbox/ContactPanel.php` |
| Modificar | `resources/views/livewire/admin/whats-fleep/inbox/contact-panel.blade.php` |
