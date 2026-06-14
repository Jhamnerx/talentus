# Diseño: Cobros, Planes y Períodos en Presupuestos

> **Fecha:** 2026-06-13  
> **Módulos:** Presupuestos, Ventas, Recibos, Cobros, Items, Planes

---

## 1. Estado actual — Dos flujos que no se hablan

El sistema tiene actualmente **dos arquitecturas de cobro paralelas** que operan de forma independiente:

```
FLUJO A — Puntual (Presupuestos)
  Presupuesto → Venta/Recibo → Payment

FLUJO B — Recurrente (Cobros)
  Cobro (plan + período) → PeriodoCobro → Venta/Recibo → Payment
```

El **Flujo A** no sabe nada del Flujo B. Un presupuesto aceptado con `plan_id` en sus detalles no genera automáticamente un `Cobro` periódico. Esto crea trabajo manual y riesgo de pérdida de ingresos recurrentes.

---

## 2. Conceptos clave del dominio

| Concepto | Tabla | Descripción |
|----------|-------|-------------|
| **Presupuesto** | `presupuestos` | Cotización al cliente. Puede tener ítems con planes. |
| **Detalle** | `detalle_presupuestos` | Ítem del presupuesto. Tiene `plan_id` y `plan_features`. |
| **Plan** | `plans` | Servicio recurrente con `invoice_period` + `invoice_interval`. |
| **Cobro** | `cobros` | Contrato de cobro por vehículo. 1 cobro = 1 vehículo + 1 plan. |
| **Período** | `periodos_cobros` | Ciclo de un cobro. Tiene fechas + estado (PENDIENTE → FACTURADO → PAGADO). |
| **Venta** | `ventas` | Comprobante de emisión (Factura/Boleta). |
| **Recibo** | `recibos` | Comprobante de pago (Recibo de honorarios). |
| **Payment** | `payments` | Registro del dinero recibido. Polimórfico (vincula a Venta o Recibo). |

---

## 3. Los dos tipos de ítems en un presupuesto

Un presupuesto puede mezclar dos tipos de ítems:

### Ítem puntual (sin plan)
- Venta de equipo GPS, instalación, servicio técnico
- `plan_id = null`
- Se factura una sola vez
- `cantidad × valor_unitario` es el total

### Ítem recurrente (con plan)
- Monitoreo satelital mensual, plataforma anual
- `plan_id ≠ null`
- Tiene período de cobro (MENSUAL, TRIMESTRAL, ANUAL, etc.)
- `cantidad` = número de vehículos/unidades
- `valor_unitario` = precio por unidad por período
- El presupuesto muestra el precio del período seleccionado

---

## 4. El problema del período en presupuestos

### Situación actual
```
Plan "Monitoreo Básico"
  → invoice_interval: month
  → invoice_period: 1
  → price: S/. 420.00/mes

Presupuesto — ítem:
  cantidad: 2 (vehículos)
  valor_unitario: 420.00
  sub_total: 840.00  ← ¿por mes? ¿por año?
```

El presupuesto no indica si el total es por mes, por año, o por única vez. El cliente no sabe exactamente qué está aprobando.

### Solución propuesta

Agregar `periodo_cobranza` al `detalle_presupuestos` para que cada ítem pueda tener su propio período de facturación independiente del plan base:

```
MENSUAL | BIMENSUAL | TRIMESTRAL | SEMESTRAL | ANUAL | UNICO
```

Esto permite:
- Plan mensual facturado anualmente (precio × 12 en un solo cobro)
- Plan mensual con pago mensual
- Dos planes en el mismo presupuesto con períodos distintos

---

## 5. Cómo mostrar planes y períodos en el PDF

### Estructura visual por ítem:

