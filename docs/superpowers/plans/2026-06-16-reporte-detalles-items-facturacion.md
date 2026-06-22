# Reporte de Detalles por Ítem — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a line-item-level Excel report ("Reporte de Detalles por Ítem") that can be exported from both the Ventas/Facturación index and the Recibos index, showing one row per detail line (producto or servicio) with full document traceability.

**Architecture:** A single Maatwebsite Excel export class (`ReporteDetallesItemsExport`) queries `VentasDetalle` or `DetalleRecibos` depending on `$contexto` and returns a flat collection of mapped rows. A single shared Livewire component (`App\Livewire\Admin\Reportes\DetallesItems`), mounted once per parent page, follows the existing `App\Livewire\Admin\Reportes\Ventas` pattern: it listens for two distinct dispatched events (one per origin page) to set `$contexto` and open its modal. Two existing index components gain a small trigger method each; two existing index blades gain a trigger button each; two parent layout blades gain the new component's `@livewire(...)` inclusion.

**Tech Stack:** Laravel 12 (Laravel 10 file structure), Livewire 4 (class components, `#[On(...)]` attributes), Maatwebsite Laravel Excel (`FromCollection`, `WithHeadings`, `WithStyles`, `ShouldAutoSize`), WireUI `<x-form.modal.card>`.

**Validation approach:** This project's `php artisan test` runs against the real database (`RefreshDatabase` would wipe production data) and must **never** be run. Validate every PHP file with `php -l` only. No PHPUnit tests are part of this plan. Blade files have no syntax linter available — visually diff against the `Reportes\Ventas` pattern they're copied from.

**Restrictions (apply to every task):**
- Never run `php artisan test` or `php artisan migrate`.
- Validate PHP only with `php -l`.
- No new documentation files beyond this plan/spec.
- Follow existing conventions exactly (see `docs/superpowers/specs/2026-06-16-reporte-detalles-items-facturacion-design.md`).

---

### Task 1: Export class

**Files:**
- Create: `app/Exports/ReporteDetallesItemsExport.php`

- [ ] **Step 1: Write the export class**

