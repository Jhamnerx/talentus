# Añadir placa heredando configuración — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Permitir añadir una o varias placas nuevas a un cliente existente desde el listado de cobros, heredando su configuración (plan, periodo, divisa, tipo de comprobante, monto, descuento) sin re-teclear.

**Architecture:** Se reusa el modal Livewire `RegistrarFlota`. Se añade un botón "+ Añadir placa" en la cabecera de cliente del listado que dispara `abrirRegistrarFlota` con `clienteId`. El componente gana un modo "heredar" que prellena la config desde el último cobro activo del cliente y lista solo las placas sin cobro. Sin cambios de base de datos; `guardar()` no se toca.

**Tech Stack:** Laravel 12, Livewire 4, WireUI, Tailwind CSS v4, Blade.

**Pruebas:** Por decisión del usuario y por falta de BD de pruebas segura (phpunit usaría el MySQL real), **solo validación con `php -l` + prueba manual en el navegador**. No se escribe feature test.

---

## File Structure

- **Modify:** `app/Livewire/Admin/Cobros/RegistrarFlota.php`
  - `abrir(?int $clienteId = null)`: acepta cliente opcional → modo heredar.
  - `cargarVehiculosDisponibles()`: nuevo helper privado, lista vehículos del cliente excluyendo los que ya tienen cobro ACTIVO/SUSPENDIDO.
  - `prefillDesdeCliente(int $clienteId)`: nuevo helper privado, hereda config del último cobro activo.
  - `updatedClienteId()`: usa el helper compartido.
- **Modify:** `resources/views/livewire/admin/cobros/index.blade.php`
  - Botón "+ Añadir placa" en la fila-cabecera del cliente (`$showClienteHeader`).
- **Modify:** `resources/views/livewire/admin/cobros/registrar-flota.blade.php`
  - Texto del aviso cuando no hay placas pendientes.

---

## Task 1: Modo "heredar" en RegistrarFlota

**Files:**
- Modify: `app/Livewire/Admin/Cobros/RegistrarFlota.php`

Contexto: el componente ya importa `App\Enums\CobroEstado`, `App\Models\Cobros`, `App\Models\Vehiculos`, `Carbon\Carbon`. No se requieren imports nuevos.

- [ ] **Step 1: Refactorizar `updatedClienteId()` para usar un helper compartido**

