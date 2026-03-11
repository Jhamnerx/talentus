<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Planes de Servicio</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gestiona los planes de suscripción y sus
                características</p>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search -->
            <div class="relative">
                <x-form.input wire:model.live.debounce.300ms="search" placeholder="Buscar planes..."
                    icon="magnifying-glass" />
            </div>
            <!-- Create button -->
            <x-form.button primary wire:click="openModalCreate" icon="plus">
                Crear Plan
            </x-form.button>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700/60">

        <div class="overflow-x-auto min-h-screen">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Table header -->
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Plan</th>
                        <th class="px-4 py-3 text-left font-semibold">Producto</th>
                        <th class="px-4 py-3 text-center font-semibold">Precio</th>
                        <th class="px-4 py-3 text-center font-semibold">Facturación</th>
                        <th class="px-4 py-3 text-center font-semibold">Prueba</th>
                        <th class="px-4 py-3 text-center font-semibold">Características</th>
                        <th class="px-4 py-3 text-center font-semibold">Estado</th>
                        <th class="px-4 py-3 text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($planes as $plan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20">
                            <!-- Plan Name -->
                            <td class="px-4 py-3">
                                <div class="flex flex-col">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ is_array($plan->name) ? $plan->name['es'] ?? ($plan->name['en'] ?? 'Sin nombre') : $plan->name }}
                                    </div>
                                    @if ($plan->description)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            {{ Str::limit(is_array($plan->description) ? $plan->description['es'] ?? ($plan->description['en'] ?? '') : $plan->description, 50) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <!-- Product -->
                            <td class="px-4 py-3">
                                @if ($plan->producto)
                                    <span class="text-gray-700 dark:text-gray-300">
                                        {{ $plan->producto->descripcion }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 text-xs">Sin producto</span>
                                @endif
                            </td>
                            <!-- Price -->
                            <td class="px-4 py-3 text-center">
                                <div class="font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $plan->currency }} {{ number_format($plan->price, 4) }}
                                </div>
                                @if ($plan->signup_fee > 0)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Setup: +{{ number_format($plan->signup_fee, 2) }}
                                    </div>
                                @endif
                            </td>
                            <!-- Billing -->
                            <td class="px-4 py-3 text-center">
                                <span class="text-gray-700 dark:text-gray-300">
                                    {{ $plan->invoice_period }}
                                    {{ Str::plural($plan->invoice_interval, $plan->invoice_period) }}
                                </span>
                            </td>
                            <!-- Trial -->
                            <td class="px-4 py-3 text-center">
                                @if ($plan->trial_period > 0)
                                    <x-form.badge positive>
                                        {{ $plan->trial_period }}
                                        {{ Str::plural($plan->trial_interval, $plan->trial_period) }}
                                    </x-form.badge>
                                @else
                                    <x-form.badge flat>
                                        No
                                    </x-form.badge>
                                @endif
                            </td>
                            <!-- Features Count -->
                            <td class="px-4 py-3 text-center">
                                <button wire:click="openModalFeatures({{ $plan->id }})"
                                    class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <x-form.icon name="list-bullet" class="w-4 h-4" />
                                    <span class="font-medium">{{ $plan->features->count() }}</span>
                                </button>
                            </td>
                            <!-- Status -->
                            <td class="px-4 py-3 text-center">
                                @if ($plan->is_active)
                                    <x-form.badge positive>Activo</x-form.badge>
                                @else
                                    <x-form.badge negative>Inactivo</x-form.badge>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">

                                    <x-form.button xs primary icon="pencil"
                                        wire:click="openModalEdit({{ $plan->id }})" />


                                    <x-form.button xs negative icon="trash"
                                        wire:click="openModalDelete({{ $plan->id }})" />

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                @if ($search)
                                    No se encontraron planes que coincidan con "{{ $search }}"
                                @else
                                    No hay planes registrados.

                                    <button wire:click="openModalCreate"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Crear el primer plan
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($planes->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $planes->links() }}
            </div>
        @endif

    </div>


</div>
