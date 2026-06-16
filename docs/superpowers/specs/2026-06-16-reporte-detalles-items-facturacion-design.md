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

| Acción | Archivo |
|--------|---------|
| Crear | `app/Exports/ReporteDetallesItemsExport.php` |
| Crear | `app/Livewire/Admin/Facturacion/Ventas/ReporteDetalles.php` |
| Crear | `app/Livewire/Admin/Ventas/Recibos/ReporteDetalles.php` |
| Crear | `resources/views/livewire/admin/facturacion/ventas/reporte-detalles.blade.php` |
| Crear | `resources/views/livewire/admin/ventas/recibos/reporte-detalles.blade.php` |
| Modificar | Vista del índice de Ventas (incluir `<livewire:admin.facturacion.ventas.reporte-detalles />`) |
| Modificar | Vista del índice de Recibos (incluir `<livewire:admin.ventas.recibos.reporte-detalles />`) |

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

## Sección 2: Componentes Livewire

Ambos modales siguen el patrón de `App\Livewire\Admin\Ventas\Recibos\Reportes`.

### `ReporteDetalles.php` (ventas)

**Propiedades públicas:**
```php
public bool    $open                = false;
public string  $fecha_inicio        = '';
public string  $fecha_fin           = '';
public string  $tipo_item           = 'todos';
public string  $estado_doc          = 'todos';
public mixed   $cliente_id          = null;
public ?string $tipo_comprobante_id = null;
```

**Listeners:** `['open-modal-reporte-detalles-ventas' => 'openModal']`

**Métodos:**
- `openModal()`: `$this->open = true`
- `closeModal()`: `$this->open = false; $this->reset(...)`
- `exportar()`: validación básica (fechas requeridas), llama `Excel::download(new ReporteDetallesItemsExport('ventas', ...), 'reporte-detalles-ventas.xlsx')`

### `ReporteDetalles.php` (recibos)

Idéntico al de ventas excepto:
- Sin propiedad `$tipo_comprobante_id`
- Listener: `'open-modal-reporte-detalles-recibos' => 'openModal'`
- Export con `contexto = 'recibos'`
- Nombre descarga: `'reporte-detalles-recibos.xlsx'`
- Estado doc no incluye opción 'anulado'

---

## Sección 3: Integración en vistas existentes

### Ventas Index

En la vista del índice de ventas, añadir un botón "Reporte por ítem" junto a los botones existentes. Al hacer clic, despacha el evento `open-modal-reporte-detalles-ventas`. Incluir el componente al final de la vista:

```blade
<livewire:admin.facturacion.ventas.reporte-detalles />
```

### Recibos Index

En la vista del índice de recibos, añadir botón "Reporte por ítem" similar. Al clic, despacha `open-modal-reporte-detalles-recibos`. Incluir:

```blade
<livewire:admin.ventas.recibos.reporte-detalles />
```

---

## Sección 4: Modal blade

Ambas vistas blade siguen el patrón de `resources/views/livewire/admin/ventas/recibos/reportes.blade.php`:

- Modal con `wire:model.live="open"`
- Campos de fecha inicio/fin (`wire:model`)
- Select Tipo Ítem: Todos / Producto / Servicio
- Select Estado Doc (ventas: Todos/Completado/Borrador/Anulado; recibos: Todos/Completado/Borrador)
- Select Cliente (buscable o simple, según patrón existente en el index)
- Select Tipo Comprobante (solo ventas)
- Botón "Exportar" → `wire:click="exportar"` con spinner
- Botón "Cerrar"

---

## Restricciones

- No correr `php artisan test` ni `php artisan migrate`.
- Validar PHP con `php -l`.
- Sin documentación adicional.
- Seguir convenciones de los componentes hermanos (`Reportes.php` en recibos).
