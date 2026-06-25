# Añadir placa a un cliente sin re-teclear — Diseño

**Fecha:** 2026-06-25
**Módulo:** `app/Livewire/Admin/Cobros`
**Enfoque elegido:** A — Botón "+ Añadir placa" en la cabecera del cliente, reusando `RegistrarFlota`.

## Problema

El proceso es: **Cotizar → Facturar → Registrar cobros** por periodos. Cada `cobros` es
*una suscripción por placa* (cliente + vehículo + plan + periodo + fechas + monto + estado);
`periodos_cobros` guarda el historial de facturación de cada cobro.

Cuando un cliente que **ya tiene flota activa** suma una placa nueva, hoy hay que registrar un
cobro desde cero ([RegistrarCobro](../../../app/Livewire/Admin/Cobros/RegistrarCobro.php) o
[RegistrarFlota](../../../app/Livewire/Admin/Cobros/RegistrarFlota.php)), re-eligiendo cliente,
plan, periodo, divisa, tipo de comprobante, fechas y monto, aunque el cliente ya tenga placas
idénticas.

**Dolor priorizado por el usuario:** re-teclear toda la configuración. (No se pide alineación de
fechas ni prorrateo.)

**Causa raíz:** el refactor de junio 2026 eliminó `contratos_id` de `cobros`; ya no hay agrupador
a nivel de cliente, así que cada placa es independiente y "añadir placa" obliga a re-capturar todo.

## Objetivo

Permitir añadir una o varias placas nuevas a un cliente existente **heredando** su configuración
con uno o dos clics, sin re-teclear. **Sin cambios de base de datos.**

## No-objetivos (YAGNI)

- No se crea una entidad "Flota/Contrato" ni se reintroduce `contratos_id`.
- No se alinean las fechas de la placa nueva al ciclo de la flota.
- No hay prorrateo del primer periodo.
- No se modifica el flujo de facturación/cobro consolidado existente.

## Diseño

### 1. Disparador (UI)

En [index.blade.php](../../../resources/views/livewire/admin/cobros/index.blade.php), la tabla ya
agrupa las filas con una **fila-cabecera por cliente** (`$showClienteHeader`, ~línea 507). Se agrega
en esa cabecera, alineado a la derecha, un botón **"+ Añadir placa"**:

```blade
wire:click="$dispatch('abrirRegistrarFlota', { clienteId: {{ $cobro->clientes_id }} })"
```

El botón "Registrar flota" del toolbar superior se mantiene sin argumentos (flota en blanco).
El botón se muestra dentro del bloque `@can('admin.cobros.create')` como los demás de creación.

### 2. Componente `RegistrarFlota` — único punto de cambio

Se cambia la firma del listener de apertura a:

```php
public function abrir(?int $clienteId = null): void
```

- **Sin `clienteId`** → comportamiento actual (flota en blanco). Sin regresiones.
- **Con `clienteId`** → modo "heredar":
  1. Fija `cliente_id = $clienteId`.
  2. Carga los vehículos del cliente **excluyendo** los que ya tienen un cobro
     `ACTIVO` o `SUSPENDIDO` (solo aparecen placas nuevas). Reutiliza la consulta de
     `updatedClienteId()` añadiendo el filtro de exclusión.
  3. Busca el **último cobro `ACTIVO`** del cliente (`Cobros::activos()->where('clientes_id',…)
     ->latest('id')->first()`) y, si existe, hereda: `plan_id`, `periodo`, `divisa`,
     `tipo_comprobante` (desde `tipo_pago`), `monto`, `descuento`, `nota`.
  4. `fecha_inicio = hoy`; `fecha_fin = calcularFechaFin(hoy, periodo)`.
  5. Si el cliente no tiene cobro previo, abre en blanco con el cliente fijado.
  6. `modalOpen = true`.

`guardar()`, `rules()`, `calcularMonto()` y `calcularFechaFin()` **no se tocan**. `guardar()` ya
crea un `Cobros` + un `PeriodoCobro` (`tipo=INICIAL`, `estado=PENDIENTE`) por placa y **omite**
las que ya tengan cobro activo/suspendido, avisando.

### 3. Flujo de datos

```
[Index] cabecera cliente "+ Añadir placa"
   └─ dispatch abrirRegistrarFlota(clienteId)
        └─ RegistrarFlota::abrir(clienteId)  → modal prellenado, solo placas nuevas
             └─ usuario marca placa(s) → guardar()
                  └─ por cada placa: Cobros::create + PeriodoCobro PENDIENTE (INICIAL)
                       └─ aparecen en la lista → "Cobrar seleccionados" (flujo actual)
```

### 4. Casos borde

| Caso | Comportamiento |
|------|----------------|
| Cliente con todas sus placas ya con cobro | Select de vehículos vacío + aviso "Sin placas pendientes de registrar". |
| Cliente sin cobro previo | Modo blanco con cliente fijado (no hay config que heredar). |
| Placa marcada que ya tiene cobro | `guardar()` la omite y lo informa en el toast (lógica existente). |
| Cliente con planes mixtos | Hereda del último cobro activo; todos los campos quedan editables en el modal. |
| Fechas | Por defecto hoy, independientes del ciclo de la flota (decisión del usuario). |

### 5. Pruebas

Feature test de `RegistrarFlota` (PHPUnit):

1. `abrir($clienteId)` con cobro previo activo → hereda `plan_id`, `periodo`, `divisa`,
   `tipo_comprobante`, `monto`, `descuento` del último cobro activo.
2. `abrir($clienteId)` excluye del listado los vehículos con cobro `ACTIVO`/`SUSPENDIDO`.
3. `abrir($clienteId)` sin cobro previo → abre en blanco con `cliente_id` fijado.
4. `guardar()` con N placas → crea N `Cobros` y N `PeriodoCobro` `PENDIENTE`/`INICIAL`.
5. `abrir(null)` mantiene el comportamiento de flota en blanco (no regresión).

**Nota de entorno:** existe la indicación de **no** ejecutar `php artisan test` contra la BD real
(`RefreshDatabase` la borra). Antes de correr las pruebas se confirmará la vía (conexión/BD de
pruebas dedicada vs. solo validación de sintaxis con `php -l`).

## Archivos afectados

- `resources/views/livewire/admin/cobros/index.blade.php` — botón en la cabecera de cliente.
- `app/Livewire/Admin/Cobros/RegistrarFlota.php` — `abrir(?int $clienteId = null)` + filtro de vehículos.
- `resources/views/livewire/admin/cobros/registrar-flota.blade.php` — ajuste del texto de aviso (placas pendientes).
- `tests/Feature/...` — nuevo feature test del componente.
```

## Limpieza relacionada (opcional, fuera de alcance principal)

`app/Livewire/Admin/Ventas/Contratos/Index.php::createCobro()` quedó muerto tras el refactor de
junio 2026 (usa columnas inexistentes: `contratos_id`, `monto_unidad`). No es parte de este cambio,
pero conviene anotarlo para una limpieza futura.
