<x-form.modal.card title="Nueva Orden de Trabajo" wire:model.live="modalSave" width="5xl">
    <div class="space-y-4">

        {{-- ── Tipo de Orden ──────────────────────────────────────────────── --}}
        <x-form.select label="Tipo de Orden *" wire:model.live="work_order_type_id" placeholder="Seleccionar tipo"
            :options="$tipos" option-label="nombre" option-value="id" />

        {{-- ── Toggle: Individual vs Proyecto ───────────────────────────── --}}
        <div class="flex items-center gap-4 py-1">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de asignación:</span>
            <div class="flex items-center gap-1 rounded-lg bg-gray-100 dark:bg-gray-700 p-1">
                <button type="button" wire:click="$set('esProyecto', false)"
                    class="px-3 py-1.5 text-xs font-medium rounded-md transition
                        {{ !$esProyecto ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                    <svg class="inline w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Individual
                </button>
                <button type="button" wire:click="$set('esProyecto', true)"
                    class="px-3 py-1.5 text-xs font-medium rounded-md transition
                        {{ $esProyecto ? 'bg-indigo-600 text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                    <svg class="inline w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Proyecto (múltiples vehículos)
                </button>
            </div>
        </div>

        {{-- ── MODO PROYECTO ──────────────────────────────────────────────── --}}
        @if ($esProyecto)
            <div
                class="rounded-lg border border-indigo-200 bg-indigo-50 dark:border-indigo-600/30 dark:bg-indigo-950/20 p-4 space-y-4">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">Configuración del
                        proyecto</span>
                </div>

                <x-form.input wire:model="tituloProyecto" label="Título del proyecto *"
                    placeholder="Ej: MANTENIMIENTO EQUIPOS FMC920 — SÁBADO 24/05" class="uppercase" />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tipo de trabajo por defecto
                        </label>
                        <select wire:model="itemsTipoTrabajo"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-white px-3 py-2">
                            <option value="mantenimiento">Mantenimiento</option>
                            <option value="instalacion">Instalación</option>
                            <option value="cambio_chip">Cambio de chip</option>
                            <option value="retiro">Retiro de equipo</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Las líneas con <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">- cambio de
                                chip</code> se detectan automáticamente.
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Lista de placas
                        <span class="text-xs text-gray-400 font-normal ml-1">(una por línea, acepta notas: <code
                                class="bg-gray-100 dark:bg-gray-700 px-1 rounded">ARS-173 - cambio de
                                chip</code>)</span>
                    </label>
                    <textarea wire:model="placasTexto" rows="10"
                        placeholder="M8G-926&#10;CME-065&#10;M8R-730&#10;M8G-803 - cambio de chip&#10;M7O-825"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-mono text-gray-900 dark:text-white px-3 py-2 resize-y"></textarea>
                    @if (trim($placasTexto))
                        @php $numLineas = count(array_filter(preg_split('/[\r\n]+/', trim($placasTexto)))); @endphp
                        <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1">{{ $numLineas }}
                            {{ $numLineas === 1 ? 'unidad' : 'unidades' }} a registrar</p>
                    @endif
                </div>

                <p class="text-xs text-gray-400 dark:text-gray-500">
                    💡 Puedes dejar la lista vacía y el técnico agregará las unidades desde la orden.
                </p>
            </div>
        @else
            {{-- ── MODO INDIVIDUAL: Vehículo y Cliente ───────────────────── --}}
            @if ($costoEstimado !== null)
                <div class="flex items-center gap-2 -mt-2">
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $costoPersonalizado ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }}">
                        @if ($costoPersonalizado)
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Costo del técnico:
                        @else
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19V7a2 2 0 012-2h8l4 4v10a2 2 0 01-2 2H6a2 2 0 01-2-2z" />
                            </svg>
                            Costo base:
                        @endif
                        <span class="font-bold">S/ {{ number_format($costoEstimado, 2) }}</span>
                    </span>
                    @if ($costoPersonalizado)
                        <span class="text-xs text-gray-400 dark:text-gray-500">Precio personalizado para este
                            técnico</span>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- ── Vehículo ─────────────────────────────────────────────── --}}
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Vehículo <span
                                class="text-red-500">*</span></span>
                        <x-form.button flat xs icon="plus" wire:click="addVehiculo('')">
                            Nuevo vehículo
                        </x-form.button>
                    </div>
                    <x-form.select autocomplete="off" wire:model.live="vehiculo_id" placeholder="Buscar por placa"
                        :async-data="route('api.vehiculos.index')" option-label="placa" option-value="id"
                        option-description="option_description" />
                </div>

                {{-- ── Cliente (autocompleta) ──────────────────────────────── --}}
                <x-form.input label="Cliente *" wire:model="cliente_nombre" disabled />
            </div>
        @endif{{-- /esProyecto --}}

        {{-- ── Sector de operación ─────────────────────────────────────────── --}}
        @if ($tipoMuestraSector || $tipoMuestraPlan)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if ($tipoMuestraSector)
                    <x-form.select multiselect label="Sector" wire:model.live="sector"
                        placeholder="Seleccionar sectores" :options="$sectores" option-label="label"
                        option-value="value" />
                @endif

                @if ($tipoMuestraSector && in_array('OTROS', $sector))
                    <x-form.input label="Especificar sector" wire:model="sector_especifico"
                        placeholder="Describir sector..." />
                @elseif ($tipoMuestraPlan)
                    <x-form.select label="Plan de servicio" wire:model="plan_id" placeholder="Seleccionar plan"
                        :options="$planes" option-label="name" option-value="id" :clearable="true" />
                @endif
            </div>

            @if ($tipoMuestraSector && in_array('OTROS', $sector) && $tipoMuestraPlan)
                <x-form.select label="Plan de servicio" wire:model="plan_id" placeholder="Seleccionar plan"
                    :options="$planes" option-label="name" option-value="id" :clearable="true" />
            @endif
        @endif

        {{-- ── Operador SIM (independiente) ──────────────────────────────────── --}}
        @if ($tipoRequiereOperadorSim)
            <x-form.select label="Operador SIM *" wire:model="operador_sim_orden" placeholder="Seleccionar operador"
                :options="$operadores" option-label="name" option-value="name" :clearable="true" />
        @endif

        {{-- ── Modelo de dispositivo (independiente) ──────────────────────────── --}}
        @if ($tipoRequiereModeloDispositivo)
            <x-form.select label="Modelo del dispositivo *" wire:model="modelo_dispositivo_id"
                placeholder="Seleccionar modelo" :options="$modelosDispositivo" option-label="name" option-value="id"
                :clearable="true"
                hint="{{ $tipoEquipo === 'sensor_adas' ? 'Sensor ADAS' : ($tipoEquipo === 'velocimetro' ? 'Velocímetro' : 'Dispositivo GPS') }}" />
        @endif


        {{-- ── Técnico — filtrable por ciudad ────────────────────────────── --}}
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 space-y-3">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Asignación de
                Técnico</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <x-form.select label="Filtrar por ciudad" wire:model.live="ciudad_filter"
                    placeholder="Todas las ciudades" option-label="nombre" option-value="id" :options="$ciudades"
                    :clearable="false" />

                <x-form.select label="Técnico Asignado *" wire:model.live="tecnico_id"
                    placeholder="Seleccionar técnico" :options="$tecnicos" option-label="name" option-value="id" />
            </div>
        </div>

        {{-- ── Fecha Programada + Dirección ──────────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-form.datetime.picker label="Fecha Programada *" wire:model.live="fecha_programada"
                parse-format="YYYY-MM-DD HH:mm" display-format="DD-MM-YYYY HH:mm" :clearable="false"
                :interval="30" />

            <x-form.input label="Dirección del servicio" wire:model="direccion"
                placeholder="Ej: Av. Los Álamos 456, Surco" />
        </div>

        {{-- ── Vincular Mantenimiento Programado ──────────────────────────── --}}
        @if ($tipoRequiereMantenimiento)
            <div
                class="rounded-lg border border-amber-200 bg-amber-50 p-3 dark:border-amber-600/30 dark:bg-amber-950/20">
                <div class="mb-2 flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-amber-500 dark:text-amber-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-semibold text-amber-700 dark:text-amber-400">Mantenimiento
                        Programado</span>
                </div>

                @if (!$vehiculo_id)
                    <p class="text-xs text-amber-600 dark:text-amber-400/80">Selecciona un vehículo para ver las
                        notificaciones de mantenimiento pendientes.</p>
                @elseif ($mantenimientosPendientes->isEmpty())
                    <p class="text-xs text-amber-600 dark:text-amber-400/80">No hay mantenimientos programados
                        pendientes para este vehículo.</p>
                @else
                    <x-form.select label="Vincular con Notificación de Mantenimiento" wire:model="mantenimiento_id"
                        placeholder="Seleccionar mantenimiento programado (opcional)" :options="$mantenimientosPendientes"
                        option-label="label" option-value="id" :clearable="true" />
                    <p class="mt-1 text-xs text-amber-600 dark:text-amber-400/80">
                        Al finalizar la orden, el mantenimiento vinculado se marcará como
                        <strong class="font-semibold text-amber-700 dark:text-amber-300">completado</strong>.
                    </p>
                @endif
            </div>
        @endif

        {{-- ── Accesorios ─────────────────────────────────────────────────── --}}
        @if ($tipoMuestraAccesorios)
            <div
                class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 @error('accesorios') border-red-400 dark:border-red-500 @enderror">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">
                    Accesorios a
                    instalar</p>
                <div class="flex flex-wrap gap-4">
                    @foreach ($accesoriosDisponibles as $value => $label)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="accesorios" value="{{ $value }}"
                                class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" />
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('accesorios')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- ── Alertas GPS / ADAS ───────────────────────────────────────── --}}
        @if ($tipoMuestraAlertas)
            <div
                class="rounded-lg border border-blue-200 dark:border-blue-700/40 p-3 @error('alertas') border-red-400 dark:border-red-500 @enderror">
                <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wide mb-3">
                    🔔 {{ $tipoEquipo === 'sensor_adas' ? 'Alertas ADAS a configurar' : 'Alertas GPS a configurar' }}
                    @if ($tipoRequiereAlertas)
                        <span class="text-red-500 ml-1">*</span>
                    @endif
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-2">
                    @foreach ($alertasDisponibles as $value => $label)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="alertas" value="{{ $value }}"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('alertas')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- ── Observaciones ───────────────────────────────────────────────── --}}
        <x-form.textarea label="Consideraciones / Observaciones" wire:model="observaciones_inicial"
            placeholder="Instrucciones especiales, notas técnicas..." rows="3" />

        {{-- ── Ubicación del servicio ──────────────────────────────────────── --}}
        <div x-data="{
            open: false,
            lat: $wire.entangle('ubicacion_lat'),
            lng: $wire.entangle('ubicacion_lng'),
            direccion: $wire.entangle('ubicacion_direccion'),
            tempLat: null,
            tempLng: null,
            tempDireccion: '',
            searchQuery: '',
            map: null,
            marker: null,
            async openModal() {
                this.tempLat = this.lat;
                this.tempLng = this.lng;
                this.tempDireccion = this.direccion;
                this.open = true;
                this.$nextTick(() => this.initMap());
            },
            async initMap() {
                if (typeof L === 'undefined') {
                    await new Promise((resolve, reject) => {
                        if (!document.getElementById('leaflet-css')) {
                            const link = document.createElement('link');
                            link.id = 'leaflet-css';
                            link.rel = 'stylesheet';
                            link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                            document.head.appendChild(link);
                        }
                        if (!document.getElementById('leaflet-js')) {
                            const script = document.createElement('script');
                            script.id = 'leaflet-js';
                            script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                            script.onload = resolve;
                            script.onerror = reject;
                            document.head.appendChild(script);
                        } else {
                            resolve();
                        }
                    });
                }
                if (this.map) {
                    this.map.remove();
                    this.map = null;
                }
                const centerLat = this.tempLat ?? -12.0464;
                const centerLng = this.tempLng ?? -77.0428;
                this.map = L.map('create-map-container').setView([centerLat, centerLng], this.tempLat ? 15 : 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(this.map);
                if (this.tempLat && this.tempLng) {
                    this.marker = L.marker([this.tempLat, this.tempLng], { draggable: true }).addTo(this.map);
                    this.marker.on('dragend', (e) => {
                        const pos = e.target.getLatLng();
                        this.tempLat = pos.lat;
                        this.tempLng = pos.lng;
                        this.reverseGeocode(pos.lat, pos.lng);
                    });
                }
                this.map.on('click', (e) => {
                    this.tempLat = e.latlng.lat;
                    this.tempLng = e.latlng.lng;
                    if (this.marker) { this.marker.setLatLng(e.latlng); } else {
                        this.marker = L.marker(e.latlng, { draggable: true }).addTo(this.map);
                        this.marker.on('dragend', (ev) => {
                            const p = ev.target.getLatLng();
                            this.tempLat = p.lat;
                            this.tempLng = p.lng;
                            this.reverseGeocode(p.lat, p.lng);
                        });
                    }
                    this.reverseGeocode(e.latlng.lat, e.latlng.lng);
                });
            },
            reverseGeocode(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=es`)
                    .then(r => r.json()).then(d => { this.tempDireccion = d.display_name ?? ''; })
                    .catch(() => {});
            },
            async searchAddress() {
                if (!this.searchQuery.trim()) return;
                const r = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&limit=1&accept-language=es`);
                const data = await r.json();
                if (data.length > 0) {
                    const { lat, lon, display_name } = data[0];
                    this.tempLat = parseFloat(lat);
                    this.tempLng = parseFloat(lon);
                    this.tempDireccion = display_name;
                    this.map.setView([lat, lon], 16);
                    if (this.marker) { this.marker.setLatLng([lat, lon]); } else {
                        this.marker = L.marker([lat, lon], { draggable: true }).addTo(this.map);
                        this.marker.on('dragend', (e) => {
                            const p = e.target.getLatLng();
                            this.tempLat = p.lat;
                            this.tempLng = p.lng;
                            this.reverseGeocode(p.lat, p.lng);
                        });
                    }
                }
            },
            guardar() {
                if (this.tempLat && this.tempLng) {
                    $wire.setUbicacion(this.tempLat, this.tempLng, this.tempDireccion);
                }
                this.open = false;
            },
            limpiar() { $wire.limpiarUbicacion(); }
        }" class="rounded-lg border border-gray-200 dark:border-gray-700 p-3 space-y-2">

            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Ubicación del
                servicio</p>

            {{-- Mostrar ubicación seleccionada --}}
            @if ($ubicacion_lat)
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-start gap-2 min-w-0">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-2.007 3.96-5.07 3.96-8.827a8.25 8.25 0 00-16.5 0c0 3.756 2.017 6.82 3.96 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="min-w-0">
                            @if ($ubicacion_direccion)
                                <p class="text-sm text-gray-700 dark:text-gray-200 truncate">
                                    {{ $ubicacion_direccion }}
                                </p>
                            @endif
                            <p class="text-xs font-mono text-gray-400 dark:text-gray-500">
                                {{ number_format($ubicacion_lat, 6) }}, {{ number_format($ubicacion_lng, 6) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-1 shrink-0">
                        <x-form.button flat xs label="Editar" x-on:click="openModal()" />
                        <x-form.button flat xs label="Quitar" x-on:click="limpiar()" />
                    </div>
                </div>
            @else
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-400 dark:text-gray-500 italic">Sin ubicación asignada</p>
                    <x-form.button flat xs label="Seleccionar en mapa" x-on:click="openModal()">
                        <x-slot name="prepend">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </x-slot>
                    </x-form.button>
                </div>
            @endif

            {{-- Modal del mapa --}}
            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background: rgba(0,0,0,0.5);" x-transition>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-3xl flex flex-col"
                    style="max-height: 90vh;">
                    <div
                        class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Seleccionar ubicación del
                            servicio</h3>
                        <button x-on:click="open = false"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="px-5 py-3 border-b border-gray-200 dark:border-gray-700 flex gap-2">
                        <input x-model="searchQuery" @keyup.enter="searchAddress()" type="text"
                            placeholder="Buscar dirección..."
                            class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <x-form.button flat sm label="Buscar" x-on:click="searchAddress()" />
                    </div>
                    <div id="create-map-container" class="flex-1" style="min-height: 380px;"></div>
                    <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-700 space-y-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <span x-show="tempLat && tempLng"
                                x-text="`${parseFloat(tempLat).toFixed(6)}, ${parseFloat(tempLng).toFixed(6)}`"></span>
                            <span x-show="!tempLat || !tempLng">Haz clic en el mapa para seleccionar</span>
                        </p>
                        <p x-show="tempDireccion" x-text="tempDireccion"
                            class="text-xs text-gray-600 dark:text-gray-300 truncate"></p>
                    </div>
                    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                        <x-form.button flat label="Cancelar" x-on:click="open = false" />
                        <x-form.button primary label="Guardar ubicación" x-on:click="guardar()" :disabled="false" />
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Contacto ────────────────────────────────────────────────────── --}}
        @if ($cliente_id && count($contactos) > 0)
            <x-form.select wire:key="contacto-select-{{ $vehiculo_id }}" label="Contacto encargado de la orden *"
                wire:model="contacto_id" placeholder="Seleccionar contacto" :options="$contactos" option-label="label"
                option-value="id" :clearable="true" />
        @elseif ($cliente_id)
            <div
                class="rounded border border-gray-200 dark:border-gray-700 px-3 py-2 text-xs text-gray-400 dark:text-gray-500 italic">
                Este cliente no tiene contactos registrados.
            </div>
        @else
            <div
                class="rounded border border-gray-200 dark:border-gray-700 px-3 py-2 text-xs text-gray-400 dark:text-gray-500 italic">
                Selecciona un vehículo para ver los contactos del cliente.
            </div>
        @endif

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-form.button flat label="Cancelar" wire:click="closeModal" />
            <x-form.button primary label="Crear Orden" wire:click="save" spinner="save" />
        </div>
    </x-slot>

</x-form.modal.card>
