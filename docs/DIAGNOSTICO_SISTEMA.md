# Diagnostico integral del sistema Talentus

Fecha inicial: 2026-06-01 | Ultima actualizacion: 2026-06-07
Alcance revisado: rutas web/API/facturacion/WhatsApp, flujo comercial-operativo, modulos administrativos, stock de productos, stock/estado de dispositivos, WorkOrders, cobros, pagos y puntos criticos de consistencia.

> Nota de alcance: esta revision fue sobre codigo fuente y `php artisan route:list --except-vendor`. No se hizo una auditoria directa de datos productivos en base de datos.

---

## 1. Resumen ejecutivo

| Area                    | Estado                                   | Diagnostico                                                                                                                                                                       |
| ----------------------- | ---------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Rutas principales       | Funcional con deuda                      | `route:list` carga 256 rutas, pero hay nombres inconsistentes, typos y APIs auxiliares dentro de `web.php`.                                                                       |
| Almacen/productos       | Riesgo medio (mejorado)                  | Stock ahora se mueve en recibos, anulaciones y eliminaciones. Pendiente: editar recibo y accesorios WorkOrder.                                                                    |
| Dispositivos GPS        | Parcialmente correcto                    | Ventas/recibos marcan dispositivos como `VENDIDO`; anulacion/eliminacion los revierte a `STOCK`; WorkOrders solo guardan historial y no cambian estado.                           |
| Vehiculos/dispositivos  | Correcto como asignacion                 | `SaveVehiculo` y `Vehiculos::sincronizarDispositivos()` validan disponibilidad por asignacion, pero no consumen stock. Esto puede ser correcto si la venta ocurre por otro flujo. |
| WorkOrders              | Flujo tecnico robusto, cierre incompleto | Iniciar/finalizar/cerrar funciona, exige firma para finalizar, pero cerrar no genera venta/cobro ni activa GPS externo.                                                           |
| Cobros/pagos            | Parcialmente integrado                   | `PaymentsObserver` marca periodos como pagados cuando el documento se paga; la creacion de documentos/cobros sigue siendo manual en varios escenarios.                            |
| Facturacion             | Operativa con deuda                      | Emitir factura/boleta descuenta stock de productos y dispositivos; anulacion ahora repone productos.                                                                              |
| Modulos administrativos | Operativos                               | Usuarios, roles, ajustes, bancos, series, plantilla, SUNAT estan ruteados; permisos no son homogeneos en todos los modulos.                                                       |
| Gerencia/KPI            | En desarrollo                            | Hay rutas y modelos KPI nuevos sin confirmar; estan sin commit y forman parte de cambios locales actuales.                                                                        |

Prioridad actual: completar consistencia de stock en edicion de recibos, luego formalizar regla de dispositivos y cerrar automatizaciones.

---

## 2. Estado del arbol de trabajo

Cambios observados al momento de la auditoria inicial (ya confirmados como commits):

- SIM cards y lineas: per-page selector, filtros UI, M2M sync con creacion de lineas.
- Seguridad: throttle en `/api/consultas/*`, middleware `verified` en facturacion, eliminacion de middleware redundante en compras.
- Stock: ComprasObserver::deleted(), Compras\Edit diferencial, Recibos::createItems(), AnularComprobante, EliminarRecibo.

---

## 3. Rutas y orden de modulos

### 3.1 Hallazgos de rutas pendientes

