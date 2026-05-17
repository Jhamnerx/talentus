<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Loading Overlay para exportaciones -->
    <div wire:loading wire:target="exportExcel,exportPdf"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex flex-col items-center shadow-xl">
            <svg class="animate-spin h-12 w-12 text-indigo-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <p class="text-gray-700 dark:text-gray-300 font-medium">Generando archivo...</p>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Por favor espere</p>
        </div>
    </div>

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Compras ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative" @submit.prevent>
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                    type="search" placeholder="Buscar Factura…" />
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
            @can('crear-compras_facturas')
                <a href="{{ route('admin.compras.create') }}">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Registrar Factura</span>
                    </button>
                </a>
            @endcan

            <!-- Export Buttons -->
            <div class="relative inline-flex" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300"
                    aria-haspopup="true" :aria-expanded="open">
                    <svg class="w-4 h-4 fill-current text-gray-500 dark:text-gray-400 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M9 7V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1H9z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Exportar</span>
                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400" viewBox="0 0 12 12">
                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="origin-top-right z-10 absolute top-full right-0 min-w-52 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                    @click.away="open = false" style="display: none;">
                    <div
                        class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase px-3 py-1.5 border-b border-gray-200 dark:border-gray-700">
                        Exportar como
                    </div>
                    <ul>
                        <li>
                            <button wire:click="exportExcel" wire:loading.attr="disabled" wire:target="exportExcel"
                                class="w-full text-left font-medium text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center py-2 px-3 transition-colors">
                                <svg class="w-4 h-4 fill-current text-green-600 dark:text-green-400 shrink-0 mr-2"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M14 0H2C.9 0 0 .9 0 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V2c0-1.1-.9-2-2-2zM5 13H3V3h2v10zm3 0H6V3h2v10zm3 0H9V3h2v10zm3 0h-2V3h2v10z" />
                                </svg>
                                <span>Excel (.xlsx)</span>
                                <span wire:loading wire:target="exportExcel" class="ml-auto">
                                    <svg class="animate-spin h-3 w-3 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button wire:click="exportPdf" wire:loading.attr="disabled" wire:target="exportPdf"
                                class="w-full text-left font-medium text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center py-2 px-3 transition-colors">
                                <svg class="w-4 h-4 fill-current text-red-600 dark:text-red-400 shrink-0 mr-2"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M14.9 5.7L10.3 1.1C10 .8 9.7.7 9.3.7H2c-.6 0-1 .4-1 1v12.6c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V6.7c0-.4-.1-.7-.4-1zm-5.2 7.6H6.3c-.3 0-.5-.2-.5-.5s.2-.5.5-.5h3.4c.3 0 .5.2.5.5s-.2.5-.5.5zm0-2.3H6.3c-.3 0-.5-.2-.5-.5s.2-.5.5-.5h3.4c.3 0 .5.2.5.5s-.2.5-.5.5zm0-2.3H6.3c-.3 0-.5-.2-.5-.5s.2-.5.5-.5h3.4c.3 0 .5.2.5.5s-.2.5-.5.5zm.5-2.3H10V2.3l3.7 3.7h-3.5c-.3 0-.5-.2-.5-.5V5.4z" />
                                </svg>
                                <span>PDF (.pdf)</span>
                                <span wire:loading wire:target="exportPdf" class="ml-auto">
                                    <svg class="animate-spin h-3 w-3 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </li>
                    </ul>
                    <div
                        class="text-xs text-gray-400 dark:text-gray-500 px-3 py-2 border-t border-gray-200 dark:border-gray-700">
                        @if ($search || $formaPago || $estadoPago)
                            <span class="text-indigo-600 dark:text-indigo-400">✓</span> Incluye filtros aplicados
                        @else
                            Exportando {{ $compras->total() }} registros
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Filters -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start gap-2">

            <!-- Filtro Forma de Pago -->
            <div class="w-48">
                <x-form.select label="Forma de Pago" wire:model.live="formaPago" :options="[
                    ['name' => 'Todos', 'id' => ''],
                    ['name' => 'Contado', 'id' => 'CONTADO'],
                    ['name' => 'Crédito', 'id' => 'CREDITO'],
                ]"
                    option-label="name" option-value="id" />
            </div>

            <!-- Filtro Estado de Pago -->
            <div class="w-48">
                <x-form.select label="Estado de Pago" wire:model.live="estadoPago" :options="[
                    ['name' => 'Todos', 'id' => ''],
                    ['name' => 'Pagado', 'id' => 'pagado'],
                    ['name' => 'Pendiente', 'id' => 'pendiente'],
                    ['name' => 'Parcial', 'id' => 'parcial'],
                ]"
                    option-label="name" option-value="id" />
            </div>

        </div>

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            @if ($formaPago || $estadoPago || $search)
                <x-form.button flat label="Limpiar Filtros"
                    wire:click="$set('formaPago', ''); $set('estadoPago', ''); $set('search', '')" />
            @endif
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
        <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                        Facturas Compras
                        <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $compras->total() }}</span>
                    </h2>
                    <div class="flex gap-4 mt-2 text-xs">
                        @php
                            $totalGeneral = $compras->sum('total');
                            $totalPagado = $compras->sum('total_pagado');
                            $totalPendiente = $totalGeneral - $totalPagado;
                        @endphp
                        <span class="text-blue-600 dark:text-blue-400">
                            Total: S/ {{ number_format($totalGeneral, 2) }}
                        </span>
                        <span class="text-green-600 dark:text-green-400">
                            Pagado: S/ {{ number_format($totalPagado, 2) }}
                        </span>
                        <span class="text-red-600 dark:text-red-400">
                            Pendiente: S/ {{ number_format($totalPendiente, 2) }}
                        </span>
                    </div>
                </div>

                @if ($formaPago || $estadoPago)
                    <div class="flex gap-2 text-xs">
                        @if ($formaPago)
                            <x-form.badge flat info label="Forma: {{ $formaPago }}" />
                        @endif
                        @if ($estadoPago)
                            <x-form.badge flat info label="Estado: {{ ucfirst($estadoPago) }}" />
                        @endif
                    </div>
                @endif
            </div>
        </header>
        <div>

            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">
                <table class="table-auto w-full dark:text-gray-300">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-100 dark:border-gray-700/60">
                        <tr>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">FECHA EMISION</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">F. VENCIMIENTO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">PROVEEDOR</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">COMPROBANTE</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">PRODUCTOS</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">FORMA PAGO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">IGV</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">TOTAL</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">ESTADO PAGO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">OPCIONES</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        <!-- Row -->
                        @foreach ($compras as $compra)
                            <tr class="{{ $compra->estado == 'ANULADO' ? 'opacity-50' : '' }}">

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>{{ $compra->fecha_emision->format('d-m-Y') }}</div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if ($compra->fecha_vencimiento)
                                        @php
                                            $esVencido = now()->greaterThan($compra->fecha_vencimiento);
                                            $diasRestantes = now()->diffInDays($compra->fecha_vencimiento, false);
                                        @endphp
                                        <div
                                            class="flex items-center {{ $esVencido && $compra->forma_pago == 'CREDITO' && !$compra->isPaid() ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-800 dark:text-gray-100' }}">
                                            @if ($esVencido && $compra->forma_pago == 'CREDITO' && !$compra->isPaid())
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                            {{ $compra->fecha_vencimiento->format('d-m-Y') }}
                                        </div>
                                        @if ($compra->forma_pago == 'CREDITO' && !$compra->isPaid())
                                            <div
                                                class="text-xs {{ $esVencido ? 'text-red-500 dark:text-red-400' : ($diasRestantes <= 7 ? 'text-orange-500 dark:text-orange-400' : 'text-gray-500 dark:text-gray-400') }}">
                                                @if ($esVencido)
                                                    Vencido hace {{ abs($diasRestantes) }} días
                                                @else
                                                    Vence en {{ $diasRestantes }} días
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $compra->proveedor->razon_social }}
                                    </div>
                                    <div class="font-sm text-gray-700 dark:text-gray-300">
                                        <p class="text-xs">
                                            {{ $compra->proveedor->numero_documento }}
                                        </p>

                                    </div>

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                    <div
                                        class="font-medium {{ $compra->estado == 'ANULADO' ? 'text-red-600 dark:text-red-400' : 'text-sky-500 dark:text-sky-400' }}">
                                        {{ $compra->serie_correlativo }}

                                    </div>
                                    <div class="font-sm text-gray-700 dark:text-gray-300">
                                        <p class="text-xs">
                                            {{ $compra->tipoComprobante ? $compra->tipoComprobante->descripcion : '' }}
                                        </p>

                                    </div>

                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3  text-center">

                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <button aria-haspopup="true" @click.prevent="open = !open"
                                            :aria-expanded="open"
                                            class="outline-none inline-flex justify-center items-center group hover:shadow-sm focus:ring-offset-background-white dark:focus:ring-offset-background-dark transition-all ease-in-out duration-200 focus:ring-2 disabled:opacity-80 disabled:cursor-not-allowed text-sky-600 border border-sky-600 hover:bg-opacity-25 dark:hover:bg-opacity-15 hover:text-sky-700 hover:bg-sky-400 dark:hover:text-sky-500 dark:hover:bg-sky-600 focus:bg-opacity-25 focus:border-transparent dark:focus:border-transparent dark:focus:bg-opacity-15 focus:ring-offset-0 focus:text-sky-700 focus:bg-sky-400 focus:ring-sky-600 dark:focus:text-sky-500 dark:focus:bg-sky-600 dark:focus:ring-sky-700 rounded-md gap-x-2 text-sm px-4 py-2"
                                            type="button">
                                            <svg class="w-4 h-4 shrink-0" stroke="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M2.03555 12.3224C1.96647 12.1151 1.9664 11.8907 2.03536 11.6834C3.42372 7.50972 7.36079 4.5 12.0008 4.5C16.6387 4.5 20.5742 7.50692 21.9643 11.6776C22.0334 11.8849 22.0335 12.1093 21.9645 12.3166C20.5761 16.4903 16.6391 19.5 11.9991 19.5C7.36119 19.5 3.42564 16.4931 2.03555 12.3224Z"
                                                    stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </path>
                                                <path
                                                    d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                                    stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                </path>
                                            </svg>
                                        </button>

                                        <div class="origin-top-left z-20 absolute top-full -left-4 min-w-44 bg-white dark:bg-gray-800 border border-slate-300 dark:border-gray-700 py-1.5 rounded shadow-xl overflow-hidden mt-1"
                                            @click.outside="open = false" @keydown.escape.window="open = false"
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-200 transform"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-out duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            x-cloak>
                                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                <thead
                                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3">
                                                            #
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Nombre
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Cantidad/Precio
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Total
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($compra->detalle as $key => $detalle)
                                                        <tr
                                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                            <th scope="row"
                                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">

                                                                {{ $key + 1 }}

                                                            </th>
                                                            <td class="px-6 py-4">
                                                                {{ $detalle->descripcion }}
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $detalle->cantidad }} |
                                                                {{ $compra->divisa == 'PEN' ? 'S/ ' : '$' }}{{ round($detalle->precio, 2) }}
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $compra->divisa == 'PEN' ? 'S/ ' : '$' }}
                                                                {{ round($detalle->importe_total, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </td>

                                {{-- FORMA DE PAGO --}}
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if ($compra->forma_pago == 'CREDITO')
                                            <x-form.badge flat warning label="CRÉDITO" />
                                            @if ($compra->numero_cuotas > 0)
                                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">
                                                    ({{ $compra->numero_cuotas }} cuotas)
                                                </span>
                                            @endif
                                        @else
                                            <x-form.badge flat positive label="CONTADO" />
                                        @endif
                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium">

                                        {{ $compra->divisa == 'PEN' ? 'S/ ' : '$' }} {{ $compra->igv }}

                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">

                                        {{ $compra->divisa == 'PEN' ? 'S/ ' : '$' }}
                                        {{ number_format($compra->total, 2) }}

                                    </div>
                                </td>

                                {{-- ESTADO DE PAGO --}}
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if ($compra->estado == 'ANULADO')
                                        <x-form.badge flat negative label="ANULADO" />
                                    @else
                                        @php
                                            $totalPagado = $compra->total_pagado;
                                            $saldo = $compra->saldo_pendiente;
                                            $porcentajePagado =
                                                $compra->total > 0 ? ($totalPagado / $compra->total) * 100 : 0;
                                        @endphp

                                        <div class="space-y-1">
                                            @if ($compra->isPaid())
                                                <x-form.badge flat positive label="PAGADO" />
                                            @elseif($totalPagado > 0)
                                                <x-form.badge flat warning label="PARCIAL" />
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    Pagado:
                                                    {{ $compra->divisa == 'PEN' ? 'S/ ' : '$' }}{{ number_format($totalPagado, 2) }}
                                                </div>
                                                <div class="text-xs text-red-600 dark:text-red-400">
                                                    Saldo:
                                                    {{ $compra->divisa == 'PEN' ? 'S/ ' : '$' }}{{ number_format($saldo, 2) }}
                                                </div>
                                            @else
                                                <x-form.badge flat negative label="PENDIENTE" />
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    Debe:
                                                    {{ $compra->divisa == 'PEN' ? 'S/ ' : '$' }}{{ number_format($compra->total, 2) }}
                                                </div>
                                            @endif

                                            @if (!$compra->isPaid() && $porcentajePagado > 0)
                                                <div
                                                    class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-1">
                                                    <div class="bg-blue-600 h-1.5 rounded-full"
                                                        style="width: {{ $porcentajePagado }}%"></div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex gap-1">

                                        <x-form.button 2xs secondary label="Editar" icon="pencil"
                                            href="{{ route('admin.compras.edit', $compra) }}" />

                                        @if ($compra->estado !== 'ANULADO')
                                            <x-form.button 2xs negative label="Anular" icon="trash"
                                                spinner="anularCompra({{ $compra->id }})"
                                                wire:click.prevent="anularCompra({{ $compra->id }})" />
                                        @endif

                                        @if (!$compra->isPaid() && $compra->estado !== 'ANULADO')
                                            <x-form.button 2xs positive label="Pagos" icon="currency-dollar"
                                                wire:click="verPagos({{ $compra->id }})" />
                                        @endif

                                    </div>
                                </td>

                            </tr>
                        @endforeach

                        @if ($compras->count() < 1)
                            <tr>
                                <td colspan="10"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center text-gray-500 dark:text-gray-400">No hay Registros</div>
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
        {{ $compras->links() }}
        {{-- @include('admin.partials.pagination-classic') --}}

    </div>

    <!-- Modal de pagos -->
    @livewire('admin.compras.register-payment')

</div>
