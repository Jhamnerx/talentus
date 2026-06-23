# Vehículos — Sync solo no-sincronizados + filtro "No está en plataforma" — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Permitir sincronizar en el modal de flota solo los vehículos sin vínculo en GPSWox, y filtrar en el index los vehículos que no están en la plataforma GPSWox.

**Architecture:** Un scope de Eloquent `Vehiculos::scopeSinSincronizarGpswox()` (con el `OR` agrupado en closure) es la fuente única de la definición "no sincronizado". El modal `SincronizarFlota` gana un toggle `soloNoSincronizados` que aplica el scope al contar y al recorrer; el index `VehiculosIndex` gana una opción de dropdown que aplica el mismo scope.

**Tech Stack:** Laravel 12, Livewire 4, Blade, WireUi, Alpine, PHPUnit 11.

> **Restricción de testing (preferencia del usuario):** NO ejecutar `php artisan test` con `RefreshDatabase` (borra la BD real; `phpunit.xml` apunta a la BD de desarrollo). El test del scope (Task 1) es **sin BD ni factory** (solo `toSql()`), seguro de ejecutar con filtro. Validar todos los archivos con `php -l`.

---

## File Structure

- `app/Models/Vehiculos.php` — **modificar**. Nuevo `scopeSinSincronizarGpswox`.
- `tests/Unit/Models/VehiculosSinSincronizarGpswoxTest.php` — **crear**. Test estructural del scope (sin BD).
- `app/Livewire/Admin/Vehiculos/VehiculosIndex.php` — **modificar**. `when` para `sin_sincronizar`.
- `resources/views/livewire/admin/vehiculos/vehiculos-index.blade.php` — **modificar**. Opción del dropdown.
- `app/Livewire/Admin/Vehiculos/SincronizarFlota.php` — **modificar**. Toggle + `baseQuery` + hook + filtro en `procesarSiguiente`.
- `resources/views/livewire/admin/vehiculos/sincronizar-flota.blade.php` — **modificar**. Checkbox + manejo de total 0.

---

## Task 1: Scope `sinSincronizarGpswox` (TDD, sin BD)

**Files:**
- Modify: `app/Models/Vehiculos.php`
- Test: `tests/Unit/Models/VehiculosSinSincronizarGpswoxTest.php`

- [ ] **Step 1: Escribir el test que falla**

Crear `tests/Unit/Models/VehiculosSinSincronizarGpswoxTest.php`:

```php
<?php

namespace Tests\Unit\Models;

use App\Models\Vehiculos;
use Tests\TestCase;

/**
 * Test estructural del scope (sin BD ni factory): verifica que el OR quede
 * agrupado y combine con otras condiciones como AND (… OR …).
 * toSql() no abre conexión, por lo que es seguro de ejecutar.
 */
class VehiculosSinSincronizarGpswoxTest extends TestCase
{
    public function test_scope_genera_el_or_de_ambas_columnas(): void
    {
        $sql = (new Vehiculos())->newQuery()->sinSincronizarGpswox()->toSql();

        $this->assertStringContainsString('gpswox_id', $sql);
        $this->assertStringContainsString('gpswox_sincronizado_at', $sql);
        $this->assertMatchesRegularExpression('/gpswox_id.*is null\s+or\s+.*gpswox_sincronizado_at.*is null/i', $sql);
    }

    public function test_scope_agrupa_el_or_al_combinar_con_cursor(): void
    {
        $sql = (new Vehiculos())->newQuery()
            ->sinSincronizarGpswox()
            ->where('id', '>', 0)
            ->toSql();

        // El OR va entre paréntesis y el cursor queda como AND posterior.
        $this->assertMatchesRegularExpression('/\([^()]*gpswox_id[^()]*is null\s+or\s+[^()]*gpswox_sincronizado_at[^()]*is null[^()]*\)/i', $sql);
        $this->assertMatchesRegularExpression('/\)\s+and\s+.*id.*>/i', $sql);
    }
}
```

- [ ] **Step 2: Verificar que falla (método inexistente)**

Run: `php artisan test --compact --filter=VehiculosSinSincronizarGpswoxTest`
Expected: FAIL — `Call to undefined method ...::sinSincronizarGpswox()`

> Si la política impide ejecutar el suite, al menos `php -l tests/Unit/Models/VehiculosSinSincronizarGpswoxTest.php` → `No syntax errors detected`. Este test NO toca BD.

- [ ] **Step 3: Implementar el scope**

En `app/Models/Vehiculos.php`, agregar este método (junto a otros scopes/métodos del modelo):

```php
    public function scopeSinSincronizarGpswox($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('gpswox_id')->orWhereNull('gpswox_sincronizado_at');
        });
    }
```

- [ ] **Step 4: Verificar que pasa**