```php
<?php

namespace App\Exports;

use App\Models\DetalleRecibos;
use App\Models\VentasDetalle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteDetallesItemsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function __construct(
        public readonly string $contexto,            // 'ventas' | 'recibos'
        public readonly string $fecha_inicio,
        public readonly string $fecha_fin,
        public readonly string $tipo_item,            // 'todos' | 'producto' | 'servicio'
        public readonly string $estado_doc,           // 'todos' | 'COMPLETADO' | 'BORRADOR' | 'anulado'
        public readonly mixed $cliente_id,
        public readonly ?string $tipo_comprobante_id,
    ) {}

    public function collection(): Collection
    {
        return $this->contexto === 'recibos'
            ? $this->fetchRecibos()
            : $this->fetchVentas();
    }

    public function headings(): array
    {
        if ($this->contexto === 'recibos') {
            return [
                'Fecha',
                'Documento',
                'Estado Doc',
                'Cliente',
                'RUC/DNI',
                'Producto',
                'Descripción',
                'Tipo Ítem',
                'Cantidad',
                'Precio',
                'Descuento',
                'Total Línea',
                'Divisa',
                'Estado Pago',
            ];
        }

        return [
            'Fecha',
            'Documento',
            'Tipo Comprobante',
            'Estado Doc',
            'Cliente',
            'RUC/DNI',
            'Cód. Producto',
            'Descripción',
            'Tipo Ítem',
            'Cantidad',
            'V. Unitario',
            'P. Unitario',
            'Descuento',
            'Sub Total',
            'IGV',
            'Total Línea',
            'Divisa',
            'Estado Pago',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function fetchVentas(): Collection
    {
        return VentasDetalle::query()
            ->with(['venta.cliente', 'venta.tipoComprobante', 'producto'])
            ->whereHas('venta', function ($q) {
                $q->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin]);

                match ($this->estado_doc) {
                    'COMPLETADO' => $q->where('estado', 'COMPLETADO')->whereNull('id_baja'),
                    'BORRADOR' => $q->where('estado', 'BORRADOR'),
                    'anulado' => $q->whereNotNull('id_baja'),
                    default => null,
                };

                if ($this->cliente_id) {
                    $q->where('cliente_id', $this->cliente_id);
                }

                if ($this->tipo_comprobante_id) {
                    $q->where('tipo_comprobante_id', $this->tipo_comprobante_id);
                }
            })
            ->when(
                $this->tipo_item !== 'todos',
                fn ($q) => $q->whereHas('producto', fn ($pq) => $pq->where('tipo', $this->tipo_item))
            )
            ->get()
            ->sortBy(fn ($d) => $d->venta->fecha_emision)
            ->map(function (VentasDetalle $d) {
                $venta = $d->venta;
                $isAnulada = ! is_null($venta->id_baja);

                return [
                    $venta->fecha_emision?->format('d/m/Y'),
                    $venta->serie_correlativo,
                    $venta->tipoComprobante->descripcion ?? '',
                    $isAnulada ? 'ANULADA' : $venta->estado->value,
                    $venta->cliente->razon_social ?? '',
                    $venta->cliente->numero_documento ?? '',
                    $d->codigo,
                    $d->descripcion,
                    strtoupper($d->producto->tipo ?? 'N/A'),
                    $d->cantidad,
                    $d->valor_unitario,
                    $d->precio_unitario,
                    $d->descuento,
                    $d->sub_total,
                    $d->igv,
                    $d->total,
                    strtoupper($venta->divisa ?? 'PEN'),
                    $venta->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE',
                ];
            })
            ->values();
    }

    private function fetchRecibos(): Collection
    {
        return DetalleRecibos::query()
            ->with(['recibos.clientes', 'producto'])
            ->whereHas('recibos', function ($q) {
                $q->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin]);

                match ($this->estado_doc) {
                    'COMPLETADO' => $q->where('estado', 'COMPLETADO'),
                    'BORRADOR' => $q->where('estado', 'BORRADOR'),
                    default => null,
                };

                if ($this->cliente_id) {
                    $q->where('clientes_id', $this->cliente_id);
                }
            })
            ->when(
                $this->tipo_item !== 'todos',
                fn ($q) => $q->whereHas('producto', fn ($pq) => $pq->where('tipo', $this->tipo_item))
            )
            ->get()
            ->sortBy(fn ($d) => $d->recibos->fecha_emision)
            ->map(function (DetalleRecibos $d) {
                $recibo = $d->recibos;

                return [
                    $recibo->fecha_emision?->format('d/m/Y'),
                    $recibo->serie . '-' . $recibo->numero,
                    $recibo->estado,
                    $recibo->clientes->razon_social ?? '',
                    $recibo->clientes->numero_documento ?? '',
                    $d->getAttributes()['producto'],
                    $d->descripcion,
                    strtoupper($d->producto->tipo ?? 'N/A'),
                    $d->cantidad,
                    $d->precio,
                    $d->descuento_val,
                    $d->total,
                    strtoupper($recibo->divisa ?? 'PEN'),
                    $recibo->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE',
                ];
            })
            ->values();
    }
}
```

- [ ] **Step 2: Validate syntax**

Run: `php -l app/Exports/ReporteDetallesItemsExport.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Exports/ReporteDetallesItemsExport.php
git commit -m "feat(facturacion): export class for line-item detail report"
```

---

### Task 2: Shared Livewire component

**Files:**
- Create: `app/Livewire/Admin/Reportes/DetallesItems.php`

- [ ] **Step 1: Write the component**

