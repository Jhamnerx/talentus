# Post-Venta: Mensajes Automáticos WhatsApp — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** When an admin closes a Work Order, automatically send a WhatsApp message to the client's gerente contact and queue a daily summary for post-venta/ventas users.

**Architecture:** Event/Listener/Job pipeline — `WorkOrder::cerrar()` fires `WorkOrderCerrada`; a queued listener dispatches `EnviarMensajeClienteJob`; a separate daily job sends the resumen. CRUD Livewire components under Ajustes manage message templates per sector.

**Tech Stack:** Laravel 12, Livewire 4, WhatsappService (existing), Spatie Permissions, EmpresaScope (existing), Tailwind CSS v4

---

## File Map

### New files
```
database/migrations/YYYY_add_es_postventa_to_devices_table.php
database/migrations/YYYY_create_postventa_plantillas_table.php
app/Models/PostventaPlantilla.php
app/Events/WorkOrderCerrada.php
app/Listeners/EnviarMensajePostventaListener.php
app/Jobs/EnviarMensajeClienteJob.php
app/Jobs/EnviarResumenDiarioPostventaJob.php
app/Livewire/Admin/Ajustes/Postventa/Plantillas/Index.php
app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php
app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php
app/Livewire/Admin/Ajustes/Postventa/Plantillas/Delete.php
resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php
resources/views/livewire/admin/ajustes/postventa/plantillas/save.blade.php
resources/views/livewire/admin/ajustes/postventa/plantillas/edit.blade.php
resources/views/livewire/admin/ajustes/postventa/plantillas/delete.blade.php
resources/views/admin/ajustes/postventa.blade.php
```

### Modified files
```
app/Models/WhatsFleep/Device.php               — add es_postventa to fillable + casts
app/Models/WorkOrder.php                        — fire WorkOrderCerrada event in cerrar()
bootstrap/app.php                               — schedule EnviarResumenDiarioPostventaJob
app/Http/Controllers/Admin/AjustesController.php — add postventa() method
routes/web.php                                  — add admin.ajustes.postventa route
app/Livewire/Admin/WhatsFleep/Devices/Index.php  — add togglePostventa() method
resources/views/livewire/admin/whats-fleep/devices/index.blade.php — add Post-Venta column
resources/views/components/admin/settings/navigation.blade.php     — add Post-Venta nav link
```

---

## Task 1: Migrations

**Files:**
- Create: `database/migrations/2026_06_12_000001_add_es_postventa_to_devices_table.php`
- Create: `database/migrations/2026_06_12_000002_create_postventa_plantillas_table.php`

- [ ] **Step 1: Generate migrations**

```bash
php artisan make:migration add_es_postventa_to_devices_table --no-interaction
php artisan make:migration create_postventa_plantillas_table --no-interaction
```

- [ ] **Step 2: Write the `add_es_postventa_to_devices_table` migration**

Open the generated file and replace its content:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->boolean('es_postventa')->default(false)->after('interno');
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('es_postventa');
        });
    }
};
```

- [ ] **Step 3: Write the `create_postventa_plantillas_table` migration**

Open the generated file and replace its content:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postventa_plantillas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('sector_id')->nullable()->constrained('sectores')->nullOnDelete();
            $table->text('cuerpo');
            $table->string('archivo_url')->nullable();
            $table->enum('archivo_tipo', ['pdf', 'video'])->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postventa_plantillas');
    }
};
```

- [ ] **Step 4: Run migrations**

```bash
php artisan migrate --no-interaction
```

Expected: `DONE` for both new migrations — no errors.

- [ ] **Step 5: Verify with php -l**

```bash
php -l database/migrations/2026_06_12_000001_add_es_postventa_to_devices_table.php
php -l database/migrations/2026_06_12_000002_create_postventa_plantillas_table.php
```

Expected: `No syntax errors detected`

- [ ] **Step 6: Commit**

```bash
git add database/migrations/2026_06_12_000001_add_es_postventa_to_devices_table.php
git add database/migrations/2026_06_12_000002_create_postventa_plantillas_table.php
git commit -m "feat: add es_postventa to devices and create postventa_plantillas table"
```

---

## Task 2: Models

**Files:**
- Create: `app/Models/PostventaPlantilla.php`
- Modify: `app/Models/WhatsFleep/Device.php`

- [ ] **Step 1: Create the PostventaPlantilla model**

```bash
php artisan make:model PostventaPlantilla --no-interaction
```

- [ ] **Step 2: Write the PostventaPlantilla model**

Replace the generated `app/Models/PostventaPlantilla.php`:

```php
<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostventaPlantilla extends Model
{
    protected $table = 'postventa_plantillas';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'activo'     => 'boolean',
            'empresa_id' => 'integer',
            'sector_id'  => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);

        static::creating(function (self $plantilla) {
            $plantilla->empresa_id = session('empresa');
        });
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
```

- [ ] **Step 3: Update Device model — add es_postventa to fillable and casts**

Open `app/Models/WhatsFleep/Device.php`. Update the `$fillable` array and `$casts` array:

```php
protected $fillable = [
    'user_id',
    'body',
    'webhook',
    'status',
    'message_sent',
    'api_key',
    'interno',
    'es_postventa',
];

protected $casts = [
    'message_sent' => 'integer',
    'interno'      => 'boolean',
    'es_postventa' => 'boolean',
];
```

- [ ] **Step 4: Verify with php -l**

```bash
php -l app/Models/PostventaPlantilla.php
php -l app/Models/WhatsFleep/Device.php
```

Expected: `No syntax errors detected` for both.

- [ ] **Step 5: Commit**

```bash
git add app/Models/PostventaPlantilla.php app/Models/WhatsFleep/Device.php
git commit -m "feat: add PostventaPlantilla model and es_postventa to Device"
```

---

## Task 3: Event + WorkOrder trigger

**Files:**
- Create: `app/Events/WorkOrderCerrada.php`
- Modify: `app/Models/WorkOrder.php`

- [ ] **Step 1: Generate the event**

```bash
php artisan make:event WorkOrderCerrada --no-interaction
```

- [ ] **Step 2: Write the WorkOrderCerrada event**

Replace the generated `app/Events/WorkOrderCerrada.php`:

```php
<?php

namespace App\Events;

use App\Models\WorkOrder;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorkOrderCerrada
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public WorkOrder $workOrder
    ) {}
}
```

- [ ] **Step 3: Fire the event in WorkOrder::cerrar()**

Open `app/Models/WorkOrder.php`. The `cerrar()` method currently ends at `$this->save();`. Add the event dispatch after `$this->save()`:

Find this block:
```php
public function cerrar(): void
{
    if ($this->estado !== WorkOrderStatus::FINALIZADO) {
        throw new \Exception('Solo se pueden cerrar órdenes finalizadas');
    }

    $this->bloqueado = true;
    $this->fecha_cerrado = now();
    $this->save();
}
```

Replace with:
```php
public function cerrar(): void
{
    if ($this->estado !== WorkOrderStatus::FINALIZADO) {
        throw new \Exception('Solo se pueden cerrar órdenes finalizadas');
    }

    $this->bloqueado = true;
    $this->fecha_cerrado = now();
    $this->save();

    event(new \App\Events\WorkOrderCerrada($this));
}
```

- [ ] **Step 4: Verify with php -l**

```bash
php -l app/Events/WorkOrderCerrada.php
php -l app/Models/WorkOrder.php
```

Expected: `No syntax errors detected` for both.

- [ ] **Step 5: Commit**

```bash
git add app/Events/WorkOrderCerrada.php app/Models/WorkOrder.php
git commit -m "feat: add WorkOrderCerrada event fired when work order is closed"
```

---

## Task 4: Listener + EnviarMensajeClienteJob

**Files:**
- Create: `app/Listeners/EnviarMensajePostventaListener.php`
- Create: `app/Jobs/EnviarMensajeClienteJob.php`

- [ ] **Step 1: Generate listener and job**

```bash
php artisan make:listener EnviarMensajePostventaListener --no-interaction
php artisan make:job EnviarMensajeClienteJob --no-interaction
```

- [ ] **Step 2: Write the listener**

Replace `app/Listeners/EnviarMensajePostventaListener.php`:

```php
<?php

namespace App\Listeners;

use App\Events\WorkOrderCerrada;
use App\Jobs\EnviarMensajeClienteJob;
use App\Models\WhatsFleep\Device;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EnviarMensajePostventaListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(WorkOrderCerrada $event): void
    {
        $workOrder = $event->workOrder;

        $device = Device::whereHas('user', function ($query) use ($workOrder) {
            $query->where('empresa_id', $workOrder->empresa_id);
        })->where('es_postventa', true)->first();

        if (!$device) {
            Log::warning('EnviarMensajePostventaListener: no hay device es_postventa activo', [
                'work_order_id' => $workOrder->id,
                'empresa_id'    => $workOrder->empresa_id,
            ]);
            return;
        }

        EnviarMensajeClienteJob::dispatch($workOrder, $device);
    }
}
```

- [ ] **Step 3: Write the EnviarMensajeClienteJob**

Replace `app/Jobs/EnviarMensajeClienteJob.php`:

```php
<?php

namespace App\Jobs;

use App\Models\Clientes;
use App\Models\PostventaPlantilla;
use App\Models\Sector;
use App\Models\WorkOrder;
use App\Models\WhatsFleep\Device;
use App\Scopes\EmpresaScope;
use App\Services\WhatsFleep\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnviarMensajeClienteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [30, 60, 120];

    public function __construct(
        public WorkOrder $workOrder,
        public Device $device
    ) {}

    public function handle(WhatsappService $whatsapp): void
    {
        $workOrder = $this->workOrder->load([
            'cliente.contactos',
            'vehiculo',
        ]);

        // 1. Resolve recipient numbers
        $numeros = $workOrder->cliente?->contactos()
            ->where('is_gerente', true)
            ->pluck('telefono')
            ->filter()
            ->values()
            ->toArray();

        if (empty($numeros)) {
            $fallback = $workOrder->cliente?->telefono;
            if (!$fallback) {
                Log::warning('EnviarMensajeClienteJob: cliente sin contacto gerente ni teléfono', [
                    'work_order_id' => $workOrder->id,
                ]);
                return;
            }
            $numeros = [$fallback];
        }

        // 2. Resolve template — match by sector name, fallback to default (sector_id = null)
        $plantilla = $this->resolverPlantilla($workOrder);

        if (!$plantilla) {
            Log::warning('EnviarMensajeClienteJob: no hay plantilla para la OT', [
                'work_order_id' => $workOrder->id,
                'sector'        => $workOrder->sector,
            ]);
            return;
        }

        // 3. Replace variables
        $cuerpo = $this->reemplazarVariables($plantilla->cuerpo, $workOrder);

        // 4. Send to each recipient
        foreach ($numeros as $numero) {
            if ($plantilla->archivo_url) {
                $whatsapp->sendMedia(
                    $this->device->body,
                    $numero,
                    $plantilla->archivo_tipo,
                    url($plantilla->archivo_url),
                    $cuerpo
                );
            } else {
                $whatsapp->sendText($this->device->body, $numero, $cuerpo);
            }
        }
    }

    private function resolverPlantilla(WorkOrder $workOrder): ?PostventaPlantilla
    {
        $empresaId = $workOrder->empresa_id;
        $sectorId  = null;

        if ($workOrder->sector) {
            $nombre   = trim(explode(',', $workOrder->sector)[0]);
            $sectorId = Sector::withoutGlobalScopes()
                ->where('empresa_id', $empresaId)
                ->where('nombre', $nombre)
                ->value('id');
        }

        if ($sectorId) {
            $plantilla = PostventaPlantilla::withoutGlobalScopes()
                ->where('empresa_id', $empresaId)
                ->where('sector_id', $sectorId)
                ->where('activo', true)
                ->first();

            if ($plantilla) {
                return $plantilla;
            }
        }

        return PostventaPlantilla::withoutGlobalScopes()
            ->where('empresa_id', $empresaId)
            ->whereNull('sector_id')
            ->where('activo', true)
            ->first();
    }

    private function reemplazarVariables(string $cuerpo, WorkOrder $workOrder): string
    {
        return str_replace(
            ['{placa}', '{cliente}', '{fecha_instalacion}', '{fecha_cierre}'],
            [
                $workOrder->vehiculo?->placa ?? '',
                $workOrder->cliente?->razon_social ?? '',
                $workOrder->fecha_inicio?->format('d/m/Y') ?? '',
                $workOrder->fecha_cerrado?->format('d/m/Y') ?? '',
            ],
            $cuerpo
        );
    }
}
```

- [ ] **Step 4: Verify with php -l**

```bash
php -l app/Listeners/EnviarMensajePostventaListener.php
php -l app/Jobs/EnviarMensajeClienteJob.php
```

Expected: `No syntax errors detected` for both.

- [ ] **Step 5: Commit**

```bash
git add app/Listeners/EnviarMensajePostventaListener.php app/Jobs/EnviarMensajeClienteJob.php
git commit -m "feat: add post-venta listener and EnviarMensajeClienteJob"
```

---

## Task 5: Daily Summary Job + Schedule

**Files:**
- Create: `app/Jobs/EnviarResumenDiarioPostventaJob.php`
- Modify: `bootstrap/app.php`

- [ ] **Step 1: Generate the job**

```bash
php artisan make:job EnviarResumenDiarioPostventaJob --no-interaction
```

- [ ] **Step 2: Write the job**

Replace `app/Jobs/EnviarResumenDiarioPostventaJob.php`:

```php
<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WhatsFleep\Device;
use App\Scopes\EmpresaScope;
use App\Services\WhatsFleep\WhatsappService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnviarResumenDiarioPostventaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(WhatsappService $whatsapp): void
    {
        $ayer = Carbon::yesterday();

        $ordenes = WorkOrder::withoutGlobalScopes()
            ->with(['vehiculo', 'cliente.contactos'])
            ->where('bloqueado', true)
            ->whereBetween('fecha_cerrado', [
                $ayer->copy()->startOfDay(),
                $ayer->copy()->endOfDay(),
            ])
            ->get();

        if ($ordenes->isEmpty()) {
            return;
        }

        $porEmpresa = $ordenes->groupBy('empresa_id');

        foreach ($porEmpresa as $empresaId => $otEmpresa) {
            $device = Device::whereHas('user', function ($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })->where('interno', true)->first();

            if (!$device) {
                Log::warning('EnviarResumenDiarioPostventaJob: no hay device interno', [
                    'empresa_id' => $empresaId,
                ]);
                continue;
            }

            $usuarios = User::withoutGlobalScope(EmpresaScope::class)
                ->where('empresa_id', $empresaId)
                ->whereNotNull('telefono')
                ->where('telefono', '!=', '')
                ->role(['postventa', 'ventas'])
                ->get();

            if ($usuarios->isEmpty()) {
                continue;
            }

            $mensaje = $this->construirResumen($ayer, $otEmpresa);

            foreach ($usuarios as $usuario) {
                $whatsapp->sendText($device->body, $usuario->telefono, $mensaje);
            }
        }
    }

    private function construirResumen(Carbon $fecha, \Illuminate\Support\Collection $ordenes): string
    {
        $total = $ordenes->count();
        $lineas = ["📋 RESUMEN POST-VENTA | {$fecha->format('d/m/Y')}", "OTs cerradas: {$total}", ''];

        foreach ($ordenes->values() as $i => $ot) {
            $num      = $i + 1;
            $placa    = $ot->vehiculo?->placa ?? 'S/N';
            $cliente  = $ot->cliente?->razon_social ?? 'S/N';
            $contacto = $ot->cliente?->contactos?->first()?->nombre ?? '';
            $telefono = $ot->cliente?->contactos?->first()?->telefono ?? '';
            $inicio   = $ot->fecha_inicio?->format('d/m/Y') ?? '—';
            $cierre   = $ot->fecha_cerrado?->format('d/m/Y') ?? '—';

            $lineas[] = "{$num}. 🚗 {$placa} — {$cliente}";
            if ($contacto) {
                $lineas[] = "   👤 {$contacto}" . ($telefono ? " | {$telefono}" : '');
            }
            $lineas[] = "   📅 Instalación: {$inicio} | Cierre: {$cierre}";
            $lineas[] = '';
        }

        $lineas[] = 'Enviado por el sistema Talentus';

        return implode("\n", $lineas);
    }
}
```

