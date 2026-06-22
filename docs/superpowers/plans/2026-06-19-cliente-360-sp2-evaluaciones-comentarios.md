# Cliente 360° · SP#2 Evaluaciones por área + Comentarios/reseñas — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Permitir que un usuario con permiso deje una reseña (comentario + calificación 1-5 opcional) sobre un cliente, asociada automáticamente al área/equipo del usuario, visible dentro del dashboard Cliente 360° existente.

**Architecture:** Un modelo nuevo `Resena` (tabla `resenas`) con `EmpresaScope`, relacionado a `Clientes`, `User` (autor) y `Team` (área, reutilizando la columna `kpi_area` ya existente — sin taxonomía nueva). Un componente Livewire nuevo y aislado `ClienteResenas` (formulario + listado) embebido dentro de `client360-dashboard.blade.php`, siguiendo el mismo patrón de separación que ya usa el timeline de actividad (partial separado) y `GpswoxService` (servicio separado) en SP#1.

**Tech Stack:** Laravel 12, Livewire 4, TailwindCSS, Spatie Permission, paquete `wireui/wireui` (trait `WireUiActions`, ya usado en `KpiEquipos.php`).

> **Restricción de validación (igual que SP#1):** NUNCA ejecutar `php artisan test`. Verificación de cada archivo PHP es `php -l <archivo>`.

> **Nota sobre tests automatizados:** el usuario indicó explícitamente que no son necesarios para este sub-proyecto ("no es necesario un test"). Este plan no incluye pasos de TDD/PHPUnit. La verificación es manual (Task 7) más `php -l` por archivo.

**Spec:** `docs/superpowers/specs/2026-06-19-cliente-360-sp2-evaluaciones-comentarios-design.md`

---

## File Structure

- Modify `database/seeders/PermisosSeeder.php` — agregar permiso `gestionar-resenas-cliente`
- Create `database/migrations/2026_06_19_000001_create_resenas_table.php`
- Create `app/Models/Resena.php`
- Modify `app/Models/Clientes.php` — agregar relación `resenas()`
- Create `app/Livewire/Admin/Clientes/ClienteResenas.php`
- Create `resources/views/livewire/admin/clientes/cliente-resenas.blade.php`
- Modify `resources/views/livewire/admin/clientes/client360-dashboard.blade.php` — embeber `<livewire:admin.clientes.cliente-resenas>`

---

## Task 1: Permiso `gestionar-resenas-cliente`

**Files:**

- Modify: `database/seeders/PermisosSeeder.php`

- [ ] **Step 1: Añadir el permiso al seeder (para futuros entornos que lo ejecuten desde cero)**

Busca en `database/seeders/PermisosSeeder.php`:

```php
            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'cambiar.estado-cliente',
            'eliminar-cliente',
            'exportar-cliente',
            'importar-cliente',
            'ver-cliente-360',
```

Reemplaza por:

```php
            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'cambiar.estado-cliente',
            'eliminar-cliente',
            'exportar-cliente',
            'importar-cliente',
            'ver-cliente-360',
            'gestionar-resenas-cliente',
```

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l database/seeders/PermisosSeeder.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Crear el permiso en la base de datos actual (el seeder no es re-ejecutable, ya creó los roles/permisos iniciales)**

Run: `php artisan tinker --execute="echo Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'gestionar-resenas-cliente', 'guard_name' => 'web'])->id;"`
Expected: imprime un ID numérico (sin error)

- [ ] **Step 4: Commit**

```bash
git add database/seeders/PermisosSeeder.php
git commit -m "feat(cliente-360): permiso gestionar-resenas-cliente"
```

> Nota para el reporte final al usuario: el permiso queda creado pero **sin asignar a ningún rol** — el usuario debe asignarlo manualmente desde la pantalla de gestión de roles existente a quien corresponda.

---

## Task 2: Migración tabla `resenas`

**Files:**

- Create: `database/migrations/2026_06_19_000001_create_resenas_table.php`

- [ ] **Step 1: Crear la migración**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('team_id');
            $table->text('comentario');
            $table->tinyInteger('calificacion')->nullable()->comment('Calificación 1-5 estrellas, opcional');
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->index('cliente_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
```

> Convención de FKs (`unsignedBigInteger` + `foreign()->references()->on()->onDelete('cascade')`) tomada de `database/migrations/2026_01_18_215815_create_teams_table.php` y `2026_01_18_215819_create_team_user_table.php`. `tinyInteger('calificacion')` nullable replica el patrón ya usado en `2026_06_02_000001_add_calificacion_cliente_to_work_orders_table.php` (`calificacion_cliente`).

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l database/migrations/2026_06_19_000001_create_resenas_table.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Ejecutar la migración**

Run: `php artisan migrate --path=database/migrations/2026_06_19_000001_create_resenas_table.php`
Expected: `Migrating: 2026_06_19_000001_create_resenas_table` seguido de `Migrated:` sin error

- [ ] **Step 4: Commit**

```bash
git add database/migrations/2026_06_19_000001_create_resenas_table.php
git commit -m "feat(cliente-360): migracion tabla resenas"
```

---

## Task 3: Modelo `Resena` + relación `Clientes::resenas()`

**Files:**

- Create: `app/Models/Resena.php`
- Modify: `app/Models/Clientes.php`

- [ ] **Step 1: Crear el modelo**

```php
<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resena extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'calificacion' => 'integer',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
```

> Sin `LogsActivity`: la reseña ya es en sí misma un registro de auditoría inmutable (decisión del spec). Sin `SoftDeletes`: no hay borrado, ni soft ni hard, por flujo de la app (no se expone ningún método `eliminar()`).

- [ ] **Step 2: Añadir la relación `resenas()` en `Clientes.php`**

Busca en `app/Models/Clientes.php`:

```php
    public function clienteUsers(): HasMany
    {
        return $this->hasMany(ClienteUser::class, 'cliente_id');
    }
}
```

Reemplaza por:

```php
    public function clienteUsers(): HasMany
    {
        return $this->hasMany(ClienteUser::class, 'cliente_id');
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class, 'cliente_id');
    }
}
```

- [ ] **Step 3: Verificar sintaxis**

Run: `php -l app/Models/Resena.php && php -l app/Models/Clientes.php`
Expected: dos `No syntax errors detected`

- [ ] **Step 4: Verificación funcional rápida (solo lectura, no crea registros)**

Run: `php artisan tinker --execute="
\$c = App\Models\Clientes::first();
echo \$c ? 'cliente='.\$c->id.' resenas='.\$c->resenas()->count() : 'sin clientes para probar';
"`
Expected: `cliente=N resenas=0` (o el conteo real), sin excepción