```php
<?php

namespace App\Livewire\Admin\Reportes;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Exports\ReporteDetallesItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class DetallesItems extends Component
{
    public $showModal = false;

    /** ventas | recibos */
    public $contexto = 'ventas';

    public $fecha_inicio;
    public $fecha_fin;

    /** todos | producto | servicio */
    public $tipo_item = 'todos';

    /** todos | COMPLETADO | BORRADOR | anulado */
    public $estado_doc = 'todos';

    public $cliente_id = null;
    public $tipo_comprobante_id = null;

    public function mount(): void
    {
        $this->fecha_inicio = Carbon::today()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin    = Carbon::today()->format('Y-m-d');
    }

    #[On('open-modal-reporte-detalles-ventas')]
    public function openModalVentas(): void
    {
        $this->contexto = 'ventas';
        $this->showModal = true;
    }

    #[On('open-modal-reporte-detalles-recibos')]
    public function openModalRecibos(): void
    {
        $this->contexto = 'recibos';
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.reportes.detalles-items');
    }

    public function exportar()
    {
        $this->validate([
            'fecha_inicio' => 'required',
            'fecha_fin'    => 'required',
        ]);

        $nombre = 'reporte-detalles-' . $this->contexto . '-'
            . $this->fecha_inicio . '_' . $this->fecha_fin . '.xlsx';

        return Excel::download(
            new ReporteDetallesItemsExport(
                $this->contexto,
                $this->fecha_inicio,
                $this->fecha_fin,
                $this->tipo_item,
                $this->estado_doc,
                $this->cliente_id,
                $this->tipo_comprobante_id,
            ),
            $nombre
        );
    }
}
```

- [ ] **Step 2: Validate syntax**

Run: `php -l app/Livewire/Admin/Reportes/DetallesItems.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/Admin/Reportes/DetallesItems.php
git commit -m "feat(facturacion): shared DetallesItems Livewire component"
```

---

### Task 3: Modal blade view

**Files:**
- Create: `resources/views/livewire/admin/reportes/detalles-items.blade.php`

- [ ] **Step 1: Write the blade view**

```blade
<x-form.modal.card :title="'Reporte Detalles por Ítem — ' .
    match ($contexto) {
        'ventas' => 'Ventas',
        'recibos' => 'Recibos',
        default => '',
    }" name="showModal" wire:model.live="showModal" align="center" persistent>

    <div class="grid grid-cols-12 gap-4">

        {{-- ── Fechas ──────────────────────────────────────────────────── --}}
        <div class="col-span-6">
            <x-form.datetime.picker label="Desde:" id="fecha_inicio" name="fecha_inicio" wire:model.live="fecha_inicio"
                :min="now()->subYears(5)" :max="now()->addYears(1)" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>
        <div class="col-span-6">
            <x-form.datetime.picker label="Hasta:" id="fecha_fin" name="fecha_fin" wire:model.live="fecha_fin"
                :min="$fecha_inicio" :max="now()->addYears(1)" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>

        {{-- ── Tipo de ítem ────────────────────────────────────────────── --}}
        <div class="col-span-12 sm:col-span-6">
            <x-form.select label="Tipo de ítem:" id="tipo_item" name="tipo_item" :options="[
                ['name' => 'Todos', 'id' => 'todos'],
                ['name' => 'Producto', 'id' => 'producto'],
                ['name' => 'Servicio', 'id' => 'servicio'],
            ]" option-label="name" option-value="id" wire:model.live="tipo_item" :clearable="false" />
        </div>

        {{-- ── Tipo comprobante (solo contexto ventas) ──────────────────── --}}
        @if ($contexto === 'ventas')
            <div class="col-span-12 sm:col-span-6">
                <x-form.select label="Tipo comprobante:" id="tipo_comprobante_id" name="tipo_comprobante_id"
                    :options="[
                        ['name' => 'FACTURA ELECTRONICA', 'id' => '01'],
                        ['name' => 'BOLETA ELECTRONICA', 'id' => '03'],
                        ['name' => 'N. VENTA ELECTRONICA', 'id' => '02'],
                    ]" placeholder="Todos" option-label="name" option-value="id"
                    wire:model.live="tipo_comprobante_id" clearable />
            </div>
        @endif

        {{-- ── Cliente ─────────────────────────────────────────────────── --}}
        <div @class([
            'col-span-12',
            'sm:col-span-6' => $contexto !== 'ventas',
        ])>
            <x-form.select autocomplete="off" id="cliente_id" name="cliente_id" label="Cliente:"
                wire:model.live="cliente_id" placeholder="Todos" :async-data="[
                    'api' => route('api.clientes.index'),
                    'params' => ['local_id' => session('local_id')],
                ]" option-label="razon_social"
                option-value="id" option-description="numero_documento" clearable />
        </div>

        {{-- ── Estado del documento ────────────────────────────────────── --}}
        <div class="col-span-12">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado del documento:</label>
            <div class="flex flex-wrap gap-4">
                <x-form.radio wire:model.live="estado_doc" value="todos" name="estado_doc" label="Todos" />
                <x-form.radio wire:model.live="estado_doc" value="COMPLETADO" name="estado_doc" label="Completado" />
                <x-form.radio wire:model.live="estado_doc" value="BORRADOR" name="estado_doc" label="Borrador" />
                @if ($contexto === 'ventas')
                    <x-form.radio wire:model.live="estado_doc" value="anulado" name="estado_doc" label="Anulado" />
                @endif
            </div>
        </div>

        {{-- ── Exportar ─────────────────────────────────────────────────── --}}
        <div class="col-span-12 flex justify-center pt-2">
            <x-form.button icon="arrow-down-tray" primary label="Descargar Excel" wire:click.prevent="exportar"
                spinner="exportar" />
        </div>

    </div>

    <x-slot name="footer" class="flex justify-between gap-x-4">
        <x-form.button flat label="Cerrar" x-on:click="close" />
    </x-slot>

</x-form.modal.card>
```

