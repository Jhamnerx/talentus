# Sync plataforma — Transferir SIM/IMEI respetando GPSWox — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Centralizar en un servicio compartido la asignación de número/SIM e IMEI desde la plataforma GPSWox, liberando el dato del vehículo anterior (archivando en `old_*` / desinstalando el pivot) y asignándolo al vehículo nuevo, de forma atómica.

**Architecture:** Nuevo `PlataformaVehiculoSyncService` con `aplicarNumero()` y `aplicarImei()` (transaction-agnostic). El webhook `deviceSync` y `GpsWoxService::sincronizarVehiculoDesdePlataforma` envuelven su procesamiento en `DB::transaction(...)` y delegan en el servicio. El webhook además gana try/catch (409 controlado en vez de 500).

**Tech Stack:** Laravel 12, PHPUnit 11, MySQL.

> **Restricción de testing (preferencia del usuario):** NO ejecutar `php artisan test` — los tests de este feature usan `RefreshDatabase` y `phpunit.xml` apunta a la BD real de desarrollo (la borraría). Validar todos los `.php` con `php -l`. La verificación de comportamiento real se hace en la **Task 5 (Tinker con rollback)**, que es segura (no persiste). Los tests quedan en el repo para un entorno con BD de pruebas dedicada.

---

## File Structure

- `app/Services/PlataformaVehiculoSyncService.php` — **crear**. `aplicarNumero` + `aplicarImei`.
- `tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php` — **crear**. Cobertura de ambos métodos.
- `app/Http/Controllers/Api/TrackingWebhookController.php` — **modificar**. Delegar + transacción + try/catch.
- `app/Services/GpsWoxService.php` — **modificar**. Delegar + transacción en `sincronizarVehiculoDesdePlataforma`.

---

## Task 1: Servicio `PlataformaVehiculoSyncService` con `aplicarNumero`

**Files:**
- Create: `app/Services/PlataformaVehiculoSyncService.php`
- Test: `tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php`

- [ ] **Step 1: Escribir el test de `aplicarNumero`**

Crear `tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php`:

```php
<?php

namespace Tests\Feature\Services;

use App\Models\Dispositivos;
use App\Models\Empresa;
use App\Models\Lineas;
use App\Models\SimCard;
use App\Models\Vehiculos;
use App\Models\VehiculoDispositivos;
use App\Services\PlataformaVehiculoSyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * NOTA: usa RefreshDatabase. NO ejecutar contra la BD de desarrollo (la borraría).
 * Requiere la conexión de pruebas sqlite :memory: habilitada en phpunit.xml.
 */
class PlataformaVehiculoSyncServiceTest extends TestCase
{
    use RefreshDatabase;

    private function seedEmpresa(): Empresa
    {
        $empresa = Empresa::create(['nombre' => 'Test']);
        session(['empresa' => $empresa->id]);
        return $empresa;
    }

    private function svc(): PlataformaVehiculoSyncService
    {
        return app(PlataformaVehiculoSyncService::class);
    }

    public function test_transfiere_numero_de_un_vehiculo_a_otro(): void
    {
        $empresa = $this->seedEmpresa();
        $linea   = Lineas::create(['numero' => '999111', 'empresa_id' => $empresa->id]);
        $sim     = SimCard::create(['sim_card' => 'SIM-A', 'operador' => 'OP', 'lineas_id' => $linea->id, 'empresa_id' => $empresa->id]);

        $a = Vehiculos::create(['placa' => 'AAA-111', 'empresa_id' => $empresa->id, 'numero' => '999111', 'sim_card_id' => $sim->id]);
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        $this->svc()->aplicarNumero($b, '999111');
        $b->save();

        $a->refresh();
        $b->refresh();

        $this->assertNull($a->numero);
        $this->assertNull($a->sim_card_id);
        $this->assertSame('999111', $a->old_numero);
        $this->assertSame('SIM-A', $a->old_sim_card);

        $this->assertSame('999111', $b->numero);
        $this->assertSame($sim->id, $b->sim_card_id);
    }

    public function test_aplicar_numero_es_idempotente_si_ya_lo_tiene(): void
    {
        $empresa = $this->seedEmpresa();
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id, 'numero' => '999111']);

        $this->svc()->aplicarNumero($b, '999111');
        $b->save();
        $b->refresh();

        $this->assertSame('999111', $b->numero);
        $this->assertNull($b->old_numero);
    }

    public function test_aplicar_numero_libre_no_libera_a_nadie(): void
    {
        $empresa = $this->seedEmpresa();
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        $this->svc()->aplicarNumero($b, '777000');
        $b->save();
        $b->refresh();

        $this->assertSame('777000', $b->numero);
    }
}
```

