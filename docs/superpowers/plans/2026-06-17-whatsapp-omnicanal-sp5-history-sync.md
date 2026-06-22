# WhatsApp Omnicanal · SP#5 Sincronización de Historial — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Agregar un botón "Sincronizar historial" en el Inbox de WhatsApp que pide a Baileys los 50 mensajes anteriores (en ambos sentidos) al más antiguo que ya tenemos, y los persiste sin bloquear la UI.

**Architecture:** Node pide el historial a Baileys (`sock.fetchMessageHistory`) y responde rápido; un listener global de `messaging-history.set` recoge el lote on-demand y lo reenvía a Laravel en un solo POST; un Job lo persiste (reutilizando `ResolveWhatsappContactAction`/`ResolveConversationAction` ya existentes) y emite `HistorySynced` (`ShouldBroadcastNow`) por cada conversación tocada, que el frontend ya escucha vía Echo.

**Tech Stack:** Laravel 12, Livewire 4, Node/Baileys 7, Redis (colas), Reverb (broadcasting).

> **Restricción de validación (igual que SP1-SP4):** NUNCA ejecutar `php artisan test`. Verificación de cada archivo PHP es `php -l <archivo>`. Verificación de cada archivo JS es `node --check <archivo>`.

**Spec:** `docs/superpowers/specs/2026-06-17-whatsapp-omnicanal-sp5-history-sync-design.md`

---

## File Structure

**Node**
- Modify `server/controllers/incomingMessage.js` — exportar `mapMessageType`, nueva función `processHistoryBatch`
- Modify `server/whatsapp.js` — nueva función `fetchMessageHistory`, listener `messaging-history.set`
- Modify `server/router/index.js` — nueva ruta `POST /api/sync-history`

**Laravel**
- Create `app/Events/WhatsFleep/HistorySynced.php`
- Create `app/Http/Requests/WhatsFleep/StoreHistoryBatchRequest.php`
- Create `app/Jobs/WhatsFleep/ProcessWhatsappHistoryBatch.php`
- Modify `app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php` — método `historyBatch`
- Modify `routes/api.php` — ruta `history-batch`
- Modify `app/Services/WhatsFleep/WhatsappService.php` + `Impl/WhatsappServiceImpl.php` — método `syncHistory`
- Create `app/Actions/WhatsFleep/SyncWhatsappHistoryAction.php`
- Modify `app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php` — método `syncHistory`, listener
- Modify `resources/views/livewire/admin/whats-fleep/inbox/conversation-view.blade.php` — botón

---

## Task 1: Node — exportar `mapMessageType` y crear `processHistoryBatch`

**Files:**
- Modify: `server/controllers/incomingMessage.js`

- [ ] **Step 1: Exportar `mapMessageType`**

Busca la función (cerca de la línea 25):
```js
function mapMessageType(messageType) {
```
Cámbiala a:
```js
export function mapMessageType(messageType) {
```

- [ ] **Step 2: Añadir `processHistoryBatch` al final del archivo**

Añade después de la función `persistIncomingToLaravel` (al final del archivo):

