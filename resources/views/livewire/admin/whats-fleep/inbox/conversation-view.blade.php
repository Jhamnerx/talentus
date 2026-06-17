@php
    $statusGlyphs = ['pending', 'sent', 'delivered', 'read', 'failed'];
@endphp

<div class="relative z-10 min-h-0 flex-1" x-data="{
    atBottom: true,
    hasNew: false,
    scrollDown(smooth = false) {
        const el = this.$refs.scroller;
        if (!el) return;
        el.scrollTo({ top: el.scrollHeight, behavior: smooth ? 'smooth' : 'auto' });
        this.atBottom = true;
        this.hasNew = false;
    },
    onScroll() {
        const el = this.$refs.scroller;
        if (!el) return;
        this.atBottom = (el.scrollHeight - el.scrollTop - el.clientHeight) < 80;
        if (this.atBottom) this.hasNew = false;
    },
}" x-init="$nextTick(() => scrollDown());
$wire.on('messages-refreshed', () => {
    $nextTick(() => {
        if (atBottom) { scrollDown(true); } else { hasNew = true; }
    });
});">
    {{-- ── Scrollable message history ─────────────────────────── --}}
    <div x-ref="scroller" x-on:scroll.passive="onScroll()"
        class="h-full overflow-y-auto scroll-smooth px-4 py-5 sm:px-8 lg:px-16">
        @if ($messages->isNotEmpty())
            {{-- Load more --}}
            <div class="mb-4 flex justify-center gap-2">
                <button type="button" wire:click="loadMore" wire:loading.attr="disabled" wire:target="loadMore"
                    class="inline-flex items-center gap-1.5 rounded-full bg-white/80 px-4 py-1.5 text-xs font-medium text-gray-600 shadow-sm ring-1 ring-black/5 backdrop-blur transition hover:bg-white hover:text-gray-900 disabled:opacity-60 dark:bg-gray-800/80 dark:text-gray-300 dark:ring-white/5 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                    <svg wire:loading wire:target="loadMore" class="h-3.5 w-3.5 animate-spin" fill="none"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z">
                        </path>
                    </svg>
                    <svg wire:loading.remove wire:target="loadMore" class="h-3.5 w-3.5" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75 12 8.25l7.5 7.5" />
                    </svg>
                    Cargar más
                </button>
                <button type="button" wire:click="syncHistory" wire:loading.attr="disabled" wire:target="syncHistory"
                    class="inline-flex items-center gap-1.5 rounded-full bg-white/80 px-4 py-1.5 text-xs font-medium text-gray-600 shadow-sm ring-1 ring-black/5 backdrop-blur transition hover:bg-white hover:text-gray-900 disabled:opacity-60 dark:bg-gray-800/80 dark:text-gray-300 dark:ring-white/5 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                    <svg wire:loading wire:target="syncHistory" class="h-3.5 w-3.5 animate-spin" fill="none"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z">
                        </path>
                    </svg>
                    <svg wire:loading.remove wire:target="syncHistory" class="h-3.5 w-3.5" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Sincronizar historial
                </button>
            </div>
        @endif

        @php $lastDate = null; @endphp
        @forelse ($messages as $m)
            @php
                $isContact = $m->sender_type->value === 'contact';
                $msgDate = $m->created_at?->format('Y-m-d');
                $showSeparator = $msgDate !== $lastDate;
                $lastDate = $msgDate;
                $type = $m->type?->value;
                $hasMedia = filled($m->media_path);
                $mediaUrl = $hasMedia ? $m->mediaUrl() : null;
                $status = $m->status?->value;
            @endphp

            {{-- Date separator --}}
            @if ($showSeparator && $m->created_at)
                <div class="my-4 flex justify-center" wire:key="sep-{{ $msgDate }}">
                    <span
                        class="rounded-lg bg-white/85 px-3 py-1 text-[11px] font-medium uppercase tracking-wide text-gray-500 shadow-sm ring-1 ring-black/5 backdrop-blur dark:bg-gray-800/85 dark:text-gray-300 dark:ring-white/5">
                        @if ($m->created_at->isToday())
                            Hoy
                        @elseif ($m->created_at->isYesterday())
                            Ayer
                        @else
                            {{ $m->created_at->translatedFormat('d M Y') }}
                        @endif
                    </span>
                </div>
            @endif

            {{-- Message row --}}
            <div wire:key="msg-{{ $m->id }}" @class([
                'flex w-full',
                'justify-start' => $isContact,
                'justify-end' => !$isContact,
            ])>
                <div @class([
                    'group relative my-1 max-w-[78%] rounded-2xl px-3 py-2 text-sm shadow-sm sm:max-w-[68%] lg:max-w-[58%]',
                    'rounded-tl-md bg-white text-gray-800 ring-1 ring-black/5 dark:bg-gray-800 dark:text-gray-100 dark:ring-white/5' => $isContact,
                    'rounded-tr-md bg-emerald-100 text-gray-900 ring-1 ring-emerald-600/10 dark:bg-emerald-600/25 dark:text-emerald-50 dark:ring-emerald-400/10' => !$isContact,
                ])>
                    {{-- Media --}}
                    @if ($hasMedia && $mediaUrl)
                        @if ($type === 'image')
                            <a href="{{ $mediaUrl }}" target="_blank" rel="noopener" class="block">
                                <img src="{{ $mediaUrl }}" alt="{{ $m->file_name ?? 'Imagen' }}" loading="lazy"
                                    class="mb-1 max-h-80 w-full max-w-xs rounded-lg object-cover" />
                            </a>
                        @elseif ($type === 'audio')
                            <audio controls preload="none" src="{{ $mediaUrl }}"
                                class="mb-1 w-56 max-w-full"></audio>
                        @elseif ($type === 'video')
                            <video controls preload="metadata" class="mb-1 max-h-80 w-full max-w-xs rounded-lg">
                                <source src="{{ $mediaUrl }}" type="{{ $m->mime_type }}">
                            </video>
                        @else
                            <a href="{{ $mediaUrl }}" target="_blank" rel="noopener"
                                class="mb-1 flex items-center gap-3 rounded-lg bg-black/5 px-3 py-2 transition hover:bg-black/10 dark:bg-white/5 dark:hover:bg-white/10">
                                <span
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-500/15 text-emerald-600 dark:text-emerald-300">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span
                                        class="block truncate text-[13px] font-medium">{{ $m->file_name ?? 'Documento' }}</span>
                                    <span
                                        class="block text-[11px] text-gray-500 dark:text-gray-400">{{ strtoupper($m->mime_type ? pathinfo($m->file_name ?? '', PATHINFO_EXTENSION) : 'Archivo') ?: 'Archivo' }}</span>
                                </span>
                            </a>
                        @endif
                    @endif

                    {{-- Body --}}
                    @if (filled($m->body))
                        <p class="whitespace-pre-line break-words leading-relaxed">{{ $m->body }}</p>
                    @endif

                    {{-- Meta: time + status --}}
                    <div @class([
                        'mt-0.5 flex items-center justify-end gap-1 text-[10px] tabular-nums leading-none',
                        'text-gray-400 dark:text-gray-500' => $isContact,
                        'text-emerald-700/70 dark:text-emerald-200/70' => !$isContact,
                    ])>
                        <span>{{ $m->created_at?->format('H:i') }}</span>

                        @unless ($isContact)
                            @if ($status === 'pending')
                                <svg class="h-3 w-3 animate-pulse" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6l3.5 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            @elseif ($status === 'sent')
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.5 4 4L19 6" />
                                </svg>
                            @elseif ($status === 'delivered')
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.2"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m1.5 12.5 4 4L15 6m1.5 10.5L22 6" />
                                </svg>
                            @elseif ($status === 'read')
                                <svg class="h-3.5 w-3.5 text-sky-500 dark:text-sky-400" fill="none" stroke="currentColor"
                                    stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m1.5 12.5 4 4L15 6m1.5 10.5L22 6" />
                                </svg>
                            @elseif ($status === 'failed')
                                <svg class="h-3.5 w-3.5 text-rose-500" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m0 3.75h.008M10.36 3.6 1.95 18a1.5 1.5 0 0 0 1.29 2.25h16.52A1.5 1.5 0 0 0 21.05 18L12.64 3.6a1.5 1.5 0 0 0-2.28 0Z" />
                                </svg>
                            @endif
                        @endunless
                    </div>
                </div>
            </div>
        @empty
            <div class="flex h-full flex-col items-center justify-center text-center">
                <div
                    class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-white/70 shadow-sm ring-1 ring-black/5 dark:bg-gray-800/70 dark:ring-white/5">
                    <svg class="h-7 w-7 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                        stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 10.5h8M8 14h5m-9 7 1.9-1.9A2 2 0 0 1 7.3 18.5h9.4a3 3 0 0 0 3-3v-7a3 3 0 0 0-3-3H6.3a3 3 0 0 0-3 3v12.6Z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Aún no hay mensajes</p>
                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Envía el primer mensaje para iniciar la
                    conversación.</p>
            </div>
        @endforelse
    </div>

    {{-- ── "Nuevos mensajes" affordance ───────────────────────── --}}
    <div x-cloak x-show="hasNew" x-transition.opacity
        class="pointer-events-none absolute inset-x-0 bottom-4 z-20 flex justify-center">
        <button type="button" x-on:click="scrollDown(true)"
            class="pointer-events-auto inline-flex items-center gap-1.5 rounded-full bg-emerald-500 px-4 py-2 text-xs font-semibold text-white shadow-lg ring-1 ring-emerald-600/30 transition hover:bg-emerald-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25 12 15.75 4.5 8.25" />
            </svg>
            Nuevos mensajes
        </button>
    </div>
</div>