- [ ] **Step 2: Sanity-check blade syntax**

There's no `php -l` equivalent for Blade. Confirm every `@if` has a matching `@endif` by eye (there are two `@if`/`@endif` pairs above) and that the file matches the structure of `resources/views/livewire/admin/reportes/ventas.blade.php`.

- [ ] **Step 3: Commit**

```bash
git add resources/views/livewire/admin/reportes/detalles-items.blade.php
git commit -m "feat(facturacion): modal view for DetallesItems report"
```

---

### Task 4: Trigger method in Ventas/Facturación index

**Files:**
- Modify: `app/Livewire/Admin/Facturacion/Ventas/Index.php:249-252`

- [ ] **Step 1: Add the new method right after `openModalReporteVentas()`**

Find:
```php
    public function openModalReporteVentas()
    {
        $this->dispatch('open-modal-reporte-ventas');
    }
}
```

Replace with:
```php
    public function openModalReporteVentas()
    {
        $this->dispatch('open-modal-reporte-ventas');
    }

    public function openModalReporteDetallesVentas()
    {
        $this->dispatch('open-modal-reporte-detalles-ventas');
    }
}
```

- [ ] **Step 2: Validate syntax**

Run: `php -l app/Livewire/Admin/Facturacion/Ventas/Index.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/Admin/Facturacion/Ventas/Index.php
git commit -m "feat(facturacion): trigger method for line-item report in Ventas index"
```

---

### Task 5: Trigger method in Recibos index

**Files:**
- Modify: `app/Livewire/Admin/Ventas/Recibos/RecibosIndex.php:133-136`

- [ ] **Step 1: Add the new method right after `OpenModalReporte()`**

Find:
```php
    public function OpenModalReporte()
    {
        $this->dispatch('openModalReporte');
    }
```

Replace with:
```php
    public function OpenModalReporte()
    {
        $this->dispatch('openModalReporte');
    }

    public function OpenModalReporteDetalles()
    {
        $this->dispatch('open-modal-reporte-detalles-recibos');
    }
```

- [ ] **Step 2: Validate syntax**

Run: `php -l app/Livewire/Admin/Ventas/Recibos/RecibosIndex.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/Admin/Ventas/Recibos/RecibosIndex.php
git commit -m "feat(facturacion): trigger method for line-item report in Recibos index"
```

---

### Task 6: Button in Ventas/Facturación index view

**Files:**
- Modify: `resources/views/livewire/admin/facturacion/ventas/index.blade.php:31-50`

