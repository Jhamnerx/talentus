# Almacén — Limpieza, FotaWebService y fix de exportación

**Fecha:** 2026-06-23
**Componentes:** `ProductosController`, `GpsController`, `FotaWebApiController` (→ `FotaWebService`), `DispositivosIndex`, `ShowInfo`, `Vehiculos\Show`, `SimCard\Save`

## Contexto

Revisión del módulo Almacén detectó: CRUD POST muerto en `ProductosController`, el anti-patrón "controller como servicio" (`new FotaWebApiController()`), una exportación que deja archivos públicos sin limpiar, y código muerto/redundante. El usuario aprobó abordar #2 (CRUD muerto), #3 (extraer servicio Fota), #4 (export) y #5 (limpieza). La autorización en acciones Livewire (#1) se descartó: el Blade ya oculta acciones sin permiso.

## Sección 2 — Productos: eliminar CRUD POST muerto

Las rutas activas de `ProductosController` son solo `index` (`admin.almacen.productos.index`) y `servicios`; el CRUD real es vía los modales Livewire `admin.items.*`. Los métodos `create`/`store`/`edit`/`update` no están ruteados y referencian vistas inexistentes (`productos/create`, `productos/edit`).

- `app/Http/Controllers/Admin/ProductosController.php`:
  - Eliminar los métodos `create`, `store`, `edit`, `update`.
  - En `__construct`, eliminar las líneas de middleware `permission:crear-producto` y `permission:editar-producto` (rutas inexistentes). Conservar `permission:ver-producto` para `index`.
  - Eliminar imports que quedan sin uso: `ProductosRequest`, `Categoria`, `Productos`, `Unit`, `Storage`, `Request`.
- **No** se elimina `app/Http/Requests/ProductosRequest.php`: lo usan `Items\CreateModal` y `Items\EditModal`.
- No hay vistas `productos/create`/`edit` que borrar (no existen).

Resultado: el controller queda con `__construct` (solo `ver-producto`), `index()` y `servicios()`.

## Sección 3 — Extraer `FotaWebService`

`FotaWebApiController` no está registrado en rutas; se usa como servicio en 3 componentes. Se mueve su lógica a un servicio y se elimina el controller.

- Crear `app/Services/FotaWebService.php` con los métodos actuales, lógica idéntica y tipos explícitos:
  - `getDevice(string $imei): object|false`
  - `getDevices(array $options = []): object|false`
  - `syncDevices(array $imeis): array`
  - `getStats(): array|false`
  - Usa el mismo `config('app.token_fota_web')`, base URI `https://api.teltonika.lt`, Guzzle `new Client([... 'verify' => false])` y headers actuales.
- Actualizar callers para resolver `app(\App\Services\FotaWebService::class)` en vez de `new FotaWebApiController()`:
  - `app/Livewire/Admin/Dispositivos/DispositivosIndex.php` (`getDevices`, `syncDevices`) — 2 instancias (`consultaFota`, `consultarDispositivosNoRegistrados`). Quitar el `use App\Http\Controllers\Admin\FotaWebApiController;`.
  - `app/Livewire/Admin/Dispositivos/ShowInfo.php` (`getDevice`). Quitar el `use`.
  - `app/Livewire/Admin/Vehiculos/Show.php` (`getDevice`). Quitar el `use`.
- Eliminar `app/Http/Controllers/Admin/FotaWebApiController.php`.
- **Sin cambios** en cuándo se marca `in_fota`/`consultado` (el marcado actual queda igual).

## Sección 4 — Arreglar la exportación de no registrados

`DispositivosIndex::exportarNoRegistrados` hoy escribe un CSV en `storage/app/public` y devuelve `redirect()->to(asset(...))`: deja archivos públicos sin limpiar y la descarga no es confiable.

- Reemplazar el cuerpo por `return response()->streamDownload(function () { ... }, $filename, ['Content-Type' => 'text/csv']);` que:
  - Abre `php://output` con `fopen`.
  - Escribe el BOM (`chr(0xEF).chr(0xBB).chr(0xBF)`).
  - Escribe la fila de encabezados y luego cada dispositivo (mismas columnas actuales: IMEI, Serial, Modelo, Descripción, Compañía, Última Conexión, Firmware, Estado).
- Conservar la guarda inicial (si `dispositivosNoRegistrados` está vacío → toast warning + `return`).
- Livewire soporta devolver un `streamDownload` desde una acción para disparar la descarga. No se deja archivo en disco ni se expone públicamente.

## Sección 5 — Limpieza de código muerto/redundante

Acotada a borrados seguros (no se reescriben estilos de validación ni se agrega `strict_types` masivo):

- `app/Http/Controllers/Admin/GpsController.php`: en `exportExcel`, eliminar la línea `redirect()->route('admin.dispositivos.index');` inalcanzable tras el `return Excel::download(...)`.
- `app/Http/Controllers/Admin/ProductosController.php`: corregir el `;;` doble (queda cubierto al reescribir el controller en la Sección 2; verificar que no quede `;;`).
- `app/Livewire/Admin/SimCard/Save.php`: eliminar el método vacío `updatedItems($value)`.
- `app/Livewire/Admin/Dispositivos/DispositivosIndex.php`:
  - Eliminar la llamada manual redundante `$this->render();` al final de `consultaFota()` (Livewire re-renderiza tras cada acción). No hay otros `$this->render()` explícitos que quitar (`search()` solo hace `resetPage()`).
  - Eliminar el listener `protected $listeners = ['render' => 'render'];` (anti-patrón; el componente ya usa atributos `#[On(...)]`).
  - Eliminar el helper `validateDate()` si no tiene usos (confirmar por búsqueda; si se usa en la vista, conservarlo).

## Pruebas / verificación

- `FotaWebService` llama a la API externa de Teltonika con Guzzle directo; no es testeable de forma confiable sin mocks de red. Verificación: `php -l` + smoke manual (abrir info de un dispositivo, consultar Fota, exportar).
- Resto de cambios (borrados, `streamDownload`): validar con `php -l`. La exportación se prueba manualmente (descargar el CSV y confirmar que no queda archivo en `storage/app/public`).
- Por preferencia registrada del usuario, no se ejecuta `php artisan test`.

## Archivos afectados

- `app/Http/Controllers/Admin/ProductosController.php` — adelgazar (#2, #5).
- `app/Http/Controllers/Admin/GpsController.php` — quitar dead code (#5).
- `app/Services/FotaWebService.php` — **crear** (#3).
- `app/Http/Controllers/Admin/FotaWebApiController.php` — **eliminar** (#3).
- `app/Livewire/Admin/Dispositivos/DispositivosIndex.php` — usar servicio + export + limpieza (#3, #4, #5).
- `app/Livewire/Admin/Dispositivos/ShowInfo.php` — usar servicio (#3).
- `app/Livewire/Admin/Vehiculos/Show.php` — usar servicio (#3).
- `app/Livewire/Admin/SimCard/Save.php` — quitar método vacío (#5).

## Fuera de alcance (YAGNI)

- Autorización en acciones Livewire (#1, descartado).
- Homogenizar validación a `rules()`/`#[Validate]` y `declare(strict_types=1)` masivo.
- Mover `consultarDispositivosNoRegistrados` a un Job en cola (mejora válida, pero fuera de este lote).
