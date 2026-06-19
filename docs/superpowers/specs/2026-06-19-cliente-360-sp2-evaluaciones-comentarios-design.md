# Cliente 360° — SP#2: Evaluaciones por área + Comentarios/reseñas

## Contexto

SP#1 (`docs/superpowers/specs/2026-06-18-cliente-360-sp1-dashboard-base-design.md`) entregó el dashboard Cliente 360° de solo lectura (header, vehículos/GPS, documentos, resumen comercial, timeline de actividad). Ese spec dejó fuera de alcance explícitamente: "sin scoring, sin evaluaciones, sin comentarios nuevos, sin relación usuario()/ejecutivo() en el modelo".

SP#2 cubre esa funcionalidad diferida: un usuario puede dejar una reseña (comentario + calificación opcional) sobre un cliente, quedando asociada automáticamente al área/equipo (`Team`) del usuario que la escribe. Es la primera pieza de Cliente 360° con **escritura** (todo SP#1 era solo lectura).

SP#3 (Customer Health Score) y SP#4 (panel gerencial/alertas/recomendaciones) seguirán como sub-proyectos posteriores y consumirán estas reseñas como una de sus fuentes de datos — no se construyen aquí.

## Decisiones de diseño

- **Un solo modelo `Resena`**, no dos features separadas: combina comentario (texto), calificación (1-5, opcional) y área en un único registro.
- **El área NO es un campo nuevo ni una relación duplicada.** Se reutiliza la infraestructura ya existente: la tabla `teams` ya tiene una columna `kpi_area` (migración `2026_07_26_000001_add_kpi_area_to_teams_table.php`), y `KpiEquipos::mount()` garantiza que existe un `Team` real por cada una de las 6 áreas de `Team::KPI_AREAS` (comercial, operaciones, administracion, postventa, monitoreo, gerencia) por empresa. La reseña simplemente apunta a un `team_id` real.
- **El área se auto-asigna del primer equipo del usuario** (`auth()->user()->teams()->first()`), sin selección manual en el formulario. Un usuario puede pertenecer a varios equipos (`belongsToMany`); se usa el primero.
- **Las reseñas son inmutables**: no se editan ni se eliminan una vez creadas (igual que el timeline de actividad — es un registro histórico).
- **Si el usuario no pertenece a ningún equipo, se bloquea la creación** con un mensaje de error claro. Esto garantiza que toda reseña tenga un área válida, requisito para que SP#3/SP#4 puedan agregar métricas por área sin registros huérfanos.

## Modelo de datos

**Migración nueva:** `create_resenas_table`

| Columna | Tipo | Notas |
|---|---|---|
| `id` | bigint | PK |
| `empresa_id` | FK → `empresas` | para `EmpresaScope` |
| `cliente_id` | FK → `clientes` | |
| `user_id` | FK → `users` | autor |
| `team_id` | FK → `teams` | área, auto-derivada, NOT NULL |
| `comentario` | text | requerido |
| `calificacion` | tinyint unsigned, nullable | 1-5 |
| `created_at` / `updated_at` | timestamps | sin `deleted_at` (inmutable, sin borrado) |

**Modelo `App\Models\Resena`:**
- `EmpresaScope` global scope (mismo patrón que `Clientes`, `Team`, etc. — `static::addGlobalScope(new EmpresaScope)` en `booted()`).
- `belongsTo(Clientes::class, 'cliente_id')`
- `belongsTo(User::class, 'user_id')` — autor
- `belongsTo(Team::class, 'team_id')` — área (nombre legible vía `Team::KPI_AREAS[$resena->team->kpi_area]`)
- `$guarded = ['id', 'created_at', 'updated_at']`
- Sin `LogsActivity`: la reseña ya es en sí misma un registro de auditoría inmutable.

**Relación nueva en `Clientes.php`:** `resenas(): HasMany` → `Resena::class, 'cliente_id'`. No existe ninguna relación de reseñas/comentarios en `Clientes` hoy — no es una relación duplicada.

## Permisos y autorización

