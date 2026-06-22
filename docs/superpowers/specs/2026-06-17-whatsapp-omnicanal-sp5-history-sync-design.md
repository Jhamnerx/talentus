# WhatsApp Omnicanal · SP#5 Sincronización de Historial — Design Spec

## Contexto

El módulo de Inbox omnicanal (SP#1-SP#4) solo captura mensajes a partir del momento en que el bot empezó a escuchar cada conversación. El botón "Cargar más" existente en `ConversationView` solo pagina sobre `whatsapp_messages` (la BD de Laravel) — nunca toca WhatsApp directamente. Para conversaciones que existían antes de la integración, o donde faltan mensajes antiguos, no hay forma de traerlos.

Baileys expone un mecanismo de "On-Demand History Sync": `sock.fetchMessageHistory(count, oldestMsgKey, oldestMsgTimestamp)` solicita mensajes anteriores a un punto de referencia conocido; la respuesta llega de forma asíncrona por el evento `sock.ev.on('messaging-history.set', ...)` con `syncType === proto.HistorySync.HistorySyncType.ON_DEMAND` (valor `6`), distinguible de la sincronización automática que Baileys hace al conectar.

Esta sesión también detectó una causa de latencia separada (ver Cambio adicional más abajo) que se corrige junto con este SP por ser de bajo riesgo y alto impacto.

## Decisiones (confirmadas con el usuario)

- **Disparador**: botón explícito "Sincronizar historial" en la conversación — no automático, no parte del flujo de "Cargar más".
- **Alcance**: trae mensajes en ambos sentidos (recibidos y enviados desde el dispositivo), no solo los del contacto.
- **Tamaño de lote**: 50 mensajes por click. El botón se puede volver a presionar para seguir trayendo más del pasado.
- **Arquitectura**: asíncrona vía eventos, reutilizando el broadcasting existente — no bloquea la UI esperando una respuesta HTTP larga.

## Arquitectura y flujo de datos

```
[ConversationView] --click--> SyncWhatsappHistoryAction
        |
        | (1) busca el WhatsappMessage más antiguo de la conversación
        | (2) POST /api/sync-history a Node {token, jid, count:50, oldestMsgKey, oldestMsgTimestamp}
        v
   [Node: router]  --202 rápido--> (Laravel no espera más en este ciclo)
        |
        | sock.fetchMessageHistory(...) dispara la solicitud a WhatsApp
        v
   [Node: listener global 'messaging-history.set']
        | cuando syncType === ON_DEMAND:
        | parsea cada mensaje del batch (incluye fromMe true/false)
        | POST /api/internal/whatsapp/history-batch a Laravel (bulk, un solo POST)
        v
   [Laravel: HistoryBatchController] --dispatch--> ProcessWhatsappHistoryBatch (queue: whatsapp)
        |
        | por cada mensaje: resuelve conversación por wa_jid, firstOrCreate
        | por (device_id, wa_message_id) [reutiliza índice único existente]
        | sender_type = fromMe ? 'agent' : 'contact'
        | al final: UN broadcast HistorySynced (ShouldBroadcastNow) por conversación afectada
        v
   [ConversationView] escucha "echo-private:whatsapp.conversation.{uuid},.history.synced" => refresh
```

No hay correlación explícita entre la petición y la respuesta: cada mensaje del batch trae su propio `key.remoteJid`, así que Node simplemente reenvía lo que reciba del evento, sin necesitar rastrear "qué botón lo disparó". Si dos conversaciones sincronizan a la vez, cada batch se procesa por su propio JID sin cruces.

## Componentes a crear/modificar

**Node**
- `server/whatsapp.js`: registrar listener global `sock.ev.on('messaging-history.set', handler)` junto a los demás listeners del socket (cerca de `messages.update`). El handler filtra `syncType === proto.HistorySync.HistorySyncType.ON_DEMAND`, descarta mensajes de grupo, parsea cada mensaje (cuerpo, tipo, media) reutilizando los helpers ya existentes en `lib/helper.js`/`controllers/incomingMessage.js`, y hace **un solo** `axios.post` a Laravel con el array completo.
- `server/router/index.js`: nuevo `POST /api/sync-history` (con `checkIpWhitelist`, igual que `/api/send-message`). Valida `token`, `jid`, `count`, `oldestMsgKey`, `oldestMsgTimestamp`; verifica `wa.isConnected(token)`; llama a `sock.fetchMessageHistory(...)`; responde `202` de inmediato (no espera el evento).
- `server/whatsapp.js`: exportar una función `fetchMessageHistory(token, jid, count, oldestMsgKey, oldestMsgTimestamp)` que el router usa internamente (mismo patrón que `sendText`/`isConnected`).

**Laravel**
- `routes/api.php`: `POST internal/whatsapp/history-batch` dentro del grupo `whatsapp.internal` ya existente.
- `app/Http/Requests/WhatsFleep/StoreHistoryBatchRequest.php`: valida `device`, y `messages` como array de objetos (`wa_message_id`, `from_me`, `wa_jid`, `type`, `body`, `timestamp`, campos de media opcionales).
- `app/Http/Controllers/Api/WhatsFleep/IncomingWhatsappController.php`: nuevo método `historyBatch()` que despacha el Job y responde `202`.
- `app/Jobs/WhatsFleep/ProcessWhatsappHistoryBatch.php`: cola `whatsapp`. Agrupa mensajes por `wa_jid`, resuelve conversación (reutiliza `ResolveWhatsappContactAction`/`ResolveConversationAction` ya existentes), persiste cada mensaje con `firstOrCreate(['device_id', 'wa_message_id'])` y `sender_type` según `from_me`, y al terminar emite **un** `HistorySynced` por conversación tocada (no uno por mensaje).
- `app/Events/WhatsFleep/HistorySynced.php`: nuevo evento, `implements ShouldBroadcastNow` (no `ShouldBroadcast`, ver razón abajo), canal `whatsapp.conversation.{uuid}`, `broadcastAs() = 'history.synced'`.
- `app/Actions/WhatsFleep/SyncWhatsappHistoryAction.php`: busca el mensaje más antiguo de la conversación, arma `oldestMsgKey`/`oldestMsgTimestamp`, llama a `WhatsappService` (nuevo método `syncHistory`).
- `app/Services/WhatsFleep/WhatsappService.php` + `Impl/WhatsappServiceImpl.php`: nuevo método `syncHistory($token, $jid, $count, $oldestMsgKey, $oldestMsgTimestamp)` → `POST /api/sync-history`.

**Livewire / Blade**
- `app/Livewire/Admin/WhatsFleep/Inbox/ConversationView.php`: método `syncHistory()` (llama a la Action; deshabilitado si no hay ningún mensaje conocido, ya que no hay punto de referencia); agregar `"echo-private:whatsapp.conversation.{$this->uuid},.history.synced" => '$refresh'` a `getListeners()`.
- `resources/views/livewire/admin/whats-fleep/inbox/conversation-view.blade.php`: botón "Sincronizar historial" junto a "Cargar más", con estado `wire:loading`/`wire:target="syncHistory"`.

## Manejo de errores

- Node sin sesión activa → `400 {status:false}`, igual que `/api/send-message`; la Action no lanza, solo no hace nada visible (no hay mensaje que sincronizar).
- El evento `messaging-history.set` on-demand nunca llega → no hay timeout ni job colgado (Node no bloquea esperando); el agente puede volver a presionar el botón.
- Mensajes duplicados (solape con lo ya conocido) → el índice único `(device_id, wa_message_id)` ya existente los ignora vía `firstOrCreate`.
- Mensaje del batch que no resuelve a ninguna conversación/dispositivo conocido → se descarta con `Log::warning`, igual que el patrón actual de `device not found`.

## Cambio adicional (latencia en tiempo real, ya aplicado en esta sesión)

`NewWhatsappMessage` y `ConversationUpdated` pasaron de `ShouldBroadcast` a `ShouldBroadcastNow`. Antes, cada `broadcast()` encolaba un Job `BroadcastEvent` aparte en la cola `default`, que debía esperar turno de un segundo worker — dos saltos de cola en serie por cada mensaje. Con `ShouldBroadcastNow` el broadcast ocurre inline dentro del mismo Job que ya procesa el mensaje. Por consistencia, `HistorySynced` (este SP) se crea directamente como `ShouldBroadcastNow`.) Este cambio requiere reiniciar los procesos `queue:work` para tomar efecto.

## Testing

Sin `php artisan test` (restricción del proyecto, ver `CLAUDE.md`/memoria). Verificación por archivo: `php -l` en cada archivo PHP nuevo/modificado, `node --check` en los archivos de Node.

## Fuera de alcance

- Sincronización automática al abrir conversación (se descartó a favor del botón explícito).
- Sincronización completa de TODOS los chats al conectar un dispositivo (eso es la sync inicial automática de Baileys, no la on-demand; no se toca en este SP).
- UI para mostrar progreso/porcentaje de la sincronización — solo loading state simple del botón.
- Descarga de archivos multimedia (fotos, audio, video, documentos) para mensajes históricos: se persiste el tipo y el caption/body, pero no el archivo. Descargar media en lote de 50 mensajes a la vez introduce complejidad de rate-limiting y volumen que no está en el alcance de este SP; puede agregarse después reutilizando `storeIncomingMedia` mensaje por mensaje si se decide necesario.
