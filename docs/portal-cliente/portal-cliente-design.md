# Portal de Cliente (Intranet) — Diseño técnico

> Estado: **diseño aprobado**, pendiente de implementación.
> Fecha: 2026-06-14
> Backend: este proyecto Laravel 12 (expone API REST).
> Frontend: proyecto **Next.js separado** desplegado en otro subdominio del mismo VPS.

---

## 1. Objetivo

Construir un **portal de cliente** donde cada cliente de Talentus pueda autenticarse y consultar/gestionar su información: vehículos, actas, certificados (GPS, velocímetro, antifatiga), comprobantes, recibos, presupuestos, contratos, órdenes de trabajo y tickets; administrar los contactos de su empresa y editar su perfil.

El portal es un **proyecto independiente en Next.js** que consume una **API REST** nueva expuesta por este sistema Laravel mediante **tokens Sanctum**.

---

## 2. Arquitectura general

```
┌─────────────────────────────────────────────┐
│  clientes.tudominio.com                      │
│  Next.js (App Router)  ──  next start -p 3001│
│  PM2 / systemd                               │
└───────────────┬─────────────────────────────┘
                │  httpd (Apache) reverse proxy + SSL (AlmaLinux)
                │  fetch  Authorization: Bearer <sanctum-token>
                ▼
┌─────────────────────────────────────────────┐
│  tudominio.com/api/portal/*  (este Laravel)  │
│  Sanctum personal access tokens              │
│  Guard cliente_users · EmpresaScope inyectado│
└─────────────────────────────────────────────┘
```

### Decisiones de arquitectura

| Tema | Decisión | Motivo |
|------|----------|--------|
| Frontend | **Next.js** (proyecto aparte, puerto propio, proxy httpd) | El cliente lo pidió; framework JS desacoplado, SSR/SEO, despliegue independiente. |
| Transporte de auth | **Sanctum Personal Access Tokens** (Bearer) | Cross-domain (subdominio distinto); no se usa Sanctum SPA-cookie porque no es same-site. |
| Almacenamiento del token en Next | **Cookie httpOnly** gestionada por Route Handlers (patrón BFF) | Evita exponer el token a JS del navegador (anti-XSS). |
| Identidad autenticable | Tabla nueva **`cliente_users`** (cuenta por persona) | Un RUC puede tener varias personas; no contamina `Clientes` con credenciales. |
| Entrega de PDFs | **URL temporal firmada** + visor | No infla JSON, permite caché y streaming bajo demanda. |
| Multi-empresa | Middleware que inyecta `empresa_id` desde el cliente autenticado | `EmpresaScope` hoy depende de `session('empresa')`; la API es stateless. |

---

## 3. Modelo de datos

### 3.1 Tabla nueva: `cliente_users`

Entidad autenticable. **No** se modifica el modelo `Clientes`.

| Columna | Tipo | Notas |
|---------|------|-------|
| `id` | bigint PK | |
| `cliente_id` | FK → `clientes.id` | empresa/RUC a la que pertenece |
| `name` | string | nombre de la persona |
| `email` | string **unique** | login |
| `email_verified_at` | timestamp null | verificación de correo |
| `password` | string | hash bcrypt |
| `rol` | enum `titular`/`colaborador` | el titular es quien registró el RUC |
| `estado` | enum `pendiente`/`aprobado`/`rechazado`/`suspendido` | controla acceso operativo |
| `telefono` | string null | |
| `last_login_at` | timestamp null | |
| `remember_token` | string null | |
| `timestamps` | | |

Índices: `unique(email)`, `index(cliente_id)`, `index(estado)`.

### 3.2 Tabla de reset de contraseñas: `cliente_password_resets`

Broker de password propio para el guard `cliente` (igual estructura que `password_resets`: `email`, `token`, `created_at`).

### 3.3 Modelo `ClienteUser`

```php
class ClienteUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // fillable: cliente_id, name, email, password, rol, estado, telefono
    // hidden: password, remember_token
    // casts: email_verified_at => datetime, password => hashed, last_login_at => datetime

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function estaAprobado(): bool
    {
        return $this->estado === 'aprobado' && $this->email_verified_at !== null;
    }
}
```

### 3.4 Relaciones reutilizadas (ya existen)

Todo se consulta a partir de `ClienteUser->cliente`:

| Recurso del portal | Origen | Relación / FK |
|--------------------|--------|---------------|
| Vehículos | `Clientes::vehiculos()` | `vehiculos.clientes_id` |
| Actas | `Vehiculos::actas()` | `actas.vehiculos_id` |
| Certificados GPS | `Vehiculos::certificados()` | `certificados.vehiculos_id` |
| Cert. Velocímetro | `Vehiculos::cert_velocimetros()` | `certificados_velocimetros.vehiculos_id` |
| Cert. Antifatiga | `CertificadosAntifatiga` | por `vehiculos_id` |
| Comprobantes | `Clientes::ventas()` → `Comprobantes` | `ventas.cliente_id` |
| Recibos | `Clientes::recibos()` | `recibos.clientes_id` |
| Presupuestos | `Clientes::presupuestos()` | `presupuestos.clientes_id` |
| Contratos | `Clientes::contratos()` | `contratos.clientes_id` |
| Órdenes de trabajo | `WorkOrder::cliente()` | `work_orders.cliente_id` |
| Tickets | `Ticket::customer()` | `tickets.customer_id` |
| Contactos | `Clientes::contactos()` | `contactos.clientes_id` |
| Cobros | `Clientes::cobros()` / `Vehiculos::cobros()` | `cobros.clientes_id` / `cobros.vehiculos_id` |

---

## 4. Autenticación y autorización

### 4.1 Guard y provider (`config/auth.php`)

```php
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'users'],
    'cliente' => ['driver' => 'session', 'provider' => 'cliente_users'], // para reset broker
],

'providers' => [
    'users' => ['driver' => 'eloquent', 'model' => App\Models\User::class],
    'cliente_users' => ['driver' => 'eloquent', 'model' => App\Models\ClienteUser::class],
],

'passwords' => [
    'users' => ['provider' => 'users', 'table' => 'password_resets', 'expire' => 60, 'throttle' => 60],
    'cliente_users' => ['provider' => 'cliente_users', 'table' => 'cliente_password_resets', 'expire' => 60, 'throttle' => 60],
],
```

> La API usa `auth:sanctum`; el token resuelve a `ClienteUser` por su `tokenable_type`. El guard `cliente` (session) solo se usa internamente para el password broker.

### 4.2 Restricción de tokens del portal

Los tokens del portal se emiten con la **ability** `portal`:

