<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Movimientos de Ingresos y Egresos
                ✨</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Los movimientos se generan automáticamente desde los pagos registrados en el sistema
            </p>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <div class="relative">
            <label for="action-search" class="sr-only">Buscar</label>
            <input id="action-search" class="form-input pl-9 focus:border-gray-300 w-full" type="search"
                placeholder="Buscar por número de documento..." wire:model.live="search" />
            <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                    width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                    <path
                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="sm:flex sm:justify-between sm:items-center mb-4">
        <div class="flex items-center gap-2 flex-wrap">
            <!-- Date filter dropdown -->
            <div class="relative inline-flex" x-data="{ open: false, selected: 0 }">
                <button
                    class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300"
                    @click.prevent="open = !open">
                    <span class="flex items-center">
                        <svg class="fill-current text-gray-400 dark:text-gray-500 shrink-0 mr-2" width="16"
                            height="16" viewBox="0 0 16 16">
                            <path
                                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                        </svg>
                        <span
                            x-text="selected === 0 ? 'Mes Actual' : selected === 1 ? 'Hoy' : selected === 2 ? 'Últimos 7 Días' : selected === 3 ? 'Últimos 30 Días' : 'Todas las Fechas'"></span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                        height="7" viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="z-10 absolute top-full left-0 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open">
                    <button class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3"
                        :class="selected === 0 && 'text-violet-500'" @click.prevent="selected = 0; open = false"
                        wire:click="filter(0)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 0 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Mes Actual</span>
                    </button>
                    <button class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3"
                        :class="selected === 1 && 'text-violet-500'" @click.prevent="selected = 1; open = false"
                        wire:click="filter(1)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 1 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Hoy</span>
                    </button>
                    <button class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3"
                        :class="selected === 2 && 'text-violet-500'" @click.prevent="selected = 2; open = false"
                        wire:click="filter(7)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 2 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Últimos 7 Días</span>
                    </button>
                    <button class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3"
                        :class="selected === 3 && 'text-violet-500'" @click.prevent="selected = 3; open = false"
                        wire:click="filter(30)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 3 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Últimos 30 Días</span>
                    </button>
                </div>
            </div>

            <!-- Tipo de movimiento filter -->
            <select class="form-select w-auto" wire:model.live="type_movement">
                <option value="">Todos los Movimientos</option>
                <option value="INGRESO">Ingresos</option>
                <option value="EGRESO">Egresos</option>
            </select>

            <!-- Destino filter -->
            <select class="form-select w-auto" wire:model.live="destination_type">
                <option value="">Todos los Destinos</option>
                <option value="App\Models\Cash">Caja</option>
                <option value="App\Models\BankAccount">Cuenta Bancaria</option>
            </select>

            <!-- Caja filter -->
            @if ($cajas->count() > 0)
                <select class="form-select w-auto" wire:model.live="cash_id">
                    <option value="">Todas las Cajas</option>
                    @foreach ($cajas as $caja)
                        <option value="{{ $caja->id }}">{{ $caja->nombre }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 relative">
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                            <span class="sr-only">Tipo</span>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Documento</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Cliente/Proveedor</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Destino</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-right">Monto</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($movimientos as $movimiento)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                @if ($movimiento->type_movement === 'INGRESO')
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $movimiento->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">
                                    {{ $movimiento->payment_type_description }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $movimiento->document_number }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div>{{ $movimiento->person_name }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-xs">{{ $movimiento->destination_description }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div
                                    class="text-right font-medium {{ $movimiento->type_movement === 'INGRESO' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $movimiento->type_movement === 'INGRESO' ? '+' : '-' }}
                                    S/ {{ number_format($movimiento->monto, 2) }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-2 first:pl-5 last:pr-5 py-8 text-center text-gray-500">
                                No se encontraron movimientos en el período seleccionado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $movimientos->links() }}
    </div>
</div>
