<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Movimientos de Ingresos y Egresos ✨
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Los movimientos se generan automáticamente desde los pagos registrados en el sistema
        </p>
    </div>

    <!-- Filters Section -->
    <div class="mb-4 space-y-4">
        <!-- Selector de Periodo Avanzado -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700/60 p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Tipo de Periodo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Periodo
                    </label>
                    <x-form.select wire:model.live="period_type">
                        <x-select.option label="Por mes" value="month" />
                        <x-select.option label="Entre meses" value="month_range" />
                        <x-select.option label="Por fecha" value="date" />
                        <x-select.option label="Entre fechas" value="date_range" />
                    </x-form.select>
                </div>

                <!-- Por mes -->
                @if ($period_type === 'month')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mes de
                        </label>
                        <x-form.input type="month" wire:model.live="month" />
                    </div>
                @endif

                <!-- Entre meses -->
                @if ($period_type === 'month_range')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mes de
                        </label>
                        <x-form.input type="month" wire:model.live="month_start" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mes al
                        </label>
                        <x-form.input type="month" wire:model.live="month_end" />
                    </div>
                @endif

                <!-- Por fecha -->
                @if ($period_type === 'date')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha
                        </label>
                        <x-form.datetime.picker wire:model.live="from" without-time />
                    </div>
                @endif

                <!-- Entre fechas -->
                @if ($period_type === 'date_range')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha de
                        </label>
                        <x-form.datetime.picker wire:model.live="from" without-time />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha al
                        </label>
                        <x-form.datetime.picker wire:model.live="to" without-time />
                    </div>
                @endif

                <!-- Última apertura de caja -->
                <div class="flex items-end">
                    <label class="flex items-center cursor-pointer">
                        <x-form.checkbox wire:model.live="ultima_apertura_caja" />
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Última apertura de caja</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Search & Additional Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <!-- Search -->
            <div class="flex-1 min-w-64">
                <x-form.input wire:model.live="search" placeholder="Buscar por número de documento..."
                    icon="magnifying-glass" />
            </div>

            <!-- Tipo de movimiento filter -->
            <div class="min-w-45">
                <x-form.select wire:model.live="type_movement" placeholder="Todos">
                    <x-select.option label="Todos" value="" />
                    <x-select.option label="Ingresos" value="INGRESO" />
                    <x-select.option label="Egresos" value="EGRESO" />
                </x-form.select>
            </div>

            <!-- Caja filter -->
            @if ($cajas->count() > 0)
                <div class="min-w-40">
                    <x-form.select wire:model.live="cash_id" placeholder="Todas las Cajas">
                        <x-select.option label="Todas las Cajas" value="" />
                        @foreach ($cajas as $caja)
                            <x-select.option label="{{ $caja->nombre }}" value="{{ $caja->id }}" />
                        @endforeach
                    </x-form.select>
                </div>
            @endif

            <!-- Botón Exportar Excel -->
            <x-form.button emerald label="Excel" icon="document-text" wire:click="export" />
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 relative">
        <div class="overflow-x-auto min-h-screen">>
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Adquiriente</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Documento/Transacción</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Detalle</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Moneda</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Tipo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Ingresos</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Gastos</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Saldo</div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($movimientos as $movimiento)
                        <tr
                            class="{{ isset($movimiento['is_saldo_inicial']) && $movimiento['is_saldo_inicial'] ? 'bg-blue-50 dark:bg-blue-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-700/20' }}">
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left text-gray-600 dark:text-gray-300">
                                    {{ $movimiento['date_time'] ? \Carbon\Carbon::parse($movimiento['date_time'])->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left font-medium text-gray-800 dark:text-gray-100">
                                    {{ $movimiento['person_name'] ?: '-' }}
                                    @if (!empty($movimiento['person_document']))
                                        <div class="text-xs text-gray-500">{{ $movimiento['person_document'] }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">
                                    @if (!empty($movimiento['document_type']))
                                        <span
                                            class="font-medium text-gray-700 dark:text-gray-300">{{ $movimiento['document_type'] }}</span>
                                        @if (!empty($movimiento['document_number']))
                                            <span class="text-gray-500"> - {{ $movimiento['document_number'] }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="text-left text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                    {{ $movimiento['detalle'] ?: '-' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $movimiento['moneda'] === 'PEN' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' }}">
                                        {{ $movimiento['moneda'] }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    @if (!empty($movimiento['tipo']))
                                        <span
                                            class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 {{ $movimiento['tipo'] === 'INGRESO' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $movimiento['tipo'] }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div
                                    class="text-right font-medium {{ $movimiento['ingresos'] > 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-400' }}">
                                    {{ $movimiento['ingresos'] > 0 ? number_format($movimiento['ingresos'], 2) : '-' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div
                                    class="text-right font-medium {{ $movimiento['gastos'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-400' }}">
                                    {{ $movimiento['gastos'] > 0 ? number_format($movimiento['gastos'], 2) : '-' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right font-semibold text-gray-900 dark:text-gray-100">
                                    {{ number_format($movimiento['saldo'], 2) }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm font-medium">No hay movimientos para mostrar</p>
                                    <p class="text-xs mt-1">Ajusta los filtros para ver más resultados</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <!-- Totales Row -->
                    @if ($movimientos->count() > 0)
                        <tr
                            class="bg-gray-100 dark:bg-gray-800/60 font-bold border-t-2 border-gray-300 dark:border-gray-600">
                            <td colspan="6"
                                class="px-2 first:pl-5 last:pr-5 py-3 text-right uppercase text-sm text-gray-700 dark:text-gray-200">
                                TOTALES:
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right font-bold text-green-700 dark:text-green-400">
                                    {{ number_format($totales['ingresos'], 2) }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right font-bold text-red-700 dark:text-red-400">
                                    {{ number_format($totales['gastos'], 2) }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-right font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($totales['saldo'], 2) }}
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $movimientos->links() }}
    </div>
</div>