- [ ] **Step 1: Add a new button right after the existing "REPORTE VENTAS" button**

Find (lines 49-51):
```blade
                <span class="hidden xs:block ml-2 text-xs">REPORTE VENTAS</span>
            </button>

            <!-- Right side -->
```

Replace with:
```blade
                <span class="hidden xs:block ml-2 text-xs">REPORTE VENTAS</span>
            </button>

            <button wire:click.prevent="openModalReporteDetallesVentas()" type="button"
                class="btn bg-sky-500 hover:bg-sky-600 dark:bg-sky-700 dark:hover:bg-sky-800 text-white">
                <svg class="w-5 h-5 fill-current shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="#fff"
                        d="M3 3a1 1 0 011-1h4a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V3zM10 9a1 1 0 011-1h4a1 1 0 011 1v12a1 1 0 01-1 1h-4a1 1 0 01-1-1V9zM17 13a1 1 0 011-1h4a1 1 0 011 1v8a1 1 0 01-1 1h-4a1 1 0 01-1-1v-8z" />
                </svg>
                <span class="hidden xs:block ml-2 text-xs">REPORTE POR ÍTEM</span>
            </button>

            <!-- Right side -->
```

- [ ] **Step 2: Visual sanity check**

No `php -l` equivalent for Blade. Confirm the new `<button>` opens and closes correctly and sits between the existing report button and the `<!-- Right side -->` comment.

- [ ] **Step 3: Commit**

```bash
git add resources/views/livewire/admin/facturacion/ventas/index.blade.php
git commit -m "feat(facturacion): add line-item report button to Ventas index"
```

---

### Task 7: Button in Recibos index view

**Files:**
- Modify: `resources/views/livewire/admin/ventas/recibos/recibos-index.blade.php:60-67`

- [ ] **Step 1: Add a new button right after the existing "Descargar Reporte" button**

Find (lines 60-67):
```blade
            @can('reportes-recibos')
                <div class="relative inline-flex">

                    <x-form.button wire:click="OpenModalReporte" spinner="OpenModalReporte" label="Descargar Reporte"
                        positive md icon="arrow-down-tray" />

                </div>
            @endcan
```

Replace with:
```blade
            @can('reportes-recibos')
                <div class="relative inline-flex">

                    <x-form.button wire:click="OpenModalReporte" spinner="OpenModalReporte" label="Descargar Reporte"
                        positive md icon="arrow-down-tray" />

                </div>
                <div class="relative inline-flex">

                    <x-form.button wire:click="OpenModalReporteDetalles" spinner="OpenModalReporteDetalles"
                        label="Reporte por Ítem" positive md icon="arrow-down-tray" />

                </div>
            @endcan
```

- [ ] **Step 2: Visual sanity check**

Confirm the `@can`/`@endcan` block now wraps two sibling `<div>`s, each containing one `<x-form.button>`.

- [ ] **Step 3: Commit**

```bash
git add resources/views/livewire/admin/ventas/recibos/recibos-index.blade.php
git commit -m "feat(facturacion): add line-item report button to Recibos index"
```

---

### Task 8: Mount the shared component on both parent pages

**Files:**
- Modify: `resources/views/admin/comprobantes/index.blade.php`
- Modify: `resources/views/admin/ventas/recibos/index.blade.php`

- [ ] **Step 1: Update `resources/views/admin/comprobantes/index.blade.php`**

Find:
```blade
<x-admin-layout>
    @livewire('admin.facturacion.ventas.index')
    @livewire('admin.facturacion.ventas.anular-comprobante', [], key('anular-comprobante'))
    @livewire('admin.facturacion.utiles.consulta-cdr', [], key('consulta-comprobante'))
    @livewire('admin.reportes.ventas')
    @livewire('admin.shared.pagos-modal')
</x-admin-layout>
```

