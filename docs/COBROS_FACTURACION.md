# Proceso de Cobros y Facturación — Talentus

---

## 1. Registro de Cobro

Al registrar un nuevo cobro para un cliente, se configura:

| Campo                          | Descripción                                          |
| ------------------------------ | ---------------------------------------------------- |
| **Cliente**                    | A quién se factura                                   |
| **Vehículos**                  | Uno o más, cada uno con su propio plan y período     |
| **Plan**                       | Define el precio (Básico, Estándar, Premium, etc.)   |
| **Período**                    | MENSUAL / BIMENSUAL / TRIMESTRAL / SEMESTRAL / ANUAL |
| **Fecha inicio / vencimiento** | Rango del servicio contratado                        |
| **Tipo de comprobante**        | FACTURA / BOLETA / RECIBO                            |
| **Divisa**                     | PEN o USD                                            |

Al guardar:

1. Se crea el **Cobro** (cabecera) y sus **Detalles** (uno por vehículo)
2. Se crea o actualiza la **suscripción** `gps-tracking` de cada vehículo con las fechas configuradas
3. Se genera automáticamente una **Notificación de Cobro** `PENDIENTE` para el período actual ← **inmediato, no espera al job**

> **Opción "Cobrar ahora"**: si se activa el checkbox al guardar, el sistema redirige directamente al formulario de emisión del comprobante.

---

## 2. Notificaciones de Cobro

Las notificaciones son los **avisos de cobro pendiente**, uno por vehículo por período.

### Estados posibles

```
PENDIENTE → FACTURADO → PAGADO
    └──────────────────→ CANCELADO
```

| Estado        | Significado                                                         |
| ------------- | ------------------------------------------------------------------- |
| **PENDIENTE** | Cobro generado, aún no facturado                                    |
| **FACTURADO** | Se emitió el comprobante (Factura/Boleta/Recibo), pendiente de pago |
| **PAGADO**    | El cliente pagó                                                     |
| **CANCELADO** | Anulado manualmente                                                 |

### Información que contiene cada notificación

- Cliente y vehículo
- Descripción: `Cobro mensual - Servicio GPS - Plan Básico - Vehículo: ABC-123`
- Rango del período: `26/03/2026 → 26/04/2026`
- Fecha de vencimiento (cuando debe pagarse)
- Monto y moneda

---

## 3. Generación automática de renovaciones

El sistema ejecuta un **job diario a las 08:00 AM** que detecta vehículos cuya suscripción vence en los próximos **7 días** y genera automáticamente la notificación de renovación para el siguiente período.

### Ejemplo completo — Vehículo ABC-123, plan MENSUAL

```
23/03  Alta del cobro
       ├─ Suscripción: 23/03 → 23/04
       └─ Notificación PENDIENTE: período 23/03 → 23/04

       [Se factura y paga → estado PAGADO]
       → NO avanza fechas (fue cobro inicial, el servicio ya corre)

16/04  Job 08:00 AM (7 días antes del vencimiento 23/04)
       └─ Notificación PENDIENTE: período 23/04 → 23/05

       [Se factura y paga → estado PAGADO]
       → DetalleCobro actualizado: 23/04 → 23/05
       → Suscripción extendida: ends_at = 23/05

16/05  Job genera siguiente renovación → ciclo se repite
```

### Identificación del tipo de notificación

El sistema distingue entre cobro inicial y renovación según `fecha_inicio` vs `det.fecha_vencimiento`:

| Tipo                          | `fecha_inicio` de la notif              | Avanza DetalleCobro? |
| ----------------------------- | --------------------------------------- | -------------------- |
| **Cobro inicial** (Save/Edit) | `fecha_inicio < det.fecha_vencimiento`  | ❌ No                |
| **Renovación** (job diario)   | `fecha_inicio >= det.fecha_vencimiento` | ✅ Sí                |

---

## 4. Flujo de facturación

Desde el listado de **Notificaciones de Cobro** se puede:

### Opción A — Emitir comprobante primero, luego registrar pago

```
[Facturar] → Formulario de Factura/Boleta/Recibo
           → Al emitir: estado cambia a FACTURADO + se vincula el documento
           → Luego: registrar el pago desde el modal de pago
           → Estado final: PAGADO
```

### Opción B — Registrar pago directamente (asociando documento existente)

```
[Registrar Pago] → Modal de pago
                 → Seleccionar documento emitido (factura/boleta/recibo)
                 → Seleccionar método de pago y destino (caja/banco)
                 → Estado final: PAGADO
```

### Opción C — Facturación en lote

Seleccionar múltiples notificaciones del **mismo cliente** y emitir un solo comprobante que las agrupa.

### Decisión del tipo de comprobante

| Condición                                 | Comprobante          |
| ----------------------------------------- | -------------------- |
| `cobro.tipo_pago = 'RECIBO'`              | Recibo de honorarios |
| Cliente con RUC (`tipo_documento_id = 6`) | Factura              |
| Cualquier otro documento de identidad     | Boleta               |

---

## 5. Efecto al registrar un pago

Cuando se marca una **notificación de renovación** como pagada:

1. El `DetalleCobro` avanza su rango: `fecha_inicio` y `fecha_vencimiento` se actualizan al nuevo período
2. La **suscripción** del vehículo extiende su `ends_at` al nuevo vencimiento
3. El job del siguiente ciclo detectará este nuevo `ends_at` y generará la próxima renovación

> Las notificaciones del **cobro inicial** (el primer período al registrar el servicio) **no avanzan fechas** al pagarse — el servicio ya estaba activo desde el inicio.

---

## 6. Descripción del comprobante

El campo descripción de cada notificación sigue el formato:

```
Cobro {período} - {Servicio} - {Plan} - Vehículo: {PLACA}
```

Ejemplo:

```
Cobro mensual - Rastreo GPS Vehicular - Plan Básico - Vehículo: A0T-950
```

Fuentes de cada parte:

- **Período**: `DetalleCobros.periodo`
- **Servicio**: `Productos.descripcion` del cobro (o `-` si no hay producto)
- **Plan**: `Plan.name` del `DetalleCobros.plan_id` (o `-` si no tiene plan)
- **Vehículo**: `Vehiculos.placa`

---

## 7. Generación manual de notificaciones

Para forzar la generación de notificaciones sin esperar al job automático:

```bash
# Con los 7 días por defecto
php artisan cobros:generar-notificaciones

# Con días personalizados (ej: 3 días de anticipación)
php artisan cobros:generar-notificaciones --dias=3
```

---

## 8. Resumen de responsabilidades

| Componente                               | Qué hace                                                                     |
| ---------------------------------------- | ---------------------------------------------------------------------------- |
| `Save.php` (al guardar cobro nuevo)      | Crea notificación del período actual inmediatamente para todos los vehículos |
| `Edit.php` (al guardar edición)          | Crea notificación solo para vehículos nuevos sin notificación activa         |
| `GenerarNotificacionesCobro` (job 08:00) | Genera renovaciones 7 días antes del vencimiento de la suscripción           |
| Checkbox **"Cobrar ahora"**              | Redirige al formulario de emisión al guardar                                 |
| `NotificacionCobro::marcarComoPagado()`  | Avanza el período solo en renovaciones (no en cobro inicial)                 |
| `DetalleCobroObserver`                   | Sincroniza `ends_at` de la suscripción del vehículo automáticamente          |
| `Notificaciones.php`                     | Listado, modal de pago, facturación individual y en lote                     |
