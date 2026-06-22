# Spec — WhatsApp Omnicanal · Subsistema #2: Inbox en tiempo real (UI + Reverb)

- **Fecha:** 2026-06-15
- **Estado:** Aprobado para escribir plan de implementación
- **Depende de:** SP#1 (núcleo + persistencia) — modelos, eventos, ingesta ya existen.
- **Alcance:** Solo SP#2. Ver §12 para los límites.

---

## 1. Contexto

SP#1 dejó el backend de persistencia y **emite** los eventos `NewWhatsappMessage`
(canal `whatsapp.conversation.{uuid}`) y `ConversationUpdated` (canal `whatsapp.empresa.{empresaId}`),
pero **nada los consume** y el broadcaster efectivo es `null`. SP#2 construye la **interfaz de
atención**: un inbox multiagente en vivo (estilo WhatsApp Web) y **cablea Reverb** para que los
eventos lleguen al navegador.

### Estado real del proyecto (verificado)

- **Reverb NO está instalado** (`laravel/reverb` ausente en composer). `config/broadcasting.php` no
  tiene conexión `reverb` y lee `BROADCAST_DRIVER` (estructura Laravel 10), que no existe en `.env`
  → broadcaster efectivo `null`. El front (`bootstrap.js`) usa Echo con protocolo `pusher` y
  `VITE_PUSHER_*`. Las `REVERB_*`/`VITE_REVERB_*` del `.env` existen pero nada las usa.
- **Multi-tenancy:** no hay `users.empresa_id`. La empresa vive en `session('empresa')`
  (`HomeController` la fija en `1`; opera como single-empresa). `EmpresaScope` lee `session('empresa')`.
- **Ruteo:** un grupo `Route::middleware(['auth:sanctum','verified'])` **sin** prefijo de URL
  `admin/`. Los nombres nuevos **no** usan `admin.` (ej. `finanzas.`, `api.*`). Controladores sí
  bajo `App\Http\Controllers\Admin\...`.
- **Patrón de página Livewire:** controlador → vista Blade → componente Livewire embebido.
- **Echo ya se usa** en `layouts/admin.blade.php` (`Echo.private('App.Models.User.'+id)`).
- **Plantillas existentes:** `postventa_plantillas` (CRUD en `Livewire/Admin/Ajustes/...`) — no se
  reutilizan (decisión D5).

---

## 2. Decisiones de diseño (acordadas)

| # | Decisión | Elección |
|---|----------|----------|
| D1 | **Motor de tiempo real** | Instalar **Laravel Reverb** (self-hosted, sin costo por mensaje). Cablear `BROADCAST_DRIVER=reverb`, conexión `reverb`, Echo→Reverb, `reverb:start` por supervisord. |
| D2 | **Envío del composer** | **Texto + adjuntos (imagen/doc/audio) + quick replies.** |
| D3 | **Asignación** | SP#2 incluye **tomar/reasignar/cerrar** (escribe `whatsapp_assignments`). Sin filtrado por rol (SP#3). |
| D4 | **Lectura** | Solo **interno** (`is_read=true`, `unread_count=0`). NO se envía "visto" (doble check) al cliente. |
| D5 | **Quick replies** | Entidad nueva **`WhatsappQuickReply`** (CRUD en **Ajustes**); el picker se usa en el composer. |
| D6 | **Ruteo** | Sin `admin.` en nombres. Inbox URL `whatsapp`, nombres `whatsapp.*`. Controladores siguen bajo `App\Http\Controllers\Admin\WhatsFleep\`. |
| D7 | **Autorización de canal** | Por `session('empresa')` (básica). El rol fino lo añade SP#3 en los mismos callbacks. |

---

## 3. Tiempo real (Reverb) y autorización de canales

### 3.1 Instalación y configuración

- `composer require laravel/reverb` + `php artisan reverb:install` (publica `config/reverb.php`,
  añade la conexión `reverb` a `config/broadcasting.php`, registra el `BroadcastServiceProvider` y
  descomenta `routes/channels.php`).
- **Driver:** fijar `BROADCAST_DRIVER=reverb` en `.env` (el config lee `BROADCAST_DRIVER`). Mantener
  `BROADCAST_CONNECTION=reverb` por compatibilidad. Verificar que `config/broadcasting.php` tras el
  install resuelve la conexión `reverb` (si sigue leyendo `BROADCAST_DRIVER`, queda alineado).
- **Front-end (`resources/js/bootstrap.js`):** reemplazar la config Echo de Pusher por Reverb:
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
  Mantener el `Echo.private('App.Models.User...')` existente del layout. `npm run build`.
- **Operación:** `php artisan reverb:start` bajo **supervisord** en prod (junto al worker `whatsapp`).

### 3.2 Canales y autorización (`routes/channels.php`)

```php
Broadcast::channel('whatsapp.empresa.{empresaId}', function ($user, $empresaId) {
    return (int) session('empresa', 1) === (int) $empresaId;     // SP#3 endurece por rol
});

