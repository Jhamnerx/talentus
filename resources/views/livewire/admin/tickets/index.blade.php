<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Tickets ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live="search" id="action-search"
                    class="form-input pl-9 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 focus:border-gray-300 dark:focus:border-gray-600"
                    type="search" placeholder="Buscar ticket..." />
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                        width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>

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

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <!-- Left side -->
        <div class="mb-4 sm:mb-0"></div>

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Filters -->
            <div class="relative" x-data="{ open: false }">
                <button wire:ignore
                    class="btn justify-between min-w-[11rem] bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100"
                    aria-label="Select date range" @click.prevent="open = !open" :aria-expanded="open">
                    <span class="flex items-center">
                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 mr-2" width="16"
                            height="16" viewBox="0 0 16 16">
                            <path
                                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                        </svg>
                        <span x-text="open ? 'Cerrar' : 'Filtrar'">Filtrar</span>
                    </span>
                </button>
                <div class="z-10 absolute top-full right-0 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <div class="font-medium text-xs text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">Período
                    </div>
                    <button wire:click="filter('1')" @click="open = false"
                        class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Hoy</span>
                    </button>
                    <button wire:click="filter('7')" @click="open = false"
                        class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Últimos 7 días</span>
                    </button>
                    <button wire:click="filter('30')" @click="open = false"
                        class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Últimos 30 días</span>
                    </button>
                    <button wire:click="filter('12')" @click="open = false"
                        class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Último año</span>
                    </button>
                    <button wire:click="filter('0')" @click="open = false"
                        class="flex items-center w-full hover:bg-gray-50 hover:dark:bg-gray-700/20 py-1 px-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Limpiar</span>
                    </button>
                </div>
            </div>

            <!-- Status Filter -->
            <select wire:model.live="statusFilter"
                class="form-select text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300">
                <option value="">Todos los estados</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                @endforeach
            </select>

            <!-- Priority Filter -->
            <select wire:model.live="priorityFilter"
                class="form-select text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300">
                <option value="">Todas las prioridades</option>
                @foreach ($priorities as $priority)
                    <option value="{{ $priority['value'] }}">{{ $priority['label'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Total Tickets <span
                    class="text-gray-400 dark:text-gray-500 font-medium">{{ $tickets->total() }}</span>
            </h2>
        </header>
        <div>
            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">
                <table class="table-auto w-full dark:text-gray-300">
                    <thead
                        class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-100 dark:border-gray-700/60">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Código</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Asunto</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Cliente</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Estado</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Prioridad</div>
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
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}"
                                        class="font-medium text-violet-500 hover:text-violet-600">
                                        {{ $ticket->code }}
                                    </a>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $ticket->subject }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    {{ $ticket->customer->razon_social ?? '-' }}
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->status->statusColor() }}">
                                        {{ $ticket->status->label() }}
                                    </span>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->priority->statusColor() }}">
                                        {{ $ticket->priority->label() }}
                                    </span>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    {{ $ticket->assignedTo->name ?? '-' }}
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            wire:click="$dispatch('open-ticket-quickview', { ticketId: {{ $ticket->id }} })"
                                            title="Vista rápida"
                                            class="text-violet-400 hover:text-violet-600 dark:text-violet-500 dark:hover:text-violet-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </button>

                                        <a href="{{ route('admin.tickets.show', $ticket) }}"
                                            title="Ver detalle completo"
                                            class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>

                                        <button wire:click="openModalEdit({{ $ticket->id }})"
                                            class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        @can('eliminar-ticket')
                                            <button wire:click="openModalDelete({{ $ticket->id }})"
                                                class="text-red-400 hover:text-red-500 dark:text-red-500 dark:hover:text-red-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
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
                                <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
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
