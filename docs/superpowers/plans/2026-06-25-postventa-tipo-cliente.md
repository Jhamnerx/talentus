# Plantillas post-venta por tipo de cliente — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Resolver la plantilla post-venta por (sector × tipo de cliente: nuevo/recurrente/ambos), con un umbral de antigüedad configurable por empresa, sin romper el comportamiento actual.

**Architecture:** Se agrega `tipo_cliente` a `postventa_plantillas` (default `ambos`) y `postventa_dias_cliente_nuevo` a `empresas`. La clasificación del cliente vive en `Clientes::tipoPostventa()`. El job existente `EnviarMensajeClienteJob::resolverPlantilla()` calcula el tipo y resuelve la plantilla con fallback. El CRUD de plantillas gana un selector de tipo y se añade un pequeño componente para el umbral.

**Tech Stack:** Laravel 12, Livewire 4, Blade, MySQL.

**Pruebas:** **Solo prueba manual** (sin BD de pruebas segura; phpunit usaría el MySQL real). Validación: `php artisan migrate` (aditivo y reversible), `php -l`, verificación con `tinker` de la clasificación, y navegador. No se escribe feature test.

---

## File Structure

- **Create:** 2 migraciones (`postventa_plantillas.tipo_cliente`, `empresas.postventa_dias_cliente_nuevo`).
- **Modify:** `app/Models/Clientes.php` — método `tipoPostventa()`.
- **Modify:** `app/Jobs/EnviarMensajeClienteJob.php` — `resolverPlantilla()` por tipo + import `Empresa`.
- **Modify:** `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php` + `save.blade.php` — selector tipo_cliente.
- **Modify:** `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php` + `edit.blade.php` — selector tipo_cliente.
- **Modify:** `resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php` — badge tipo.
- **Create:** `app/Livewire/Admin/Ajustes/Postventa/ConfiguracionPostventa.php` + `configuracion-postventa.blade.php` — input umbral.
- **Modify:** `resources/views/admin/ajustes/postventa.blade.php` — embeber configuración.

---

## Task 1: Migraciones (BD)

**Files:**
- Create: `database/migrations/<ts>_add_tipo_cliente_to_postventa_plantillas_table.php`
- Create: `database/migrations/<ts>_add_postventa_dias_cliente_nuevo_to_empresas_table.php`

- [ ] **Step 1: Generar las migraciones**

Run:
```
php artisan make:migration add_tipo_cliente_to_postventa_plantillas_table --no-interaction
php artisan make:migration add_postventa_dias_cliente_nuevo_to_empresas_table --no-interaction
```
Expected: dos archivos creados en `database/migrations/`.

- [ ] **Step 2: Contenido de la migración de `postventa_plantillas`**

Reemplazar el cuerpo de la migración `..._add_tipo_cliente_to_postventa_plantillas_table.php`:

```php
public function up(): void
{
    Schema::table('postventa_plantillas', function (Blueprint $table) {
        $table->enum('tipo_cliente', ['nuevo', 'recurrente', 'ambos'])
            ->default('ambos')
            ->after('sector_id');
    });
}

public function down(): void
{
    Schema::table('postventa_plantillas', function (Blueprint $table) {
        $table->dropColumn('tipo_cliente');
    });
}
```

- [ ] **Step 3: Contenido de la migración de `empresas`**

Reemplazar el cuerpo de la migración `..._add_postventa_dias_cliente_nuevo_to_empresas_table.php`:

```php
public function up(): void
{
    Schema::table('empresas', function (Blueprint $table) {
        $table->unsignedSmallInteger('postventa_dias_cliente_nuevo')->default(30);
    });
}

public function down(): void
{
    Schema::table('empresas', function (Blueprint $table) {
        $table->dropColumn('postventa_dias_cliente_nuevo');
    });
}
```

- [ ] **Step 4: Aplicar (migración aditiva, segura — NO usar migrate:fresh)**

