<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    {{-- ── HEADER ─────────────────────────────────────────────── --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100">Tickets ✨</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ $tickets->total() }} ticket{{ $tickets->total() !== 1 ? 's' : '' }} en total
            </p>
        </div>
        <div class="flex items-center gap-2 mt-4 sm:mt-0">
            <x-form.input
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar código, asunto, cliente..."
                icon="magnifying-glass"
                class="min-w-55"
            />
            <button wire:click="exportTickets" wire:loading.attr="disabled"
                class="btn bg-emerald-600 hover:bg-emerald-700 text-white inline-flex items-center gap-2">
                <svg wire:loading wire:target="exportTickets" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <svg wire:loading.remove wire:target="exportTickets" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="hidden sm:inline">Excel</span>
            </button>
            <button wire:click="openModalCreate"
                class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white inline-flex items-center gap-2">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                </svg>
                <span class="hidden sm:inline">Nuevo Ticket</span>
            </button>
        </div>
    </div>

    {{-- ── FILTROS ─────────────────────────────────────────────── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xs border border-gray-100 dark:border-gray-700/60 p-4 mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3">
            <x-form.datetime.picker wire:model.live="from" placeholder="Desde" without-time />
            <x-form.datetime.picker wire:model.live="to" placeholder="Hasta" without-time />

            <x-form.select wire:model.live="statusFilter" placeholder="Estado">
                <x-select.option value="">Todos los estados</x-select.option>
                @foreach ($statuses as $status)
                    <x-select.option :value="$status['value']" :label="$status['label']" />
                @endforeach
            </x-form.select>

            <x-form.select wire:model.live="priorityFilter" placeholder="Prioridad">
                <x-select.option value="">Todas las prioridades</x-select.option>
                @foreach ($priorities as $priority)
                    <x-select.option :value="$priority['value']" :label="$priority['label']" />
                @endforeach
            </x-form.select>

            <x-form.select wire:model.live="categoryFilter" placeholder="Categoría">
                <x-select.option value="">Todas las categorías</x-select.option>
                @foreach ($categories as $cat)
                    <x-select.option :value="$cat->id" :label="$cat->name" />
                @endforeach
            </x-form.select>

            <x-form.select wire:model.live="assignedFilter" placeholder="Asignado a">
                <x-select.option value="">Todos los agentes</x-select.option>
                <x-select.option value="mine">⭐ Mis tickets</x-select.option>
                @foreach ($agents as $agent)
                    <x-select.option :value="$agent->id" :label="$agent->name" />
                @endforeach
            </x-form.select>
        </div>

        {{-- Quick filters + per page --}}
        <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs text-gray-400 dark:text-gray-500">Rápido:</span>
                <button wire:click="filter('1')"
                    @class(['text-xs px-3 py-1 rounded-full border transition',
                        'bg-violet-100 dark:bg-violet-900/40 border-violet-300 dark:border-violet-600 text-violet-700 dark:text-violet-300' => $from === now()->format('Y-m-d') && $to === now()->format('Y-m-d'),
                        'border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' => !($from === now()->format('Y-m-d') && $to === now()->format('Y-m-d')),
                    ])>Hoy</button>
                <button wire:click="filter('7')"
                    class="text-xs px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">7 días</button>
                <button wire:click="filter('30')"
                    class="text-xs px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">30 días</button>
                <button wire:click="filter('12')"
                    class="text-xs px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">Este año</button>
                @if ($search || $statusFilter || $priorityFilter || $assignedFilter || $categoryFilter || $from || $to)
                    <button wire:click="limpiarFiltros"
                        class="text-xs px-3 py-1 rounded-full border border-red-200 dark:border-red-700 text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition inline-flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Limpiar
                    </button>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 dark:text-gray-500">Mostrar:</span>
                <select wire:model.live="perPage"
                    class="text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ── BULK ACTIONS ────────────────────────────────────────── --}}
    @if (count($selectedTickets) > 0)
        <div class="flex items-center gap-3 mb-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-700 rounded-xl px-4 py-3">
            <input type="checkbox" wire:model.live="selectAll" class="form-checkbox text-indigo-500 rounded" />
            <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
                {{ count($selectedTickets) }} ticket(s) seleccionado(s)
            </span>
            <div class="flex items-center gap-2 ml-auto">
                <button wire:click="bulkAction('resolve')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-teal-100 dark:bg-teal-900/40 text-teal-700 dark:text-teal-300 hover:bg-teal-200 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Resolver
                </button>
                <button wire:click="bulkAction('close')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Cerrar
                </button>
                <button wire:click="bulkAction('assign_me')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-violet-100 dark:bg-violet-900/40 text-violet-700 dark:text-violet-300 hover:bg-violet-200 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Asignarme
                </button>
                <button wire:click="$set('selectedTickets', []); $set('selectAll', false)"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 hover:bg-red-200 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancelar
                </button>
            </div>
        </div>
    @endif

    {{-- ── CARD LIST ───────────────────────────────────────────── --}}
    <div wire:loading.class="opacity-50" class="transition-opacity space-y-2">

        {{-- Select all header --}}
        @if ($tickets->count() > 0)
            <div class="flex items-center gap-3 px-4 py-2 text-xs text-gray-400 dark:text-gray-500">
                <input type="checkbox" wire:model.live="selectAll" class="form-checkbox text-indigo-500 rounded" />
                <span>Seleccionar todos en esta página</span>
            </div>
        @endif

        @forelse ($tickets as $ticket)
            <div @class([
                'bg-white dark:bg-gray-800 rounded-xl border overflow-hidden shadow-xs transition hover:shadow-sm',
                'border-red-200 dark:border-red-700/50' => $ticket->isOverdue(),
                'border-gray-100 dark:border-gray-700/60' => !$ticket->isOverdue(),
            ])>
                <div class="flex items-stretch">

                    {{-- Barra de prioridad izquierda --}}
                    <div @class([
                        'w-1 shrink-0 rounded-l-xl',
                        'bg-red-500'    => $ticket->priority->value === 'urgent',
                        'bg-orange-400' => $ticket->priority->value === 'high',
                        'bg-yellow-400' => $ticket->priority->value === 'medium',
                        'bg-green-400'  => $ticket->priority->value === 'low',
                    ])></div>

                    {{-- Checkbox --}}
                    <div class="flex items-center px-3">
                        <input type="checkbox"
                            wire:model.live="selectedTickets"
                            value="{{ $ticket->id }}"
                            class="form-checkbox text-indigo-500 rounded" />
                    </div>

                    {{-- Contenido principal --}}
                    <div class="flex-1 min-w-0 py-3 pr-4">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            {{-- Código --}}
                            <a href="{{ route('admin.tickets.show', $ticket) }}"
                                class="font-mono text-xs font-bold text-violet-600 dark:text-violet-400 hover:text-violet-800 dark:hover:text-violet-200 tracking-wide">
                                {{ $ticket->code }}
                            </a>

                            {{-- Estado --}}
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $ticket->status->statusColor() }}">
                                {{ $ticket->status->label() }}
                            </span>

                            {{-- Prioridad --}}
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $ticket->priority->statusColor() }}">
                                {{ $ticket->priority->label() }}
                            </span>

                            {{-- Categoría --}}
                            @if ($ticket->category)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
                                    </svg>
                                    {{ $ticket->category->name }}
                                </span>
                            @endif

                            {{-- SLA vencido --}}
                            @if ($ticket->isOverdue())
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    SLA vencido
                                </span>
                            @elseif ($ticket->due_at)
                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                    Vence {{ $ticket->due_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>

                        {{-- Asunto --}}
                        <a href="{{ route('admin.tickets.show', $ticket) }}"
                            class="block font-semibold text-gray-800 dark:text-gray-100 hover:text-violet-600 dark:hover:text-violet-400 truncate leading-snug"
                            title="{{ $ticket->subject }}">
                            {{ $ticket->subject }}
                        </a>

                        {{-- Meta info --}}
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1.5 text-xs text-gray-400 dark:text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $ticket->customer->razon_social ?? '—' }}
                            </span>
                            @if ($ticket->assignedTo)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $ticket->assignedTo->name }}
                                </span>
                            @else
                                <span class="flex items-center gap-1 text-amber-400 dark:text-amber-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Sin asignar
                                </span>
                            @endif
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $ticket->created_at->diffForHumans() }}
                            </span>
                            @if ($ticket->last_activity_at && $ticket->last_activity_at->ne($ticket->created_at))
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Actividad {{ $ticket->last_activity_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="flex items-center gap-1 pr-4 shrink-0">
                        <button wire:click="$dispatch('open-ticket-quickview', { ticketId: {{ $ticket->id }} })"
                            title="Vista rápida"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-violet-600 hover:bg-violet-50 dark:hover:bg-violet-900/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <a href="{{ route('admin.tickets.show', $ticket) }}"
                            title="Ver detalle"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                        <button wire:click="openModalEdit({{ $ticket->id }})"
                            title="Editar"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        @can('eliminar-ticket')
                            <button wire:click="openModalDelete({{ $ticket->id }})"
                                title="Eliminar"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700/60 p-12 text-center">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="font-medium text-gray-500 dark:text-gray-400">No hay tickets que coincidan</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Ajusta los filtros o crea un nuevo ticket</p>
                <button wire:click="limpiarFiltros" class="mt-4 text-sm text-violet-600 dark:text-violet-400 hover:underline">
                    Limpiar filtros
                </button>
            </div>
        @endforelse

    </div>

    {{-- ── PAGINACIÓN ──────────────────────────────────────────── --}}
    @if ($tickets->hasPages())
        <div class="mt-6">
            {{ $tickets->links() }}
        </div>
    @endif

    {{-- Spinner global --}}
    <div wire:loading class="fixed bottom-6 right-6 bg-gray-900 dark:bg-gray-700 text-white text-xs px-4 py-2 rounded-lg shadow-lg flex items-center gap-2 z-50">
        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        Cargando...
    </div>

</div>
