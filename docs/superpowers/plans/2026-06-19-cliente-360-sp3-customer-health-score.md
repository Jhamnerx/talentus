# Cliente 360° · SP#3 Customer Health Score — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build the Customer Health Score (CHS) engine — 7 weighted factors computed from existing data, stored as a monthly snapshot per client, displayed as a badge + trend chart on the SP#1 Cliente 360° dashboard.

**Architecture:** A scheduled Artisan command (`chs:calcular-mensual`, runs the 1st of each month at 02:00am) iterates every client across all companies and delegates the per-client calculation to `ChsCalculatorService`. Each of the 7 factors returns a 0-100 sub-score or `null` if the client lacks data for that factor; missing factors are excluded and their weight redistributed proportionally among the available ones. The result is persisted as one row per client per month in `chs_historico`. The dashboard reads the latest snapshot (and up to the last 12) directly via Eloquent — no live recalculation on page load.

**Tech Stack:** Laravel 12, Eloquent, Artisan scheduler (`bootstrap/app.php` → `withSchedule()`), Livewire 4, Tailwind CSS v4 (no new JS/Chart.js dependency — the trend mini-chart is built with plain CSS bars to avoid requiring an `npm run build`).

**Project-specific testing constraint:** Per project rule, **never run `php artisan test`** (it uses `RefreshDatabase` against the real development database). Verification per step is `php -l <file>` for syntax, and `php artisan tinker --execute="..."` for functional checks. Any tinker check that creates data must be wrapped in `DB::beginTransaction()` / `DB::rollBack()` so it leaves zero residue in the database.

---

### Task 1: Migración `chs_historico`

**Files:**
- Create: `database/migrations/2026_07_27_000001_create_chs_historico_table.php`

- [ ] **Step 1: Crear el archivo de migración**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chs_historico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('cliente_id');
            $table->date('periodo');
            $table->unsignedTinyInteger('score_final');
            $table->string('categoria');
            $table->json('factores_detalle');
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->unique(['cliente_id', 'periodo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chs_historico');
    }
};
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l database/migrations/2026_07_27_000001_create_chs_historico_table.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Ejecutar la migración**

Run: `php artisan migrate --no-interaction`
Expected: la migración `2026_07_27_000001_create_chs_historico_table` aparece como `DONE`.

- [ ] **Step 4: Verificar la tabla creada**

Run: `php artisan tinker --execute="echo Illuminate\Support\Facades\Schema::hasTable('chs_historico') ? 'OK' : 'FALTA';"`
Expected: `OK`

- [ ] **Step 5: Commit**

```bash
git add database/migrations/2026_07_27_000001_create_chs_historico_table.php
git commit -m "feat(cliente-360): migracion tabla chs_historico"
```

---

### Task 2: Enum `ChsCategoria`

**Files:**
- Create: `app/Enums/ChsCategoria.php`

Sigue exactamente el patrón ya usado en `app/Enums/CobroEstado.php` y `app/Enums/TicketStatus.php` (enum respaldado por string, con métodos `label()`/`color()`/`bgColor()` para la UI).

- [ ] **Step 1: Crear el enum**

```php
<?php

namespace App\Enums;

enum ChsCategoria: string
{
    case EXCELENTE = 'excelente';
    case BUENO = 'bueno';
    case EN_RIESGO = 'en_riesgo';
    case CRITICO = 'critico';

    public function label(): string
    {
        return match ($this) {
            self::EXCELENTE => 'Excelente',
            self::BUENO => 'Bueno',
            self::EN_RIESGO => 'En riesgo',
            self::CRITICO => 'Crítico',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::EXCELENTE => 'text-emerald-600',
            self::BUENO => 'text-blue-600',
            self::EN_RIESGO => 'text-amber-600',
            self::CRITICO => 'text-rose-600',
        };
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::EXCELENTE => 'bg-emerald-100 text-emerald-700',
            self::BUENO => 'bg-blue-100 text-blue-700',
            self::EN_RIESGO => 'bg-amber-100 text-amber-700',
            self::CRITICO => 'bg-rose-100 text-rose-700',
        };
    }

    public function barColor(): string
    {
        return match ($this) {
            self::EXCELENTE => 'bg-emerald-500',
            self::BUENO => 'bg-blue-500',
            self::EN_RIESGO => 'bg-amber-500',
            self::CRITICO => 'bg-rose-500',
        };
    }

    public static function paraScore(int $score): self
    {
        return match (true) {
            $score >= 80 => self::EXCELENTE,
            $score >= 60 => self::BUENO,
            $score >= 40 => self::EN_RIESGO,
            default => self::CRITICO,
        };
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Enums/ChsCategoria.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verificación funcional**

Run: `php artisan tinker --execute="echo App\Enums\ChsCategoria::paraScore(85)->value . ' / ' . App\Enums\ChsCategoria::paraScore(45)->label();"`
Expected: `excelente / En riesgo`

- [ ] **Step 4: Commit**

```bash
git add app/Enums/ChsCategoria.php
git commit -m "feat(cliente-360): enum ChsCategoria"
```

---

### Task 3: Modelo `ChsHistorico` + relaciones nuevas en `Clientes`

**Files:**
- Create: `app/Models/ChsHistorico.php`
- Modify: `app/Models/Clientes.php:168-171` (justo después del método `resenas()`, antes del cierre de la clase)

- [ ] **Step 1: Crear el modelo `ChsHistorico`**

```php
<?php

