# Diagnostico integral del sistema Talentus

Fecha: 2026-06-01  
Alcance revisado: rutas web/API/facturacion/WhatsApp, flujo comercial-operativo, modulos administrativos, stock de productos, stock/estado de dispositivos, WorkOrders, cobros, pagos y puntos criticos de consistencia.

> Nota de alcance: esta revision fue sobre codigo fuente y `php artisan route:list --except-vendor`. No se hizo una auditoria directa de datos productivos en base de datos. El comando de rutas cargo correctamente y mostro 256 rutas; tambien emitio un warning de Imagick por diferencia de version de ImageMagick, no bloqueante para rutas.

---

## 1. Resumen ejecutivo

El sistema esta bien separado por dominio: rutas -> controladores -> vistas Blade -> componentes Livewire -> modelos/observers/servicios. La estructura permite operar los modulos principales, pero hay riesgos importantes en inventario y en automatizacion del proceso de negocio.

| Area                    | Estado                                   | Diagnostico                                                                                                                                                                       |
| ----------------------- | ---------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Rutas principales       | Funcional con deuda                      | `route:list` carga 256 rutas, pero hay nombres inconsistentes, typos y APIs auxiliares dentro de `web.php`.                                                                       |
| Almacen/productos       | Riesgo alto                              | Compras incrementan stock; ventas SUNAT descuentan stock; recibos no descuentan productos; anulaciones/eliminaciones no reponen productos.                                        |
| Dispositivos GPS        | Parcialmente correcto                    | Ventas/recibos marcan dispositivos como `VENDIDO`; anulacion/eliminacion los revierte a `STOCK`; WorkOrders solo guardan historial y no cambian estado.                           |
| Vehiculos/dispositivos  | Correcto como asignacion                 | `SaveVehiculo` y `Vehiculos::sincronizarDispositivos()` validan disponibilidad por asignacion, pero no consumen stock. Esto puede ser correcto si la venta ocurre por otro flujo. |
| WorkOrders              | Flujo tecnico robusto, cierre incompleto | Iniciar/finalizar/cerrar funciona, exige firma para finalizar, pero cerrar no genera venta/cobro ni activa GPS externo.                                                           |
| Cobros/pagos            | Parcialmente integrado                   | `PaymentsObserver` marca periodos como pagados cuando el documento se paga; la creacion de documentos/cobros sigue siendo manual en varios escenarios.                            |
| Facturacion             | Operativa con deuda                      | Emitir factura/boleta descuenta stock de productos y dispositivos; anulacion no repone productos.                                                                                 |
| Modulos administrativos | Operativos                               | Usuarios, roles, ajustes, bancos, series, plantilla, SUNAT estan ruteados; permisos no son homogeneos en todos los modulos.                                                       |
| Gerencia/KPI            | En desarrollo                            | Hay rutas y modelos KPI nuevos sin confirmar; estan sin commit y forman parte de cambios locales actuales.                                                                        |

Prioridad general: corregir primero inventario de productos, luego formalizar la regla de dispositivos y despues cerrar automatizaciones Presupuesto -> WorkOrder -> Venta/Recibo -> Cobro.

---

## 2. Estado del arbol de trabajo

Hay cambios locales no confirmados antes de esta auditoria. No fueron revertidos.

Cambios observados:

- Modificados: `app/Models/Presupuestos.php`, `app/Models/Team.php`, `app/Models/WorkOrder.php`, `routes/web.php`, archivos de cache.
- Nuevos: componentes y modelos KPI, migraciones 2026, `docs/DIAGNOSTICO_SISTEMA.md`, `plataforma_docs/`, vistas KPI.

Recomendacion: antes de tocar logica critica de stock, hacer commit o stash selectivo de los cambios de KPI y WorkOrder para evitar mezclar auditoria con funcionalidad nueva.

---

## 3. Rutas y orden de modulos

### 3.1 Carga real de rutas

La aplicacion carga rutas desde `bootstrap/app.php`:

- `routes/web.php` como web principal.
- `routes/api.php` como API principal.
- `routes/facturacion.php` bajo prefijo `invoice` con middleware `web`, `auth`.
- `routes/whats-fleep.php` bajo middleware `web`.

Referencia: `bootstrap/app.php:18-25`.

Existe `app/Providers/RouteServiceProvider.php`, pero no esta registrado en `bootstrap/providers.php`; por tanto debe tratarse como legado o archivo no activo en el arranque actual.

### 3.2 Hallazgos de rutas

| Codigo | Severidad | Archivo                                                  | Hallazgo                                                                                                              | Accion recomendada                                                                              |
| ------ | --------- | -------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------- |
| R1     | Alta      | `bootstrap/app.php:24`                                   | `facturacion.php` usa `web`, `auth`; el resto del panel usa `auth:sanctum`, `verified`.                               | Unificar middleware si todos los documentos requieren usuario verificado y contexto de empresa. |
| R2     | Alta      | `routes/facturacion.php:28`, `routes/facturacion.php:34` | Rutas nombradas `facturacion.guia.qver.cdr` y `facturacion.nota.qver.cdr`.                                            | Renombrar a `*.ver.cdr` y buscar usos antes de cambiar.                                         |
| R3     | Media     | `routes/web.php:414-450`                                 | Endpoints tipo API/select viven dentro de `web.php` con nombres `api.*`.                                              | Moverlos a `api.php` o renombrarlos como endpoints internos web.                                |
| R4     | Media     | `routes/web.php:68-97`                                   | Finanzas usa nombres `finanzas.*`, mientras casi todo el panel usa `admin.*`.                                         | Evaluar migracion a `admin.finanzas.*` con alias temporales.                                    |
| R5     | Media     | `routes/web.php:183`                                     | Compras agrega middleware `auth` dentro de un grupo que ya esta autenticado.                                          | Remover redundancia.                                                                            |
| R6     | Media     | `routes/api.php:306-333`                                 | Consultas publicas sin throttle explicito por grupo.                                                                  | Agregar `middleware('throttle:60,1')` o limitador especifico.                                   |
| R7     | Media     | `routes/api.php:357-363`                                 | `tracking/device-maintenances/sync` queda publico y el comentario dice X-API-KEY, pero la ruta no muestra middleware. | Confirmar validacion dentro del controller o mover a middleware.                                |
| R8     | Baja      | `routes/web.php:135-137`, `302-303`                      | Varias rutas son `fn() => view(...)` o `Route::view`, sin controlador.                                                | Aceptable, pero documentar componentes Livewire esperados.                                      |

### 3.3 Mapa de modulos por rutas