```php
$clienteUser->createToken($deviceName, ['portal'])->plainTextToken;
```

Middleware en el grupo de rutas: `auth:sanctum` + `abilities:portal`. Esto impide que un token de técnico (app móvil) acceda a endpoints del portal y viceversa.

### 4.3 Middleware `portal.empresa` (contexto multi-empresa)

`EmpresaScope` lee `session('empresa')`. Como la API es stateless, un middleware resuelve la empresa del cliente autenticado y la inyecta antes de los controladores:

```php
class SetPortalEmpresa
{
    public function handle(Request $request, Closure $next): Response
    {
        $clienteUser = $request->user();
        $empresaId = $clienteUser->cliente->empresa_id;

        session(['empresa' => $empresaId]); // satisface EmpresaScope
        config(['portal.empresa_id' => $empresaId]);

        return $next($request);
    }
}
```

> **Regla de oro de aislamiento:** además del scope de empresa, **toda** consulta del portal filtra explícitamente por `cliente_id = $request->user()->cliente_id`. Un cliente jamás debe ver datos de otro, ni siquiera de la misma empresa.

### 4.4 Estados de la cuenta

```
registro ──► email_verified_at = null  (esperando verificación de correo)
         ──► verifica correo ──► estado = pendiente  (esperando aprobación admin)
         ──► admin aprueba   ──► estado = aprobado    (acceso completo)
         ──► admin rechaza   ──► estado = rechazado   (login bloqueado, mensaje)
         ──► admin suspende  ──► estado = suspendido  (login bloqueado)
```

El login solo procede si `email_verified_at != null` **y** `estado = aprobado`.

---

## 5. Flujos de cuenta

### 5.1 Registro (`POST /api/portal/auth/register`)

**Request:** `{ ruc, email, password, password_confirmation, name }`

Validación: `ruc` numérico 11 dígitos, `email` válido, `password` confirmado y fuerte.

**Decisión:** el portal es **solo para clientes que ya existen** en el ERP. Si el RUC no existe, el registro se rechaza (no se crean clientes desde el portal; eso evita el problema de "¿a qué empresa pertenece?").

**Lógica (FormRequest + acción):**

```
1. Buscar Cliente por numero_documento = ruc (sin EmpresaScope, is_active = true).
2. CASO A — RUC NO existe en el sistema:
     - Rechazar (404): "No encontramos ese RUC como cliente. Contáctanos para
       habilitar tu acceso."
3. CASO B — RUC existe SIN correo asociado (clientes.email = null):
     - Permitir registro: crear ClienteUser ligado a ese Cliente
       (primer usuario = titular; siguientes = colaborador).
     - estado = pendiente, email_verified_at = null.
     - Si el email ya existe en cliente_users → 422.
     - Enviar verificación de correo.
     - Respuesta 201: "Registro recibido, verifica tu correo".
4. CASO C — RUC existe CON correo asociado (clientes.email != null):
     - NO crear cuenta, NO revelar el correo completo.
     - Respuesta 200: "Este RUC ya tiene un correo registrado. Te enviamos
       instrucciones a tu correo." + email_hint: "jha****@***.com"
       (correo enmascarado server-side con el helper mask_email()).
```

**Helper de enmascarado de correo:**

```php
function maskEmail(string $email): string
{
    [$user, $domain] = explode('@', $email);
    $userMasked = mb_substr($user, 0, 3) . str_repeat('*', max(strlen($user) - 3, 1));
    $dotPos = strrpos($domain, '.');
    $tld = substr($domain, $dotPos);            // ".com"
    return "{$userMasked}@***{$tld}";            // jha*****@***.com
}
```

> **Anti-enumeración:** los casos A/B/C devuelven mensajes que no permiten deducir con certeza si el RUC existe o tiene correo, más allá de lo que el negocio exige mostrar (correo enmascarado). El status puede unificarse a 200/201 con mensajes neutros.

### 5.2 Verificación de correo (`GET /api/portal/auth/verify/{id}/{hash}`)

Enlace firmado (`signed` middleware) enviado por correo. Al abrirlo:
- Marca `email_verified_at = now()`.
- Estado pasa a `pendiente` (esperando aprobación admin).
- Redirige al portal Next con un mensaje "correo verificado, tu cuenta está en revisión".

`POST /api/portal/auth/email/resend` reenvía el enlace (throttle).

### 5.3 Login (`POST /api/portal/auth/login`)

**Request:** `{ email, password, device_name? }`
Espeja `MobileAuthController`:

```
1. Buscar ClienteUser por email.
2. Si no existe o Hash::check falla → 401 "Credenciales inválidas".
3. Si email_verified_at == null → 403 "Verifica tu correo".
4. Si estado != aprobado → 403 con motivo (pendiente/rechazado/suspendido).
5. Revocar tokens previos del mismo device_name.
6. token = createToken(device_name, ['portal']).
7. last_login_at = now().
8. Respuesta 200: { success, token, cliente_user, cliente }.
```

### 5.4 Recuperación de contraseña

- `POST /api/portal/auth/forgot-password` `{ email }` → envía link de reset (broker `cliente_users`, expira 60 min). Respuesta neutra siempre (anti-enumeración).
- `POST /api/portal/auth/reset-password` `{ token, email, password, password_confirmation }` → resetea y revoca todos los tokens existentes.

### 5.5 Logout y perfil

- `POST /api/portal/auth/logout` → revoca el token actual.
- `GET /api/portal/auth/me` → datos del `ClienteUser` + su `Cliente`.
- `PUT /api/portal/auth/profile` → editar `name`, `telefono`, datos básicos; cambio de contraseña con verificación de la actual.

---

## 6. Panel admin: aprobación de accesos

Módulo Livewire nuevo en el panel de administración: **"Accesos al Portal"**.

- Lista de `cliente_users` con estado `pendiente` (cola de aprobación), filtrable.
- Acciones: **Aprobar** / **Rechazar** (con motivo) / **Suspender** / **Reactivar**.
- Al aprobar/rechazar → notificación por correo al cliente.
- Permiso Spatie nuevo: `gestionar-accesos-portal`.
- Registro en activity log (ya disponible vía `LogsActivity`).
- Ruta sugerida: `admin/portal/accesos` (sigue el patrón `routes/web.php`).

---

## 7. Módulos del portal (sidebar)