```js
/**
 * Procesa un lote de mensajes históricos recibido vía el evento Baileys
 * 'messaging-history.set' (on-demand) y lo envía a Laravel en un solo POST.
 * A diferencia de IncomingMessage(), incluye mensajes salientes (fromMe).
 */
export async function processHistoryBatch(messages, whatsappClient, deviceToken) {
    const payloads = [];

    for (const msg of messages) {
        if (!msg.message || !msg.key?.remoteJid || !msg.key?.id) continue;
        if (msg.key.remoteJid.endsWith("@g.us")) continue;
        if (msg.key.remoteJid === "status@broadcast") continue;

        const {
            command: messageText,
            body: fullBody,
            from,
            senderName,
            messageType,
        } = await parseIncomingMessage(msg);

        const remoteJid = msg.key.remoteJid;
        const fromMe = msg.key.fromMe || false;
        const cleanNumber = await resolveRealNumber(
            whatsappClient,
            remoteJid,
            cleanPhoneNumber(from) || cleanPhoneNumber(remoteJid),
        );

        payloads.push({
            wa_message_id: msg.key.id,
            from_me: fromMe,
            from: cleanNumber,
            wa_jid: remoteJid,
            push_name: senderName || null,
            type: mapMessageType(messageType),
            body: fullBody || messageText || null,
            timestamp: Number(msg.messageTimestamp) || Math.floor(Date.now() / 1000),
        });
    }

    if (payloads.length === 0) return;

    try {
        await axios.post(
            `${LARAVEL_URL}/api/internal/whatsapp/history-batch`,
            { device: deviceToken, messages: payloads },
            {
                timeout: 30000,
                headers: {
                    "Content-Type": "application/json",
                    "X-Internal-Token": INTERNAL_TOKEN,
                },
            },
        );
    } catch (error) {
        logger.error(
            "Error persistiendo historial en Laravel:",
            error?.response?.status || error.message,
        );
    }
}
```

- [ ] **Step 3: Verificar sintaxis**

Run: `node --check server/controllers/incomingMessage.js`
Expected: sin salida (exit 0)

- [ ] **Step 4: Commit**

```bash
git add server/controllers/incomingMessage.js
git commit -m "feat(wa): processHistoryBatch para sincronización de historial on-demand"
```

---

## Task 2: Node — `fetchMessageHistory` y listener `messaging-history.set`

**Files:**
- Modify: `server/whatsapp.js`

- [ ] **Step 1: Importar `processHistoryBatch`**

Busca la línea:
```js
import { IncomingMessage } from "./controllers/incomingMessage.js";
```
Cámbiala a:
```js
import { IncomingMessage, processHistoryBatch } from "./controllers/incomingMessage.js";
```

- [ ] **Step 2: Añadir el listener, justo después del listener `messages.update` (antes de `return { sock, qrcode... }`)**

Busca:
```js
        // Actualizaciones de mensajes
        sock.ev.on("messages.update", (updates) => {
            for (const update of updates) {
                if (update.update.status) {
                    logger.debug(
                        `Mensaje ${update.key.id} → estado ${update.update.status}`,
                    );
                    if (update.key?.fromMe) {
                        reportStatusToLaravel(
                            token,
                            update.key.id,
                            update.update.status,
                        );
                    }
                }
            }
        });

        return {
            sock,
            qrcode: qrCodes.get(token),
        };
```

Reemplázala por:
```js
        // Actualizaciones de mensajes
        sock.ev.on("messages.update", (updates) => {
            for (const update of updates) {
                if (update.update.status) {
                    logger.debug(
                        `Mensaje ${update.key.id} → estado ${update.update.status}`,
                    );
                    if (update.key?.fromMe) {
                        reportStatusToLaravel(
                            token,
                            update.key.id,
                            update.update.status,
                        );
                    }
                }
            }
        });

        // Sincronización de historial bajo demanda (botón "Sincronizar historial" del Inbox)
        sock.ev.on("messaging-history.set", async ({ messages, syncType }) => {
            if (syncType !== proto.HistorySync.HistorySyncType.ON_DEMAND) return;
            if (!messages || messages.length === 0) return;

            try {
                await processHistoryBatch(messages, sock, token);
            } catch (error) {
                logger.error("Error procesando historial:", error);
            }
        });

        return {
            sock,
            qrcode: qrCodes.get(token),
        };
```

- [ ] **Step 3: Añadir la función `fetchMessageHistory` exportada, junto a `sendText` (cerca de la línea 608)**

Busca:
```js
/**
 * Enviar mensaje de texto
 */
export async function sendText(token, to, text, simulateTyping = true) {
```

