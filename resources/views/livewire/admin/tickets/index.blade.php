<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Tickets ✨</h1>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search -->
            <x-form.input wire:model.live.debounce.300ms="search" placeholder="Buscar ticket..." icon="magnifying-glass" />

            <!-- Export -->
            <button wire:click="exportTickets" wire:loading.attr="disabled"
                class="btn bg-green-600 hover:bg-green-700 text-white">
                <svg wire:loading wire:target="exportTickets" class="w-4 h-4 animate-spin mr-1" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                    </path>
                </svg>
                <svg wire:loading.remove wire:target="exportTickets" class="w-4 h-4 mr-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="max-xs:sr-only xs:block">Excel</span>
            </button>

            <!-- Add button -->
            <button wire:click='openModalCreate'
                class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                <svg class="fill-current shrink-0" width="16" height="16" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="max-xs:sr-only xs:block ml-2">Agregar Ticket</span>
            </button>
        </div>
    </div>

    <!-- Filters (WireUI) -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xs border border-gray-100 dark:border-gray-700/60 p-4 mb-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <x-form.datetime.picker wire:model.live="from" placeholder="Desde" without-time />
            <x-form.datetime.picker wire:model.live="to" placeholder="Hasta" without-time />

            <x-form.select wire:model.live="assignedFilter" placeholder="Todos los asignados">
                <x-select.option value="">Todos los asignados</x-select.option>
                <x-select.option value="mine">⭐ Mis tickets</x-select.option>
                @foreach ($agents as $agent)
                    <x-select.option :value="$agent->id" :label="$agent->name" />
                @endforeach
            </x-form.select>

            <x-form.select wire:model.live="statusFilter" placeholder="Todos los estados">
                <x-select.option value="">Todos los estados</x-select.option>
                @foreach ($statuses as $status)
                    <x-select.option :value="$status['value']" :label="$status['label']" />
                @endforeach
            </x-form.select>

            <x-form.select wire:model.live="priorityFilter" placeholder="Todas las prioridades">
                <x-select.option value="">Todas las prioridades</x-select.option>
                @foreach ($priorities as $priority)
                    <x-select.option :value="$priority['value']" :label="$priority['label']" />
                @endforeach
            </x-form.select>
        </div>

        @if ($search || $statusFilter || $priorityFilter || $assignedFilter || $from || $to)
            <div class="mt-3">
                <x-form.button wire:click="limpiarFiltros" flat label="Limpiar filtros" icon="x-mark" />
            </div>
        @endif
    </div>

    <!-- Bulk actions bar -->
    @if (count($selectedTickets) > 0)
        <div
            class="flex items-center gap-3 mb-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-700 rounded-xl px-4 py-3">
            <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
                {{ count($selectedTickets) }} ticket(s) seleccionado(s)
            </span>
            <div class="flex items-center gap-2 ml-auto">
                <button wire:click="bulkAction('resolve')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-teal-100 dark:bg-teal-900/40 text-teal-700 dark:text-teal-300 hover:bg-teal-200 transition-colors">
                    ✓ Marcar resueltos
                </button>
                <button wire:click="bulkAction('close')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition-colors">
                    🔒 Cerrar
                </button>
                <button wire:click="bulkAction('assign_me')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-violet-100 dark:bg-violet-900/40 text-violet-700 dark:text-violet-300 hover:bg-violet-200 transition-colors">
                    👤 Asignarme
                </button>
                <button wire:click="$set('selectedTickets', []); $set('selectAll', false)"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 hover:bg-red-200 transition-colors">
                    ✕ Cancelar
                </button>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Total Tickets
                <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $tickets->total() }}</span>
            </h2>
        </header>
        <div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full dark:text-gray-300">
                    <thead
                        class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-100 dark:border-gray-700/60">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 w-px">
                                <input type="checkbox" wire:model.live="selectAll"
                                    class="form-checkbox text-indigo-500 rounded" />
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Código</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Asunto</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Cliente</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Estado</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Prioridad / SLA</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Asignado</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Acciones</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        @forelse ($tickets as $ticket)
                            <tr class="{{ $ticket->isOverdue() ? 'bg-red-50/40 dark:bg-red-900/10' : '' }}">
                                <td class="px-2 first:pl-5 last:pr-5 py-2.5 w-px">
                                    <input type="checkbox" wire:model.live="selectedTickets" value="{{ $ticket->id }}"
                                        class="form-checkbox text-indigo-500 rounded" />
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-2.5 whitespace-nowrap">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}"
                                        class="font-medium text-violet-500 hover:text-violet-600 text-xs">
                                        {{ $ticket->code }}
                                    </a>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-2.5 max-w-[240px]">
                                    <div class="font-medium text-gray-800 dark:text-gray-100 truncate leading-snug"
                                        title="{{ $ticket->subject }}">
                                        {{ $ticket->subject }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-0.5 whitespace-nowrap">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-2.5 max-w-[200px]">
                                    <div class="truncate text-gray-700 dark:text-gray-300 text-xs leading-snug"
                                        title="{{ $ticket->customer->razon_social ?? '' }}">
                                        {{ $ticket->customer->razon_social ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-2.5 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->status->statusColor() }}">
                                        {{ $ticket->status->label() }}
                                    </span>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-2.5 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->priority->statusColor() }}">
                                        {{ $ticket->priority->label() }}
                                    </span>
                                    @if ($ticket->due_at)
                                        <div
                                            class="text-xs mt-0.5 {{ $ticket->isOverdue() ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                                            @if ($ticket->isOverdue())
                                                ⚠ Vencido {{ $ticket->due_at->diffForHumans() }}
                                            @else
                                                Vence {{ $ticket->due_at->diffForHumans() }}
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-2.5 whitespace-nowrap text-xs">
                                    {{ $ticket->assignedTo->name ?? '-' }}
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-2.5 whitespace-nowrap w-px">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            wire:click="$dispatch('open-ticket-quickview', { ticketId: {{ $ticket->id }} })"
                                            title="Vista rápida"
                                            class="text-violet-400 hover:text-violet-600 dark:text-violet-500 dark:hover:text-violet-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </button>

                                        <a href="{{ route('admin.tickets.show', $ticket) }}" title="Ver detalle"
                                            class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>

                                        <button wire:click="openModalEdit({{ $ticket->id }})" title="Editar"
                                            class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        @can('eliminar-ticket')
                                            <button wire:click="openModalDelete({{ $ticket->id }})" title="Eliminar"
                                                class="text-red-400 hover:text-red-500 dark:text-red-500 dark:hover:text-red-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg class="inline-block w-12 h-12 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="font-medium">No hay tickets disponibles</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $tickets->links() }}
    </div>
</div>
