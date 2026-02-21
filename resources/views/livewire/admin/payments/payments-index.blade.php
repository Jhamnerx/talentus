<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Pagos ✨</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Total de Pagos: <span
                    class="font-semibold">{{ $payments->count() > 0 ? number_format($total, 2) : '0.00' }}</span>
            </p>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <div class="w-64">
                <x-search-form wire:model.live="search" placeholder="Buscar Pagos" />
            </div>

            <!-- Add payment button -->
            @can('crear-payments')
                <x-form.button wire:click="openModalCreate" primary label="Agregar Pago" icon="plus"
                    spinner="openModalCreate" />
            @endcan
        </div>
    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <!-- Left side - Filters -->
        <div class="mb-4 sm:mb-0">
            <div class="flex flex-wrap gap-2">
                <!-- Filtro por divisa -->
                <div class="w-48">
                    <x-form.select label="Divisa" wire:model.live="divisa" placeholder="Todas las divisas">
                        <x-select.option label="Todas las divisas" />
                        <x-select.option label="Soles (PEN)" value="PEN" />
                        <x-select.option label="Dólares (USD)" value="USD" />
                    </x-form.select>
                </div>

                <!-- Filtro por método de pago -->
                <div class="w-64">
                    <x-form.select label="Método de Pago" wire:model.live="payment_method_id"
                        placeholder="Todos los métodos" :async-data="[
                            'api' => route('api.metodos.pago.index'),
                        ]" option-label="description"
                        option-value="id" />
                </div>

                <!-- Rango de fechas -->
                <div class="w-48">
                    <x-form.datetime.picker label="Desde" wire:model.live="from" without-time />
                </div>
                <div class="w-48">
                    <x-form.datetime.picker label="Hasta" wire:model.live="to" without-time />
                </div>

            </div>
        </div>

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Export button -->
            @can('exportar-payments')
                <x-form.button flat label="Exportar" wire:click="openExportModal" icon="arrow-down-tray" />
            @endcan

            <!-- Dropdown -->
            <div class="relative float-right" x-data="{ open: false, selected: 4 }">
                <button wire:ignore
                    class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300"
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
                </button>
                <div class="z-10 absolute top-full right-0 min-w-50 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <div class="font-medium text-sm text-gray-600 dark:text-gray-300" x-ref="options">
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3 cursor-pointer"
                            :class="selected === 0 && 'text-violet-500'" @click="selected = 0;open = false"
                            @focus="open = true" @focusout="open = false" wire:click="filter(1)">
                            <svg class="w-3 h-3 shrink-0 fill-current text-violet-500 mr-2"
                                :class="selected !== 0 && 'invisible'" viewBox="0 0 12 12">
                                <path
                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                            </svg>
                            <span>Hoy</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3 cursor-pointer"
                            :class="selected === 1 && 'text-violet-500'" @click="selected = 1;open = false"
                            @focus="open = true" @focusout="open = false" wire:click="filter(7)">
                            <svg class="w-3 h-3 shrink-0 fill-current text-violet-500 mr-2"
                                :class="selected !== 1 && 'invisible'" viewBox="0 0 12 12">
                                <path
                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                            </svg>
                            <span>Últimos 7 días</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3 cursor-pointer"
                            :class="selected === 2 && 'text-violet-500'" @click="selected = 2;open = false"
                            @focus="open = true" @focusout="open = false" wire:click="filter(30)">
                            <svg class="w-3 h-3 shrink-0 fill-current text-violet-500 mr-2"
                                :class="selected !== 2 && 'invisible'" viewBox="0 0 12 12">
                                <path
                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                            </svg>
                            <span>Últimos 30 días</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3 cursor-pointer"
                            :class="selected === 3 && 'text-violet-500'" @click="selected = 3;open = false"
                            @focus="open = true" @focusout="open = false" wire:click="filter(12)">
                            <svg class="w-3 h-3 shrink-0 fill-current text-violet-500 mr-2"
                                :class="selected !== 3 && 'invisible'" viewBox="0 0 12 12">
                                <path
                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                            </svg>
                            <span>Últimos 12 meses</span>
                        </button>
                        <button tabindex="0"
                            class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3 cursor-pointer"
                            :class="selected === 4 && 'text-violet-500'" @click="selected = 4;open = false"
                            @focus="open = true" @focusout="open = false" wire:click="filter(0)">
                            <svg class="w-3 h-3 shrink-0 fill-current text-violet-500 mr-2"
                                :class="selected !== 4 && 'invisible'" viewBox="0 0 12 12">
                                <path
                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                            </svg>
                            <span>Seleccionar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Total Pagos <span
                    class="text-gray-400 dark:text-gray-500 font-medium">{{ $payments->total() }}</span>
            </h2>
        </header>
        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-gray-300">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Número</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">N° Operación</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Monto</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Método de Pago</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Documento</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Cobro/Vehículo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Acciones</div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                    @forelse($payments as $payment)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">{{ $payment->numero }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div>{{ $payment->fecha?->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div>{{ $payment->numero_operacion ?? '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-right">
                                    {{ $payment->divisa }} {{ number_format($payment->monto, 2) }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3">
                                <div>{{ $payment->paymentMethod?->description ?? '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3">
                                @if ($payment->paymentable_type === 'App\\Models\\Ventas')
                                    @php
                                        $tipoDoc =
                                            $payment->paymentable->tipo_comprobante_id === '01'
                                                ? 'FACTURA'
                                                : ($payment->paymentable->tipo_comprobante_id === '03'
                                                    ? 'BOLETA'
                                                    : 'DOCUMENTO');
                                    @endphp
                                    <div class="text-xs">
                                        <span class="font-semibold">{{ $tipoDoc }}</span><br>
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ $payment->paymentable->serie_correlativo }}</span>
                                    </div>
                                @elseif($payment->paymentable_type === 'App\\Models\\Recibos')
                                    <div class="text-xs">
                                        <span class="font-semibold">RECIBO</span><br>
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ $payment->paymentable->serie_numero }}</span>
                                    </div>
                                @else
                                    <div>{{ $payment->documento ?? '-' }}</div>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3">
                                @if ($payment->cobros)
                                    <div class="flex flex-col gap-1">
                                        <x-form.badge flat positive label="Con Cobro" />
                                        @if ($payment->cobros->vehiculo)
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                <span
                                                    class="font-semibold">{{ $payment->cobros->vehiculo->placa }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-xs text-gray-400">Sin cobro</div>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex justify-center items-center gap-1">
                                    @can('editar-payments')
                                        <button wire:click="editPayment({{ $payment->id }})"
                                            class="btn btn-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-violet-500">
                                            Editar
                                        </button>
                                    @endcan
                                    @can('eliminar-payments')
                                        <button wire:click="deletePayment({{ $payment->id }})"
                                            class="btn btn-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-red-500">
                                            Eliminar
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="px-2 first:pl-5 last:pr-5 py-8 text-center text-gray-500 dark:text-gray-400">
                                No hay pagos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $payments->links() }}
    </div>

    <!-- Modales -->

</div>