| Codigo | Severidad | Archivo                                                  | Hallazgo                                                                                                              | Accion recomendada                                                                              | Estado     |
| ------ | --------- | -------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------- | ---------- |
| R1     | Alta      | `bootstrap/app.php:24`                                   | `facturacion.php` usa `web`, `auth`, `verified`; el resto del panel usa `auth:sanctum`.                               | Unificar si todos los documentos requieren contexto de empresa.                                 | Parcial    |
| R2     | Alta      | `routes/facturacion.php:28`, `routes/facturacion.php:34` | Rutas nombradas `facturacion.guia.qver.cdr` y `facturacion.nota.qver.cdr`.                                            | Renombrar a `*.ver.cdr` y buscar usos antes de cambiar.                                         | Pendiente  |
| R3     | Media     | `routes/web.php:414-450`                                 | Endpoints tipo API/select viven dentro de `web.php` con nombres `api.*`.                                              | Moverlos a `api.php` o renombrarlos como endpoints internos web.                                | Pendiente  |
| R4     | Media     | `routes/web.php:68-97`                                   | Finanzas usa nombres `finanzas.*`, mientras casi todo el panel usa `admin.*`.                                         | Evaluar migracion a `admin.finanzas.*` con alias temporales.                                    | Pendiente  |
| R5     | Media     | `routes/web.php:183`                                     | Compras agrega middleware `auth` dentro de un grupo que ya esta autenticado.                                          | Remover redundancia.                                                                            | **Resuelto** |
| R6     | Media     | `routes/api.php:306-333`                                 | Consultas publicas sin throttle explicito por grupo.                                                                  | Agregar `middleware('throttle:60,1')`.                                                          | **Resuelto** |
| R7     | Media     | `routes/api.php:357-363`                                 | `tracking/device-maintenances/sync` queda publico y el comentario dice X-API-KEY, pero la ruta no muestra middleware. | Confirmar validacion dentro del controller o mover a middleware.                                | Pendiente  |
| R8     | Baja      | `routes/web.php:135-137`, `302-303`                      | Varias rutas son `fn() => view(...)` o `Route::view`, sin controlador.                                                | Aceptable, pero documentar componentes Livewire esperados.                                      | Aceptable  |

---

## 4. Flujo de empresa esperado vs implementado

### 4.1 Brechas comerciales pendientes

- `PresupuestosObserver::updated()` esta vacio; no crea WorkOrder al aceptar presupuesto.
- No se ve una transicion automatica presupuesto aceptado -> orden de trabajo -> facturacion.

Referencias:
- `app/Observers/PresupuestosObserver.php:46-49`

### 4.2 WorkOrders - brechas pendientes

- `cerrar()` no genera venta, recibo, periodo de cobro, activacion GPS ni movimiento de stock.
- `guardarDispositivo()` en API y Livewire crea historial (`DeviceHistory`) pero no cambia `Dispositivos.estado`.
- `guardarAccesorio()` crea `WorkOrderAccessory`, pero no descuenta `Productos.stock`.
- En proyectos, `guardarDispositivoItem()` solo guarda texto `imei` y `numero_sim` en el item; no valida contra `dispositivos` ni consume stock.

Referencias:
- `app/Models/WorkOrder.php:180-220`
- `app/Http/Controllers/Api/WorkOrderController.php:420-463`
- `app/Http/Controllers/Api/WorkOrderController.php:473-501`
- `app/Http/Controllers/Api/WorkOrderController.php:710-724`
- `app/Livewire/Admin/WorkOrders/Show.php:275-312`

---

## 5. Auditoria de stock de productos

### 5.1 Estado actual

| Operacion                                   | Estado actual                                                                                  | Riesgo          |
| ------------------------------------------- | ---------------------------------------------------------------------------------------------- | --------------- |
| Crear compra                                | Incrementa stock del producto.                                                                 | Correcto        |
| Anular compra desde Index                   | Decrementa stock, con validacion de stock suficiente.                                          | Correcto        |
| Eliminar compra desde Delete/EliminarCompra | `ComprasObserver::deleted()` revierte stock al borrar.                                         | **Resuelto**    |
| Editar compra                               | Calcula diferencial (nuevo - viejo) y ajusta stock por producto.                               | **Resuelto**    |
| Emitir factura/boleta                       | Descuenta stock si `decrease_stock` esta true y el item es `producto`.                         | Correcto        |
| Crear recibo                                | `Recibos::createItems()` descuenta stock cuando el producto es tipo `producto`.                | **Resuelto**    |
| Editar recibo                               | Borra y recrea detalles sin ajuste de stock.                                                   | **Riesgo alto** |
| Eliminar recibo                             | Repone stock de cada detalle producto.                                                         | **Resuelto**    |
| Anular comprobante                          | Repone stock de cada detalle producto.                                                         | **Resuelto**    |
| Guias de remision                           | Crea detalles sin reservar/descontar stock.                                                    | Definicion pendiente |
| WorkOrder accesorios                        | Observer decrementa stock al instalar/reemplazar; valida disponibilidad antes de crear.        | **Resuelto**    |