Inserta ANTES de ese bloque:
```js
/**
 * Solicitar historial de mensajes anteriores a un punto de referencia
 * conocido (on-demand history sync). La respuesta llega de forma asíncrona
 * vía el evento 'messaging-history.set' registrado en connectToWhatsApp().
 */
export async function fetchMessageHistory(token, oldestMsgKey, oldestMsgTimestamp, count) {
    const sock = sockets.get(token);
    if (!sock) throw new Error("Dispositivo no conectado");

    return await sock.fetchMessageHistory(count, oldestMsgKey, oldestMsgTimestamp);
}

/**
 * Enviar mensaje de texto
 */
export async function sendText(token, to, text, simulateTyping = true) {
```

- [ ] **Step 4: Verificar sintaxis**

Run: `node --check server/whatsapp.js`
Expected: sin salida (exit 0)

- [ ] **Step 5: Commit**

```bash
git add server/whatsapp.js
git commit -m "feat(wa): listener messaging-history.set y fetchMessageHistory"
```

---

## Task 3: Node — endpoint `POST /api/sync-history`

**Files:**
- Modify: `server/router/index.js`

- [ ] **Step 1: Añadir la ruta, junto a `/api/send-message`**

Busca el cierre del handler de `/api/send-message` (el `});` que sigue al bloque que termina con `res.status(500).json({... "Error enviando mensaje" ...});`) y añade justo después:

```js
/**
 * @route POST /api/sync-history
 * @desc Solicitar historial de mensajes anteriores (on-demand history sync)
 */
router.post("/api/sync-history", checkIpWhitelist, async (req, res) => {
    try {
        const { token, jid, count, oldestMsgTimestamp } = req.body;
        const oldestMsgKey = req.body.oldestMsgKey
            ? JSON.parse(req.body.oldestMsgKey)
            : null;

        if (!token || !jid || !count || !oldestMsgKey || !oldestMsgTimestamp) {
            return res.status(400).json({
                status: false,
                message:
                    "token, jid, count, oldestMsgKey y oldestMsgTimestamp son requeridos",
            });
        }

        if (!wa.isConnected(token)) {
            return res.status(400).json({
                status: false,
                message: "Dispositivo no conectado",
            });
        }

        await wa.fetchMessageHistory(token, oldestMsgKey, Number(oldestMsgTimestamp), Number(count));

        res.status(202).json({ status: true, message: "Sincronización iniciada" });
    } catch (error) {
        logger.error("Error solicitando historial:", error);
        res.status(500).json({
            status: false,
            message: "Error solicitando historial",
            error: error.message,
        });
    }
});
```

- [ ] **Step 2: Verificar sintaxis**

Run: `node --check server/router/index.js`
Expected: sin salida (exit 0)

- [ ] **Step 3: Commit**

```bash
git add server/router/index.js
git commit -m "feat(wa): endpoint POST /api/sync-history"
```

---

## Task 4: Laravel — Evento `HistorySynced`

**Files:**
- Create: `app/Events/WhatsFleep/HistorySynced.php`

- [ ] **Step 1: Crear el evento**

```php
<?php

namespace App\Events\WhatsFleep;

use App\Models\WhatsFleep\WhatsappConversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HistorySynced implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public WhatsappConversation $conversation)
    {
    }

    /**
     * @return array<int, PrivateChannel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('whatsapp.conversation.' . $this->conversation->uuid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'wa.history.synced';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'conversation_id' => $this->conversation->id,
        ];
    }
}
```

> Se usa `ShouldBroadcastNow` (no `ShouldBroadcast`) para evitar el salto extra de cola — mismo criterio aplicado a `NewWhatsappMessage`/`ConversationUpdated` en esta sesión.

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Events/WhatsFleep/HistorySynced.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Events/WhatsFleep/HistorySynced.php
git commit -m "feat(wa): evento HistorySynced (ShouldBroadcastNow)"
```

---

## Task 5: Laravel — `StoreHistoryBatchRequest`

**Files:**
- Create: `app/Http/Requests/WhatsFleep/StoreHistoryBatchRequest.php`

- [ ] **Step 1: Crear el FormRequest**

```php
<?php

