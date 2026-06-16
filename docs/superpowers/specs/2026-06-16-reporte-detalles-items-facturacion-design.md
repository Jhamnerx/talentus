# Reporte de Detalles por Ítem — Facturación

**Fecha:** 2026-06-16
**Rama:** `feature/whatsapp-omnicanal-sp1` (o rama propia)
**Módulo:** Facturación → Ventas / Recibos

---

## Contexto

El reporte general (`ReporteVentasRecibosExport`) trabaja a nivel de **documento** (una fila por factura/recibo). Este nuevo reporte trabaja a nivel de **línea de detalle**: cada ítem dentro de un documento genera una fila en el Excel, permitiendo analizar qué productos o servicios se facturaron, en qué cantidades y a qué clientes.

El caso de uso principal es ver cuántos servicios GPS y cuántos equipos (productos) se facturaron en un período, con trazabilidad completa al documento origen.

---

## Alcance

- Dos reportes independientes: uno desde el índice de **Ventas** (facturas/boletas), otro desde el índice de **Recibos**.
- Salida: descarga de Excel con una sola hoja plana (sin hojas de resumen ni agrupación por período).
- Sin nueva ruta ni nuevo controlador.

**Fuera del alcance:**
- Reporte combinado ventas + recibos en un solo archivo.
- Agrupación por período (mensual/semanal).
- Preview en pantalla antes de exportar.

---

## Archivos afectados

> **Corrección post-exploración:** el proyecto ya tiene un patrón establecido para reportes compartidos entre Ventas y Recibos: `App\Livewire\Admin\Reportes\Ventas` (un único componente Livewire con propiedad `$contexto`, montado en ambas páginas padre vía `@livewire(...)`, que escucha eventos distintos para cada origen). Este reporte sigue el mismo patrón en vez de crear dos componentes separados.

| Acción | Archivo |
|--------|---------|
| Crear | `app/Exports/ReporteDetallesItemsExport.php` |
| Crear | `app/Livewire/Admin/Reportes/DetallesItems.php` (componente único compartido) |
| Crear | `resources/views/livewire/admin/reportes/detalles-items.blade.php` |
| Modificar | `app/Livewire/Admin/Facturacion/Ventas/Index.php` (nuevo método que dispara evento) |
| Modificar | `app/Livewire/Admin/Ventas/Recibos/RecibosIndex.php` (nuevo método que dispara evento) |
| Modificar | `resources/views/livewire/admin/facturacion/ventas/index.blade.php` (botón nuevo) |
| Modificar | `resources/views/livewire/admin/ventas/recibos/recibos-index.blade.php` (botón nuevo) |
| Modificar | `resources/views/admin/comprobantes/index.blade.php` (incluir `@livewire('admin.reportes.detalles-items')`) |
| Modificar | `resources/views/admin/ventas/recibos/index.blade.php` (incluir `@livewire('admin.reportes.detalles-items')`) |

---

## Sección 1: Export class

### `app/Exports/ReporteDetallesItemsExport.php`

Implementa `FromCollection`, `WithHeadings`, `ShouldAutoSize`.

**Constructor:**
```php
public function __construct(
    public readonly string  $contexto,           // 'ventas' | 'recibos'
    public readonly string  $fecha_inicio,
    public readonly string  $fecha_fin,
    public readonly string  $tipo_item,          // 'todos' | 'producto' | 'servicio'
    public readonly string  $estado_doc,         // 'todos' | 'COMPLETADO' | 'BORRADOR' | 'anulado'
    public readonly mixed   $cliente_id,         // nullable
    public readonly ?string $tipo_comprobante_id // nullable, solo ventas
) {}
```

**`collection()`:** Llama a `fetchVentas()` o `fetchRecibos()` según `$contexto` y retorna una `Collection` de arrays planos.

**`headings()`:** Devuelve el array de encabezados según `$contexto` (ver columnas abajo).

---

### Query ventas — `fetchVentas()`