- [ ] **Step 5: Commit**

```bash
git add app/Models/Resena.php app/Models/Clientes.php
git commit -m "feat(cliente-360): modelo Resena y relacion Clientes::resenas()"
```

---

## Task 4: Componente Livewire `ClienteResenas` (lógica)

**Files:**

- Create: `app/Livewire/Admin/Clientes/ClienteResenas.php`

- [ ] **Step 1: Crear el componente**

```php
<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Clientes;
use App\Models\Resena;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class ClienteResenas extends Component
{
    use WireUiActions;

    public Clientes $cliente;

    public string $comentario = '';

    public ?int $calificacion = null;

    public function guardar(): void
    {
        abort_unless(auth()->user()->can('gestionar-resenas-cliente'), 403);

        $this->validate([
            'comentario' => 'required|string|max:2000',
            'calificacion' => 'nullable|integer|between:1,5',
        ], [
            'comentario.required' => 'Escribe un comentario.',
            'comentario.max' => 'El comentario no puede superar los 2000 caracteres.',
            'calificacion.between' => 'La calificación debe estar entre 1 y 5.',
        ]);

        $team = auth()->user()->teams()->first();

        if (! $team) {
            $this->notification()->error('Error', 'Debes pertenecer a un equipo para registrar reseñas.');
            return;
        }

        Resena::create([
            'empresa_id' => session('empresa', 1),
            'cliente_id' => $this->cliente->id,
            'user_id' => auth()->id(),
            'team_id' => $team->id,
            'comentario' => $this->comentario,
            'calificacion' => $this->calificacion,
        ]);

        $this->reset(['comentario', 'calificacion']);

        $this->notification()->success('Listo', 'Reseña agregada.');
    }

    public function render()
    {
        $resenas = $this->cliente->resenas()
            ->with(['user', 'team'])
            ->latest()
            ->limit(20)
            ->get();

        return view('livewire.admin.clientes.cliente-resenas', [
            'resenas' => $resenas,
        ]);
    }
}
```

> `session('empresa', 1)` replica exactamente el valor por defecto que usa `EmpresaScope::apply()` (`app/Scopes/EmpresaScope.php:21`), y el patrón de asignación explícita de `empresa_id` al crear ya usado en `KpiEquipos::mount()` (`Team::firstOrCreate(['empresa_id' => $empresaId, ...])`) — no hay un observer que lo autocomplete.
>
> `auth()->user()->teams()->first()` resuelve el "primer equipo del usuario" tal como decidió el spec; si el usuario no tiene ningún equipo, se bloquea sin persistir nada.
>
> `abort_unless(...->can(...), 403)` es defensa en profundidad: la vista (Task 5) ya oculta el formulario sin el permiso, pero el método debe rechazar la llamada igualmente si se invoca directamente.