namespace App\Http\Requests\WhatsFleep;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHistoryBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'device' => ['required', 'string'],
            'messages' => ['required', 'array', 'min:1'],
            'messages.*.wa_message_id' => ['required', 'string'],
            'messages.*.from_me' => ['required', 'boolean'],
            'messages.*.from' => ['required', 'string'],
            'messages.*.wa_jid' => ['required', 'string'],
            'messages.*.push_name' => ['nullable', 'string'],
            'messages.*.type' => ['required', Rule::in(['text', 'image', 'audio', 'video', 'document', 'location', 'contact', 'sticker'])],
            'messages.*.body' => ['nullable', 'string'],
            'messages.*.timestamp' => ['nullable', 'integer'],
        ];
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Http/Requests/WhatsFleep/StoreHistoryBatchRequest.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Http/Requests/WhatsFleep/StoreHistoryBatchRequest.php
git commit -m "feat(wa): StoreHistoryBatchRequest"
```

---

## Task 6: Laravel — Job `ProcessWhatsappHistoryBatch`

**Files:**
- Create: `app/Jobs/WhatsFleep/ProcessWhatsappHistoryBatch.php`

- [ ] **Step 1: Crear el Job**

```php
<?php

namespace App\Jobs\WhatsFleep;

use App\Actions\WhatsFleep\ResolveConversationAction;
use App\Actions\WhatsFleep\ResolveWhatsappContactAction;
use App\Enums\WhatsFleep\MessageSenderType;
use App\Enums\WhatsFleep\MessageStatus;
use App\Enums\WhatsFleep\MessageType;
use App\Events\WhatsFleep\HistorySynced;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessWhatsappHistoryBatch implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(public array $payload)
    {
        $this->onQueue('whatsapp');
    }

    public function handle(
        ResolveWhatsappContactAction $resolveContact,
        ResolveConversationAction $resolveConversation
    ): void {
        $device = Device::where('body', $this->payload['device'])->first();

        if (! $device) {
            Log::warning('WA history: device not found', ['device' => $this->payload['device']]);
            return;
        }

        /** @var array<string, array{contact: \App\Models\WhatsFleep\Contact, conversation: \App\Models\WhatsFleep\WhatsappConversation}> $resolvedByJid */
        $resolvedByJid = [];

        foreach ($this->payload['messages'] as $messagePayload) {
            $waJid = $messagePayload['wa_jid'] ?? null;
            if (! $waJid) {
                continue;
            }

            DB::transaction(function () use (
                $messagePayload,
                $waJid,
                $device,
                $resolveContact,
                $resolveConversation,
                &$resolvedByJid
            ) {
                if (! isset($resolvedByJid[$waJid])) {
                    $resolved = $resolveContact->execute(
                        $device,
                        $messagePayload['from'],
                        $waJid,
                        $messagePayload['push_name'] ?? null
                    );

                    $conversation = $resolveConversation->execute(
                        $device,
                        $resolved['contact'],
                        $resolved['empresa_id'],
                        $resolved['cliente_id']
                    );

                    $resolvedByJid[$waJid] = ['contact' => $resolved['contact'], 'conversation' => $conversation];
                }

                ['contact' => $contact, 'conversation' => $conversation] = $resolvedByJid[$waJid];

                $type = MessageType::tryFrom($messagePayload['type'] ?? 'text') ?? MessageType::Text;
                $sentAt = isset($messagePayload['timestamp'])
                    ? Carbon::createFromTimestamp((int) $messagePayload['timestamp'])
                    : now();
                $fromMe = (bool) ($messagePayload['from_me'] ?? false);

                WhatsappMessage::firstOrCreate(
                    [
                        'device_id' => $device->id,
                        'wa_message_id' => $messagePayload['wa_message_id'],
                    ],
                    [
                        'empresa_id' => $conversation->empresa_id,
                        'conversation_id' => $conversation->id,
                        'contact_id' => $contact->id,
                        'sender_type' => $fromMe ? MessageSenderType::Agent : MessageSenderType::Contact,
                        'type' => $type,
                        'body' => $messagePayload['body'] ?? null,
                        // Los mensajes históricos no deben generar "no leídos" para
                        // algo que ya ocurrió antes de que el agente sincronizara.
                        'status' => $fromMe ? MessageStatus::Sent : MessageStatus::Delivered,
                        'is_read' => true,
                        'sent_at' => $sentAt,
                    ]
                );
            });
        }

        foreach ($resolvedByJid as ['conversation' => $conversation]) {
            $latest = $conversation->messages()->latest('sent_at')->first();

            if ($latest) {
                $conversation->forceFill([
                    'last_message_id' => $latest->id,
                    'last_message_at' => $latest->sent_at,
                ])->save();
            }

            broadcast(new HistorySynced($conversation));
        }
    }
}
```

> No se reutiliza `PersistIncomingMessageAction` a propósito: esa Action siempre pisa `last_message_at`/`unread_count` de la conversación asumiendo que el mensaje es el más reciente — válido para mensajes en vivo, pero incorrecto para historial (que es más viejo que lo que ya tenemos). Aquí, al final del batch, se recalcula `last_message_at` desde el mensaje real más reciente en BD, evitando ese bug.

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Jobs/WhatsFleep/ProcessWhatsappHistoryBatch.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Jobs/WhatsFleep/ProcessWhatsappHistoryBatch.php
git commit -m "feat(wa): Job ProcessWhatsappHistoryBatch (persistencia idempotente + recalculo de last_message)"
```

