<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">LINEAS ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model="search" class="form-input pl-9 focus:border-slate-300" type="search"
                    placeholder="Buscar sim card" />


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
                <a href="{{ route('admin.almacen.lineas.create') }}">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Registrar Linea</span>
                    </button>
                </a>
            @endcan


            @can('asignar.linea-sim_card')
                <a href="{{ route('admin.asign.lineas') }}">
                    <button
                        class="btn btnAsignar bg-emerald-500 hover:bg-emerald-600 text-white btn border-slate-200 hover:border-slate-300">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Asignar Sim Card a Linea</span>
                    </button>
                </a>
            @endcan

        </div>

    </div>
    <!-- More actions -->

    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Delete button -->
            <div class="table-items-action hidden">
                <div class="flex items-center">
                    <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                            class="table-items-count"></span> items selected</div>
                    <button
                        class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Eliminar</button>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="relative float-right" x-data="{ open: false, selected: 4 }">
                <button
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
                                :class="selected !== 3 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
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
            @can('exportar-sim_card')
                <div class="relative inline-flex">
                    <a href="{{ route('admin.export.lineas') }}">
                        <button
                            class="btn bg-emerald-600 hover:bg-emerald-700 text-white btn border-slate-200 hover:border-slate-300">
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
            {{-- <div class="relative inline-flex">
                <button wire:click="openModalImport()" aria-controls="basic-modal"
                    class="btn bg-blue-600 hover:bg-blue-700 text-white btn border-slate-200 hover:border-slate-300">
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
            </div> --}}
        </div>
        <!-- Left side -->

        <div class="mb-4 sm:mb-0 text-slate-500" x-data="{ clickeado: 0 }">
            <ul class="flex flex-wrap -m-1">
                <li class="m-1">
                    <button wire:click="operador()"
                        :class="clickeado === 0 && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                        @click="clickeado = 0"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white duration-150 ease-in-out">
                        Todas
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="operador('claro')"
                        :class="clickeado === 1 && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                        @click="clickeado = 1"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white duration-150 ease-in-out">
                        Claro
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="operador('entel')"
                        :class="clickeado === 2 && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                        @click="clickeado = 2"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white duration-150 ease-in-out">
                        Entel
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="operador('movistar')"
                        :class="clickeado === 3 && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                        @click="clickeado = 3"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white duration-150 ease-in-out">
                        Movistar
                    </button>
                </li>
            </ul>
        </div>

    </div>
    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Total lineas <span
                    class="text-slate-400 font-medium">{{ $lineas->total() }}</span>
            </h2>

        </header>
        <div x-data="handleSelect">
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
                                        <span class="sr-only">Selecionar Todo</span>
                                        <input id="parent-checkbox" class="form-checkbox" type="checkbox"
                                            @click="toggleAll" />
                                    </label>
                                </div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">NUMERO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">OPERADOR</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">SIM CARD</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">EMPRESA ACTUAL</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">PLACA</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">ESTADO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">SIM CARD ANTERIOR</div>
                            </th>


                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Accioness</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        @if ($lineas->count())
                            @foreach ($lineas as $linea)
                                <tr>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center">
                                            <label class="inline-flex">
                                                <span class="sr-only">Select</span>
                                                <input class="table-item form-checkbox" type="checkbox"
                                                    @click="uncheckParent" />
                                            </label>
                                        </div>
                                    </td>

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
                                            @if (!empty($linea->numero))
                                                <div class="font-medium text-slate-800">#{{ $linea->numero }}</div>
                                            @else
                                                <div class="font-medium text-slate-800"></div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        <div class="text-left">{{ $linea->operador }}</div>

                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @if (!empty($linea->sim_card))
                                            <div class="text-left font-medium text-slate-800">
                                                {{ $linea->sim_card->sim_card }}</div>
                                        @else
                                            <div class="text-left font-medium text-red-300">SIN ASIGNAR</div>
                                        @endif


                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-left font-medium text-slate-800">

                                        </div>
                                        @if (!empty($linea->sim_card))
                                            <div class="text-left font-medium text-slate-800">
                                                @if (!empty($linea->sim_card->vehiculos))
                                                    {{ $linea->sim_card->vehiculos->cliente->razon_social }}
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-left font-medium text-red-300"></div>
                                        @endif


                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-left font-medium text-slate-800">

                                        </div>
                                        @if (!empty($linea->sim_card))
                                            <div class="text-left font-medium text-slate-800">
                                                @if (!empty($linea->sim_card->vehiculos))
                                                    {{ $linea->sim_card->vehiculos->placa }}
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-left font-medium text-red-300"></div>
                                        @endif


                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        @if ($linea->estado->name == 'SUSPENDIDA')
                                            <div class="font-medium text-red-500">
                                                @php
                                                    $dias = $linea->now->diffInDays($linea->date_to_suspend);
                                                @endphp

                                                Suspendido <br>

                                                @if ($dias > 0)
                                                    {{ $dias }} Dias Restantes
                                                @else
                                                    -
                                                @endif

                                            </div>
                                        @else
                                            <div class="font-medium text-emerald-500">
                                                {{ $linea->estado->name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        <div class="text-left font-medium text-slate-800">
                                            {{ $linea->old_sim_card }}
                                        </div>
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="relative inline-flex" x-data="{ open: false }">
                                            <div class="relative inline-block h-full text-left">
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                    :class="{ 'bg-slate-100 text-slate-500': open }"
                                                    aria-haspopup="true" @click.prevent="open = !open"
                                                    :aria-expanded="open">
                                                    <span class="sr-only">Menu</span>
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <circle cx="16" cy="16" r="2" />
                                                        <circle cx="10" cy="16" r="2" />
                                                        <circle cx="22" cy="16" r="2" />
                                                    </svg>
                                                </button>
                                                <div class="origin-top-right  z-10 absolute transform  -translate-x-3/4  top-full left-0 min-w-36 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1  ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                                                    @click.outside="open = false"
                                                    @keydown.escape.window="open = false" x-show="open"
                                                    x-transition:enter="transition ease-out duration-200 transform"
                                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-out duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" x-cloak>

                                                    <ul>
                                                        @if ($linea->fecha_suspencion)
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    class="text-gray-300 cursor-not-allowed group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="true" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor"
                                                                        class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                    Suspender
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="activar({{ $linea->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-33"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor"
                                                                        class="h-5 w-5  mr-3 text-gray-400 group-hover:text-green-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                        </path>
                                                                    </svg>
                                                                    Activar
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="suspender({{ $linea->id }})"
                                                                    class="text-gray-700 disabled group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="true" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor"
                                                                        class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                    Suspender
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="activar({{ $linea->id }})"
                                                                    class="text-gray-300 cursor-not-allowed group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-33"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor"
                                                                        class="h-5 w-5  mr-3 text-gray-400 group-hover:text-green-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                        </path>
                                                                    </svg>
                                                                    Activar
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>


                                                </div>
                                            </div>

                                        </div>

                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
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
        {{ $lineas->links() }}

    </div>
</div>
