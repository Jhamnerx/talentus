# Cliente 360° · SP#1 Dashboard Base — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Página completa "Cliente 360°" (solo lectura) que agrega en una sola pantalla los datos ya existentes del cliente: header ejecutivo, vehículos con estado GPS en vivo, documentos (contratos/certificados/actas/cert. velocímetro), resumen comercial y timeline de actividad.

**Architecture:** Sigue el patrón ya establecido en el proyecto para pantallas "show" (`Route::controller` + vista wrapper `<x-admin-layout>@livewire(...)</x-admin-layout>` + componente Livewire con binding automático de modelo). El estado GPS se obtiene de un `GpswoxService` nuevo que llama a la API externa con cache de 60s.

**Tech Stack:** Laravel 12, Livewire 4, TailwindCSS, Spatie Permission, Spatie Activitylog, paquete `jhamnerx/gpswox-api` (ya instalado).

> **Restricción de validación (igual que sesiones anteriores):** NUNCA ejecutar `php artisan test`. Verificación de cada archivo PHP es `php -l <archivo>`.

**Spec:** `docs/superpowers/specs/2026-06-18-cliente-360-sp1-dashboard-base-design.md`

---

## File Structure

- Modify `database/seeders/PermisosSeeder.php` — agregar permiso `ver-cliente-360`
- Modify `app/Models/Clientes.php` — agregar `certificados()`, `actas()`, `certVelocimetros()` vía `hasManyThrough` (corrige relación rota)
- Create `app/Services/Gpswox/GpswoxService.php`
- Modify `app/Http/Controllers/Admin/ClientesController.php` — método `show360`
- Modify `routes/web.php` — ruta `admin.clientes.show360`
- Create `resources/views/admin/clientes/show360.blade.php` — vista wrapper
- Create `app/Livewire/Admin/Clientes/Client360Dashboard.php`
- Create `resources/views/livewire/admin/clientes/client360-dashboard.blade.php`
- Modify `resources/views/livewire/admin/clientes/clientes-index.blade.php` — botón "360°"

---

## Task 1: Permiso `ver-cliente-360`

**Files:**

- Modify: `database/seeders/PermisosSeeder.php`

- [ ] **Step 1: Añadir el permiso al seeder (para futuros entornos que lo ejecuten desde cero)**

Busca en `database/seeders/PermisosSeeder.php`:

```php
            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'cambiar.estado-cliente',
            'eliminar-cliente',
            'exportar-cliente',
            'importar-cliente',
```

Reemplaza por:

```php
            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'cambiar.estado-cliente',
            'eliminar-cliente',
            'exportar-cliente',
            'importar-cliente',
            'ver-cliente-360',
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l database/seeders/PermisosSeeder.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Crear el permiso en la base de datos actual (el seeder no es re-ejecutable, ya creó los roles/permisos iniciales)**

Run: `php artisan tinker --execute="echo Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'ver-cliente-360', 'guard_name' => 'web'])->id;"`
Expected: imprime un ID numérico (sin error)

- [ ] **Step 4: Commit**

```bash
git add database/seeders/PermisosSeeder.php
git commit -m "feat(cliente-360): permiso ver-cliente-360"
```

> Nota para el reporte final al usuario: el permiso queda creado pero **sin asignar a ningún rol** — el usuario debe asignarlo manualmente desde la pantalla de gestión de roles existente a quien corresponda.

---

## Task 2: Corregir relaciones de documentos en `Clientes`

**Files:**

- Modify: `app/Models/Clientes.php`

- [ ] **Step 1: Añadir el import de `HasManyThrough`**

Busca:

```php
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
```

Reemplaza por:

```php
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
```

- [ ] **Step 2: Reemplazar la relación `certificados()` rota y añadir `actas()`/`certVelocimetros()`**

Busca:

```php
    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'certificados_id');
    }
```

Reemplaza por:

```php
    public function certificados(): HasManyThrough
    {
        return $this->hasManyThrough(Certificados::class, Vehiculos::class, 'clientes_id', 'vehiculos_id');
    }

    public function actas(): HasManyThrough
    {
        return $this->hasManyThrough(Actas::class, Vehiculos::class, 'clientes_id', 'vehiculos_id');
    }

    public function certVelocimetros(): HasManyThrough
    {
        return $this->hasManyThrough(CertificadosVelocimetros::class, Vehiculos::class, 'clientes_id', 'vehiculos_id');
    }