---

## Task 7: Laravel — Controller y ruta `history-batch`

**Files:**
- Modify: `app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php`
- Modify: `routes/api.php`

- [ ] **Step 1: Añadir imports y método al controller**

Reemplaza el bloque de imports al inicio de `IncomingWhatsappController.php`:

```php
use App\Enums\WhatsFleep\MessageStatus;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsFleep\StoreIncomingWhatsappRequest;
use App\Http\Requests\WhatsFleep\StoreHistoryBatchRequest;
use App\Http\Requests\WhatsFleep\UpdateWhatsappStatusRequest;
use App\Jobs\WhatsFleep\ProcessIncomingWhatsappMessage;
use App\Jobs\WhatsFleep\ProcessWhatsappHistoryBatch;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Http\JsonResponse;
```

Añade el método, justo después de `store()`:

```php
    public function historyBatch(StoreHistoryBatchRequest $request): JsonResponse
    {
        ProcessWhatsappHistoryBatch::dispatch($request->validated());

        return response()->json(['accepted' => true], 202);
    }
```

- [ ] **Step 2: Añadir la ruta**

En `routes/api.php`, busca:
```php
        Route::post('incoming', [\App\Http\Controllers\Api\WhatsFleep\IncomingWhatsappController::class, 'store'])
            ->name('incoming');
        Route::post('status', [\App\Http\Controllers\Api\WhatsFleep\IncomingWhatsappController::class, 'status'])
            ->name('status');
```

Reemplaza por:
```php
        Route::post('incoming', [\App\Http\Controllers\Api\WhatsFleep\IncomingWhatsappController::class, 'store'])
            ->name('incoming');
        Route::post('history-batch', [\App\Http\Controllers\Api\WhatsFleep\IncomingWhatsappController::class, 'historyBatch'])
            ->name('history-batch');
        Route::post('status', [\App\Http\Controllers\Api\WhatsFleep\IncomingWhatsappController::class, 'status'])
            ->name('status');
```

- [ ] **Step 3: Verificar sintaxis y registro de la ruta**

Run: `php -l app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php && php -l routes/api.php`
Expected: dos `No syntax errors detected`

Run: `php artisan route:list --path=internal/whatsapp`
Expected: aparece `api.internal.whatsapp.history-batch`

- [ ] **Step 4: Commit**

```bash
git add app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php routes/api.php
git commit -m "feat(wa): endpoint interno POST internal/whatsapp/history-batch"
```

---

## Task 8: Laravel — `WhatsappService::syncHistory`