- [ ] **Step 2: Validar sintaxis del test**

Run: `php -l tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php`
Expected: `No syntax errors detected`

> NO ejecutar el test (RefreshDatabase). El comportamiento se verifica en Task 5.

- [ ] **Step 3: Crear el servicio con `aplicarNumero`**

Crear `app/Services/PlataformaVehiculoSyncService.php`:

```php
<?php

namespace App\Services;

use App\Models\Dispositivos;
use App\Models\Lineas;
use App\Models\Vehiculos;
use App\Models\VehiculoDispositivos;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Log;

/**
 * Asigna número/SIM e IMEI a un vehículo respetando la plataforma GPSWox como
 * fuente de verdad: libera el dato del vehículo que lo tenía antes y lo asigna
 * al destino. Los métodos son transaction-agnostic: el llamador debe envolver
 * liberar+asignar+save en un único DB::transaction.
 */
class PlataformaVehiculoSyncService
{
    /**
     * Asigna el número/SIM al vehículo destino, liberándolo de cualquier otro
     * vehículo que lo tuviera (archivando en old_numero/old_sim_card).
     * No guarda el destino: el llamador persiste numero/sim_card_id.
     */
    public function aplicarNumero(Vehiculos $destino, string $simNumber): void
    {
        $simNumber = trim($simNumber);

        if (blank($simNumber) || $destino->numero === $simNumber) {
            return;
        }

        $anterior = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('numero', $simNumber)
            ->where('id', '!=', $destino->id)
            ->first();

        if ($anterior) {
            $anterior->old_numero   = $anterior->numero;
            $anterior->old_sim_card = $anterior->sim_card?->sim_card;
            $anterior->numero       = null;
            $anterior->sim_card_id  = null;
            $anterior->save();
        }

        $destino->numero = $simNumber;

        $linea = Lineas::withoutGlobalScope(EmpresaScope::class)
            ->where('numero', $simNumber)
            ->first();

        if ($linea && $linea->sim_card) {
            $destino->sim_card_id = $linea->sim_card->id;
        }
    }
}
```

- [ ] **Step 4: Validar sintaxis**

Run: `php -l app/Services/PlataformaVehiculoSyncService.php`
Expected: `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Services/PlataformaVehiculoSyncService.php tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php
git commit -m "feat(sync): PlataformaVehiculoSyncService::aplicarNumero"
```

---

## Task 2: `aplicarImei` en el servicio

**Files:**
- Modify: `app/Services/PlataformaVehiculoSyncService.php`
- Test: `tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php`

- [ ] **Step 1: Añadir tests de `aplicarImei`**

En `tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php`, agregar estos métodos dentro de la clase:

```php
    public function test_transfiere_imei_desde_otro_vehiculo(): void
    {
        $empresa = $this->seedEmpresa();
        $disp = Dispositivos::create(['imei' => 'IMEI-1', 'empresa_id' => $empresa->id, 'estado' => 'VENDIDO']);

        $a = Vehiculos::create(['placa' => 'AAA-111', 'empresa_id' => $empresa->id, 'dispositivos_id' => $disp->id]);
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        $pivotA = VehiculoDispositivos::create([
            'vehiculo_id' => $a->id, 'dispositivo_id' => $disp->id, 'imei' => 'IMEI-1',
            'is_principal' => true, 'fecha_instalacion' => now(),
        ]);

        $resultado = $this->svc()->aplicarImei($b, 'IMEI-1');

        $this->assertTrue($resultado);

        $pivotA->refresh();
        $a->refresh();
        $b->refresh();

        $this->assertNotNull($pivotA->fecha_desinstalacion);
        $this->assertFalse((bool) $pivotA->is_principal);
        $this->assertNull($a->dispositivos_id);

        $this->assertSame($disp->id, $b->dispositivos_id);
        $this->assertDatabaseHas('vehiculos_dispositivos', [
            'vehiculo_id' => $b->id, 'dispositivo_id' => $disp->id,
            'is_principal' => true, 'fecha_desinstalacion' => null,
        ]);
    }

    public function test_aplicar_imei_ya_en_destino_solo_asegura_principal(): void
    {
        $empresa = $this->seedEmpresa();
        $disp = Dispositivos::create(['imei' => 'IMEI-1', 'empresa_id' => $empresa->id, 'estado' => 'VENDIDO']);
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        VehiculoDispositivos::create([
            'vehiculo_id' => $b->id, 'dispositivo_id' => $disp->id, 'imei' => 'IMEI-1',
            'is_principal' => false, 'fecha_instalacion' => now(),
        ]);

        $resultado = $this->svc()->aplicarImei($b, 'IMEI-1');
        $b->refresh();

        $this->assertTrue($resultado);
        $this->assertSame($disp->id, $b->dispositivos_id);
        $this->assertDatabaseHas('vehiculos_dispositivos', [
            'vehiculo_id' => $b->id, 'dispositivo_id' => $disp->id, 'is_principal' => true,
        ]);
    }

    public function test_aplicar_imei_inexistente_retorna_false(): void
    {
        $empresa = $this->seedEmpresa();
        $b = Vehiculos::create(['placa' => 'BBB-222', 'empresa_id' => $empresa->id]);

        $this->assertFalse($this->svc()->aplicarImei($b, 'NO-EXISTE'));
    }
```