### 5.2 Pendiente prioritario

**WorkOrder proyectos** — `app/Http/Controllers/Api/WorkOrderController.php:710-724`:
- `guardarDispositivoItem()` acepta `imei` como texto; no valida contra tabla `dispositivos`.

### 5.3 Recomendacion de diseno (a largo plazo)

Crear una capa unica para movimientos de stock:

```text
StockService::salida(producto, cantidad, origen_tipo, origen_id)
StockService::entrada(producto, cantidad, origen_tipo, origen_id)
StockService::revertir(origen_tipo, origen_id)
```

Idealmente guardar tabla `stock_movimientos` con `producto_id`, `tipo`, `cantidad`, `origen_type`, `origen_id`, `empresa_id`, `user_id`, `observacion`.

---

## 6. Auditoria de dispositivos GPS

### 6.1 Comportamiento actual

| Flujo                              | Cambio actual                                                | Estado       |
| ---------------------------------- | ------------------------------------------------------------ | ------------ |
| Factura/boleta                     | IMEIs seleccionados pasan a `VENDIDO`.                       | Correcto     |
| Anular comprobante                 | IMEIs de la venta vuelven a `STOCK`.                         | Correcto     |
| Crear recibo                       | IMEIs seleccionados pasan a `VENDIDO`.                       | Correcto     |
| Editar recibo                      | IMEIs removidos vuelven a `STOCK`; nuevos pasan a `VENDIDO`. | Correcto     |
| Eliminar recibo                    | IMEIs del recibo vuelven a `STOCK`.                          | Correcto     |
| Crear vehiculo/asignar dispositivo | Solo asigna vehiculo; no cambia `estado`.                    | Pendiente definicion |
| WorkOrder dispositivo              | Solo historial; no cambia `estado`.                          | Pendiente definicion |

### 6.2 Riesgos pendientes

| Codigo | Severidad | Riesgo                                                                                                                       |
| ------ | --------- | ---------------------------------------------------------------------------------------------------------------------------- |
| D1     | Alta      | WorkOrder puede registrar IMEI instalado sin cambiar estado a `VENDIDO`, `INSTALADO` o `RESERVADO`.                          |
| D2     | Alta      | `guardarDispositivoItem()` acepta `imei` como texto; no valida que exista en `dispositivos` ni que este disponible.          |
| D3     | Media     | El estado solo tiene `STOCK/VENDIDO`; falta estado operativo `INSTALADO` o `RESERVADO` si el proceso lo necesita.            |
| D4     | Media     | Importacion FOTA crea dispositivos en `STOCK`, pero no se observa incremento del producto vinculado por modelo en ese flujo. |

### 6.3 Opciones de politica de estados

**Opcion A** (mantener actual): Stock se consume al vender/facturar. WorkOrder solo instala y registra historial.

**Opcion B** (recomendada si el tecnico retira del almacen antes de facturar): Agregar estado `INSTALADO/RESERVADO`. WorkOrder al registrar IMEI cambia `STOCK` -> `INSTALADO`. Factura cambia `INSTALADO` -> `VENDIDO`.

---

## 7. Observers - estado actual