namespace App\Models;

use App\Enums\ChsCategoria;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChsHistorico extends Model
{
    use HasFactory;

    protected $table = 'chs_historico';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'periodo' => 'date',
        'score_final' => 'integer',
        'categoria' => ChsCategoria::class,
        'factores_detalle' => 'array',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }
}
```

- [ ] **Step 2: Agregar las relaciones nuevas en `Clientes.php`**

En `app/Models/Clientes.php`, justo después de:

```php
    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }
}
```

Reemplazar por (agrega tres relaciones nuevas antes del cierre de la clase):

```php
    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function chsHistorico(): HasMany
    {
        return $this->hasMany(ChsHistorico::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(WorkOrder::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function whatsappConversaciones(): HasMany
    {
        return $this->hasMany(\App\Models\WhatsFleep\WhatsappConversation::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }
}
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Models/ChsHistorico.php && php -l app/Models/Clientes.php`
Expected: `No syntax errors detected` en ambos.

- [ ] **Step 4: Verificación funcional**

Run: `php artisan tinker --execute="\$c = App\Models\Clientes::first(); echo get_class(\$c->chsHistorico()) . ' / ' . get_class(\$c->ordenesTrabajo()) . ' / ' . get_class(\$c->whatsappConversaciones());"`
Expected: las tres líneas resuelven a `Illuminate\Database\Eloquent\Relations\HasMany` sin error.

- [ ] **Step 5: Commit**

```bash
git add app/Models/ChsHistorico.php app/Models/Clientes.php
git commit -m "feat(cliente-360): modelo ChsHistorico y relaciones chsHistorico/ordenesTrabajo/whatsappConversaciones en Clientes"
```

---

### Task 4: `ChsCalculatorService` — motor de cálculo de los 7 factores

**Files:**
- Create: `app/Services/Chs/ChsCalculatorService.php`

**Contexto para el implementador:** Este service NO se prueba con `php artisan test` (restricción del proyecto). Verifica cada método con `php artisan tinker` contra clientes reales, usando transacciones si necesitas crear datos de prueba.

Fórmulas exactas (ya validadas en el spec, no reinterpretar):

1. **Pagos/Cobranza (peso 25)**: de `$cliente->cobros()->activos()->get()` (scope `activos()` ya existe en `Cobros`), `100 × (cantidad con accessor ->vencido === false) / total`. Si no hay cobros activos: `null`.
2. **Tickets (peso 20)**: de `$cliente->tickets()` creados en los últimos 6 meses con `due_at` no nulo, `100 - (100 × vencidos / total)`. Un ticket está "vencido" si `resolved_at > due_at`, o si no tiene `resolved_at` y `due_at` ya pasó. Si no hay tickets con `due_at` en el período: `null`.
3. **GPS (peso 15)**: `100 × (vehículos con gpswox_active=true) / total vehículos`. Si no tiene vehículos: `null`.
4. **Antigüedad (peso 10)**: tramo por meses desde `created_at` (`<6m`=40, `<12m`=60, `<36m`=80, `36m+`=100), `+10` (tope 100) si tiene algún contrato con `estado=true`. Nunca es `null` (todo cliente tiene `created_at`).
5. **WhatsApp (peso 10)**: de `$cliente->whatsappConversaciones()` con `last_message_at` no nulo, la más reciente. Tramos por días desde esa fecha (`≤7`=100, `≤30`=70, `≤90`=40, `>90`=10). Si no hay ninguna conversación con mensaje: `null`.
6. **Reseñas (peso 10)**: promedio de `$cliente->resenas()` con `calificacion` no nula de los últimos 6 meses, escalado `(promedio - 1) / 4 × 100`. Si no hay reseñas calificadas: `null`.
7. **Órdenes de trabajo (peso 10)**: promedio de `$cliente->ordenesTrabajo()` con `calificacion_cliente` no nula y `calificado_at` en los últimos 6 meses, mismo escalado. Si no hay OTs calificadas: `null`.

- [ ] **Step 1: Crear el service completo**

```php
<?php

namespace App\Services\Chs;

use App\Enums\ChsCategoria;
use App\Models\Clientes;
use Carbon\Carbon;

class ChsCalculatorService
{
    private const PESOS = [
        'pagos' => 25,
        'tickets' => 20,
        'gps' => 15,
        'antiguedad' => 10,
        'whatsapp' => 10,
        'resenas' => 10,
        'ordenes_trabajo' => 10,
    ];

    /**
     * @return array{score_final: int, categoria: ChsCategoria, factores_detalle: array<string, array{subscore: float|null, peso_aplicado: float}>}|null
     */
    public function calcularParaCliente(Clientes $cliente): ?array
    {
        $subscores = [
            'pagos' => $this->calcularFactorPagos($cliente),
            'tickets' => $this->calcularFactorTickets($cliente),
            'gps' => $this->calcularFactorGps($cliente),
            'antiguedad' => $this->calcularFactorAntiguedad($cliente),
            'whatsapp' => $this->calcularFactorWhatsapp($cliente),
            'resenas' => $this->calcularFactorResenas($cliente),
            'ordenes_trabajo' => $this->calcularFactorOrdenesTrabajo($cliente),
        ];

        return $this->combinarFactores($subscores);
    }

    /**
     * @param array<string, float|null> $subscores
     * @return array{score_final: int, categoria: ChsCategoria, factores_detalle: array<string, array{subscore: float|null, peso_aplicado: float}>}|null
     */
    private function combinarFactores(array $subscores): ?array
    {
        $disponibles = array_filter($subscores, fn (?float $valor) => $valor !== null);

        if (empty($disponibles)) {
            return null;
        }

        $pesoTotalDisponible = array_sum(array_intersect_key(self::PESOS, $disponibles));

        $scoreFinal = 0.0;
        $factoresDetalle = [];

        foreach ($subscores as $factor => $subscore) {
            if ($subscore === null) {
                $factoresDetalle[$factor] = ['subscore' => null, 'peso_aplicado' => 0.0];
                continue;
            }

            $pesoAplicado = self::PESOS[$factor] / $pesoTotalDisponible * 100;
            $scoreFinal += $subscore * ($pesoAplicado / 100);
            $factoresDetalle[$factor] = ['subscore' => round($subscore, 1), 'peso_aplicado' => round($pesoAplicado, 1)];
        }

        $scoreFinal = (int) round($scoreFinal);

        return [
            'score_final' => $scoreFinal,
            'categoria' => ChsCategoria::paraScore($scoreFinal),
            'factores_detalle' => $factoresDetalle,
        ];
    }

    private function calcularFactorPagos(Clientes $cliente): ?float
    {
        $cobrosActivos = $cliente->cobros()->activos()->get();

        if ($cobrosActivos->isEmpty()) {
            return null;
        }

        $alDia = $cobrosActivos->filter(fn ($cobro) => ! $cobro->vencido)->count();

        return 100 * $alDia / $cobrosActivos->count();
    }

    private function calcularFactorTickets(Clientes $cliente): ?float
    {
        $desde = Carbon::now()->subMonths(6);

        $tickets = $cliente->tickets()
            ->where('created_at', '>=', $desde)
            ->whereNotNull('due_at')
            ->get();

        if ($tickets->isEmpty()) {
            return null;
        }

        $vencidos = $tickets->filter(function ($ticket) {
            if ($ticket->resolved_at) {
                return $ticket->resolved_at->gt($ticket->due_at);
            }

            return $ticket->due_at->isPast();
        })->count();

        return 100 - (100 * $vencidos / $tickets->count());
    }

    private function calcularFactorGps(Clientes $cliente): ?float
    {
        $vehiculos = $cliente->vehiculos;

        if ($vehiculos->isEmpty()) {
            return null;
        }

        $activos = $vehiculos->where('gpswox_active', true)->count();

        return 100 * $activos / $vehiculos->count();
    }

    private function calcularFactorAntiguedad(Clientes $cliente): ?float
    {
        if (! $cliente->created_at) {
            return null;
        }

        $meses = $cliente->created_at->diffInMonths(Carbon::now());

        $base = match (true) {
            $meses < 6 => 40,
            $meses < 12 => 60,
            $meses < 36 => 80,
            default => 100,
        };

        $tieneContratoVigente = $cliente->contratos()->where('estado', true)->exists();

        return (float) ($tieneContratoVigente ? min(100, $base + 10) : $base);
    }

    private function calcularFactorWhatsapp(Clientes $cliente): ?float
    {
        $ultimaConversacion = $cliente->whatsappConversaciones()
            ->whereNotNull('last_message_at')
            ->latest('last_message_at')
            ->first();

        if (! $ultimaConversacion) {
            return null;
        }

        $dias = $ultimaConversacion->last_message_at->diffInDays(Carbon::now());

        return match (true) {
            $dias <= 7 => 100.0,
            $dias <= 30 => 70.0,
            $dias <= 90 => 40.0,
            default => 10.0,
        };
    }

    private function calcularFactorResenas(Clientes $cliente): ?float
    {
        $promedio = $cliente->resenas()
            ->whereNotNull('calificacion')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->avg('calificacion');

        if ($promedio === null) {
            return null;
        }

        return ((float) $promedio - 1) / 4 * 100;
    }

    private function calcularFactorOrdenesTrabajo(Clientes $cliente): ?float
    {
        $promedio = $cliente->ordenesTrabajo()
            ->whereNotNull('calificacion_cliente')
            ->where('calificado_at', '>=', Carbon::now()->subMonths(6))
            ->avg('calificacion_cliente');

        if ($promedio === null) {
            return null;
        }

        return ((float) $promedio - 1) / 4 * 100;
    }
}
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Services/Chs/ChsCalculatorService.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verificación funcional sobre un cliente real**

Run:
```
php artisan tinker --execute="
\$cliente = App\Models\Clientes::first();
\$resultado = app(App\Services\Chs\ChsCalculatorService::class)->calcularParaCliente(\$cliente);
echo \$resultado === null ? 'NULL (cliente sin datos en ningun factor)' : json_encode(\$resultado);
"
```
Expected: o bien `NULL (cliente sin datos en ningun factor)`, o un JSON con `score_final` entero 0-100, `categoria` (string del enum) y `factores_detalle` con las 7 claves. No debe lanzar excepción.

- [ ] **Step 4: Verificación del caso "sin ningún dato" (cliente nuevo sin actividad)**

Run:
```
php artisan tinker --execute="
DB::beginTransaction();
\$cliente = App\Models\Clientes::factory()->create(['created_at' => now()]);
\$resultado = app(App\Services\Chs\ChsCalculatorService::class)->calcularParaCliente(\$cliente);
echo \$resultado === null ? 'NULL correcto: solo antiguedad tiene dato pero antiguedad nunca es null, revisar' : json_encode(\$resultado);
DB::rollBack();
"
```
Expected: el factor `antiguedad` SIEMPRE tiene dato (no es `null`), así que el resultado NUNCA debe ser `NULL` para un cliente recién creado — debe imprimir el JSON con `antiguedad` resuelto y los otros 6 factores en `null` dentro de `factores_detalle`, con `peso_aplicado` de `antiguedad` = 100. Si la factory de `Clientes` no existe o falla, usar en su lugar un cliente real con pocos datos relacionados (ej. `Clientes::doesntHave('cobros')->doesntHave('tickets')->first()`), sin necesidad de transacción ni creación.

- [ ] **Step 5: Commit**

```bash
git add app/Services/Chs/ChsCalculatorService.php
git commit -m "feat(cliente-360): ChsCalculatorService - motor de calculo de los 7 factores del CHS"
```

---

### Task 5: Comando `chs:calcular-mensual` + registro en el scheduler

**Files:**
- Create: `app/Console/Commands/CalcularChsMensualCommand.php`
- Modify: `bootstrap/app.php:43-58` (bloque `withSchedule`)

- [ ] **Step 1: Crear el comando**

```php
<?php

namespace App\Console\Commands;

use App\Models\ChsHistorico;
use App\Models\Clientes;
use App\Scopes\EmpresaScope;
use App\Services\Chs\ChsCalculatorService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class CalcularChsMensualCommand extends Command
{
    protected $signature = 'chs:calcular-mensual';

    protected $description = 'Calcula el Customer Health Score mensual de todos los clientes (todas las empresas)';

    public function handle(ChsCalculatorService $calculator): int
    {
        $periodo = Carbon::now()->startOfMonth();

        $procesados = 0;
        $conScore = 0;
        $omitidos = 0;
        $conError = 0;

        Clientes::withoutGlobalScope(EmpresaScope::class)->cursor()->each(function (Clientes $cliente) use ($calculator, $periodo, &$procesados, &$conScore, &$omitidos, &$conError) {
            $procesados++;

            try {
                $resultado = $calculator->calcularParaCliente($cliente);

                if ($resultado === null) {
                    $omitidos++;
                    return;
                }

                ChsHistorico::withoutGlobalScope(EmpresaScope::class)->updateOrCreate(
                    ['cliente_id' => $cliente->id, 'periodo' => $periodo->toDateString()],
                    [
                        'empresa_id' => $cliente->empresa_id,
                        'score_final' => $resultado['score_final'],
                        'categoria' => $resultado['categoria']->value,
                        'factores_detalle' => $resultado['factores_detalle'],
                    ]
                );

                $conScore++;
            } catch (Throwable $e) {
                $conError++;
                Log::error("CHS: error calculando cliente {$cliente->id}: {$e->getMessage()}");
            }
        });

        $this->info("CHS mensual: {$procesados} clientes procesados, {$conScore} con score, {$omitidos} omitidos por falta de datos, {$conError} con error.");

        return Command::SUCCESS;
    }
}
```

- [ ] **Step 2: Registrar el comando en el scheduler**

En `bootstrap/app.php`, dentro del bloque `->withSchedule(function (Schedule $schedule) {...})`, agregar la línea al final (justo antes del `})`  de cierre):

```php
        $schedule->job(new EnviarResumenDiarioPostventaJob)->dailyAt('08:00');
        $schedule->command('chs:calcular-mensual')->monthlyOn(1, '02:00');
    })
```

(Reemplaza la línea existente `$schedule->job(new EnviarResumenDiarioPostventaJob)->dailyAt('08:00');` agregando la nueva línea inmediatamente después, dentro del mismo bloque.)

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Console/Commands/CalcularChsMensualCommand.php && php -l bootstrap/app.php`
Expected: `No syntax errors detected` en ambos.

- [ ] **Step 4: Verificar que el comando está registrado**

Run: `php artisan list chs`
Expected: aparece `chs:calcular-mensual` con su descripción.

- [ ] **Step 5: Verificar que el schedule lo incluye**

Run: `php artisan schedule:list`
Expected: una fila para `chs:calcular-mensual` con próxima ejecución el día 1 del mes siguiente a las 02:00.

- [ ] **Step 6: Ejecutar el comando manualmente y revisar el resultado**

Run: `php artisan chs:calcular-mensual`
Expected: imprime la línea de resumen (`CHS mensual: N clientes procesados, ...`) sin excepciones. Esto SÍ escribe filas reales en `chs_historico` para el mes actual — es el comportamiento esperado en producción, no requiere rollback.

- [ ] **Step 7: Verificar los datos guardados**

Run: `php artisan tinker --execute="echo App\Models\ChsHistorico::withoutGlobalScopes()->count() . ' registros, ejemplo: ' . json_encode(App\Models\ChsHistorico::withoutGlobalScopes()->first()?->toArray());"`
Expected: cuenta > 0 (si al menos un cliente tenía datos en algún factor) y el JSON de ejemplo tiene `score_final`, `categoria`, `factores_detalle` poblados.

- [ ] **Step 8: Commit**

```bash
git add app/Console/Commands/CalcularChsMensualCommand.php bootstrap/app.php
git commit -m "feat(cliente-360): comando chs:calcular-mensual + registro en scheduler (dia 1, 02:00am)"
```

---

### Task 6: Indicador visual en el dashboard de SP#1

**Files:**
- Modify: `app/Livewire/Admin/Clientes/Client360Dashboard.php:15-32` (método `render()`)
- Modify: `resources/views/livewire/admin/clientes/client360-dashboard.blade.php:27-29` (entre el header y el panel de vehículos)

- [ ] **Step 1: Agregar los datos del CHS al `render()` de `Client360Dashboard`**

En `app/Livewire/Admin/Clientes/Client360Dashboard.php`, dentro de `render()`, el array que se pasa a `view()` queda así (se agregan las dos últimas claves `chsActual` y `chsTendencia`):

```php
    public function render()
    {
        $this->cliente->loadMissing([
            'vehiculos',
            'contratos',
        ]);

        return view('livewire.admin.clientes.client360-dashboard', [
            'ejecutivo' => $this->ejecutivoAsignado(),
            'vehiculosConGps' => $this->vehiculosConEstadoGps(),
            'certificados' => $this->cliente->certificados()->latest('fecha_instalacion')->limit(20)->get(),
            'actas' => $this->cliente->actas()->latest('fecha_instalacion')->limit(20)->get(),
            'certVelocimetros' => $this->cliente->certVelocimetros()->limit(20)->get(),
            'contratos' => $this->cliente->contratos,
            'resumenComercial' => $this->resumenComercial(),
            'timeline' => $this->timeline(),
            'chsActual' => $this->cliente->chsHistorico()->latest('periodo')->first(),
            'chsTendencia' => $this->cliente->chsHistorico()->latest('periodo')->limit(12)->get()->reverse()->values(),
        ]);
    }
```

- [ ] **Step 2: Agregar la sección del badge CHS en el blade**

En `resources/views/livewire/admin/clientes/client360-dashboard.blade.php`, insertar una sección nueva inmediatamente después del cierre del header ejecutivo (línea 27, `</div>` que cierra el panel de header) y antes del comentario `{{-- ── Panel de vehículos + GPS ──... --}}` (línea 29):

```blade
    {{-- ── Customer Health Score ─────────────────────────────────── --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">Customer Health Score</h2>
        @if ($chsActual)
            <div class="flex flex-wrap items-end gap-6">
                <div>
                    <span class="text-4xl font-bold {{ $chsActual->categoria->color() }}">{{ $chsActual->score_final }}</span>
                    <span class="text-sm text-gray-400">/100</span>
                    <p class="mt-1">
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium {{ $chsActual->categoria->bgColor() }}">
                            {{ $chsActual->categoria->label() }}
                        </span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Período: {{ $chsActual->periodo->format('m/Y') }}</p>
                </div>
                @if ($chsTendencia->count() > 1)
                    <div class="flex items-end gap-1.5 h-20" title="Tendencia últimos {{ $chsTendencia->count() }} meses">
                        @foreach ($chsTendencia as $snapshot)
                            <div class="flex flex-col items-end h-full" wire:key="chs-tendencia-{{ $snapshot->id }}">
                                <div
                                    class="w-4 rounded-t {{ $snapshot->categoria->barColor() }}"
                                    style="height: {{ max(4, $snapshot->score_final) }}%"
                                    title="{{ $snapshot->periodo->format('m/Y') }}: {{ $snapshot->score_final }}"
                                ></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <p class="text-sm text-gray-400">CHS aún no calculado.</p>
        @endif
    </div>

```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Livewire/Admin/Clientes/Client360Dashboard.php`
Expected: `No syntax errors detected`

(Los archivos `.blade.php` no son PHP puro y `php -l` puede fallar en ellos por la sintaxis Blade — esto es esperado, no es un error real. Verificar el blade visualmente releyendo el archivo tras la edición.)

- [ ] **Step 4: Verificación funcional del Livewire component**

Run:
```
php artisan tinker --execute="
\$cliente = App\Models\Clientes::first();
\$componente = new App\Livewire\Admin\Clientes\Client360Dashboard();
\$componente->cliente = \$cliente;
\$view = \$componente->render();
echo 'OK, view: ' . \$view->name();
"
```
Expected: `OK, view: livewire.admin.clientes.client360-dashboard` sin excepción.

- [ ] **Step 5: Verificación manual en navegador (responsabilidad del usuario)**

Este paso no lo puede ejecutar el agente (no hay herramienta de automatización de navegador disponible en este entorno). Indicar al usuario que abra `GET /clientes/{id}/360` de un cliente con al menos un registro en `chs_historico` (ya generado en el Task 5, Step 6) y confirme visualmente: el badge muestra el score y la categoría con el color correcto, y si hay más de un snapshot histórico, las barras de tendencia se ven proporcionalmente correctas. Si el cliente no tiene ningún `ChsHistorico`, debe ver el texto "CHS aún no calculado." sin romper el resto de la página.

- [ ] **Step 6: Commit**

```bash
git add app/Livewire/Admin/Clientes/Client360Dashboard.php resources/views/livewire/admin/clientes/client360-dashboard.blade.php
git commit -m "feat(cliente-360): indicador visual CHS (badge + tendencia) en dashboard 360"
```

---

## Fuera de alcance (recordatorio, ver spec)

- Panel gerencial, ranking, alertas automáticas, recomendaciones (SP#4).
- Recalculo manual bajo demanda.
- Edición manual del score.
- Nuevos campos de captura de datos.
