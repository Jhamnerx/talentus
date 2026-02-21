<div class="space-y-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cuentas Bancarias</h3>
        <x-form.button primary label="Nueva Cuenta" wire:click="create" icon="plus" />
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <x-form.input placeholder="Buscar..." wire:model.live="search" />

        <x-form.select wire:model.live="bank_filter" placeholder="Todos los bancos">
            @foreach ($banks as $bank)
                <x-select.option label="{{ $bank->description }}" value="{{ $bank->id }}" />
            @endforeach
        </x-form.select>

        <x-form.select wire:model.live="currency_filter" placeholder="Todas las monedas">
            @foreach ($currencies as $currency)
                <x-select.option label="{{ $currency->description }}" value="{{ $currency->id }}" />
            @endforeach
        </x-form.select>

        <x-form.select wire:model.live="status_filter" placeholder="Todos los estados">
            <x-select.option label="Activo" value="1" />
            <x-select.option label="Inactivo" value="0" />
        </x-form.select>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60">
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                    <tr>
                        <th class="px-4 py-3 text-left">Banco</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-left">Número</th>
                        <th class="px-4 py-3 text-left">CCI</th>
                        <th class="px-4 py-3 text-center">Moneda</th>
                        <th class="px-4 py-3 text-right">Saldo Inicial</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">En Docs</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($bankAccounts as $account)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                            <td class="px-4 py-3">{{ $account->bank->description }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-100">
                                {{ $account->description }}
                            </td>
                            <td class="px-4 py-3">{{ $account->number }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $account->cci ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $account->currency_name }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right font-mono">{{ number_format($account->initial_balance, 2) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="toggleStatus({{ $account->id }})" type="button">
                                    @if ($account->status)
                                        <x-form.badge positive label="Activo" />
                                    @else
                                        <x-form.badge negative label="Inactivo" />
                                    @endif
                                </button>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="toggleShowInDocuments({{ $account->id }})" type="button">
                                    @if ($account->show_in_documents)
                                        <x-form.icon name="check-circle" class="w-5 h-5 text-green-500" />
                                    @else
                                        <x-form.icon name="x-circle" class="w-5 h-5 text-gray-400" />
                                    @endif
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <x-form.button xs primary label="Editar" wire:click="edit({{ $account->id }})" />
                                    <x-form.button xs negative label="Eliminar"
                                        wire:click="confirmDelete({{ $account->id }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-10 text-center text-gray-400 dark:text-gray-500">
                                No se encontraron cuentas bancarias
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $bankAccounts->links() }}
    </div>
</div>
