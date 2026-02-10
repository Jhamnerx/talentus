<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Cuentas por Cobrar ✨</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Lista de documentos con saldo pendiente de pago
            </p>
        </div>
    </div>

    <!-- Totals Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- Total por Cobrar Card -->
        <div
            class="bg-linear-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 border border-amber-200 dark:border-amber-700/50 rounded-lg p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-600 dark:text-amber-400">Total por Cobrar</p>
                    <p class="text-2xl font-bold text-amber-900 dark:text-amber-100 mt-1">
                        S/ {{ number_format($totales['total_por_cobrar'] ?? 0, 2) }}
                    </p>
                </div>
                <div class="p-3 bg-amber-200/50 dark:bg-amber-700/30 rounded-full">
                    <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Pagado Card -->
        <div
            class="bg-linear-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border border-emerald-200 dark:border-emerald-700/50 rounded-lg p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Total Pagado (Parcial)</p>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100 mt-1">
                        S/ {{ number_format($totales['total_pagado'] ?? 0, 2) }}
                    </p>
                </div>
                <div class="p-3 bg-emerald-200/50 dark:bg-emerald-700/30 rounded-full">
                    <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <!-- Search -->
            <div class="md:col-span-2">
                <x-form.input wire:model.live="search" placeholder="Buscar por número o cliente..."
                    icon="magnifying-glass" />
            </div>
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

            <!-- Tipo Documento filter -->
            <div>
                <x-form.select placeholder="Tipo" wire:model.live="tipo_documento">
                    <x-select.option label="Todos" value="" />
                    <x-select.option label="Facturas" value="ventas" />
                    <x-select.option label="Recibos" value="recibos" />
                </x-form.select>
            </div>

            <!-- Cliente filter -->
            <div>
                <x-form.select placeholder="Cliente" wire:model.live="cliente_id" option-description="numero_documento"
                    :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id" />
            </div>
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
                            <div class="font-semibold text-left">Cliente</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Documento</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Emisión</div>
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
                    @forelse($documentos as $doc)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">
                                    {{ $doc->cliente->razon_social ?? 'N/A' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $doc->cliente->numero_documento ?? '' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    @if ($doc->type === 'ventas')
                                        <span
                                            class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                            Factura
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                            Recibo
                                        </span>
                                    @endif
                                    <span class="text-gray-800 dark:text-gray-100">{{ $doc->numero_documento }}</span>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($doc->fecha_emision)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right text-gray-900 dark:text-gray-100">
                                    {{ $doc->divisa }} {{ number_format($doc->total, 2) }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right text-emerald-600 dark:text-emerald-400">
                                    {{ $doc->divisa }} {{ number_format($doc->total_pagado ?? 0, 2) }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right text-amber-600 dark:text-amber-400">
                                    {{ $doc->divisa }} {{ number_format($doc->total_pendiente ?? 0, 2) }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex justify-center">
                                    @php
                                        $estadoColor = match ($doc->pago_estado) {
                                            'PAID'
                                                => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
                                            'PARTIAL'
                                                => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
                                            'UNPAID' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            default
                                                => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                        };
                                        $estadoLabel = match ($doc->pago_estado) {
                                            'PAID' => 'Pagado',
                                            'PARTIAL' => 'Parcial',
                                            'UNPAID' => 'Pendiente',
                                            default => $doc->pago_estado,
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $estadoColor }}">
                                        {{ $estadoLabel }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($doc->pago_estado !== 'PAID')
                                        <button
                                            wire:click="$dispatch('open-modal-register-payment', { paymentable_type: '{{ $doc->type }}', paymentable_id: {{ $doc->id }} })"
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
                            <td colspan="8" class="px-2 first:pl-5 last:pr-5 py-10 text-center">
                                <div class="text-gray-400 dark:text-gray-500">
                                    <svg class="inline-block w-12 h-12 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="font-medium">No se encontraron documentos con saldo pendiente</p>
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
        {{ $documentos->links() }}
    </div>

</div>