```
┌─────────────┬────────────┬────────────────────────────────────────┬──────────────┬──────────────┐
│  CANTIDAD   │   CÓDIGO   │ DESCRIPCIÓN                            │  VALOR UNIT. │  VALOR TOTAL │
├─────────────┼────────────┼────────────────────────────────────────┼──────────────┼──────────────┤
│      2      │  PROD-3014 │ MONITOREO SATELITAL PLATAFORMA         │  S/. 420.00  │  S/. 840.00  │
│             │            │ SERVICIO STANDAR PLAN ANUAL [Mensual]  │              │              │
│             │            │ - Transmisión: 1 minuto                │              │              │
│             │            │ - Historial: 3 meses                   │              │              │
│             │            │ - Geocercas                            │              │              │
│             │            │ Período de cobro: Mensual              │              │              │
└─────────────┴────────────┴────────────────────────────────────────┴──────────────┴──────────────┘
```

**Reglas de display:**
- El badge `[Mensual]` viene de `Plan.invoice_interval`
- "Período de cobro" en la descripción aclara la frecuencia al cliente
- Si `periodo_cobranza` difiere del plan base (ej: plan mensual, cobro anual), mostrar ambos:
  - `[Plan: Mensual | Cobro: Anual]`
- El `VALOR UNIT.` siempre es el precio por período de cobro

---

## 6. Flujo unificado propuesto

```
                    PRESUPUESTO
                        │
              ┌─────────┴─────────┐
              │                   │
         Ítems puntuales    Ítems recurrentes
         (sin plan)         (con plan_id + periodo_cobranza)
              │                   │
              └─────────┬─────────┘
                        │
                   ACEPTADO
                        │
              ┌─────────┴─────────────────────────────┐
              │                                       │
      Generar VENTA/RECIBO                    Generar COBROS
      por ítems puntuales                     (1 por vehículo)
              │                                       │
          PAGO ÚNICO                          PERIODOS_COBROS
                                              (ciclos automáticos)
                                                      │
                                              Generar VENTA/RECIBO
                                              por período
                                                      │
                                                   PAGO
```

---

## 7. Campos a agregar (migración)

### `detalle_presupuestos`
```php
$table->string('periodo_cobranza')->nullable()->after('plan_id');
// Valores: MENSUAL | BIMENSUAL | TRIMESTRAL | SEMESTRAL | ANUAL | UNICO | null
// null = ítem puntual sin recurrencia
```

### `presupuestos`
```php
$table->boolean('tiene_recurrentes')->default(false)->after('features');
// Calculado al guardar: true si algún detalle tiene plan_id
// Permite filtrar presupuestos que generarán cobros
```

---

## 8. Lógica del selector de período en el modal de ítems

Cuando el usuario selecciona un plan en `ModalAddProducto`, mostrar un selector de período:

```
Plan seleccionado: Monitoreo Básico (S/. 420.00/mes)
Período de cobro: [Mensual ▼]  ← options: Mensual / Trimestral / Semestral / Anual

                        → Valor unitario: S/. 420.00  (mensual)
                        → Valor unitario: S/. 1,260.00 (trimestral = 420 × 3)
                        → Valor unitario: S/. 2,520.00 (semestral = 420 × 6)
                        → Valor unitario: S/. 5,040.00 (anual = 420 × 12)
```

**El precio se recalcula automáticamente** al cambiar el período: `precio_base × multiplicador`.

Multiplicadores:
| Período | Multiplicador |
|---------|--------------|
| MENSUAL | 1 |
| BIMENSUAL | 2 |
| TRIMESTRAL | 3 |
| SEMESTRAL | 6 |
| ANUAL | 12 |

---

## 9. Generación automática de Cobros al aceptar presupuesto

Cuando un presupuesto pasa a estado `ACEPTADA` y tiene ítems con `plan_id`:

```php
// En PresupuestosObserver::updated() cuando estado cambia a ACEPTADA:

foreach ($presupuesto->detalles->whereNotNull('plan_id') as $detalle) {
    // Para cada vehículo en el ítem (cantidad = nro de vehículos)
    // Se crea 1 Cobro con:
    Cobros::create([
        'empresa_id'       => $presupuesto->empresa_id,
        'clientes_id'      => $presupuesto->clientes_id,
        'vehiculos_id'     => null,  // Pendiente de asignar (flujo separado)
        'plan_id'          => $detalle->plan_id,
        'periodo'          => $detalle->periodo_cobranza,
        'monto'            => $detalle->valor_unitario,
        'divisa'           => $presupuesto->divisa,
        'tipo_pago'        => ...,  // FACTURA o RECIBO según cliente
        'fecha_inicio'     => $presupuesto->fecha,
        'fecha_vencimiento'=> ...,  // fecha + 1 período
        'estado'           => 'ACTIVO',
        'nota'             => 'Generado desde presupuesto ' . $presupuesto->serie_correlativo,
    ]);
}
```

