@php
    $statusStyles = [
        'open'    => ['chip' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300', 'label' => 'Abierta'],
        'pending' => ['chip' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300',       'label' => 'Pendiente'],
        'closed'  => ['chip' => 'bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300',              'label' => 'Cerrada'],
    ];

    $contactName = $conversation?->contact?->push_name
        ?? $conversation?->contact?->number
        ?? 'Sin nombre';
    $initial = mb_strtoupper(mb_substr(trim($contactName), 0, 1)) ?: '?';
    $cliente = $conversation?->contact?->cliente;
@endphp

<aside class="flex h-full w-80 shrink-0 flex-col border-l border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
    {{-- ── Header ─────────────────────────────────────────────── --}}
    <div class="shrink-0 border-b border-gray-200 px-5 py-6 text-center dark:border-gray-800">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-xl font-semibold text-white shadow-sm dark:from-emerald-500 dark:to-teal-600">
            {{ $initial }}
        </div>
        <p class="mt-3 truncate text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $contactName }}</p>
        @if ($conversation?->contact?->number)
            <p class="mt-0.5 text-xs tabular-nums text-gray-500 dark:text-gray-400">{{ $conversation->contact->number }}</p>
        @endif
    </div>

    {{-- ── Scrollable body ────────────────────────────────────── --}}
    <div class="min-h-0 flex-1 space-y-5 overflow-y-auto px-5 py-5">
        {{-- Contacto --}}
        <section>
            <h3 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">Contacto</h3>
            <dl class="space-y-2 rounded-xl bg-gray-50 p-3 ring-1 ring-gray-100 dark:bg-gray-800/60 dark:ring-gray-800">
                <div class="flex items-start justify-between gap-3">
                    <dt class="shrink-0 text-xs text-gray-500 dark:text-gray-400">Número</dt>
                    <dd class="min-w-0 truncate text-right text-xs font-medium tabular-nums text-gray-800 dark:text-gray-100">{{ $conversation?->contact?->number ?? '—' }}</dd>
                </div>
                <div class="flex items-start justify-between gap-3">
                    <dt class="shrink-0 text-xs text-gray-500 dark:text-gray-400">Nombre WhatsApp</dt>
                    <dd class="min-w-0 truncate text-right text-xs font-medium text-gray-800 dark:text-gray-100">{{ $conversation?->contact?->push_name ?? '—' }}</dd>
                </div>
            </dl>
        </section>

        {{-- Cliente --}}
        @if ($cliente)
            <section>
                <h3 class="mb-2 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                    <svg class="h-3 w-3 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    Cliente vinculado
                </h3>
                <dl class="space-y-2 rounded-xl bg-emerald-50/70 p-3 ring-1 ring-emerald-100 dark:bg-emerald-500/[0.06] dark:ring-emerald-500/20">
                    <div class="flex items-start justify-between gap-3">
                        <dt class="shrink-0 text-xs text-gray-500 dark:text-gray-400">Razón social</dt>
                        <dd class="min-w-0 truncate text-right text-xs font-semibold text-gray-800 dark:text-gray-100">{{ $cliente->razon_social ?? '—' }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="shrink-0 text-xs text-gray-500 dark:text-gray-400">Documento</dt>
                        <dd class="min-w-0 truncate text-right text-xs font-medium tabular-nums text-gray-800 dark:text-gray-100">{{ $cliente->numero_documento ?? '—' }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="shrink-0 text-xs text-gray-500 dark:text-gray-400">Teléfono</dt>
                        <dd class="min-w-0 truncate text-right text-xs font-medium tabular-nums text-gray-800 dark:text-gray-100">{{ $cliente->telefono ?? '—' }}</dd>
                    </div>
                </dl>
            </section>
        @endif

        {{-- Otras conversaciones --}}
        <section>
            <h3 class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">Otras conversaciones</h3>
            @if ($otras->isNotEmpty())
                <ul class="space-y-1.5">
                    @foreach ($otras as $o)
                        @php
                            $oStatus = $o->status?->value;
                            $oStyle = $statusStyles[$oStatus] ?? ['chip' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300', 'label' => $oStatus ?? '—'];
                        @endphp
                        <li wire:key="otra-{{ $o->id }}">
                            <button
                                type="button"
                                wire:click="openConversation('{{ $o->uuid }}')"
                                class="flex w-full items-center justify-between gap-2 rounded-lg border border-gray-100 bg-white px-3 py-2 text-left transition hover:border-gray-200 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-800/40 dark:hover:border-gray-700 dark:hover:bg-gray-800"
                            >
                                <span @class(['inline-flex shrink-0 items-center rounded-md px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide', $oStyle['chip']])>
                                    {{ $oStyle['label'] }}
                                </span>
                                <span class="truncate text-[11px] tabular-nums text-gray-500 dark:text-gray-400">
                                    {{ $o->last_message_at?->diffForHumans() ?? '—' }}
                                </span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="rounded-lg border border-dashed border-gray-200 px-3 py-4 text-center text-xs text-gray-400 dark:border-gray-700 dark:text-gray-500">
                    Sin otras conversaciones.
                </p>
            @endif
        </section>

        {{-- SP#4: panel de vehículos/GPS/tickets aquí --}}
    </div>
</aside>