| # | Módulo | Endpoint base | Notas |
|---|--------|---------------|-------|
| 1 | Dashboard | `GET /api/portal/dashboard` | resumen: nº vehículos activos, recibos pendientes, tickets abiertos, próximos vencimientos |
| 2 | Vehículos | `GET /api/portal/vehiculos` | **con gating** (ver §8) |
| 3 | Actas | `GET /api/portal/actas` | filtrable por vehículo |
| 4 | Certificados GPS | `GET /api/portal/certificados-gps` | |
| 5 | Cert. Velocímetro | `GET /api/portal/certificados-velocimetro` | |
| 6 | Cert. Antifatiga | `GET /api/portal/certificados-antifatiga` | |
| 7 | Comprobantes | `GET /api/portal/comprobantes` | facturas/boletas emitidas |
| 8 | Recibos | `GET /api/portal/recibos` | con estado de pago |
| 9 | Presupuestos | `GET /api/portal/presupuestos` | |
| 10 | Contratos | `GET /api/portal/contratos` | |
| 11 | Órdenes de trabajo | `GET /api/portal/ordenes-trabajo` (+ `/{id}`) | modelo `WorkOrder` por `cliente_id` |
| 12 | Tickets | `GET /api/portal/tickets` (+ `/{id}`) | modelo `Ticket` por `customer_id`. **Solo lectura**; el detalle incluye mensajes públicos (los internos se excluyen). Publicar mensajes no está implementado (posible futuro). |
| 13 | Notas de crédito/débito | `GET /api/portal/notas-credito` · `/notas-debito` | modelo `Comprobantes` (tipo 07 / 08) |
| 14 | Contactos | `GET/POST/PUT/DELETE /api/portal/contactos` | CRUD de su empresa |
| 15 | Perfil | `GET/PUT /api/portal/auth/profile` | credenciales + datos básicos |

Los PDF se obtienen con un endpoint genérico `GET /api/portal/pdf/{tipo}/{id}` que devuelve una URL firmada (§9), **no** con `{recurso}/{id}/pdf`. Solo `vehiculos`, `ordenes-trabajo` y `tickets` tienen endpoint de detalle `/{id}`; el resto son listados.

---

## 8. Gating de acceso a vehículos

Implementado en `App\Services\Portal\VehiculoAccesoService`. Un vehículo es **accesible** si cumple **al menos una** condición:

1. **Cobro vigente**: el vehículo tiene un `Cobros` con estado `ACTIVO` o `CORTESIA` (cubre "plan activo / cobro pagado"; el plan en Talentus se materializa como un cobro por vehículo).
2. **Recibo pendiente de pago**: el cliente tiene un `Recibos` con `pago_estado = UNPAID` (acceso en mora permitido).

```php
public function evaluar(Vehiculos $vehiculo, bool $clienteTieneReciboPendiente = false): array
{
    $cobros = $vehiculo->relationLoaded('cobros') ? $vehiculo->cobros : $vehiculo->cobros()->with('plan')->get();

    $cobroVigente = $cobros->first(
        fn ($c) => in_array($c->estado, [CobroEstado::ACTIVO, CobroEstado::CORTESIA], true)
    );

    $accesible = $cobroVigente !== null || $clienteTieneReciboPendiente;

    return [
        'accesible' => $accesible,
        'motivo'    => $accesible ? null : $this->motivo($cobros), // suspendido | cancelado | sin_cobro
        'plan'      => $cobroVigente ? [
            'nombre' => $cobroVigente->plan_nombre,
            'estado' => $cobroVigente->estado->value,
            'vence'  => optional($cobroVigente->fecha_vencimiento)->format('Y-m-d'),
            'dias_restantes' => $cobroVigente->dias_restantes,
        ] : null,
    ];
}
```

> **Decisión final:** el gating se basa en `Cobros` (mecanismo real de facturación por vehículo, enum `CobroEstado`) más el recibo pendiente del cliente, no en `planSubscriptions`. Cada vehículo se marca con `accesible: bool`, `motivo` y `plan`; el frontend muestra el bloqueo correspondiente.

---

## 9. Entrega de PDFs (URL firmada)

Los PDF se entregan como **URL temporal firmada**, no en base64. Se usa **un endpoint genérico** con un parámetro `tipo`, no rutas por recurso.

**Flujo:**

```
GET /api/portal/pdf/{tipo}/{id}            (auth:sanctum, abilities:portal, portal.empresa)
  → valida que el documento pertenece al cliente
  → 200 { "url": "https://tudominio.com/api/portal/files/{tipo}/{id}?cliente=42&expires=...&signature=..." }

GET /api/portal/files/{tipo}/{id}          (middleware signed, SIN sanctum)
  → fija el contexto de empresa y hace stream del PDF (Content-Type: application/pdf)
```

- `tipo` ∈ `acta` · `certificado-gps` · `certificado-velocimetro` · `certificado-antifatiga` · `contrato` · `presupuesto` · `recibo` · `orden-trabajo` · `comprobante` · `nota-credito` · `nota-debito` · `comunicacion-baja`.
- La URL se genera con `URL::temporarySignedRoute('api.portal.files.stream', now()->addMinutes(config('portal.pdf_link_minutes', 10)), ['tipo' => $tipo, 'id' => $id, 'cliente' => $clienteId])`.
- El stream re-verifica la pertenencia con el `cliente` embebido en la firma (la ruta no lleva token; la firma es la autorización).
- Generadores reutilizados: `getPDFData()` (actas/certificados/contrato/presupuesto/recibo), `WorkOrderPdfController::generate()` (OT) y `getPdf()` de facturación electrónica/Greenter (`comprobante`/`nota-credito`/`nota-debito`/`comunicacion-baja`).
- Next abre la URL en un visor (`<iframe>` / `<embed>` / `react-pdf`) o la usa para descarga directa. Ver detalle completo en §16.10.

---

## 10. Contrato de la API (resumen de endpoints)

Prefijo: **`/api/portal`**. Salvo auth pública, todo requiere `Authorization: Bearer <token>` + `Accept: application/json`.

> Lista fiel a `routes/api.php`. La referencia completa con request/response está en **§16**.

### Públicos (sin token)
```
POST   /api/portal/auth/register                  (throttle:6,1)
POST   /api/portal/auth/login                     (throttle:6,1)
POST   /api/portal/auth/forgot-password           (throttle:6,1)
POST   /api/portal/auth/reset-password            (throttle:6,1)
POST   /api/portal/auth/email/resend              (throttle:6,1)
GET    /api/portal/auth/verify/{id}/{hash}        (signed)
GET    /api/portal/files/{tipo}/{id}              (signed, stream PDF)
```