- [ ] **Step 3: Register the job in bootstrap/app.php schedule**

Open `bootstrap/app.php`. Find the `->withSchedule(function (Schedule $schedule) {` block. Add the import at the top of the file:

After the existing `use App\Jobs\CheckTicketSlaJob;` line, add:
```php
use App\Jobs\EnviarResumenDiarioPostventaJob;
```

Inside `withSchedule()`, after the last `$schedule->` line, add:
```php
$schedule->job(new EnviarResumenDiarioPostventaJob)->dailyAt('08:00');
```

- [ ] **Step 4: Verify with php -l**

```bash
php -l app/Jobs/EnviarResumenDiarioPostventaJob.php
php -l bootstrap/app.php
```

Expected: `No syntax errors detected` for both.

- [ ] **Step 5: Commit**

```bash
git add app/Jobs/EnviarResumenDiarioPostventaJob.php bootstrap/app.php
git commit -m "feat: add EnviarResumenDiarioPostventaJob scheduled daily at 08:00"
```

---

## Task 6: Toggle es_postventa in Devices Index

**Files:**
- Modify: `app/Livewire/Admin/WhatsFleep/Devices/Index.php`
- Modify: `resources/views/livewire/admin/whats-fleep/devices/index.blade.php`

- [ ] **Step 1: Add togglePostventa() to the Index component**

Open `app/Livewire/Admin/WhatsFleep/Devices/Index.php`. Add this import at the top with the others:

```php
use Illuminate\Support\Facades\Auth;
```