```

> La relación anterior usaba `'certificados_id'` como FK, columna que no existe en la tabla `certificados` (la FK real es `vehiculos_id`) — por eso nunca devolvía resultados. `hasManyThrough` usa la tabla `vehiculos` como intermedia: `clientes_id` es la FK en `vehiculos` que apunta a `Clientes`, `vehiculos_id` es la FK en `certificados`/`actas`/`certificados_velocimetros` que apunta a `vehiculos`.

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Models/Clientes.php`
Expected: `No syntax errors detected`

- [ ] **Step 4: Verificación funcional rápida (solo lectura, no toca la BD)**

Run: `php artisan tinker --execute="
\$c = App\Models\Clientes::has('vehiculos')->first();
if (\$c) { echo 'cliente='.\$c->id.' certificados='.\$c->certificados()->count().' actas='.\$c->actas()->count().' certVelocimetros='.\$c->certVelocimetros()->count(); } else { echo 'sin clientes con vehiculos para probar'; }
"`
Expected: imprime los 3 conteos sin error (los números pueden ser 0, lo importante es que no lance excepción)

- [ ] **Step 5: Commit**

```bash
git add app/Models/Clientes.php
git commit -m "fix(cliente-360): corregir relacion certificados() rota y agregar actas()/certVelocimetros() via hasManyThrough"
```

---

## Task 3: `GpswoxService`

**Files:**

- Create: `app/Services/Gpswox/GpswoxService.php`

- [ ] **Step 1: Crear el Service**

```php
<?php

namespace App\Services\Gpswox;

use Gpswox\Wox;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class GpswoxService
{
    private Wox $client;

    public function __construct()
    {
        $this->client = new Wox(
            config('services.gpswox.base_uri'),
            config('services.gpswox.api_hash')
        );
    }

    /**
     * Devuelve el estado más reciente (online/offline, velocidad, última
     * señal) de los dispositivos indicados, cacheado 60s por cliente.
     * En caso de error de la API externa, retorna un array vacío en vez
     * de propagar la excepción — el llamador debe tratar la ausencia de
     * datos como "estado no disponible", no como un fallo de la página.
     *
     * @param  array<int, int>  $gpswoxIds
     * @return array<string, mixed> indexado por device id (string)
     */
    public function getLatestStatusForDevices(int $clienteId, array $gpswoxIds): array
    {
        if (empty($gpswoxIds)) {
            return [];
        }

        return Cache::remember("gpswox.latest.{$clienteId}", 60, function () use ($gpswoxIds) {
            try {
                $response = $this->client->request('GET', 'api/get_devices_latest', [
                    'query' => [
                        'filters' => [
                            'id' => implode(',', $gpswoxIds),
                        ],
                    ],
                ]);

                $items = $response['items'] ?? [];

                return collect($items)->keyBy(fn ($item) => (string) ($item['id'] ?? ''))->all();
            } catch (Throwable $e) {
                Log::warning('GpswoxService: error consultando get_devices_latest', [
                    'cliente_id' => $clienteId,
                    'error' => $e->getMessage(),
                ]);

                return [];
            }
        });
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Services/Gpswox/GpswoxService.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Services/Gpswox/GpswoxService.php
git commit -m "feat(cliente-360): GpswoxService con cache 60s y degradacion ante error de API"
```

---

## Task 4: Controller, ruta y vista wrapper

**Files:**

- Modify: `app/Http/Controllers/Admin/ClientesController.php`
- Modify: `routes/web.php`
- Create: `resources/views/admin/clientes/show360.blade.php`

- [ ] **Step 1: Añadir el método al controller**

El contenido actual completo de `app/Http/Controllers/Admin/ClientesController.php` es:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientesRequest;
use App\Models\Clientes;
use App\Models\Flotas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cliente', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.clientes.index');
    }


    public function exportExcel()
    {
        return Excel::download(new ClientesExport, 'clientes.xls');
    }
}
```

Reemplázalo por:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientesRequest;
use App\Models\Clientes;
use App\Models\Flotas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cliente', ['only' => ['index']]);
        $this->middleware('permission:ver-cliente-360', ['only' => ['show360']]);
    }

    public function index()
    {
        return view('admin.clientes.index');
    }

    public function show360(Clientes $cliente)
    {
        return view('admin.clientes.show360', ['cliente' => $cliente]);
    }


    public function exportExcel()
    {
        return Excel::download(new ClientesExport, 'clientes.xls');
    }
}
```