### Autenticados (`auth:sanctum` + `abilities:portal` + `portal.empresa`)
```
POST   /api/portal/auth/logout
GET    /api/portal/auth/me
PUT    /api/portal/auth/profile

GET    /api/portal/dashboard

GET    /api/portal/vehiculos
GET    /api/portal/vehiculos/{id}

GET    /api/portal/actas                          (listado)
GET    /api/portal/certificados-gps               (listado)
GET    /api/portal/certificados-velocimetro       (listado)
GET    /api/portal/certificados-antifatiga        (listado)

GET    /api/portal/comprobantes                   (Ventas: boletas/facturas)
GET    /api/portal/notas-credito                  (Comprobantes tipo 07)
GET    /api/portal/notas-debito                   (Comprobantes tipo 08)
GET    /api/portal/recibos                        (listado)
GET    /api/portal/presupuestos                   (listado)
GET    /api/portal/contratos                      (listado)

GET    /api/portal/ordenes-trabajo
GET    /api/portal/ordenes-trabajo/{id}

GET    /api/portal/tickets
GET    /api/portal/tickets/{id}                   (incluye mensajes públicos)

GET    /api/portal/contactos
POST   /api/portal/contactos
PUT    /api/portal/contactos/{id}
DELETE /api/portal/contactos/{id}

GET    /api/portal/pdf/{tipo}/{id}                (→ { url } firmada; tipos en §16.10)
```

### Ejemplos de payload

**Login OK (200):**
```json
{
  "success": true,
  "token": "12|xxxxxxxxxxxxxxxxxxxxxxxx",
  "cliente_user": { "id": 5, "name": "Jhamner S.", "email": "jha@empresa.com", "rol": "titular" },
  "cliente": { "id": 42, "razon_social": "MI EMPRESA SAC", "ruc": "20512345678" }
}
```

**Registro RUC existente con correo (200):**
```json
{
  "success": true,
  "message": "Te enviamos instrucciones a tu correo registrado.",
  "email_hint": "jha*****@***.com"
}
```

**Listado de vehículos (200):**
```json
{
  "data": [
    {
      "id": 10, "placa": "ABC-123", "marca": "Toyota", "modelo": "Hilux", "color": "Blanco", "year": "2022",
      "accesible": true, "motivo": null,
      "plan": { "nombre": "Plan Flota", "estado": "ACTIVO", "vence": "2026-09-30", "dias_restantes": 108 }
    },
    {
      "id": 11, "placa": "XYZ-789", "marca": "Hyundai", "modelo": "HD65", "color": "Azul", "year": "2020",
      "accesible": false, "motivo": "sin_cobro",
      "plan": null
    }
  ]
}
```

**PDF (200):**
```json
{ "url": "https://tudominio.com/api/portal/files/acta/55?expires=1718400000&signature=ab12..." }
```

### Convención de respuestas

- Éxito: `2xx`. Errores de validación: `422` con `{ message, errors }`.
- No autenticado: `401`. Sin permiso / estado no aprobado: `403`. No encontrado / no es del cliente: `404` (no `403`, para no revelar existencia).
- Se usan **Eloquent API Resources** (`ClienteUserResource`, `VehiculoResource`, etc.) y, donde aplique, paginación estándar de Laravel (`?page=&per_page=`).

---

## 11. Seguridad

- [ ] Tokens Sanctum con ability `portal`; middleware `abilities:portal` en todo el grupo.
- [ ] **Toda** consulta filtra por `cliente_id` del token (aislamiento estricto), además del `EmpresaScope`.
- [ ] Anti-enumeración en registro/forgot-password (mensajes neutros, correo enmascarado).
- [ ] Rate limiting: `throttle` en login (`5,1`), register, forgot-password, resend.
- [ ] Verificación de correo obligatoria + aprobación admin antes de operar.
- [ ] URLs de PDF firmadas y de corta expiración; validación de pertenencia antes de firmar.
- [ ] CORS restringido al origen del portal (`https://clientes.tudominio.com`).
- [ ] HTTPS forzado (HSTS) en el VirtualHost.
- [ ] Reset de contraseña revoca todos los tokens activos.
- [ ] Password policy fuerte (mín. 8, mezcla) vía regla `Password::defaults()`.
- [ ] Activity log en acciones sensibles (aprobación, cambio de credenciales).

---

## 12. Infraestructura y despliegue (AlmaLinux + httpd)

### 12.1 Next.js

```bash
# en el VPS
cd /var/www/portal-cliente
npm ci
npm run build
pm2 start "npm run start" --name portal-cliente -- -p 3001
pm2 save
```

### 12.2 Apache (httpd) reverse proxy + SSL

```apache
<VirtualHost *:443>
    ServerName clientes.tudominio.com

    SSLEngine on
    SSLCertificateFile      /etc/letsencrypt/live/clientes.tudominio.com/fullchain.pem
    SSLCertificateKeyFile   /etc/letsencrypt/live/clientes.tudominio.com/privkey.pem

    ProxyPreserveHost On
    ProxyPass        /  http://127.0.0.1:3001/
    ProxyPassReverse /  http://127.0.0.1:3001/

    # Headers de seguridad
    Header always set Strict-Transport-Security "max-age=31536000"
</VirtualHost>

<VirtualHost *:80>
    ServerName clientes.tudominio.com
    Redirect permanent / https://clientes.tudominio.com/
</VirtualHost>
```

> Requiere `mod_proxy`, `mod_proxy_http`, `mod_ssl`, `mod_headers`. SELinux: `setsebool -P httpd_can_network_connect 1`.

### 12.3 CORS en Laravel (`config/cors.php`)

```php
'paths' => ['api/portal/*'],
'allowed_origins' => ['https://clientes.tudominio.com'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => false, // token Bearer, no cookies cross-site
```

### 12.4 Variables de entorno

**Laravel (`.env`):**
```
PORTAL_URL=https://clientes.tudominio.com        # para enlaces de verificación/reset
```

**Next.js (`.env`):**
```
API_BASE_URL=https://tudominio.com/api/portal     # uso server-side (BFF)
NEXT_PUBLIC_APP_NAME=Portal Talentus
SESSION_SECRET=...                                 # firma de cookie httpOnly
```

---

## 13. Plan de implementación por fases (backend)

> El frontend Next.js se construye en su propio repositorio tras cerrar la Fase 2.

### Fase 1 — Autenticación y cuenta
1. Migración `cliente_users` + `cliente_password_resets`.
2. Modelo `ClienteUser` (Authenticatable, HasApiTokens, Notifiable) + factory.
3. Guard `cliente`, provider y password broker en `config/auth.php`.
4. Ability `portal` + middleware `abilities` + middleware `SetPortalEmpresa`.
5. `PortalAuthController`: register, login, logout, me, verify, resend, forgot/reset, profile.
6. FormRequests (`RegisterPortalRequest`, etc.) + helper `maskEmail`.
7. Notificaciones de correo (verificación, reset, aprobación/rechazo).
8. Rutas `routes/api.php` (grupo `portal/auth`).
9. **Tests** (Feature): registro casos A/B/C, login por estado, verificación, reset, aislamiento.