```php
VentasDetalle::query()
    ->with(['venta.cliente', 'venta.tipoComprobante', 'producto'])
    ->whereHas('venta', function ($q) {
        $q->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin]);

        match ($this->estado_doc) {
            'COMPLETADO' => $q->where('estado', 'COMPLETADO')->whereNull('id_baja'),
            'BORRADOR'   => $q->where('estado', 'BORRADOR'),
            'anulado'    => $q->whereNotNull('id_baja'),
            default      => null, // 'todos': sin filtro adicional
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
```

**Mapeo de columnas por fila (ventas):**

| Columna | Fuente |
|---------|--------|
| Fecha | `$d->venta->fecha_emision` (formato d/m/Y) |
| Documento | `$d->venta->serie_correlativo` |
| Tipo Comprobante | `$d->venta->tipoComprobante->descripcion ?? ''` |
| Estado Doc | `id_baja IS NOT NULL` → 'ANULADA'; else `$d->venta->estado` |
| Cliente | `$d->venta->cliente->razon_social ?? ''` |
| RUC/DNI | `$d->venta->cliente->numero_documento ?? ''` |
| Cód. Producto | `$d->codigo` |
| Descripción | `$d->descripcion` |
| Tipo Ítem | `$d->producto->tipo ?? 'N/A'` en mayúsculas |
| Cantidad | `$d->cantidad` |
| V. Unitario | `$d->valor_unitario` |
| P. Unitario | `$d->precio_unitario` |
| Descuento | `$d->descuento` |
| Sub Total | `$d->sub_total` |
| IGV | `$d->igv` |
| Total Línea | `$d->total` |
| Divisa | `strtoupper($d->venta->divisa ?? 'PEN')` |
| Estado Pago | `$d->venta->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE'` |

---

### Query recibos — `fetchRecibos()`

```php
DetalleRecibos::query()
    ->with(['recibos.clientes', 'producto'])
    ->whereHas('recibos', function ($q) {
        $q->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin]);

        match ($this->estado_doc) {
            'COMPLETADO' => $q->where('estado', 'COMPLETADO'),
            'BORRADOR'   => $q->where('estado', 'BORRADOR'),
            default      => null, // 'todos' y 'anulado' no aplican en recibos
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
```

**Mapeo de columnas por fila (recibos):**

| Columna | Fuente |
|---------|--------|
| Fecha | `$d->recibos->fecha_emision` (formato d/m/Y) |
| Documento | `$d->recibos->serie . '-' . $d->recibos->numero` |
| Estado Doc | `$d->recibos->estado` |
| Cliente | `$d->recibos->clientes->razon_social ?? ''` |
| RUC/DNI | `$d->recibos->clientes->numero_documento ?? ''` |
| Producto | `$d->getAttributes()['producto']` (campo texto del detalle) |
| Descripción | `$d->descripcion` |
| Tipo Ítem | `$d->producto->tipo ?? 'N/A'` en mayúsculas (relación Eloquent eager-loaded) |
| Cantidad | `$d->cantidad` |
| Precio | `$d->precio` |
| Descuento | `$d->descuento_val` |
| Total Línea | `$d->total` |
| Divisa | `strtoupper($d->recibos->divisa ?? 'PEN')` |
| Estado Pago | `$d->recibos->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE'` |

> **Nota de naming conflict:** `DetalleRecibos` tiene un campo texto `producto` Y una relación Eloquent `producto()` con el mismo nombre. Cuando se hace eager load con `with('producto')`, acceder a `$d->producto` devuelve el modelo `Productos` (la relación gana). Para el campo texto hay que usar `$d->getAttributes()['producto']`.

---

## Sección 2: Componente Livewire compartido

Sigue el patrón exacto de `App\Livewire\Admin\Reportes\Ventas` (`app/Livewire/Admin/Reportes/Ventas.php`): un único componente con `$contexto`, montado una sola vez en cada página padre, con un `#[On(...)]` por cada evento de origen.

### `app/Livewire/Admin/Reportes/DetallesItems.php`

