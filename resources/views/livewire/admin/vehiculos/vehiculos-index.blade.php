<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Vehiculos ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search" class="form-input pl-9 focus:border-slate-300"
                    type="search" placeholder="Buscar Vehiculo" />
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


            {{-- BOTON Y MODAL PARA CREAR VEHICULO --}}

            @can('crear-vehiculos-vehiculos')
                <div class="relative inline-flex">

                    <!-- Create button -->
                    <button wire:click="openModalSave()" aria-controls="basic-modal"
                        class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Añadir Vehiculo</span>
                    </button>

                    <button wire:click="openModalAddVehiculo()" class="btn bg-emerald-500 hover:bg-emerald-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Registro Rapido</span>
                    </button>
                </div>
            @endcan

        </div>

    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start mb-4 sm:justify-end gap-2">

            <!-- Dropdown -->
            <div class="relative float-right hidden sm:block" x-data="{ open: false, selected: 4 }">
                <button wire:ignore
                    class="btn justify-between min-w-44 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600"
                    aria-label="Select date range" aria-haspopup="true" @click.prevent="open = !open"
                    :aria-expanded="open">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0 mr-2" viewBox="0 0 16 16">
                            <path
                                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                        </svg>
                        <span x-text="$refs.options.children[selected].children[1].innerHTML"></span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-slate-400" width="11" height="7"
                        viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="z-10 absolute top-full right-0 w-full bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <div class="font-medium text-sm text-slate-600" x-ref="options">
                        <button wire:click="filter(1)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 0 && 'text-indigo-500'" @click="selected = 0;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 0 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Hoy</span>
                        </button>
                        <button wire:click="filter(7)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 1 && 'text-indigo-500'" @click="selected = 1;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 1 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Ultimos 7 días</span>
                        </button>
                        <button wire:click="filter(30)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 2 && 'text-indigo-500'" @click="selected = 2;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 2 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Ultimo Mes</span>
                        </button>
                        <button wire:click="filter(12)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 3 && 'text-indigo-500'" @click="selected = 3;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 3 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Ultimos 12 Meses</span>
                        </button>
                        <button wire:click="filter(0)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 4 && 'text-indigo-500'" @click="selected = 4;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 4 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Todos</span>
                        </button>

                    </div>
                </div>
            </div>
            <!-- Export button -->
            @can('exportar.vehiculos-vehiculos')
                <div class="relative inline-flex">


                    <x-form.button wire:click.prevent='exportVehiculos()' spinner="exportVehiculos" label="Exportar"
                        positive md icon="download" />
                </div>
            @endcan
            <!-- Import button -->
            @can('importar-vehiculos-vehiculos')
                <div class="relative inline-flex">

                    <x-form.button wire:click="openModalImport()" label="Importar" info md icon="upload" />
                </div>
            @endcan

            <div class="relative inline-flex">

                <x-form.button wire:click="getDevicesWox()" label="Vehiculos plataforma" info md icon="briefcase" />
            </div>
        </div>
        <!-- Left side -->
        <div class="mb-4 sm:mb-0">
            <ul class="flex flex-wrap -m-1">
                <li class="m-1">
                    <button
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">Todas
                        <span class="ml-1 text-indigo-200">{{ $vehiculos->total() }}</span></button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">vehiculos <span
                    class="text-slate-400 font-medium">{{ $vehiculos->total() }}</span>
            </h2>
        </header>
        <div>

            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">
                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <div class="flex items-center">
                                    <label class="inline-flex">
                                        <span class="sr-only">Seleccionar todo</span>
                                        <input id="parent-checkbox" class="form-checkbox" type="checkbox" />
                                    </label>
                                </div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Placa</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Marca</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Datos</div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Cliente</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Ver info Plataforma</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">SIM#</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Dispositivo#</div>
                            </th>

                            @canany(['eliminar-vehiculos-vehiculo', 'editar-vehiculos-vehiculos'])
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-center">Acciones</div>
                                </th>
                            @endcanany
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        @foreach ($vehiculos as $vehiculo)
                            <tr wire:key='vehi-{{ $vehiculo->id }}'>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center">
                                        <label class="inline-flex">
                                            <span class="sr-only">Select</span>
                                            <input class="table-item form-checkbox" type="checkbox" />
                                        </label>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-blue-500">{{ $vehiculo->placa }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">{{ $vehiculo->marca }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                        @mouseleave="open = false">
                                        <button class="btn border-slate-200 hover:border-slate-300 text-slate-600"
                                            aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                                            @focusout="open = false" @click.prevent>
                                            <span class="mr-2">
                                                VER INFO
                                            </span>

                                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                                viewBox="0 0 12 12">
                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                            </svg>
                                        </button>
                                        <div
                                            class="z-10 absolute top-3/4 left-1/2 transform -translate-x-1/2 h-[calc(100vh-64px)]">
                                            <div class="min-w-72 p-3 z-10 rounded-2xl mb-2 bg-slate-100 shadow-2xl shadow-gray-800 overflow-auto max-h-full overflow-y-auto"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>
                                                <div class="">
                                                    <div class="font-medium text-slate-800 mb-0.5 pb-2  text-base">
                                                        <b>{{ $vehiculo->placa }}</b>
                                                    </div>
                                                    <div
                                                        class="relative overflow-y-auto overflow-x-auto shadow-md sm:rounded-lg">
                                                        <table
                                                            class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                                                            <thead
                                                                class="text-xs  text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                <tr>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        DATO
                                                                    </th>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        VALOR
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="a overflow-y-auto">
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        MODELO
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        {{ $vehiculo->modelo }}
                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        TIPO
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        {{ $vehiculo->tipo }}
                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        AÑO
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        {{ $vehiculo->year }}
                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        COLOR
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        {{ $vehiculo->color }}
                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        MOTOR
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        {{ $vehiculo->motor }}
                                                                    </td>

                                                                </tr>
                                                                <tr
                                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                    <th scope="row"
                                                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                        SERIE
                                                                    </th>
                                                                    <td class="px-6 py-4">
                                                                        {{ $vehiculo->serie }}
                                                                    </td>

                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="font-medium text-blue-500">AHF-960</div> --}}
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div class="font-medium text-sky-500">
                                        @if ($vehiculo->cliente)
                                            {{ $vehiculo->cliente->razon_social }}
                                        @else
                                            Sin Cliente Registrado
                                        @endif

                                    </div>
                                    @if ($vehiculo->cliente)
                                        <div class="font-sm text-slate-900">
                                            <p class="text-xs">
                                                {{ $vehiculo->cliente->numero_documento }}
                                            </p>

                                        </div>
                                    @endif

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">


                                    @if ($vehiculo->sim_card)
                                        @if ($vehiculo->sim_card->linea)
                                            <div class="font-medium text-emerald-600">
                                                #{{ $vehiculo->sim_card->linea->numero }} -
                                                {{ $vehiculo->sim_card->linea->operador }}
                                            </div>
                                        @else
                                            <div class="font-medium text-red-200">
                                                LS # {{ $vehiculo->sim_card->sim_card }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="font-medium text-red-500">
                                            AS {{ $vehiculo->old_sim_card }}
                                        </div>
                                    @endif

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800 text-center">
                                        @if ($vehiculo->dispositivos)
                                            {{ $vehiculo->dispositivos->modelo->modelo . ' | ' . $vehiculo->dispositivos->imei }}
                                        @else
                                            {{ $vehiculo->dispositivo_imei }}
                                        @endif

                                    </div>
                                </td>
                                @canany(['eliminar-vehiculos-vehiculo', 'editar-vehiculos-vehiculos',
                                    'show-vehiculos-vehiculos'])
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="relative inline-flex" x-data="{ open: false }">
                                            <div class="relative inline-block h-full text-left">
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                    :class="{ 'bg-slate-100 text-slate-500': open }" aria-haspopup="true"
                                                    @click.prevent="open = !open" :aria-expanded="open">
                                                    <span class="sr-only">Menu</span>
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <circle cx="16" cy="16" r="2" />
                                                        <circle cx="10" cy="16" r="2" />
                                                        <circle cx="22" cy="16" r="2" />
                                                    </svg>
                                                </button>
                                                <div class="origin-top-right  z-10 absolute transform  -translate-x-3/4  top-full left-0 min-w-36 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1  ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                                                    @click.outside="open = false" @keydown.escape.window="open = false"
                                                    x-show="open"
                                                    x-transition:enter="transition ease-out duration-200 transform"
                                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-out duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" x-cloak>
                                                    <ul>
                                                        @can('show-vehiculos-vehiculos')
                                                            <li>
                                                                <a href="{{ route('admin.vehiculos.show', $vehiculo) }}"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-29"
                                                                    role="menuitem" tabindex="-1"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        class="h-5 w-5  mr-3 text-gray-400 group-hover:text-violet-500">
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
                                                        @endcan
                                                        @can('editar-vehiculos-vehiculos')
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="openModalEdit({{ $vehiculo->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
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
                                                        @endcan

                                                        @can('eliminar-vehiculos-vehiculo')
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="deleteVehiculo({{ $vehiculo->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                    Eliminar
                                                                </a>
                                                            </li>
                                                        @endcan

                                                        @role('admin')
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="suspendVehiculo({{ $vehiculo->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg class="h-5 w-5 mr-3 text-gray-500 group-hover:text-rose-700"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 64 64">
                                                                        <g stroke-linecap="round" stroke-width="2"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-linejoin="round" class="nc-icon-wrapper">
                                                                            <line x1="32" y1="3"
                                                                                x2="32" y2="12"></line>
                                                                            <line x1="61" y1="32"
                                                                                x2="52" y2="32"></line>
                                                                            <line x1="32" y1="61"
                                                                                x2="32" y2="52"></line>
                                                                            <line x1="3" y1="32"
                                                                                x2="12" y2="32"></line>
                                                                            <polyline points="20 16 32 32 44 32">
                                                                            </polyline>
                                                                            <circle cx="32" cy="32" r="29">
                                                                            </circle>
                                                                        </g>
                                                                    </svg>
                                                                    Suspender
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="createMantenimiento({{ $vehiculo->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg class="h-5 w-5 mr-3 text-gray-500 group-hover:text-blue-700"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 64 64">
                                                                        <g stroke-linecap="round" stroke-width="2"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-linejoin="round" class="nc-icon-wrapper">
                                                                            <path
                                                                                d="M47.75,37.458,56.352,45a8.034,8.034,0,0,1,.575,11.347c-.091.1-.184.2-.28.3h0a8.035,8.035,0,0,1-11.363,0c-.1-.1-.189-.2-.28-.3L35.667,46.167">
                                                                            </path>
                                                                            <polyline data-cap="butt"
                                                                                points="29.439 25.439 20 16 20 12 13 5 5 13 12 20 16 20 25.234 29.234">
                                                                            </polyline>
                                                                            <path
                                                                                d="M58.376,14.5,51,21.879l-8.872-8.872L49.5,5.629a15.142,15.142,0,0,0-5.266-.586,13.9,13.9,0,0,0-12.7,12.7,15.124,15.124,0,0,0,.588,5.271L6.283,46.344a3.89,3.89,0,0,0-.277,5.495c.044.049.089.1.135.142l5.882,5.882a3.891,3.891,0,0,0,5.5-.009c.044-.045.088-.09.13-.137L41,31.881a15.127,15.127,0,0,0,5.272.588,13.9,13.9,0,0,0,12.7-12.7A15.145,15.145,0,0,0,58.376,14.5Z">
                                                                            </path>
                                                                        </g>
                                                                    </svg>
                                                                    Registrar Mantenimiento
                                                                </a>
                                                            </li>
                                                        @endrole

                                                    </ul>


                                                </div>
                                            </div>

                                        </div>

                                    </td>
                                @endcanany

                            </tr>
                        @endforeach
                        @if ($vehiculos->count() < 1)
                            <td colspan="10" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                <div class="text-center">No hay Registros</div>
                            </td>
                        @endif


                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $vehiculos->links() }}

    </div>


</div>
