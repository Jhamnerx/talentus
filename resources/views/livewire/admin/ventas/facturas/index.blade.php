<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Facturas Ventas ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search" class="form-input pl-9 focus:border-slate-300"
                    type="search" placeholder="Buscar Factura…" />
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
            @can('crear-ventas-facturas')
                <a href="{{ route('admin.ventas.facturas.create') }}">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Crear Factura</span>
                    </button>
                </a>
            @endcan


        </div>

    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left side -->
        <div class="mb-4 sm:mb-0 text-slate-500" x-data="{ clickeado: 0 }">
            <ul class="flex flex-wrap -m-1">
                <li class="m-1">
                    <button wire:click="status()"
                        :class="clickeado === 0 && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                        @click="clickeado = 0"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white duration-150 ease-in-out">Todas
                        <span class="ml-1 text-indigo-200">{{ $totales['total'] }}</span></button>
                </li>
                <li class="m-1">
                    <button wire:click="status('PAID')"
                        :class="clickeado === 1 && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                        @click="clickeado = 1"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white duration-150 ease-in-out">Pagadas
                        <span class="ml-1 text-slate-400">{{ $totales['pagadas'] }}</span></button>
                </li>
                <li class="m-1">
                    <button wire:click="status('UNPAID')"
                        :class="clickeado === 2 && 'border-transparent shadow-sm bg-indigo-500 text-white'"
                        @click="clickeado = 2"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white duration-150 ease-in-out">Vencidas
                        <span class="ml-1 text-slate-400">{{ $totales['vencidas'] }}</span></button>
                </li>
            </ul>
        </div>

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Eliminar button -->
            <div class="table-items-action hidden">
                <div class="flex items-center">
                    <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                            class="table-items-count"></span> Items Seleccionados</div>
                    <button
                        class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Eliminar</button>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="relative float-right" x-data="{ open: false, selected: 4 }">
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
                                :class="selected !== 2 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
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

            <!-- Filter button -->
            <div class="relative inline-flex">
                <button
                    class="btn bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600">
                    <span class="sr-only">Filtro</span><wbr>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                        <path
                            d="M9 15H7a1 1 0 010-2h2a1 1 0 010 2zM11 11H5a1 1 0 010-2h6a1 1 0 010 2zM13 7H3a1 1 0 010-2h10a1 1 0 010 2zM15 3H1a1 1 0 010-2h14a1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Facturas ventas <span
                    class="text-slate-400 font-medium">{{ $totales['total'] }}</span>
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
                                        <input id="parent-checkbox" class="form-checkbox" type="checkbox"
                                            @click="toggleAll" />
                                    </label>
                                </div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Serie y Número</div>
                            </th>
                            @can('descargar-ventas-facturas')
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Descargar</div>
                                </th>
                            @endcan
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Cliente</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Tipo Venta</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Total</div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Emitido el</div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Vence el</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Estado</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Pagado el</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Acciones</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        @if ($facturas->count())
                            @foreach ($facturas as $factura)
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

                                        @if ($factura->estado == 'BORRADOR')
                                            <div class="font-medium text-red-500">
                                                <a href="{{ route('admin.ventas.facturas.show', $factura) }}">
                                                    {{ $factura->serie_numero }}
                                                </a>
                                            </div>
                                        @else
                                            <div class="font-medium text-sky-600">
                                                <a href="{{ route('admin.ventas.facturas.show', $factura) }}">
                                                    {{ $factura->serie_numero }}
                                                </a>
                                            </div>
                                        @endif

                                    </td>
                                    @can('descargar-ventas-facturas')
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="space-x-1">
                                                <a target="_blank" href="{{ route('admin.pdf.factura', $factura) }}">
                                                    <button class="text-slate-400 hover:text-slate-500 rounded-full">
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

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $factura->clientes->razon_social }}
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @if ($factura->tipo_venta == 'CREDITO')
                                            <div>
                                                <div class="relative inline-flex" x-data="{ open: false }">
                                                    <button class="inline-flex justify-center items-center group"
                                                        aria-haspopup="true" @click.prevent="open = !open"
                                                        :aria-expanded="open">
                                                        <div class="flex items-center truncate">
                                                            <span
                                                                class="truncate ml-2 text-sm font-medium group-hover:text-slate-800">
                                                                {{ $factura->tipo_venta }}
                                                            </span>
                                                            <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                                                viewBox="0 0 12 12">
                                                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                    <div class="origin-top-right z-10 absolute top-full left-0 min-w-44 bg-white border border-slate-300 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                                                        @click.outside="open = false"
                                                        @keydown.escape.window="open = false" x-show="open"
                                                        x-transition:enter="transition ease-out duration-200 transform"
                                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                                        x-transition:enter-end="opacity-100 translate-y-0"
                                                        x-transition:leave="transition ease-out duration-200"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0" x-cloak>
                                                        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200">
                                                            <div class="font-medium text-slate-800">Detalle de cuotas.
                                                            </div>
                                                            <div class="text-sm text-slate-600">
                                                                Adelanto:
                                                                {{ $factura->divisa == 'USD' ? "$ " . $factura->adelanto : 'S/. ' . $factura->adelanto }}
                                                            </div>

                                                        </div>
                                                        <table
                                                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                            <thead
                                                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                <tr>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        N° Cuota
                                                                    </th>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        Fecha
                                                                    </th>
                                                                    <th scope="col" class="px-6 py-3">
                                                                        Importe
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($factura->detalle_cuotas as $key => $cuota)
                                                                    <tr
                                                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                        <th scope="row"
                                                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">

                                                                            Cuota-{{ $key + 1 }}

                                                                        </th>
                                                                        <td class="px-6 py-4">
                                                                            {{ $cuota['fecha'] }}
                                                                        </td>
                                                                        <td class="px-6 py-4">
                                                                            {{ $cuota['importe'] }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- End -->
                                            </div>
                                        @else
                                            <div class="font-medium text-slate-800">
                                                {{ $factura->tipo_venta }}
                                            </div>
                                        @endif


                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-emerald-500">
                                            @if ($factura->divisa == 'PEN')
                                                S/. {{ $factura->total }}
                                            @else
                                                $ {{ $factura->total }}
                                            @endif

                                        </div>
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        <div>{{ $factura->fecha_emision->format('d-m-Y') }}</div>

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        <div>{{ $factura->fecha_vencimiento->format('d-m-Y') }}</div>

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                        @switch($factura->pago_estado)
                                            @case('PAID')
                                                <div
                                                    class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5">
                                                    PAGADA</div>
                                            @break

                                            @case('UNPAID')
                                                <div
                                                    class="inline-flex font-medium bg-rose-100 text-rose-500 rounded-full text-center px-2.5 py-0.5">
                                                    POR PAGAR</div>
                                            @break
                                        @endswitch

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div>
                                            @if ($factura->fecha_pago)
                                                {{ $factura->fecha_pago->format('d-m-Y') }}
                                            @else
                                            @endif

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
                                                        @can('editar-ventas-facturas')
                                                            <li>

                                                                <a href="{{ route('admin.ventas.facturas.edit', $factura) }}"
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
                                                        @can('eliminar-ventas-facturas')
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click.prevent="openModalDelete({{ $factura->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
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
                                                        @can('ver-ventas-facturas')
                                                            <li>
                                                                <a href="{{ route('admin.ventas.facturas.show', $factura) }}"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
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
                                                                    </svg> Ver
                                                                </a>
                                                            </li>
                                                        @endcan

                                                        @can('enviar-ventas-facturas')
                                                            <li>
                                                                <a href="javascript: void(0)"
                                                                    wire:click="modalOpenSend({{ $factura->id }})"
                                                                    class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                    disabled="false" id="headlessui-menu-item-32"
                                                                    role="menuitem" tabindex="-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor"
                                                                        class="h-5 w-5 mr-3 text-gray-400 group-hover:text-cyan-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                                                                        </path>
                                                                    </svg> Enviar
                                                                </a>
                                                            </li>
                                                        @endcan

                                                        @can('estados-ventas-facturas')
                                                            @if ($factura->pago_estado == 'PAID')
                                                                <li>
                                                                    <a href="javascript: void(0)"
                                                                        wire:click.prevent="markPaid({{ $factura->id }})"
                                                                        class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal cursor-default"
                                                                        disabled="true" id="headlessui-menu-item-33"
                                                                        role="menuitem" tabindex="-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor"
                                                                            class="h-5 w-5  mr-3 text-gray-300">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                            </path>
                                                                        </svg>
                                                                        Marcar como Pagada
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="javascript: void(0)"
                                                                        @click.prevent="open = !open"
                                                                        wire:click.prevent="markUnPaid({{ $factura->id }})"
                                                                        class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                        disabled="false" id="headlessui-menu-item-34"
                                                                        role="menuitem" tabindex="-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor"
                                                                            class="h-5 w-5  mr-3 text-gray-400 group-hover:text-red-400">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                            </path>
                                                                        </svg> Marcar como No Pagada
                                                                    </a>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a href="javascript: void(0)"
                                                                        @click.prevent="open = !open"
                                                                        wire:click.prevent="markPaid({{ $factura->id }})"
                                                                        class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                        disabled="false" id="headlessui-menu-item-33"
                                                                        role="menuitem" tabindex="-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor"
                                                                            class="h-5 w-5  mr-3 text-gray-400 group-hover:text-lime-500">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                            </path>
                                                                        </svg>
                                                                        Marcar como Pagada
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="javascript: void(0)"
                                                                        wire:click.prevent="markUnPaid({{ $factura->id }})"
                                                                        class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal cursor-default"
                                                                        disabled="true" id="headlessui-menu-item-34"
                                                                        role="menuitem" tabindex="-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke="currentColor"
                                                                            class="h-5 w-5  mr-3 text-gray-300">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                            </path>
                                                                        </svg> Marcar como No Pagada
                                                                    </a>
                                                                </li>
                                                            @endif
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
        {{ $facturas->links() }}
        {{-- @include('admin.partials.pagination-classic') --}}

    </div>

</div>
