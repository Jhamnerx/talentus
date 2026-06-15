# Spec — WhatsApp Omnicanal · Subsistema #1: Núcleo conversacional + persistencia

- **Fecha:** 2026-06-15
- **Estado:** Aprobado para escribir plan de implementación
- **Alcance:** Solo SP#1 (de 5 subsistemas). Ver §11 para los límites.

---

## 1. Contexto

La empresa de monitoreo GPS atiende a clientes por WhatsApp usando un servidor Node/Baileys
(`server/`, puerto 3000) que comparte la base MySQL con la app Laravel 12. Hoy los mensajes
**entrantes no se persisten** como conversación: `server/controllers/incomingMessage.js` solo
dispara auto-respuestas o un webhook, y `message_histories` es una bitácora de salida.

Este subsistema construye **la columna vertebral**: un modelo conversacional persistente y un
pipeline de ingesta que guarda **todo** mensaje entrante y saliente de forma confiable, aunque
ningún navegador tenga el inbox abierto. Sobre esta base se construyen los SP#2–5.

### Infraestructura existente relevante

- **Reverb** ya configurado (`REVERB_*` en `.env`) — no hay que montar broadcasting.
- **Módulo Tickets maduro**: `Ticket` con `EmpresaScope`, enums `TicketStatus`/`TicketPriority`,
  SLA, `assigned_to`, `customer_id`→`Clientes`, `vehiculo_id`.
- **`EmpresaScope`** (multi-tenant) lee `session('empresa', 1)`.
- **Envío saliente** existente: componentes Livewire hacen `Http::post` al Node
  (`/api/send-message`, `/api/send-image`, etc.).
- **`devices`**: `id, user_id, body (token único), webhook, status, api_key, interno, es_postventa`.
  **No tiene `empresa_id`** (solo `user_id`).
- **`contacts`** (modelo `App\Models\WhatsFleep\Contact`): `id, user_id, tag_id (nullable),
  name, number, timestamps`. Tabla vacía actualmente.
- **`clientes`**: tiene `telefono`, `email`, `empresa_id` (default 1), `numero_documento`.
- **`contactos`** (contactos de cliente, distinto de `contacts`): tiene `telefono`,
  `numero_documento`, `empresa_id`, `cliente_id`.

---

## 2. Decisiones de diseño (acordadas)

