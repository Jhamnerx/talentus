<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Transacciones 💳</h1>
        </div>
    </div>

    <!-- Selector de Periodo -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 mb-5">
        <div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
            <!-- Tipo de periodo -->
            <div class="lg:col-span-1">
                <x-form.select wire:model.live="period_type" label="Periodo">
                    <x-select.option label="Un mes" value="month" />
                    <x-select.option label="Rango meses" value="month_range" />
                    <x-select.option label="Una fecha" value="date" />
                    <x-select.option label="Rango fechas" value="date_range" />
                </x-form.select>
            </div>

            <!-- Inputs condicionales según tipo de periodo -->
            @if ($period_type === 'month')
                <div class="lg:col-span-2">
                    <x-form.input type="month" wire:model.live="month" label="Mes" />
                </div>
            @elseif ($period_type === 'month_range')
                <div class="lg:col-span-2">
                    <x-form.input type="month" wire:model.live="month_start" label="Mes inicio" />
                </div>
                <div class="lg:col-span-2">
                    <x-form.input type="month" wire:model.live="month_end" label="Mes fin" />
                </div>
            @elseif ($period_type === 'date')
                <div class="lg:col-span-2">
                    <x-form.datetime.picker wire:model.live="from" label="Fecha" without-time
                        display-format="DD/MM/YYYY" parse-format="YYYY-MM-DD" />
                </div>
            @elseif ($period_type === 'date_range')
                <div class="lg:col-span-2">
                    <x-form.datetime.picker wire:model.live="from" label="Desde" without-time
                        display-format="DD/MM/YYYY" parse-format="YYYY-MM-DD" />
                </div>
                <div class="lg:col-span-2">
                    <x-form.datetime.picker wire:model.live="to" label="Hasta" without-time display-format="DD/MM/YYYY"
                        parse-format="YYYY-MM-DD" />
                </div>
            @endif
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 mb-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="sm:col-span-2">
                <x-form.input wire:model.live.debounce.500ms="search" label="Buscar"
                    placeholder="Número, descripción..." />
            </div>

            <div>
                <x-form.select wire:model.live="type_movement" label="Tipo">
                    <x-select.option label="Todos" value="" />
                    <x-select.option label="Ingresos" value="INGRESO" />
                    <x-select.option label="Gastos" value="EGRESO" />
                </x-form.select>
            </div>

            <div>
                <x-form.select wire:model.live="destination_type" label="Destino">
                    <x-select.option label="Todos" value="" />
                    <x-select.option label="Caja" value="cash" />
                    <x-select.option label="Banco" value="bank" />
                </x-form.select>
            </div>

            @if ($destination_type === 'cash')
                <div class="lg:col-span-2">
                    <x-form.select wire:model.live="cash_id" label="Caja específica" placeholder="Seleccione">
                        <x-select.option label="Todas" value="" />
                        @foreach ($cajas as $caja)
                            <x-select.option label="{{ $caja->nombre }}" value="{{ $caja->id }}" />
                        @endforeach
                    </x-form.select>
                </div>
            @elseif ($destination_type === 'bank')
                <div class="lg:col-span-2">
                    <x-form.select wire:model.live="bank_account_id" label="Cuenta bancaria" placeholder="Seleccione">
                        <x-select.option label="Todas" value="" />
                        @foreach ($cuentasBancarias as $cuenta)
                            <x-select.option label="{{ $cuenta->bank->name ?? 'Banco' }} - {{ $cuenta->description }}"
                                value="{{ $cuenta->id }}" />
                        @endforeach
                    </x-form.select>
                </div>
            @endif

            <div class="flex items-end">
                <button wire:click="export" class="btn bg-emerald-600 text-white hover:bg-emerald-700 w-full">
                    <svg class="fill-current shrink-0 w-4 h-4" viewBox="0 0 16 16">
                        <path
                            d="M9 13H1c-.6 0-1-.4-1-1V4c0-.6.4-1 1-1h6v2H2v6h7v-2h2v3c0 .6-.4 1-1 1zM16 9l-5-5v3H7v4h4v3l5-5z" />
                    </svg>
                    <span class="ml-2">Excel</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Totales -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg p-4 shadow-lg">
            <div class="text-emerald-100 text-sm font-medium mb-1">Total Ingresos</div>
            <div class="text-white text-2xl font-bold">S/ {{ number_format($totales['ingresos'], 2) }}</div>
        </div>
        <div class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-lg p-4 shadow-lg">
            <div class="text-rose-100 text-sm font-medium mb-1">Total Gastos</div>
            <div class="text-white text-2xl font-bold">S/ {{ number_format($totales['gastos'], 2) }}</div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4 shadow-lg">
            <div class="text-blue-100 text-sm font-medium mb-1">Saldo</div>
            <div class="text-white text-2xl font-bold">S/ {{ number_format($totales['saldo'], 2) }}</div>
        </div>
    </div>


    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Transacciones
                <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $movimientos->total() }}</span>
            </h2>
        </header>
        <div class="overflow-x-auto min-h-screen">>
            <table class="table-auto w-full">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold w-[120px]">Fecha</th>
                        <th class="px-4 py-3 text-left font-semibold">Adquiriente</th>
                        <th class="px-4 py-3 text-left font-semibold">Documento / Transacción</th>
                        <th class="px-4 py-3 text-left font-semibold">Detalle</th>
                        <th class="px-4 py-3 text-center font-semibold w-[60px]">Moneda</th>
                        <th class="px-4 py-3 text-left font-semibold">Destino</th>
                        <th class="px-4 py-3 text-right font-semibold w-[110px]">Ingresos</th>
                        <th class="px-4 py-3 text-right font-semibold w-[110px]">Gastos</th>
                        <th class="px-4 py-3 text-right font-semibold w-[110px]">Saldo</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($movimientos as $mov)
                        <tr
                            class="{{ isset($mov['is_saldo_inicial']) && $mov['is_saldo_inicial'] ? 'bg-blue-50 dark:bg-blue-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-900/30' }}">
                            {{-- Fecha --}}
                            <td class="px-4 py-3 whitespace-nowrap w-[120px]">
                                <div class="text-gray-800 dark:text-gray-100 text-xs">
                                    {{ $mov['date_time'] ?? '-' }}
                                </div>
                            </td>

                            {{-- Adquiriente --}}
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $mov['person_name'] ?? '-' }}
                                </div>
                                @if (!empty($mov['person_document']))
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $mov['person_document'] }}
                                    </div>
                                @endif
                            </td>

                            {{-- Documento / Transacción --}}
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $mov['document_type'] ?? '-' }}
                                </div>
                                @if (!empty($mov['document_number']))
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $mov['document_number'] }}
                                    </div>
                                @endif
                            </td>

                            {{-- Detalle --}}
                            <td class="px-4 py-3">
                                <div class="text-gray-700 dark:text-gray-300 text-xs max-w-xs truncate">
                                    {{ $mov['detalle'] ?? '-' }}
                                </div>
                            </td>

                            {{-- Moneda --}}
                            <td class="px-4 py-3 text-center w-[60px]">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    {{ $mov['moneda'] === 'USD' ? 'bg-green-100 text-green-800 dark:bg-green-400/10 dark:text-green-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-400/10 dark:text-blue-400' }}">
                                    {{ $mov['moneda'] ?? 'PEN' }}
                                </span>
                            </td>

                            {{-- Destino --}}
                            <td class="px-4 py-3">
                                <div class="text-gray-700 dark:text-gray-300 text-xs">
                                    {{ $mov['destination'] ?? '-' }}
                                </div>
                            </td>

                            {{-- Ingresos --}}
                            <td class="px-4 py-3 whitespace-nowrap text-right w-[110px]">
                                @if (isset($mov['ingresos']) && $mov['ingresos'] > 0)
                                    <div class="text-emerald-600 dark:text-emerald-400 font-semibold">
                                        {{ number_format($mov['ingresos'], 2) }}
                                    </div>
                                @else
                                    <div class="text-gray-400">-</div>
                                @endif
                            </td>

                            {{-- Gastos --}}
                            <td class="px-4 py-3 whitespace-nowrap text-right w-[110px]">
                                @if (isset($mov['gastos']) && $mov['gastos'] > 0)
                                    <div class="text-rose-600 dark:text-rose-400 font-semibold">
                                        {{ number_format($mov['gastos'], 2) }}
                                    </div>
                                @else
                                    <div class="text-gray-400">-</div>
                                @endif
                            </td>

                            {{-- Saldo --}}
                            <td class="px-4 py-3 whitespace-nowrap text-right w-[110px]">
                                <div class="text-gray-900 dark:text-gray-100 font-bold">
                                    {{ number_format($mov['saldo'] ?? 0, 2) }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <div class="text-gray-400 dark:text-gray-500">
                                    <svg class="inline-block w-12 h-12 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="font-medium text-lg">No se encontraron transacciones</p>
                                    <p class="text-sm mt-1">Intenta ajustar los filtros de búsqueda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- Footer con totales --}}
                <tfoot>
                    <tr
                        class="bg-gray-50/50 dark:bg-gray-800/60 border-t-2 border-gray-300 dark:border-gray-600 font-bold">
                        <td colspan="6" class="px-4 py-3 text-right text-gray-800 dark:text-gray-100">
                            TOTALES:
                        </td>
                        <td class="px-4 py-3 text-right text-emerald-600 dark:text-emerald-400 whitespace-nowrap">
                            S/ {{ number_format($totales['ingresos'], 2) }}
                        </td>
                        <td class="px-4 py-3 text-right text-rose-600 dark:text-rose-400 whitespace-nowrap">
                            S/ {{ number_format($totales['gastos'], 2) }}
                        </td>
                        <td class="px-4 py-3 text-right text-blue-600 dark:text-blue-400 whitespace-nowrap">
                            S/ {{ number_format($totales['saldo'], 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $movimientos->links() }}
    </div>
</div>