Broadcast::channel('whatsapp.conversation.{uuid}', function ($user, $uuid) {
    $conv = \App\Models\WhatsFleep\WhatsappConversation::where('uuid', $uuid)->first();
    return $conv !== null && (int) $conv->empresa_id === (int) session('empresa', 1);
});
```

> La auth de broadcasting corre por middleware web (sesión disponible), por eso `session('empresa')`
> es válido aquí. **SP#3** añadirá la comprobación de rol/asignación dentro de estos callbacks.

### 3.3 Eventos consumidos (ya emitidos por SP#1)

- `whatsapp.conversation.{uuid}` → `wa.message.new` (`NewWhatsappMessage`): append en la vista abierta.
- `whatsapp.empresa.{empresaId}` → `wa.conversation.updated` (`ConversationUpdated`): refresco de la lista.

---

## 4. Arquitectura de componentes Livewire

Patrón: **controlador → vista → componentes Livewire** dentro del grupo `auth:sanctum,verified`.
Componentes pequeños y enfocados, comunicados por **eventos Livewire** (no estado enredado).

- **Ruta:** `Route::get('whatsapp', [InboxController::class, 'index'])->name('whatsapp.inbox')->middleware('can:ver-whatsapp')`.
  El controlador retorna `view('admin.whatsapp.inbox')` que monta los componentes.
- **`WhatsappInbox`** (`app/Livewire/Admin/WhatsFleep/Inbox/Index.php`) — contenedor; mantiene
  `selectedConversationUuid`; layout de 3 paneles; responsive (colapsa en móvil).
- **`ConversationList`** — sidebar izquierdo; lista + filtros + búsqueda; escucha `whatsapp.empresa.{id}`.
- **`ConversationHeader`** — cabecera central; contacto/estado/acciones (asignar/reasignar/cerrar/prioridad).
- **`ConversationView`** — historial + scroll infinito; escucha `whatsapp.conversation.{uuid}`; marca leído.
- **`MessageComposer`** — texto + adjuntos + quick replies.
- **`ContactPanel`** — panel derecho mínimo (contacto + cliente básico + otras conversaciones).

**Eventos entre componentes (Livewire `dispatch`):**
- `conversation-selected` (uuid) — emitido por `ConversationList`, escuchado por `ConversationView`,
  `ConversationHeader`, `ContactPanel`, `MessageComposer`.
- `conversation-updated` — tras asignar/cerrar/leer; refresca `ConversationList` y `ConversationHeader`.
- `message-sent` — `MessageComposer` → `ConversationView` (append optimista).

**Vistas Blade:** `resources/views/livewire/admin/whats-fleep/inbox/*.blade.php` y la vista
contenedora `resources/views/admin/whatsapp/inbox.blade.php`.

---

## 5. `ConversationList` (sidebar)

- **Query:** `WhatsappConversation::forTenant(session('empresa'))` con eager-load `contact`,
  `cliente`, `lastMessage`, `assignedUser`; orden `last_message_at desc`; paginación incremental
  ("cargar más" / scroll). Evita N+1 con `with([...])`.
- **Filtros:** estado `Abiertas|Pendientes|Cerradas` (`#[Url]`); asignación `Mías|Sin asignar|Todas`
  (`#[Url]`). **Búsqueda** (`#[Url]`, `wire:model.live.debounce`) por `contact.name`/`contact.number`/
  `cliente.razon_social`/nombre.
- **Ítem:** avatar inicial, nombre (cliente o contacto), preview `lastMessage.body` (o tipo si media),
  hora relativa, **badge `unread_count`**, chip de `assignedUser`, chip de `priority` si ≠ normal.
- **Tiempo real:** `#[On('echo-private:whatsapp.empresa.{empresaId},wa.conversation.updated')]` (o
  re-render por `$refresh`) → reordena, actualiza preview/unread sin recargar.
- **Selección:** click → `$dispatch('conversation-selected', uuid: $uuid)`.

---

## 6. `ConversationView` (centro)

- **Carga:** últimos 30 mensajes de la conversación, eager-load `senderUser`; **scroll infinito hacia
  arriba** (cursor por `id`/`created_at`).
- **Burbujas (WhatsApp Web):** `sender_type=contact` izquierda; `agent`/`system` derecha; hora; en
  salientes, **ticks de estado** (pending→spinner, sent/delivered/read/failed). Separadores por fecha.
- **Media:** imagen/audio/video/documento se renderizan vía la ruta privada autenticada
  **`whatsapp.media`** (`mediaUrl()` de SP#1). Nunca URL pública.
- **Tiempo real:** `#[On('echo-private:whatsapp.conversation.{uuid},wa.message.new')]` → append +
  autoscroll si el usuario está al fondo; si no, badge "nuevos mensajes ↓".
- **Marcar leído:** al seleccionar/abrir, `MarkConversationReadAction` pone `is_read=true` en los
  mensajes entrantes no leídos y `unread_count=0`; emite `ConversationUpdated` para limpiar el badge
  en otros agentes. **Sin** llamada al Node (D4).

---

## 7. `MessageComposer` + backend de salida

- **Texto:** reusa `SendWhatsappMessageAction` (SP#1). Enter envía; Shift+Enter salto de línea.
- **Adjuntos (Livewire `WithFileUploads`):**
  - Subida validada (mimetypes/size) → almacena en disco **privado** `local`:
    `storage/app/whatsapp/outgoing/{empresa}/{uuid}.{ext}`.
  - Nueva **`SendWhatsappMediaAction`** (`App\Actions\WhatsFleep\`): persiste `WhatsappMessage`
    (`sender_type=Agent`, `type` image/document/audio, `media_path`, `mime_type`, `file_name`,
    `file_size`, `status=Pending`) y delega al `WhatsappService->sendMedia($device->body, $number,
    $type, $rutaAbsolutaLocal, $caption, $fileName)`. Como Node y Laravel comparten disco, se pasa la
    **ruta local absoluta** (Baileys la lee con `{ url: ruta }`; sin exponer URL pública). Guarda el
    `wa_message_id` devuelto; `status=Sent`. Fallo → `status=Failed`.
  - **Verificación en implementación:** confirmar que el endpoint Node `/api/send-*` (vía
    `WhatsappService::sendMedia`) acepta una ruta de archivo local; si exige URL, pasar la ruta
    absoluta del disco compartido (Baileys soporta path local en `{ url }`).
- **Quick replies:** picker que al escribir `/` filtra `WhatsappQuickReply` activos por `shortcut`/
  `title` e inserta el `body` en el textarea.
- **Optimista:** el mensaje propio aparece al instante (`status=pending`) y se actualiza con el ack
  (vía `wa.message.new`/`wa.conversation.updated` o re-render).

---

## 8. `ConversationHeader`, asignación y `ContactPanel`

**`ConversationHeader`:**
- Muestra contacto/cliente, `status`, `priority`.
- Acciones (Actions dedicadas, escriben auditoría):
  - **Asignarme** → `AssignConversationAction`: set `assigned_user_id = auth()->id()` + fila en
    `whatsapp_assignments` (`from`=anterior, `to`=auth, `assigned_by`=auth).
  - **Reasignar** → selector de usuario → misma Action con `to` elegido.
  - **Cerrar/Reabrir** → `ChangeConversationStatusAction`: `status` + `closed_at`.
  - **Prioridad** → set `priority`.
- Cada acción emite `ConversationUpdated`. Sin filtrado por rol (SP#3).

**`ContactPanel` (mínimo SP#2):**
- Contacto (número, push_name) + cliente vinculado básico (razón social/nombre, documento, teléfono),
  **solo lectura**.
- **Otras conversaciones** del mismo `contact` (link para cambiar de conversación).
- Contenedor preparado para el panel rico (vehículos/GPS/tickets) que llega en **SP#4**.

---

## 9. Modelo de datos nuevo, permiso y limpieza de SP#1

**`whatsapp_quick_replies`** (migración + modelo `App\Models\WhatsFleep\WhatsappQuickReply`):
- `id`, `empresa_id`, `shortcut` (string, ej. `saludo`), `title` (string), `body` (text),
  `active` (bool, default true), timestamps. Índice `(empresa_id, active)`, único `(empresa_id, shortcut)`.
- Cast `active` boolean. CRUD Livewire en **`app/Livewire/Admin/Ajustes/WhatsApp/QuickReplies/`**
  (Index/Save/Delete), ruta y vista en Ajustes, protegida con **`can:ver-whatsapp`** (mismo permiso
  del inbox; no se crea uno nuevo para gestionarlas).

**Permiso Spatie `ver-whatsapp`** (+ seeder, asignado a Admin) para la ruta `whatsapp.inbox`.

**Limpieza de SP#1 (consistencia de nombres):** renombrar la ruta de media
`admin.whatsapp.media` → **`whatsapp.media`** en `routes/web.php` y el `route('admin.whatsapp.media', …)`
de `WhatsappMessage::mediaUrl()`. Es seguro: SP#1 aún no está mergeado.

**Sin más tablas:** todo lo demás se apoya en las de SP#1 (`whatsapp_conversations/messages/
assignments`, `contacts`).

---

## 10. Dirección estética (frontend-design + tipo WhatsApp)

- **Lenguaje:** WhatsApp Web profesional — 3 paneles, densidad cómoda, burbujas con cola,
  separadores de fecha, scroll suave. Refinado/utilitario, no maximalista.
- **Integración:** respeta el tema de `layouts/admin.blade.php` (paleta, tipografía, **dark mode**
  ya soportado). Acentos verdes sutiles tipo WhatsApp para lo propio (burbuja saliente, badge unread),
  sin romper la identidad admin.
- **Microinteracciones:** `wire:loading` en acciones, estado de envío (spinner→tick), aparición de
  mensajes nuevos con transición sutil, autoscroll, skeleton al cargar histórico.
- **Tailwind v4** (activar `tailwindcss-development` al implementar) + Alpine donde haga falta
  interacción cliente (autoscroll, picker de `/`, autosize del textarea).
- **Responsive:** móvil colapsa paneles (lista ↔ conversación ↔ panel) tipo app.
- Se aplica la skill **frontend-design** del proyecto (`.agents/skills/frontend-design/SKILL.md`)
  para calidad de UI.

---

## 11. Estrategia de validación (sin `php artisan test`)

> Restricción del proyecto: el suite usa la BD real con `RefreshDatabase`. **No** ejecutar
> `php artisan test`.

- `php -l` en cada PHP nuevo/editado; `node --check` si se toca Node.
- `npm run build` para verificar que Vite compila (Echo/Reverb, assets del inbox).
- `php artisan route:list` para confirmar `whatsapp.inbox`, `whatsapp.media`, canales.
- **Smoke en vivo** (a cargo del usuario): `reverb:start` + worker `whatsapp` + servidor Node, abrir
  el inbox y ver llegar un mensaje en tiempo real. No se automatiza aquí.

---

## 12. Fuera de alcance de SP#2

| Tema | Subsistema |
|------|-----------|
| Visibilidad/filtrado **por rol** (Agente/Supervisor/Gerente), quién puede reasignar, auditoría de tiempos | SP#3 |
| Panel rico de **vehículos/GPS** (última ubicación, bloqueo motor) y **tickets** (vincular/crear/convertir) | SP#4 |
| Reglas automáticas (robo→emergency), escalamiento 5/10 min, tags automáticos | SP#5 |
| Grupos de WhatsApp | Fuera |

En SP#2 la autorización es por empresa (no por rol) y la asignación no tiene restricciones de rol.

---

## 13. Inventario de archivos (crear / editar)

**Infra tiempo real:**
- `composer require laravel/reverb` + `php artisan reverb:install` (genera `config/reverb.php`, edita
  `config/broadcasting.php`).
- Editar: `.env` / `.env.example` (`BROADCAST_DRIVER=reverb`), `resources/js/bootstrap.js` (Echo→Reverb),
  `routes/channels.php` (2 canales).

**Backend:**
- Crear: `app/Actions/WhatsFleep/SendWhatsappMediaAction.php`, `MarkConversationReadAction.php`,
  `AssignConversationAction.php`, `ChangeConversationStatusAction.php`.
- Crear: migración `*_create_whatsapp_quick_replies_table.php`, modelo `WhatsappQuickReply.php`.
- Crear: `database/seeders/WhatsappPermissionsSeeder.php` (permiso `ver-whatsapp`).
- Editar: `routes/web.php` (ruta inbox + quick replies + rename media), `WhatsappMessage::mediaUrl()`
  (rename ruta).
- Crear: `app/Http/Controllers/Admin/WhatsFleep/InboxController.php`.

**Livewire + vistas:**
- Crear: `app/Livewire/Admin/WhatsFleep/Inbox/{Index,ConversationList,ConversationHeader,ConversationView,MessageComposer,ContactPanel}.php`
  y sus Blade en `resources/views/livewire/admin/whats-fleep/inbox/`.
- Crear: vista contenedora `resources/views/admin/whatsapp/inbox.blade.php`.
- Crear: `app/Livewire/Admin/Ajustes/WhatsApp/QuickReplies/{Index,Save,Delete}.php` + Blade.

**Front:** `npm run build` tras editar `bootstrap.js`.

---

## 14. Criterios de aceptación de SP#2

1. Con Reverb corriendo, un mensaje entrante (vía el pipeline de SP#1) **aparece en vivo** en la lista
   (preview + unread) y, si la conversación está abierta, se **agrega** a la vista sin recargar.
2. El agente envía **texto** y se ve optimista; el estado evoluciona con los acks.
3. El agente envía un **adjunto** (imagen/doc/audio); se guarda en disco privado, sale por Node y se
   persiste como mensaje saliente.
4. **Quick replies:** escribir `/atajo` filtra e inserta el cuerpo; el CRUD vive en Ajustes.
5. **Asignación:** tomar/reasignar/cerrar funciona y queda registrado en `whatsapp_assignments`;
   la lista se actualiza en vivo para otros agentes.
6. Abrir una conversación **limpia el unread** (interno) sin enviar "visto" al cliente.
7. Filtros (estado/asignación) y búsqueda funcionan y son enlazables (`#[Url]`).
8. La media entrante/saliente solo se sirve por la ruta autenticada (sin acceso anónimo).
9. La UI es estilo WhatsApp profesional, responsive y con dark mode; `npm run build` compila.
10. Ruteo sin `admin.`: `whatsapp.inbox` y `whatsapp.media` registrados; todos los PHP pasan `php -l`.
