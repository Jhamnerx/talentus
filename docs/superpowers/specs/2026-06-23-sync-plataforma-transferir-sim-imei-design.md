# Sync desde plataforma — Transferir SIM/número e IMEI respetando GPSWox

**Fecha:** 2026-06-23
**Componentes:** `App\Http\Controllers\Api\TrackingWebhookController`, `App\Services\GpsWoxService`, **nuevo** `App\Services\PlataformaVehiculoSyncService`

## Problema

GPSWox es la fuente de verdad. Cuando la plataforma informa que un vehículo tiene cierto
número/SIM o IMEI, hoy el sistema lo asigna al vehículo destino **sin liberar** al vehículo
que lo tenía antes. Esto causa:

1. **Número/SIM:** `numero` tiene índice `unique` ([create_vehiculos_table.php:29](database/migrations/2022_03_13_002412_create_vehiculos_table.php#L29)).
   Al hacer `$vehiculo->numero = $simNumber` con un número ya usado por otro vehículo, el
   `save()` lanza `Duplicate entry`. En el webhook ([deviceSync](app/Http/Controllers/Api/TrackingWebhookController.php#L106))
   no hay try/catch → **HTTP 500** y no se guarda nada. En el pull
   ([GpsWoxService](app/Services/GpsWoxService.php#L591)) hay try/catch → `status:0` con error SQL.
2. **IMEI:** si el IMEI está activo en otro vehículo, el webhook **no lo transfiere**: solo
   loguea un warning y responde éxito igual ([líneas 132-162](app/Http/Controllers/Api/TrackingWebhookController.php#L132)).
   El vehículo nuevo nunca recibe el equipo.

Además, ambos caminos (push webhook y pull del modal de flota) duplican esta lógica.

## Objetivo

Respetar la plataforma: al recibir un número/SIM o IMEI que ya está en otro vehículo,
**liberar** el dato del vehículo anterior (archivando en campos `old_*` / marcando el
dispositivo como desinstalado) y **asignarlo** al vehículo nuevo. Centralizar la lógica en
un servicio compartido usado por el webhook y por `GpsWoxService`.

## Decisiones tomadas

1. **Alcance:** ambos caminos usan un **servicio compartido** (DRY).
2. **Vehículo anterior:** se libera y archiva en `old_*`:
   - SIM: `old_numero = numero`, `old_sim_card = sim_card?->sim_card`, luego `numero = null`,
     `sim_card_id = null`.
   - IMEI: pivot anterior `fecha_desinstalacion = now()` + `is_principal = false`; si su
     `dispositivos_id` apuntaba a ese equipo → `dispositivos_id = null`.
3. **Archivado `old_*`:** se **sobrescribe** con el dato que se transfiere (es lo más reciente
   que el vehículo anterior pierde). Difiere del patrón de desactivación que protege con
   `blank()`, porque aquí el objetivo es archivar lo transferido.
4. **Multi-empresa:** la búsqueda de `Dispositivos` por IMEI se hace **sin** `EmpresaScope`
   (la plataforma es global), corrigiendo el bug latente actual.

## Arquitectura — `PlataformaVehiculoSyncService`

`app/Services/PlataformaVehiculoSyncService.php`. Los métodos son **transaction-agnostic**: el
llamador envuelve todo el procesamiento del vehículo (liberar anterior + asignar destino +
`save()` del destino) en un único `DB::transaction(...)`, de modo que liberar y asignar sean
atómicos juntos. `aplicarNumero` no guarda el vehículo destino (lo hace el llamador dentro de la
misma transacción); `aplicarImei` sí persiste pivots y el shortcut `dispositivos_id`.

### `aplicarNumero(Vehiculos $destino, string $simNumber): void`

```
1. Si $destino->numero === $simNumber → return (idempotente).
2. $anterior = Vehiculos::withoutGlobalScope(EmpresaScope)
       ->where('numero', $simNumber)->where('id','!=',$destino->id)->first();
3. Si $anterior:
     $anterior->old_numero   = $anterior->numero;
     $anterior->old_sim_card = $anterior->sim_card?->sim_card;
     $anterior->numero       = null;
     $anterior->sim_card_id  = null;
     $anterior->save();
4. $destino->numero = $simNumber;
   $linea = Lineas::withoutGlobalScope(EmpresaScope)->where('numero',$simNumber)->first();
   if ($linea?->sim_card) { $destino->sim_card_id = $linea->sim_card->id; }
   // El save de $destino lo hace el llamador.
```

### `aplicarImei(Vehiculos $destino, string $imei): bool`

```
1. $dispositivo = Dispositivos::withoutGlobalScope(EmpresaScope)->where('imei',$imei)->first();
   if (!$dispositivo) { log 'IMEI no registrado'; return false; }
2. $pivotDestino = VehiculoDispositivos::where('vehiculo_id',$destino->id)
       ->where('imei',$imei)->whereNull('fecha_desinstalacion')->first();
   if ($pivotDestino):
       // ya instalado en destino → asegurar principal
       desmarcar otros principales activos del destino;
       $pivotDestino->update(['is_principal'=>true]);
       $destino->dispositivos_id = $dispositivo->id; $destino->save();
       return true;
3. // No está en destino: buscar pivot activo en OTRO vehículo
   $pivotOtro = VehiculoDispositivos::where('dispositivo_id',$dispositivo->id)
       ->where('vehiculo_id','!=',$destino->id)
       ->whereNull('fecha_desinstalacion')->first();
   if ($pivotOtro):
       // transferir: desinstalar del anterior
       $pivotOtro->update(['fecha_desinstalacion'=>now(),'is_principal'=>false]);
       $anterior = Vehiculos::withoutGlobalScope(EmpresaScope)->find($pivotOtro->vehiculo_id);
       if ($anterior && $anterior->dispositivos_id === $dispositivo->id) {
           $anterior->dispositivos_id = null; $anterior->save();
       }
       // (no se llama marcarVendidoPorInstalacion: el equipo ya estaba vendido/instalado)
   else:
       // IMEI libre → descontar stock al instalar
       app(StockService::class)->marcarVendidoPorInstalacion($dispositivo);
4. // Instalar en destino (caso transferencia o libre)
   desmarcar principales activos del destino;
   VehiculoDispositivos::create([
       'vehiculo_id'=>$destino->id,'dispositivo_id'=>$dispositivo->id,'imei'=>$imei,
       'is_principal'=>true,'fecha_instalacion'=>now(),
   ]);
   $destino->dispositivos_id = $dispositivo->id; $destino->save();
   return true;
```

## Cableado de los llamadores

### `TrackingWebhookController::deviceSync`

- Reemplazar el bloque SIM ([85-101](app/Http/Controllers/Api/TrackingWebhookController.php#L85))
  por: `if (!blank($simNumber)) { $svc->aplicarNumero($vehiculo, $simNumber); $cambios[]='numero'; }`
  antes del `$vehiculo->save()` (el save del destino persiste `numero`/`sim_card_id`).
- Reemplazar el bloque IMEI ([108-170](app/Http/Controllers/Api/TrackingWebhookController.php#L108))
  por: `if (!blank($imei)) { $imeiSincronizado = $svc->aplicarImei($vehiculo, $imei); }`.
- Envolver todo el procesamiento del vehículo (saves de gpswox_id/active + `aplicarNumero` +
  `$vehiculo->save()` + `aplicarImei`) en `DB::transaction(...)`, y eso a su vez en try/catch;
  ante `\Throwable` responder JSON controlado (`status:0`, HTTP 409) con el mensaje, en vez del
  500 actual.

### `GpsWoxService::sincronizarVehiculoDesdePlataforma`

- Reemplazar el bloque SIM ([573-589](app/Services/GpsWoxService.php#L573)) por
  `$this->plataformaSync->aplicarNumero($vehiculo, $simNumber)` (inyectado por constructor o
  `app(...)`), conservando el push a `$acciones`.
- Reemplazar el bloque "Dispositivo principal por IMEI" ([522-571](app/Services/GpsWoxService.php#L522))
  por `$this->plataformaSync->aplicarImei($vehiculo, $imei)`.
- Envolver el cuerpo (asignaciones + `aplicarNumero` + `$vehiculo->save()` + `aplicarImei`) en
  `DB::transaction(...)` dentro de su try/catch existente que retorna `status:0`.

## Manejo de errores

- El llamador envuelve liberar+asignar+save en un único `DB::transaction`, revirtiendo
  liberaciones parciales si algo falla (no queda un número liberado sin dueño).
- `deviceSync` deja de devolver 500: try/catch → respuesta JSON de conflicto controlada.
- La liberación previa del `numero` (paso 3 de `aplicarNumero`) elimina la causa raíz del
  `Duplicate entry`.

## Pruebas

Tests de feature/unit de `PlataformaVehiculoSyncService` (requieren BD; factory de Vehiculos
existe):

1. **Transferencia de número:** vehículo A tiene `numero=X`; `aplicarNumero(B, X)` → A queda con
   `old_numero=X`, `old_sim_card=<sim>`, `numero=null`, `sim_card_id=null`; B queda con
   `numero=X` y `sim_card_id` resuelto.
2. **Idempotencia:** `aplicarNumero(B, X)` cuando B ya tiene `numero=X` → no cambia nada, no toca A.
3. **Número libre:** `aplicarNumero(B, Y)` con Y en ningún vehículo → B recibe Y, nadie se libera.
4. **Transferencia de IMEI:** dispositivo en A (pivot principal activo); `aplicarImei(B, imei)` →
   pivot de A con `fecha_desinstalacion` y `is_principal=false`, `A->dispositivos_id=null`; B con
   pivot principal activo y `dispositivos_id=<id>`.
5. **IMEI ya en destino:** `aplicarImei(B, imei)` cuando B ya lo tiene → asegura principal, retorna true.
6. **IMEI libre:** instala en B y descuenta stock (mock/spy de `StockService::marcarVendidoPorInstalacion`).

> Por preferencia registrada del usuario **no** se ejecuta `php artisan test` (RefreshDatabase
> borraría la BD real). Validar con `php -l`; los tests quedan en el repo para entorno con BD de
> pruebas dedicada.

## Archivos afectados

- `app/Services/PlataformaVehiculoSyncService.php` — **crear**.
- `app/Http/Controllers/Api/TrackingWebhookController.php` — usar el servicio + try/catch.
- `app/Services/GpsWoxService.php` — usar el servicio en `sincronizarVehiculoDesdePlataforma`.
- `tests/Feature/Services/PlataformaVehiculoSyncServiceTest.php` — **crear**.

## Fuera de alcance (YAGNI)

- No se cambia el contrato del payload del webhook ni del pull.
- No se tocan `gpswox_id`/`gpswox_active` (su manejo queda igual).
- No se agrega liberación de SIM en otros flujos (alta manual, edición) — solo sync de plataforma.