| Observer               | Estado                                                   | Pendiente                                                    |
| ---------------------- | -------------------------------------------------------- | ------------------------------------------------------------ |
| `ComprasObserver`      | `deleted()` revierte stock correctamente.                | Resuelto.                                                    |
| `VentasObserver`       | `updated()` y `deleted()` vacios.                        | Reponer stock al eliminar si aplica.                         |
| `RecibosObserver`      | Existe; stock ahora se maneja en `createItems()`.        | Evaluar centralizar stock en observer.                       |
| `PresupuestosObserver` | No crea WorkOrder al aceptar.                            | Automatizar transicion comercial -> operaciones.             |
| `DispositivosObserver` | No centraliza estados de venta/stock.                    | Registrar transiciones o mover logica a servicio.            |
| `PaymentsObserver`     | Robusto para caja y periodos.                            | Mantener; agregar tests.                                     |
| `WorkOrderObserver`    | Robusto para UUID/notificaciones.                        | Agregar eventos de cierre si se automatiza facturacion.      |
| `TicketObserver`       | Robusto para SLA/eventos.                                | Mantener.                                                    |

---

## 8. Hallazgos pendientes por prioridad

### Criticos

1. **WorkOrder proyectos** aceptan IMEI como texto sin validar disponibilidad real (`app/Http/Controllers/Api/WorkOrderController.php:710-724`).

### Altos

4. Facturacion descuenta stock antes de llamar API SUNAT; si la API falla, el stock queda descontado pero el documento no se emite. Falta compensacion.
5. Importacion FOTA de dispositivos no parece incrementar stock de producto vinculado por `modelo_id`.
6. Rutas nombradas `facturacion.guia.qver.cdr` y `facturacion.nota.qver.cdr` (R2).
7. Tracking sync (`routes/api.php:357-363`) publico sin middleware visible (R7).

### Medios

8. Selects API estan en `web.php` (R3).
9. Finanzas no usa prefijo de nombre `admin.*` (R4).
10. `RouteServiceProvider.php` parece legado y puede confundir mantenimiento.
11. WorkOrders no generan venta/recibo/cobro al cerrar.
12. Presupuesto aceptado no genera WorkOrder.
13. Estado de dispositivos carece de `RESERVADO/INSTALADO` (D3).

---

## 9. Plan recomendado (actualizado)

### Inmediato

1. Corregir edicion de recibo: diferencial de stock en `Recibos\Edit` (mismo patron que `Compras\Edit`).
2. Validar IMEIs reales en WorkOrder proyectos e implementar.

### Sprint siguiente: dispositivos y WorkOrders

1. Definir politica `STOCK/VENDIDO` vs `STOCK/RESERVADO/INSTALADO/VENDIDO`.
2. Validar IMEIs reales en WorkOrder item y guardar `dispositivo_id`.
3. Descontar o reservar accesorios de WorkOrder.
4. Sincronizar FOTA import con `Productos.stock`.

### Sprint posterior: proceso end-to-end

1. Presupuesto aceptado crea WorkOrder.
2. WorkOrder cerrada genera documento pendiente de facturacion o recibo.
3. Documento pagado marca periodo y dispara postventa.
4. Tickets V1/V3/V7/V15/V30 desde cierre de instalacion.
5. KPI lee estados reales del flujo.

---

## 10. Consultas utiles para auditoria en base de datos

```sql
-- Productos con stock negativo
SELECT id, codigo, descripcion, stock
FROM productos
WHERE CAST(stock AS SIGNED) < 0;

-- Productos tipo dispositivo sin modelo vinculado
SELECT id, codigo, descripcion, modelo_id
FROM productos
WHERE es_dispositivo = 1
  AND modelo_id IS NULL;

-- Dispositivos vendidos
SELECT d.id, d.imei, d.estado
FROM dispositivos d
WHERE d.estado = 'VENDIDO';

-- WorkOrders cerradas sin venta/recibo vinculado por presupuesto
SELECT wo.id, wo.presupuesto_id, wo.fecha_cerrado
FROM work_orders wo
LEFT JOIN ventas v ON v.presupuestos_id = wo.presupuesto_id
LEFT JOIN recibos r ON r.presupuestos_id = wo.presupuesto_id
WHERE wo.fecha_cerrado IS NOT NULL
  AND wo.presupuesto_id IS NOT NULL
  AND v.id IS NULL
  AND r.id IS NULL;
```
