<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Transacciones 💳</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <button wire:click="export" class="btn bg-emerald-600 text-white hover:bg-emerald-700">
                <svg class="fill-current shrink-0 w-4 h-4" viewBox="0 0 16 16">
                    <path
                        d="M9 13H1c-.6 0-1-.4-1-1V4c0-.6.4-1 1-1h6v2H2v6h7v-2h2v3c0 .6-.4 1-1 1zM16 9l-5-5v3H7v4h4v3l5-5z" />
                </svg>
                <span class="ml-2">Exportar</span>
            </button>
        </div>

    </div>

    <!-- Totales -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-linear-to-br from-emerald-500 to-emerald-600 rounded-lg p-4 shadow-lg">
            <div class="text-emerald-100 text-sm font-medium mb-1">Total Ingresos</div>
            <div class="text-white text-2xl font-bold">S/ {{ number_format($totales['ingresos'], 2) }}</div>
        </div>
        <div class="bg-linear-to-br from-rose-500 to-rose-600 rounded-lg p-4 shadow-lg">
            <div class="text-rose-100 text-sm font-medium mb-1">Total Egresos</div>
            <div class="text-white text-2xl font-bold">S/ {{ number_format($totales['egresos'], 2) }}</div>
        </div>
        <div class="bg-linear-to-br from-blue-500 to-blue-600 rounded-lg p-4 shadow-lg">
            <div class="text-blue-100 text-sm font-medium mb-1">Saldo</div>
            <div class="text-white text-2xl font-bold">S/ {{ number_format($totales['saldo'], 2) }}</div>
        </div>
    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Right side -->
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div class="sm:col-span-2">
                        <x-form.input wire:model.live.debounce.500ms="search" label="Buscar"
                            placeholder="Número, cliente..." />
                    </div>

                    <div>
                        <x-form.select wire:model.live="tipo_filter" label="Tipo" placeholder="Todos">
                            <x-select.option label="Todos" value="" />
                            <x-select.option label="Ingresos" value="ingreso" />
                            <x-select.option label="Egresos" value="egreso" />
                        </x-form.select>
                    </div>

                    <div>
                        <x-form.select wire:model.live="destination_type" label="Destino" placeholder="Todos">
                            <x-select.option label="Todos" value="" />
                            <x-select.option label="Caja" value="cash" />
                            <x-select.option label="Banco" value="bank" />
                        </x-form.select>
                    </div>

                    <div>
                        <x-form.datetime.picker wire:model.live="from" label="Desde" without-time
                            display-format="DD/MM/YYYY" parse-format="YYYY-MM-DD" />
                    </div>

                    <div>
                        <x-form.datetime.picker wire:model.live="to" label="Hasta" without-time
                            display-format="DD/MM/YYYY" parse-format="YYYY-MM-DD" />
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mt-4">
                    <button wire:click="filter(1)" class="btn-sm bg-white dark:bg-gray-800 border-gray-200">Hoy</button>
                    <button wire:click="filter(7)" class="btn-sm bg-white dark:bg-gray-800 border-gray-200">7
                        días</button>
                    <button wire:click="filter(30)" class="btn-sm bg-white dark:bg-gray-800 border-gray-200">30
                        días</button>
                    <button wire:click="filter(0)"
                        class="btn-sm bg-white dark:bg-gray-800 border-gray-200">Limpiar</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Movimientos
                <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $movimientos->total() }}</span>
            </h2>
        </header>
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Fecha</th>
                        <th class="px-4 py-3 text-left font-semibold">Tipo</th>
                        <th class="px-4 py-3 text-left font-semibold">Documento</th>
                        <th class="px-4 py-3 text-left font-semibold">Persona</th>
                        <th class="px-4 py-3 text-left font-semibold">Destino</th>
                        <th class="px-4 py-3 text-right font-semibold">Ingreso</th>
                        <th class="px-4 py-3 text-right font-semibold">Egreso</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($movimientos as $mov)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100 text-sm">
                                    {{ $mov['date_of_payment'] ?? ($mov['created_at'] ?? '-') }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ ($mov['type_movement'] ?? '') === 'INGRESO'
                                        ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-400/10 dark:text-emerald-400'
                                        : 'bg-rose-100 text-rose-800 dark:bg-rose-400/10 dark:text-rose-400' }}">
                                    {{ $mov['instance_type'] ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-gray-800 dark:text-gray-100 font-medium">
                                    {{ $mov['document_number'] ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-800 dark:text-gray-100 max-w-xs truncate">
                                    {{ $mov['person_name'] ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-600 dark:text-gray-400 text-xs max-w-xs truncate">
                                    {{ $mov['destination_description'] ?? ($mov['destination_name'] ?? '-') }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                @if (($mov['type_movement'] ?? '') === 'INGRESO')
                                    <div class="text-emerald-600 dark:text-emerald-400 font-semibold">
                                        +{{ $mov['currency_type_id'] ?? 'S/' }} {{ $mov['input'] ?? '0.00' }}
                                    </div>
                                @else
                                    <div class="text-gray-400">-</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                @if (($mov['type_movement'] ?? '') === 'EGRESO')
                                    <div class="text-rose-600 dark:text-rose-400 font-semibold">
                                        {{ $mov['currency_type_id'] ?? 'S/' }} {{ $mov['output'] ?? '0.00' }}
                                    </div>
                                @else
                                    <div class="text-gray-400">-</div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
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
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $movimientos->links() }}

    </div>
</div>
