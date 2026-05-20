<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Métodos de Pago ✨</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gestión de métodos de pago según SUNAT</p>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <form class="relative" @submit.prevent>
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live="search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                    type="search" placeholder="Buscar métodos" />
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
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-slate-200 dark:border-gray-700/60">
        <div class="overflow-x-auto min-h-screen">
            <table class="table-auto w-full divide-y divide-slate-200 dark:divide-gray-700">
                <thead class="text-xs uppercase text-slate-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-900/20">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">CÓDIGO</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">DESCRIPCIÓN</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">ESTADO</div>
                        </th>
                        @can('editar-payment-methods')
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">ACCIONES</div>
                            </th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-700">
                    @forelse($paymentMethods as $method)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">{{ $method->id }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3">
                                @if ($editingId === $method->id)
                                    <x-form.input wire:model.defer="description" />
                                @else
                                    <div class="text-gray-800 dark:text-gray-100">{{ $method->description }}</div>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex justify-center">
                                    @if ($editingId === $method->id)
                                        <x-form.toggle wire:model.defer="active" />
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $method->active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $method->active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            @can('editar-payment-methods')
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex justify-center gap-2">
                                        @if ($editingId === $method->id)
                                            <x-form.button xs positive label="Guardar" wire:click="update" />
                                            <x-form.button xs flat label="Cancelar" wire:click="cancelEdit" />
                                        @else
                                            <x-form.button xs primary label="Editar"
                                                wire:click="edit('{{ $method->id }}')" />
                                        @endif
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-2 first:pl-5 last:pr-5 py-8 text-center text-gray-500">
                                No hay métodos de pago disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4">
            {{ $paymentMethods->links() }}
        </div>
    </div>
</div>
