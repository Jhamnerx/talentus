<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Registro de Cobranza ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                    type="search" placeholder="Buscar Cobro" />
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-gray-500 group-hover:text-slate-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>

            <!-- Create invoice button -->
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

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left side - Per Page Selector -->
        <div class="flex items-center gap-2 mb-4 sm:mb-0">
            <label for="perPage" class="text-sm text-gray-600 dark:text-gray-300">Mostrar:</label>
            <select wire:model.live="perPage" id="perPage"
                class="form-select text-sm py-1 px-2 border-slate-200 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100 hover:border-slate-300 focus:border-indigo-300 rounded">
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-600 dark:text-gray-300">registros</span>
        </div>

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Eliminar button -->
            <div class="table-items-action hidden">
                <div class="flex items-center">
                    <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap text-gray-500 dark:text-gray-400">
                        <span class="table-items-count"></span> Items Seleccionados
                    </div>
                    <button
                        class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-rose-500 hover:text-rose-600">Eliminar</button>
                </div>
            </div>

            <!-- Dropdown -->

            <div class="relative float-right" x-data="{ open: false, selected: 3 }">
                <button wire:ignore
                    class="btn justify-between min-w-44 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                    aria-label="Select date range" aria-haspopup="true" @click.prevent="open = !open"
                    :aria-expanded="open">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 fill-current text-gray-500 dark:text-gray-400 shrink-0 mr-2"
                            viewBox="0 0 16 16">
                            <path
                                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                        </svg>
                        <span x-text="$refs.options.children[selected].children[1].innerHTML"></span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                        height="7" viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="z-10 absolute top-full right-0 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <div class="font-medium text-sm text-gray-600 dark:text-gray-300" x-ref="options">
                        <button wire:click="setFiltroFecha('por_vencer')" tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                            :class="selected === 0 && 'text-indigo-500'" @click="selected = 0;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 0 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Por Vencer (7 días)</span>
                        </button>
                        <button wire:click="setFiltroFecha('vencidos')" tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                            :class="selected === 1 && 'text-indigo-500'" @click="selected = 1;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 1 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Vencidos</span>
                        </button>
                        <button wire:click="setFiltroFecha('proximo_mes')" tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                            :class="selected === 2 && 'text-indigo-500'" @click="selected = 2;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 2 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Próximo Mes</span>
                        </button>

                        <button wire:click="setFiltroFecha(null)" tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3 cursor-pointer"
                            :class="selected === 3 && 'text-indigo-500'" @click="selected = 3;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 3 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Todos</span>
                        </button>

                    </div>
                </div>
            </div>

            <!-- Filter button -->
            <div class="relative inline-flex">
                <button
                    class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <span class="sr-only">Filtro</span><wbr>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                        <path
                            d="M9 15H7a1 1 0 010-2h2a1 1 0 010 2zM11 11H5a1 1 0 010-2h6a1 1 0 010 2zM13 7H3a1 1 0 010-2h10a1 1 0 010 2zM15 3H1a1 1 0 010-2h14a1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>

    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Registros de cobros
                <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $cobros->total() }}</span>
            </h2>
        </header>
        <div>

            <div class="overflow-x-auto min-h-screen">
                <table class="table-auto w-full dark:text-gray-300">

                    <thead
                        class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-100 dark:border-gray-700/60">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <div class="font-semibold text-left">Expandir</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <div class="font-semibold text-left">Ver</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Empresa</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Contacto</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Comentario</div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Periodo</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Tipo Comprobante</div>
                            </th>
                            {{-- <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Crear Invoice</div>
                            </th> --}}
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Observacion</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Acciones</div>
                            </th>
                        </tr>
                    </thead>

                    @foreach ($cobros as $cobro)
                        <tbody class="text-sm" wire:key='cobro-{{ $cobro->id }}' x-data="{ open: false }">
                            <!-- Fila principal -->
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <button
                                        class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 transform transition-transform"
                                        :class="{ 'rotate-180': open }" @click.prevent="open = !open"
                                        :aria-expanded="open" aria-controls="vehiculos-{{ $cobro->id }}">
                                        <span class="sr-only">Expandir</span>
                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                            <path d="M16 20l-5.4-5.4 1.4-1.4 4 4 4-4 1.4 1.4z" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <a href="{{ route('admin.cobros.show', $cobro) }}"
                                        class="text-gray-700 dark:text-gray-300 group flex items-center text-sm font-normal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            class="h-5 w-5 text-gray-400 dark:text-gray-500 group-hover:text-violet-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="font-medium text-sky-600 dark:text-sky-400">
                                            {{ $cobro->clientes->razon_social }}
                                        </div>
                                        @if (!$cobro->detalle->isEmpty())
                                            <span
                                                class="ml-2 px-2 py-0.5 text-xs font-medium bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-300 rounded-full">
                                                {{ $cobro->detalle->count() }} vehículos
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        @if (count($cobro->clientes->contactos) >= 1)
                                            @foreach ($cobro->clientes->contactos as $contacto)
                                                <ul>
                                                    <li>{{ $contacto->nombre }}</li>
                                                </ul>
                                            @endforeach
                                        @else
                                            #añadir
                                        @endif
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-gray-800 dark:text-gray-100">{{ $cobro->comentario }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $cobro->periodo }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $cobro->tipo_pago }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $cobro->observacion }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <div class="relative inline-block h-full text-left">
                                            <button
                                                class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 rounded-full"
                                                :class="{ 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400': open }"
                                                aria-haspopup="true" @click.prevent="open = !open"
                                                :aria-expanded="open">
                                                <span class="sr-only">Menu</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="2" />
                                                    <circle cx="10" cy="16" r="2" />
                                                    <circle cx="22" cy="16" r="2" />
                                                </svg>
                                            </button>
                                            <div class="origin-top-right z-10 absolute transform -translate-x-3/4 top-full left-0 min-w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded shadow-lg overflow-hidden mt-1 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-gray-700 focus:outline-none"
                                                @click.outside="open = false" @keydown.escape.window="open = false"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 -translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>
                                                <ul>
                                                    @can('admin.cobros.edit')
                                                        <li>
                                                            <a href="{{ route('admin.cobros.edit', $cobro) }}"
                                                                class="text-gray-700 dark:text-gray-300 group flex items-center px-4 py-2 text-sm font-normal">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="w-5 h-5 mr-3 text-gray-400 dark:text-gray-500 group-hover:text-blue-500">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                    </path>
                                                                </svg> Editar
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    @can('admin.cobros.delete')
                                                        <li>
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent="openModalDelete({{ $cobro->id }})"
                                                                class="text-gray-700 dark:text-gray-300 group flex items-center px-4 py-2 text-sm font-normal">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="h-5 w-5 mr-3 text-gray-400 dark:text-gray-500 group-hover:text-red-500">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                                Eliminar
                                                            </a>
                                                        </li>
                                                    @endcan
                                                    <li>
                                                        <a href="{{ route('admin.cobros.show', $cobro) }}"
                                                            class="text-gray-700 dark:text-gray-300 group flex items-center px-4 py-2 text-sm font-normal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="h-5 w-5 mr-3 text-gray-400 dark:text-gray-500 group-hover:text-violet-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg> Ver
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
            </div>
            </td>
            </tr>

            <!-- Fila collapsible con vehículos -->
            <tr id="vehiculos-{{ $cobro->id }}" role="region" x-show="open" x-cloak>
                <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-3">
                    <div class="bg-gray-50 dark:bg-gray-900/20 p-5 -mt-3">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            VEHÍCULOS ({{ $cobro->detalle->count() }})
                        </h3>

                        @if ($cobro->detalle->isEmpty())
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                No se registraron vehículos
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach ($cobro->detalle as $detalle)
                                    @php
                                        $diasRestantes = (int) \Carbon\Carbon::now()->diffInDays(
                                            $detalle->fecha,
                                            false,
                                        );
                                        $bgColor = '';
                                        $textColor = '';
                                        $borderLeftColor = '';

                                        if ($diasRestantes < 0) {
                                            $bgColor = 'bg-red-50 dark:bg-red-900/20';
                                            $textColor = 'text-red-700 dark:text-red-400';
                                            $borderLeftColor = 'border-l-red-500 dark:border-l-red-600';
                                            $estadoTexto = 'VENCIDO';
                                        } elseif ($diasRestantes <= 7) {
                                            $bgColor = 'bg-orange-50 dark:bg-orange-900/20';
                                            $textColor = 'text-orange-700 dark:text-orange-400';
                                            $borderLeftColor = 'border-l-orange-500 dark:border-l-orange-600';
                                            $estadoTexto = 'POR VENCER';
                                        } elseif ($diasRestantes <= 15) {
                                            $bgColor = 'bg-yellow-50 dark:bg-yellow-900/20';
                                            $textColor = 'text-yellow-700 dark:text-yellow-400';
                                            $borderLeftColor = 'border-l-yellow-500 dark:border-l-yellow-600';
                                            $estadoTexto = 'PRÓXIMO';
                                        } else {
                                            $bgColor = 'bg-green-50 dark:bg-green-900/20';
                                            $textColor = 'text-green-700 dark:text-green-400';
                                            $borderLeftColor = 'border-l-green-500 dark:border-l-green-600';
                                            $estadoTexto = 'VIGENTE';
                                        }
                                    @endphp

                                    <div
                                        class="flex items-center gap-4 p-3 {{ $bgColor }} border-l-4 {{ $borderLeftColor }} rounded hover:shadow-sm transition-shadow">
                                        <!-- Placa y Vehículo -->
                                        <div class="w-32 shrink-0">
                                            @if ($detalle->vehiculo)
                                                <div class="font-bold {{ $textColor }}">
                                                    {{ $detalle->vehiculo->placa }}
                                                </div>
                                                @if ($detalle->vehiculo->marca || $detalle->vehiculo->modelo)
                                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                                        {{ $detalle->vehiculo->marca }}
                                                        {{ $detalle->vehiculo->modelo }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="font-bold text-gray-400 dark:text-gray-500">Sin vehículo
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Tipo y Año -->
                                        @if ($detalle->vehiculo)
                                            <div class="w-32 shrink-0 text-sm">
                                                @if ($detalle->vehiculo->tipo)
                                                    <div class="text-gray-600 dark:text-gray-400">
                                                        {{ $detalle->vehiculo->tipo }}</div>
                                                @endif
                                                @if ($detalle->vehiculo->año)
                                                    <div class="text-gray-500 dark:text-gray-500 text-xs">Año:
                                                        {{ $detalle->vehiculo->año }}</div>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Plan -->
                                        <div class="w-24 shrink-0 text-sm">
                                            <div class="text-gray-600 dark:text-gray-400 text-xs">Plan</div>
                                            <div class="font-medium text-gray-900 dark:text-gray-100">S/.
                                                {{ $detalle->plan }}</div>
                                        </div>

                                        <!-- Vencimiento -->
                                        <div class="w-28 shrink-0 text-sm">
                                            <div class="text-gray-600 dark:text-gray-400 text-xs">Vencimiento</div>
                                            <div class="font-medium {{ $textColor }}">
                                                {{ $detalle->fecha->format('d-m-Y') }}
                                            </div>
                                        </div>

                                        <!-- Días restantes -->
                                        <div class="w-28 shrink-0 text-sm">
                                            <div class="text-gray-600 dark:text-gray-400 text-xs">Días restantes</div>
                                            <div class="font-bold {{ $textColor }}">
                                                {{ $diasRestantes >= 0 ? $diasRestantes . ' días' : 'Vencido hace ' . abs($diasRestantes) . ' días' }}
                                            </div>
                                        </div>

                                        <!-- Estado Badge -->
                                        <div class="w-24 shrink-0">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold {{ $textColor }} bg-white dark:bg-gray-800 border border-current rounded">
                                                {{ $estadoTexto }}
                                            </span>
                                        </div>

                                        <!-- Toggle Estado -->
                                        <div class="flex items-center gap-2 ml-auto" x-data="{ checked: {{ $detalle->estado ? 'true' : 'false' }} }">
                                            <span class="text-xs text-gray-600 dark:text-gray-400">Estado:</span>
                                            <div class="form-switch">
                                                <input wire:click="cambiarEstado({{ $detalle->id }})"
                                                    type="checkbox" id="switchCollapse{{ $detalle->id }}"
                                                    class="sr-only" x-model="checked" />
                                                <label class="bg-gray-400 dark:bg-gray-700"
                                                    for="switchCollapse{{ $detalle->id }}">
                                                    <span class="bg-white dark:bg-gray-300 shadow-sm"
                                                        aria-hidden="true"></span>
                                                    <span class="sr-only">Estado</span>
                                                </label>
                                            </div>
                                            <span class="text-xs"
                                                :class="checked ? 'text-green-600' : 'text-red-600'">
                                                <span x-show="checked">Activo</span>
                                                <span x-show="!checked">Inactivo</span>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
            </tbody>
            @endforeach

            @if ($cobros->count() < 1)
                <tbody>
                    <tr>
                        <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                            <div class="text-center text-gray-500 dark:text-gray-400">No hay Registros</div>
                        </td>
                    </tr>
                </tbody>
            @endif
            </table>

        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-8 w-full">
    {{ $cobros->links() }}

</div>

</div>
