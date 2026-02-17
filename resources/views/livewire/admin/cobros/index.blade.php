<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header con filtros mejorados -->
    <div class="mb-8">
        <!-- Título y botón limpiar filtros -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Cobros Recurrentes 💰</h1>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <button wire:click="clearFilters" class="btn bg-red-500 hover:bg-red-600 text-white">
                    <svg class="w-4 h-4 fill-current shrink-0 " viewBox="0 0 16 16">
                        <path
                            d="M5.414 4L4 5.414 6.586 8 4 10.586 5.414 12 8 9.414 10.586 12 12 10.586 9.414 8 12 5.414 10.586 4 8 6.586z" />
                    </svg>
                    <span class="ml-2">Limpiar</span>
                </button>
                @can('admin.cobros.create')
                    <a href="{{ route('admin.cobros.create') }}">
                        <button
                            class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                            <span class="hidden xs:block ml-2">Registrar</span>
                        </button>
                    </a>
                @endcan
            </div>
        </div>

        <!-- Filtros organizados: Izquierda (filtros) y Derecha (búsqueda + cliente) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">

            <!-- IZQUIERDA: Filtros Dropdown (3 columnas) -->
            <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-3 gap-3">

                <!-- 1. Estado del Cobro -->
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button
                        class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                        aria-label="Select state" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="flex items-center">
                            <span class="text-xs font-semibold mr-1">Estado:</span>
                            <span class="text-xs font-medium">
                                @if ($estado === 1)
                                    ✅ Activo
                                @elseif ($estado === 0)
                                    ⏸️ Suspendido
                                @else
                                    Todos
                                @endif
                            </span>
                        </span>
                        <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                            height="7" viewBox="0 0 11 7">
                            <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                        </svg>
                    </button>
                    <div class="origin-top-right z-10 absolute left-0 min-w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                            Estado del Cobro</div>
                        <div class="mb-1">
                            <button wire:click='$set("estado",1)'
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!{{ $estado === 1 ? 'true' : 'false' }} && 'invisible'" width="12"
                                    height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">✅ Activo</span>
                            </button>
                            <button wire:click='$set("estado",0)'
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!{{ $estado === 0 ? 'true' : 'false' }} && 'invisible'" width="12"
                                    height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">⏸️ Suspendido</span>
                            </button>
                            <button wire:click='$set("estado",null)'
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!{{ $estado === null ? 'true' : 'false' }} && 'invisible'" width="12"
                                    height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Todos</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 4. Filtro Registros (cuándo se creó) -->
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button
                        class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                        aria-label="Filtrar registros" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="flex items-center">
                            <span class="text-xs font-semibold mr-1">📝:</span>
                            <span class="text-xs font-medium truncate">
                                @if ($filtroFecha === 'registrados_7dias')
                                    7d
                                @elseif ($filtroFecha === 'registrados_mes')
                                    Mes
                                @else
                                    Todos
                                @endif
                            </span>
                        </span>
                        <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                            height="7" viewBox="0 0 11 7">
                            <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                        </svg>
                    </button>
                    <div class="origin-top-right z-10 absolute left-0 min-w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                            📝 Registros (Fecha Creación)
                        </div>
                        <div class="mb-1">
                            <button wire:click="setFiltroFecha('registrados_7dias')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!{{ $filtroFecha === 'registrados_7dias' ? 'true' : 'false' }} && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Últimos 7 días</span>
                            </button>
                            <button wire:click="setFiltroFecha('registrados_mes')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!{{ $filtroFecha === 'registrados_mes' ? 'true' : 'false' }} && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Este mes</span>
                            </button>
                            <button wire:click="setFiltroFecha(null)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!{{ $filtroFecha === null ? 'true' : 'false' }} && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Todos</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 3. Filtro Vencimientos -->
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button
                        class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                        aria-label="Filtrar vencimientos" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="flex items-center">
                            <span class="text-xs font-semibold mr-1">⏰:</span>
                            <span class="text-xs font-medium truncate">
                                @if ($filtroVencimiento === 'vencidos')
                                    ❌ Venc
                                @elseif ($filtroVencimiento === 'vencen_7dias')
                                    🟡 7d
                                @elseif ($filtroVencimiento === 'vencen_fin_mes')
                                    🔵 Fin
                                @elseif ($filtroVencimiento === 'vencen_proximo_mes')
                                    🟣 Mes
                                @else
                                    Todos
                                @endif
                            </span>
                        </span>
                        <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                            height="7" viewBox="0 0 11 7">
                            <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                        </svg>
                    </button>
                    <div class="origin-top-right z-10 absolute left-0 min-w-64 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                            ⏰ Vencimiento (Próxima Facturación)
                        </div>
                        <div class="mb-1">
                            <button wire:click="setFiltroVencimiento('vencidos')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-red-500"
                                    :class="!{{ $filtroVencimiento === 'vencidos' ? 'true' : 'false' }} && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">🔴 Vencidos (ya pasaron)</span>
                            </button>
                            <button wire:click="setFiltroVencimiento('vencen_7dias')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-amber-500"
                                    :class="!{{ $filtroVencimiento === 'vencen_7dias' ? 'true' : 'false' }} && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">🟡 Vencen en 7 días</span>
                            </button>
                            <button wire:click="setFiltroVencimiento('vencen_fin_mes')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-blue-500"
                                    :class="!{{ $filtroVencimiento === 'vencen_fin_mes' ? 'true' : 'false' }} && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">🔵 Vencen a fin de mes</span>
                            </button>
                            <button wire:click="setFiltroVencimiento('vencen_proximo_mes')"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="!{{ $filtroVencimiento === 'vencen_proximo_mes' ? 'true' : 'false' }} &&
                                        'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">🟣 Vencen en próximo mes</span>
                            </button>
                            <button wire:click="setFiltroVencimiento(null)"
                                class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                                @click="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-gray-400"
                                    :class="!{{ $filtroVencimiento === null ? 'true' : 'false' }} && 'invisible'"
                                    width="12" height="9" viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span class="text-sm">Todos</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DERECHA: Búsqueda + Select Cliente (2 columnas) -->
            <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-3">

                <!-- Select Cliente con API -->
                <div>
                    <x-form.select label="Cliente" wire:model.live="clienteId" placeholder="Seleccionar cliente..."
                        :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id" :clearable="true" />
                </div>

                <!-- Búsqueda general -->
                <div>
                    <label for="action-search"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Búsqueda general
                    </label>
                    <div class="relative">
                        <input wire:model.live.debounce='search' id="action-search"
                            class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100 w-full"
                            type="search" placeholder="Placa, contacto, periodo..." />
                        <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                            <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-gray-500 group-hover:text-slate-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                                viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                <path
                                    d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Per Page Selector con WireUI -->
        <div class="flex items-center gap-3 mt-5">
            <label for="perPage" class="text-sm text-gray-600 dark:text-gray-300">Mostrar:</label>
            <div class="w-24">
                <x-form.native.select wire:model.live="perPage" id="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </x-form.native.select>
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-300">registros</span>
        </div>

        <!-- Tabla de Detalles Agrupados por Empresa -->
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mt-5">
            <header class="px-5 py-4">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Vehículos por cobrar
                    <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $detalles->total() }}</span>
                </h2>
            </header>
            <div>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full dark:text-gray-300">
                        <thead
                            class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-100 dark:border-gray-700/60">
                            <tr>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Cliente</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Vehículo</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Plan</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Vencimiento</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Días Rest.</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Estado</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Periodo</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Tipo</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="font-semibold text-left">Acciones</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm">
                            @php
                                $currentCliente = null;
                            @endphp

                            @foreach ($detalles as $detalle)
                                @php
                                    $clienteNombre = $detalle->cobro->clientes->razon_social;
                                    $showClienteHeader = $currentCliente !== $clienteNombre;
                                    $currentCliente = $clienteNombre;

                                    // Calcular días restantes desde el inicio del día actual
                                    $hoy = \Carbon\Carbon::now()->startOfDay();
                                    $fechaVencimiento = \Carbon\Carbon::parse($detalle->fecha)->startOfDay();
                                    $diasRestantes = $hoy->diffInDays($fechaVencimiento, false);

                                    // Determinar texto descriptivo para días restantes
                                    if ($diasRestantes < 0) {
                                        $diasTexto =
                                            abs($diasRestantes) .
                                            ' día' .
                                            (abs($diasRestantes) != 1 ? 's' : '') .
                                            ' atrasado';
                                    } elseif ($diasRestantes == 0) {
                                        $diasTexto = 'Hoy';
                                    } elseif ($diasRestantes == 1) {
                                        $diasTexto = 'Mañana';
                                    } else {
                                        $diasTexto = $diasRestantes . ' días';
                                    }

                                    // Determinar colores y estado según días restantes
                                    if ($diasRestantes < 0) {
                                        $bgColor = 'bg-red-50 dark:bg-red-900/10';
                                        $textColor = 'text-red-700 dark:text-red-400';
                                        $estadoTexto = 'VENCIDO';
                                    } elseif ($diasRestantes <= 7) {
                                        $bgColor = 'bg-orange-50 dark:bg-orange-900/10';
                                        $textColor = 'text-orange-700 dark:text-orange-400';
                                        $estadoTexto = 'POR VENCER';
                                    } elseif ($diasRestantes <= 15) {
                                        $bgColor = 'bg-yellow-50 dark:bg-yellow-900/10';
                                        $textColor = 'text-yellow-700 dark:text-yellow-400';
                                        $estadoTexto = 'PRÓXIMO';
                                    } else {
                                        $bgColor = 'bg-green-50 dark:bg-green-900/10';
                                        $textColor = 'text-green-700 dark:text-green-400';
                                        $estadoTexto = 'VIGENTE';
                                    }
                                @endphp

                                @if ($showClienteHeader)
                                    <tr
                                        class="bg-indigo-100 dark:bg-indigo-900/40 border-t-2 border-indigo-200 dark:border-indigo-700">
                                        <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-2">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="font-bold text-sm text-indigo-900 dark:text-indigo-100">
                                                    {{ $clienteNombre }}
                                                </span>
                                                @if ($detalle->cobro->clientes->contactos->isNotEmpty())
                                                    <span class="text-xs text-indigo-700 dark:text-indigo-300">
                                                        • {{ $detalle->cobro->clientes->contactos->first()->nombre }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                                <tr class="border-b border-gray-200 dark:border-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700/30 {{ $bgColor }}"
                                    wire:key='detalle-{{ $detalle->id }}'>

                                    <!-- Cliente -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3">
                                        <div class="font-medium text-sm text-gray-900 dark:text-gray-100">
                                            {{ $detalle->cobro->clientes->razon_social }}
                                        </div>
                                        @if ($detalle->cobro->clientes->contactos->isNotEmpty())
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $detalle->cobro->clientes->contactos->first()->nombre }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Vehículo -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3">
                                        @if ($detalle->vehiculo)
                                            <div class="font-bold {{ $textColor }}">
                                                {{ $detalle->vehiculo->placa }}
                                            </div>
                                            @if ($detalle->vehiculo->marca || $detalle->vehiculo->modelo)
                                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                                    {{ $detalle->vehiculo->marca }} {{ $detalle->vehiculo->modelo }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">Sin vehículo</span>
                                        @endif
                                    </td>

                                    <!-- Plan -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            S/. {{ number_format($detalle->plan, 2) }}
                                        </div>
                                    </td>

                                    <!-- Vencimiento -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @if ($detalle->estado == 1 && $diasRestantes >= 0)
                                            <div class="font-medium {{ $textColor }}">
                                                {{ $detalle->fecha->format('d-m-Y') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                        @endif
                                    </td>

                                    <!-- Días Restantes -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @if ($detalle->estado == 1 && $diasRestantes >= 0)
                                            <div class="font-bold {{ $textColor }} text-xs">
                                                {{ $diasTexto }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                        @endif
                                    </td>

                                    <!-- Estado Badge -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold {{ $textColor }} bg-white dark:bg-gray-900/50 border-2 border-current rounded">
                                            {{ $estadoTexto }}
                                        </span>
                                    </td>

                                    <!-- Periodo -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $detalle->cobro->periodo }}
                                        </div>
                                    </td>

                                    <!-- Tipo -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $detalle->cobro->tipo_pago }}
                                        </div>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.cobros.show', $detalle->cobro) }}"
                                                class="text-gray-400 hover:text-violet-500" title="Ver cobro">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <div class="form-switch" x-data="{ checked: {{ $detalle->estado ? 'true' : 'false' }} }">
                                                <input wire:click="cambiarEstado({{ $detalle->id }})"
                                                    type="checkbox" id="switch{{ $detalle->id }}" class="sr-only"
                                                    x-model="checked" />
                                                <label class="bg-gray-400 dark:bg-gray-700"
                                                    for="switch{{ $detalle->id }}">
                                                    <span class="bg-white dark:bg-gray-300 shadow-sm"
                                                        aria-hidden="true"></span>
                                                    <span class="sr-only">Estado</span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($detalles->count() < 1)
                                <tr>
                                    <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
                                        <div class="text-gray-500 dark:text-gray-400">No hay registros</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $detalles->links() }}
        </div>

    </div>
</div>