**Files:**
- Modify: `app/Services/WhatsFleep/WhatsappService.php`
- Modify: `app/Services/WhatsFleep/Impl/WhatsappServiceImpl.php`

- [ ] **Step 1: Añadir el método a la interface**

En `WhatsappService.php`, añade dentro de la interface (junto a `sendText`):

```php
    public function syncHistory($token, $jid, $count, array $oldestMsgKey, $oldestMsgTimestamp): object;
```

- [ ] **Step 2: Implementarlo en `WhatsappServiceImpl.php`**

Añade junto a `sendText()`:

```php
    public function syncHistory($token, $jid, $count, array $oldestMsgKey, $oldestMsgTimestamp): object
    {
        return $this->request('POST', '/api/sync-history', [
            'token'              => $token,
            'jid'                => $jid,
            'count'              => $count,
            // form_params no soporta objetos anidados con extended:false en Express;
            // se serializa como JSON, igual que 'buttons'/'sections' en otros métodos.
            'oldestMsgKey'       => json_encode($oldestMsgKey),
            'oldestMsgTimestamp' => $oldestMsgTimestamp,
        ]);
    }
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Services/WhatsFleep/WhatsappService.php && php -l app/Services/WhatsFleep/Impl/WhatsappServiceImpl.php`
Expected: dos `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Services/WhatsFleep/WhatsappService.php app/Services/WhatsFleep/Impl/WhatsappServiceImpl.php
git commit -m "feat(wa): WhatsappService::syncHistory"
```

---

## Task 9: Laravel — `SyncWhatsappHistoryAction`

**Files:**
- Create: `app/Actions/WhatsFleep/SyncWhatsappHistoryAction.php`

- [ ] **Step 1: Crear la Action**

```php
<?php

namespace App\Actions\WhatsFleep;

use App\Models\WhatsFleep\WhatsappConversation;
use App\Services\WhatsFleep\WhatsappService;

class SyncWhatsappHistoryAction
{
    public function __construct(private WhatsappService $whatsapp)
    {
    }

    /**
     * Pide a Baileys los 50 mensajes anteriores al más antiguo que ya
     * tenemos para esta conversación. No hace nada si no hay ningún
     * mensaje conocido (no hay punto de referencia desde donde pedir).
     */
    public function execute(WhatsappConversation $conversation): void
    {
        $oldest = $conversation->messages()->oldest('sent_at')->first();

        if (! $oldest || ! $oldest->wa_message_id) {
            return;
        }

        $device = $conversation->device;
        $jid = $conversation->contact->wa_jid ?: $conversation->contact->number;

        $this->whatsapp->syncHistory(
            $device->body,
            $jid,
            50,
            [
                'remoteJid' => $jid,
                'fromMe' => $oldest->sender_type->value === 'agent',
                'id' => $oldest->wa_message_id,
            ],
            $oldest->sent_at->getTimestampMs()
        );
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Actions/WhatsFleep/SyncWhatsappHistoryAction.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Actions/WhatsFleep/SyncWhatsappHistoryAction.php
git commit -m "feat(wa): SyncWhatsappHistoryAction"
```

---

## Task 10: Livewire — `ConversationView::syncHistory()`

**Files:**
- Modify: `app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php`

- [ ] **Step 1: Añadir el import**

Busca:
```php
use App\Actions\WhatsFleep\MarkConversationReadAction;
```
Cámbialo a:
```php
use App\Actions\WhatsFleep\MarkConversationReadAction;
use App\Actions\WhatsFleep\SyncWhatsappHistoryAction;
```

- [ ] **Step 2: Añadir el listener de `history.synced` (reutiliza `onNewMessage`)**

Busca:
```php
    public function getListeners(): array
    {
        return [
            "echo-private:whatsapp.conversation.{$this->uuid},.wa.message.new" => 'onNewMessage',
            'message-sent' => 'onSent',
        ];
    }
```
Reemplaza por:
```php
    public function getListeners(): array
    {
        return [
            "echo-private:whatsapp.conversation.{$this->uuid},.wa.message.new" => 'onNewMessage',
            "echo-private:whatsapp.conversation.{$this->uuid},.wa.history.synced" => 'onNewMessage',
            'message-sent' => 'onSent',
        ];
    }
```

