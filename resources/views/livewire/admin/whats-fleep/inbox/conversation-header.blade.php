@php
    $statusStyles = [
        'open'    => ['chip' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300', 'label' => 'Abierta'],
        'pending' => ['chip' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300',       'label' => 'Pendiente'],
        'closed'  => ['chip' => 'bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300',              'label' => 'Cerrada'],
    ];
    $priorityStyles = [
        'low'       => ['dot' => 'bg-gray-400 dark:bg-gray-500', 'chip' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300',          'label' => 'Baja'],
        'normal'    => ['dot' => 'bg-sky-400',                   'chip' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/15 dark:text-sky-300',           'label' => 'Normal'],
        'high'      => ['dot' => 'bg-amber-500',                 'chip' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300',   'label' => 'Alta'],
        'emergency' => ['dot' => 'bg-rose-500',                  'chip' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300',       'label' => 'Urgente'],
    ];

    $displayName = $conversation?->cliente?->razon_social
        ?? $conversation?->contact?->push_name
        ?? $conversation?->contact?->number
        ?? 'Sin nombre';
    $initial = mb_strtoupper(mb_substr(trim($displayName), 0, 1)) ?: '?';
    $status = $conversation?->status?->value;
    $priority = $conversation?->priority?->value;
@endphp

<div class="shrink-0 border-b border-gray-200 bg-white px-4 py-2.5 dark:border-gray-800 dark:bg-gray-900">
    <div class="flex items-center justify-between gap-3">
        {{-- ── Identity ───────────────────────────────────────── --}}
        <div class="flex min-w-0 items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-sm font-semibold text-white shadow-sm dark:from-emerald-500 dark:to-teal-600">
                {{ $initial }}
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $displayName }}</p>
                <div class="mt-0.5 flex flex-wrap items-center gap-1.5">
                    @if ($conversation?->contact?->number)
                        <span class="text-xs tabular-nums text-gray-500 dark:text-gray-400">{{ $conversation->contact->number }}</span>
                    @endif
                    @if ($status && isset($statusStyles[$status]))
                        <span @class(['inline-flex items-center rounded-md px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide', $statusStyles[$status]['chip']])>
                            {{ $statusStyles[$status]['label'] }}
                        </span>
                    @endif
                    @if ($priority && isset($priorityStyles[$priority]))
                        <span @class(['inline-flex items-center gap-1 rounded-md px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide', $priorityStyles[$priority]['chip']])>
                            <span @class(['h-1.5 w-1.5 rounded-full', $priorityStyles[$priority]['dot']]) aria-hidden="true"></span>
                            {{ $priorityStyles[$priority]['label'] }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Actions ────────────────────────────────────────── --}}
        <div class="flex shrink-0 items-center gap-1.5">
            {{-- Assignee / Asignarme --}}
            @if ($conversation?->assignedUser?->name)
                <span class="hidden items-center gap-1.5 rounded-lg bg-gray-100 px-2.5 py-1.5 text-xs font-medium text-gray-700 sm:inline-flex dark:bg-gray-800 dark:text-gray-200">
                    <svg class="h-3.5 w-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                    </svg>
                    {{ $conversation->assignedUser->name }}
                </span>
            @else
                <button
                    type="button"
                    wire:click="assignToMe"
                    wire:loading.attr="disabled"
                    wire:target="assignToMe"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-emerald-600 disabled:opacity-60"
                >
                    <svg wire:loading wire:target="assignToMe" class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z"></path>
                    </svg>
                    <svg wire:loading.remove wire:target="assignToMe" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Asignarme
                </button>
            @endif

            {{-- Primary status toggle --}}
            @if ($status === 'closed')
                <button
                    type="button"
                    wire:click="setStatus('open')"
                    wire:loading.attr="disabled"
                    wire:target="setStatus"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 disabled:opacity-60 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 9.75V7.5a4.5 4.5 0 0 0-9 0v3m12 0H4.5a1.5 1.5 0 0 0-1.5 1.5v7.5A1.5 1.5 0 0 0 4.5 21h15a1.5 1.5 0 0 0 1.5-1.5V12a1.5 1.5 0 0 0-1.5-1.5Z" />
                    </svg>
                    Reabrir
                </button>
            @else
                <button
                    type="button"
                    wire:click="setStatus('closed')"
                    wire:loading.attr="disabled"
                    wire:target="setStatus"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 disabled:opacity-60 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Cerrar
                </button>
            @endif

            {{-- ── Kebab: reassign + priority ─────────────────── --}}
            <div x-data="{ open: false }" class="relative" x-on:keydown.escape.window="open = false">
                <button
                    type="button"
                    x-on:click="open = ! open"
                    :class="open ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200'"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg transition"
                    aria-label="Más acciones"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75h.008v.008H12V6.75Zm0 5.25h.008v.008H12V12Zm0 5.25h.008v.008H12v-.008Z" />
                    </svg>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition.opacity.duration.150ms
                    x-on:click.outside="open = false"
                    class="absolute right-0 z-30 mt-2 w-64 origin-top-right rounded-xl border border-gray-200 bg-white p-3 shadow-lg ring-1 ring-black/5 dark:border-gray-700 dark:bg-gray-800 dark:ring-white/5"
                >
                    {{-- Reassign --}}
                    <p class="px-1 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">Reasignar agente</p>
                    <div class="mt-1.5 flex items-center gap-1.5">
                        <select
                            wire:model="reassignTo"
                            class="min-w-0 flex-1 rounded-lg border border-gray-200 bg-gray-50 py-1.5 pl-2 pr-7 text-xs text-gray-800 transition focus:border-emerald-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:focus:border-emerald-500"
                        >
                            <option value="">Selecciona un agente…</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                        <button
                            type="button"
                            wire:click="reassign"
                            wire:loading.attr="disabled"
                            wire:target="reassign"
                            class="inline-flex h-[1.875rem] items-center justify-center rounded-lg bg-emerald-500 px-2.5 text-xs font-semibold text-white transition hover:bg-emerald-600 disabled:opacity-60"
                        >
                            <svg wire:loading wire:target="reassign" class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="reassign">Aplicar</span>
                        </button>
                    </div>

                    <div class="my-3 h-px bg-gray-100 dark:bg-gray-700"></div>

                    {{-- Priority --}}
                    <p class="px-1 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">Prioridad</p>
                    <div class="mt-1.5 grid grid-cols-2 gap-1.5">
                        @foreach (['low', 'normal', 'high', 'emergency'] as $p)
                            <button
                                type="button"
                                wire:click="setPriority('{{ $p }}')"
                                @class([
                                    'inline-flex items-center gap-1.5 rounded-lg px-2 py-1.5 text-xs font-medium transition ring-1',
                                    $priorityStyles[$p]['chip'] . ' ring-transparent' => $priority === $p,
                                    'bg-transparent text-gray-600 ring-gray-200 hover:bg-gray-50 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700/60' => $priority !== $p,
                                ])
                            >
                                <span @class(['h-1.5 w-1.5 rounded-full', $priorityStyles[$p]['dot']]) aria-hidden="true"></span>
                                {{ $priorityStyles[$p]['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