- [ ] **Step 2: Validar sintaxis del test**

Run: `php -l tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Implementar `aplicarImei`**

En `app/Services/PlataformaVehiculoSyncService.php`, agregar este método dentro de la clase (después de `aplicarNumero`):

```php
    /**
     * Asigna el dispositivo (por IMEI) como principal del vehículo destino,
     * desinstalándolo de cualquier otro vehículo que lo tuviera activo.
     * Persiste pivots y el shortcut dispositivos_id. Retorna true si quedó asignado.
     */
    public function aplicarImei(Vehiculos $destino, string $imei): bool
    {
        $imei = trim($imei);

        if (blank($imei)) {
            return false;
        }

        $dispositivo = Dispositivos::withoutGlobalScope(EmpresaScope::class)
            ->where('imei', $imei)
            ->first();

        if (! $dispositivo) {
            Log::channel('daily')->info('[PlataformaSync] IMEI no registrado en Talentus', ['imei' => $imei]);
            return false;
        }

        $pivotDestino = VehiculoDispositivos::where('vehiculo_id', $destino->id)
            ->where('imei', $imei)
            ->whereNull('fecha_desinstalacion')
            ->first();

        if ($pivotDestino) {
            VehiculoDispositivos::where('vehiculo_id', $destino->id)
                ->whereNull('fecha_desinstalacion')
                ->where('id', '!=', $pivotDestino->id)
                ->update(['is_principal' => false]);

            $pivotDestino->update(['is_principal' => true]);
            $destino->dispositivos_id = $dispositivo->id;
            $destino->save();

            return true;
        }

        $pivotOtro = VehiculoDispositivos::where('dispositivo_id', $dispositivo->id)
            ->where('vehiculo_id', '!=', $destino->id)
            ->whereNull('fecha_desinstalacion')
            ->first();

        if ($pivotOtro) {
            $pivotOtro->update(['fecha_desinstalacion' => now(), 'is_principal' => false]);

            $anterior = Vehiculos::withoutGlobalScope(EmpresaScope::class)->find($pivotOtro->vehiculo_id);
            if ($anterior && (int) $anterior->dispositivos_id === (int) $dispositivo->id) {
                $anterior->dispositivos_id = null;
                $anterior->save();
            }
        } else {
            app(StockService::class)->marcarVendidoPorInstalacion($dispositivo);
        }

        VehiculoDispositivos::where('vehiculo_id', $destino->id)
            ->whereNull('fecha_desinstalacion')
            ->update(['is_principal' => false]);

        VehiculoDispositivos::create([
            'vehiculo_id'       => $destino->id,
            'dispositivo_id'    => $dispositivo->id,
            'imei'              => $imei,
            'is_principal'      => true,
            'fecha_instalacion' => now(),
        ]);

        $destino->dispositivos_id = $dispositivo->id;
        $destino->save();

        return true;
    }
