# Mejoras al módulo de Usuarios — Diseño

**Fecha:** 2026-06-20
**Estado:** Aprobado

## Objetivo

Hacer usable el módulo de Usuarios del panel admin: arreglar la UX del formulario de registro/edición, limpiar y reenfocar el index, y añadir la funcionalidad de "Ingresar como" (impersonación de usuario) protegida por permiso.

## Contexto actual

- `app/Livewire/Admin/Usuarios/Create.php` y `Edit.php`: componentes casi gemelos. Ambos usan `wire:model.live` en todos los campos (round-trip por tecla) y campos de contraseña que disparan el guardado/autocompletado del navegador.
- `app/Livewire/Admin/Usuarios/Index.php`: el dropdown de fechas en la vista llama a `filter()`, **método inexistente** → error al hacer clic. La tabla muestra columnas siempre vacías (Tipo Doc, N° Doc, Dirección, Cumpleaños, Cliente) y dos columnas de estado (`is_active`, `estado`). `users.estado` por defecto es `false` (columna legacy).
- Autenticación: Laravel Fortify. `session('empresa')` se fija siempre a `1` (mono-empresa efectivo). El `route_redirect` del rol define el destino post-login (`app/Http/Responses/LoginResponse.php`).
- No existe ninguna infraestructura de impersonación (ni paquete ni código).
- Cuenta protegida: `jhamnerx1x@gmail.com` (excluida del listado vía `scopeExcludeEmail`).

## Parte 1 — Impersonación "Ingresar como"

Implementación **custom** (sin paquete) para controlar exactamente las restricciones.

### Permiso
- Nuevo permiso `admin.usuarios.impersonate` creado vía migración idempotente (`firstOrCreate`, `guard_name=web`), otorgado al rol `admin`, con `down()`.
- Añadido como checkbox a los modales de crear y editar rol (`save.blade.php`, `edit.blade.php`), en la columna "Administración Usuarios sistema".

### Controlador y rutas
`app/Http/Controllers/Admin/ImpersonationController.php`:

- `start(User $user)` (ruta `admin.usuarios.impersonate`, método GET):
  1. `abort_unless(auth()->user()->can('admin.usuarios.impersonate'), 403)`.
  2. Bloquear (redirigir con error) si:
     - `$user->id === auth()->id()` (uno mismo),
     - `$user->email === 'jhamnerx1x@gmail.com'` (cuenta protegida),
     - `$user->hasRole('admin')` (no impersonar admins),
     - ya se está impersonando (`session()->has('impersonator_id')`).
  3. `session(['impersonator_id' => auth()->id()])`.
  4. `Auth::login($user)`.
  5. `session()->put('empresa', 1)`.
  6. Registrar en activity log (`activity()->causedBy(...)->performedOn($user)->log('impersonate-start')`).
  7. Redirigir al `route_redirect` del primer rol del usuario (fallback `admin.home`).

- `leave()` (ruta `admin.usuarios.impersonate.leave`, método GET):
  1. `abort_unless(session()->has('impersonator_id'), 403)`.
  2. `$originalId = session('impersonator_id')`.
  3. `Auth::loginUsingId($originalId)`.
  4. `session()->forget('impersonator_id')`; `session()->put('empresa', 1)`.
  5. Registrar `impersonate-stop`.
  6. Redirigir a `admin.usuarios.index`.

Rutas registradas en `routes/web.php` dentro del grupo `web`/`auth` existente.

### Barra de impersonación
En `resources/views/layouts/admin.blade.php`, antes del contenido principal: si `session('impersonator_id')`, mostrar barra fija superior ámbar:

> ⚠ Estás viendo como **{{ auth()->user()->name }}** — [Volver a mi cuenta](route admin.usuarios.impersonate.leave)

### Botón en el index
Acción "Ingresar como" por fila, dentro de `@can('admin.usuarios.impersonate')`, **oculta** cuando el objetivo es la cuenta protegida o tiene rol `admin` (mismas restricciones que el controlador, para no mostrar un botón que fallará).

### Seguridad
- Doble verificación: el botón se oculta Y el controlador valida (defensa en profundidad).
- El impersonador debe tener el permiso; el objetivo nunca puede ser admin ni la cuenta protegida.
- Activity log de inicio y fin de impersonación.

## Parte 2 — UX del formulario (Create + Edit)

- Cambiar `wire:model.live` → `wire:model.blur` en campos de texto y contraseña (sin round-trip por tecla). Mantener `wire:model.live` solo en el select `document_id` (que carga las series).
- Campos de contraseña: añadir `autocomplete="new-password"` en ambos (`password`, `password_confirmation`) → detiene el prompt "¿guardar contraseña?" del navegador y evita autocompletado.
- Validación: añadir `min:8` a la regla `password` con mensaje en ambos componentes. En `Edit` la contraseña sigue siendo opcional (`nullable|min:8|confirmed`).

## Parte 3 — Index limpio

`resources/views/livewire/admin/usuarios/index.blade.php`:

- **Quitar** columnas siempre vacías: Tipo Doc, N° Doc, Dirección, Cumpleaños, Cliente.
- **Quitar** la columna `estado` (legacy, default `false`).
- **Quitar** el dropdown de fechas (llama a `filter()` inexistente).
- **Añadir** columna **Rol**: badges con `$usuario->roles->pluck('name')`.
- **Añadir** acción **Ingresar como** (gateada, ver Parte 1).
- Conservar: búsqueda, filtro por rol, toggle Activo (`is_active`), editar, eliminar, paginación.
- Columnas finales: ID · Nombre · Email · Teléfonos · Rol · Serie · Activo · Acciones.
- `Index.php`: eager-load `roles` para evitar N+1 (`User::query()->with('roles')`).

## Pruebas

- Tests de feature para impersonación (`tests/Feature/Admin/ImpersonationTest.php`):
  - Usuario con permiso puede impersonar a un no-admin → sesión cambia + `impersonator_id` presente.
  - No se puede impersonar: a uno mismo, a un admin, a la cuenta protegida → redirige con error, sin cambiar sesión.
  - Sin permiso → 403.
  - `leave()` restaura al impersonador original.
- **Restricción del entorno:** no se ejecuta `php artisan test` (RefreshDatabase borra la BD real de desarrollo). Los tests se escriben y se validan con `php -l`; su ejecución requiere una BD de pruebas separada (fuera del alcance de esta tanda salvo que se configure).

## Archivos afectados

- Crear: `app/Http/Controllers/Admin/ImpersonationController.php`, migración del permiso, `tests/Feature/Admin/ImpersonationTest.php`.
- Modificar: `routes/web.php`, `resources/views/layouts/admin.blade.php`, `resources/views/livewire/admin/usuarios/index.blade.php`, `app/Livewire/Admin/Usuarios/Index.php`, `create.blade.php`, `edit.blade.php`, `Create.php`, `Edit.php`, modales de rol (`save.blade.php`, `edit.blade.php`).

## Fuera de alcance

- Unificar Create/Edit en un solo componente (refactor mayor; se mantienen separados).
- Cambiar el comportamiento de `logoutUser()` en `Edit` (cierra sesiones del usuario editado tras guardar).
- Bloqueo de acceso por URL directa a otros módulos (tema aparte ya tratado).
