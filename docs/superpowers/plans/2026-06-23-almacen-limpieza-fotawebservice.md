# Almacén — Limpieza + FotaWebService + fix export — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Limpiar el módulo Almacén: borrar el CRUD POST muerto de productos, extraer `FotaWebApiController` a un `FotaWebService`, arreglar la exportación de no registrados y quitar código muerto/redundante.

**Architecture:** Cambios localizados, sin lógica nueva de negocio. Se crea un servicio (`FotaWebService`) que reemplaza al controller usado como servicio, y se actualizan sus 3 callers. Lo demás son borrados y un cambio de descarga.

**Tech Stack:** Laravel 12, Livewire 4, Guzzle.

> **Restricción de testing (preferencia del usuario):** NO ejecutar `php artisan test`. `FotaWebService` llama a una API externa (Guzzle directo) no testeable sin mocks; el resto son borrados/refactors. Validar TODO con `php -l`. Verificación de comportamiento = smoke manual (abrir info de dispositivo, consultar Fota, exportar CSV).

---

## File Structure

- `app/Http/Controllers/Admin/ProductosController.php` — **adelgazar** (Task 1).
- `app/Services/FotaWebService.php` — **crear** (Task 2).
- `app/Http/Controllers/Admin/FotaWebApiController.php` — **eliminar** (Task 2).
- `app/Livewire/Admin/Dispositivos/DispositivosIndex.php` — servicio + export + limpieza (Tasks 2, 3, 4).
- `app/Livewire/Admin/Dispositivos/ShowInfo.php` — servicio (Task 2).
- `app/Livewire/Admin/Vehiculos/Show.php` — servicio (Task 2).
- `app/Http/Controllers/Admin/GpsController.php` — dead code (Task 4).
- `app/Livewire/Admin/SimCard/Save.php` — método vacío (Task 4).

---

## Task 1: Adelgazar `ProductosController` (#2 + `;;` de #5)

**Files:**
- Modify: `app/Http/Controllers/Admin/ProductosController.php`

- [ ] **Step 1: Reemplazar el archivo completo**

Reemplazar TODO el contenido de `app/Http/Controllers/Admin/ProductosController.php` por:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-producto', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.almacen.productos.index', ['tipo' => 'producto']);
    }

    public function servicios()
    {
        return view('admin.almacen.servicios.index', ['tipo' => 'servicio']);
    }
}
```

> Esto borra `create`/`store`/`edit`/`update` (no ruteados), los imports sin uso, el `;;` doble, y las líneas de middleware `crear-producto`/`editar-producto`. `servicios()` se mantiene sin gate como estaba. `ProductosRequest` NO se toca (lo usan `Items\CreateModal`/`EditModal`).

- [ ] **Step 2: Validar sintaxis**

Run: `php -l app/Http/Controllers/Admin/ProductosController.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Confirmar que las rutas siguen resolviendo**

Verificar que [routes/web.php](routes/web.php) solo referencia `ProductosController` para `index` y `servicios` (grep): `grep -n "ProductosController\|almacen.productos\|servicios" routes/web.php` — no debe haber rutas a `store`/`update`/`create`/`edit`.

- [ ] **Step 4: Commit**

```bash
git add app/Http/Controllers/Admin/ProductosController.php
git commit -m "refactor(almacen): eliminar CRUD POST muerto de ProductosController"
```

---

## Task 2: Extraer `FotaWebService` y actualizar callers (#3)

**Files:**
- Create: `app/Services/FotaWebService.php`
- Modify: `app/Livewire/Admin/Dispositivos/DispositivosIndex.php`, `app/Livewire/Admin/Dispositivos/ShowInfo.php`, `app/Livewire/Admin/Vehiculos/Show.php`
- Delete: `app/Http/Controllers/Admin/FotaWebApiController.php`

- [ ] **Step 1: Crear `app/Services/FotaWebService.php`**