- [ ] **Step 2: Añadir la ruta**

Busca en `routes/web.php`:

```php
    Route::controller(ClientesController::class)->group(function () {

        Route::get('clientes', 'index')->name('admin.clientes.index');
        // Route::post('clientes', 'store')->name('admin.clientes.store');
        //Route::get('clientes/crear', 'create')->name('admin.clientes.create');
        //Route::get('clientes/{cliente}', 'show')->name('admin.clientes.show');
        // Route::put('clientes/{cliente}', 'update')->name('admin.clientes.updated');
        //Route::get('clientes/{cliente}/editar', 'edit')->name('admin.clientes.edit');
```

Reemplaza por:

```php
    Route::controller(ClientesController::class)->group(function () {

        Route::get('clientes', 'index')->name('admin.clientes.index');
        Route::get('clientes/{cliente}/360', 'show360')->name('admin.clientes.show360');
        // Route::post('clientes', 'store')->name('admin.clientes.store');
        //Route::get('clientes/crear', 'create')->name('admin.clientes.create');
        //Route::get('clientes/{cliente}', 'show')->name('admin.clientes.show');
        // Route::put('clientes/{cliente}', 'update')->name('admin.clientes.updated');
        //Route::get('clientes/{cliente}/editar', 'edit')->name('admin.clientes.edit');
```

- [ ] **Step 3: Crear la vista wrapper**

```blade
<x-admin-layout>

    @livewire('admin.clientes.client360-dashboard', ['cliente' => $cliente])

</x-admin-layout>
```

- [ ] **Step 4: Verificar sintaxis y registro de la ruta**

Run: `php -l app/Http/Controllers/Admin/ClientesController.php && php -l routes/web.php`
Expected: dos `No syntax errors detected`

