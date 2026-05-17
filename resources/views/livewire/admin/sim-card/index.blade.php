<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">SIM CARDS - TARJETAS FISICAS
            </h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <form class="relative" @submit.prevent>
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live.debounce.500ms="search" class="form-input pl-9 focus:border-slate-300"
                    type="search" placeholder="Buscar sim card" />

                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>

            <!-- Add  button -->
            @can('crear-sim_card')
                <button wire:click.prevent='openModalCreate()'
                    class="btn bg-indigo-500 hover:bg-indigo-600 text-white cursor-pointer">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Registrar Sim Card</span>
                </button>
            @endcan


            @can('asignar.linea-sim_card')
                <button wire:click.prevent="openModalAsign()"
                    class="btn btnAsignar bg-emerald-500 hover:bg-emerald-600 text-white btn border-slate-200 hover:border-slate-300 cursor-pointer">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Asignar Linea a Sim Card</span>
                </button>
            @endcan

        </div>

    </div>
    <!-- More actions -->

    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: filtro por operador -->
        <div class="mb-4 sm:mb-0 mt-2 sm:mt-0 text-slate-500" x-data="{ clickeado: 0 }">
            <ul class="flex flex-wrap -m-1">
                <li class="m-1">
                    <button wire:click.prevent="setOperador()"
                        :class="clickeado === 0 && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                        @click="clickeado = 0"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm duration-150 ease-in-out">
                        Todas
                    </button>
                </li>
                @foreach ($operadoresList as $opBtn)
                    <li class="m-1">
                        <button wire:click.prevent="setOperador({{ $opBtn->id }})"
                            :class="clickeado === {{ $opBtn->id }} && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                            @click="clickeado = {{ $opBtn->id }}"
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm duration-150 ease-in-out">
                            {{ strtoupper($opBtn->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Export button -->
            @can('exportar-sim_card')
                <div class="relative inline-flex">
                    <a href="{{ route('admin.export.lineas') }}">
                        <button
                            class="btn bg-emerald-600 hover:bg-emerald-700 text-white btn border-slate-200 hover:border-slate-300 cursor-pointer">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 32 32">
                                <path
                                    d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
                            </svg>
                            <span class="hidden xs:block ml-2">Exportar</span>
                        </button>
                    </a>
                </div>
            @endcan


            <!-- Import button -->
            @can('importar-sim_card')
                <div class="relative inline-flex">
                    <button wire:click="openModalImport()" aria-controls="basic-modal"
                        class="btn bg-blue-600 hover:bg-blue-700 text-white btn border-slate-200 hover:border-slate-300 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 icon icon-tabler icon-tabler-upload"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <polyline points="7 9 12 4 17 9" />
                            <line x1="12" y1="4" x2="12" y2="16" />
                        </svg>
                        <span class="hidden xs:block ml-2">Importar</span>
                    </button>
                </div>
            @endcan

            {{-- Botón sincronización M2M Dataglobal (solo visible si hay operador configurado) --}}
            @if ($operadorM2M)
                <div class="relative inline-flex">
                    <button wire:click="sincronizarM2M" wire:loading.attr="disabled" wire:target="sincronizarM2M"
                        class="btn bg-orange-500 hover:bg-orange-600 disabled:opacity-60 text-white border-slate-200 hover:border-slate-300 cursor-pointer">
                        {{-- Icono normal --}}
                        <svg wire:loading.remove wire:target="sincronizarM2M" xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{-- Spinner de carga --}}
                        <svg wire:loading wire:target="sincronizarM2M" class="w-5 h-5 shrink-0 animate-spin"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span class="hidden xs:block ml-2">
                            <span wire:loading.remove wire:target="sincronizarM2M">Sync
                                {{ strtoupper($operadorM2M->name) }}</span>
                            <span wire:loading wire:target="sincronizarM2M">Sincronizando...</span>
                        </span>
                    </button>
                </div>
            @endif

        </div>

    </div>
    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100">Total sim cards <span
                    class="text-slate-400 dark:text-slate-500 font-medium">{{ $sim_cards->total() }}</span>
            </h2>

        </header>
        <div>
            <!-- Table -->
            <div class="overflow-x-auto">

                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/20 border-t border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">SIM CARD</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">NUMERO ASIGNADO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">OPERADOR</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">VEHICULO - DISPOSITIVO</div>
                            </th>
                            @can('ver.cambios-sim_card')
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Acciones</div>
                                </th>
                            @endcan


                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">

                        @foreach ($sim_cards as $sim_card)
                            <tr wire:key="{{ $sim_card->id }}"
                                @if ($sim_card->operador?->api_slug) @dblclick.prevent="$dispatch('m2m-abrir-panel', { icc: '{{ $sim_card->sim_card }}' })"
                                    title="Doble click para gestionar SIM en M2M"
                                    class="cursor-pointer hover:bg-orange-50/50 dark:hover:bg-orange-900/10 transition" @endif>


                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 shrink-0 flex items-center justify-center bg-talentus-100 rounded-full mr-2 sm:mr-3">

                                            <svg class="ml-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" width="20" height="20">
                                                <g fill="none" class="nc-icon-wrapper">
                                                    <path
                                                        d="M18 2h-8L4 8v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 2v16H6V8.83L10.83 4H18zM7 17h2v2H7v-2zm8 0h2v2h-2v-2zm-8-6h2v4H7v-4zm4 4h2v4h-2v-4zm0-4h2v2h-2v-2zm4 0h2v4h-2v-4z"
                                                        fill="white"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        @if (!empty($sim_card->sim_card))
                                            <div class="font-medium text-slate-800 dark:text-slate-100">
                                                {{ $sim_card->sim_card }}</div>
                                        @else
                                            <div class="font-medium text-slate-800 dark:text-slate-100"></div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if (!empty($sim_card->linea))
                                        <div class="text-left text-slate-800 dark:text-slate-100">
                                            {{ $sim_card->linea->numero }}</div>
                                    @else
                                        <div class="text-left text-slate-500 dark:text-slate-400"># -</div>
                                    @endif

                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 dark:text-slate-100">
                                        {{ $sim_card->operador?->name ?? '—' }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                    @if (!empty($sim_card->vehiculos))
                                        <div class="flex items-center space-x-2 justify-center">
                                            <!-- Start -->
                                            <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                                @mouseleave="open = false">
                                                <button class="block" aria-haspopup="true" :aria-expanded="open"
                                                    @focus="open = true" @focusout="open = false" @click.prevent>
                                                    <svg class="w-4 h-4 fill-current text-slate-400"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                                                    </svg>
                                                </button>
                                                <div class="z-10 absolute bottom-full left-1/2 -translate-x-1/2">
                                                    <div class="bg-slate-800 dark:bg-slate-700 p-2 rounded overflow-hidden mb-2"
                                                        x-show="open"
                                                        x-transition:enter="transition ease-out duration-200 transform"
                                                        x-transition:enter-start="opacity-0 translate-y-2"
                                                        x-transition:enter-end="opacity-100 translate-y-0"
                                                        x-transition:leave="transition ease-out duration-200"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0" x-cloak>
                                                        <div class="text-xs text-slate-200 whitespace-nowrap">
                                                            Esta opción te permite ir al vehiculo asignado y
                                                            editarlo
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End -->
                                            <div class="font-medium text-sky-500">
                                                {{ $sim_card->vehiculos->placa }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="font-medium text-emerald-500">
                                            Sin Vehiculo
                                        </div>
                                    @endif

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <div class="relative inline-block h-full text-left">
                                            <button
                                                class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 rounded-full"
                                                :class="{ 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300': open }"
                                                aria-haspopup="true" @click.prevent="open = !open"
                                                :aria-expanded="open">
                                                <span class="sr-only">Menu</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="2" />
                                                    <circle cx="10" cy="16" r="2" />
                                                    <circle cx="22" cy="16" r="2" />
                                                </svg>
                                            </button>
                                            <div class="origin-top-right  z-10 absolute transform  -translate-x-3/4  top-full left-0 min-w-36 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-1.5 rounded shadow-lg overflow-hidden mt-1  ring-1 ring-black dark:ring-slate-700 ring-opacity-5 divide-y divide-gray-100 dark:divide-slate-700 focus:outline-none"
                                                @click.outside="open = false" @keydown.escape.window="open = false"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 -translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>

                                                <ul>
                                                    <li>
                                                        <a href="javascript: void(0)"
                                                            wire:click.prevent="openModalEdit({{ $sim_card->id }})"
                                                            class="text-gray-700 dark:text-gray-200 hover:bg-slate-50 dark:hover:bg-slate-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                            disabled="false" id="headlessui-menu-item-27"
                                                            role="menuitem" tabindex="-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                </path>
                                                            </svg> Editar

                                                        </a>
                                                    </li>
                                                    @if ($sim_card->linea)
                                                        <li>
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent="openModalCambiarNumero({{ $sim_card->id }})"
                                                                class="text-gray-700 dark:text-gray-200 hover:bg-slate-50 dark:hover:bg-slate-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                role="menuitem" tabindex="-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="w-5 h-5 mr-3 text-gray-400 group-hover:text-indigo-500"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                                                </svg>
                                                                Cambiar número
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @can('eliminar.numero-sim_card')
                                                        @if ($sim_card->linea)
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="openModalUnAsign({{ $sim_card }})"
                                                                    class="text-rose-600 dark:text-rose-400 hover:bg-slate-50 dark:hover:bg-slate-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg class="w-5 h-5 mr-3 fill-current shrink-0"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                                                    </svg>
                                                                    Eliminar asignación
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endcan
                                                    @can('ver.cambios-sim_card')
                                                        <li>
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent="openModalCambios({{ $sim_card->id }})"
                                                                class="text-gray-700 dark:text-gray-200 hover:bg-slate-50 dark:hover:bg-slate-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-27"
                                                                role="menuitem" tabindex="-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-eye-check w-6 h-6 shrink-0"
                                                                    viewBox="0 0 32 32" stroke-width="1.5"
                                                                    stroke="#9e9e9e" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <circle cx="12" cy="12" r="2" />
                                                                    <path
                                                                        d="M12 19c-4 0 -7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7c-.42 .736 -.858 1.414 -1.311 2.033" />
                                                                    <path d="M15 19l2 2l4 -4" />
                                                                </svg> Ver Cambios

                                                            </a>
                                                        </li>
                                                    @endcan

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if ($sim_cards->count() < 1)
                            <tr>
                                <td colspan="6"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center text-slate-500 dark:text-slate-400">No hay Registros</div>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $sim_cards->links() }}
    </div>

    {{-- M2M Panel: modales de gestión de SIM cards via API M2M Dataglobal --}}
    @livewire('admin.sim-card.m2m-panel')

</div>