- [ ] **Step 2: Verificar sintaxis**

Run: `php -l app/Livewire/Admin/Clientes/ClienteResenas.php`
Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
git add app/Livewire/Admin/Clientes/ClienteResenas.php
git commit -m "feat(cliente-360): componente ClienteResenas (logica)"
```

> Este componente referencia la vista `livewire.admin.clientes.cliente-resenas`, creada en la Task 5. Hasta entonces, renderizarlo fallará — eso se completa en la siguiente tarea.

---

## Task 5: Vista `cliente-resenas.blade.php` (formulario + listado)

**Files:**

- Create: `resources/views/livewire/admin/clientes/cliente-resenas.blade.php`

- [ ] **Step 1: Crear la vista**

```blade
<div class="rounded-xl bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-800 p-5">
    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-3">
        Reseñas ({{ $resenas->count() }})
    </h2>

    @can('gestionar-resenas-cliente')
        <form wire:submit.prevent="guardar" class="mb-5 space-y-3">
            <div>
                <label for="comentario" class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Comentario</label>
                <textarea wire:model="comentario" id="comentario" rows="3"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm"
                    placeholder="Escribe una reseña sobre este cliente..."></textarea>
                @error('comentario')
                    <span class="text-xs text-rose-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <span class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Calificación (opcional)</span>
                <div class="flex items-center gap-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('calificacion', {{ $i }})"
                            class="p-0.5" title="{{ $i }} estrella(s)">
                            <svg class="w-5 h-5 {{ $calificacion && $i <= $calificacion ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    @endfor
                    @if ($calificacion)
                        <button type="button" wire:click="$set('calificacion', null)"
                            class="ml-2 text-xs text-gray-400 hover:text-gray-600">Quitar</button>
                    @endif
                </div>
                @error('calificacion')
                    <span class="text-xs text-rose-600">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-colors">
                Agregar reseña
            </button>
        </form>
    @endcan

    @if ($resenas->isNotEmpty())
        <ul class="space-y-3">
            @foreach ($resenas as $resena)
                <li wire:key="resena-{{ $resena->id }}" class="rounded-lg ring-1 ring-gray-200 dark:ring-gray-800 p-3">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="font-medium text-gray-800 dark:text-gray-100">{{ $resena->user->name }}</span>
                            <span class="text-xs text-gray-400">
                                — {{ \App\Models\Team::KPI_AREAS[$resena->team->kpi_area] ?? $resena->team->name }}
                            </span>
                        </div>
                        <time class="text-xs text-gray-400">{{ $resena->created_at->format('d/m/Y H:i') }}</time>
                    </div>

                    @if ($resena->calificacion)
                        <div class="flex items-center gap-0.5 mt-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $resena->calificacion ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    @endif

                    <p class="text-sm text-gray-700 dark:text-gray-200 mt-2">{{ $resena->comentario }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm text-gray-400">Sin reseñas registradas.</p>
    @endif
</div>
```

> Estrellas SVG reutilizadas del patrón ya existente en `resources/views/livewire/admin/work-orders/show.blade.php:503-517` (`calificacion_cliente`), para consistencia visual entre ambas features de calificación 1-5.
>
> El formulario completo (incluyendo el textarea y el selector de estrellas) está dentro de `@can('gestionar-resenas-cliente')` — sin el permiso, el usuario solo ve el listado de solo lectura, tal como decidió el spec.

- [ ] **Step 2: Commit**

```bash
git add resources/views/livewire/admin/clientes/cliente-resenas.blade.php
git commit -m "feat(cliente-360): vista ClienteResenas - formulario y listado"
```

---

## Task 6: Embeber el componente en el dashboard Cliente 360°

**Files:**

- Modify: `resources/views/livewire/admin/clientes/client360-dashboard.blade.php`

- [ ] **Step 1: Insertar el componente entre el panel de documentos y el timeline**

Busca:

```blade
    @include('livewire.admin.clientes.partials.client360-comercial-timeline')
</div>
```

Reemplaza por:

```blade
    <livewire:admin.clientes.cliente-resenas :cliente="$cliente" />

    @include('livewire.admin.clientes.partials.client360-comercial-timeline')
</div>
```

> Sintaxis `<livewire:admin.clientes.cliente-resenas :cliente="$cliente" />` tomada del patrón ya usado en el proyecto para componentes anidados (`resources/views/livewire/admin/whats-fleep/inbox/index.blade.php:9-29`).

- [ ] **Step 2: Commit**

```bash
git add resources/views/livewire/admin/clientes/client360-dashboard.blade.php
git commit -m "feat(cliente-360): embeber ClienteResenas en el dashboard 360"
```

---

## Task 7: Verificación manual end-to-end

**Files:** _(ninguno)_

- [ ] **Step 1: Confirmar que el permiso existe y asignarlo a tu usuario/rol de prueba**

Run: `php artisan tinker --execute="
\$p = Spatie\Permission\Models\Permission::where('name','gestionar-resenas-cliente')->first();
echo \$p ? 'permiso existe, id='.\$p->id : 'FALTA crear el permiso (revisar Task 1)';
"`
Expected: `permiso existe, id=N`

Si tu usuario de prueba no lo tiene:
Run: `php artisan tinker --execute="App\Models\User::find(<tu_user_id>)->givePermissionTo('gestionar-resenas-cliente');"`

- [ ] **Step 2: Confirmar que tu usuario de prueba pertenece a algún equipo**

Run: `php artisan tinker --execute="
\$u = App\Models\User::find(<tu_user_id>);
echo \$u->teams()->count() . ' equipo(s): ' . \$u->teams()->pluck('name')->implode(', ');
"`
Expected: al menos 1 equipo. Si devuelve 0, asígnalo desde la pantalla de gestión de equipos (`KpiEquipos`) antes de continuar — de lo contrario el formulario mostrará el error "Debes pertenecer a un equipo".

- [ ] **Step 3: Abrir el dashboard Cliente 360° de un cliente cualquiera**

Visita `/admin/clientes/{id}/360`, confirma que aparece el nuevo panel "Reseñas" entre Documentos y Actividad reciente, con el formulario visible (si tienes el permiso) y "Sin reseñas registradas." si aún no hay ninguna.

- [ ] **Step 4: Crear una reseña con calificación**

Escribe un comentario, selecciona 4 estrellas, guarda. Confirma que aparece de inmediato en el listado con tu nombre, el área de tu equipo, las 4 estrellas y el comentario.

- [ ] **Step 5: Crear una reseña sin calificación**

Repite sin seleccionar estrellas — confirma que se guarda igual, sin sección de estrellas en el listado para esa reseña.

- [ ] **Step 6: Verificar el bloqueo de validación**

Intenta guardar con el comentario vacío — confirma que aparece el mensaje de error bajo el textarea y no se crea ningún registro nuevo.

- [ ] **Step 7: Verificar que un usuario sin el permiso solo ve el listado**

Con un usuario de prueba sin `gestionar-resenas-cliente` (o quitándoselo temporalmente), confirma que el formulario no aparece pero el listado de reseñas existentes sí es visible.

- [ ] **Step 8: Sin commit** (esta tarea no produce archivos)

---

## Self-Review (completado al escribir el plan)

- **Cobertura del spec:** modelo `Resena` con `EmpresaScope` y relaciones (Task 3), permiso dedicado `gestionar-resenas-cliente` (Task 1), área auto-derivada de `auth()->user()->teams()->first()->kpi_area` sin selección manual (Task 4), bloqueo si el usuario no tiene equipo (Task 4, Step 1 del componente), reseñas inmutables — no se generó ningún método de edición/borrado (Task 4), panel embebido dentro del dashboard 360° existente, no como página separada (Task 6), formulario visible solo con permiso, listado visible para cualquiera con acceso a Cliente 360° (Task 5). Fuera de alcance respetado: sin edición/eliminación, sin selección manual de área, sin agregación/score (eso es SP#3/SP#4), sin notificaciones email/push.
- **Placeholders:** ninguno; todo el código está completo y verificado contra los archivos reales del proyecto (`Clientes.php`, `Team.php`, `User.php`, `EmpresaScope.php`, `KpiEquipos.php`, `work-orders/show.blade.php`, migraciones de `teams`/`team_user`/`work_orders`).
- **Consistencia de tipos:** `ClienteResenas::$cliente` (Clientes) coincide con `:cliente="$cliente"` en la Task 6 y con el binding automático ya usado por `Client360Dashboard`. Las propiedades `comentario`/`calificacion` del componente (Task 4) coinciden exactamente con los campos usados en el formulario de la vista (Task 5: `wire:model="comentario"`, `$set('calificacion', ...)`). La relación `cliente->resenas()` (Task 3) coincide con la consulta `$this->cliente->resenas()->with(['user', 'team'])` del componente (Task 4). Las columnas de la migración (`empresa_id`, `cliente_id`, `user_id`, `team_id`, `comentario`, `calificacion`, Task 2) coinciden exactamente con los campos asignados en `Resena::create([...])` (Task 4).