**Propiedades públicas:**
```php
public bool    $showModal           = false;
public string  $contexto            = 'ventas'; // 'ventas' | 'recibos'
public string  $fecha_inicio        = '';
public string  $fecha_fin           = '';
public string  $tipo_item           = 'todos';  // 'todos' | 'producto' | 'servicio'
public string  $estado_doc          = 'todos';  // 'todos' | 'COMPLETADO' | 'BORRADOR' | 'anulado'
public mixed   $cliente_id          = null;
public ?string $tipo_comprobante_id = null;     // solo aplica cuando contexto = 'ventas'
```

**`mount()`:** fija `fecha_inicio` al primer día del mes actual y `fecha_fin` a hoy (mismo criterio que `Reportes\Ventas::mount()`).

**Listeners vía atributos:**
```php
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
```

**`exportar()`:**
```php
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
```

### Disparadores en los componentes existentes

`app/Livewire/Admin/Facturacion/Ventas/Index.php` — nuevo método junto a `openModalReporteVentas()`:
```php
public function openModalReporteDetallesVentas()
{
    $this->dispatch('open-modal-reporte-detalles-ventas');
}
```

`app/Livewire/Admin/Ventas/Recibos/RecibosIndex.php` — nuevo método junto a `OpenModalReporte()`:
```php
public function OpenModalReporteDetalles()
{
    $this->dispatch('open-modal-reporte-detalles-recibos');
}
```

---

## Sección 3: Integración en vistas existentes

### Ventas / Comprobantes (`resources/views/admin/comprobantes/index.blade.php`)

Página padre que monta los componentes Livewire vía `@livewire(...)`. Añadir:
```blade
@livewire('admin.reportes.detalles-items')
```

En `resources/views/livewire/admin/facturacion/ventas/index.blade.php`, añadir un botón "Reporte por ítem" junto al botón "REPORTE VENTAS" existente (línea ~31), que llama `wire:click.prevent="openModalReporteDetallesVentas()"`.

### Recibos (`resources/views/admin/ventas/recibos/index.blade.php`)

Misma página padre que ya monta `@livewire('admin.reportes.ventas')`. Añadir junto a ese:
```blade
@livewire('admin.reportes.detalles-items')
```

> **Nota:** el componente `admin.reportes.detalles-items` se monta una sola vez por página padre (no dos), igual que `admin.reportes.ventas` — sirve a ambos contextos vía el evento recibido.

En `resources/views/livewire/admin/ventas/recibos/recibos-index.blade.php`, añadir botón "Reporte por ítem" junto al botón "Descargar Reporte" existente (línea ~63), que llama `wire:click="OpenModalReporteDetalles"`.

---

## Sección 4: Modal blade

### `resources/views/livewire/admin/reportes/detalles-items.blade.php`

Sigue el patrón exacto de `resources/views/livewire/admin/reportes/ventas.blade.php`:

- `<x-form.modal.card>` con título dinámico según `$contexto` (match 'ventas' => 'Ventas', 'recibos' => 'Recibos')
- `wire:model.live="showModal"`
- Campos de fecha inicio/fin (`x-form.datetime.picker`, `wire:model.live`)
- Select Tipo Ítem: Todos / Producto / Servicio (`x-form.select` o `x-form.radio`)
- Select/radio Estado Doc: Todos / Completado / Borrador / Anulado — la opción "Anulado" solo se muestra `@if ($contexto === 'ventas')`
- Select Cliente (`x-form.select` con `async-data`, igual que en `ventas.blade.php`)
- Select Tipo Comprobante — solo `@if ($contexto === 'ventas')`
- Botón "Descargar Excel" → `wire:click.prevent="exportar"` con `spinner="exportar"`
- Footer con botón "Cerrar"

---

## Restricciones

- No correr `php artisan test` ni `php artisan migrate`.
- Validar PHP con `php -l`.
- Sin documentación adicional.
- Seguir convenciones de los componentes hermanos (`Reportes.php` en recibos).