**Nota:** La asignación de vehículos puede ser manual post-aceptación (muchas veces el cliente no tiene los vehículos listos al firmar el contrato).

---

## 10. Pantalla de resumen del presupuesto — sección de recurrentes

Cuando un presupuesto tiene ítems recurrentes, mostrar una sección adicional en la vista:

```
┌─────────────────────────────────────────────────┐
│  SERVICIOS RECURRENTES                          │
├─────────────────────────────────────────────────┤
│  Plan              │ Período   │ Monto/período  │
├────────────────────┼───────────┼────────────────┤
│  Monitoreo Básico  │ Mensual   │ S/. 840.00     │
│  Plataforma Pro    │ Anual     │ S/. 3,600.00   │
├────────────────────┴───────────┴────────────────┤
│  Total mensual recurrente: S/. 840.00           │
│  Total anual recurrente:   S/. 4,440.00         │
└─────────────────────────────────────────────────┘
```

---

## 11. Estado de presupuestos — agregar FACTURADO

El enum `PresupuestosStatus` actualmente tiene: `PENDIENTE (0)`, `ACEPTADA (1)`, `RECHAZADA (2)`.

Propuesta de estados extendidos:

```
PENDIENTE   → Enviado al cliente, esperando respuesta
ACEPTADA    → Cliente aprobó, pendiente de facturar
FACTURADA   → Venta/Recibo emitido (ítems puntuales)
ACTIVA      → Cobros periódicos generados y activos
RECHAZADA   → Cliente rechazó
VENCIDA     → Pasó la fecha de caducidad sin respuesta
```

---

## 12. Correcciones de integridad referencial

### Recibos → debe vincularse a Ventas, no a Presupuestos
```
Estado actual:  recibos.presupuestos_id → presupuestos
Correcto:       recibos.ventas_id → ventas (cuando aplica)
                recibos.presupuestos_id puede quedar para recibos sin factura previa
```

### PeriodoCobro → verificar que el recibo/venta sea del período correcto
```php
// En PaymentsObserver, al marcar PAGADO:
// Verificar que venta.fecha_emision está dentro de periodo.fecha_inicio → periodo.fecha_fin
```

---

## 13. Resumen de tareas de implementación

| Prioridad | Tarea | Impacto |
|-----------|-------|---------|
| 🔴 Alta | Agregar `periodo_cobranza` a `detalle_presupuestos` | Desbloquea todo lo demás |
| 🔴 Alta | Selector de período en `ModalAddProducto` con recálculo de precio | UX crítica |
| 🔴 Alta | Mostrar período y precio/período en PDF (`pdf-new.blade.php`) | Claridad al cliente |
| 🟡 Media | Generación automática de `Cobros` al aceptar presupuesto | Automatización |
| 🟡 Media | Sección "Servicios Recurrentes" en vista del presupuesto | Visibilidad |
| 🟡 Media | Extender `PresupuestosStatus` con estados adicionales | Trazabilidad |
| 🟢 Baja | Corregir relación recibos → ventas | Integridad |
| 🟢 Baja | Validar período correcto en PaymentsObserver | Robustez |

---

## 14. Prioridad inmediata recomendada

**Sprint 1 (más impacto, menos riesgo):**
1. Migración: `periodo_cobranza` en `detalle_presupuestos`
2. Modal: selector de período con recálculo automático de precio
3. PDF: mostrar período de cobro y nombre del plan (ya parcialmente hecho)

**Sprint 2:**
4. Vista presupuesto: sección resumen de servicios recurrentes
5. Observer: generación automática de Cobros al aceptar presupuesto

**Sprint 3:**
6. Estados extendidos de presupuestos
7. Correcciones de integridad referencial
