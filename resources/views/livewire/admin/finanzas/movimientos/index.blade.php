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
    <div class="mb-4 space-y-3">
        <!-- Search -->
        <div>
            <x-form.input wire:model.live="search" placeholder="Buscar por número de documento..."
                icon="magnifying-glass" />
        </div>

        <!-- Filters Row -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Date filter dropdown -->
            <div class="relative inline-flex" x-data="{ open: false, selected: 0 }">
                <button
                    class="btn justify-between min-w-fit bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100"
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
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
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
            <div class="min-w-45">
                <x-form.select wire:model.live="type_movement" placeholder="Todos los Movimientos">
                    <x-select.option label="Todos los Movimientos" value="" />
                    <x-select.option label="Ingresos" value="INGRESO" />
                    <x-select.option label="Egresos" value="EGRESO" />
                </x-form.select>
            </div>

            <!-- Destino filter -->
            <div class="min-w-45">
                <x-form.select wire:model.live="destination_type" placeholder="Todos los Destinos">
                    <x-select.option label="Todos los Destinos" value="" />
                    <x-select.option label="Caja" value="App\Models\Cash" />
                    <x-select.option label="Cuenta Bancaria" value="App\Models\BankAccount" />
                    <x-select.option label="⚠️ Sin Destino" value="sin_destino" />
                </x-form.select>
            </div>

            <!-- Caja filter -->
            @if ($cajas->count() > 0)
                <div class="min-w-35">
                    <x-form.select wire:model.live="cash_id" placeholder="Todas las Cajas">
                        <x-select.option label="Todas las Cajas" value="" />
                        @foreach ($cajas as $caja)
                            <x-select.option label="{{ $caja->nombre }}" value="{{ $caja->id }}" />
                        @endforeach
                    </x-form.select>
                </div>
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
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($movimientos as $movimiento)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                @if (($movimiento['type_movement'] ?? '') === 'INGRESO')
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
                                <div class="text-left">{{ $movimiento['date_time'] ?? '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">
                                    {{ $movimiento['instance_type_description'] ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $movimiento['document_number'] ?? '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div>{{ $movimiento['person_name'] ?? '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-xs">{{ $movimiento['destination_description'] ?? '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div
                                    class="text-right font-medium {{ ($movimiento['type_movement'] ?? '') === 'INGRESO' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ($movimiento['type_movement'] ?? '') === 'INGRESO' ? '+' : '-' }}
                                    S/ {{ number_format($movimiento['payment'] ?? 0, 2) }}
                                </div>
                                @if (isset($movimiento['residuary']))
                                    <div class="text-xs text-gray-500 text-right">
                                        Saldo: S/ {{ number_format($movimiento['residuary'], 2) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                @if (($movimiento['destination_id'] ?? null) === null)
                                    <x-form.button xs warning icon="link" label="Asignar"
                                        wire:click="openReassignModal({{ $movimiento['id'] ?? 0 }})" />
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-8 text-center text-gray-500">
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

    <!-- Modal de Reasignación de Destino -->
    <x-form.modal.card title="Asignar Destino al Movimiento" wire:model="showReassignModal" blur max-width="lg">
        @if ($selectedMovement)
            <div class="space-y-4">
                <!-- Información del movimiento -->
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <div class="text-sm space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Fecha:</span>
                            <span class="font-medium">{{ $selectedMovement->date }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Descripción:</span>
                            <span class="font-medium">{{ $selectedMovement->description }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Monto:</span>
                            <span
                                class="font-bold text-lg {{ $selectedMovement->type_movement === 'INGRESO' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $selectedMovement->type_movement === 'INGRESO' ? '+' : '-' }}
                                S/ {{ number_format($selectedMovement->payment->monto ?? 0, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Selector de tipo de destino -->
                <div>
                    <x-form.select label="Tipo de Destino" wire:model.live="reassign_destination_type"
                        placeholder="Seleccione tipo de destino">
                        <x-select.option label="💰 Caja Chica" value="cash" />
                        <x-select.option label="🏦 Cuenta Bancaria" value="bank" />
                    </x-form.select>
                </div>

                <!-- Selector de caja (si tipo = cash) -->
                @if ($reassign_destination_type === 'cash')
                    <div>
                        <x-form.select label="Caja Chica" wire:model.defer="reassign_cash_id"
                            placeholder="Seleccione una caja" :options="App\Models\Cash::where('estado', true)->get()" option-label="nombre"
                            option-value="id" />
                    </div>
                @endif

                <!-- Selector de cuenta bancaria (si tipo = bank) -->
                @if ($reassign_destination_type === 'bank')
                    <div>
                        <x-form.select label="Cuenta Bancaria" wire:model.defer="reassign_bank_account_id"
                            placeholder="Seleccione una cuenta">
                            @foreach (App\Models\BankAccount::where('status', true)->get() as $account)
                                <x-select.option
                                    label="{{ $account->bank->name }} - {{ $account->number }} ({{ $account->currency_type_id }})"
                                    value="{{ $account->id }}" />
                            @endforeach
                        </x-form.select>
                    </div>
                @endif

                <!-- Advertencia -->
                <div
                    class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                    <p class="text-xs text-yellow-800 dark:text-yellow-200">
                        <strong>Nota:</strong> Esta acción actualizará el saldo del destino seleccionado. Asegúrese de
                        elegir el destino correcto.
                    </p>
                </div>
            </div>
        @endif

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button flat label="Cancelar" wire:click="closeReassignModal" />
                <x-form.button primary label="Asignar Destino" wire:click="confirmReassign"
                    spinner="confirmReassign" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