Run: `php artisan test --compact --filter=VehiculosSinSincronizarGpswoxTest`
Expected: PASS (2 tests)
Y: `php -l app/Models/Vehiculos.php` → `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Models/Vehiculos.php tests/Unit/Models/VehiculosSinSincronizarGpswoxTest.php
git commit -m "feat(vehiculos): scope sinSincronizarGpswox"
```

---

## Task 2: Filtro "No está en plataforma" en el index

**Files:**
- Modify: `app/Livewire/Admin/Vehiculos/VehiculosIndex.php`
- Modify: `resources/views/livewire/admin/vehiculos/vehiculos-index.blade.php`

- [ ] **Step 1: Agregar el `when` en `render()`**

En `app/Livewire/Admin/Vehiculos/VehiculosIndex.php`, en el query de `render()`, localizar:

```php
            ->when($this->gpswox_filter === 'activo', fn($q) => $q->where('gpswox_active', true))
            ->when($this->gpswox_filter === 'inactivo', fn($q) => $q->where('gpswox_active', false))
```

y agregar inmediatamente debajo:

```php
            ->when($this->gpswox_filter === 'sin_sincronizar', fn($q) => $q->sinSincronizarGpswox())
```

- [ ] **Step 2: Agregar la opción al dropdown**

En `resources/views/livewire/admin/vehiculos/vehiculos-index.blade.php`, localizar:

```blade
                    <option value="">Todos</option>
                    <option value="activo">Activo en plataforma</option>
                    <option value="inactivo">Inactivo en plataforma</option>
```

y agregar debajo de la línea `inactivo`:

```blade
                    <option value="sin_sincronizar">No está en plataforma</option>
```

- [ ] **Step 3: Validar sintaxis**

Run: `php -l app/Livewire/Admin/Vehiculos/VehiculosIndex.php`
Expected: `No syntax errors detected`
(La vista Blade no se lintea con `php -l`; se valida en QA manual.)

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/Vehiculos/VehiculosIndex.php resources/views/livewire/admin/vehiculos/vehiculos-index.blade.php
git commit -m "feat(vehiculos): filtro 'No esta en plataforma' en index"
```

---

## Task 3: Toggle "Solo no sincronizados" en el modal

**Files:**
- Modify: `app/Livewire/Admin/Vehiculos/SincronizarFlota.php`
- Modify: `resources/views/livewire/admin/vehiculos/sincronizar-flota.blade.php`

- [ ] **Step 1: Añadir propiedad y helper en el componente**

En `app/Livewire/Admin/Vehiculos/SincronizarFlota.php`:

a) Agregar la propiedad junto a las demás (después de `public int $noEncontradosCount = 0;`):

```php
    public bool $soloNoSincronizados = false;
```

b) Agregar un helper privado para la query base según el modo (antes de `render()`):

```php
    private function baseQuery()
    {
        return Vehiculos::query()
            ->when($this->soloNoSincronizados, fn ($q) => $q->sinSincronizarGpswox());
    }
```

c) Agregar el hook que recalcula el total al cambiar el toggle (antes de iniciar):

```php
    public function updatedSoloNoSincronizados(): void
    {
        $this->total = $this->baseQuery()->count();
    }
```

- [ ] **Step 2: Usar `baseQuery` en `abrir`, `iniciar` y resetear el toggle**

En `abrir()`, reemplazar:

```php
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount']);
        $this->total     = Vehiculos::count();
```
por:
```php
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount', 'soloNoSincronizados']);
        $this->total     = $this->baseQuery()->count();
```

En `iniciar()`, reemplazar:

```php
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount']);
        $this->total     = Vehiculos::count();
```
por:
```php
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount']);
        $this->total     = $this->baseQuery()->count();
```

> Nota: en `iniciar()` NO se resetea `soloNoSincronizados` (debe respetar lo elegido por el usuario antes de arrancar).

- [ ] **Step 3: Filtrar en `procesarSiguiente`**

En `procesarSiguiente()`, reemplazar:

```php
        $vehiculo = Vehiculos::where('id', '>', $this->lastId)
            ->orderBy('id')
            ->first();
```
por:
```php
        $vehiculo = Vehiculos::query()
            ->when($this->soloNoSincronizados, fn ($q) => $q->sinSincronizarGpswox())
            ->where('id', '>', $this->lastId)
            ->orderBy('id')
            ->first();