```php
<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Cliente de la API de Teltonika Fota Web.
 * Extraído de FotaWebApiController (que se usaba como servicio).
 */
class FotaWebService
{
    private const BASE_URI = 'https://api.teltonika.lt';

    private function client(): Client
    {
        return new Client(['base_uri' => self::BASE_URI, 'verify' => false]);
    }

    /**
     * @return object|false
     */
    public function getDevice(string $imei)
    {
        $token = config('app.token_fota_web');

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => self::BASE_URI . '/devices/' . $imei,
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $this->client()->request('GET', self::BASE_URI . '/devices/' . $imei, $parameters);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents());
        }

        return false;
    }

    /**
     * @param array $options imei, model, company_id, group_id, query, query_field, page, per_page, sort, order, activity_status
     * @return object|false
     */
    public function getDevices(array $options = [])
    {
        $token = config('app.token_fota_web');

        $queryParams = [];

        if (!empty($options['imei'])) {
            $queryParams['imei'] = is_array($options['imei']) ? $options['imei'] : [$options['imei']];
        }
        if (!empty($options['model'])) {
            $queryParams['model'] = is_array($options['model']) ? $options['model'] : [$options['model']];
        }
        if (!empty($options['company_id'])) {
            $queryParams['company_id'] = is_array($options['company_id']) ? $options['company_id'] : [$options['company_id']];
        }
        if (!empty($options['group_id'])) {
            $queryParams['group_id'] = is_array($options['group_id']) ? $options['group_id'] : [$options['group_id']];
        }
        if (!empty($options['query'])) {
            $queryParams['query'] = $options['query'];
        }
        if (!empty($options['query_field'])) {
            $queryParams['query_field'] = $options['query_field'];
        }

        $queryParams['page'] = $options['page'] ?? 1;
        $queryParams['per_page'] = min($options['per_page'] ?? 25, 100);

        if (!empty($options['sort'])) {
            $queryParams['sort'] = $options['sort'];
        }
        $queryParams['order'] = $options['order'] ?? 'asc';

        if (isset($options['activity_status'])) {
            $queryParams['activity_status'] = is_array($options['activity_status'])
                ? $options['activity_status']
                : [$options['activity_status']];
        }

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 10,
            'timeout' => 30,
            'query' => $queryParams,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => self::BASE_URI . '/devices',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $this->client()->request('GET', self::BASE_URI . '/devices', $parameters);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents());
        }

        return false;
    }

    /**
     * @param array $imeis
     * @return array{total:int,found:int,not_found:int,devices:array}
     */
    public function syncDevices(array $imeis): array
    {
        $result = [
            'total' => count($imeis),
            'found' => 0,
            'not_found' => 0,
            'devices' => [],
        ];

        $chunks = array_chunk($imeis, 50);

        foreach ($chunks as $chunk) {
            $response = $this->getDevices([
                'imei' => $chunk,
                'per_page' => 50,
            ]);

            if ($response && isset($response->data)) {
                foreach ($response->data as $device) {
                    $result['devices'][] = $device;
                    $result['found']++;
                }
            }
        }

        $result['not_found'] = $result['total'] - $result['found'];

        return $result;
    }

    /**
     * @return array|false
     */
    public function getStats()
    {
        $response = $this->getDevices(['page' => 1, 'per_page' => 1]);

        if ($response) {
            return [
                'total' => $response->total ?? 0,
                'current_page' => $response->current_page ?? 0,
                'last_page' => $response->last_page ?? 0,
                'per_page' => $response->per_page ?? 0,
            ];
        }

        return false;
    }
}
```

> Nota: `getDevice`/`getDevices` no llevan tipo de retorno declarado (solo PHPDoc) a propósito: `json_decode` puede devolver `null` ante JSON inválido y un `: object|false` lanzaría TypeError — se preserva el comportamiento original exacto.

- [ ] **Step 2: `php -l` del servicio**