Reemplazar el método actual ([RegistrarFlota.php:85-96](../../../app/Livewire/Admin/Cobros/RegistrarFlota.php#L85-L96)):

```php
    public function updatedClienteId(): void
    {
        $this->vehiculo_ids = [];

        if ($this->cliente_id) {
            $this->vehiculos = Vehiculos::where('clientes_id', $this->cliente_id)
                ->orderBy('placa')
                ->get(['id', 'placa', 'marca', 'modelo']);
        } else {
            $this->vehiculos = collect();
        }
    }
```

por:

```php
    public function updatedClienteId(): void
    {
        $this->vehiculo_ids = [];
        $this->cargarVehiculosDisponibles();
    }

    /**
     * Carga los vehículos del cliente seleccionado que aún NO tienen un cobro
     * ACTIVO o SUSPENDIDO (es decir, las placas disponibles para registrar).
     */
    private function cargarVehiculosDisponibles(): void
    {
        if (!$this->cliente_id) {
            $this->vehiculos = collect();
            return;
        }

        $vehiculosConCobro = Cobros::query()
            ->where('clientes_id', $this->cliente_id)
            ->whereIn('estado', [CobroEstado::ACTIVO, CobroEstado::SUSPENDIDO])
            ->pluck('vehiculos_id')
            ->filter()
            ->all();

        $this->vehiculos = Vehiculos::where('clientes_id', $this->cliente_id)
            ->whereNotIn('id', $vehiculosConCobro)
            ->orderBy('placa')
            ->get(['id', 'placa', 'marca', 'modelo']);
    }
```

- [ ] **Step 2: Cambiar la firma de `abrir()` a modo heredar opcional**

Reemplazar el método actual ([RegistrarFlota.php:72-83](../../../app/Livewire/Admin/Cobros/RegistrarFlota.php#L72-L83)):

```php
    public function abrir(): void
    {
        $this->loadPlanes();
        $this->reset(['cliente_id', 'vehiculo_ids', 'plan_id', 'monto', 'descuento', 'nota']);
        $this->vehiculos        = collect();
        $this->periodo          = 'MENSUAL';
        $this->divisa           = 'PEN';
        $this->tipo_comprobante = 'FACTURA';
        $this->fecha_inicio     = Carbon::today()->format('Y-m-d');
        $this->fecha_fin        = Carbon::today()->addMonthNoOverflow()->format('Y-m-d');
        $this->modalOpen        = true;
    }
```

por:

```php
    public function abrir(?int $clienteId = null): void
    {
        $this->loadPlanes();
        $this->reset(['cliente_id', 'vehiculo_ids', 'plan_id', 'monto', 'descuento', 'nota']);
        $this->vehiculos        = collect();
        $this->periodo          = 'MENSUAL';
        $this->divisa           = 'PEN';
        $this->tipo_comprobante = 'FACTURA';
        $this->fecha_inicio     = Carbon::today()->format('Y-m-d');
        $this->fecha_fin        = Carbon::today()->addMonthNoOverflow()->format('Y-m-d');

        if ($clienteId) {
            $this->prefillDesdeCliente($clienteId);
        }

        $this->modalOpen = true;
    }

    /**
     * Modo "Añadir placa": fija el cliente, carga sus placas disponibles y hereda
     * la configuración de su último cobro ACTIVO (si existe). Todo queda editable.
     */
    private function prefillDesdeCliente(int $clienteId): void
    {
        $this->cliente_id = $clienteId;
        $this->cargarVehiculosDisponibles();

        $ultimoCobro = Cobros::activos()
            ->where('clientes_id', $clienteId)
            ->latest('id')
            ->first();

        if (!$ultimoCobro) {
            return;
        }

        $this->plan_id          = $ultimoCobro->plan_id;
        $this->periodo          = $ultimoCobro->periodo ?? 'MENSUAL';
        $this->divisa           = $ultimoCobro->divisa ?? 'PEN';
        $this->tipo_comprobante = $ultimoCobro->tipo_pago ?? 'FACTURA';
        $this->monto            = (float) ($ultimoCobro->monto ?? 0);
        $this->descuento        = (float) ($ultimoCobro->descuento ?? 0);
        $this->nota             = $ultimoCobro->nota;
        $this->fecha_fin        = $this->calcularFechaFin($this->fecha_inicio, $this->periodo);
    }
```

- [ ] **Step 3: Validar sintaxis**

Run: `php -l app/Livewire/Admin/Cobros/RegistrarFlota.php`
Expected: `No syntax errors detected in app/Livewire/Admin/Cobros/RegistrarFlota.php`

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/Cobros/RegistrarFlota.php
git commit -m "feat(cobros): modo heredar en RegistrarFlota al añadir placa"
```

---

## Task 2: Botón "+ Añadir placa" en la cabecera de cliente

**Files:**
- Modify: `resources/views/livewire/admin/cobros/index.blade.php`

- [ ] **Step 1: Reemplazar la fila-cabecera del cliente**

Reemplazar el bloque actual ([index.blade.php:507-529](../../../resources/views/livewire/admin/cobros/index.blade.php#L507-L529)):

```blade
                                @if ($showClienteHeader)
                                    <tr
                                        class="bg-indigo-100 dark:bg-indigo-900/40 border-t-2 border-indigo-200 dark:border-indigo-700">
                                        <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-2">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="font-bold text-sm text-indigo-900 dark:text-indigo-100">
                                                    {{ $clienteNombre }}
                                                </span>
                                                @if ($clienteContacto)
                                                    <span class="text-xs text-indigo-700 dark:text-indigo-300">
                                                        • {{ $clienteContacto }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
```

por:

```blade
                                @if ($showClienteHeader)
                                    <tr
                                        class="bg-indigo-100 dark:bg-indigo-900/40 border-t-2 border-indigo-200 dark:border-indigo-700">
                                        <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-2">
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <span class="font-bold text-sm text-indigo-900 dark:text-indigo-100">
                                                        {{ $clienteNombre }}
                                                    </span>
                                                    @if ($clienteContacto)
                                                        <span class="text-xs text-indigo-700 dark:text-indigo-300">
                                                            • {{ $clienteContacto }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @can('admin.cobros.create')
                                                    <button
                                                        wire:click="$dispatch('abrirRegistrarFlota', { clienteId: {{ $cobro->clientes_id }} })"
                                                        class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-700 dark:text-indigo-200 hover:text-indigo-900 dark:hover:text-white bg-white/70 dark:bg-indigo-800/50 hover:bg-white dark:hover:bg-indigo-700 border border-indigo-300 dark:border-indigo-600 rounded-md px-2 py-1 transition"
                                                        title="Añadir placa a este cliente heredando su configuración">
                                                        <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 16 16">
                                                            <path
                                                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                                        </svg>
                                                        Añadir placa
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endif
```

- [ ] **Step 2: Validar que el blade compila (sin error de sintaxis Blade)**

Run: `php artisan view:clear`
Expected: `INFO  Compiled views cleared successfully.` (no excepción al limpiar; el siguiente render compilará la vista)

- [ ] **Step 3: Commit**

```bash
git add resources/views/livewire/admin/cobros/index.blade.php
git commit -m "feat(cobros): boton '+ Anadir placa' en cabecera de cliente"
```

---

## Task 3: Aviso de "sin placas pendientes" en el modal de flota

**Files:**
- Modify: `resources/views/livewire/admin/cobros/registrar-flota.blade.php`

- [ ] **Step 1: Actualizar el texto del aviso**

Reemplazar ([registrar-flota.blade.php:20-22](../../../resources/views/livewire/admin/cobros/registrar-flota.blade.php#L20-L22)):

```blade
            @elseif ($cliente_id && $vehiculos->isEmpty())
                <p class="text-xs text-amber-500 mt-1">Este cliente no tiene vehículos registrados.</p>
            @endif
```

por:

```blade
            @elseif ($cliente_id && $vehiculos->isEmpty())
                <p class="text-xs text-amber-500 mt-1">Este cliente no tiene placas pendientes de registrar (todas ya tienen un cobro activo o suspendido).</p>
            @endif
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/livewire/admin/cobros/registrar-flota.blade.php
git commit -m "feat(cobros): aviso de placas pendientes en modal de flota"
```

---

## Task 4: Verificación manual end-to-end

**Files:** ninguno (solo verificación).

- [ ] **Step 1: Compilar estilos (por si hay clases Tailwind nuevas)**

Run: `npm run build`
Expected: build completa sin errores. (Si se está usando `npm run dev`, no hace falta.)

- [ ] **Step 2: Abrir el listado de cobros**

Navegar a la ruta `admin.cobros.index` (Cobros Recurrentes). Verificar que cada grupo de cliente
muestra el botón **"+ Añadir placa"** a la derecha de la cabecera.

- [ ] **Step 3: Heredar config (cliente con flota activa)**

En un cliente que ya tenga al menos un cobro ACTIVO y al menos un vehículo sin cobro:
clic en "+ Añadir placa". Verificar que el modal abre con:
- Cliente fijado.
- Plan, Período, Divisa, Tipo comprobante, Monto y Descuento iguales a los de su último cobro activo.
- El select de vehículos muestra **solo** placas sin cobro (no aparecen las que ya tienen uno).

- [ ] **Step 4: Guardar y comprobar**

Marcar una o más placas → "Registrar N vehículo(s)". Verificar el toast de éxito y que las nuevas
placas aparecen en el listado del cliente con su período PENDIENTE. Seleccionarlas y usar
"Cobrar seleccionados" para confirmar que entran al flujo de facturación normal.

- [ ] **Step 5: Casos borde**

- Cliente **sin** cobro previo: "+ Añadir placa" abre el modal en blanco con el cliente fijado.
- Cliente con **todas** las placas ya con cobro: el select queda vacío y aparece el aviso
  "no tiene placas pendientes de registrar".
- Botón **"Registrar flota"** del toolbar superior: sigue abriendo el modal en blanco (sin regresión).

- [ ] **Step 6 (si todo OK): no hay commit adicional** — los cambios ya están commiteados en Tasks 1–3.

---

## Notas

- `guardar()`, `rules()`, `calcularMonto()` y `calcularFechaFin()` **no se modifican**.
- Sin cambios de esquema/migraciones.
- Limpieza relacionada fuera de alcance: `App\Livewire\Admin\Ventas\Contratos\Index::createCobro()`
  quedó muerto tras el refactor de junio 2026 (usa columnas inexistentes). Anotar para limpieza futura.
