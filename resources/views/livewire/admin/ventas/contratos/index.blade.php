<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Contratos ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search" class="form-input pl-9 focus:border-slate-300"
                    type="search" placeholder="Buscar contrato…" />
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

            <!-- Create invoice button -->
            @can('crear-contrato')
                <a href="{{ route('admin.ventas.contratos.create') }}">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Crear Contrato</span>
                    </button>
                </a>
            @endcan


        </div>

    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">


        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">



        </div>

    </div>


    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Contratos <span
                    class="text-slate-400 font-medium">{{ $contratos->total() }}</span>
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
                            @can('descargar-contrato')
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-center">Descargar</div>
                                </th>
                            @endcan

                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Cliente</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Vehiculos - Plan</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Ciudad</div>
                            </th>
                            @can('caracteristicas-contrato')
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Caracteristicas</div>
                                </th>
                            @endcan
                            @can('cambiar.estado-contrato')
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Estado</div>
                                </th>
                            @endcan

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Emitido el</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Emitido por</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Acciones</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        @if ($contratos->count())
                            @foreach ($contratos as $contrato)
                                <tr wire:key="c-{{ $contrato->id }}">
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center">
                                            <label class="inline-flex">
                                                <span class="sr-only">Select</span>
                                                <input class="table-item form-checkbox" type="checkbox" />
                                            </label>
                                        </div>
                                    </td>
                                    @can('descargar-contrato')
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <div class="space-x-1 text-center">
                                                <a target="_blank" href="{{ route('admin.pdf.contratos', $contrato) }}">
                                                    <button class="text-talentus-200 hover:text-talentus-100 rounded-full">
                                                        <span class="sr-only">Descargar</span>
                                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                            <path
                                                                d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
                                                        </svg>
                                                    </button>
                                                </a>

                                            </div>
                                        </td>
                                    @endcan

                                    <td class="px-2 first:pl-5 last:pr-5 py-3">
                                        <div class="font-medium text-slate-800">{{ $contrato->cliente->razon_social }}
                                        </div>
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        <!-- Start -->
                                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                            @mouseleave="open = false">
                                            <button class="btn border-slate-200 hover:border-slate-300 text-slate-600"
                                                aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                                                @focusout="open = false" @click.prevent>
                                                <span class="mr-2">Ver vehiculos
                                                    @if (!$contrato->detalle->isEmpty())
                                                        ({{ $contrato->detalle->count() }})
                                                    @endif


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
                                                            <b>VEHICULOS</b>
                                                        </div>
                                                        <div
                                                            class="relative overflow-y-auto overflow-x-auto shadow-md sm:rounded-lg">
                                                            <table
                                                                class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                                <thead
                                                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                    <tr>
                                                                        <th scope="col" class="px-6 py-3">
                                                                            Placa
                                                                        </th>
                                                                        <th scope="col" class="px-6 py-3">
                                                                            Plan
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="a overflow-y-auto">

                                                                    @if ($contrato->detalle->isEmpty())
                                                                        <tr
                                                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                                                            <td colspan="2">NO SE REGISTRARON
                                                                                VEHICULOS</td>

                                                                        </tr>
                                                                    @else
                                                                        @foreach ($contrato->detalle as $detalle)
                                                                            <tr
                                                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                                <th scope="row"
                                                                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">

                                                                                    @if ($detalle->vehiculos)
                                                                                        {{ $detalle->vehiculos->placa }}
                                                                                    @else
                                                                                        -
                                                                                    @endif

                                                                                </th>
                                                                                <td class="px-6 py-4">
                                                                                    S/. {{ $detalle->plan }}
                                                                                </td>

                                                                            </tr>
                                                                        @endforeach
                                                                    @endif



                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="font-medium text-blue-500">AHF-960</div> --}}
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $contrato->ciudades->nombre }}</div>
                                    </td>
                                    @can('caracteristicas-contrato')
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 w-48">
                                            <div>
                                                <div class="m-3 w-48">
                                                    <!-- Start -->

                                                    @livewire('admin.ventas.contratos.status-sello', ['model' => $contrato, 'field' => 'sello'], key('sello' . $contrato->id))

                                                    @livewire('admin.ventas.contratos.status-fondo', ['model' => $contrato, 'field' => 'fondo'], key('fondo' . $contrato->id))
                                                    <!-- End -->
                                                </div>
                                            </div>
                                        </td>
                                    @endcan

                                    @can('cambiar.estado-contrato')
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div>
                                                <div class="m-3 ">
                                                    @livewire('admin.ventas.contratos.change-status', ['model' => $contrato, 'field' => 'estado'], key('estado' . $contrato->id))

                                                    <!-- End -->
                                                </div>
                                            </div>
                                        </td>
                                    @endcan
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div>{{ $contrato->created_at->format('d-m-Y') }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div>{{ $contrato->user->name }}</div>
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
                                                        @can('editar-contrato')
                                                            <li>
                                                                <a href="{{ route('admin.ventas.contratos.edit', $contrato) }}"
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
                                                        @endcan

                                                        @can('eliminar-contrato')
                                                            <li>
                                                                <a wire:click.prevent="openModalDelete({{ $contrato->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal cursor-pointer"
                                                                    disabled="false" id="headlessui-menu-item-28"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                        </path>
                                                                    </svg>
                                                                    Eliminar
                                                                </a>
                                                            </li>
                                                        @endcan


                                                        @can('enviar-contrato')
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click="modalOpenSend({{ $contrato->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-32"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        class="h-5 w-5 mr-3 text-gray-400 group-hover:text-cyan-600">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                                                                        </path>
                                                                    </svg> Enviar
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('crear-registro-contrato')
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click="createCobro({{ $contrato->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-32"
                                                                    role="menuitem" tabindex="-1">

                                                                    <svg class="h-5 w-5 mr-3 text-gray-400 group-hover:text-cyan-600"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <g fill="none" class="nc-icon-wrapper">
                                                                            <path
                                                                                d="M11.5 17.1c-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79z"
                                                                                fill="currentColor"></path>
                                                                        </g>
                                                                    </svg>
                                                                    Crear Registro de Cobro
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
        {{ $contratos->links() }}

    </div>


</div>