Run: `php -l app/Services/FotaWebService.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Actualizar `DispositivosIndex`**

En `app/Livewire/Admin/Dispositivos/DispositivosIndex.php`:
- Reemplazar el import `use App\Http\Controllers\Admin\FotaWebApiController;` por `use App\Services\FotaWebService;`.
- En `consultaFota()`, reemplazar `$api = new FotaWebApiController();` por `$api = app(FotaWebService::class);`.
- En `consultarDispositivosNoRegistrados()`, reemplazar `$api = new FotaWebApiController();` por `$api = app(FotaWebService::class);`.

`php -l app/Livewire/Admin/Dispositivos/DispositivosIndex.php` → `No syntax errors detected`.

- [ ] **Step 4: Actualizar `ShowInfo`**

En `app/Livewire/Admin/Dispositivos/ShowInfo.php`:
- Reemplazar `use App\Http\Controllers\Admin\FotaWebApiController;` por `use App\Services\FotaWebService;`.
- Reemplazar `$api = new FotaWebApiController();` por `$api = app(FotaWebService::class);`.

`php -l app/Livewire/Admin/Dispositivos/ShowInfo.php` → ok.

- [ ] **Step 5: Actualizar `Vehiculos\Show`**

En `app/Livewire/Admin/Vehiculos/Show.php`:
- Reemplazar `use App\Http\Controllers\Admin\FotaWebApiController;` por `use App\Services\FotaWebService;`.
- Reemplazar `$api = new FotaWebApiController();` por `$api = app(FotaWebService::class);`.

`php -l app/Livewire/Admin/Vehiculos/Show.php` → ok.

- [ ] **Step 6: Confirmar que no quedan referencias y eliminar el controller**

Run: `grep -rn "FotaWebApiController" app/ routes/`
Expected: SIN resultados (ninguna referencia restante).

Luego eliminar el archivo:
```bash
git rm app/Http/Controllers/Admin/FotaWebApiController.php
```

- [ ] **Step 7: Commit**

```bash
git add app/Services/FotaWebService.php app/Livewire/Admin/Dispositivos/DispositivosIndex.php app/Livewire/Admin/Dispositivos/ShowInfo.php app/Livewire/Admin/Vehiculos/Show.php
git commit -m "refactor(almacen): extraer FotaWebService y eliminar FotaWebApiController"
```

---

## Task 3: Arreglar la exportación de no registrados (#4)

**Files:**
- Modify: `app/Livewire/Admin/Dispositivos/DispositivosIndex.php`

- [ ] **Step 1: Reemplazar el cuerpo de `exportarNoRegistrados`**

Reemplazar TODO el método `exportarNoRegistrados()` por:

```php
    /**
     * Exportar dispositivos no registrados a CSV (descarga directa, sin dejar archivo en disco).
     */
    public function exportarNoRegistrados()
    {
        if (empty($this->dispositivosNoRegistrados)) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'Sin datos',
                mensaje: 'No hay dispositivos para exportar'
            );
            return;
        }

        $filename = 'dispositivos_no_registrados_' . date('Y-m-d_His') . '.csv';
        $dispositivos = $this->dispositivosNoRegistrados;

        return response()->streamDownload(function () use ($dispositivos) {
            $file = fopen('php://output', 'w');

            // BOM para que Excel respete UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['IMEI', 'Serial', 'Modelo', 'Descripción', 'Compañía', 'Última Conexión', 'Firmware', 'Estado']);

            foreach ($dispositivos as $dispositivo) {
                fputcsv($file, [
                    $dispositivo['imei'],
                    $dispositivo['serial'],
                    $dispositivo['modelo'],
                    $dispositivo['descripcion'],
                    $dispositivo['company_name'],
                    $dispositivo['seen_at'],
                    $dispositivo['current_firmware'],
                    $dispositivo['activity_status'],
                ]);
            }

            fclose($file);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
```

> Devuelve la descarga directamente desde la acción Livewire (patrón soportado). Ya no escribe en `storage/app/public` ni expone el archivo. Se elimina el toast 'Exportado' (la descarga es la confirmación).

- [ ] **Step 2: Validar sintaxis**

Run: `php -l app/Livewire/Admin/Dispositivos/DispositivosIndex.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/Admin/Dispositivos/DispositivosIndex.php
git commit -m "fix(almacen): exportar no registrados como descarga directa (sin archivos publicos)"
```

---

## Task 4: Limpieza de código muerto/redundante (#5)

**Files:**
- Modify: `app/Http/Controllers/Admin/GpsController.php`, `app/Livewire/Admin/SimCard/Save.php`, `app/Livewire/Admin/Dispositivos/DispositivosIndex.php`

- [ ] **Step 1: `GpsController::exportExcel` — quitar redirect inalcanzable**

En `app/Http/Controllers/Admin/GpsController.php`, reemplazar:

```php
    public function exportExcel()
    {
        return Excel::download(new DispositivosExport, 'dispositivos.xls');

        redirect()->route('admin.dispositivos.index');
    }
```
por:
```php
    public function exportExcel()
    {
        return Excel::download(new DispositivosExport, 'dispositivos.xls');
    }
```

`php -l app/Http/Controllers/Admin/GpsController.php` → ok.

- [ ] **Step 2: `SimCard\Save` — quitar método vacío**

En `app/Livewire/Admin/SimCard/Save.php`, eliminar el método completo:

```php
    public function updatedItems($value)
    {
        // sin transformación de texto ya que ahora es ID
    }
```

`php -l app/Livewire/Admin/SimCard/Save.php` → ok.

- [ ] **Step 3: `DispositivosIndex` — quitar `render()` manual y `validateDate` sin uso**

En `app/Livewire/Admin/Dispositivos/DispositivosIndex.php`:

a) En `consultaFota()`, eliminar la última línea `$this->render();` (justo antes del cierre `}` del método). Livewire re-renderiza solo tras la acción.

b) Eliminar el método helper sin uso:
```php
    function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
```
(Confirmado sin llamadas dentro de este componente; otros componentes tienen su propia copia.) Tras quitarlo, el `use DateTime;` queda sin uso → eliminar también el import `use DateTime;`.

`php -l app/Livewire/Admin/Dispositivos/DispositivosIndex.php` → ok.

- [ ] **Step 4: Commit**

```bash
git add app/Http/Controllers/Admin/GpsController.php app/Livewire/Admin/SimCard/Save.php app/Livewire/Admin/Dispositivos/DispositivosIndex.php
git commit -m "chore(almacen): quitar codigo muerto (redirect inalcanzable, metodo vacio, render manual, validateDate)"
```

---

## Task 5: Smoke manual (verificación)

No hay tests automatizados (API externa + borrados). Verificar a mano:

- [ ] **Step 1: Info de dispositivo (FotaWebService.getDevice)** — abrir el modal "ver info" de un dispositivo TELTONIKA; debe mostrar datos de Fota como antes.
- [ ] **Step 2: Consultar Fota (getDevices/syncDevices)** — botón de consulta a Fota Web en el index de dispositivos; debe traer/actualizar sin error.
- [ ] **Step 3: Exportar no registrados** — abrir el modal de no registrados con datos y exportar; debe **descargar** el CSV directamente y NO crear archivos en `storage/app/public`.
- [ ] **Step 4: Vehículo Show** — abrir un vehículo con dispositivo principal; el panel de info de Fota debe seguir funcionando.

---

## Notas de ejecución

- Orden: Task 1 → 2 → 3 → 4 → 5.
- `php -l` en cada `.php` tocado antes de commitear.
- Sin `php artisan test` (preferencia del usuario; además no hay tests nuevos).

## Fuera de alcance (decidido en planificación)

- **No** se elimina el listener `protected $listeners = ['render' => 'render']` de `DispositivosIndex`: `dispatch('render')` es una convención global en el código y el beneficio de quitarlo es marginal frente al riesgo. Se difiere.
- Autorización en acciones Livewire, homogenización de validación, `strict_types` masivo, y mover la consulta Fota a un Job (todos fuera de este lote).