```

- [ ] **Step 4: Validar sintaxis**

Run: `php -l app/Services/PlataformaVehiculoSyncService.php`
Expected: `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Services/PlataformaVehiculoSyncService.php tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php
git commit -m "feat(sync): PlataformaVehiculoSyncService::aplicarImei"
```

---

## Task 3: Cablear `TrackingWebhookController::deviceSync`

**Files:**
- Modify: `app/Http/Controllers/Api/TrackingWebhookController.php`

- [ ] **Step 1: Agregar imports**

En `app/Http/Controllers/Api/TrackingWebhookController.php`, junto a los `use` existentes, agregar:

```php
use App\Services\PlataformaVehiculoSyncService;
use Illuminate\Support\Facades\DB;
```

- [ ] **Step 2: Reemplazar el bloque SIM + save + IMEI por delegación transaccional**

Localizar el bloque que va desde el comentario `// --- numero (SIM) + sim_card_id ---` hasta el cierre del `if (!blank($imei)) { ... }` del bloque de dispositivo principal (actualmente líneas 84–170, terminando justo antes del `Log::channel('daily')->info('[TrackingWebhook] Vehículo sincronizado'`).

Reemplazar TODO ese bloque por:

```php
        // --- Asignación de número/SIM e IMEI respetando la plataforma (atómico) ---
        $svc = app(PlataformaVehiculoSyncService::class);
        $imeiSincronizado = false;

        try {
            $imeiSincronizado = DB::transaction(function () use ($svc, $vehiculo, $simNumber, $imei, &$cambios) {
                if (!blank($simNumber) && $vehiculo->numero !== $simNumber) {
                    $svc->aplicarNumero($vehiculo, $simNumber);
                    $cambios[] = 'numero';
                }

                $vehiculo->gpswox_sincronizado_at = now();
                $vehiculo->save();

                return !blank($imei) ? $svc->aplicarImei($vehiculo, $imei) : false;
            });
        } catch (\Throwable $e) {
            Log::channel('daily')->error('[TrackingWebhook] Error al sincronizar', [
                'placa' => $plateNumber,
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'status'  => 0,
                'message' => 'Conflicto al sincronizar: ' . $e->getMessage(),
            ], 409);
        }
```

> Nota: las asignaciones de `gpswox_id` y `gpswox_active` (líneas previas) quedan tal cual; modifican `$vehiculo` en memoria y se persisten con el `$vehiculo->save()` dentro de la transacción. El `gpswox_sincronizado_at = now()` y el `$vehiculo->save()` originales (líneas 104–106) se eliminan porque ahora viven dentro de la transacción.

- [ ] **Step 3: Validar sintaxis**

Run: `php -l app/Http/Controllers/Api/TrackingWebhookController.php`
Expected: `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Http/Controllers/Api/TrackingWebhookController.php
git commit -m "feat(sync): deviceSync delega en servicio + transaccion + 409 controlado"
```

---

## Task 4: Cablear `GpsWoxService::sincronizarVehiculoDesdePlataforma`

**Files:**
- Modify: `app/Services/GpsWoxService.php`

- [ ] **Step 1: Agregar import de DB**

En `app/Services/GpsWoxService.php`, junto a los `use` existentes, agregar:

```php
use Illuminate\Support\Facades\DB;
```

(`PlataformaVehiculoSyncService` se resuelve con `app(...)`, no requiere import.)

- [ ] **Step 2: Reemplazar bloques IMEI y SIM por delegación dentro de una transacción**

En `sincronizarVehiculoDesdePlataforma`, localizar desde la línea `$acciones = [];` y el bloque `// ── 1. gpswox_id ──` hasta el `$vehiculo->save();` (actualmente líneas 513–591), que incluye: el set de gpswox_id/sincronizado_at/active, el bloque `// ── 2. Dispositivo por IMEI ──`, y el bloque `// ── 3. SIM / Línea ──`.

Reemplazar TODO ese rango por:

```php
            $acciones = [];
            $svc = app(\App\Services\PlataformaVehiculoSyncService::class);

            DB::transaction(function () use ($vehiculo, $svc, $gpswoxId, $active, $imei, $simNumber, &$acciones) {
                $vehiculo->gpswox_id              = $gpswoxId;
                $vehiculo->gpswox_sincronizado_at = now();
                if ($active !== null) {
                    $vehiculo->gpswox_active = $active;
                }

                if (!blank($simNumber)) {
                    $svc->aplicarNumero($vehiculo, $simNumber);
                    $acciones[] = "SIM {$simNumber} asignada";
                }

                $vehiculo->save();

                if (!blank($imei)) {
                    $asignado = $svc->aplicarImei($vehiculo, $imei);
                    $acciones[] = $asignado
                        ? "IMEI {$imei} asignado como principal"
                        : "IMEI {$imei} no registrado en el sistema";
                }
            });
```

