<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Cuentas por Pagar ✨</h1>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <x-form.input wire:model.live="search" placeholder="Buscar cuenta..." icon="magnifying-glass" />
    </div>

    <!-- Filters -->
    <div class="sm:flex sm:justify-between sm:items-center mb-4">
        <div class="flex items-center gap-2">
            <!-- Date filter -->
            <div class="relative inline-flex" x-data="{ open: false, selected: 4 }">
                <button
                    class="btn justify-between min-w-[120px] bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100"
                    aria-label="Select date range" aria-haspopup="true" @click.prevent="open = !open"
                    :aria-expanded="open">
                    <span class="flex items-center">
                        <svg class="shrink-0 mr-2 fill-current text-gray-500" width="16" height="16"
                            viewBox="0 0 16 16">
                            <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                            <path
                                d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                        </svg>
                        <span
                            x-text="{
                            1: 'Hoy',
                            7: 'Últimos 7 días',
                            30: 'Últimos 30 días',
                            4: 'Todas las Fechas'
                        }[selected]"></span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-gray-400" width="11" height="7"
                        viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="z-10 absolute top-full left-0 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <button
                        class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3 cursor-pointer"
                        :class="selected === 1 && 'text-violet-500'"
                        @click="selected = 1; open = false; $wire.filter(1)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 1 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Hoy</span>
                    </button>
                    <button
                        class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3 cursor-pointer"
                        :class="selected === 7 && 'text-violet-500'"
                        @click="selected = 7; open = false; $wire.filter(7)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 7 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Últimos 7 días</span>
                    </button>
                    <button
                        class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3 cursor-pointer"
                        :class="selected === 30 && 'text-violet-500'"
                        @click="selected = 30; open = false; $wire.filter(30)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 30 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Últimos 30 días</span>
                    </button>
                    <button
                        class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3 cursor-pointer"
                        :class="selected === 4 && 'text-violet-500'"
                        @click="selected = 4; open = false; $wire.filter(0)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 4 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Todas las Fechas</span>
                    </button>
                </div>
            </div>

            <!-- Estado filter -->
            <x-form.select placeholder="Todos los Estados" wire:model.live="estado_filter">
                <x-select.option label="Todos los Estados" value="" />
                <x-select.option label="Pendiente" value="PENDIENTE" />
                <x-select.option label="Parcial" value="PARCIAL" />
                <x-select.option label="Pagado" value="PAGADO" />
                <x-select.option label="Vencido" value="VENCIDO" />
            </x-form.select>

            <!-- Proveedor filter -->
            <x-form.select placeholder="Todos los Proveedores" wire:model.live="proveedor_id"
                option-description="numero_documento" :async-data="route('api.proveedores.index')" option-label="razon_social" option-value="id" />
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 relative">
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Proveedor</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Documento</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Emisión</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Vencimiento</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Total</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Pagado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Pendiente</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Estado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Acciones</div>
                        </th>
                    </tr>
                </thead>
                <tbody
                    class="text-sm divide-y divide-gray-200 dark:divide-gray-700 border-b border-gray-200 dark:border-gray-700">
                    @forelse($cuentas as $cuenta)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">
                                    {{ $cuenta->proveedor->nombre }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100">{{ $cuenta->numero_documento }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100">
                                    {{ $cuenta->fecha_emision->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100">
                                    {{ $cuenta->fecha_vencimiento->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right text-gray-900 dark:text-gray-100">S/
                                    {{ number_format($cuenta->monto_total, 2) }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right text-emerald-600 dark:text-emerald-400">S/
                                    {{ number_format($cuenta->monto_pagado, 2) }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right text-rose-600 dark:text-rose-400">S/
                                    {{ number_format($cuenta->saldo_pendiente, 2) }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex justify-center">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $cuenta->estado->statusColor() }}">
                                        {{ $cuenta->estado->value }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($cuenta->estado->value !== 'PAGADO')
                                        <button wire:click="registrarPago({{ $cuenta->id }})"
                                            class="text-emerald-400 hover:text-emerald-600 dark:text-emerald-500 dark:hover:text-emerald-400"
                                            title="Registrar Pago">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-10 text-center">
                                <div class="text-gray-400 dark:text-gray-500">
                                    <svg class="inline-block w-12 h-12 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="font-medium">No se encontraron cuentas por pagar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $cuentas->links() }}
    </div>
</div>