| # | Decisión | Elección |
|---|----------|----------|
| D1 | **Ingesta Node→Laravel** | Node hace `POST` a un endpoint interno de Laravel; el controller despacha un **Job en cola** que persiste, hila la conversación, emite eventos y notifica. Toda la lógica de negocio vive en Laravel. |
| D2 | **Threading (1 contacto → N conversaciones)** | Como máximo **una** conversación abierta por `(contacto, dispositivo)`. El entrante se pega a ella; si todas están cerradas, se crea una nueva. Las múltiples conversaciones nacen al cerrar una y abrir otra (o creación manual desde ticket en SP#4). |
| D3 | **Contacto ↔ Cliente** | Auto-match por teléfono normalizado contra `clientes.telefono` y `contactos.telefono`. Con match → `cliente_id` + `empresa_id` del cliente. Sin match → contacto sin cliente, empresa por defecto; vinculación manual posterior. |
| D4 | **Identidad de contacto** | **Reutilizar la tabla `contacts`** como identidad única (campañas + conversaciones). NO crear `whatsapp_contacts`. Se extiende `contacts` con columnas de WhatsApp. |
| D5 | **Adjuntos** | Node descarga el binario con `downloadMediaMessage`, lo escribe en `storage/app/whatsapp/...` (disco **privado** `local`, mismo servidor) y manda la **ruta** + metadatos en el POST. Laravel solo registra metadatos. Los adjuntos **no** se sirven por URL pública: `mediaUrl()` devuelve una ruta autenticada (`admin.whatsapp.media`) que transmite el archivo solo con sesión (`auth:sanctum`+`verified`); el rol fino por conversación es SP#3. |
| D6 | **Multi-tenancy del Job** | Los modelos WhatsApp **no** dependen de `session('empresa')` (no existe en un worker de cola). Se setea `empresa_id` explícito al crear y se filtra con un scope propio activado por el Job. |

---

## 3. Arquitectura y flujo de datos

Principio rector: **toda la lógica de negocio vive en Laravel; Node es solo transporte WhatsApp.**
Node nunca decide threading, empresa ni tickets.

### 3.1 Flujo entrante (mensaje del cliente)

```
Baileys messages.upsert  (server/controllers/incomingMessage.js)
  → si hay media: downloadMediaMessage → escribe storage/app/whatsapp/{device}/{id}.ext  (disco PRIVADO)
  → POST {laravel}/api/internal/whatsapp/incoming   (header X-Internal-Token)
      → VerifyInternalToken (middleware)
      → IncomingWhatsappController@store
          → StoreIncomingWhatsappRequest (valida)
          → ProcessIncomingWhatsappMessage::dispatch($validated)->onQueue('whatsapp')
          → 202 Accepted
              ── worker de cola ──────────────────────────────
              Job (transaccional, idempotente):
                1. ResolveWhatsappContact   → normaliza nº, resuelve empresa, firstOrCreate contact, auto-match cliente_id
                2. ResolveConversation      → reabre conversación abierta (contacto,device) o crea nueva
                3. PersistIncomingMessage   → firstOrCreate message por (device_id, wa_message_id); unread_count++; last_message_*
                4. broadcast(NewWhatsappMessage)  +  broadcast(ConversationUpdated)
```

La persistencia **no depende del navegador**: ocurre en el worker. Sin inbox abierto, el mensaje
queda guardado y `unread_count` actualizado. Al abrir el inbox (SP#2), se carga el historial.

### 3.2 Flujo saliente (agente responde) — esqueleto, lo consume SP#2

```
SendWhatsappMessageAction (App\Actions\WhatsFleep)
  1. Crea WhatsappMessage (sender_type=Agent, status=Pending) en DB   ← se persiste ANTES de salir
  2. Delega el envío al WhatsappService existente (App\Services\WhatsFleep\WhatsappService → Impl)
     que hace el POST al Node /api/send-*  (NO se reinventa el cliente HTTP)
  3. Node responde con wa_message_id → se guarda en el registro; status=Sent
```

### 3.3 Flujo de estado (acks de WhatsApp)

```
Baileys messages.update (delivered/read)
  → POST {laravel}/api/internal/whatsapp/status   (X-Internal-Token)
      → IncomingWhatsappController@status
          → actualiza status / delivered_at / read_at del WhatsappMessage  +  broadcast(ConversationUpdated)
```

---

## 4. Modelo de datos (migraciones)

Todas las tablas nuevas llevan `empresa_id` para multi-tenant.

### 4.1 `alter` sobre `contacts` (migración nueva)

Agrega:
- `empresa_id` bigint unsigned, default 1, índice
- `cliente_id` bigint unsigned **nullable**, FK `clientes` (sin cascade; `nullOnDelete`)
- `wa_jid` string nullable
- `push_name` string nullable
- `profile_pic_url` string nullable
- `metadata` json nullable
- **único `(empresa_id, number)`**

Se conservan `user_id`, `tag_id`, `name`. En alta por mensaje entrante:
`user_id = device->user_id`, `number` **normalizado** (sin código país 51 / sin no-dígitos).

> No se agrega `EmpresaScope` global al modelo `Contact` (rompería el CRUD de campañas que filtra
> por `user_id`). El `empresa_id` se setea y se filtra explícitamente en queries de conversaciones.

### 4.2 `whatsapp_conversations`

| Columna | Tipo | Notas |
|---------|------|-------|
| `id` | bigint PK | |
| `uuid` | uuid | índice único; usado en canales/ rutas |
| `empresa_id` | bigint | índice |
| `device_id` | FK `devices` | |
| `contact_id` | FK `contacts` | |
| `cliente_id` | FK `clientes` nullable | auto-match |
| `ticket_id` | FK `tickets` nullable | columna sin lógica en SP#1 (SP#4) |
| `assigned_user_id` | FK `users` nullable | columna sin lógica de rol en SP#1 (SP#3) |
| `status` | enum | `open` / `pending` / `closed` |
| `priority` | enum | `low` / `normal` / `high` / `emergency` (default `normal`) |
| `unread_count` | unsigned int | default 0 |
| `last_message_id` | bigint nullable | |
| `last_message_at` | timestamp nullable | |
| `closed_at` | timestamp nullable | |
| `metadata` | json nullable | |
| timestamps + softDeletes | | |

Índices: `(empresa_id, status, last_message_at)`, `(contact_id, status)`, único `uuid`.

### 4.3 `whatsapp_messages`

| Columna | Tipo | Notas |
|---------|------|-------|
| `id` | bigint PK | |
| `uuid` | uuid | índice único |
| `empresa_id` | bigint | índice |
| `conversation_id` | FK `whatsapp_conversations` | onDelete cascade |
| `device_id` | FK `devices` | |
| `contact_id` | FK `contacts` | |
| `wa_message_id` | string nullable | id de WhatsApp |
| `sender_type` | enum | `contact` / `agent` / `system` |
| `sender_user_id` | FK `users` nullable | quién envió (agente) |
| `type` | enum | text/image/audio/video/document/location/contact/sticker |
| `body` | text nullable | |
| `media_path` | string nullable | ruta relativa en disco `public` |
| `mime_type` | string nullable | |
| `file_name` | string nullable | |
| `file_size` | unsigned bigint nullable | |
| `status` | enum | pending/sent/delivered/read/failed (default pending) |
| `is_read` | boolean | default false |
| `metadata` | json nullable | |
| `sent_at` | timestamp nullable | |
| `delivered_at` | timestamp nullable | |
| `read_at` | timestamp nullable | |
| timestamps | | |

Índices: `(conversation_id, created_at)`, **único `(device_id, wa_message_id)`** (idempotencia ante
reentregas de Baileys).

### 4.4 `whatsapp_assignments` (auditoría append-only)

`id`, `empresa_id`, `conversation_id` FK, `from_user_id` nullable, `to_user_id` nullable,
`assigned_by` nullable, `note` nullable, `created_at`. (Su uso pleno es SP#3; aquí solo el modelo.)

### 4.5 `whatsapp_tags` + pivote `whatsapp_conversation_tag`

- `whatsapp_tags`: `id`, `empresa_id`, `name`, `slug`, `color`. Único `(empresa_id, slug)`.
- pivote: `whatsapp_conversation_id`, `whatsapp_tag_id`. (Asignación automática es SP#5.)

---

## 5. Modelos Eloquent y enums

Namespace `App\Models\WhatsFleep\` (junto a los existentes).

### 5.1 Enums (`App\Enums\WhatsFleep\`, backed enums, claves TitleCase)

- `ConversationStatus`: `Open='open'`, `Pending='pending'`, `Closed='closed'`
- `ConversationPriority`: `Low`, `Normal`, `High`, `Emergency`
- `MessageType`: `Text`, `Image`, `Audio`, `Video`, `Document`, `Location`, `Contact`, `Sticker`
- `MessageSenderType`: `Contact`, `Agent`, `System`
- `MessageStatus`: `Pending`, `Sent`, `Delivered`, `Read`, `Failed`

### 5.2 Modelos

- **`WhatsappConversation`** — `casts()`: status/priority enums, `last_message_at`/`closed_at`
  datetime, `metadata` array. `SoftDeletes`. Relaciones: `contact()`, `cliente()`
  (`withTrashed()` + `withoutGlobalScope(EmpresaScope)`), `device()`, `assignedUser()`, `ticket()`,
  `messages()` (HasMany), `lastMessage()` (BelongsTo), `assignments()` (HasMany), `tags()`
  (BelongsToMany). Scopes: `scopeForTenant($empresaId)`, `scopeOpen()`, `scopeAssignedTo($userId)`.
- **`WhatsappMessage`** — `casts()`: type/sender_type/status enums, `sent_at`/`delivered_at`/
  `read_at` datetime, `metadata` array, `is_read` boolean. Relaciones: `conversation()`,
  `contact()`, `device()`, `senderUser()`. Accessor `mediaUrl()` (`Storage::disk('public')->url`).
  Scopes: `scopeFromContact()`, `scopeUnread()`.
- **`WhatsappAssignment`** — relaciones `conversation()`, `fromUser()`, `toUser()`, `assignedBy()`.
- **`WhatsappTag`** — `conversations()` BelongsToMany.
- **`Contact`** (existente, extendido) — agregar `cliente()` (BelongsTo nullable) y
  `conversations()` (HasMany). Sin tocar lo de campañas.

Todos los métodos con return type hints y promoción de constructor donde aplique (convención del proyecto).

---

## 6. Capa de ingesta

### 6.1 Rutas (`routes/api.php`)

```php
Route::prefix('internal/whatsapp')
    ->middleware('whatsapp.internal')           // VerifyInternalToken
    ->name('api.internal.whatsapp.')
    ->group(function () {
        Route::post('incoming', [IncomingWhatsappController::class, 'store'])->name('incoming');
        Route::post('status',   [IncomingWhatsappController::class, 'status'])->name('status');
    });
```

### 6.2 Middleware `VerifyInternalToken`

Compara header `X-Internal-Token` con `config('whatsapp.internal_token')`. Falla → `401`.
Registrar alias `whatsapp.internal` en `app/Http/Kernel.php` (`$routeMiddleware`).

### 6.3 `StoreIncomingWhatsappRequest` (FormRequest)

Reglas (array-based, según convención): `device` required string; `wa_message_id` required string;
`from` required string; `wa_jid` nullable string; `push_name` nullable string;
`type` required in:enum; `body` nullable string; `media_path`/`mime_type`/`file_name` nullable string;
`file_size` nullable integer; `timestamp` nullable; `is_group` boolean.
Si `is_group=true` → el Job lo descarta (fuera de alcance, §11).

### 6.4 `IncomingWhatsappController`

- `store()`: valida → `ProcessIncomingWhatsappMessage::dispatch(...)->onQueue('whatsapp')` → `202`.
- `status()`: valida `wa_message_id` + `status` → actualiza el `WhatsappMessage` (delivered/read) →
  `broadcast(ConversationUpdated)`. Sin lógica pesada en el controller.

### 6.5 Job `ProcessIncomingWhatsappMessage` (`ShouldQueue`)

Orquesta servicios, no contiene SQL crudo. Transaccional. Idempotente vía único
`(device_id, wa_message_id)`. Setea contexto de empresa explícito (no usa sesión HTTP).

### 6.6 Actions (`App\Actions\WhatsFleep\`, sufijo `*Action`, como `App\Actions\Tickets\`)

- `ResolveWhatsappContactAction` — normaliza número, resuelve empresa (cliente match → su
  `empresa_id`; si no, `config('whatsapp.default_empresa_id')`), `firstOrCreate` contact por
  `(empresa_id, number)`, actualiza `push_name`/`wa_jid`, intenta `cliente_id` por
  `clientes.telefono`/`contactos.telefono`.
- `ResolveConversationAction` — reabre la conversación `open` de `(contact, device)` o crea una nueva.
- `PersistIncomingMessageAction` — crea el `WhatsappMessage` idempotente; actualiza `unread_count`,
  `last_message_id`, `last_message_at` de la conversación.
- `SendWhatsappMessageAction` — esqueleto de salida (§3.2); lo consume SP#2. **Reutiliza** el
  `App\Services\WhatsFleep\WhatsappService` existente para el POST al Node (no reinventa el HTTP).

> Las llamadas salientes al Node se hacen **siempre** vía el `WhatsappService` (interfaz +
> `Impl\WhatsappServiceImpl`) ya presente; las Actions solo orquestan persistencia + delegan envío.

### 6.7 Normalización de teléfono

Helper `normalize_wa_number(string): string` — quita no-dígitos y **garantiza la forma
internacional**: si el número es local (≤ 9 dígitos sin código), antepone `51` (Perú). El número del
contacto se **guarda internacional** (`51987654321`) porque el envío saliente lo requiere
(`formatReceipt` del Node no agrega el código de país). El auto-match compara la columna `telefono`
normalizada contra **ambas** formas candidatas (internacional y local sin `51`), por si en la BD
está guardada con o sin código.

---

## 7. Reverb — eventos emitidos (canales: ver reparto)

SP#1 **emite**; SP#2 **autoriza y consume** (SP#3 endurece por rol).

- **`NewWhatsappMessage`** (`ShouldBroadcast`) → `broadcastOn()`:
  `PrivateChannel("whatsapp.conversation.{conversationUuid}")`.
  Payload: mensaje serializado (id, uuid, sender_type, type, body, media_url, status, created_at).
- **`ConversationUpdated`** (`ShouldBroadcast`) → `broadcastOn()`:
  `PrivateChannel("whatsapp.empresa.{empresaId}")`.
  Payload: conversación resumida (uuid, last_message, unread_count, status, assigned_user_id).

> En SP#1 estos eventos se emiten aunque aún no exista autorización de canal (inofensivo). La
> autorización (`routes/channels.php`) y la suscripción Echo/Livewire son **SP#2**; el filtrado por
> rol (Agente/Supervisor/Gerente) es **SP#3**.

---

## 8. Cambios en Node (`server/`)

Mínimos y acotados:

- **`server/controllers/incomingMessage.js`**: tras el autoreply/webhook actual, **siempre**:
  1. Si el mensaje trae media → `downloadMediaMessage` → escribir a
     `storage/app/whatsapp/{device}/{wa_message_id}.{ext}` (disco **privado** `local`).
  2. `POST {LARAVEL_URL}/api/internal/whatsapp/incoming` con header `X-Internal-Token` y payload
     (device token, wa_message_id, from, push_name, type, body, media_path/mime/file_name/file_size,
     wa_jid, timestamp, is_group). Reutiliza `cleanPhoneNumber` existente.
- **`server/whatsapp.js`** (`messages.update`): además del log actual, `POST .../status` con
  `wa_message_id` + estado mapeado (delivered/read).
- Nueva config Node: `LARAVEL_URL`, `INTERNAL_TOKEN` y `WA_MEDIA_ROOT` desde `.env` (ya carga `dotenv`).

---

## 9. Configuración nueva

`config/whatsapp.php` (agregar):
```php
'internal_token'      => env('WHATSAPP_INTERNAL_TOKEN'),
'default_empresa_id'  => env('WHATSAPP_DEFAULT_EMPRESA_ID', 1),
'media_disk'          => env('WHATSAPP_MEDIA_DISK', 'local'),  // PRIVADO
'media_path'          => 'whatsapp',
'country_code'        => env('WHATSAPP_COUNTRY_CODE', '51'),
```
`.env` (Laravel y Node comparten el mismo archivo en la raíz; el token va en ambas variables):
```
WHATSAPP_INTERNAL_TOKEN=<random-largo>
WHATSAPP_DEFAULT_EMPRESA_ID=1
WHATSAPP_MEDIA_DISK=local
WHATSAPP_COUNTRY_CODE=51
# Bridge Node -> Laravel:
LARAVEL_URL=http://talentus.test
INTERNAL_TOKEN=<mismo valor que WHATSAPP_INTERNAL_TOKEN>
WA_MEDIA_ROOT=./storage/app/whatsapp
```
**Seguridad de adjuntos:** el disco es `local` (`storage/app`), **privado**. NO se usa el disco
`public` ni `storage:link` para la media de WhatsApp. Se sirven por la ruta autenticada
`GET admin/whatsapp/media/{message:uuid}` → `WhatsappMediaController@show`, dentro del grupo
`auth:sanctum`+`verified` (solo con sesión). El rol fino por conversación llega en SP#3.

**Cola:** el Job corre en la cola dedicada `whatsapp` (`->onQueue('whatsapp')`). En producción se
levanta un worker `php artisan queue:work --queue=whatsapp` gestionado por **supervisord** (a cargo
del usuario). En local basta `php artisan queue:work --queue=whatsapp` (o `QUEUE_CONNECTION=sync`
para pruebas manuales).

---

## 10. Idempotencia, concurrencia y errores

- **Idempotencia**: único `(device_id, wa_message_id)` + `firstOrCreate` → reentregas de Baileys no
  duplican. El Job es seguro de reintentar.
- **Concurrencia de threading**: `ResolveConversation` usa `lockForUpdate` dentro de la transacción
  para evitar dos conversaciones abiertas simultáneas ante mensajes casi-simultáneos.
- **Fallos**: el Job usa reintentos de cola (`tries`, `backoff`). Si Node no alcanza Laravel, el
  mensaje ya quedó en disco (media) y Baileys reintdrega el upsert; la persistencia es eventual.
- **Salida**: el `WhatsappMessage` se crea **antes** del POST a Node; si Node falla → `status=Failed`
  y se puede reintentar sin perder el registro.

---

## 11. Fuera de alcance de SP#1

| Tema | Subsistema |
|------|-----------|
| UI Livewire (Inbox, Sidebar, Vista, Composer, paneles) | SP#2 |
| Autorización de canales Reverb + suscripción Echo/Livewire + unread en vivo | SP#2 |
| Policies y jerarquía Agente/Supervisor/Gerente; filtrado por rol; reasignación | SP#3 |
| Crear/convertir/vincular ticket; panel GPS, última ubicación, bloqueo de motor | SP#4 |
| Reglas automáticas (robo→emergency), escalamiento 5/10 min, asignación de tags | SP#5 |
| Grupos de WhatsApp (las conversaciones son 1:1 cliente) | Fuera |

En SP#1, `ticket_id`, `assigned_user_id`, `priority` y los tags son **solo modelo/columna** sin
lógica asociada.

---

## 12. Estrategia de validación (sin `php artisan test`)

> Restricción conocida del proyecto: el suite usa la base real y `RefreshDatabase` la borraría.
> **No se ejecutará `php artisan test`.**

- Validación de cada archivo PHP con `php -l`.
- Revisión manual de queries (eager loading, evitar N+1) y de los índices definidos.
- Opcional, si el usuario lo pide: dejar tests escritos (PHPUnit) **sin ejecutarlos**.

---

## 13. Inventario de archivos (crear / editar)

**Migraciones (crear):**
- `*_add_whatsapp_fields_to_contacts_table.php`
- `*_create_whatsapp_conversations_table.php`
- `*_create_whatsapp_messages_table.php`
- `*_create_whatsapp_assignments_table.php`
- `*_create_whatsapp_tags_table.php`
- `*_create_whatsapp_conversation_tag_table.php`

**Enums (crear):** `ConversationStatus`, `ConversationPriority`, `MessageType`,
`MessageSenderType`, `MessageStatus`.

**Modelos (crear):** `WhatsappConversation`, `WhatsappMessage`, `WhatsappAssignment`, `WhatsappTag`.
**Modelo (editar):** `App\Models\WhatsFleep\Contact` (+`cliente()`, `conversations()`, fillables).

**Ingesta (crear):** `VerifyInternalToken` (middleware), `IncomingWhatsappController`,
`StoreIncomingWhatsappRequest`, `ProcessIncomingWhatsappMessage` (Job).

**Actions (crear, `App\Actions\WhatsFleep\`):** `ResolveWhatsappContactAction`,
`ResolveConversationAction`, `PersistIncomingMessageAction`, `SendWhatsappMessageAction`.
**Servicio (reutilizar):** `App\Services\WhatsFleep\WhatsappService` (interfaz + `Impl`) para el envío al Node.

**Eventos (crear):** `NewWhatsappMessage`, `ConversationUpdated`.

**Helper (editar):** `app/helpers.php` (+`normalize_wa_number`).

**Config (editar):** `config/whatsapp.php`, `.env`(.example).
**Routing (editar):** `routes/api.php`, `app/Http/Kernel.php` (alias middleware).

**Node (editar):** `server/controllers/incomingMessage.js`, `server/whatsapp.js`.

---

## 14. Criterios de aceptación de SP#1

1. Un mensaje entrante (con o sin media) se persiste como `WhatsappMessage` ligado a una
   `WhatsappConversation`, **sin** ningún navegador abierto.
2. Reentregar el mismo `wa_message_id` **no** crea duplicados.
3. Un número que coincide con `clientes.telefono`/`contactos.telefono` queda con `cliente_id` y
   `empresa_id` correctos; sin match → contacto sin cliente con empresa por defecto.
4. Un segundo mensaje del mismo contacto+dispositivo cae en la **misma** conversación abierta;
   tras cerrarla, uno nuevo abre **otra** conversación.
5. Los adjuntos quedan en `storage/app/public/whatsapp/...` con metadatos correctos y `mediaUrl()`
   resuelve a una URL servible.
6. Se emiten `NewWhatsappMessage` y `ConversationUpdated` por los canales definidos.
7. Un mensaje saliente creado por `SendWhatsappMessageAction` se persiste antes del POST a Node y
   su `status` evoluciona con los acks (`/status`).
8. Todos los archivos PHP pasan `php -l`.