- **Permiso nuevo:** `gestionar-resenas-cliente`, agregado a `database/seeders/PermisosSeeder.php` (mismo patrón que `ver-cliente-360` de SP#1 — permiso dedicado, no reutilizado).
- **Ver el listado de reseñas:** visible para cualquiera con `ver-cliente-360` (el panel vive dentro del dashboard 360°, no requiere permiso de lectura separado).
- **Agregar una reseña:** requiere `gestionar-resenas-cliente`, verificado tanto en el Blade (`@can('gestionar-resenas-cliente')` para mostrar/ocultar el formulario) como en el método del componente Livewire (`abort_unless` antes de persistir) — doble verificación, mismo patrón que el resto de la app.
- **Multi-tenancy:** `EmpresaScope` en `Resena` impide ver o crear reseñas de clientes de otra empresa, igual que el resto de los modelos del dashboard.

## Componente Livewire y UI

**Nuevo componente:** `App\Livewire\Admin\Clientes\ClienteResenas` + vista `resources/views/livewire/admin/clientes/cliente-resenas.blade.php`, embebido en `client360-dashboard.blade.php` entre el panel de documentos y el timeline:

```blade
<livewire:admin.clientes.cliente-resenas :cliente="$cliente" />
@include('livewire.admin.clientes.partials.client360-comercial-timeline')
```

**Propiedades públicas:**
```php
public Clientes $cliente;
public string $comentario = '';
public ?int $calificacion = null;
```

**`mount(Clientes $cliente)`:** recibe el cliente.

**`render()`:** carga `$cliente->resenas()->with(['user', 'team'])->latest()->limit(20)->get()` (mismo límite/patrón usado por certificados/actas/timeline en SP#1).

**`guardar()`:**
1. `abort_unless(auth()->user()->can('gestionar-resenas-cliente'), 403)`.
2. Valida: `comentario` → `required|string|max:2000`; `calificacion` → `nullable|integer|between:1,5`.
3. Resuelve `$team = auth()->user()->teams()->first();`. Si es `null`, agrega un error de validación al campo (mensaje: "Debes pertenecer a un equipo para registrar reseñas") y detiene — no crea el registro.
4. Crea el `Resena` con `cliente_id`, `user_id = auth()->id()`, `team_id = $team->id`, `comentario`, `calificacion`.
5. Resetea `comentario` y `calificacion`, y muestra notificación de éxito (`WireUiActions`/`notification()`, mismo patrón que `KpiEquipos.php`).

**UI:**
- El formulario solo se renderiza si `@can('gestionar-resenas-cliente')`; sin el permiso, el usuario solo ve el listado (solo lectura).
- Cada reseña del listado muestra: autor (`$resena->user->name`), área (`Team::KPI_AREAS[$resena->team->kpi_area]`), estrellas si `calificacion` no es null, el comentario, y la fecha.
- Estilo visual consistente con los demás paneles del dashboard (`rounded-xl ring-1 ring-gray-200 dark:ring-gray-800 p-5`), como tarjetas/filas (no tabla, por ser texto libre de longitud variable).

## Validación y casos borde

- `comentario`: requerido, string, máx. 2000 caracteres.
- `calificacion`: opcional, entero entre 1 y 5.
- Usuario sin equipo: bloqueado, mensaje de error, sin persistir.
- Usuario sin permiso `gestionar-resenas-cliente`: 403 si invoca `guardar()` directamente (defensa en profundidad, además de ocultar el form en la UI).
- Cliente de otra empresa: ya cubierto por `EmpresaScope` (404 vía route-model binding, consistente con el comportamiento de SP#1).

## Fuera de alcance (explícito)

- Edición o eliminación de reseñas (son inmutables).
- Selección manual de área en el formulario (siempre auto-derivada).
- Cualquier agregación, score o alerta sobre las reseñas — eso corresponde a SP#3 (Customer Health Score) y SP#4 (panel gerencial).
- Notificaciones (email/push) al crear una reseña.
- Tests automatizados para esta feature (decisión explícita del usuario para este sub-proyecto).
