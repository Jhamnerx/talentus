# Cliente 360° · SP#1 Dashboard Base — Design Spec

## Contexto

El usuario pidió un módulo "Calificación 360° del Cliente" completo: dashboard ejecutivo, Customer Health Score (CHS) con 7 factores ponderados, evaluaciones por área, comentarios/reseñas, timeline, panel gerencial, alertas automáticas y motor de recomendaciones. Es un módulo CRM Enterprise completo — demasiado grande para un solo spec/plan.

Se decidió descomponer en 4 sub-proyectos secuenciales:

1. **SP#1 (este spec)**: Cliente 360° — dashboard agregador de página completa, solo lectura, usando exclusivamente datos que YA existen en el sistema. Sin scoring, sin evaluaciones nuevas, sin comentarios nuevos.
2. **SP#2**: Evaluaciones por área + Comentarios/reseñas (tablas y UI nuevas).
3. **SP#3**: Customer Health Score — motor de cálculo de los 7 factores, tabla de historial mensual, indicador visual en el dashboard de SP#1.
4. **SP#4**: Panel gerencial + Alertas automáticas + Recomendaciones basadas en reglas.

Este spec cubre **solo SP#1**.

## Mapa de relaciones relevante (investigación previa)

```
Clientes (app/Models/Clientes.php)
├─ Vehiculos        hasMany (clientes_id) ✓ ya existe
├─ Contratos        hasMany (clientes_id) ✓ ya existe
├─ Certificados      ⚠️ relación rota (FK inexistente 'certificados_id') — se corrige en este SP
├─ Actas             ⚠️ sin relación directa — indirecta vía Vehiculo — se agrega en este SP
├─ CertVelocimetros  ⚠️ sin relación directa — indirecta vía Vehiculo — se agrega en este SP
├─ Ventas/Recibos/Cobros   hasMany ✓ ya existen (naming inconsistente entre modelos, ver nota)
├─ user_id (ejecutivo)     columna existe en BD, SIN relación Eloquent — fuera de alcance de este SP (confirmado con el usuario, "por ahora no tiene uso")
└─ Activitylog        Spatie Activitylog ya cubre Clientes y entidades relacionadas — reutilizable tal cual para el timeline

Vehiculos (app/Models/Vehiculos.php)
├─ certificados(), cert_velocimetros(), actas(), contratos()   ya existen, correctos
├─ gpswox_id, gpswox_active, gpswox_sincronizado_at            columnas ya existentes
└─ dispositivoPrincipal(), dispositivosAsignados()             ya existen
```

**Nota de naming**: `Ventas::cliente()`, `Recibos::cliente()` (singular) vs `Presupuestos::clientes()`, `Cobros::clientes()` (plural) — al construir las queries del resumen comercial, usar el nombre de relación correcto por modelo (no asumir un patrón único).

## Decisiones confirmadas con el usuario

- **Ubicación**: página completa nueva (`GET clientes/{cliente}/360`), NO dentro del modal de edición existente (que es compacto y no alcanza para un dashboard). Acceso vía un botón/ícono "360°" en cada fila del listado `ClientesIndex` existente.
- **Permiso**: nuevo `ver-cliente-360` (no se reutiliza ninguno existente), agregado a `PermisosSeeder.php` siguiendo el patrón de los demás permisos de `clientes`.
- **GPSWox en vivo**: se consulta la API externa vía un `GpswoxService` nuevo, con resultado cacheado 60 segundos por cliente (`Cache::remember`).
- **GPSWox — filtros sin tocar el paquete vendor**: `jhamnerx/gpswox-api`'s `Device::getDevicesLatest()` no acepta filtros. En vez de modificar el paquete, el `GpswoxService` llama directamente a `Wox::request('GET', 'api/get_devices_latest', ['query' => ['filters' => ['id' => $gpswoxIds]]])` (método público del cliente base), filtrando solo los dispositivos del cliente actual.
- **Ejecutivo asignado**: se muestra como dato de solo lectura desde `clientes.user_id` (join/lookup directo), SIN agregar una relación Eloquent `usuario()`/`ejecutivo()` — confirmado fuera de alcance.

## Arquitectura

