<div
    class="flex h-[calc(100vh-4rem)] w-full overflow-hidden bg-gray-100 dark:bg-gray-950"
    x-data="{ hasConversation: @js(filled($conversation)) }"
    x-on:conversation-selected.window="hasConversation = true"
>
    {{-- LEFT PANE · Conversation list --}}
    <aside
        @class([
            'flex w-full flex-col border-r border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900',
            'md:flex md:w-80 lg:w-96 md:shrink-0',
            'hidden md:flex' => filled($conversation),
        ])
    >
        <livewire:admin.whats-fleep.inbox.conversation-list />
    </aside>

    {{-- CENTER PANE · Active conversation --}}
    <main
        @class([
            'relative flex flex-1 flex-col',
            'bg-[#efeae2] dark:bg-gray-950',
            'hidden md:flex' => blank($conversation),
            'flex' => filled($conversation),
        ])
    >
        {{-- Subtle WhatsApp-style textured backdrop --}}
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.06] dark:opacity-[0.04]"
            style="background-image: radial-gradient(circle at 1px 1px, currentColor 1px, transparent 0); background-size: 22px 22px;"
            aria-hidden="true"
        ></div>

        @if (filled($conversation))
            <livewire:admin.whats-fleep.inbox.conversation-header
                :uuid="$conversation"
                :key="'header-'.$conversation"
            />

            <livewire:admin.whats-fleep.inbox.conversation-view
                :uuid="$conversation"
                :key="'view-'.$conversation"
            />

            <livewire:admin.whats-fleep.inbox.message-composer
                :uuid="$conversation"
                :key="'composer-'.$conversation"
            />
        @else
            {{-- Empty state · WhatsApp Web style --}}
            <div class="relative z-10 flex flex-1 flex-col items-center justify-center px-8 text-center">
                <div class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-emerald-500/10 ring-1 ring-emerald-500/20 dark:bg-emerald-400/10">
                    <svg class="h-12 w-12 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm0 18.13c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.26 8.26 0 0 1-1.26-4.39c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.42 5.83c0 4.54-3.7 8.24-8.24 8.24z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold tracking-tight text-gray-800 dark:text-gray-100">
                    Selecciona una conversación
                </h2>
                <p class="mt-2 max-w-sm text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Elige un chat de la lista para ver los mensajes y responder a tus contactos desde un solo lugar.
                </p>
                <div class="mt-6 flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                    <span>Tus mensajes están protegidos.</span>
                </div>
            </div>
        @endif
    </main>

    {{-- RIGHT PANE · Contact panel --}}
    @if (filled($conversation))
        <aside class="hidden w-80 shrink-0 border-l border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 xl:flex xl:flex-col">
            <livewire:admin.whats-fleep.inbox.contact-panel
                :uuid="$conversation"
                :key="'panel-'.$conversation"
            />
        </aside>
    @endif
</div>
