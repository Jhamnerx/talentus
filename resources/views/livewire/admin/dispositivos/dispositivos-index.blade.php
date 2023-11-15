<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Dispositivos ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live="search" class="form-input pl-9 focus:border-slate-300" type="search"
                    placeholder="Buscar Dispositivo" />

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
            @can('crear-dispositivo')
                <a href="{{ route('admin.almacen.dispositivos.create') }}">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Añadir Dispositivo</span>
                    </button>
                </a>
            @endcan

            @can('ver.modelos-dispositivo')
                <a href="{{ route('admin.almacen.modelos-dispositivos') }}"
                    class="btn bg-emerald-500 hover:bg-emerald-600 text-white btn border-slate-200 hover:border-slate-300"
                    aria-controls="basic-modal">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">VER MODELOS GPS</span>
                </a>
            @endcan


        </div>

    </div>
    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Right side -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Delete button -->
                <div class="table-items-action hidden">
                    <div class="flex items-center">
                        <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                                class="table-items-count"></span>
                            items seleccionados</div>
                        <button
                            class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Eliminar</button>
                    </div>
                </div>
                <!-- Dropdown -->
                <div class="relative float-right" x-data="{ open: false, selected: 2 }">
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
                            <button wire:click="filter('STOCK')" tabindex="0"
                                class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                                :class="selected === 0 && 'text-indigo-500'" @click="selected = 0;open = false"
                                @focus="open = true" @focusout="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="selected !== 0 && 'invisible'" width="12" height="9"
                                    viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span>Disponibles</span>
                            </button>
                            <button wire:click="filter('VENDIDO')" tabindex="0"
                                class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                                :class="selected === 1 && 'text-indigo-500'" @click="selected = 1;open = false"
                                @focus="open = true" @focusout="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="selected !== 1 && 'invisible'" width="12" height="9"
                                    viewBox="0 0 12 9">
                                    <path
                                        d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                                </svg>
                                <span>Vendidos</span>
                            </button>


                            <button wire:click="filter(0)" tabindex="0"
                                class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                                :class="selected === 2 && 'text-indigo-500'" @click="selected = 2;open = false"
                                @focus="open = true" @focusout="open = false">
                                <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                    :class="selected !== 2 && 'invisible'" width="12" height="9"
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
                @can('exportar-dispositivo')
                    <div class="relative inline-flex">
                        <a href="{{ route('admin.export.dispositivos') }}">
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
                @can('importar-dispositivo')
                    @livewire('admin.dispositivos.import')
                @endcan

                <div class="relative inline-flex">

                    <button wire:click.prevent="consultaFota" wire:loading.attr="disabled"
                        wire:loading.class="bg-[#62abf3]" wire:loading.class.remove="hover:bg-[#0054A6] bg-[#477dd8]"
                        class="btn bg-[#4790d8] hover:bg-[#0054A6] text-white btn border-slate-200 hover:border-slate-300">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <g fill="currentColor" class="nc-icon-wrapper">
                                <path
                                    d="M22.707,8.293A1,1,0,0,0,21,9v6H17a17,17,0,0,0,0,34h9a2,2,0,0,0,0-4H17a13,13,0,0,1,0-26H31a1,1,0,0,0,.707-1.707Z">
                                </path>
                                <path data-color="color-2"
                                    d="M47,15H38a2,2,0,0,0,0,4h9a13,13,0,0,1,0,26H33a1,1,0,0,0-.707,1.707l9,9A1,1,0,0,0,42,56a.987.987,0,0,0,.383-.076A1,1,0,0,0,43,55V49h4a17,17,0,0,0,0-34Z">
                                </path>
                            </g>
                        </svg>
                        <span class="hidden xs:block ml-2">Consultar Fota</span>
                    </button>

                </div>
                <div class="relative inline-flex" wire:loading wire:target="consultaFota">
                    Consultando a fota web...
                </div>

            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Total dispositivos <span
                    class="text-slate-400 font-medium">{{ $dispositivos->total() }}</span>
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
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <span class="sr-only">Favorito</span>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">IMEI</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">MODELO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">MARCA</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">FOTA</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">VEHICULO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Registrado por:</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha registro:</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Accioness</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        @if ($dispositivos->count())
                            @foreach ($dispositivos as $dispositivo)
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
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center relative">
                                            <button>
                                                <svg class="w-4 h-4 shrink-0 fill-current text-yellow-500"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 0L6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934h-6L8 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 shrink-0 flex items-center justify-center bg-slate-100 rounded-full mr-2 sm:mr-3">
                                                @if ($dispositivo->modelo->image)
                                                    <img class="ml-1"
                                                        src="{{ Storage::url($dispositivo->modelo->image->url) }}.webp"
                                                        width="20" height="20" alt="Icon 01" />
                                                @else
                                                    {{-- <img class="ml-1"
                                            src="{{ Storage::url($dispositivo->modelo->image->url) }}.webp" width="20"
                                            height="20" alt="Icon 01" /> --}}
                                                @endif

                                            </div>
                                            @if ($dispositivo->of_client)
                                                <div class="font-medium text-blue-500">{{ $dispositivo->imei }}</div>
                                            @else
                                                <div class="font-medium text-slate-800">{{ $dispositivo->imei }}</div>
                                            @endif

                                        </div>
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-left">{{ $dispositivo->modelo->modelo }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-left">{{ $dispositivo->modelo->marca }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @if ($dispositivo->in_fota)
                                            <div class="text-left">

                                                <img width="60%"
                                                    src="https://fm.teltonika.lt//static/media/teltonikaFavicon.1d173e0a4f5b5a7d7471.ico"
                                                    alt="">

                                            </div>
                                        @endif

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        @if (!empty($dispositivo->vehiculos))
                                            <div class="font-medium text-sky-500">
                                                <a
                                                    href="{{ route('admin.vehiculos.edit', $dispositivo->vehiculos) }}">{{ $dispositivo->vehiculos->placa }}</a>
                                            </div>
                                        @else
                                            <div class="font-medium text-emerald-500">
                                                Equipo Disponible
                                            </div>
                                        @endif

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-left text-slate-800 text-sm">
                                            {{ $dispositivo->user ? $dispositivo->user->name : '' }}

                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="text-left text-slate-800 text-sm">
                                            {{ $dispositivo->created_at->format('d-m-Y h:m') }}

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

                                                        <li>
                                                            <a href="{{ route('admin.almacen.dispositivos.edit', $dispositivo) }}"
                                                                class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-27"
                                                                role="menuitem" tabindex="-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                    </path>
                                                                </svg> Editar

                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent="verInfoDispositivo({{ $dispositivo }}) "class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-29"
                                                                role="menuitem" tabindex="-1"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="h-5 w-5  mr-3 text-gray-400 group-hover:text-violet-500">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                    </path>
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                    </path>
                                                                </svg>
                                                                Ver Información
                                                            </a>
                                                        </li>

                                                    </ul>


                                                </div>
                                            </div>

                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        @else
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
        {{ $dispositivos->links() }}
        {{-- @include('admin.partials.pagination-classic') --}}

    </div>
</div>