(It's already imported. Now add the method.) After the `apiKeyCopied()` method and before `render()`, add:

```php
public function togglePostventa(int $deviceId): void
{
    $empresaId = Auth::user()->empresa_id;

    Device::whereHas('user', function ($query) use ($empresaId) {
        $query->where('empresa_id', $empresaId);
    })->update(['es_postventa' => false]);

    Device::findOrFail($deviceId)->update(['es_postventa' => true]);

    $this->notification()->success(
        title: 'Device post-venta actualizado',
        description: 'El número de WhatsApp para mensajes post-venta fue configurado.'
    );
}
```

- [ ] **Step 2: Add Post-Venta column to the index view**

Open `resources/views/livewire/admin/whats-fleep/devices/index.blade.php`.

In the `<thead>` row, after the `<th>Sistema</th>` column, add:
```blade
<th class="px-4 py-3 text-center">Post-Venta</th>
```

In the `<tbody>` rows (inside `@foreach`), after the Sistema `<td>` block, add:
```blade
<td class="px-4 py-3 text-center">
    @if ($device->es_postventa)
        <span
            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Activo
        </span>
    @else
        <button
            wire:click="togglePostventa({{ $device->id }})"
            class="text-xs text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition cursor-pointer underline">
            Activar
        </button>
    @endif
</td>
```

- [ ] **Step 3: Verify with php -l**

```bash
php -l app/Livewire/Admin/WhatsFleep/Devices/Index.php
```

Expected: `No syntax errors detected`

- [ ] **Step 4: Commit**

```bash
git add app/Livewire/Admin/WhatsFleep/Devices/Index.php
git add resources/views/livewire/admin/whats-fleep/devices/index.blade.php
git commit -m "feat: add togglePostventa to Devices Index with Post-Venta column"
```

---

## Task 7: Route, Controller, Page View, Navigation

**Files:**
- Modify: `app/Http/Controllers/Admin/AjustesController.php`
- Modify: `routes/web.php`
- Create: `resources/views/admin/ajustes/postventa.blade.php`
- Modify: `resources/views/components/admin/settings/navigation.blade.php`

- [ ] **Step 1: Add postventa() to AjustesController**

Open `app/Http/Controllers/Admin/AjustesController.php`. After the `sunat()` method, add:

```php
public function postventa(): \Illuminate\View\View
{
    return view('admin.ajustes.postventa');
}
```

- [ ] **Step 2: Add route in web.php**

Open `routes/web.php`. Find the existing ajustes routes block (near line 293). After:
```php
Route::view('ajustes/cuentas-bancarias', 'admin.ajustes.cuentas-bancarias')->name('admin.ajustes.cuentas-bancarias');
```

Add:
```php
Route::get('ajustes/postventa', [AjustesController::class, 'postventa'])->name('admin.ajustes.postventa');
```

- [ ] **Step 3: Create the page view**

Create `resources/views/admin/ajustes/postventa.blade.php`:

```blade
<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">
        @livewire('admin.ajustes.postventa.plantillas.index')
        @livewire('admin.ajustes.postventa.plantillas.save')
        @livewire('admin.ajustes.postventa.plantillas.edit')
        @livewire('admin.ajustes.postventa.plantillas.delete')
    </div>
</x-admin-layout>
```

- [ ] **Step 4: Add Post-Venta link to the settings navigation**

Open `resources/views/components/admin/settings/navigation.blade.php`.

After the last `</li>` before `</ul>` (currently the cuentas-bancarias `</li>`), add:

```blade
@role('admin')
    <li class="mr-0.5 md:mr-0 md:mb-0.5">
        <a href="{{ route('admin.ajustes.postventa') }}"
            class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.postventa')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif">
            <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.postventa')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                width="16" height="16" viewBox="0 0 16 16">
                <path
                    d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1ZM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm11.5-1.5a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h7Zm0 3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h7Z" />
            </svg>
            <span
                class="text-sm font-medium @if (Route::is('admin.ajustes.postventa')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                Post-Venta
            </span>
        </a>
    </li>
@endrole
```

- [ ] **Step 5: Verify with php -l**

```bash
php -l app/Http/Controllers/Admin/AjustesController.php
php -l routes/web.php
```

Expected: `No syntax errors detected` for both.

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/Admin/AjustesController.php
git add routes/web.php
git add resources/views/admin/ajustes/postventa.blade.php
git add resources/views/components/admin/settings/navigation.blade.php
git commit -m "feat: add Post-Venta ajustes route, controller method, view, and navigation link"
```

---

## Task 8: Livewire Plantillas Index

**Files:**
- Create: `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Index.php`
- Create: `resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php`

- [ ] **Step 1: Generate the component**

```bash
php artisan make:livewire "Admin/Ajustes/Postventa/Plantillas/Index" --no-interaction
```

- [ ] **Step 2: Write the Index component**

Replace `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Index.php`:

```php
<?php

namespace App\Livewire\Admin\Ajustes\Postventa\Plantillas;

use App\Models\PostventaPlantilla;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $listeners = ['render', 'update-table' => 'render'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function toggleActivo(int $id): void
    {
        $plantilla = PostventaPlantilla::findOrFail($id);
        $plantilla->update(['activo' => !$plantilla->activo]);

        $this->dispatch('notify-toast',
            icon: 'success',
            title: 'PLANTILLA ' . ($plantilla->activo ? 'ACTIVADA' : 'DESACTIVADA'),
            mensaje: 'El estado de la plantilla fue actualizado.'
        );
    }

    public function openModalSave(): void
    {
        $this->dispatch('openModalSavePlantilla');
    }

    public function openModalEdit(int $id): void
    {
        $this->dispatch('openModalEditPlantilla', id: $id);
    }

    public function openModalDelete(int $id): void
    {
        $this->dispatch('openModalDeletePlantilla', id: $id);
    }

    public function render()
    {
        $plantillas = PostventaPlantilla::with('sector')
            ->when($this->search, function ($q) {
                $q->where('cuerpo', 'like', '%' . $this->search . '%')
                  ->orWhereHas('sector', fn ($sq) => $sq->where('nombre', 'like', '%' . $this->search . '%'));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.ajustes.postventa.plantillas.index', compact('plantillas'));
    }
}
```

- [ ] **Step 3: Write the Index view**

Replace `resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php`:

```blade
<div>
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Plantillas Post-Venta</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Mensajes automáticos enviados al cliente al cerrar una OT. Variables: <code class="text-xs bg-gray-100 dark:bg-gray-700 px-1 rounded">{placa} {cliente} {fecha_instalacion} {fecha_cierre}</code>
            </p>
        </div>
        <div>
            <x-form.button wire:click="openModalSave" primary icon="plus" label="Nueva plantilla" />
        </div>
    </div>

    <div class="mb-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
        <x-form.input wire:model.live.debounce="search" placeholder="Buscar plantilla..." icon="magnifying-glass" />
    </div>

    @if ($plantillas->isEmpty())
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl py-16 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">Aún no hay plantillas registradas.</p>
            <x-form.button wire:click="openModalSave" primary label="Crear primera plantilla" />
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-4 py-3 text-left">Sector</th>
                            <th class="px-4 py-3 text-left">Cuerpo del mensaje</th>
                            <th class="px-4 py-3 text-center">Archivo</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        @foreach ($plantillas as $plantilla)
                            <tr wire:key="plantilla-{{ $plantilla->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $plantilla->sector?->nombre ?? '— Por defecto —' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 max-w-xs">
                                    <p class="text-gray-600 dark:text-gray-300 truncate">{{ $plantilla->cuerpo }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($plantilla->archivo_url)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                            @if ($plantilla->archivo_tipo === 'pdf') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                            @else bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 @endif">
                                            {{ strtoupper($plantilla->archivo_tipo) }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600 text-xs">&mdash;</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button wire:click="toggleActivo({{ $plantilla->id }})"
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full cursor-pointer transition
                                            @if ($plantilla->activo) bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200
                                            @else bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400 hover:bg-gray-200 @endif">
                                        {{ $plantilla->activo ? 'Activa' : 'Inactiva' }}
                                    </button>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="openModalEdit({{ $plantilla->id }})"
                                            class="p-1.5 rounded text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="openModalDelete({{ $plantilla->id }})"
                                            class="p-1.5 rounded text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($plantillas->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/60">
                    {{ $plantillas->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
```

- [ ] **Step 4: Verify with php -l**

```bash
php -l app/Livewire/Admin/Ajustes/Postventa/Plantillas/Index.php
```

Expected: `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Livewire/Admin/Ajustes/Postventa/Plantillas/Index.php
git add resources/views/livewire/admin/ajustes/postventa/plantillas/index.blade.php
git commit -m "feat: add Plantillas Index Livewire component with search, toggle active, actions"
```

---

## Task 9: Livewire Plantillas Save

**Files:**
- Create: `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php`
- Create: `resources/views/livewire/admin/ajustes/postventa/plantillas/save.blade.php`

- [ ] **Step 1: Generate the component**

```bash
php artisan make:livewire "Admin/Ajustes/Postventa/Plantillas/Save" --no-interaction
```

- [ ] **Step 2: Write the Save component**

Replace `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php`:

```php
<?php

namespace App\Livewire\Admin\Ajustes\Postventa\Plantillas;

use App\Models\PostventaPlantilla;
use App\Models\Sector;
use Livewire\Component;
use Livewire\WithFileUploads;

class Save extends Component
{
    use WithFileUploads;

    public bool    $openModal   = false;
    public ?int    $sector_id   = null;
    public string  $cuerpo      = '';
    public bool    $activo      = true;
    public         $archivo     = null;

    protected $listeners = ['openModalSavePlantilla' => 'open'];

    public function open(): void
    {
        $this->reset();
        $this->activo    = true;
        $this->openModal = true;
    }

    public function close(): void
    {
        $this->openModal = false;
        $this->reset();
        $this->resetErrorBag();
    }

    protected function rules(): array
    {
        return [
            'sector_id' => 'nullable|exists:sectores,id',
            'cuerpo'    => 'required|string|max:2000',
            'activo'    => 'boolean',
            'archivo'   => 'nullable|file|mimes:pdf,mp4,mov,avi|max:16384',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $archivoUrl  = null;
        $archivoTipo = null;

        if ($this->archivo) {
            $path       = $this->archivo->store('postventa', 'public');
            $archivoUrl = '/storage/' . $path;
            $extension  = strtolower($this->archivo->getClientOriginalExtension());
            $archivoTipo = $extension === 'pdf' ? 'pdf' : 'video';
        }

        PostventaPlantilla::create([
            'sector_id'   => $validated['sector_id'],
            'cuerpo'      => $validated['cuerpo'],
            'activo'      => $validated['activo'],
            'archivo_url' => $archivoUrl,
            'archivo_tipo'=> $archivoTipo,
        ]);

        $this->dispatch('notify-toast', icon: 'success', title: 'PLANTILLA CREADA', mensaje: 'La plantilla post-venta fue creada.');
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        $sectores = Sector::activos()->get();

        return view('livewire.admin.ajustes.postventa.plantillas.save', compact('sectores'));
    }
}
```

- [ ] **Step 3: Write the Save view**

Replace `resources/views/livewire/admin/ajustes/postventa/plantillas/save.blade.php`:

```blade
<div>
    <x-form.modal.card title="NUEVA PLANTILLA POST-VENTA" max-width="lg" wire:model.live="openModal" align="center">
        <form autocomplete="off">
            <div class="px-5 py-4 grid grid-cols-12 gap-4">

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">Sector</label>
                    <select wire:model.live="sector_id" class="form-select w-full">
                        <option value="">— Plantilla por defecto —</option>
                        @foreach ($sectores as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                        @endforeach
                    </select>
                    @error('sector_id')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">
                        Cuerpo del mensaje
                        <span class="text-xs font-normal text-gray-400 ml-1">Variables: {placa} {cliente} {fecha_instalacion} {fecha_cierre}</span>
                    </label>
                    <textarea wire:model.live="cuerpo" rows="5" class="form-textarea w-full"
                        placeholder="Escribe el mensaje..."></textarea>
                    @error('cuerpo')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">
                        Archivo adjunto <span class="text-xs font-normal text-gray-400">(PDF o video, máx. 16 MB)</span>
                    </label>
                    <input type="file" wire:model="archivo" class="form-input w-full" accept=".pdf,.mp4,.mov,.avi" />
                    <div wire:loading wire:target="archivo" class="text-xs text-gray-400 mt-1">Subiendo archivo...</div>
                    @error('archivo')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12 flex items-center gap-3">
                    <label class="block text-sm font-medium">Activo</label>
                    <input type="checkbox" wire:model.live="activo" class="form-checkbox" />
                </div>

            </div>
        </form>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="close" />
                <x-form.button primary label="Guardar" wire:click.prevent="save" spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
```

- [ ] **Step 4: Verify with php -l**

```bash
php -l app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php
```

Expected: `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Livewire/Admin/Ajustes/Postventa/Plantillas/Save.php
git add resources/views/livewire/admin/ajustes/postventa/plantillas/save.blade.php
git commit -m "feat: add Plantillas Save modal Livewire component"
```

---

## Task 10: Livewire Plantillas Edit

**Files:**
- Create: `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php`
- Create: `resources/views/livewire/admin/ajustes/postventa/plantillas/edit.blade.php`

- [ ] **Step 1: Generate the component**

```bash
php artisan make:livewire "Admin/Ajustes/Postventa/Plantillas/Edit" --no-interaction
```

- [ ] **Step 2: Write the Edit component**

Replace `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php`:

```php
<?php

namespace App\Livewire\Admin\Ajustes\Postventa\Plantillas;

use App\Models\PostventaPlantilla;
use App\Models\Sector;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public bool                  $openModal      = false;
    public ?PostventaPlantilla   $plantilla      = null;
    public ?int                  $sector_id      = null;
    public string                $cuerpo         = '';
    public bool                  $activo         = true;
    public                       $archivo        = null;
    public ?string               $archivoActual  = null;

    protected $listeners = ['openModalEditPlantilla' => 'open'];

    public function open(int $id): void
    {
        $plantilla             = PostventaPlantilla::findOrFail($id);
        $this->plantilla       = $plantilla;
        $this->sector_id       = $plantilla->sector_id;
        $this->cuerpo          = $plantilla->cuerpo;
        $this->activo          = $plantilla->activo;
        $this->archivoActual   = $plantilla->archivo_url;
        $this->archivo         = null;
        $this->openModal       = true;
        $this->resetErrorBag();
    }

    public function close(): void
    {
        $this->openModal = false;
        $this->reset();
        $this->resetErrorBag();
    }

    protected function rules(): array
    {
        return [
            'sector_id' => 'nullable|exists:sectores,id',
            'cuerpo'    => 'required|string|max:2000',
            'activo'    => 'boolean',
            'archivo'   => 'nullable|file|mimes:pdf,mp4,mov,avi|max:16384',
        ];
    }

    public function update(): void
    {
        $validated = $this->validate();

        $archivoUrl  = $this->plantilla->archivo_url;
        $archivoTipo = $this->plantilla->archivo_tipo;

        if ($this->archivo) {
            if ($archivoUrl) {
                Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $archivoUrl), '/'));
            }
            $path       = $this->archivo->store('postventa', 'public');
            $archivoUrl = '/storage/' . $path;
            $extension  = strtolower($this->archivo->getClientOriginalExtension());
            $archivoTipo = $extension === 'pdf' ? 'pdf' : 'video';
        }

        $this->plantilla->update([
            'sector_id'    => $validated['sector_id'],
            'cuerpo'       => $validated['cuerpo'],
            'activo'       => $validated['activo'],
            'archivo_url'  => $archivoUrl,
            'archivo_tipo' => $archivoTipo,
        ]);

        $this->dispatch('notify-toast', icon: 'success', title: 'PLANTILLA ACTUALIZADA', mensaje: 'La plantilla fue actualizada.');
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        $sectores = Sector::activos()->get();

        return view('livewire.admin.ajustes.postventa.plantillas.edit', compact('sectores'));
    }
}
```

- [ ] **Step 3: Write the Edit view**

Replace `resources/views/livewire/admin/ajustes/postventa/plantillas/edit.blade.php`:

```blade
<div>
    <x-form.modal.card title="EDITAR PLANTILLA POST-VENTA" max-width="lg" wire:model.live="openModal" align="center">
        <form autocomplete="off">
            <div class="px-5 py-4 grid grid-cols-12 gap-4">

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">Sector</label>
                    <select wire:model.live="sector_id" class="form-select w-full">
                        <option value="">— Plantilla por defecto —</option>
                        @foreach ($sectores as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                        @endforeach
                    </select>
                    @error('sector_id')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">
                        Cuerpo del mensaje
                        <span class="text-xs font-normal text-gray-400 ml-1">Variables: {placa} {cliente} {fecha_instalacion} {fecha_cierre}</span>
                    </label>
                    <textarea wire:model.live="cuerpo" rows="5" class="form-textarea w-full"
                        placeholder="Escribe el mensaje..."></textarea>
                    @error('cuerpo')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">
                        Archivo adjunto <span class="text-xs font-normal text-gray-400">(PDF o video, máx. 16 MB)</span>
                    </label>
                    @if ($archivoActual)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Archivo actual: <span class="font-mono">{{ basename($archivoActual) }}</span>
                            (sube uno nuevo para reemplazarlo)
                        </p>
                    @endif
                    <input type="file" wire:model="archivo" class="form-input w-full" accept=".pdf,.mp4,.mov,.avi" />
                    <div wire:loading wire:target="archivo" class="text-xs text-gray-400 mt-1">Subiendo archivo...</div>
                    @error('archivo')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12 flex items-center gap-3">
                    <label class="block text-sm font-medium">Activo</label>
                    <input type="checkbox" wire:model.live="activo" class="form-checkbox" />
                </div>

            </div>
        </form>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="close" />
                <x-form.button primary label="Actualizar" wire:click.prevent="update" spinner="update" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
```

- [ ] **Step 4: Verify with php -l**

```bash
php -l app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php
```

Expected: `No syntax errors detected`

- [ ] **Step 5: Commit**

```bash
git add app/Livewire/Admin/Ajustes/Postventa/Plantillas/Edit.php
git add resources/views/livewire/admin/ajustes/postventa/plantillas/edit.blade.php
git commit -m "feat: add Plantillas Edit modal Livewire component"
```

---

## Task 11: Livewire Plantillas Delete

**Files:**
- Create: `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Delete.php`
- Create: `resources/views/livewire/admin/ajustes/postventa/plantillas/delete.blade.php`

- [ ] **Step 1: Generate the component**

```bash
php artisan make:livewire "Admin/Ajustes/Postventa/Plantillas/Delete" --no-interaction
```

- [ ] **Step 2: Write the Delete component**

Replace `app/Livewire/Admin/Ajustes/Postventa/Plantillas/Delete.php`:

```php
<?php

namespace App\Livewire\Admin\Ajustes\Postventa\Plantillas;

use App\Models\PostventaPlantilla;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Delete extends Component
{
    public bool                $openModal = false;
    public ?PostventaPlantilla $plantilla = null;

    protected $listeners = ['openModalDeletePlantilla' => 'open'];

    public function open(int $id): void
    {
        $this->plantilla = PostventaPlantilla::findOrFail($id);
        $this->openModal = true;
    }

    public function close(): void
    {
        $this->openModal = false;
        $this->plantilla = null;
    }

    public function delete(): void
    {
        if ($this->plantilla->archivo_url) {
            Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $this->plantilla->archivo_url), '/'));
        }

        $this->plantilla->delete();

        $this->dispatch('notify-toast', icon: 'success', title: 'PLANTILLA ELIMINADA', mensaje: 'La plantilla fue eliminada.');
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        return view('livewire.admin.ajustes.postventa.plantillas.delete');
    }
}
```

- [ ] **Step 3: Write the Delete view**

Replace `resources/views/livewire/admin/ajustes/postventa/plantillas/delete.blade.php`:

```blade
<div>
    <x-form.modal.card title="ELIMINAR PLANTILLA" max-width="sm" wire:model.live="openModal" align="center">

        <div class="px-5 py-4 text-center">
            <svg class="w-12 h-12 text-rose-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            <p class="text-gray-700 dark:text-gray-200 font-medium">¿Estás seguro de eliminar esta plantilla?</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Sector: <strong>{{ $plantilla?->sector?->nombre ?? 'Por defecto' }}</strong>
            </p>
            @if ($plantilla?->archivo_url)
                <p class="text-xs text-gray-400 mt-1">Se eliminará también el archivo adjunto.</p>
            @endif
            <p class="text-sm text-rose-500 mt-2">Esta acción no se puede deshacer.</p>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cancelar" wire:click.prevent="close" />
                <x-form.button negative label="Sí, eliminar" wire:click.prevent="delete" spinner="delete" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
```

- [ ] **Step 4: Verify with php -l**

```bash
php -l app/Livewire/Admin/Ajustes/Postventa/Plantillas/Delete.php
```

Expected: `No syntax errors detected`

- [ ] **Step 5: Final commit**

```bash
git add app/Livewire/Admin/Ajustes/Postventa/Plantillas/Delete.php
git add resources/views/livewire/admin/ajustes/postventa/plantillas/delete.blade.php
git commit -m "feat: add Plantillas Delete modal Livewire component — post-venta messaging complete"
```

---

## Self-Review Checklist

- [x] **Spec §1a** — `es_postventa` boolean on devices → Task 1 + Task 2 (Device model)
- [x] **Spec §1b** — `postventa_plantillas` table → Task 1
- [x] **Spec §1c** — `PostventaPlantilla` model with EmpresaScope → Task 2
- [x] **Spec §2 (event)** — `WorkOrderCerrada` fired from `cerrar()` → Task 3
- [x] **Spec §2 (listener)** — `EnviarMensajePostventaListener` ShouldQueue, auto-discovered → Task 4
- [x] **Spec §2 (job cliente)** — `EnviarMensajeClienteJob` with gerente contacts + template + variable replacement → Task 4
- [x] **Spec §2 (daily)** — `EnviarResumenDiarioPostventaJob` scheduled at 08:00 in `bootstrap/app.php` → Task 5
- [x] **Spec §3a** — toggle `es_postventa` in Devices Index (deactivates others, activates selected) → Task 6
- [x] **Spec §3b** — CRUD plantillas under `/admin/ajustes/postventa` → Tasks 7–11
- [x] **Spec §4** — all error paths handled with `Log::warning` + graceful returns → Tasks 4 & 5
- [x] **Device empresa scoping** — uses `whereHas('user', empresa_id)` throughout
- [x] **WorkOrder::sector string parsing** — splits by comma, takes first name, looks up Sector by name
- [x] **Template fallback** — sector-specific → default (sector_id null) → log warning
- [x] **File cleanup on delete/update** — `Storage::disk('public')->delete()` in Edit and Delete components