```
[ClientesIndex] --click "360°"--> GET clientes/{cliente}/360
        |
        v
[Client360Dashboard] (Livewire, página completa, permission:ver-cliente-360)
        |
        ├─ Header ejecutivo: datos directos de $cliente + lookup de user_id
        ├─ Panel vehículos+GPS: $cliente->vehiculos, estado GPS vía GpswoxService (cache 60s)
        ├─ Panel documentos: $cliente->certificados / ->actas / ->certVelocimetros / ->contratos
        ├─ Resumen comercial: agregados de Ventas/Recibos (facturación puntual) + Cobros (suscripción/cobranza recurrente por vehículo, mostrado por separado, no sumado junto a Ventas/Recibos)
        └─ Timeline: Spatie Activitylog filtrado por subject_type/subject_id del cliente y relacionados
```

`GpswoxService::getLatestStatusForDevices(array $gpswoxIds): array` — internamente: `Cache::remember("gpswox.latest.{$clienteId}", 60, fn() => $wox->request('GET', 'api/get_devices_latest', ['query' => ['filters[id]' => implode(',', $gpswoxIds)]]))`. Si la llamada falla (timeout, error HTTP, credenciales), se captura la excepción, se loguea con `Log::warning`, y se retorna un array vacío — el panel de vehículos entonces muestra "No disponible" en la columna de estado GPS sin romper el resto de la página.

## Componentes a crear/modificar

**Permisos**

- Modify `database/seeders/PermisosSeeder.php` — agregar `'ver-cliente-360'`.

**Modelo**

- Modify `app/Models/Clientes.php` — agregar `certificados()`, `actas()`, `certVelocimetros()` como `hasManyThrough` vía `Vehiculos` (corrige el bug de la relación rota existente).

**Service GPSWox**

- Create `app/Services/Gpswox/GpswoxService.php` — instancia `Wox` con `config('services.gpswox.base_uri')`/`api_hash` (mismo patrón que `SincronizarVehiculosGpswox`), expone `getLatestStatusForDevices(array $gpswoxIds): array`, maneja caché y errores como se describió arriba.

**Ruta**

- Modify `routes/web.php` — `Route::get('clientes/{cliente}/360', Client360Dashboard::class)->name('admin.clientes.show360')->middleware('permission:ver-cliente-360')`.

**Livewire — componente principal**

- Create `app/Livewire/Admin/Clientes/Client360Dashboard.php` + vista — orquesta la carga del cliente con eager loading (`vehiculos`, `contratos`, etc.) y delega a sub-vistas/secciones blade para cada panel (header, vehículos, documentos, comercial, timeline). Dado el tamaño, los paneles se implementan como **secciones dentro del mismo blade** (no sub-componentes Livewire separados) para evitar la complejidad de inter-comunicación entre componentes en este SP — si en SP#2/SP#3 algún panel necesita su propio estado reactivo (ej. agregar comentarios), se extrae a su propio componente Livewire en ese momento.

**Listado de clientes**

- Modify `resources/views/livewire/admin/clientes/clientes-index.blade.php` — agregar el botón/ícono "360°" en la fila de acciones, condicionado a `@can('ver-cliente-360')`.

## Manejo de errores

- GPSWox no responde: panel de vehículos se degrada (estado GPS = "No disponible"), resto de la página funciona normal.
- Cliente sin vehículos/documentos/ventas: cada panel muestra su propio estado vacío, no es un error.
- Sin permiso `ver-cliente-360`: 403 (middleware de ruta).
- Cliente inexistente o de otra empresa: 404 (route-model binding + `EmpresaScope` ya aplicado).

## Testing

Sin `php artisan test` (restricción del proyecto). Verificación por archivo: `php -l` en cada archivo PHP nuevo/modificado.

## Fuera de alcance (este SP)

- Customer Health Score / scoring de ningún tipo (SP#3).
- Evaluaciones por área, comentarios/reseñas (SP#2).
- Panel gerencial, ranking de clientes, alertas automáticas, recomendaciones (SP#4).
- Relación Eloquent `Clientes::usuario()`/`ejecutivo()` (confirmado sin uso por ahora).
- Posición/velocidad GPS en tiempo real más allá de lo que devuelve `get_devices_latest` (sin mapa interactivo, sin tracking en vivo).