- [ ] **Step 3: Añadir el método `syncHistory()`, junto a `loadMore()`**

Busca:
```php
    public function loadMore(): void
    {
        $this->perPage += 30;
    }
```
Reemplaza por:
```php
    public function loadMore(): void
    {
        $this->perPage += 30;
    }

    public function syncHistory(): void
    {
        $conversation = $this->conversation();
        if ($conversation) {
            app(SyncWhatsappHistoryAction::class)->execute($conversation);
        }
    }
```

- [ ] **Step 4: Verificar sintaxis**

Run: `php -l app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php`
Expected: `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php
git commit -m "feat(wa): ConversationView::syncHistory + listener history.synced"
```

---

## Task 11: Blade — botón "Sincronizar historial"

**Files:**
- Modify: `resources/views/livewire/admin/whats-fleep/inbox/conversation-view.blade.php`

- [ ] **Step 1: Añadir el botón junto a "Cargar más"**

Busca el bloque (dentro de `@if ($messages->isNotEmpty())`):
```blade
            {{-- Load more --}}
            <div class="mb-4 flex justify-center">
                <button type="button" wire:click="loadMore" wire:loading.attr="disabled" wire:target="loadMore"
                    class="inline-flex items-center gap-1.5 rounded-full bg-white/80 px-4 py-1.5 text-xs font-medium text-gray-600 shadow-sm ring-1 ring-black/5 backdrop-blur transition hover:bg-white hover:text-gray-900 disabled:opacity-60 dark:bg-gray-800/80 dark:text-gray-300 dark:ring-white/5 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                    <svg wire:loading wire:target="loadMore" class="h-3.5 w-3.5 animate-spin" fill="none"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z">
                        </path>
                    </svg>
                    <svg wire:loading.remove wire:target="loadMore" class="h-3.5 w-3.5" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75 12 8.25l7.5 7.5" />
                    </svg>
                    Cargar más
                </button>
            </div>
```

Reemplaza por (añade el segundo botón en el mismo contenedor):
```blade
            {{-- Load more --}}
            <div class="mb-4 flex justify-center gap-2">
                <button type="button" wire:click="loadMore" wire:loading.attr="disabled" wire:target="loadMore"
                    class="inline-flex items-center gap-1.5 rounded-full bg-white/80 px-4 py-1.5 text-xs font-medium text-gray-600 shadow-sm ring-1 ring-black/5 backdrop-blur transition hover:bg-white hover:text-gray-900 disabled:opacity-60 dark:bg-gray-800/80 dark:text-gray-300 dark:ring-white/5 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                    <svg wire:loading wire:target="loadMore" class="h-3.5 w-3.5 animate-spin" fill="none"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z">
                        </path>
                    </svg>
                    <svg wire:loading.remove wire:target="loadMore" class="h-3.5 w-3.5" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75 12 8.25l7.5 7.5" />
                    </svg>
                    Cargar más
                </button>
                <button type="button" wire:click="syncHistory" wire:loading.attr="disabled" wire:target="syncHistory"
                    class="inline-flex items-center gap-1.5 rounded-full bg-white/80 px-4 py-1.5 text-xs font-medium text-gray-600 shadow-sm ring-1 ring-black/5 backdrop-blur transition hover:bg-white hover:text-gray-900 disabled:opacity-60 dark:bg-gray-800/80 dark:text-gray-300 dark:ring-white/5 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                    <svg wire:loading wire:target="syncHistory" class="h-3.5 w-3.5 animate-spin" fill="none"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z">
                        </path>
                    </svg>
                    <svg wire:loading.remove wire:target="syncHistory" class="h-3.5 w-3.5" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Sincronizar historial
                </button>
            </div>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/livewire/admin/whats-fleep/inbox/conversation-view.blade.php
git commit -m "feat(wa): botón Sincronizar historial en ConversationView"
```

