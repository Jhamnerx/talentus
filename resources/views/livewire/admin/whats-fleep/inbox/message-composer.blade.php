<div
    class="relative z-10 shrink-0 border-t border-black/5 bg-[#f0f2f5] px-3 py-3 sm:px-4 dark:border-white/5 dark:bg-gray-900"
>
    {{-- ── Quick replies dropdown ─────────────────────────────── --}}
    @if (str_starts_with($body, '/') && $quickReplies->isNotEmpty())
        <div class="absolute bottom-full left-3 right-3 z-30 mb-2 sm:left-4 sm:right-4">
            <div class="max-h-64 overflow-y-auto rounded-2xl border border-gray-200 bg-white py-1.5 shadow-xl ring-1 ring-black/5 dark:border-gray-700 dark:bg-gray-800 dark:ring-white/10">
                <p class="px-3 pb-1 pt-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                    Respuestas rápidas
                </p>
                @foreach ($quickReplies as $qr)
                    <button
                        type="button"
                        wire:key="qr-{{ $qr->id }}"
                        wire:click="applyQuickReply({{ $qr->id }})"
                        class="flex w-full items-start gap-3 px-3 py-2 text-left transition hover:bg-emerald-50 dark:hover:bg-emerald-500/10"
                    >
                        <span class="mt-0.5 inline-flex shrink-0 items-center rounded-md bg-gray-100 px-1.5 py-0.5 font-mono text-[11px] font-medium text-gray-500 dark:bg-gray-700 dark:text-gray-300">
                            /{{ $qr->shortcut }}
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block truncate text-sm font-medium text-gray-800 dark:text-gray-100">{{ $qr->title }}</span>
                            <span class="block truncate text-xs text-gray-400 dark:text-gray-500">{{ \Illuminate\Support\Str::limit($qr->body, 64) }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── Attachment preview row ─────────────────────────────── --}}
    @if ($attachment)
        <div class="mb-2 rounded-2xl border border-emerald-200 bg-white p-3 shadow-sm dark:border-emerald-500/30 dark:bg-gray-800">
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-300">
                    @if (\Illuminate\Support\Str::startsWith($attachment->getMimeType(), 'image/'))
                        <img src="{{ $attachment->temporaryUrl() }}" alt="preview" class="h-full w-full object-cover" />
                    @else
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-gray-800 dark:text-gray-100">
                        {{ $attachment->getClientOriginalName() }}
                    </p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500">
                        {{ number_format($attachment->getSize() / 1024, 0) }} KB
                    </p>
                    <input
                        type="text"
                        wire:model.live="caption"
                        placeholder="Añade un comentario…"
                        class="mt-2 w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm text-gray-800 placeholder-gray-400 focus:border-emerald-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
                    />
                </div>

                <button
                    type="button"
                    wire:click="$set('attachment', null)"
                    class="shrink-0 rounded-full p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                    title="Quitar"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-2 flex items-center justify-end gap-2">
                <button
                    type="button"
                    wire:click="sendAttachment"
                    wire:loading.attr="disabled"
                    wire:target="attachment,sendAttachment"
                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500 px-4 py-1.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <svg wire:loading wire:target="attachment,sendAttachment" class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="attachment,sendAttachment">Enviar archivo</span>
                    <span wire:loading wire:target="attachment,sendAttachment">Enviando…</span>
                </button>
            </div>
        </div>
    @endif

    @error('attachment')
        <p class="mb-2 px-1 text-xs font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
    @enderror

    {{-- ── Composer bar ───────────────────────────────────────── --}}
    <div class="flex items-end gap-2">
        {{-- Attachment / clip button --}}
        <label
            class="flex h-10 w-10 shrink-0 cursor-pointer items-center justify-center rounded-full text-gray-500 transition hover:bg-black/5 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200"
            title="Adjuntar archivo"
        >
            <input type="file" wire:model="attachment" class="hidden" />
            <svg wire:loading.remove wire:target="attachment" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
            </svg>
            <svg wire:loading wire:target="attachment" class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z"></path>
            </svg>
        </label>

        {{-- Text input --}}
        <div
            class="flex min-w-0 flex-1 items-end rounded-3xl bg-white px-4 py-2 shadow-sm ring-1 ring-black/5 focus-within:ring-2 focus-within:ring-emerald-500/30 dark:bg-gray-800 dark:ring-white/5"
            x-data="{
                resize() {
                    const el = this.$refs.ta;
                    el.style.height = 'auto';
                    el.style.height = Math.min(el.scrollHeight, 160) + 'px';
                },
            }"
            x-init="$nextTick(() => resize())"
        >
            <textarea
                x-ref="ta"
                rows="1"
                wire:model.live="body"
                x-on:input="resize()"
                x-on:keydown.enter="if (! $event.shiftKey) { $event.preventDefault(); $wire.sendText(); $nextTick(() => resize()); }"
                placeholder="Escribe un mensaje…   (usa / para respuestas rápidas)"
                class="max-h-40 w-full resize-none border-0 bg-transparent py-1 text-sm leading-relaxed text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 dark:text-gray-100 dark:placeholder-gray-500"
            ></textarea>
        </div>

        {{-- Send button --}}
        <button
            type="button"
            wire:click="sendText"
            wire:loading.attr="disabled"
            wire:target="sendText"
            @disabled(trim($body) === '')
            @class([
                'flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-white shadow-sm transition',
                'bg-emerald-500 hover:bg-emerald-600' => trim($body) !== '',
                'cursor-not-allowed bg-gray-300 dark:bg-gray-700' => trim($body) === '',
            ])
            title="Enviar"
        >
            <svg wire:loading.remove wire:target="sendText" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3.4 20.4 21.85 12.5a.5.5 0 0 0 0-.92L3.4 3.6a.5.5 0 0 0-.69.62L5.1 11.2l9.4.8-9.4.8-2.39 6.98a.5.5 0 0 0 .69.62Z" />
            </svg>
            <svg wire:loading wire:target="sendText" class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.4 0 0 5.4 0 12h4z"></path>
            </svg>
        </button>
    </div>
</div>
