<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Dispositivos</h1>
        </div>

        <div class="flex flex-wrap gap-2 justify-start sm:justify-end">
            @can('exportar-dispositivo')
                <a href="{{ route('admin.export.dispositivos') }}">
                    <x-form.button positive sm icon="arrow-down-tray" label="Exportar" />
                </a>
            @endcan

            @can('importar-dispositivo')
                <x-form.button wire:click="OpenModalImport()" info sm icon="arrow-up-tray" label="Importar" />
            @endcan

            <x-form.button
                wire:click="consultaFota()"
                wire:loading.attr="disabled"
                wire:target="consultaFota"
                sky sm
                icon="arrow-path"
                label="Consultar Fota"
                spinner="consultaFota"
            />

            <x-form.button
                wire:click="consultarDispositivosNoRegistrados()"
                wire:loading.attr="disabled"
                wire:target="consultarDispositivosNoRegistrados"
                purple sm
                icon="clipboard-document-check"
                label="No Registrados"
                spinner="consultarDispositivosNoRegistrados"
            />

            @can('ver.modelos-dispositivo')
                <a href="{{ route('admin.almacen.modelos-dispositivos') }}">
                    <x-form.button dark sm icon="squares-2x2" label="Ver Modelos GPS" />
                </a>
            @endcan

            @can('crear-dispositivo')
                <x-form.button wire:click="openModalCreate" primary sm icon="plus" label="Añadir Dispositivo" />
            @endcan
        </div>
    </div>

    <!-- Filters bar -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
        <div class="grid grid-cols-12 gap-3">

            <!-- Search -->
            <div class="col-span-12 sm:col-span-6 md:col-span-4">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Buscar</label>
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" type="search"
                        class="form-input w-full pl-9 text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 focus:border-violet-300 dark:focus:border-violet-500 rounded-lg"
                        placeholder="IMEI, placa, marca, modelo..." />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 fill-current text-gray-400 dark:text-gray-500 ml-3" viewBox="0 0 16 16">
                            <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Modelo filter -->
            <div class="col-span-12 sm:col-span-6 md:col-span-3">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Modelo</label>
                <select wire:model.live="modelo_filter"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300 dark:focus:border-violet-500">
                    <option value="">Todos los modelos</option>
                    @foreach ($modelos as $modelo)
                        <option value="{{ $modelo->id }}">{{ $modelo->marca }} {{ $modelo->modelo }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Estado filter -->
            <div class="col-span-6 sm:col-span-4 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</label>
                <select wire:model.live="estado_filter"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300 dark:focus:border-violet-500">
                    <option value="">Todos</option>
                    <option value="VENDIDO">Vendido</option>
                    <option value="STOCK">Stock</option>
                </select>
            </div>

            <!-- Asignado filter -->
            <div class="col-span-6 sm:col-span-4 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Asignación</label>
                <select wire:model.live="asignado_filter"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300 dark:focus:border-violet-500">
                    <option value="">Todos</option>
                    <option value="asignado">Asignados</option>
                    <option value="disponible">Disponibles</option>
                </select>
            </div>

            <!-- Per page + clear -->
            <div class="col-span-12 sm:col-span-4 md:col-span-1 flex flex-col justify-between">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Por página</label>
                <select wire:model.live="perPage"
                    class="form-select w-full text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-lg focus:border-violet-300 dark:focus:border-violet-500">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

        </div>

        @if ($search || $modelo_filter || $estado_filter || $asignado_filter)
            <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                <x-form.button wire:click="limpiarFiltros" flat negative sm icon="x-mark" label="Limpiar filtros" />
                <span class="text-xs text-gray-400 dark:text-gray-500">
                    Mostrando {{ $dispositivos->total() }} resultado(s)
                </span>
            </div>
        @endif
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
        <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                Dispositivos
                <span class="text-gray-400 dark:text-gray-500 font-medium ml-1">{{ $dispositivos->total() }}</span>
            </h2>
        </header>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm">
                <thead class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th class="px-3 pl-5 py-3 whitespace-nowrap text-left">IMEI</th>
                        <th class="px-3 py-3 whitespace-nowrap text-left">Modelo / Marca</th>
                        <th class="px-3 py-3 whitespace-nowrap text-left">Estado</th>
                        <th class="px-3 py-3 whitespace-nowrap text-left">Fota</th>
                        <th class="px-3 py-3 text-left">Vehículo asignado</th>
                        <th class="px-3 py-3 whitespace-nowrap text-left">Registro</th>
                        <th class="px-3 pr-5 py-3 whitespace-nowrap text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($dispositivos as $dispositivo)
                        @php $veh = $dispositivo->vehiculos->first(); @endphp
                        <tr wire:key="device-{{ $dispositivo->id }}"
                            class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition-colors">

                            {{-- IMEI --}}
                            <td class="px-3 pl-5 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 shrink-0 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        @if ($dispositivo->modelo->image)
                                            <img src="{{ Storage::url($dispositivo->modelo->image->url) }}.webp"
                                                width="18" height="18" alt="" />
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-mono font-medium text-gray-800 dark:text-gray-100 text-xs
                                            {{ $dispositivo->of_client ? 'text-blue-500 dark:text-blue-400' : '' }}">
                                            {{ $dispositivo->imei }}
                                        </div>
                                        @if ($dispositivo->of_client)
                                            <span class="text-xs text-blue-400 dark:text-blue-500">Del cliente</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- MODELO / MARCA --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">
                                    {{ $dispositivo->modelo->modelo }}
                                </div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $dispositivo->modelo->marca }}
                                </div>
                            </td>

                            {{-- ESTADO --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                @if ($dispositivo->estado === 'VENDIDO')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        Vendido
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                        Stock
                                    </span>
                                @endif
                            </td>

                            {{-- FOTA --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                @if ($dispositivo->in_fota)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Fota
                                    </span>
                                @else
                                    <span class="text-xs text-gray-300 dark:text-gray-600">—</span>
                                @endif
                            </td>

                            {{-- VEHÍCULO ASIGNADO --}}
                            <td class="px-3 py-3">
                                @if ($veh)
                                    <div class="flex items-start gap-2">
                                        <div class="mt-0.5 w-5 h-5 shrink-0 flex items-center justify-center bg-sky-100 dark:bg-sky-900/30 rounded">
                                            <svg class="w-3 h-3 text-sky-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7h4l2 4v4h-6V7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-sky-600 dark:text-sky-400 text-sm">
                                                {{ $veh->placa }}
                                            </div>
                                            @if ($veh->cliente)
                                                <div class="text-xs text-gray-600 dark:text-gray-300 truncate max-w-44">
                                                    {{ $veh->cliente->razon_social }}
                                                </div>
                                            @endif
                                            @if ($veh->marca || $veh->modelo)
                                                <div class="text-xs text-gray-400 dark:text-gray-500">
                                                    {{ trim($veh->marca . ' ' . $veh->modelo) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Disponible
                                    </span>
                                @endif
                            </td>

                            {{-- REGISTRO --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $dispositivo->created_at->format('d/m/Y') }}
                                </div>
                                @if ($dispositivo->user)
                                    <div class="text-xs text-gray-400 dark:text-gray-500 truncate max-w-28">
                                        {{ $dispositivo->user->name }}
                                    </div>
                                @endif
                            </td>

                            {{-- ACCIONES --}}
                            <td class="px-3 pr-5 py-3 whitespace-nowrap text-center">
                                <div class="relative inline-flex" x-data="{ open: false }">
                                    <button
                                        class="rounded-full text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400"
                                        :class="{ 'bg-gray-100 dark:bg-gray-700 text-gray-500': open }"
                                        @click.prevent="open = !open" :aria-expanded="open">
                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                            <circle cx="16" cy="16" r="2" />
                                            <circle cx="10" cy="16" r="2" />
                                            <circle cx="22" cy="16" r="2" />
                                        </svg>
                                    </button>
                                    <div class="origin-top-right z-10 absolute -translate-x-3/4 top-full left-0 min-w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 py-1.5 rounded-lg shadow-lg mt-1"
                                        @click.outside="open = false"
                                        @keydown.escape.window="open = false"
                                        x-show="open"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 -translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-out duration-100"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        x-cloak>
                                        <ul>
                                            <li>
                                                <a href="javascript:void(0)"
                                                    wire:click.prevent="openModalEdit({{ $dispositivo->id }})"
                                                    @click="open = false"
                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                    Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"
                                                    wire:click.prevent="verInfoDispositivo({{ $dispositivo }})"
                                                    @click="open = false"
                                                    class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Ver Información
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                                No hay dispositivos que coincidan con los filtros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($dispositivos->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $dispositivos->links() }}
            </div>
        @endif
    </div>

    <!-- Modal de dispositivos no registrados con WireUI -->
    <x-form.modal.card wire:model="showModalNoRegistrados" title="" width="7xl" blur>
        <x-slot name="title">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-linear-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">📋 Dispositivos No Registrados</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        Dispositivos en Fota Web que no están en tu sistema
                    </p>
                </div>
            </div>
        </x-slot>

        <!-- Selector de modelo y botón guardar -->
        @if (count($dispositivosNoRegistrados) > 0)
            <!-- Selección rápida por modelo de Fota -->
            <div
                class="mb-4 p-4 bg-linear-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border-2 border-blue-200 dark:border-blue-800">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                    </svg>
                    <h3 class="text-sm font-bold text-blue-900 dark:text-blue-100">⚡ Selección Rápida por Modelo</h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($this->modelosFota as $modeloInfo)
                        @php
                            $imeisDelModelo = $modeloInfo['imeis'];
                            $todosSeleccionados = !array_diff($imeisDelModelo, $dispositivosSeleccionados);
                            $algunoSeleccionado = !empty(array_intersect($imeisDelModelo, $dispositivosSeleccionados));
                        @endphp
                        <button wire:click="seleccionarPorModelo('{{ $modeloInfo['modelo'] }}')"
                            class="group relative inline-flex items-center gap-2 px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                                {{ $todosSeleccionados
                                    ? 'bg-blue-600 text-white shadow-lg scale-105'
                                    : ($algunoSeleccionado
                                        ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 border-2 border-blue-400 dark:border-blue-600'
                                        : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-blue-900/30') }}">
                            @if ($todosSeleccionados)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                                </svg>
                            @elseif($algunoSeleccionado)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                </svg>
                            @endif
                            <span class="font-bold">{{ $modeloInfo['modelo'] }}</span>
                            <span
                                class="{{ $todosSeleccionados ? 'bg-white/20' : 'bg-blue-100 dark:bg-blue-800/50' }} px-2 py-0.5 rounded-full text-xs font-bold">
                                {{ $modeloInfo['count'] }}
                            </span>
                        </button>
                    @endforeach
                </div>
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-3">
                    💡 Haz click en un modelo para seleccionar todos sus dispositivos
                </p>
            </div>

            <div
                class="mb-6 p-4 bg-linear-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl border-2 border-indigo-200 dark:border-indigo-800">
                <div class="flex flex-col md:flex-row gap-4 items-start md:items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            📦 Selecciona el modelo para los dispositivos
                        </label>
                        <x-form.select wire:model.live="modeloSeleccionado"
                            placeholder="Selecciona un modelo TELTONIKA" :options="$this->modelosTeltonika" option-label="modelo"
                            option-value="id" />
                    </div>

                    <div class="flex gap-2">
                        <x-form.button wire:click="guardarDispositivosSeleccionados"
                            spinner="guardarDispositivosSeleccionados" primary icon="check"
                            label="Guardar Seleccionados ({{ count($dispositivosSeleccionados) }})" />
                    </div>
                </div>
                @if (count($dispositivosSeleccionados) > 0)
                    <div class="mt-3 flex items-center gap-2">
                        <span class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400">
                            {{ count($dispositivosSeleccionados) }} dispositivo(s) seleccionado(s)
                        </p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-linear-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 border-2 border-blue-200 dark:border-blue-800">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-blue-500 dark:bg-blue-600 rounded-lg shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wide">Total Fota Web</p>
                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ number_format($totalFotaWeb) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-linear-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4 border-2 border-green-200 dark:border-green-800">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-green-500 dark:bg-green-600 rounded-lg shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-green-600 dark:text-green-400 uppercase tracking-wide">Registrados</p>
                        <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ number_format($totalLocal) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-linear-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-4 border-2 border-purple-200 dark:border-purple-800">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-purple-500 dark:bg-purple-600 rounded-lg shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-purple-600 dark:text-purple-400 uppercase tracking-wide">No Registrados</p>
                        <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ number_format(count($dispositivosNoRegistrados)) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de dispositivos no registrados -->
        @if (count($dispositivosNoRegistrados) > 0)
            <div class="mb-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-purple-500"></span>
                    </span>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mostrando <span class="font-bold text-purple-600 dark:text-purple-400">{{ count($dispositivosNoRegistrados) }}</span> dispositivos
                    </p>
                </div>
                <x-form.button wire:click="exportarNoRegistrados" emerald label="Exportar CSV" icon="arrow-down-tray" sm />
            </div>

            <div class="overflow-x-auto max-h-125 border border-gray-200 dark:border-gray-700 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-3 text-center">
                                <input type="checkbox" wire:model.live="seleccionarTodos"
                                    wire:click="toggleSeleccionarTodos"
                                    class="w-5 h-5 text-purple-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-purple-500 focus:ring-2 cursor-pointer" />
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">IMEI</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Serial</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Modelo</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Compañía</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Última Conexión</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($dispositivosNoRegistrados as $dispositivo)
                            <tr class="hover:bg-purple-50 dark:hover:bg-purple-900/10 transition-colors"
                                wire:key="no-reg-{{ $dispositivo['imei'] }}">
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox" value="{{ $dispositivo['imei'] }}"
                                        wire:model.live="dispositivosSeleccionados"
                                        class="w-5 h-5 text-purple-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-purple-500 focus:ring-2 cursor-pointer" />
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap font-mono text-sm font-bold text-gray-900 dark:text-gray-100">{{ $dispositivo['imei'] }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $dispositivo['serial'] }}</td>
                                <td class="px-4 py-3 whitespace-nowrap"><x-form.badge rounded blue label="{{ $dispositivo['modelo'] }}" /></td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">{{ $dispositivo['descripcion'] ?: '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $dispositivo['company_name'] }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ $dispositivo['seen_at'] ? \Carbon\Carbon::parse($dispositivo['seen_at'])->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if ($dispositivo['activity_status'] === 'Active')
                                        <x-form.badge rounded positive label="{{ $dispositivo['activity_status'] }}" />
                                    @else
                                        <x-form.badge rounded secondary label="{{ $dispositivo['activity_status'] }}" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">¡Todo sincronizado!</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Todos los dispositivos de Fota Web ya están registrados en tu sistema.</p>
            </div>
        @endif

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cerrar" wire:click="cerrarModalNoRegistrados" />
            </div>
        </x-slot>
    </x-form.modal.card>

</div>