Replace with:
```blade
<x-admin-layout>
    @livewire('admin.facturacion.ventas.index')
    @livewire('admin.facturacion.ventas.anular-comprobante', [], key('anular-comprobante'))
    @livewire('admin.facturacion.utiles.consulta-cdr', [], key('consulta-comprobante'))
    @livewire('admin.reportes.ventas')
    @livewire('admin.reportes.detalles-items')
    @livewire('admin.shared.pagos-modal')
</x-admin-layout>
```

- [ ] **Step 2: Update `resources/views/admin/ventas/recibos/index.blade.php`**

Find:
```blade
<x-admin-layout ruta="ventas-recibos">
    @livewire('admin.ventas.recibos.recibos-index')
    @livewire('admin.reportes.ventas')
    @livewire('admin.ventas.recibos.send')
    @livewire('admin.ventas.recibos.eliminar-recibo')
    @livewire('admin.ventas.recibos.confirmar-estado-recibo')
    @livewire('admin.shared.pagos-modal')
</x-admin-layout>
```

Replace with:
```blade
<x-admin-layout ruta="ventas-recibos">
    @livewire('admin.ventas.recibos.recibos-index')
    @livewire('admin.reportes.ventas')
    @livewire('admin.reportes.detalles-items')
    @livewire('admin.ventas.recibos.send')
    @livewire('admin.ventas.recibos.eliminar-recibo')
    @livewire('admin.ventas.recibos.confirmar-estado-recibo')
    @livewire('admin.shared.pagos-modal')
</x-admin-layout>
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/admin/comprobantes/index.blade.php resources/views/admin/ventas/recibos/index.blade.php
git commit -m "feat(facturacion): mount DetallesItems report component on parent pages"
```

---

### Task 9: Full syntax sweep

**Files:** all PHP files touched in Tasks 1, 2, 4, 5

- [ ] **Step 1: Run `php -l` over every modified/created PHP file**

```bash
php -l app/Exports/ReporteDetallesItemsExport.php
php -l app/Livewire/Admin/Reportes/DetallesItems.php
php -l app/Livewire/Admin/Facturacion/Ventas/Index.php
php -l app/Livewire/Admin/Ventas/Recibos/RecibosIndex.php
```

Expected: `No syntax errors detected` for all four.

- [ ] **Step 2: Manual smoke test (browser)**

Since this feature has UI components, manually verify in the browser per CLAUDE.md guidance:
1. Open the Ventas/Facturación index, click "REPORTE POR ÍTEM", set a date range, click "Descargar Excel" — confirm an `.xlsx` downloads with ventas-specific columns (18 columns including Tipo Comprobante, V. Unitario, P. Unitario, IGV).
2. Open the Recibos index, click "Reporte por Ítem", set a date range, click "Descargar Excel" — confirm an `.xlsx` downloads with recibos-specific columns (14 columns, no Tipo Comprobante/IGV).
3. Confirm the "Anulado" radio option only appears in the ventas context.
4. Confirm the "Tipo comprobante" select only appears in the ventas context.

- [ ] **Step 3: Final commit if any fixes were needed during smoke test**

```bash
git add -A
git commit -m "fix(facturacion): smoke-test fixes for line-item report"
```

(Skip this step if no fixes were needed.)

---

## Self-Review Notes

- **Spec coverage:** All 4 sections of the spec (Export class, Livewire component, view integration, modal blade) map to Tasks 1-3 (creation) and 4-8 (integration). The "fuera del alcance" items (combined report, period grouping, on-screen preview) are correctly absent from this plan.
- **Type/signature consistency:** `ReporteDetallesItemsExport` constructor order (`contexto, fecha_inicio, fecha_fin, tipo_item, estado_doc, cliente_id, tipo_comprobante_id`) matches exactly between Task 1 (class definition) and Task 2 (`exportar()` call site).
- **Naming conflict handled:** `fetchRecibos()` uses `$d->getAttributes()['producto']` (not `$d->producto`) to read the text column instead of the eager-loaded `Productos` relation, per the documented Eloquent attribute-resolution order.
- **No placeholders:** every step contains complete, runnable code — no "add error handling" or "similar to Task N" shortcuts.