### Fase 2 — Aprobación admin
1. Permiso `gestionar-accesos-portal` (seeder Spatie).
2. Componente Livewire "Accesos al Portal" + vista + ruta `admin/portal/accesos`.
3. Acciones aprobar/rechazar/suspender + notificaciones.
4. **Tests**.

### Fase 3 — Recursos de consulta
1. `PortalDashboardController` + controladores por recurso (vehículos con gating, actas, certificados, comprobantes, recibos, presupuestos, contratos, órdenes de trabajo, tickets).
2. API Resources por recurso.
3. Servicio de gating de vehículos.
4. **Tests** por recurso (incluye pertenencia/aislamiento y gating).

### Fase 4 — Contactos y PDFs
1. CRUD de contactos (FormRequests).
2. Endpoint genérico `pdf/{tipo}/{id}` (→ URL firmada) + ruta firmada `files/{tipo}/{id}` que hace stream, reutilizando los generadores PDF existentes.
3. **Tests** (CRUD, firma/expiración, pertenencia).

### Fase 5 — Infra
1. `config/cors.php`, variables `.env`.
2. Documentar despliegue Next + Apache + PM2 (este archivo).

---

## 14. Notas / pendientes de confirmar en implementación

- **Resuelto:** `clientes` guarda el correo en la columna `email` (nullable) y el RUC en `numero_documento`. Multi-empresa vía `empresa_id`.
- **Resuelto:** el portal es solo para clientes existentes; no se crean `Cliente` desde el registro (ver §5.1).
- Nombres exactos de columnas de estado de pago en `Cobros`/`Recibos` para el gating (Fase 3).
- Edge case: un mismo RUC presente en más de una empresa — la búsqueda toma el primer `Cliente` activo; revisar si se necesita desambiguar por empresa.
- Estructura final del PDF de presupuestos/comprobantes (reutilizar generadores existentes) (Fase 4).

---

## 15. Estado de implementación

### Fase 1 — Autenticación y cuenta ✅ (backend)

Implementado en este repositorio:

- Migraciones `cliente_users` y `cliente_password_resets`.
- Modelo `App\Models\ClienteUser` (Authenticatable, HasApiTokens, Notifiable) + `ClienteUserFactory` (estados `pendiente`, `sinVerificar`, `rechazado`, `suspendido`).
- Relación `Clientes::clienteUsers()`.
- `config/auth.php`: guard `cliente`, provider `cliente_users`, broker `cliente_users`.
- `config/portal.php`: `url`, `signed_link_minutes`.
- Middleware `SetPortalEmpresa` (alias `portal.empresa`) + aliases `abilities`/`ability` de Sanctum en `Kernel.php`.
- Helper `mask_email()` en `app/helpers.php`.
- Notifications `Portal\VerifyPortalEmailNotification` y `Portal\ResetPortalPasswordNotification`.
- FormRequests en `App\Http\Requests\Portal\*`.
- `Api\Portal\PortalAuthController`: register, verify, resendVerification, login, logout, me, updateProfile, forgotPassword, resetPassword.
- Rutas `/api/portal/auth/*` en `routes/api.php`.

**Pendiente de ejecutar por el equipo** (no se corre automáticamente porque la BD de tests apunta a la BD real):

```bash
php artisan migrate          # crea cliente_users y cliente_password_resets
# añadir PORTAL_URL al .env
```

> Tests automatizados omitidos por decisión del proyecto (la suite usa la BD real). Validado con `php -l`.

### Fase 2 — Aprobación admin ✅ (Livewire)

Implementado en este repositorio:

- Seeder `PortalAccesosPermissionsSeeder` → permiso `gestionar-accesos-portal` (asignado al rol `Admin`).
- Notification `Portal\PortalAccesoActualizadoNotification` (mensajes para `aprobado`/`rechazado`/`suspendido`, con motivo opcional).
- Componente Livewire `App\Livewire\Admin\Portal\AccesosIndex` (class-based): listado paginado con búsqueda y filtro por estado (chips), contador de pendientes, y acciones `aprobar`, `suspender`, `reactivar`, `rechazar` (con modal de motivo). Cada acción autoriza `gestionar-accesos-portal`, revoca tokens al suspender/rechazar y notifica por correo.
- Vistas `resources/views/livewire/admin/portal/accesos-index.blade.php` y wrapper `resources/views/admin/portal/accesos/index.blade.php` (con toasts iziToast).
- Ruta `admin/portal/accesos` (`Route::view`) protegida por `can:gestionar-accesos-portal`.
- Enlace "Accesos al Portal" en el sidebar (grupo Clientes), gated por el permiso.

**Pendiente de ejecutar por el equipo:**

```bash
php artisan db:seed --class=PortalAccesosPermissionsSeeder   # crea el permiso y lo asigna a Admin
```

### Fase 3 — Recursos de consulta ✅ (API)

Implementado en este repositorio:

- Trait `Api\Portal\Concerns\ResolvesPortalCliente`: resuelve el cliente del token, expone `vehiculoIds()`, `clienteTieneReciboPendiente()`, `perPage()`. **Todo se filtra por `cliente_id` del token.**
- Servicio `Services\Portal\VehiculoAccesoService`: gating de vehículos. **Interpretación final:** accesible si el vehículo tiene un `Cobros` vigente (estado `ACTIVO` o `CORTESIA`) **o** el cliente tiene un recibo `UNPAID`. Devuelve `accesible`, `motivo` (`suspendido`/`cancelado`/`sin_cobro`) y `plan` (nombre, estado, vence, días restantes).
- API Resources en `Http\Resources\Portal\*` (Vehiculo, Acta, CertificadoGps, CertificadoVelocimetro, CertificadoAntifatiga, Comprobante, Recibo, Presupuesto, Contrato, OrdenTrabajo, Ticket, TicketMessage).
- Controllers en `Api\Portal\*`: `PortalDashboardController`, `PortalVehiculoController` (index/show con gating), `PortalCertificadoController` (actas + GPS + velocímetro + antifatiga), `PortalFacturacionController` (comprobantes, recibos, presupuestos, contratos), `PortalOrdenTrabajoController` (index/show), `PortalTicketController` (index/show — **solo mensajes públicos**, los internos se excluyen).
- Rutas autenticadas (`auth:sanctum` + `abilities:portal` + `portal.empresa`) en `routes/api.php`.
- Paginación con `?per_page` (máx. 50).