```

- [ ] **Step 4: Resetear el toggle en `cerrar`**

En `cerrar()`, reemplazar:

```php
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount', 'total']);
```
por:
```php
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount', 'total', 'soloNoSincronizados']);
```

- [ ] **Step 5: Validar sintaxis del componente**

Run: `php -l app/Livewire/Admin/Vehiculos/SincronizarFlota.php`
Expected: `No syntax errors detected`

- [ ] **Step 6: Actualizar la vista del modal (toggle + total 0)**

En `resources/views/livewire/admin/vehiculos/sincronizar-flota.blade.php`, reemplazar TODO el bloque "Listo para iniciar":

```blade
            {{-- Estado: Listo para iniciar --}}
            @if (! $corriendo && ! $terminado && $total > 0)
                <div class="flex flex-col items-center gap-3 py-4">
                    <svg class="w-16 h-16 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-300 text-center">
                        Se consultará la plataforma GPSWox placa por placa para actualizar
                        <strong>IMEI, SIM y ID</strong> de cada vehículo.
                    </p>
                    <p class="text-sm text-gray-400 dark:text-gray-500">
                        Total de vehículos a procesar: <strong class="text-gray-700 dark:text-gray-200">{{ $total }}</strong>
                    </p>
                    <p class="text-xs text-amber-500 dark:text-amber-400">
                        Este proceso puede tardar varios minutos. No cierre esta ventana.
                    </p>
                </div>
            @endif
```

por:

```blade
            {{-- Estado: Listo para iniciar --}}
            @if (! $corriendo && ! $terminado)
                <div class="flex flex-col items-center gap-3 py-4">
                    <svg class="w-16 h-16 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-300 text-center">
                        Se consultará la plataforma GPSWox placa por placa para actualizar
                        <strong>IMEI, SIM y ID</strong> de cada vehículo.
                    </p>

                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                        <input type="checkbox" wire:model.live="soloNoSincronizados"
                            class="rounded border-gray-300 text-violet-500 focus:ring-violet-400">
                        Solo verificar los que no están en GPSWox / nunca sincronizados
                    </label>

                    @if ($total > 0)
                        <p class="text-sm text-gray-400 dark:text-gray-500">
                            Total de vehículos a procesar: <strong class="text-gray-700 dark:text-gray-200">{{ $total }}</strong>
                        </p>
                        <p class="text-xs text-amber-500 dark:text-amber-400">
                            Este proceso puede tardar varios minutos. No cierre esta ventana.
                        </p>
                    @else
                        <p class="text-sm text-emerald-600 dark:text-emerald-400">
                            No hay vehículos pendientes de sincronizar.
                        </p>
                    @endif
                </div>
            @endif
```

- [ ] **Step 7: Deshabilitar "Iniciar" cuando no hay nada que procesar**

En el mismo archivo, en el `<x-slot name="footer">`, reemplazar el botón de iniciar:

```blade
                    <x-form.button
                        primary
                        icon="arrow-path"
                        label="Iniciar Sincronización"
                        @click="iniciarLoop()"
                    />
```
por:
```blade
                    <x-form.button
                        primary
                        icon="arrow-path"
                        label="Iniciar Sincronización"
                        :disabled="$total === 0"
                        @click="iniciarLoop()"
                    />
```

- [ ] **Step 8: Commit**

```bash
git add app/Livewire/Admin/Vehiculos/SincronizarFlota.php resources/views/livewire/admin/vehiculos/sincronizar-flota.blade.php
git commit -m "feat(vehiculos): toggle 'solo no sincronizados' en sincronizar flota"
```

---

## Task 4: Verificación manual (QA)

Pre-requisito: estar en una ruta del index de vehículos; el servidor GPSWox no es necesario para el filtro, sí para probar la sincronización real.

- [ ] **Step 1: Filtro del index**

1. Abrir el index de vehículos, dropdown "Plataforma" → elegir "No está en plataforma".
2. Esperado: la tabla muestra solo vehículos con `gpswox_id` nulo (o `gpswox_sincronizado_at` nulo). "Limpiar filtros" lo resetea.

- [ ] **Step 2: Modal — total reacciona al toggle**

1. Abrir "Sincronizar Flota". Anotar el total (todos).
2. Marcar "Solo verificar los que no están en GPSWox…".
3. Esperado: el total mostrado baja al número de no-sincronizados. Si es 0, aparece "No hay vehículos pendientes de sincronizar" y el botón "Iniciar" queda deshabilitado.

- [ ] **Step 3: Modal — recorrido filtrado**

1. Con el toggle activo y total > 0, pulsar "Iniciar Sincronización".
2. Esperado: solo procesa los no-sincronizados; la barra llega a 100% sobre ese subconjunto. Cerrar y reabrir deja el toggle en off.

---

## Notas de ejecución

- Orden: Task 1 → 2 → 3 → 4.
- `php -l` en cada `.php` tocado antes de commitear. Las vistas Blade se validan en QA manual (Task 4).
- Único test automatizado: el estructural del scope (Task 1), seguro porque usa `toSql()` sin conexión.
- El factory `VehiculosFactory` depende de SimCard/Flotas/Dispositivos/Empresa sembrados; por eso no se usa un feature test de filtrado con BD aquí (iría como mejora futura en entorno de pruebas dedicado).