| Modulo                      | Rutas base                                                   | Vista/control principal                         | Estado                                          |
| --------------------------- | ------------------------------------------------------------ | ----------------------------------------------- | ----------------------------------------------- |
| Dashboard                   | `/`, `/dashboard`, charts                                    | `HomeController`                                | OK                                              |
| Finanzas                    | `/finanzas/*`                                                | `FinanzasController`, Livewire finanzas         | OK con nombres no `admin.*`                     |
| Caja chica reportes         | `/finanzas/caja-chica/*`                                     | `CajaChicaPdfController`                        | OK                                              |
| Almacen categorias          | `/categorias`                                                | `CategoriaController`, Livewire categorias      | OK                                              |
| Almacen productos/servicios | `/productos`, `/servicios`                                   | `ProductosController`, Livewire items           | OK con riesgo de stock                          |
| Almacen SIM                 | `/sim-card`                                                  | `SimCardController`, Livewire sim-card          | OK                                              |
| Almacen lineas              | `/lineas`, `/lineas-y-sim-card`                              | `LineasController`                              | OK                                              |
| Almacen dispositivos        | `/dispositivos`, `/modelos/dispositivos`                     | `GpsController`, Livewire dispositivos          | OK parcial con stock                            |
| Guias                       | `/guias`, `/guias/crear`, `/guias/{guia}/editar`             | `GuiaRemisionController`                        | OK funcional, sin stock                         |
| Clientes/contactos          | `/clientes`, `/contactos`                                    | `ClientesController`, `ContactosController`     | OK                                              |
| Pagos/cobros                | `/pagos`, `/cobros`                                          | `PaymentsController`, `CobrosController`        | OK parcial                                      |
| Planes                      | `/planes`                                                    | `PlanesController`                              | OK                                              |
| Compras                     | `/compras`, `/compras/registrar`, `/compras/editar/{compra}` | `ComprasController`, Livewire compras           | OK con riesgos al editar/eliminar               |
| Presupuestos                | `/presupuestos/*`                                            | `PresupuestoController`                         | OK, no crea WorkOrder automatico                |
| Facturacion SUNAT           | `/ventas`, `/emitir/*`, `/notas`                             | `ComprobantesController`, Livewire facturacion  | OK con brechas de reposicion                    |
| Recibos                     | `/recibos/*`                                                 | `RecibosController`, Livewire recibos           | OK, no descuenta stock producto                 |
| Contratos                   | `/contratos/*`                                               | `ContratosController`                           | OK                                              |
| Vehiculos/flotas            | `/vehiculos`, `/flotas`                                      | `VehiculosController`, `FlotasController`       | OK                                              |
| Mantenimiento/reportes      | `/mantenimiento`, `/reportes/*`                              | `MantenimientoController`, `ReportesController` | OK                                              |
| Certificados                | `/actas`, `/certificados-*`                                  | Controllers certificados                        | OK                                              |
| Ajustes                     | `/ajustes/*`                                                 | `AjustesController`, Livewire ajustes           | OK                                              |
| Servicio tecnico            | `/tecnico/tareas`, `/tecnico/index`                          | `ServicioTecnicoController`                     | OK                                              |
| WorkOrders web              | `/work-orders/*`                                             | `WorkOrderController`, Livewire WorkOrders      | OK, cierre no automatiza inventario/facturacion |
| Tickets                     | `/tickets`, `/tickets-dashboard/*`                           | `TicketsController`                             | OK                                              |
| WhatsApp                    | `/whatsapp/*`                                                | Controllers WhatsFleep                          | OK con middleware dentro de archivo             |
| API mobile WorkOrders       | `/api/work-orders/*`                                         | `Api\WorkOrderController`                       | OK parcial                                      |
| API publica consultas       | `/api/consultas/*`                                           | `ConsultasApiController`                        | Falta throttle explicito                        |

---

## 4. Flujo de empresa esperado vs implementado

Flujo esperado del negocio:

```text
Comercial -> Presupuesto/Contrato -> Operaciones/WorkOrder -> Instalacion/Servicio
-> Facturacion/Recibo -> Cobro/Pago -> Postventa/Tickets -> Gerencia/KPI
```

### 4.1 Comercial

Implementado:

- Clientes y contactos existen.
- Presupuestos crean detalles en `Presupuestos::createItems()`.
- Presupuesto tiene relaciones hacia venta, recibo y WorkOrders.

Brechas:

- `PresupuestosObserver::updated()` esta vacio; no crea WorkOrder al aceptar presupuesto.
- No se ve una transicion automatica presupuesto aceptado -> orden de trabajo -> facturacion.

Referencias:

- `app/Models/Presupuestos.php:111-123`
- `app/Models/Presupuestos.php:186-198`
- `app/Observers/PresupuestosObserver.php:46-49`

### 4.2 Operaciones / WorkOrders

Implementado:

- La orden inicia solo desde `pendiente`.
- Finaliza solo desde `en_proceso`.
- Para finalizar exige firma de conformidad.
- Cerrar bloquea la orden y setea `fecha_cerrado`.
- API y web reutilizan los metodos del modelo.

Brechas:

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

### 4.3 Facturacion / Recibos / Cobros

Implementado:

- Facturas/boletas se emiten desde `admin.factura.create` y `admin.boleta.create`.
- Recibos pueden crearse desde periodos de cobro.
- `PeriodoCobro::marcarComoFacturado()`, `marcarComoPagado()` y `resetFacturacion()` existen.
- `PaymentsObserver` marca periodos como pagados al completar pagos de venta/recibo.