**Notas de seguridad aplicadas:** aislamiento estricto por `cliente_id` en cada consulta; tickets exponen solo `is_internal = false`; el contexto de empresa se inyecta por middleware.

### Fase 4 — Contactos y PDFs ✅ (API)

Implementado en este repositorio:

- **Contactos (CRUD):** `PortalContactoController` (index/store/update/destroy), `ContactoPortalRequest`, `ContactoResource`. Todo acotado por `cliente_id`; al crear se fija `clientes_id` y `empresa_id` desde el cliente. Rutas `GET/POST/PUT/DELETE /api/portal/contactos`.
- **PDFs por URL firmada:** `PortalPdfController`:
  - `GET /api/portal/pdf/{tipo}/{id}` (autenticado) → verifica pertenencia y devuelve `{ url }` (ruta temporal firmada, expira en `config('portal.pdf_link_minutes')`, 10 min por defecto).
  - `GET /api/portal/files/{tipo}/{id}` (middleware `signed`, sin token) → re-verifica pertenencia con el `cliente` embebido en la firma, fija el contexto de empresa y hace **stream** del PDF reutilizando los generadores existentes (`getPDFData()` de los modelos; `WorkOrderPdfController::generate()` para órdenes).
  - Tipos soportados: `acta`, `certificado-gps`, `certificado-velocimetro`, `certificado-antifatiga`, `contrato`, `presupuesto`, `recibo`, `orden-trabajo`.
- Resource de presupuesto enriquecido con `serie_correlativo`/`numero`; `VehiculoResource` corregido a la columna real `year` (verificado contra `database/talentus.sql`).

**Modelos de facturación (confirmado):** boletas/facturas/nota de venta → `Ventas`; notas de crédito/débito → `Comprobantes` (`tipo_comprobante_id` `07`/`08`). Endpoints: `comprobantes`, `notas-credito`, `notas-debito`.

**PDFs de facturación (resuelto):** los PDF de ventas, notas y comunicación de baja se generan con el método `getPdf()` de cada modelo (`Ventas`/`Comprobantes`/`EnvioResumen`), que renderiza con Greenter (`Util::getPdf*`) y hace stream con DomPDF. Cableados en `PortalPdfController` (tipos `comprobante`, `nota-credito`, `nota-debito`, `comunicacion-baja`). Nota: `getPdf()` depende de la columna `clase` (documento Greenter serializado), igual que el panel admin; solo aplica a documentos emitidos electrónicamente. El `FacturaPdfController` del admin importa un modelo `Facturas` inexistente y no se usa.

### Estado global

| Fase | Alcance | Estado |
|------|---------|--------|
| 1 | Autenticación y cuenta | ✅ |
| 2 | Aprobación admin (Livewire) | ✅ |
| 3 | Recursos de consulta | ✅ |
| 4 | Contactos y PDFs | ✅ (todos: docs, facturación, notas y comunicación de baja) |
| 5 | Infra (CORS, deploy Next/Apache) | pendiente |

---

## 16. Referencia completa de endpoints (request / response)

**Base URL:** `/api/portal`
**Headers comunes:** `Accept: application/json`. Para rutas autenticadas, además `Authorization: Bearer {token}`.
**Códigos:** `200/201` éxito · `401` sin autenticar · `403` sin permiso/estado no aprobado/ability faltante · `404` no encontrado o no pertenece al cliente · `422` validación (`{ message, errors }`).
**Paginación:** las listas devuelven el envelope estándar de Laravel: `{ data: [...], links: {...}, meta: { current_page, last_page, per_page, total, ... } }`. Parámetro `?per_page=` (default 15, máx 50).
**`pdf_url`:** cada recurso documental (actas, certificados GPS/velocímetro/antifatiga, contratos, presupuestos, recibos, órdenes de trabajo, comprobantes y notas) incluye un campo **`pdf_url`** con la URL firmada lista para abrir en un `<iframe>`/visor, **sin** una segunda llamada. Caduca según `config('portal.pdf_link_minutes')` (10 min); si expiró, se refresca con `GET /pdf/{tipo}/{id}`.

---

### 16.1 Autenticación (público)

#### `POST /auth/register`
Request:
```json
{ "ruc": "20512345678", "name": "Jhamner S.", "email": "jha@correo.com", "password": "secret123", "password_confirmation": "secret123" }
```
Respuestas:
```jsonc
// 201 — RUC existe SIN correo: cuenta creada (pendiente de verificar)
{ "success": true, "message": "Registro recibido. Revisa tu correo para verificar tu cuenta." }

// 200 — RUC existe CON correo: no se revela, se notifica al correo registrado
{ "success": true, "message": "Este RUC ya tiene un correo registrado. Te enviamos instrucciones a tu correo.", "email_hint": "jha****@***.com" }

// 404 — RUC no existe como cliente
{ "success": false, "message": "No encontramos ese RUC como cliente. Contáctanos para habilitar tu acceso." }

// 422 — validación o correo ya registrado en cliente_users
{ "message": "...", "errors": { "email": ["Ya existe una cuenta con este correo."] } }
```

#### `POST /auth/login`
Request:
```json
{ "email": "jha@correo.com", "password": "secret123", "device_name": "portal-web" }
```
Respuestas:
```jsonc
// 200
{
  "success": true,
  "token": "12|xxxxxxxxxxxxxxxxxxxxxxxx",
  "cliente_user": { "id": 5, "name": "Jhamner S.", "email": "jha@correo.com", "telefono": "999...", "rol": "titular", "estado": "aprobado" },
  "cliente": { "id": 42, "razon_social": "MI EMPRESA SAC", "ruc": "20512345678" }
}

// 401 — credenciales inválidas
{ "success": false, "message": "Credenciales inválidas." }

// 403 — correo sin verificar
{ "success": false, "message": "Verifica tu correo para activar tu cuenta." }

// 403 — estado no aprobado (pendiente/rechazado/suspendido)
{ "success": false, "message": "Tu cuenta está en revisión. Te avisaremos cuando sea aprobada.", "estado": "pendiente" }
```

#### `GET /auth/verify/{id}/{hash}`  *(firmado; abierto desde el correo)*
Marca el correo como verificado y **redirige** a `PORTAL_URL/email-verificado`. No devuelve JSON.

#### `POST /auth/email/resend`
Request: `{ "email": "jha@correo.com" }`
Respuesta (neutra siempre): `{ "success": true, "message": "Si el correo está registrado y sin verificar, te enviamos un nuevo enlace." }`

#### `POST /auth/forgot-password`
Request: `{ "email": "jha@correo.com" }`
Respuesta (neutra siempre): `{ "success": true, "message": "Si el correo está registrado, te enviamos instrucciones para restablecer tu contraseña." }`