Run: `php artisan route:list --name=admin.clientes.show360`
Expected: aparece la ruta `GET clientes/{cliente}/360` con nombre `admin.clientes.show360`

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/Admin/ClientesController.php routes/web.php resources/views/admin/clientes/show360.blade.php
git commit -m "feat(cliente-360): ruta y controller show360"
```

> Esta tarea referencia el componente Livewire `admin.clientes.client360-dashboard`, que se crea en la Task 5. La ruta funcionará una vez completada esa tarea.

---

## Task 5: Componente Livewire `Client360Dashboard` (lógica)

**Files:**

- Create: `app/Livewire/Admin/Clientes/Client360Dashboard.php`

- [ ] **Step 1: Crear el componente**

```php
<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Clientes;
use App\Models\User;
use App\Services\Gpswox\GpswoxService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Client360Dashboard extends Component
{
    public Clientes $cliente;

    public function render()
    {
        $this->cliente->loadMissing([
            'vehiculos',
            'contratos',
        ]);

        return view('livewire.admin.clientes.client360-dashboard', [
            'ejecutivo' => $this->ejecutivoAsignado(),
            'vehiculosConGps' => $this->vehiculosConEstadoGps(),
            'certificados' => $this->cliente->certificados()->latest('fecha_instalacion')->limit(20)->get(),
            'actas' => $this->cliente->actas()->latest('fecha_instalacion')->limit(20)->get(),
            'certVelocimetros' => $this->cliente->certVelocimetros()->limit(20)->get(),
            'contratos' => $this->cliente->contratos,
            'resumenComercial' => $this->resumenComercial(),
            'timeline' => $this->timeline(),
        ]);
    }

    private function ejecutivoAsignado(): ?User
    {
        if (! $this->cliente->user_id) {
            return null;
        }

        return User::find($this->cliente->user_id);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function vehiculosConEstadoGps(): array
    {
        $vehiculos = $this->cliente->vehiculos;

        $gpswoxIds = $vehiculos->pluck('gpswox_id')->filter()->values()->all();

        $estados = app(GpswoxService::class)->getLatestStatusForDevices($this->cliente->id, $gpswoxIds);

        return $vehiculos->map(function ($vehiculo) use ($estados) {
            $estado = $estados[(string) $vehiculo->gpswox_id] ?? null;

            return [
                'vehiculo' => $vehiculo,
                'online' => $estado['online'] ?? null,
                'speed' => $estado['speed'] ?? null,
                'time' => $estado['time'] ?? null,
            ];
        })->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function resumenComercial(): array
    {
        $totalFacturado = (float) $this->cliente->ventas()->sum('total');
        $totalPagado = (float) $this->cliente->ventas()->paid()->sum('total');
        $deudaPendiente = (float) $this->cliente->ventas()->unPaid()->sum('total');
        $cantidadVentas = $this->cliente->ventas()->count();
        $ultimaVenta = $this->cliente->ventas()->latest('fecha_emision')->first();

        return [
            'total_facturado' => $totalFacturado,
            'total_pagado' => $totalPagado,
            'deuda_pendiente' => $deudaPendiente,
            'ticket_promedio' => $cantidadVentas > 0 ? $totalFacturado / $cantidadVentas : 0.0,
            'ultima_venta' => $ultimaVenta,
            'total_recibos' => $this->cliente->recibos()->count(),
            'cobros_activos' => $this->cliente->cobros()->count(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection<int, Activity>
     */
    private function timeline()
    {
        $vehiculoIds = $this->cliente->vehiculos->pluck('id')->all();
        $contratoIds = $this->cliente->contratos->pluck('id')->all();

        return Activity::query()
            ->where(function ($query) use ($vehiculoIds, $contratoIds) {
                $query->where(function ($q) {
                    $q->where('subject_type', Clientes::class)
                        ->where('subject_id', $this->cliente->id);
                });

                if (! empty($vehiculoIds)) {
                    $query->orWhere(function ($q) use ($vehiculoIds) {
                        $q->where('subject_type', \App\Models\Vehiculos::class)
                            ->whereIn('subject_id', $vehiculoIds);
                    });
                }

                if (! empty($contratoIds)) {
                    $query->orWhere(function ($q) use ($contratoIds) {
                        $q->where('subject_type', \App\Models\Contratos::class)
                            ->whereIn('subject_id', $contratoIds);
                    });
                }
            })
            ->latest()
            ->limit(50)
            ->get();
    }
}
```

> `$this->cliente` se inyecta automáticamente por Livewire 4 vía binding de ruta/modelo, gracias al type-hint `public Clientes $cliente` (mismo patrón que `app/Livewire/Admin/Vehiculos/Show.php`).

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Livewire/Admin/Clientes/Client360Dashboard.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/Admin/Clientes/Client360Dashboard.php
git commit -m "feat(cliente-360): componente Client360Dashboard (logica)"
```

---

## Task 6: Vista del dashboard — Header, vehículos/GPS, documentos

**Files:**

- Create: `resources/views/livewire/admin/clientes/client360-dashboard.blade.php`

- [ ] **Step 1: Crear la vista con el header ejecutivo, panel de vehículos+GPS y panel de documentos**

```blade
<div class="p-4 sm:p-6 space-y-6">

    {{-- ── Header ejecutivo ──────────────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $cliente->razon_social }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $cliente->numero_documento }}</p>
            </div>
            <div class="flex flex-wrap gap-4 text-sm">
                <div>
                    <span class="block text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wide">Estado</span>
                    <span class="font-medium {{ $cliente->is_active ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $cliente->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div>
                    <span class="block text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wide">Fecha de alta</span>
                    <span class="font-medium text-gray-700 dark:text-gray-200">{{ $cliente->created_at?->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="block text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wide">Ejecutivo asignado</span>
                    <span class="font-medium text-gray-700 dark:text-gray-200">{{ $ejecutivo?->name ?? 'Sin asignar' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Panel de vehículos + GPS ──────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">
            Vehículos ({{ count($vehiculosConGps) }})
        </h2>
        @if (count($vehiculosConGps) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500 border-b border-gray-200 dark:border-gray-800">
                            <th class="py-2 pr-4">Placa</th>
                            <th class="py-2 pr-4">Marca / Modelo</th>
                            <th class="py-2 pr-4">Estado GPS</th>
                            <th class="py-2 pr-4">Velocidad</th>
                            <th class="py-2 pr-4">Última señal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculosConGps as $row)
                            <tr wire:key="veh-{{ $row['vehiculo']->id }}" class="border-b border-gray-100 dark:border-gray-800/60">
                                <td class="py-2 pr-4 font-medium text-gray-800 dark:text-gray-100">{{ $row['vehiculo']->placa }}</td>
                                <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">{{ $row['vehiculo']->marca }} {{ $row['vehiculo']->modelo }}</td>
                                <td class="py-2 pr-4">
                                    @if ($row['online'] === null)
                                        <span class="text-gray-400">No disponible</span>
                                    @elseif ($row['online'] === 'true' || $row['online'] === true)
                                        <span class="text-emerald-600">🟢 Transmitiendo</span>
                                    @else
                                        <span class="text-rose-600">🔴 Desconectado</span>
                                    @endif
                                </td>
                                <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">{{ $row['speed'] !== null ? $row['speed'].' km/h' : '—' }}</td>
                                <td class="py-2 pr-4 text-gray-600 dark:text-gray-300">{{ $row['time'] ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-400">Sin vehículos registrados.</p>
        @endif
    </div>

    {{-- ── Panel de documentos ───────────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Documentos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Contratos</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $contratos->count() }}</p>
            </div>
            <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Certificados GPS</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $certificados->count() }}</p>
            </div>
            <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Actas</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $actas->count() }}</p>
            </div>
            <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Cert. Velocímetro</p>
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $certVelocimetros->count() }}</p>
            </div>
        </div>
    </div>

    @include('livewire.admin.clientes.partials.client360-comercial-timeline')
</div>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/livewire/admin/clientes/client360-dashboard.blade.php
git commit -m "feat(cliente-360): vista dashboard - header, vehiculos+gps, documentos"
```

> Esta vista incluye `livewire.admin.clientes.partials.client360-comercial-timeline`, creado en la Task 7. Hasta entonces, la página fallará al renderizar — eso se completa en la siguiente tarea.

---

## Task 7: Vista del dashboard — Resumen comercial y timeline

**Files:**

- Create: `resources/views/livewire/admin/clientes/partials/client360-comercial-timeline.blade.php`

- [ ] **Step 1: Crear el partial**

```blade
{{-- ── Resumen comercial ─────────────────────────────────────────── --}}
<div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Resumen comercial</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Total facturado</p>
            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">S/ {{ number_format($resumenComercial['total_facturado'], 2) }}</p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Total pagado</p>
            <p class="text-base font-semibold text-emerald-600">S/ {{ number_format($resumenComercial['total_pagado'], 2) }}</p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Deuda pendiente</p>
            <p class="text-base font-semibold {{ $resumenComercial['deuda_pendiente'] > 0 ? 'text-rose-600' : 'text-gray-800 dark:text-gray-100' }}">
                S/ {{ number_format($resumenComercial['deuda_pendiente'], 2) }}
            </p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Ticket promedio</p>
            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">S/ {{ number_format($resumenComercial['ticket_promedio'], 2) }}</p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Última compra</p>
            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                {{ $resumenComercial['ultima_venta']?->fecha_emision?->format('d/m/Y') ?? '—' }}
            </p>
        </div>
        <div class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
            <p class="text-xs text-gray-400 uppercase tracking-wide">Cobros activos</p>
            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ $resumenComercial['cobros_activos'] }}</p>
        </div>
    </div>
</div>

{{-- ── Timeline ───────────────────────────────────────────────────── --}}
<div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Actividad reciente</h2>
    @if ($timeline->isNotEmpty())
        <ol class="relative border-l border-gray-200 dark:border-gray-800 ml-2 space-y-4">
            @foreach ($timeline as $event)
                <li wire:key="activity-{{ $event->id }}" class="ml-4">
                    <div class="absolute w-2 h-2 bg-emerald-500 rounded-full -left-1 mt-1.5"></div>
                    <time class="text-xs text-gray-400">{{ $event->created_at->format('d/m/Y H:i') }}</time>
                    <p class="text-sm text-gray-700 dark:text-gray-200">
                        {{ $event->description }}
                        <span class="text-gray-400">— {{ class_basename($event->subject_type) }}</span>
                    </p>
                </li>
            @endforeach
        </ol>
    @else
        <p class="text-sm text-gray-400">Sin actividad registrada.</p>
    @endif
</div>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/livewire/admin/clientes/partials/client360-comercial-timeline.blade.php
git commit -m "feat(cliente-360): vista dashboard - resumen comercial y timeline"
```

---

## Task 8: Botón "360°" en el listado de clientes

**Files:**

- Modify: `resources/views/livewire/admin/clientes/clientes-index.blade.php`

- [ ] **Step 1: Añadir el botón, antes del botón "Editar cliente"**

Busca:

```blade
                                        {{-- Editar cliente --}}
                                        @can('editar-cliente')
                                            <button wire:click.prevent='openModalEdit({{ $cliente->id }})'
                                                title="Editar"
                                                class="p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                <span class="sr-only">Editar</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
```

Reemplaza por:

```blade
                                        {{-- Cliente 360° --}}
                                        @can('ver-cliente-360')
                                            <a href="{{ route('admin.clientes.show360', $cliente->id) }}" wire:navigate
                                                title="Cliente 360°"
                                                class="p-1.5 rounded-lg text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-colors">
                                                <span class="sr-only">Cliente 360°</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        {{-- Editar cliente --}}
                                        @can('editar-cliente')
                                            <button wire:click.prevent='openModalEdit({{ $cliente->id }})'
                                                title="Editar"
                                                class="p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                <span class="sr-only">Editar</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/livewire/admin/clientes/clientes-index.blade.php
git commit -m "feat(cliente-360): boton de acceso en listado de clientes"
```

---

## Task 9: Verificación manual end-to-end

**Files:** _(ninguno)_

- [ ] **Step 1: Confirmar que el permiso existe y asignarlo a tu usuario/rol de prueba**

Run: `php artisan tinker --execute="
\$p = Spatie\Permission\Models\Permission::where('name','ver-cliente-360')->first();
echo \$p ? 'permiso existe, id='.\$p->id : 'FALTA crear el permiso (revisar Task 1)';
"`
Expected: `permiso existe, id=N`

Si tu usuario de prueba no lo tiene, asígnalo desde la pantalla de gestión de roles existente, o vía:
Run: `php artisan tinker --execute="App\Models\User::find(<tu_user_id>)->givePermissionTo('ver-cliente-360');"`

- [ ] **Step 2: Abrir el listado de clientes en el navegador**

Visita `/admin/clientes` (o la URL real del panel admin), confirma que aparece el nuevo ícono "Cliente 360°" en la fila de un cliente con vehículos.

- [ ] **Step 3: Abrir el dashboard de un cliente con vehículos y GPSWox configurado**

Haz clic en el ícono — debe navegar a `/clientes/{id}/360` sin error 500, mostrando header, panel de vehículos (con o sin estado GPS según conectividad real), documentos, resumen comercial y timeline.

- [ ] **Step 4: Verificar que un cliente SIN vehículos/documentos/ventas no rompe la página**

Abre el 360° de un cliente sin vehículos — el panel debe mostrar "Sin vehículos registrados" en vez de error.

- [ ] **Step 5: Verificar degradación si GPSWox falla**

Si tienes forma de simularlo (ej. cambiar temporalmente `GPSWOX_API_HASH` en `.env` a un valor inválido y reiniciar), confirma que la columna de estado GPS muestra "No disponible" en vez de romper la página. Revertir el cambio en `.env` después de probar.

- [ ] **Step 6: Sin commit** (esta tarea no produce archivos)

---

## Self-Review (completado al escribir el plan)

- **Cobertura del spec:** Página completa nueva (Task 4), permiso `ver-cliente-360` (Task 1), `GpswoxService` con cache 60s y degradación ante error (Task 3), relaciones `certificados()`/`actas()`/`certVelocimetros()` corregidas (Task 2), todos los paneles del dashboard (Tasks 6-7), botón de acceso en listado (Task 8). Fuera de alcance respetado: sin scoring, sin evaluaciones, sin comentarios nuevos, sin relación `usuario()`/`ejecutivo()` en el modelo.
- **Placeholders:** ninguno; todo el código está completo, verificado contra los archivos reales del proyecto (`ClientesController`, `Clientes.php`, `Vehiculos.php`, `Ventas.php` con sus scopes `paid()`/`unPaid()` reales, patrón `show.blade.php` de Vehículos).
- **Consistencia de tipos:** `Client360Dashboard::$cliente` (Clientes, binding automático) coincide con `@livewire('admin.clientes.client360-dashboard', ['cliente' => $cliente])` en la vista wrapper (Task 4) y con el parámetro `Clientes $cliente` del controller (Task 4). Las claves del array `resumenComercial` usadas en la vista (Task 7: `total_facturado`, `total_pagado`, `deuda_pendiente`, `ticket_promedio`, `ultima_venta`, `cobros_activos`) coinciden exactamente con las claves devueltas por `resumenComercial()` en el componente (Task 5). La estructura de `$vehiculosConGps` (`vehiculo`, `online`, `speed`, `time`) usada en la vista (Task 6) coincide con lo que arma `vehiculosConEstadoGps()` (Task 5).