Brechas:

- La venta SUNAT descuenta productos, pero depende de flag de UI.
- Recibos no descuentan productos.
- Anular venta y eliminar recibo revierten periodos y dispositivos, pero no productos.
- No hay observer de ventas que cree periodos de cobro o conecte automaticamente con suscripciones.

Referencias:

- `app/Models/PeriodoCobro.php:132-163`
- `app/Observers/PaymentsObserver.php:88-132`
- `app/Observers/VentasObserver.php:31-41`

---

## 5. Auditoria de stock de productos

### 5.1 Comportamiento actual verificado

| Operacion                                   | Resultado actual                                                          | Estado                                     |
| ------------------------------------------- | ------------------------------------------------------------------------- | ------------------------------------------ |
| Crear compra                                | Incrementa stock del producto.                                            | Correcto                                   |
| Anular compra desde Index                   | Decrementa stock, con validacion de stock suficiente.                     | Correcto parcial                           |
| Eliminar compra desde Delete/EliminarCompra | No decrementa stock.                                                      | Riesgo alto                                |
| Editar compra                               | Borra detalles y los recrea, pero no ajusta diferencias de stock.         | Riesgo alto                                |
| Emitir factura/boleta                       | Descuenta stock si `decrease_stock` esta true y el item es `producto`.    | Correcto parcial                           |
| Crear recibo                                | No descuenta stock de productos.                                          | Riesgo alto                                |
| Editar recibo                               | No ajusta stock producto por diferencias.                                 | Riesgo alto                                |
| Eliminar recibo                             | No repone productos; solo dispositivos y periodos/pagos.                  | Riesgo alto                                |
| Anular comprobante                          | No repone productos; solo dispositivos, periodos/pagos y resumen de baja. | Riesgo alto                                |
| Guias de remision                           | Crea detalles sin reservar/descontar stock.                               | Definicion pendiente                       |
| WorkOrder accesorios                        | Crea accesorio sin descontar stock.                                       | Riesgo alto si accesorios salen de almacen |

### 5.2 Evidencia principal

- Ventas descuenta producto solo con flag: `app/Models/Ventas.php:203-214`.
- El flag existe en UI: `app/Livewire/Admin/Facturacion/Ventas/Emitir.php:66-67`.
- La emision llama `Ventas::createItems(..., $this->decrease_stock)`: `app/Livewire/Admin/Facturacion/Ventas/Emitir.php:767-768`.
- Recibos crean detalles sin stock: `app/Models/Recibos.php:134-140`.
- Recibo create llama `Recibos::createItems()` sin descuento: `app/Livewire/Admin/Ventas/Recibos/Create.php:558-560`.
- Recibo edit borra y recrea detalles sin stock diferencial: `app/Livewire/Admin/Ventas/Recibos/Edit.php:396-400`.
- Eliminar recibo no repone productos: `app/Livewire/Admin/Ventas/Recibos/EliminarRecibo.php:65-83`.
- Anular comprobante no repone productos: `app/Livewire/Admin/Facturacion/Ventas/AnularComprobante.php:149-176`.
- Compras incrementan stock: `app/Models/Compras.php:113-123`.
- Compras edit borra y recrea detalles sin ajuste de stock: `app/Livewire/Admin/Compras/Edit.php:392-402`.
- Compras delete solo hace `delete()`: `app/Livewire/Admin/Compras/Delete.php:18-23`, `app/Livewire/Admin/Compras/EliminarCompra.php:27-31`.
- `ComprasObserver::deleted()` esta vacio: `app/Observers/ComprasObserver.php:34-37`.
- Guias no afectan stock: `app/Models/GuiaRemision.php:144-151`.
- WorkOrder accessory no afecta stock: `app/Http/Controllers/Api/WorkOrderController.php:473-501`.

### 5.3 Riesgo

El stock de productos puede quedar inflado o subestimado segun el flujo usado:

- Venta SUNAT: baja stock.
- Recibo: no baja stock.
- Anulacion: no repone stock.
- Compra editada/eliminada: puede dejar stock acumulado.
- Accesorios en WorkOrder: pueden instalarse sin inventario.

