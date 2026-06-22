@php
    $priorityStyles = [
        'low'       => ['dot' => 'bg-gray-400 dark:bg-gray-500',   'chip' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300',          'label' => 'Baja'],
        'high'      => ['dot' => 'bg-amber-500',                   'chip' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300',   'label' => 'Alta'],
        'emergency' => ['dot' => 'bg-rose-500',                    'chip' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300',       'label' => 'Urgente'],
    ];
@endphp

<div class="flex h-full w-full flex-col bg-white dark:bg-gray-900">
    {{-- ── Header ─────────────────────────────────────────────── --}}
    <div class="shrink-0 border-b border-gray-200 px-4 pb-3 pt-4 dark:border-gray-800">
        <div class="mb-3 flex items-center justify-between">
            <h1 class="text-base font-semibold tracking-tight text-gray-900 dark:text-gray-100">
                Conversaciones
            </h1>
            <span
                wire:loading.delay
                wire:target="search, estado, asignacion, nextPage, previousPage, gotoPage"
                class="flex items-center gap-1.5 text-[11px] font-medium text-gray-400 dark:text-gray-500"
            >
                <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z"></path>
                </svg>
                Cargando
            </span>
        </div>

        {{-- Search --}}
        <div class="relative">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3m1.8-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar por nombre o número…"
                class="w-full rounded-xl border border-gray-200 bg-gray-50 py-2 pl-9 pr-3 text-sm text-gray-800 placeholder-gray-400 transition focus:border-emerald-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-emerald-500 dark:focus:bg-gray-800"
            />
        </div>

        {{-- Estado tabs --}}
        <div class="mt-3 flex items-center gap-1 rounded-xl bg-gray-100 p-1 dark:bg-gray-800/80">
            @foreach (['open' => 'Abiertas', 'pending' => 'Pendientes', 'closed' => 'Cerradas'] as $value => $label)
                <button
                    type="button"
                    wire:click="$set('estado', '{{ $value }}')"
                    @class([
                        'flex-1 rounded-lg px-2 py-1.5 text-xs font-medium transition',
                        'bg-white text-gray-900 shadow-sm dark:bg-gray-700 dark:text-gray-100' => $estado === $value,
                        'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200' => $estado !== $value,
                    ])
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Asignación segmented --}}
        <div class="mt-2 flex items-center gap-1.5 text-xs">
            @foreach (['todas' => 'Todas', 'mias' => 'Mías', 'sin_asignar' => 'Sin asignar'] as $value => $label)
                <button
                    type="button"
                    wire:click="$set('asignacion', '{{ $value }}')"
                    @class([
                        'rounded-full px-3 py-1 font-medium transition ring-1',
                        'bg-emerald-50 text-emerald-700 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/30' => $asignacion === $value,
                        'bg-transparent text-gray-500 ring-gray-200 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-200' => $asignacion !== $value,
                    ])
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- ── Scrollable list ────────────────────────────────────── --}}
    <div class="min-h-0 flex-1 overflow-y-auto">
        @forelse ($conversations as $c)
            @php
                $displayName = $c->cliente?->razon_social ?? $c->contact?->push_name ?? $c->contact?->name ?? $c->contact?->number ?? 'Sin nombre';
                $initial = mb_strtoupper(mb_substr(trim($displayName), 0, 1)) ?: '?';
                $priority = $c->priority?->value;
                $hasPriority = $priority && $priority !== 'normal';
            @endphp

            <button
                type="button"
                wire:key="conv-{{ $c->id }}"
                wire:click="select('{{ $c->uuid }}')"
                @class([
                    'group relative flex w-full items-start gap-3 border-b border-gray-100 px-4 py-3 text-left transition dark:border-gray-800/70',
                    'bg-emerald-50/60 dark:bg-emerald-500/[0.07]' => $selected === $c->uuid,
                    'hover:bg-gray-50 dark:hover:bg-gray-800/60' => $selected !== $c->uuid,
                ])
            >
                {{-- Active indicator bar --}}
                @if ($selected === $c->uuid)
                    <span class="absolute inset-y-0 left-0 w-0.5 bg-emerald-500" aria-hidden="true"></span>
                @endif

                {{-- Avatar --}}
                <div class="relative shrink-0">
                    @if ($c->contact?->profile_pic_url)
                        <img src="{{ $c->contact->profile_pic_url }}" alt="{{ $displayName }}"
                            class="h-11 w-11 rounded-full object-cover shadow-sm">
                    @else
                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-sm font-semibold text-white shadow-sm dark:from-emerald-500 dark:to-teal-600">
                            {{ $initial }}
                        </div>
                    @endif
                    @if ($hasPriority)
                        <span
                            @class(['absolute -right-0.5 -top-0.5 h-3 w-3 rounded-full ring-2 ring-white dark:ring-gray-900', $priorityStyles[$priority]['dot'] ?? 'bg-gray-400'])
                            aria-hidden="true"
                        ></span>
                    @endif
                </div>

                {{-- Body --}}
                <div class="min-w-0 flex-1">
                    <div class="flex items-baseline justify-between gap-2">
                        <p @class([
                            'truncate text-sm',
                            'font-semibold text-gray-900 dark:text-gray-50' => $c->unread_count > 0,
                            'font-medium text-gray-800 dark:text-gray-100' => $c->unread_count === 0,
                        ])>
                            {{ $displayName }}
                        </p>
                        @if ($c->last_message_at)
                            <span @class([
                                'shrink-0 text-[11px] tabular-nums',
                                'font-semibold text-emerald-600 dark:text-emerald-400' => $c->unread_count > 0,
                                'text-gray-400 dark:text-gray-500' => $c->unread_count === 0,
                            ])>
                                {{ $c->last_message_at->diffForHumans(null, true) }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-0.5 flex items-center justify-between gap-2">
                        <p @class([
                            'truncate text-xs',
                            'text-gray-600 dark:text-gray-300' => $c->unread_count > 0,
                            'text-gray-500 dark:text-gray-400' => $c->unread_count === 0,
                        ])>
                            {{ $c->lastMessage?->body ?? '—' }}
                        </p>
                        @if ($c->unread_count > 0)
                            <span class="flex h-5 min-w-[1.25rem] shrink-0 items-center justify-center rounded-full bg-emerald-500 px-1.5 text-[11px] font-bold leading-none text-white shadow-sm">
                                {{ $c->unread_count > 99 ? '99+' : $c->unread_count }}
                            </span>
                        @endif
                    </div>

                    {{-- Meta chips --}}
                    @if ($c->assignedUser?->name || $hasPriority)
                        <div class="mt-1.5 flex flex-wrap items-center gap-1.5">
                            @if ($c->assignedUser?->name)
                                <span class="inline-flex items-center gap-1 rounded-md bg-gray-100 px-1.5 py-0.5 text-[10px] font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                    <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                    </svg>
                                    {{ $c->assignedUser->name }}
                                </span>
                            @endif
                            @if ($hasPriority)
                                <span @class(['inline-flex items-center rounded-md px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide', $priorityStyles[$priority]['chip'] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300'])>
                                    {{ $priorityStyles[$priority]['label'] ?? $priority }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </button>
        @empty
            <div class="flex h-full flex-col items-center justify-center px-6 py-16 text-center">
                <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                    <svg class="h-7 w-7 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5h8M8 14h5m-9 7 1.9-1.9A2 2 0 0 1 7.3 18.5h9.4a3 3 0 0 0 3-3v-7a3 3 0 0 0-3-3H6.3a3 3 0 0 0-3 3v12.6Z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">Sin conversaciones</p>
                <p class="mt-1 max-w-[14rem] text-xs leading-relaxed text-gray-400 dark:text-gray-500">
                    No hay chats que coincidan con los filtros seleccionados.
                </p>
            </div>
        @endforelse
    </div>

    {{-- ── Pagination ─────────────────────────────────────────── --}}
    @if ($conversations->hasPages())
        <div class="shrink-0 border-t border-gray-200 px-3 py-2 dark:border-gray-800">
            {{ $conversations->links() }}
        </div>
    @endif
</div>
