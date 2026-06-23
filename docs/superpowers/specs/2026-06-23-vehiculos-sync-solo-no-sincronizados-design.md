# Vehículos — Sincronizar solo no-sincronizados + filtro "No está en plataforma"

**Fecha:** 2026-06-23
**Componentes:** `App\Livewire\Admin\Vehiculos\SincronizarFlota`, `App\Livewire\Admin\Vehiculos\VehiculosIndex`, `App\Models\Vehiculos`

## Problema

1. El modal "Sincronizar Flota con GPSWox" siempre recorre **todos** los vehículos (`Vehiculos::count()` + iteración por id). No hay forma de reprocesar solo los que nunca se vincularon a la plataforma (los que fallaron antes o son nuevos).
2. El index tiene un filtro "Plataforma" con `Todos / Activo en plataforma / Inactivo en plataforma` (sobre `gpswox_active`), pero no permite ver los vehículos que **no están en la plataforma GPSWox** (sin `gpswox_id`).

## Objetivo

- Agregar al modal un toggle "Solo no sincronizados" que limita el proceso a vehículos sin vínculo en GPSWox.
- Agregar al dropdown "Plataforma" del index una opción "No está en plataforma" que filtra esos mismos vehículos.

## Definición compartida: "no sincronizado"

Un vehículo está **sin sincronizar / no en plataforma** cuando:

```
gpswox_id IS NULL OR gpswox_sincronizado_at IS NULL
```

`sincronizarVehiculoDesdePlataforma()` setea `gpswox_id` y `gpswox_sincronizado_at` juntos solo cuando la placa se encuentra en la plataforma. El `OR` es literal a lo pedido y robusto ante datos donde uno esté seteado sin el otro.

### Scope reutilizable (fuente única de verdad)

En `app/Models/Vehiculos.php`. El `OR` va **envuelto en un closure** para que, al combinarse con otras condiciones (p. ej. el cursor `where('id','>',$lastId)`), quede como `AND (gpswox_id IS NULL OR gpswox_sincronizado_at IS NULL)` y no se rompa la precedencia:

```php
public function scopeSinSincronizarGpswox($query)
{
    return $query->where(function ($q) {
        $q->whereNull('gpswox_id')->orWhereNull('gpswox_sincronizado_at');
    });
}
```

## Sección 1 — Modal `SincronizarFlota`

### Componente (`SincronizarFlota.php`)

- Nueva propiedad: `public bool $soloNoSincronizados = false;`
- Helper privado para contar/consultar según el modo:

```php
private function baseQuery()
{
    return Vehiculos::query()
        ->when($this->soloNoSincronizados, fn ($q) => $q->sinSincronizarGpswox());
}
```

- `abrir()`: `$this->reset([... , 'soloNoSincronizados'])` y `$this->total = $this->baseQuery()->count();`
- `iniciar()`: recalcular `$this->total = $this->baseQuery()->count();` (igual que hoy pero vía `baseQuery`).
- Nuevo hook para que el total mostrado reaccione al toggle antes de iniciar:

```php
public function updatedSoloNoSincronizados(): void
{
    $this->total = $this->baseQuery()->count();
}
```

- `procesarSiguiente()`: aplicar el scope agrupado junto al cursor por id:

```php
$vehiculo = Vehiculos::query()
    ->when($this->soloNoSincronizados, fn ($q) => $q->sinSincronizarGpswox())
    ->where('id', '>', $this->lastId)
    ->orderBy('id')
    ->first();
```

> El scope ya agrupa su `OR` en un closure (ver "Definición compartida"), así que el cursor `where('id','>',$lastId)` queda correctamente como `AND (gpswox_id IS NULL OR gpswox_sincronizado_at IS NULL)`.

### Vista (`sincronizar-flota.blade.php`)

Dentro del bloque "Listo para iniciar" (`@if (! $corriendo && ! $terminado && $total > 0)` … y también cuando `$total === 0` para poder togglear), agregar un checkbox antes del texto de total:

```blade
<label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
    <input type="checkbox" wire:model.live="soloNoSincronizados"
        class="rounded border-gray-300 text-violet-500 focus:ring-violet-400">
    Solo verificar los que no están en GPSWox / nunca sincronizados
</label>
```

El toggle solo se muestra cuando `! $corriendo && ! $terminado`. El contador "Total de vehículos a procesar: {{ $total }}" ya refleja el modo gracias a `updatedSoloNoSincronizados()`.

Edge: si con el toggle activo `$total === 0`, el bloque actual (`$total > 0`) se oculta. Ajustar la condición del bloque "Listo para iniciar" para mostrar el toggle aunque el total sea 0, y mostrar un aviso "No hay vehículos pendientes de sincronizar" cuando `soloNoSincronizados && total === 0`. El botón "Iniciar" se deshabilita si `$total === 0`.

## Sección 2 — Filtro index `VehiculosIndex`

### Componente (`VehiculosIndex.php`)

En `render()`, junto a los `when` de `gpswox_filter` existentes, agregar:

```php
->when($this->gpswox_filter === 'sin_sincronizar', fn ($q) => $q->sinSincronizarGpswox())
```

No requiere cambios en `clearFilters()` ni en `updatingGpswoxFilter()` (ya existen y resetean/paginan correctamente).

### Vista (`vehiculos-index.blade.php`)

En el `<select wire:model.live="gpswox_filter">`, agregar una opción:

```blade
<option value="sin_sincronizar">No está en plataforma</option>
```

## Pruebas

Test unitario del scope (sin tocar la red ni la plataforma), en `tests/Unit/Models/` o `tests/Feature/Admin/Vehiculos/`:

1. Vehículo con `gpswox_id = null` → aparece en `sinSincronizarGpswox()`.
2. Vehículo con `gpswox_sincronizado_at = null` (id seteado) → aparece.
3. Vehículo con `gpswox_id` y `gpswox_sincronizado_at` ambos seteados → NO aparece.
4. Combinado con otra condición (`where('id','>',0)`) el agrupamiento del scope mantiene `AND (… OR …)` (no trae filas sincronizadas).

> Estos tests requieren BD (factory de Vehiculos existe: `database/factories/VehiculosFactory.php`). Por preferencia registrada del usuario **no** se ejecuta `php artisan test` (RefreshDatabase borraría la BD real). Se validan archivos con `php -l`; los tests quedan en el repo para un entorno con BD de pruebas.

## Archivos afectados

- `app/Models/Vehiculos.php` — scope `sinSincronizarGpswox`.
- `app/Livewire/Admin/Vehiculos/SincronizarFlota.php` — propiedad + hook + `baseQuery` + filtro en `procesarSiguiente`.
- `resources/views/livewire/admin/vehiculos/sincronizar-flota.blade.php` — checkbox toggle + manejo de total 0.
- `app/Livewire/Admin/Vehiculos/VehiculosIndex.php` — `when` para `sin_sincronizar`.
- `resources/views/livewire/admin/vehiculos/vehiculos-index.blade.php` — opción del dropdown.
- `tests/...VehiculosSinSincronizarGpswoxTest.php` — test del scope.

## Fuera de alcance (YAGNI)

- No se modifica la lógica de matching contra GPSWox ni `gpswox_active`.
- No se agregan controles nuevos fuera del dropdown existente para el filtro.
- No se cambia el recorrido placa-por-placa ni el manejo de errores Alpine del modal.