Run: `php artisan migrate --no-interaction`
Expected: ambas migraciones corren con `DONE`. (Solo agrega columnas; no borra datos.)

- [ ] **Step 5: Commit**

```bash
git add database/migrations
git commit -m "feat(postventa): columnas tipo_cliente y umbral dias cliente nuevo"
```

---

## Task 2: Clasificación del cliente (`Clientes::tipoPostventa`)

**Files:**
- Modify: `app/Models/Clientes.php`

Contexto: `vehiculos()` ya usa `withoutGlobalScope(EmpresaScope::class)` (seguro en cola) pero incluye `withTrashed()`; por eso se usa `->withoutTrashed()` para contar solo vehículos no eliminados. `created_at` es Carbon por defecto.

- [ ] **Step 1: Agregar el método**

Insertar este método dentro de la clase `Clientes` (por ejemplo, justo después de la relación `sector()` en [Clientes.php:113](../../../app/Models/Clientes.php#L113)):

```php
    /**
     * Clasifica al cliente para la mensajería post-venta.
     * NUEVO: tiene exactamente 1 vehículo no eliminado Y se registró hace <= $umbralDias.
     * RECURRENTE: cualquier otro caso.
     */
    public function tipoPostventa(int $umbralDias): string
    {
        $esPrimerVehiculo = $this->vehiculos()->withoutTrashed()->count() === 1;

        $recienRegistrado = $this->created_at !== null
            && $this->created_at->gte(now()->subDays($umbralDias));

        return ($esPrimerVehiculo && $recienRegistrado) ? 'nuevo' : 'recurrente';
    }
```

- [ ] **Step 2: Validar sintaxis**

Run: `php -l app/Models/Clientes.php`
Expected: `No syntax errors detected in app/Models/Clientes.php`

- [ ] **Step 3: Verificación rápida con tinker (read-only)**

Run (ajusta el ID a un cliente real):
```
php artisan tinker --execute='$c = App\Models\Clientes::withoutGlobalScopes()->find(1); echo $c?->tipoPostventa(30);'
```
Expected: imprime `nuevo` o `recurrente` sin error.

- [ ] **Step 4: Commit**

```bash
git add app/Models/Clientes.php
git commit -m "feat(postventa): Clientes::tipoPostventa para clasificar nuevo/recurrente"
```

---

## Task 3: Resolución por tipo en el job

**Files:**
- Modify: `app/Jobs/EnviarMensajeClienteJob.php`

- [ ] **Step 1: Agregar import de `Empresa`**

En la zona de `use` de [EnviarMensajeClienteJob.php](../../../app/Jobs/EnviarMensajeClienteJob.php) añadir:

```php
use App\Models\Empresa;
```

- [ ] **Step 2: Reemplazar `resolverPlantilla()`**

Reemplazar el método actual ([EnviarMensajeClienteJob.php:107-137](../../../app/Jobs/EnviarMensajeClienteJob.php#L107-L137)) por:

```php
    private function resolverPlantilla(WorkOrder $workOrder): ?PostventaPlantilla
    {
        $empresaId = $workOrder->empresa_id;

        $umbral = (int) (Empresa::withoutGlobalScopes()
            ->whereKey($empresaId)
            ->value('postventa_dias_cliente_nuevo') ?? 30);

        $tipo = $workOrder->cliente?->tipoPostventa($umbral) ?? 'recurrente';

        $sectorId = null;
        if ($workOrder->sector) {
            $nombre   = trim(explode(',', $workOrder->sector)[0]);
            $sectorId = Sector::withoutGlobalScopes()
                ->where('empresa_id', $empresaId)
                ->where('nombre', $nombre)
                ->value('id');
        }

        // Orden de preferencia: sector+tipo, sector+ambos, default+tipo, default+ambos.
        $candidatos = [];
        if ($sectorId !== null) {
            $candidatos[] = ['sector_id' => $sectorId, 'tipo_cliente' => $tipo];
            $candidatos[] = ['sector_id' => $sectorId, 'tipo_cliente' => 'ambos'];
        }
        $candidatos[] = ['sector_id' => null, 'tipo_cliente' => $tipo];
        $candidatos[] = ['sector_id' => null, 'tipo_cliente' => 'ambos'];

        foreach ($candidatos as $criterio) {
            $query = PostventaPlantilla::withoutGlobalScopes()
                ->where('empresa_id', $empresaId)
                ->where('tipo_cliente', $criterio['tipo_cliente'])
                ->where('activo', true);

            if ($criterio['sector_id'] === null) {
                $query->whereNull('sector_id');
            } else {
                $query->where('sector_id', $criterio['sector_id']);
            }

            $plantilla = $query->first();
            if ($plantilla) {
                return $plantilla;
            }
        }

        return null;
    }
```

- [ ] **Step 3: Validar sintaxis**

Run: `php -l app/Jobs/EnviarMensajeClienteJob.php`
Expected: `No syntax errors detected in app/Jobs/EnviarMensajeClienteJob.php`

- [ ] **Step 4: Commit**

```bash
git add app/Jobs/EnviarMensajeClienteJob.php
git commit -m "feat(postventa): resolver plantilla por sector y tipo de cliente con fallback"
```

---

## Task 4: Selector tipo_cliente en `Save`

**Files:**
- Modify: `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php`
- Modify: `resources/views/livewire/admin/ajustes/postventa/plantillas/save.blade.php`

- [ ] **Step 1: Propiedad + reglas + create en `Save.php`**

En [Save.php](../../../app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php):

1. Tras `public bool $activo = true;` (línea 17) añadir:
```php
    public string  $tipo_cliente = 'ambos';
```

2. En `open()` (después de `$this->reset();`, línea 24) añadir para garantizar el default:
```php
        $this->tipo_cliente = 'ambos';
```

3. En `rules()` añadir la regla (junto a las demás):
```php
            'tipo_cliente' => 'required|in:nuevo,recurrente,ambos',
```

4. En `save()`, dentro del array de `PostventaPlantilla::create([...])`, añadir:
```php
            'tipo_cliente' => $validated['tipo_cliente'],
```

- [ ] **Step 2: Selector en `save.blade.php`**

En [save.blade.php](../../../resources/views/livewire/admin/ajustes/postventa/plantillas/save.blade.php), inmediatamente después del bloque `<div class="col-span-12">…Sector…</div>` (cierra en la línea 17), insertar:

```blade
                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">Tipo de cliente</label>
                    <select wire:model.live="tipo_cliente" class="form-select w-full">
                        <option value="ambos">Ambos (nuevo y recurrente)</option>
                        <option value="nuevo">Cliente nuevo</option>
                        <option value="recurrente">Cliente recurrente</option>
                    </select>
                    @error('tipo_cliente')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
```

- [ ] **Step 3: Validar sintaxis**

Run: `php -l app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php`
Expected: `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php resources/views/livewire/admin/ajustes/postventa/plantillas/save.blade.php
git commit -m "feat(postventa): selector tipo de cliente al crear plantilla"
```

---

## Task 5: Selector tipo_cliente en `Edit`

**Files:**
- Modify: `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php`
- Modify: `resources/views/livewire/admin/ajustes/postventa/plantillas/edit.blade.php`

- [ ] **Step 1: Propiedad + open + reglas + update en `Edit.php`**

En [Edit.php](../../../app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php):

1. Tras `public bool $activo = true;` (línea 19) añadir:
```php
    public string                $tipo_cliente   = 'ambos';
```

2. En `open()` (tras `$this->activo = $plantilla->activo;`, línea 31) añadir:
```php
        $this->tipo_cliente    = $plantilla->tipo_cliente;
```

3. En `rules()` añadir:
```php
            'tipo_cliente' => 'required|in:nuevo,recurrente,ambos',
```

4. En `update()`, dentro de `$this->plantilla->update([...])`, añadir:
```php
            'tipo_cliente' => $validated['tipo_cliente'],
```

- [ ] **Step 2: Selector en `edit.blade.php`**

En [edit.blade.php](../../../resources/views/livewire/admin/ajustes/postventa/plantillas/edit.blade.php), inmediatamente después del bloque `<div class="col-span-12">…Sector…</div>` (cierra en la línea 17), insertar el MISMO bloque que en Save:

```blade
                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">Tipo de cliente</label>
                    <select wire:model.live="tipo_cliente" class="form-select w-full">
                        <option value="ambos">Ambos (nuevo y recurrente)</option>
                        <option value="nuevo">Cliente nuevo</option>
                        <option value="recurrente">Cliente recurrente</option>
                    </select>
                    @error('tipo_cliente')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
```

- [ ] **Step 3: Validar sintaxis**

Run: `php -l app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php`
Expected: `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php resources/views/livewire/admin/ajustes/postventa/plantillas/edit.blade.php
git commit -m "feat(postventa): selector tipo de cliente al editar plantilla"
```

---

## Task 6: Badge de tipo en el listado

**Files:**
- Modify: `resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php`

- [ ] **Step 1: Mostrar el tipo bajo el sector**

En [index.blade.php](../../../resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php), reemplazar la celda del sector (líneas 39-43):

```blade
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $plantilla->sector?->nombre ?? '— Por defecto —' }}
                                    </span>
                                </td>
```

por:

```blade
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $plantilla->sector?->nombre ?? '— Por defecto —' }}
                                    </div>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                        @if ($plantilla->tipo_cliente === 'nuevo') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                        @elseif ($plantilla->tipo_cliente === 'recurrente') bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400
                                        @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 @endif">
                                        @if ($plantilla->tipo_cliente === 'nuevo') Cliente nuevo
                                        @elseif ($plantilla->tipo_cliente === 'recurrente') Cliente recurrente
                                        @else Ambos @endif
                                    </span>
                                </td>
```

- [ ] **Step 2: Limpiar vistas compiladas**

Run: `php artisan view:clear`
Expected: `INFO  Compiled views cleared successfully.`

- [ ] **Step 3: Commit**

```bash
git add resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php
git commit -m "feat(postventa): mostrar tipo de cliente en el listado de plantillas"
```

---

## Task 7: Configuración del umbral (componente nuevo)

**Files:**
- Create: `app/Livewire/Admin/Ajustes/Postventa/ConfiguracionPostventa.php`
- Create: `resources/views/livewire/admin/ajustes/postventa/configuracion-postventa.blade.php`
- Modify: `resources/views/admin/ajustes/postventa.blade.php`

- [ ] **Step 1: Crear el componente Livewire**

Run: `php artisan make:livewire Admin/Ajustes/Postventa/ConfiguracionPostventa --no-interaction`
Expected: crea la clase y la vista.

- [ ] **Step 2: Contenido de la clase**

Reemplazar `app/Livewire/Admin/Ajustes/Postventa/ConfiguracionPostventa.php` por:

```php
<?php

namespace App\Livewire\Admin\Ajustes\Postventa;

use App\Models\Empresa;
use Livewire\Component;

class ConfiguracionPostventa extends Component
{
    public int $dias = 30;

    public function mount(): void
    {
        $this->dias = (int) (Empresa::find(session('empresa'))?->postventa_dias_cliente_nuevo ?? 30);
    }

    protected function rules(): array
    {
        return [
            'dias' => 'required|integer|min:1|max:3650',
        ];
    }

    public function guardar(): void
    {
        $this->validate();

        $empresa = Empresa::find(session('empresa'));
        if ($empresa) {
            $empresa->postventa_dias_cliente_nuevo = $this->dias;
            $empresa->save();
        }

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'CONFIGURACIÓN GUARDADA',
            mensaje: 'Días para considerar cliente nuevo actualizado.',
        );
    }

    public function render()
    {
        return view('livewire.admin.ajustes.postventa.configuracion-postventa');
    }
}
```

- [ ] **Step 3: Contenido de la vista**

Reemplazar `resources/views/livewire/admin/ajustes/postventa/configuracion-postventa.blade.php` por:

```blade
<div class="mb-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
    <div class="flex flex-col sm:flex-row sm:items-end gap-3">
        <div class="grow">
            <label class="block text-sm font-medium mb-1">Días para considerar cliente nuevo</label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                Un cliente es <strong>nuevo</strong> si tiene 1 solo vehículo y se registró hace este número de días o menos.
            </p>
            <input type="number" min="1" max="3650" wire:model="dias" class="form-input w-32" />
            @error('dias')
                <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <x-form.button primary label="Guardar" wire:click="guardar" spinner="guardar" />
    </div>
</div>
```

- [ ] **Step 4: Embeber en la página de Ajustes → Postventa**

En [postventa.blade.php](../../../resources/views/admin/ajustes/postventa.blade.php), dentro de `<div class="p-6 space-y-6">` (línea 15), añadir como PRIMERA línea (antes del index):

```blade
                        @livewire('admin.ajustes.postventa.configuracion-postventa')
```

- [ ] **Step 5: Validar sintaxis y vistas**

Run:
```
php -l app/Livewire/Admin/Ajustes/Postventa/ConfiguracionPostventa.php
php artisan view:clear
```
Expected: `No syntax errors detected` y `Compiled views cleared successfully.`

- [ ] **Step 6: Commit**

```bash
git add app/Livewire/Admin/Ajustes/Postventa/ConfiguracionPostventa.php resources/views/livewire/admin/ajustes/postventa/configuracion-postventa.blade.php resources/views/admin/ajustes/postventa.blade.php
git commit -m "feat(postventa): configuracion del umbral de dias para cliente nuevo"
```

---

## Task 8: Verificación manual end-to-end

**Files:** ninguno.

- [ ] **Step 1: Compilar estilos**

Run: `npm run build` (o tener `npm run dev` activo).
Expected: build sin errores.

- [ ] **Step 2: Configurar umbral**

Ir a **Ajustes → Postventa**. Verificar el bloque "Días para considerar cliente nuevo", cambiarlo (ej. 30) y Guardar → toast de éxito.

- [ ] **Step 3: Crear plantillas por tipo**

Crear/editar plantillas: confirmar el selector "Tipo de cliente" (Ambos/Nuevo/Recurrente), guardarlas y ver el badge correcto en el listado.

- [ ] **Step 4: Verificar la clasificación (tinker, read-only)**

Run (ajusta IDs reales): 
```
php artisan tinker --execute='$c = App\Models\Clientes::withoutGlobalScopes()->find(1); echo $c->tipoPostventa(30), PHP_EOL, $c->vehiculos()->withoutTrashed()->count();'
```
Expected: imprime el tipo y el conteo de vehículos coherente con la regla.

- [ ] **Step 5: Flujo real**

Cerrar una OT de un cliente que clasifique como `nuevo` y otra de uno `recurrente` (con el worker de colas activo y un Device `es_postventa`), y confirmar que se usó la plantilla del tipo correspondiente (revisar el WhatsApp recibido o el `storage/logs/laravel.log` ante warnings).

- [ ] **Step 6: Fallback / compatibilidad**

Con solo plantillas `ambos` existentes (estado inicial), confirmar que el envío sigue funcionando igual que antes.

---

## Notas

- `handle()` del job no cambia: sigue llamando `resolverPlantilla()` y logueando si es null.
- Sin `migrate:fresh`/`RefreshDatabase` (borraría datos). Solo `php artisan migrate` aditivo.
- `ConfiguracionPostventa` usa asignación directa de atributo (`$empresa->postventa_dias_cliente_nuevo = ...`), que no depende de `$fillable`/`$guarded`.