#### `POST /auth/reset-password`
Request:
```json
{ "token": "<token-del-correo>", "email": "jha@correo.com", "password": "nueva123", "password_confirmation": "nueva123" }
```
Respuestas: `200 { success:true, message }` · `422 { success:false, message }` (token inválido/expirado). Revoca todos los tokens activos.

---

### 16.2 Cuenta (autenticado)

#### `POST /auth/logout`
Respuesta: `{ "success": true, "message": "Sesión cerrada correctamente." }`

#### `GET /auth/me`
```json
{
  "success": true,
  "cliente_user": { "id": 5, "name": "Jhamner S.", "email": "jha@correo.com", "telefono": "999...", "rol": "titular", "estado": "aprobado" },
  "cliente": { "id": 42, "razon_social": "MI EMPRESA SAC", "ruc": "20512345678" }
}
```

#### `PUT /auth/profile`
Request (la contraseña es opcional; si se envía, `current_password` es obligatorio):
```json
{ "name": "Jhamner S.", "telefono": "999111222", "current_password": "secret123", "password": "nueva123", "password_confirmation": "nueva123" }
```
Respuesta: `{ "success": true, "message": "Perfil actualizado.", "cliente_user": { ... } }` · `422` si `current_password` no coincide.

---

### 16.3 Dashboard (autenticado)

#### `GET /dashboard`
```json
{
  "success": true,
  "data": {
    "vehiculos_total": 12,
    "recibos_pendientes": { "cantidad": 3, "monto": 450.00 },
    "tickets_abiertos": 2,
    "cobros_proximos_a_vencer": 4
  }
}
```

---

### 16.4 Vehículos (autenticado)

#### `GET /vehiculos`  ·  `GET /vehiculos/{id}`
Item (`VehiculoResource`):
```json
{
  "id": 10, "placa": "ABC-123", "marca": "Toyota", "modelo": "Hilux", "color": "Blanco", "year": "2022",
  "accesible": true, "motivo": null,
  "plan": { "nombre": "Plan Flota", "estado": "ACTIVO", "vence": "2026-09-30", "dias_restantes": 108 },
  "dispositivo": { "imei": "86xxxxxxxxxxxxx" }
}
```
- `accesible` (bool): el vehículo tiene cobro vigente (`ACTIVO`/`CORTESIA`) o el cliente tiene recibo pendiente.
- `motivo` cuando `accesible=false`: `suspendido` · `cancelado` · `sin_cobro`.
- `plan` es `null` si no hay cobro vigente.

---

### 16.5 Certificados y actas (autenticado)

#### `GET /actas` — `ActaResource`
```json
{ "id": 55, "numero": "0001", "codigo": "ACT-0001", "fecha": "2026-01-10", "inicio_cobertura": "2026/01/10", "fin_cobertura": "2027/01/10", "plataforma": "GPSWox", "vehiculo": { "id": 10, "placa": "ABC-123" }, "pdf_url": "https://tudominio.com/api/portal/files/acta/55?cliente=42&expires=...&signature=..." }
```
Los certificados GPS/velocímetro/antifatiga siguen el mismo patrón e incluyen su propio `pdf_url` (`certificado-gps`/`certificado-velocimetro`/`certificado-antifatiga`).

#### `GET /certificados-gps` — `CertificadoGpsResource`
```json
{ "id": 7, "numero": "0007", "codigo": "GPS-0007", "fecha": "2026-01-10", "fecha_instalacion": "2026-01-10", "fin_cobertura": "2027-01-10", "vehiculo": { "id": 10, "placa": "ABC-123" }, "pdf_url": "https://.../api/portal/files/certificado-gps/7?cliente=42&..." }
```

#### `GET /certificados-velocimetro` — `CertificadoVelocimetroResource`
```json
{ "id": 4, "numero": "0004", "codigo": "VEL-0004", "fecha": "2026-01-10", "velocimetro_modelo": "VDO", "vehiculo": { "id": 10, "placa": "ABC-123" }, "pdf_url": "https://.../api/portal/files/certificado-velocimetro/4?cliente=42&..." }
```

#### `GET /certificados-antifatiga` — `CertificadoAntifatigaResource`
```json
{ "id": 2, "fecha_emision": "2026-01-10", "fecha_instalacion": "2026-01-10", "inicio_cobertura": "2026-01-10", "fin_cobertura": "2027-01-10", "imei_personalizado": null, "vehiculo": { "id": 10, "placa": "ABC-123" }, "pdf_url": "https://.../api/portal/files/certificado-antifatiga/2?cliente=42&..." }
```

---

### 16.6 Facturación (autenticado)

> **Modelos:** boletas/facturas/nota de venta → `Ventas`. Notas de crédito/débito → `Comprobantes` (filtrado por `tipo_comprobante_id`: `07` crédito, `08` débito).

#### `GET /comprobantes` — `VentaResource` (boletas, facturas y notas de venta, solo `estado = COMPLETADO`)
```json
{
  "id": 80, "tipo_comprobante_id": "01", "serie_correlativo": "F001-123", "fecha_emision": "2026-05-01",
  "divisa": "PEN", "sub_total": "100.00", "igv": "18.00", "total": "118.00",
  "estado": "COMPLETADO", "pago_estado": "UNPAID", "fe_estado": 1,
  "anulado": true,
  "comunicacion_baja": { "id": 15, "nombre_xml": "20512345678-RA-20260510-001", "pdf_url": "https://.../api/portal/files/comunicacion-baja/15?cliente=42&..." },
  "pdf_url": "https://tudominio.com/api/portal/files/comprobante/80?cliente=42&expires=...&signature=..."
}
```
- `tipo_comprobante_id`: `01` factura · `03` boleta · `80`/nota de venta.
- `anulado`: `true` cuando la venta tiene `id_baja` (comunicación de baja a SUNAT). `comunicacion_baja` es `null` si no está anulada; su PDF se obtiene con `pdf/comunicacion-baja/{id_baja}`.

#### `GET /notas-credito` — `NotaResource` (modelo `Comprobantes`, tipo `07`)
```json
{ "id": 90, "tipo": "credito", "tipo_comprobante_id": "07", "serie_correlativo": "FC01-12", "fecha_emision": "2026-05-03", "divisa": "PEN", "sub_total": "50.00", "igv": "9.00", "total": "59.00", "estado": "ACEPTADO", "fe_estado": 1, "documento_afectado": "F001-123", "motivo": "Anulación parcial", "pdf_url": "https://.../api/portal/files/nota-credito/90?cliente=42&..." }
```