---

## Task 12: Verificación manual end-to-end

**Files:** _(ninguno)_

> Requiere: Node corriendo (con los cambios de las Tareas 1-3), `queue:work --queue=whatsapp` corriendo, Reverb corriendo. Reinicia los tres procesos antes de probar para asegurar que toman el código nuevo.

- [ ] **Step 1: Verificar que la cola `whatsapp` está vacía antes de empezar**

Run: `php artisan tinker --execute="echo Illuminate\Support\Facades\Redis::llen('queues:whatsapp');"`
Expected: `0`

- [ ] **Step 2: Abrir una conversación real en el Inbox que tenga al menos un mensaje**

Abre `/whatsapp?conversation={uuid}` en el navegador, con DevTools → Network → Socket abierto.

- [ ] **Step 3: Hacer clic en "Sincronizar historial"**

Expected: el botón muestra el spinner brevemente. En la consola de Node debe aparecer la petición `POST /api/sync-history` seguida, segundos después, del log `processHistoryBatch` (sin errores).

- [ ] **Step 4: Verificar que llegaron mensajes nuevos a la BD (solo lectura)**

Run: `php artisan tinker --execute="
\$c = App\Models\WhatsFleep\WhatsappConversation::where('uuid','<uuid-de-la-conversacion>')->first();
echo \$c->messages()->count();
"`
Expected: el conteo aumentó respecto a antes de sincronizar (asumiendo que había historial disponible en WhatsApp).

- [ ] **Step 5: Verificar que la UI se actualizó sin recargar la página**

Expected: los mensajes históricos (incluyendo, si los hubo, mensajes salientes del agente con burbuja a la derecha) aparecen en el chat sin necesidad de refrescar.

- [ ] **Step 6: Verificar idempotencia (repetir el sync con el mismo punto de referencia)**

No aplica un repeat directo (el punto de referencia cambia tras el primer sync, al haber un mensaje más antiguo). Confirmar en su lugar que no hay mensajes duplicados:

Run: `php artisan tinker --execute="
\$c = App\Models\WhatsFleep\WhatsappConversation::where('uuid','<uuid-de-la-conversacion>')->first();
\$total = \$c->messages()->count();
\$unicos = \$c->messages()->distinct('wa_message_id')->count('wa_message_id');
echo \$total.' / '.\$unicos;
"`
Expected: ambos números iguales (sin duplicados).

- [ ] **Step 7: Sin commit** (esta tarea no produce archivos)

---

## Self-Review (completado al escribir el plan)

- **Cobertura del spec:** Disparador por botón explícito (Task 11), alcance ambos sentidos vía `from_me` (Task 1, 6), lote de 50 (Task 9), arquitectura asíncrona vía eventos reutilizando broadcasting (Task 2, 4, 10). Manejo de errores: device no encontrado (Task 6, `Log::warning`), sin sesión activa (Task 3, `400`), sin timeout/job colgado (Task 2, listener pasivo), duplicados (Task 6, `firstOrCreate` por índice único existente). Fuera de alcance respetado: no se descarga media histórica (Task 1, payload sin `media_path`).
- **Placeholders:** ninguno; todo el código está completo.
- **Consistencia de tipos:** `ResolveWhatsappContactAction::execute()` se llama con la misma firma de 4 argumentos posicionales ya usada en `ProcessIncomingWhatsappMessage` (Task 6 reutiliza el patrón exacto). `WhatsappService::syncHistory()` firma coincide entre interface (Task 8 Step 1) e implementación (Task 8 Step 2). El evento `wa.history.synced` (Task 4 `broadcastAs()`, renombrado de `history.synced` para seguir la convención `wa.*` de los eventos existentes) coincide exactamente con el string usado en el listener de Livewire (Task 10, con el punto inicial `.wa.history.synced` requerido por el `EventFormatter` de Laravel Echo — mismo bug ya corregido esta sesión para `wa.message.new`/`wa.conversation.updated`).