Esto afecta reportes, disponibilidad, compras, tecnicos y rentabilidad.

### 5.4 Recomendacion de diseno

Crear una capa unica para movimientos de stock:

```text
StockService::salida(producto, cantidad, origen_tipo, origen_id)
StockService::entrada(producto, cantidad, origen_tipo, origen_id)
StockService::revertir(origen_tipo, origen_id)
```

Idealmente guardar tabla `stock_movimientos`:

- `producto_id`
- `tipo` entrada/salida/reversion/reserva
- `cantidad`
- `origen_type`
- `origen_id`
- `empresa_id`
- `user_id`
- `observacion`

Con esa tabla se evita duplicar logica en venta, recibo, compra, guia y WorkOrder.

### 5.5 Correcciones minimas inmediatas

1. En `Recibos::createItems()` descontar stock cuando el producto sea tipo `producto`.
2. En `EliminarRecibo::eliminar()` reponer stock de cada detalle producto.
3. En `AnularComprobante::afterSuccess()` reponer stock de cada detalle producto.
4. En `Compras\Delete` y `Compras\EliminarCompra` decrementar stock antes de eliminar o moverlo a observer.
5. En `Compras\Edit`, calcular diferencia entre detalle anterior y nuevo.
6. Envolver venta/recibo/compra + stock + dispositivo en `DB::transaction()`.
7. Validar `stock >= cantidad` antes de salidas, salvo permiso explicito de sobregiro.

---

## 6. Auditoria de dispositivos GPS

### 6.1 Estados actuales

El modelo `Dispositivos` define:

- `STOCK`
- `VENDIDO`

Referencia: `app/Models/Dispositivos.php:31-32`.

### 6.2 Donde se cambia el estado

| Flujo                              | Cambio actual                                                | Evidencia                                                                                 |
| ---------------------------------- | ------------------------------------------------------------ | ----------------------------------------------------------------------------------------- |
| Factura/boleta                     | IMEIs seleccionados pasan a `VENDIDO`.                       | `app/Livewire/Admin/Facturacion/Ventas/Emitir.php:770-783`                                |
| Anular comprobante                 | IMEIs de la venta vuelven a `STOCK`.                         | `app/Livewire/Admin/Facturacion/Ventas/AnularComprobante.php:157-168`                     |
| Crear recibo                       | IMEIs seleccionados pasan a `VENDIDO`.                       | `app/Livewire/Admin/Ventas/Recibos/Create.php:562-575`                                    |
| Editar recibo                      | IMEIs removidos vuelven a `STOCK`; nuevos pasan a `VENDIDO`. | `app/Livewire/Admin/Ventas/Recibos/Edit.php:407-416`                                      |
| Eliminar recibo                    | IMEIs del recibo vuelven a `STOCK`.                          | `app/Livewire/Admin/Ventas/Recibos/EliminarRecibo.php:65-73`                              |
| Crear vehiculo/asignar dispositivo | Solo asigna vehiculo; no cambia `estado`.                    | `app/Livewire/Admin/Vehiculos/SaveVehiculo.php:73-84`, `app/Models/Vehiculos.php:218-246` |
| WorkOrder dispositivo              | Solo historial; no cambia `estado`.                          | `app/Http/Controllers/Api/WorkOrderController.php:420-463`                                |
| WorkOrder item proyecto            | Solo texto IMEI/SIM; no cambia `estado`.                     | `app/Http/Controllers/Api/WorkOrderController.php:710-724`                                |

### 6.3 Evaluacion

La logica de dispositivos es consistente si la regla de negocio es:

```text
Un dispositivo sale de STOCK solo cuando se vende/factura/recibe.
La instalacion/asignacion a vehiculo no equivale a venta.
```

Si la regla real de Talentus es que el tecnico al instalar ya consume inventario, entonces WorkOrders tienen una brecha: guardar dispositivo o accesorio deberia reservar/descontar stock o marcar estado intermedio.

### 6.4 Riesgos detectados

