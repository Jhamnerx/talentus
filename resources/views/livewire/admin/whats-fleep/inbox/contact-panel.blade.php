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
        @if ($conversation?->contact?->profile_pic_url)
            <img src="{{ $conversation->contact->profile_pic_url }}" alt="{{ $contactName }}"
                class="mx-auto h-16 w-16 rounded-full object-cover shadow-sm">
        @else
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-xl font-semibold text-white shadow-sm dark:from-emerald-500 dark:to-teal-600">
                {{ $initial }}
            </div>
        @endif
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
                <div class="flex items-start justify-between gap-3">
                    <dt class="shrink-0 text-xs text-gray-500 dark:text-gray-400">Dispositivo</dt>
                    <dd class="min-w-0 truncate text-right text-xs font-medium text-gray-800 dark:text-gray-100">{{ $conversation?->device?->body ?? '—' }}</dd>
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

        {{-- ── Ticket vinculado ──────────────────────────────────── --}}
        <section>
            <h3 class="mb-2 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                <svg class="h-3 w-3 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a3 3 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                </svg>
                Ticket
            </h3>

            @if ($conversation?->ticket_id && $conversation->ticket)
                @php $ticket = $conversation->ticket; @endphp
                <div class="rounded-xl bg-indigo-50/70 p-3 ring-1 ring-indigo-100 dark:bg-indigo-500/[0.06] dark:ring-indigo-500/20">
                    <div class="mb-2 flex items-center justify-between gap-2">
                        <span class="shrink-0 rounded bg-indigo-100 px-1.5 py-0.5 text-[10px] font-bold tabular-nums text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                            {{ $ticket->code }}
                        </span>
                        <span @class(['inline-flex shrink-0 items-center rounded-md px-1.5 py-0.5 text-[10px] font-semibold', $ticket->status->statusColor()])>
                            {{ $ticket->status->label() }}
                        </span>
                    </div>
                    <p class="mb-2 line-clamp-2 text-xs font-medium text-gray-800 dark:text-gray-100">{{ $ticket->subject }}</p>
                    <span @class(['inline-flex items-center rounded-md px-1.5 py-0.5 text-[10px] font-semibold', $ticket->priority->statusColor()])>
                        {{ $ticket->priority->label() }}
                    </span>
                    <div class="mt-3 flex items-center justify-between gap-2">
                        <a
                            href="{{ route('admin.tickets.show', $ticket) }}"
                            target="_blank"
                            class="text-xs font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200"
                        >
                            Ver ticket →
                        </a>
                        @can('reply', $conversation)
                            <button
                                type="button"
                                wire:click="unlinkTicket"
                                class="text-xs text-gray-400 hover:text-red-500 dark:text-gray-500 dark:hover:text-red-400"
                            >
                                Desvincular
                            </button>
                        @endcan
                    </div>
                </div>
            @else
                @can('reply', $conversation)
                    <div class="space-y-2">
                        <div class="relative" x-data @click.outside="$wire.set('ticketSearch', '')">
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="ticketSearch"
                                placeholder="Buscar por código o asunto…"
                                class="form-input w-full rounded-lg text-xs"
                            />
                            @if ($ticketResults->isNotEmpty())
                                <ul class="absolute z-10 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                    @foreach ($ticketResults as $t)
                                        <li wire:key="tr-{{ $t->id }}">
                                            <button
                                                type="button"
                                                wire:click="linkTicket({{ $t->id }})"
                                                class="flex w-full items-start gap-2 px-3 py-2 text-left text-xs hover:bg-gray-50 dark:hover:bg-gray-700"
                                            >
                                                <span class="shrink-0 font-mono font-semibold text-indigo-600 dark:text-indigo-400">{{ $t->code }}</span>
                                                <span class="truncate text-gray-700 dark:text-gray-200">{{ $t->subject }}</span>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if ($conversation?->cliente_id)
                            <button
                                type="button"
                                wire:click="openCreateTicketModal"
                                class="flex w-full items-center justify-center gap-1 rounded-lg border border-dashed border-indigo-300 py-2 text-xs font-medium text-indigo-600 transition hover:border-indigo-400 hover:bg-indigo-50 dark:border-indigo-600 dark:text-indigo-400 dark:hover:bg-indigo-500/10"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                Crear ticket
                            </button>
                        @endif
                    </div>
                @else
                    <p class="rounded-lg border border-dashed border-gray-200 px-3 py-4 text-center text-xs text-gray-400 dark:border-gray-700 dark:text-gray-500">
                        Sin ticket vinculado.
                    </p>
                @endcan
            @endif
        </section>

        {{-- ── Vehículos del cliente ──────────────────────────────── --}}
        @if ($vehiculos->isNotEmpty())
            <section>
                <h3 class="mb-2 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                    <svg class="h-3 w-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    Vehículos
                </h3>
                <ul class="space-y-1.5">
                    @foreach ($vehiculos as $v)
                        <li wire:key="vh-{{ $v->id }}" class="flex items-center gap-2 rounded-lg border border-gray-100 bg-white px-3 py-2 dark:border-gray-800 dark:bg-gray-800/40">
                            <span @class([
                                'h-2 w-2 shrink-0 rounded-full',
                                'bg-emerald-400' => $v->gpswox_active,
                                'bg-gray-300 dark:bg-gray-600' => ! $v->gpswox_active,
                            ])></span>
                            <span class="font-mono text-xs font-semibold text-gray-800 dark:text-gray-100">{{ $v->placa }}</span>
                            <span class="truncate text-[11px] text-gray-500 dark:text-gray-400">{{ trim(($v->marca ?? '') . ' ' . ($v->modelo ?? '')) ?: '—' }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>

    {{-- ── Modal: Crear ticket ────────────────────────────────────── --}}
    <x-form.modal.card title="Crear ticket" max-width="lg" wire:model.live="showCreateTicketModal" align="center">
        <form autocomplete="off" @submit.prevent>
            <div class="grid grid-cols-12 gap-4 px-5 py-4">
                <div class="col-span-12">
                    <label class="mb-1 block text-sm font-medium">Asunto <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="createSubject" class="form-input w-full" placeholder="Ej: Falla en dispositivo GPS" />
                    @error('createSubject') <p class="mt-1 text-sm text-pink-600">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label class="mb-1 block text-sm font-medium">Prioridad <span class="text-red-500">*</span></label>
                    <select wire:model="createPriority" class="form-select w-full">
                        <option value="low">Baja</option>
                        <option value="medium">Media</option>
                        <option value="high">Alta</option>
                        <option value="urgent">Urgente</option>
                    </select>
                    @error('createPriority') <p class="mt-1 text-sm text-pink-600">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <label class="mb-1 block text-sm font-medium">Categoría</label>
                    <select wire:model="createCategoryId" class="form-select w-full">
                        <option value="">— Sin categoría —</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('createCategoryId') <p class="mt-1 text-sm text-pink-600">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-12">
                    <label class="mb-1 block text-sm font-medium">Descripción <span class="text-red-500">*</span></label>
                    <textarea wire:model="createDescription" rows="4" class="form-textarea w-full" placeholder="Describe el problema o solicitud…"></textarea>
                    @error('createDescription') <p class="mt-1 text-sm text-pink-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </form>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cancelar" x-on:click.prevent="$wire.set('showCreateTicketModal', false)" />
                <x-form.button primary label="Crear y vincular" wire:click.prevent="createAndLinkTicket" spinner="createAndLinkTicket" />
            </div>
        </x-slot>
    </x-form.modal.card>
</aside>