> El `try/catch` que envuelve el método se conserva: si la transacción lanza, cae al `catch` existente que retorna `['status' => 0, ...]`. El `$resumen`/`return status:1` posteriores quedan igual.

- [ ] **Step 3: Validar sintaxis**

Run: `php -l app/Services/GpsWoxService.php`
Expected: `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Services/GpsWoxService.php
git commit -m "feat(sync): sincronizarVehiculoDesdePlataforma delega en servicio + transaccion"
```

---

## Task 5: Verificación de comportamiento con Tinker (rollback, segura)

Esta task verifica el servicio contra la BD real SIN persistir, usando una transacción que se revierte. NO usa `php artisan test`.

- [ ] **Step 1: Verificar transferencia de número (con rollback)**

Ejecutar con Tinker (vía el tool `tinker` de Boost, o `php artisan tinker`). Reemplazar `PLACA_A`/`PLACA_B` por dos placas reales donde A tenga un `numero` y B no:

```php
use Illuminate\Support\Facades\DB;
use App\Models\Vehiculos;
use App\Services\PlataformaVehiculoSyncService;

DB::beginTransaction();
$a = Vehiculos::where('placa','PLACA_A')->first();
$b = Vehiculos::where('placa','PLACA_B')->first();
$num = $a->numero;
app(PlataformaVehiculoSyncService::class)->aplicarNumero($b, $num);
$b->save();
$a->refresh(); $b->refresh();
dump([
  'A_numero'     => $a->numero,        // null esperado
  'A_old_numero' => $a->old_numero,    // $num esperado
  'B_numero'     => $b->numero,        // $num esperado
  'B_sim_card_id'=> $b->sim_card_id,
]);
DB::rollBack(); // revierte: no se persiste nada
```

Esperado: `A_numero=null`, `A_old_numero=$num`, `B_numero=$num`.

- [ ] **Step 2: Verificar transferencia de IMEI (con rollback)**

Con `PLACA_A` = vehículo que tiene un dispositivo principal (IMEI conocido) y `PLACA_B` = otro vehículo:

```php
use Illuminate\Support\Facades\DB;
use App\Models\Vehiculos;
use App\Models\VehiculoDispositivos;
use App\Services\PlataformaVehiculoSyncService;

DB::beginTransaction();
$a = Vehiculos::where('placa','PLACA_A')->first();
$b = Vehiculos::where('placa','PLACA_B')->first();
$imei = VehiculoDispositivos::where('vehiculo_id',$a->id)->whereNull('fecha_desinstalacion')->where('is_principal',true)->value('imei');
$ok = app(PlataformaVehiculoSyncService::class)->aplicarImei($b, $imei);
$a->refresh(); $b->refresh();
dump([
  'ok'             => $ok,
  'A_dispositivos' => $a->dispositivos_id, // null esperado
  'B_dispositivos' => $b->dispositivos_id, // id del dispositivo esperado
  'pivotA_desinst' => VehiculoDispositivos::where('vehiculo_id',$a->id)->where('imei',$imei)->value('fecha_desinstalacion'), // no null
  'pivotB'         => VehiculoDispositivos::where('vehiculo_id',$b->id)->where('imei',$imei)->whereNull('fecha_desinstalacion')->where('is_principal',true)->exists(), // true
]);
DB::rollBack();
```

Esperado: `ok=true`, `A_dispositivos=null`, `B_dispositivos=<id>`, `pivotA_desinst` no null, `pivotB=true`.

- [ ] **Step 3 (opcional): Webhook end-to-end**

Si hay entorno de pruebas, enviar un POST a `route('...device-sync')` con `plate_number` = PLACA_B y un `sim_number`/`imei` que pertenezcan a otro vehículo, y confirmar respuesta `status:1` (o `409` controlado ante conflicto irresoluble) en vez de 500.

---

## Notas de ejecución

- Orden: Task 1 → 2 → 3 → 4 → 5.
- `php -l` en cada `.php` tocado antes de commitear.
- Los tests de feature (Tasks 1–2) NO se ejecutan aquí (RefreshDatabase + BD real); quedan para entorno de pruebas. La verificación real es la Task 5 (Tinker con rollback, no persiste).
- `aplicarNumero` NO guarda el destino; el llamador hace `$vehiculo->save()` dentro de la misma transacción (Tasks 3 y 4 ya lo hacen).