| Codigo | Severidad | Riesgo                                                                                                                       |
| ------ | --------- | ---------------------------------------------------------------------------------------------------------------------------- |
| D1     | Alta      | WorkOrder puede registrar IMEI instalado sin cambiar estado a `VENDIDO`, `INSTALADO` o `RESERVADO`.                          |
| D2     | Alta      | `guardarDispositivoItem()` acepta `imei` como texto; no valida que exista en `dispositivos` ni que este disponible.          |
| D3     | Media     | El estado solo tiene `STOCK/VENDIDO`; falta estado operativo `INSTALADO` o `RESERVADO` si el proceso lo necesita.            |
| D4     | Media     | Importacion FOTA crea dispositivos en `STOCK`, pero no se observa incremento del producto vinculado por modelo en ese flujo. |
| D5     | Media     | `DispositivosObserver` no centraliza cambios de estado; la logica esta en componentes Livewire.                              |

### 6.5 Recomendacion de regla definitiva

Definir una de estas politicas:

Opcion A: Stock se consume al vender/facturar

- Mantener `STOCK` -> `VENDIDO` en factura/recibo.
- WorkOrder solo instala y registra historial.
- Debe impedirse instalar dispositivos no vendidos si la empresa no permite instalaciones antes de pago.

Opcion B: Stock se consume al instalar

- Agregar estado `INSTALADO` o `RESERVADO`.
- WorkOrder al registrar IMEI cambia `STOCK` -> `INSTALADO/RESERVADO`.
- Factura/recibo cambia `INSTALADO/RESERVADO` -> `VENDIDO`.
- Anulacion puede volver a `INSTALADO` si sigue fisicamente instalado, no necesariamente a `STOCK`.

Para Talentus, por el flujo tecnico, recomiendo Opcion B si el almacen entrega equipos a tecnicos antes de facturar.

---

## 7. Proceso modulo por modulo

### 7.1 Almacen

Productos:

- CRUD por Livewire `admin.items.*`.
- Producto tiene `stock`, `tipo`, `es_dispositivo`, `modelo_id`.
- `modelo_id` es obligatorio si `es_dispositivo=true` y debe ser unico por empresa.

Estado: funcional. Riesgo: stock no esta centralizado.

Dispositivos:

- Alta manual incrementa stock del producto vinculado por `modelo_id`.
- Alta manual crea `Dispositivos` en lote.
- Importacion FOTA crea dispositivos en `STOCK`, pero no se ve ajuste de `Productos.stock`.

Referencias:

- `app/Http/Requests/ProductosRequest.php:28-47`
- `app/Livewire/Admin/Dispositivos/Save.php:78-86`
- `app/Livewire/Admin/Dispositivos/Save.php:99-123`
- `app/Livewire/Admin/Dispositivos/Save.php:131-135`
- `app/Livewire/Admin/Dispositivos/DispositivosIndex.php:371-386`

Guias:

- Crean detalles, no mueven stock.
- Si la guia representa traslado de equipos, falta reserva o salida de almacen.

Referencia: `app/Models/GuiaRemision.php:144-151`.

### 7.2 Comercial y ventas

Presupuestos:

- Crea documentos y detalles.
- Tiene relacion con factura, recibo y WorkOrder.
- No dispara WorkOrder automatico al aprobar.

Contratos:

- Rutas y vistas estan conectadas.
- No se audito detalle legal o firma, solo ruta/flujo.

Facturacion:

- Emision descuenta stock producto y marca GPS vendido.
- El bloque no esta claramente en transaccion unica con API SUNAT; si la API falla despues de crear documento y descontar stock, puede quedar estado intermedio.

### 7.3 Operaciones y servicio tecnico

WorkOrders:

- Buen control de estados.
- Exige firma de conformidad para finalizar.
- Tiene API mobile completa.
- No automatiza stock ni facturacion al cerrar.

Tareas tecnico:

- Rutas y Livewire existen.
- Parece modulo historico paralelo a WorkOrders.
- Recomendacion: definir si WorkOrders reemplaza tareas o si ambos conviven con responsabilidades distintas.

