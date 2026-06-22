# Cliente 360° · SP#3 Customer Health Score — Design Spec

## Contexto

Tercer sub-proyecto del módulo "Calificación 360° del Cliente" (ver roadmap completo en `docs/superpowers/specs/2026-06-18-cliente-360-sp1-dashboard-base-design.md`). SP#1 (dashboard de solo lectura) y SP#2 (evaluaciones/reseñas) ya están completos.

El spec original de SP#1 mencionaba un Customer Health Score (CHS) con "7 factores ponderados" pero nunca los especificó. El usuario delegó la propuesta de los 7 factores al asistente, con la condición de basarlos en datos que ya existen en el sistema (no inventar campos nuevos de captura). Este spec cubre **solo SP#3**: el motor de cálculo, la tabla de historial mensual y el indicador visual en el dashboard de SP#1.

## Los 7 factores del CHS

Cada factor produce un sub-score de 0 a 100. El score final es el promedio ponderado de los sub-scores disponibles (ver "Manejo de datos faltantes" abajo).

| # | Factor | Peso | Fuente de datos | Fórmula |
|---|--------|------|------------------|---------|
| 1 | Pagos/Cobranza | 25% | `Cobros`/`PeriodoCobro` | `100 × (cobros_al_día / cobros_activos_totales)` del cliente |
| 2 | Soporte/Tickets | 20% | `Ticket` (SLA) | `100 - penalización` por tickets vencidos/abiertos fuera de SLA, normalizado 0-100 |
| 3 | GPS/Vehículos activos | 15% | `Vehiculos.gpswox_active` | `100 × (vehículos con gpswox_active=true / total vehículos)` |
| 4 | Antigüedad/Lealtad | 10% | `Clientes.created_at` + `Contratos` | Tramos por años de antigüedad (<6m=40, 6-12m=60, 1-3a=80, 3a+=100), ajustado si tiene contratos vigentes |
| 5 | Comunicación WhatsApp | 10% | `WhatsappConversation` | Tramos por recencia del último mensaje (≤7d=100, ≤30d=70, ≤90d=40, >90d=10) |
| 6 | Satisfacción — Reseñas | 10% | `Resena.calificacion` (SP#2) | `(promedio calificacion últimos 6 meses - 1) / 4 × 100` |
| 7 | Satisfacción — Órdenes de trabajo | 10% | `WorkOrder.calificacion_cliente` | `(promedio calificacion_cliente últimos 6 meses - 1) / 4 × 100` |

Los pesos de los factores 1-3 (25/20/15 = 60%) reflejan que son las fuentes de datos más fuertes y estructuradas del sistema (`scopeVencidos()`, `scopeProximosAVencer()`, `scopeOverdue()` ya existentes). Los factores 4-5 (10% c/u = 20%) son señales medias. Los factores 6-7 (10% c/u = 20%) son señales débiles/dispersas hoy (reseñas y calificación de OT son campos nuevos con poca data histórica), pero se incluyen porque son exactamente el tipo de señal cualitativa que un "Customer Health Score" debe capturar — su peso bajo limita el impacto mientras la data madura.

### Detalle de fórmulas por factor

**1. Pagos/Cobranza (25%)** — Sobre los `Cobros` activos del cliente (todas las suscripciones/cobros recurrentes no cancelados), se calcula la proporción que está al día (`! $cobro->vencido`) usando el accessor `getVencidoAttribute()` ya existente. Si el cliente no tiene ningún `Cobro` activo, el factor se excluye (sin datos).

**2. Soporte/Tickets (20%)** — Sobre los `Ticket` del cliente en los últimos 6 meses: `100 - (tickets_vencidos / tickets_totales × 100)`, usando `Ticket::scopeOverdue()`/`isOverdue()` ya existentes. Si el cliente no tiene tickets en el período, el factor se excluye.

**3. GPS/Vehículos activos (15%)** — Proporción de `Vehiculos` del cliente con `gpswox_active = true` sobre el total de vehículos del cliente. Si el cliente no tiene vehículos, el factor se excluye.

**4. Antigüedad/Lealtad (10%)** — Score base por tramo de antigüedad desde `Clientes.created_at` (siempre poblado, nunca se excluye este factor): menos de 6 meses = 40, 6-12 meses = 60, 1-3 años = 80, 3+ años = 100. Si el cliente tiene al menos un `Contrato` vigente (`estado = true`), se suma un bono de +10 al resultado del tramo, máximo 100.

**5. Comunicación WhatsApp (10%)** — Según los días transcurridos desde el último mensaje en `WhatsappConversation` del cliente: ≤7 días = 100, ≤30 días = 70, ≤90 días = 40, más de 90 días = 10. Si el cliente nunca ha tenido conversación de WhatsApp, el factor se excluye.

**6. Satisfacción — Reseñas (10%)** — Promedio de `Resena.calificacion` (donde no es null) de los últimos 6 meses, escalado de la escala 1-5 a 0-100 con `(promedio - 1) / 4 × 100`. Si no hay reseñas con calificación en el período, el factor se excluye.

**7. Satisfacción — Órdenes de trabajo (10%)** — Igual que el factor 6 pero sobre `WorkOrder.calificacion_cliente`. Si no hay OTs calificadas en el período, el factor se excluye.

## Manejo de datos faltantes

Si un factor no tiene datos suficientes para un cliente (ver condiciones de exclusión arriba), se excluye del cálculo y su peso se redistribuye proporcionalmente entre los factores que sí tienen datos. Ejemplo: si faltan los factores 6 y 7 (20% de peso combinado), los pesos de los factores 1-5 se escalan proporcionalmente para sumar 100%.

Si **ningún** factor tiene datos suficientes para un cliente, no se genera registro de `ChsHistorico` para ese cliente ese mes — el dashboard mostrará el estado "CHS aún no calculado".

## Escala y categorías

Score final: 0-100, redondeado a entero. Categorías:

- **Excelente**: 80-100 (verde)
- **Bueno**: 60-79 (azul)
- **En riesgo**: 40-59 (amarillo)
- **Crítico**: 0-39 (rojo)

## Cálculo y almacenamiento

Snapshot mensual programado, no cálculo en vivo. Un comando Artisan se ejecuta vía scheduler el día 1 de cada mes a las 02:00am, calcula el CHS de todos los clientes de todas las empresas y guarda un registro por cliente en `chs_historico`. El dashboard de SP#1 siempre lee el último snapshot guardado — no recalcula en cada visita.

## Arquitectura

```
[Schedule: día 1 de cada mes, 02:00am] (bootstrap/app.php -> withSchedule())
        |
        v
[php artisan chs:calcular-mensual] (App\Console\Commands\CalcularChsMensual)
        |
        ├─ itera todos los Clientes (todas las empresas, sin scope de empresa de sesión)
        |
        v
[ChsCalculatorService::calcularParaCliente(Clientes $cliente): ?ChsResultado]
        |
        ├─ ejecuta los 7 sub-cálculos (cada uno retorna float|null)
        ├─ redistribuye pesos entre los factores con datos
        ├─ si ningún factor tiene datos: retorna null (no se crea registro)
        └─ retorna ChsResultado (score_final, categoria, factores_detalle)
        |
        v
[ChsHistorico::updateOrCreate(['cliente_id', 'periodo'], [...])]
        |
        v
[Client360Dashboard] — Eloquent query del último ChsHistorico del cliente
        |
        ├─ Badge con score + color de categoría
        └─ Mini-gráfico de tendencia (últimos 6-12 ChsHistorico)
```

Un cliente con error durante su cálculo individual (ej. excepción en una de las queries) se loguea con `Log::error()` y el comando continúa con el resto de clientes — un fallo aislado no debe interrumpir la corrida completa.

## Componentes a crear/modificar

**Migración**

- Create `database/migrations/xxxx_create_chs_historico_table.php` — tabla `chs_historico`: `id, empresa_id, cliente_id, periodo (date), score_final (unsignedTinyInteger), categoria (enum: excelente,bueno,en_riesgo,critico), factores_detalle (json), created_at, updated_at`. FK a `empresas`/`clientes` con cascade delete. Índice único compuesto `(cliente_id, periodo)`.

**Modelo**

- Create `app/Models/ChsHistorico.php` — con `EmpresaScope` propio (sigue el patrón del resto de modelos de la app), relación `cliente(): BelongsTo` con `withoutGlobalScope(EmpresaScope::class)`, cast de `factores_detalle` a `array` y de `periodo` a `date`.
- Modify `app/Models/Clientes.php` — agregar `chsHistorico(): HasMany` con `withoutGlobalScope(EmpresaScope::class)`.

**Service de cálculo**

- Create `app/Services/Chs/ChsCalculatorService.php` — método público `calcularParaCliente(Clientes $cliente): ?array`, con un método privado por factor (`calcularFactorPagos`, `calcularFactorTickets`, `calcularFactorGps`, `calcularFactorAntiguedad`, `calcularFactorWhatsapp`, `calcularFactorResenas`, `calcularFactorOrdenesTrabajo`), cada uno retornando `?float` (null = sin datos, excluido). Un método privado `combinarFactores(array $subscores): array` aplica la redistribución de pesos y retorna `['score_final' => int, 'categoria' => string, 'factores_detalle' => array]`.

**Comando Artisan**

- Create `app/Console/Commands/CalcularChsMensual.php` — `php artisan chs:calcular-mensual`, itera `Clientes::withoutGlobalScope(EmpresaScope::class)->cursor()` (todas las empresas), llama al service por cliente, hace `ChsHistorico::updateOrCreate()` cuando hay resultado, captura excepciones por cliente con `Log::error()` sin detener la corrida, reporta un resumen final (`N clientes procesados, M con score, K omitidos por falta de datos, E con error`).
- Modify `bootstrap/app.php` — registrar el schedule: `->withSchedule(fn (Schedule $schedule) => $schedule->command('chs:calcular-mensual')->monthlyOn(1, '02:00'))`.

**Dashboard (SP#1)**

- Modify `app/Livewire/Admin/Clientes/Client360Dashboard.php` — cargar el último `ChsHistorico` del cliente (`$cliente->chsHistorico()->latest('periodo')->first()`) y los últimos 6-12 para la tendencia, pasarlos a la vista.
- Modify `resources/views/livewire/admin/clientes/client360-dashboard.blade.php` — agregar sección de badge CHS (score + color de categoría) en el header, junto con mini-gráfico de tendencia (reutilizar librería de gráficos ya presente en el proyecto si existe, o gráfico simple con barras/puntos en CSS si no). Estado vacío "CHS aún no calculado" cuando no hay ningún `ChsHistorico`.

## Manejo de errores

- Cliente sin datos en ningún factor: no se crea registro ese mes, dashboard muestra "CHS aún no calculado".
- Error al calcular un cliente específico (excepción en una query): se loguea con `Log::error`, el comando continúa con el resto.
- Comando ejecutado dos veces el mismo mes (reintento manual): `updateOrCreate` sobre `(cliente_id, periodo)` evita duplicados, simplemente sobrescribe el snapshot del mes.
- Sin permiso `ver-cliente-360`: ya cubierto por SP#1 (mismo middleware de ruta, el badge CHS es parte de la misma página).

## Testing

Sin `php artisan test` (restricción del proyecto). Verificación: `php -l` en cada archivo PHP nuevo/modificado, más pruebas funcionales vía `php artisan tinker --execute=...` envueltas en `DB::beginTransaction()`/`DB::rollBack()` para verificar el cálculo de un cliente real (con y sin datos en distintos factores) sin dejar residuo en la base de datos. Verificar también manualmente que `php artisan chs:calcular-mensual` corre sin errores sobre los clientes reales (en modo de solo lectura, sin commitear si se usa dentro de una transacción de prueba, o aceptando que sí escriba si se corre tal cual está pensado para producción).

## Fuera de alcance (este SP)

- Panel gerencial, ranking de clientes por CHS, alertas automáticas cuando el CHS baja de cierto umbral, motor de recomendaciones (todo esto es SP#4).
- Recalculo manual/bajo demanda ("recalcular ahora") — se evaluó como opción pero se descartó a favor del snapshot mensual simple; puede agregarse en una iteración futura si se necesita.
- Edición manual del CHS por un usuario (el score siempre se deriva del cálculo automático, nunca es editable a mano).
- Nuevos campos de captura de datos — los 7 factores usan exclusivamente datos que ya existen en el sistema.
