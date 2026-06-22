<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Vehículos</h1>
        </div>
        <div class="flex flex-wrap gap-2 justify-start sm:justify-end">
            @role('admin')
                <x-form.button wire:click="abrirSincronizarFlota" info icon="arrow-path" label="Sincronizar GPSWox" />
            @endrole

            @can('exportar.vehiculos-vehiculos')
                <x-form.button wire:click.prevent='exportVehiculos()' spinner="exportVehiculos" label="Exportar" positive sm
                    icon="arrow-down-tray" />
            @endcan

            @can('importar-vehiculos-vehiculos')
                <x-form.button wire:click="openModalImport()" label="Importar" info sm icon="arrow-up-tray" />
            @endcan

            @can('crear-vehiculos-vehiculos')
                <x-form.button wire:click="openModalSave()" dark icon="plus" label="Añadir Vehículo" />
            @endcan
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
        <div class="grid grid-cols-12 gap-3">

            <!-- Search -->
            <div class="col-span-12 sm:col-span-6 md:col-span-4">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Buscar</label>
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" type="search"
                        class="form-input w-full pl-9 text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 focus:border-violet-300 rounded-lg"
                        placeholder="Placa, IMEI, cliente, RUC, SIM..." />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 fill-current text-gray-400 dark:text-gray-500 ml-3" viewBox="0 0 16 16">
                            <path
                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path
                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cliente filter -->
            <div class="col-span-12 sm:col-span-6 md:col-span-4">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Cliente</label>
                <x-form.select wire:model.live="clientes_id" placeholder="Todos los clientes"
                    option-description="numero_documento" :async-data="route('api.clientes.index')" option-label="razon_social"
                    option-value="id" />
            </div>

            <!-- Marca filter -->
            <div class="col-span-6 sm:col-span-4 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Marca</label>
                <select wire:model.live="marca_filter"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300">
                    <option value="">Todas</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca }}">{{ $marca }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Estado filter -->
            <div class="col-span-6 sm:col-span-4 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</label>
                <select wire:model.live="estado_filter"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300">
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="2">Suspendidos</option>
                </select>
            </div>

            <!-- Sector filter -->
            <div class="col-span-6 sm:col-span-4 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sector</label>
                <select wire:model.live="sector_filter"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300">
                    <option value="">Todos</option>
                    @foreach ($sectores as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Plan filter -->
            <div class="col-span-6 sm:col-span-4 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Plan</label>
                <select wire:model.live="plan_filter"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300">
                    <option value="">Todos</option>
                    @foreach ($planes as $plan)
                        <option value="{{ $plan['id'] }}">{{ $plan['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- GPSWox filter -->
            <div class="col-span-6 sm:col-span-4 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Plataforma</label>
                <select wire:model.live="gpswox_filter"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300">
                    <option value="">Todos</option>
                    <option value="activo">Activo en plataforma</option>
                    <option value="inactivo">Inactivo en plataforma</option>
                </select>
            </div>

            <!-- Per page -->
            <div class="col-span-6 sm:col-span-4 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Por página</label>
                <select wire:model.live="perPage"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

        </div>

        <!-- Filter footer: date picker + clear + export -->
        <div
            class="flex flex-wrap items-center justify-between gap-2 mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-2">
                @if ($clientes_id || $marca_filter || $plan_filter || $sector_filter || $search || $estado_filter || $gpswox_filter)
                    <x-form.button wire:click="clearFilters" flat negative sm icon="x-mark" label="Limpiar filtros" />
                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $vehiculos->total() }} resultado(s)</span>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <!-- Date range dropdown -->
                <div class="relative" x-data="{ open: false, selected: 4 }">
                    <button
                        class="btn justify-between min-w-40 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:border-gray-300 text-gray-500 dark:text-gray-400 text-sm"
                        @click.prevent="open = !open" :aria-expanded="open">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                            </svg>
                            <span
                                x-text="$refs.options && $refs.options.children[selected] && $refs.options.children[selected].children[1] ? $refs.options.children[selected].children[1].innerHTML : 'Periodo'"></span>
                        </span>
                        <svg class="shrink-0 ml-1 fill-current text-gray-400" width="11" height="7">
                            <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                        </svg>
                    </button>
                    <div class="z-10 absolute top-full right-0 w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 py-1.5 rounded shadow-lg mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak>
                        <div class="font-medium text-sm text-gray-600 dark:text-gray-300" x-ref="options">
                            <button wire:click="filter(1)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                :class="selected === 0 && 'text-indigo-500'" @click="selected = 0;open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="selected !== 0 && 'invisible'" width="12" height="9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span>Hoy</span>
                            </button>
                            <button wire:click="filter(7)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                :class="selected === 1 && 'text-indigo-500'" @click="selected = 1;open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="selected !== 1 && 'invisible'" width="12" height="9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span>Últimos 7 días</span>
                            </button>
                            <button wire:click="filter(30)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                :class="selected === 2 && 'text-indigo-500'" @click="selected = 2;open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="selected !== 2 && 'invisible'" width="12" height="9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span>Último mes</span>
                            </button>
                            <button wire:click="filter(12)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                :class="selected === 3 && 'text-indigo-500'" @click="selected = 3;open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="selected !== 3 && 'invisible'" width="12" height="9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span>Últimos 12 meses</span>
                            </button>
                            <button wire:click="filter(0)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                                :class="selected === 4 && 'text-indigo-500'" @click="selected = 4;open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="selected !== 4 && 'invisible'" width="12" height="9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span>Todos</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 mb-8">
        <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                Vehículos
                <span class="text-gray-400 dark:text-gray-500 font-medium ml-1">{{ $vehiculos->total() }}</span>
            </h2>
        </header>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm dark:text-gray-300">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th class="px-3 pl-5 py-3 whitespace-nowrap text-left">Vehículo</th>
                        <th class="px-3 py-3 whitespace-nowrap text-left">Cliente</th>
                        <th class="px-3 py-3 whitespace-nowrap text-left">SIM / Línea</th>
                        <th class="px-3 py-3 whitespace-nowrap text-left">Dispositivo GPS</th>
                        <th class="px-3 py-3 whitespace-nowrap text-left">Plataforma</th>
                        <th class="px-3 py-3 whitespace-nowrap text-center">Suscripción</th>
                        @canany(['eliminar-vehiculos-vehiculos', 'editar-vehiculos-vehiculos'])
                            <th class="px-3 pr-5 py-3 whitespace-nowrap text-center">Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach ($vehiculos as $vehiculo)
                        <tr wire:key="vehi-{{ $vehiculo->id }}"
                            class="{{ $vehiculo->estado == 2 ? 'bg-orange-50/50 dark:bg-orange-900/10' : '' }} hover:bg-gray-50 dark:hover:bg-gray-900/20 transition-colors">

                            {{-- VEHÍCULO --}}
                            <td class="px-3 pl-5 py-3">
                                <div class="flex items-start gap-2">
                                    <div class="mt-0.5">
                                        @if ($vehiculo->estado == 2)
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/40">
                                                <svg class="w-4 h-4 text-orange-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M18.364 5.636a9 9 0 010 12.728M5.636 18.364a9 9 0 010-12.728M12 8v4m0 4h.01" />
                                                </svg>
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-sky-100 dark:bg-sky-900/40">
                                                <svg class="w-4 h-4 text-sky-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                    <path
                                                        d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7h4l2 4v4h-6V7z" />
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-sky-600 dark:text-sky-400 text-base leading-tight">
                                            {{ $vehiculo->placa }}
                                        </div>
                                        {{-- Marca + Modelo --}}
                                        <div class="text-xs font-medium text-gray-700 dark:text-gray-200 mt-0.5">
                                            {{ trim(($vehiculo->marca ?? '') . ' ' . ($vehiculo->modelo ?? '')) ?: '—' }}
                                        </div>
                                        {{-- Tipo · Año · Color --}}
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @if ($vehiculo->tipo)
                                                <span
                                                    class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                                    {{ $vehiculo->tipo }}
                                                </span>
                                            @endif
                                            @if ($vehiculo->year)
                                                <span
                                                    class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                                    {{ $vehiculo->year }}
                                                </span>
                                            @endif
                                            @if ($vehiculo->color)
                                                <span
                                                    class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                                    {{ $vehiculo->color }}
                                                </span>
                                            @endif
                                        </div>
                                        {{-- Sectores --}}
                                        @if ($vehiculo->sectores->isNotEmpty())
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach ($vehiculo->sectores as $sector)
                                                    <span
                                                        class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-300">
                                                        {{ $sector->nombre }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- CLIENTE --}}
                            <td class="px-3 py-3 max-w-44">
                                @if ($vehiculo->cliente)
                                    <div class="font-medium text-sky-600 dark:text-sky-400 text-sm leading-snug">
                                        {{ $vehiculo->cliente->razon_social }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-mono">
                                        {{ $vehiculo->cliente->numero_documento }}
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500 italic">Sin cliente</span>
                                @endif
                            </td>

                            {{-- SIM / LÍNEA --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                @if ($vehiculo->estado == 2)
                                    <div class="space-y-0.5">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-400">
                                            Suspendido
                                        </span>
                                        @if ($vehiculo->old_sim_card)
                                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                                Ant: {{ $vehiculo->old_sim_card }}
                                            </div>
                                        @endif
                                        @if ($vehiculo->old_numero)
                                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                                #{{ $vehiculo->old_numero }}
                                            </div>
                                        @endif
                                    </div>
                                @elseif ($vehiculo->sim_card)
                                    @if ($vehiculo->sim_card->linea)
                                        <div class="font-medium text-emerald-600 dark:text-emerald-400 text-sm">
                                            #{{ $vehiculo->sim_card->linea->numero }}
                                        </div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                            {{ $vehiculo->sim_card->linea->operador?->name ?? $vehiculo->sim_card->sim_card }}
                                        </div>
                                    @else
                                        <div class="text-sm text-amber-600 dark:text-amber-400 font-mono">
                                            {{ $vehiculo->sim_card->sim_card }}
                                        </div>
                                        <div class="text-xs text-gray-400">Sin línea asignada</div>
                                    @endif
                                @else
                                    <span class="text-xs text-red-400 dark:text-red-500">
                                        {{ $vehiculo->old_sim_card ? 'Ant: ' . $vehiculo->old_sim_card : 'Sin SIM' }}
                                    </span>
                                @endif
                            </td>

                            {{-- DISPOSITIVO GPS --}}
                            <td class="px-3 py-3">
                                @php $dp = $vehiculo->dispositivoPrincipal; @endphp
                                @if ($dp && $dp->dispositivo)
                                    <div class="font-medium text-gray-800 dark:text-gray-100 text-sm">
                                        {{ $dp->dispositivo->modelo->modelo ?? '—' }}
                                        <span class="ml-1 text-xs text-emerald-500 font-normal">Principal</span>
                                    </div>
                                    <div class="text-xs font-mono text-gray-400 dark:text-gray-500 mt-0.5">
                                        {{ $dp->imei ?? $dp->dispositivo->imei }}
                                    </div>
                                @elseif ($vehiculo->dispositivos->count() > 0)
                                    @php $d0 = $vehiculo->dispositivos->first(); @endphp
                                    <div class="font-medium text-gray-600 dark:text-gray-300 text-sm">
                                        {{ $d0->dispositivo->modelo->modelo ?? '—' }}
                                    </div>
                                    <div class="text-xs font-mono text-gray-400 dark:text-gray-500 mt-0.5">
                                        {{ $d0->imei }}
                                    </div>
                                @elseif ($vehiculo->dispositivo_imei ?? null)
                                    <div class="text-xs font-mono text-amber-500">
                                        {{ $vehiculo->dispositivo_imei }}
                                        <span class="font-sans text-gray-400">(ant.)</span>
                                    </div>
                                @else
                                    <span class="text-xs text-red-400 dark:text-red-500">Sin dispositivo</span>
                                @endif

                                {{-- Tooltip con todos los dispositivos --}}
                                @if ($vehiculo->dispositivos->count() > 0)
                                    <div class="relative mt-1" x-data="{ open: false }" @mouseenter="open = true"
                                        @mouseleave="open = false">
                                        <button
                                            class="text-[10px] text-sky-500 hover:text-sky-700 underline cursor-pointer"
                                            @click.prevent>
                                            Ver todos ({{ $vehiculo->dispositivos->count() }})
                                        </button>
                                        <div class="z-20 absolute bottom-full left-0 mb-1 min-w-64 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl p-2"
                                            x-show="open" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 translate-y-1"
                                            x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                                            <div
                                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1.5 uppercase">
                                                Dispositivos — {{ $vehiculo->placa }}
                                            </div>
                                            @foreach ($vehiculo->dispositivos as $vd)
                                                <div
                                                    class="flex items-center justify-between gap-2 py-1 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                                    <div>
                                                        <div
                                                            class="text-xs font-medium text-gray-700 dark:text-gray-200">
                                                            {{ $vd->dispositivo->modelo->modelo ?? 'Sin modelo' }}
                                                            @if ($vd->is_principal)
                                                                <span class="text-emerald-500">✓</span>
                                                            @endif
                                                        </div>
                                                        <div class="text-[10px] font-mono text-gray-400">
                                                            {{ $vd->imei }}</div>
                                                    </div>
                                                    @if ($vd->fecha_desinstalacion)
                                                        <span
                                                            class="text-[10px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded">
                                                            {{ $vd->fecha_desinstalacion->format('d/m/y') }}
                                                        </span>
                                                    @else
                                                        <span
                                                            class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded">Activo</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </td>

                            {{-- GPSWOX --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                @if ($vehiculo->gpswox_id)
                                    <div class="flex flex-col gap-1">
                                        @if ($vehiculo->gpswox_active)
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                Activo
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Inactivo
                                            </span>
                                        @endif
                                        <div class="text-[10px] text-gray-400 font-mono">#{{ $vehiculo->gpswox_id }}
                                        </div>
                                        @if ($vehiculo->gpswox_sincronizado_at)
                                            <div class="text-[10px] text-gray-400">
                                                {{ $vehiculo->gpswox_sincronizado_at->diffForHumans() }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-300 dark:text-gray-600">—</span>
                                @endif
                            </td>

                            {{-- SUSCRIPCIÓN --}}
                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                @php
                                    $subCancelada = $vehiculo->planSubscriptions
                                        ->whereNotNull('canceled_at')
                                        ->sortByDesc('canceled_at')
                                        ->first();
                                    $subActiva =
                                        $vehiculo->estado != 2
                                            ? $vehiculo->planSubscriptions
                                                ->whereNull('canceled_at')
                                                ->filter(fn($s) => \Carbon\Carbon::parse($s->ends_at)->isFuture())
                                                ->sortByDesc('ends_at')
                                                ->first()
                                            : null;
                                    $subVencida =
                                        !$subActiva && !$subCancelada && $vehiculo->planSubscriptions->isNotEmpty();
                                @endphp

                                @if ($vehiculo->estado == 2 && $subCancelada)
                                    <button wire:click="abrirModalSuscripcion({{ $vehiculo->id }})"
                                        title="Suscripción cancelada — vehículo suspendido"
                                        class="inline-flex flex-col items-center gap-0.5 group">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/40 group-hover:ring-2 group-hover:ring-orange-400 transition">
                                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 5.636a9 9 0 010 12.728M5.636 18.364a9 9 0 010-12.728M12 8v4m0 4h.01" />
                                            </svg>
                                        </span>
                                        <span
                                            class="text-xs font-medium text-orange-600 dark:text-orange-400">Cancelada</span>
                                    </button>
                                @elseif ($subActiva)
                                    @php
                                        $dias = (int) \Carbon\Carbon::now()
                                            ->startOfDay()
                                            ->diffInDays(
                                                \Carbon\Carbon::parse($subActiva->ends_at)->startOfDay(),
                                                false,
                                            );
                                        if ($dias < 0) {
                                            $diasTexto = abs($dias) . 'd atrasado';
                                            $ringColor = 'group-hover:ring-red-400';
                                            $bgColor = 'bg-red-100 dark:bg-red-900/40';
                                            $textColor = 'text-red-600 dark:text-red-400';
                                        } elseif ($dias === 0) {
                                            $diasTexto = 'Hoy';
                                            $ringColor = 'group-hover:ring-orange-400';
                                            $bgColor = 'bg-orange-100 dark:bg-orange-900/40';
                                            $textColor = 'text-orange-600 dark:text-orange-400';
                                        } elseif ($dias <= 7) {
                                            $diasTexto = $dias . 'd';
                                            $ringColor = 'group-hover:ring-amber-400';
                                            $bgColor = 'bg-amber-100 dark:bg-amber-900/40';
                                            $textColor = 'text-amber-600 dark:text-amber-400';
                                        } elseif ($dias <= 15) {
                                            $diasTexto = $dias . 'd';
                                            $ringColor = 'group-hover:ring-yellow-400';
                                            $bgColor = 'bg-yellow-100 dark:bg-yellow-900/40';
                                            $textColor = 'text-yellow-600 dark:text-yellow-400';
                                        } else {
                                            $diasTexto = $dias . 'd';
                                            $ringColor = 'group-hover:ring-emerald-400';
                                            $bgColor = 'bg-emerald-100 dark:bg-emerald-900/40';
                                            $textColor = 'text-emerald-600 dark:text-emerald-400';
                                        }
                                    @endphp
                                    <button wire:click="abrirModalSuscripcion({{ $vehiculo->id }})"
                                        title="Activa — vence {{ \Carbon\Carbon::parse($subActiva->ends_at)->format('d/m/Y') }}"
                                        class="inline-flex flex-col items-center gap-0.5 group">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $bgColor }} group-hover:ring-2 {{ $ringColor }} transition">
                                            <svg class="w-4 h-4 {{ $textColor }}" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <span
                                            class="text-xs font-medium {{ $textColor }}">{{ $diasTexto }}</span>
                                    </button>
                                @elseif ($subVencida)
                                    <button wire:click="abrirModalSuscripcion({{ $vehiculo->id }})"
                                        title="Suscripción vencida"
                                        class="inline-flex flex-col items-center gap-0.5 group">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/40 group-hover:ring-2 group-hover:ring-red-400 transition">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <span class="text-xs font-medium text-red-600 dark:text-red-400">Vencida</span>
                                    </button>
                                @else
                                    <button wire:click="abrirModalSuscripcion({{ $vehiculo->id }})"
                                        title="Sin suscripción"
                                        class="inline-flex flex-col items-center gap-0.5 group">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 group-hover:ring-2 group-hover:ring-gray-400 transition">
                                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        </span>
                                        <span class="text-xs font-medium text-gray-400 dark:text-gray-500">Sin
                                            plan</span>
                                    </button>
                                @endif

                                @if ($vehiculo->cobro)
                                    @php $cobroVeh = $vehiculo->cobro; @endphp
                                    <div class="mt-1.5 flex justify-center">
                                        <a href="{{ route('admin.cobros.index') }}"
                                            title="Cobro #{{ $cobroVeh->id }} — {{ $cobroVeh->periodo }}"
                                            @class([
                                                'inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold transition',
                                                'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-200' =>
                                                    $cobroVeh->es_activo,
                                                'bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 hover:bg-gray-200 line-through' => !$cobroVeh->es_activo,
                                            ])>
                                            {{ $cobroVeh->periodo ?? '—' }}
                                        </a>
                                    </div>
                                @endif
                            </td>

                            {{-- ACCIONES --}}
                            @canany(['eliminar-vehiculos-vehiculos', 'editar-vehiculos-vehiculos',
                                'show-vehiculos-vehiculos'])
                                <td class="px-3 pr-5 py-3 whitespace-nowrap text-center">
                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <button
                                            class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 rounded-full"
                                            :class="{ 'bg-gray-100 dark:bg-gray-700 text-gray-500': open }"
                                            @click.prevent="open = !open" :aria-expanded="open">
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                <circle cx="16" cy="16" r="2" />
                                                <circle cx="10" cy="16" r="2" />
                                                <circle cx="22" cy="16" r="2" />
                                            </svg>
                                        </button>
                                        <div class="origin-top-right z-10 absolute -translate-x-3/4 top-full left-0 min-w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 py-1.5 rounded shadow-lg mt-1"
                                            @click.outside="open = false" @keydown.escape.window="open = false"
                                            x-show="open" x-transition:enter="transition ease-out duration-100 transform"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-out duration-100"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            x-cloak>
                                            <ul>
                                                @can('show-vehiculos-vehiculos')
                                                    <li>
                                                        <a href="{{ route('admin.vehiculos.show', $vehiculo) }}"
                                                            class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group flex items-center px-4 py-2 text-sm">
                                                            <svg class="h-4 w-4 mr-3 text-gray-400 group-hover:text-violet-500"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            Ver
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('editar-vehiculos-vehiculos')
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            wire:click.prevent="openModalEdit({{ $vehiculo->id }})"
                                                            @click="open = false"
                                                            class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group flex items-center px-4 py-2 text-sm">
                                                            <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-blue-500"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                            Editar
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('eliminar-vehiculos-vehiculos')
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            wire:click.prevent="deleteVehiculo({{ $vehiculo->id }})"
                                                            @click="open = false"
                                                            class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group flex items-center px-4 py-2 text-sm">
                                                            <svg class="h-4 w-4 mr-3 text-gray-400 group-hover:text-red-500"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Eliminar
                                                        </a>
                                                    </li>
                                                @endcan
                                                @role('admin')
                                                    @if ($vehiculo->estado == 2)
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                wire:click.prevent="activarVehiculo({{ $vehiculo->id }})"
                                                                @click="open = false"
                                                                class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group flex items-center px-4 py-2 text-sm">
                                                                <svg class="h-4 w-4 mr-3 text-gray-400 group-hover:text-emerald-600"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Activar
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="javascript:void(0)"
                                                                wire:click.prevent="suspendVehiculo({{ $vehiculo->id }})"
                                                                @click="open = false"
                                                                class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group flex items-center px-4 py-2 text-sm">
                                                                <svg class="h-4 w-4 mr-3 text-gray-400 group-hover:text-rose-600"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M18.364 5.636a9 9 0 010 12.728M5.636 18.364a9 9 0 010-12.728M12 8v4m0 4h.01" />
                                                                </svg>
                                                                Suspender
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            wire:click.prevent="createMantenimiento({{ $vehiculo->id }})"
                                                            @click="open = false"
                                                            class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group flex items-center px-4 py-2 text-sm">
                                                            <svg class="h-4 w-4 mr-3 text-gray-400 group-hover:text-blue-700"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                            Mantenimiento
                                                        </a>
                                                    </li>
                                                @endrole
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            @endcanany

                        </tr>
                    @endforeach

                    @if ($vehiculos->count() < 1)
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                                No hay vehículos que coincidan con los filtros.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if ($vehiculos->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $vehiculos->links() }}
            </div>
        @endif
    </div>

    @role('admin')
        @livewire('admin.vehiculos.sincronizar-flota')
    @endrole

</div>