### 7.4 Vehiculos

Alta de vehiculo:

- Permite seleccionar varios dispositivos.
- Valida disponibilidad por tabla `vehiculos_dispositivos`.
- Sincroniza principal y marca desinstalaciones.
- No cambia stock/estado del dispositivo.

Esto esta bien si asignar dispositivo no significa venderlo. Si instalarlo consume almacen, falta integracion con inventario.

Referencias:

- `app/Livewire/Admin/Vehiculos/SaveVehiculo.php:46-84`
- `app/Livewire/Admin/Vehiculos/SaveVehiculo.php:95-134`
- `app/Models/Vehiculos.php:170-309`

### 7.5 Finanzas/cobros/pagos

- Pagos usan observers para documentos de caja y periodos de cobro.
- `PeriodoCobro` tiene metodos correctos para facturado/pagado/reset.
- Falta asegurar que ventas/recibos creen y vinculen periodos de forma consistente en todos los origenes.

Referencias:

- `app/Models/PeriodoCobro.php:132-163`
- `app/Observers/PaymentsObserver.php:88-132`

### 7.6 Postventa/tickets

- Tickets tienen rutas y dashboard.
- `TicketObserver` maneja SLA, auto-asignacion y eventos.
- Es uno de los modulos mas maduros del flujo.

Recomendacion: conectar automaticamente tickets de postventa desde cierre de WorkOrder.

### 7.7 Gerencia/KPI

- Hay rutas nuevas `gerencia/kpi-dashboard` y `gerencia/kpi-equipos`.
- Hay modelos `Kpi`, `KpiResultado`, `KpiAlerta`, `Wig`, `VisitaTecnica`.
- Todo esto aparece como cambio local sin commit; no se recomienda mezclar con correcciones de inventario.

---

## 8. Observers

| Observer               | Estado                                                   | Recomendacion                                                |
| ---------------------- | -------------------------------------------------------- | ------------------------------------------------------------ |
| `ProductoObserver`     | Asigna/audita producto.                                  | No concentrar stock aqui salvo eventos claros.               |
| `DispositivosObserver` | No centraliza estados de venta/stock.                    | Registrar transiciones de estado o mover logica a servicio.  |
| `ComprasObserver`      | `deleted()` vacio.                                       | Revertir stock o delegar a `StockService`.                   |
| `VentasObserver`       | `updated()` y `deleted()` vacios.                        | Reponer stock al anular/eliminar si aplica o emitir eventos. |
| `RecibosObserver`      | Existe, revisar como punto para stock recibos.           | Agregar salida/reposicion si el recibo vende productos.      |
| `PresupuestosObserver` | No crea WorkOrder al aceptar.                            | Automatizar transicion comercial -> operaciones.             |
| `CobrosObserver`       | Registra cambios, no automatiza suscripcion/facturacion. | Conectar con periodos/suscripcion si aplica.                 |
| `PaymentsObserver`     | Robusto para caja y periodos.                            | Mantener; agregar tests.                                     |
| `WorkOrderObserver`    | Robusto para UUID/notificaciones.                        | Agregar eventos de cierre si se automatiza facturacion.      |
| `TicketObserver`       | Robusto para SLA/eventos.                                | Mantener.                                                    |

---

## 9. Hallazgos priorizados

### Criticos

1. Recibos no descuentan stock de productos.
2. Anular comprobante no repone stock de productos.
3. Eliminar recibo no repone stock de productos.
4. Editar compra borra/recrea detalles sin corregir stock.
5. Eliminar compra no revierte stock.
6. WorkOrder accesorios no descuentan stock.
7. WorkOrder proyectos aceptan IMEI como texto sin validar disponibilidad real.

### Altos

8. Facturacion descuenta stock antes/durante un flujo que luego llama API externa; falta transaccion/compensacion clara.
9. Importacion FOTA de dispositivos no parece incrementar stock de producto vinculado.
10. `facturacion.php` tiene rutas `qver`.
11. APIs publicas de consulta no tienen throttle explicito.
12. Tracking sync publico debe confirmar middleware/API key.