#### `GET /notas-debito` — `NotaResource` (modelo `Comprobantes`, tipo `08`)
```json
{ "id": 91, "tipo": "debito", "tipo_comprobante_id": "08", "serie_correlativo": "FD01-4", "fecha_emision": "2026-05-04", "divisa": "PEN", "sub_total": "20.00", "igv": "3.60", "total": "23.60", "estado": "ACEPTADO", "fe_estado": 1, "documento_afectado": "F001-123", "motivo": "Intereses por mora", "pdf_url": "https://.../api/portal/files/nota-debito/91?cliente=42&..." }
```

#### `GET /recibos` — `ReciboResource`
```json
{ "id": 30, "serie": "R001", "numero": "45", "serie_numero": "R001-45", "fecha_emision": "2026/05/01", "fecha_pago": null, "divisa": "PEN", "total": "118.00", "estado": "COMPLETADO", "pago_estado": "UNPAID", "tipo_venta": "CONTADO", "pdf_url": "https://.../api/portal/files/recibo/30?cliente=42&..." }
```

#### `GET /presupuestos` — `PresupuestoResource`
```json
{ "id": 12, "serie_correlativo": "P001-12", "numero": "12", "fecha": "2026/04/20", "fecha_caducidad": "2026/05/20", "total": "500.00", "total_soles": "500.00", "estado": "PENDIENTE", "pdf_url": "https://.../api/portal/files/presupuesto/12?cliente=42&..." }
```

#### `GET /contratos` — `ContratoResource`
```json
{ "id": 9, "fecha": "2026/01/05", "fecha_emision": "2026/01/05", "estado": true, "pdf_url": "https://.../api/portal/files/contrato/9?cliente=42&..." }
```

---

### 16.7 Órdenes de trabajo (autenticado)

#### `GET /ordenes-trabajo`  ·  `GET /ordenes-trabajo/{id}` — `OrdenTrabajoResource`
```json
{
  "id": 100, "uuid": "9b2c...", "estado": "finalizado",
  "fecha_programada": "2026-05-01T09:00:00.000000Z", "fecha_inicio": "2026-05-01T09:15:00.000000Z", "fecha_finalizacion": "2026-05-01T11:00:00.000000Z",
  "observaciones_final": "Instalación conforme",
  "tipo": { "id": 1, "nombre": "Instalación GPS" },
  "vehiculo": { "id": 10, "placa": "ABC-123" },
  "pdf_url": "https://tudominio.com/api/portal/files/orden-trabajo/100?cliente=42&expires=...&signature=..."
}
```
`estado`: `pendiente` · `en_proceso` · `finalizado` · `cancelado`.

---

### 16.8 Tickets (autenticado — solo lectura)

> El portal **no** permite crear tickets ni publicar mensajes; solo consultar los del cliente. Si se requiere interacción, es una ampliación futura.

#### `GET /tickets` — `TicketResource` (lista, sin `mensajes`)
```json
{ "id": 21, "code": "TK-2026-000021", "subject": "GPS sin señal", "description": "...", "status": "open", "priority": "high", "last_activity_at": "2026-05-02T14:00:00.000000Z", "resolved_at": null, "closed_at": null, "created_at": "2026-05-01T10:00:00.000000Z", "categoria": "Soporte técnico" }
```

#### `GET /tickets/{id}` — incluye `mensajes` (solo públicos; los internos se excluyen)
```json
{
  "id": 21, "code": "TK-2026-000021", "subject": "GPS sin señal", "status": "open", "priority": "high", "categoria": "Soporte técnico",
  "mensajes": [
    { "id": 200, "body": "Hemos recibido tu reporte.", "autor": "Soporte Talentus", "created_at": "2026-05-01T10:05:00.000000Z" }
  ]
}
```

---

### 16.9 Contactos (autenticado, CRUD)

#### `GET /contactos` — `ContactoResource` (paginado)
```json
{ "id": 3, "nombre": "Ana Pérez", "cargo": "Gerente", "numero_documento": "44556677", "telefono": "999...", "email": "ana@empresa.com", "birthday": "1990-05-20", "is_gerente": true, "is_cobros": false, "descripcion": null, "nota": null }
```

#### `POST /contactos`
Request (`nombre` y `numero_documento` obligatorios):
```json
{ "nombre": "Ana Pérez", "numero_documento": "44556677", "cargo": "Gerente", "telefono": "999111222", "email": "ana@empresa.com", "birthday": "1990-05-20", "is_gerente": true, "is_cobros": false, "descripcion": "", "nota": "" }
```
Respuesta `201`: `{ "success": true, "data": { ...ContactoResource } }`

#### `PUT /contactos/{id}`
Mismo body que store. Respuesta `200`: `{ "success": true, "data": { ... } }` · `404` si no pertenece al cliente.

#### `DELETE /contactos/{id}`
Respuesta: `{ "success": true, "message": "Contacto eliminado." }`

---

### 16.10 PDFs

#### `GET /pdf/{tipo}/{id}`  *(autenticado)*
`tipo` ∈ `acta` · `certificado-gps` · `certificado-velocimetro` · `certificado-antifatiga` · `contrato` · `presupuesto` · `recibo` · `orden-trabajo` · `comprobante` · `nota-credito` · `nota-debito` · `comunicacion-baja`.

Generadores reutilizados: `getPDFData()` (actas, certificados, contrato, presupuesto, recibo), `WorkOrderPdfController::generate()` (OT), y `getPdf()` de facturación electrónica vía Greenter (`comprobante`→`Ventas`, `nota-credito`/`nota-debito`→`Comprobantes`, `comunicacion-baja`→`EnvioResumen`). Todos hacen stream de PDF real (DomPDF/Greenter).
Verifica pertenencia y devuelve una URL temporal firmada (expira en `PORTAL_PDF_LINK_MINUTES`, 10 min):
```json
{ "url": "https://tudominio.com/api/portal/files/recibo/30?cliente=42&expires=1718400000&signature=ab12..." }
```
`404` si el `tipo` no es válido o el documento no pertenece al cliente.

#### `GET /files/{tipo}/{id}`  *(firmado, sin token)*
Hace **stream** del PDF (`Content-Type: application/pdf`, inline). La firma es la autorización; re-verifica pertenencia con el `cliente` embebido. El frontend la usa en un `<iframe>`/visor o para descarga directa.

> **Ventas, notas y comunicación de baja:** ✅ ya cableados vía el método `getPdf()` de cada modelo (`Ventas`, `Comprobantes`, `EnvioResumen`), que renderiza con Greenter + DomPDF. El PDF de **recibo** también está completo (`Recibos::getPDFData()` → `pdf.recibo.pdf`).