### Medios

13. Selects API estan en `web.php`.
14. Finanzas no usa prefijo de nombre `admin.*`.
15. `RouteServiceProvider.php` parece legado y puede confundir mantenimiento.
16. WorkOrders no generan venta/recibo/cobro al cerrar.
17. Presupuesto aceptado no genera WorkOrder.
18. Estado de dispositivos carece de `RESERVADO/INSTALADO`.

---

## 10. Plan recomendado

### Sprint 1: inventario y rutas criticas

1. Crear `StockService` o helpers privados temporales para salida/entrada/reversion.
2. Descontar productos en recibos.
3. Reponer productos en anulacion de comprobante y eliminacion de recibo.
4. Ajustar stock al editar/eliminar compra.
5. Corregir `qver` a `ver` con busqueda de usos.
6. Agregar throttle a `/api/consultas/*`.

### Sprint 2: dispositivos y WorkOrders

1. Definir politica `STOCK/VENDIDO` vs `STOCK/RESERVADO/INSTALADO/VENDIDO`.
2. Validar IMEIs reales en WorkOrder item y guardar `dispositivo_id`.
3. Descontar o reservar accesorios de WorkOrder.
4. Centralizar cambios de estado de dispositivos en servicio.
5. Sincronizar FOTA import con `Productos.stock` si el producto por modelo representa inventario contable.

### Sprint 3: proceso end-to-end

1. Presupuesto aceptado crea WorkOrder.
2. WorkOrder cerrada genera documento pendiente de facturacion o recibo.
3. Documento pagado marca periodo y dispara postventa.
4. Tickets V1/V3/V7/V15/V30 desde cierre de instalacion.
5. KPI lee estados reales del flujo.

---

## 11. Checklist tecnico para correccion

Antes de cambiar stock:

- Crear pruebas para venta con producto.
- Crear pruebas para recibo con producto.
- Crear pruebas para anulacion de venta.
- Crear pruebas para eliminar recibo.
- Crear pruebas para editar compra con cantidad mayor/menor.
- Crear pruebas para dispositivo GPS vendido y revertido.

Casos minimos:

```text
Producto stock 10
Venta 2 unidades -> stock 8
Anular venta -> stock 10

Producto stock 10
Recibo 3 unidades -> stock 7
Eliminar recibo -> stock 10

Compra 5 unidades -> stock 15
Editar compra a 2 unidades -> stock 12
Eliminar compra -> stock 10

GPS en STOCK
Venta con IMEI -> VENDIDO
Anular venta -> STOCK
```

---

## 12. Consultas utiles para auditoria en base de datos

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

-- Dispositivos vendidos sin detalle de venta ni recibo conocido por IMEI id en JSON
-- Ajustar segun motor/JSON real de la tabla detalles.
SELECT d.id, d.imei, d.estado
FROM dispositivos d
WHERE d.estado = 'VENDIDO';

-- Compras no anuladas con detalles: comparar contra movimientos cuando exista stock_movimientos
SELECT c.id, c.serie, c.correlativo, SUM(cd.cantidad) AS total_items
FROM compras c
JOIN detalle_compras cd ON cd.compras_id = c.id
WHERE c.deleted_at IS NULL
GROUP BY c.id, c.serie, c.correlativo;

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

---

## 13. Conclusion

Talentus tiene una base funcional y bastante amplia. Las rutas cargan y los modulos principales estan conectados, pero el sistema todavia depende de pasos manuales entre comercial, operaciones, facturacion y cobros.

El riesgo mas importante esta en inventario:

- Los productos se descuentan en facturacion SUNAT, pero no en recibos.
- Las anulaciones/eliminaciones no reponen productos.
- Compras editadas/eliminadas pueden dejar stock incorrecto.
- WorkOrders pueden registrar accesorios o IMEIs sin mover inventario.

La correccion debe empezar por una capa unica de movimientos de stock y por una regla formal de estados de dispositivos. Despues de eso, automatizar Presupuesto -> WorkOrder -> Venta/Recibo -> Cobro va a ser mucho mas seguro.
