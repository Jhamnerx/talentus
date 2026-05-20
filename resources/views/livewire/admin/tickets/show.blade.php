<div class="space-y-0">

    <!-- ══════════════════════════════════════════════════════ -->
    <!-- HEADER BANNER -->
    <!-- ══════════════════════════════════════════════════════ -->
    <div
        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden mb-6 shadow-sm">
        <!-- Barra de color según prioridad -->
        <div
            class="h-1.5 w-full
            @if ($ticket->priority->value === 'urgent') bg-red-500
            @elseif($ticket->priority->value === 'high') bg-orange-400
            @elseif($ticket->priority->value === 'medium') bg-yellow-400
            @else bg-green-400 @endif">
        </div>

        <div class="px-6 py-5 flex flex-wrap items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap">
                    <span
                        class="text-xs font-mono font-semibold text-gray-400 dark:text-gray-500 tracking-widest uppercase">{{ $ticket->code }}</span>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $ticket->status->statusColor() }}">
                        {{ $ticket->status->label() }}
                    </span>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $ticket->priority->statusColor() }}">
                        {{ $ticket->priority->label() }}
                    </span>
                    @if ($ticket->category)
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z" />
                            </svg>
                            {{ $ticket->category->name }}
                        </span>
                    @endif
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-2 leading-tight">{{ $ticket->subject }}
                </h1>
                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $ticket->customer->razon_social }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Creado {{ $ticket->created_at->diffForHumans() }}
                    </span>
                    @if ($ticket->assignedTo)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            Asignado a <strong
                                class="text-gray-700 dark:text-gray-300">{{ $ticket->assignedTo->name }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <a href="{{ route('admin.tickets.index') }}"
                class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Volver
            </a>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════ -->
    <!-- CUERPO: TIMELINE + SIDEBAR -->
    <!-- ══════════════════════════════════════════════════════ -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ─── COLUMNA PRINCIPAL ─── -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Descripción -->
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                        Descripción</h3>
                </div>
                <div class="px-6 py-5">
                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed whitespace-pre-wrap">
                        {{ $ticket->description }}</p>
                </div>
            </div>

            <!-- Timeline -->
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Timeline
                    </h3>
                    <span class="ml-auto text-xs text-gray-400">{{ count($timelineItems) }} actividades</span>
                </div>

                <div class="px-6 py-5">
                    @if (count($timelineItems) === 0)
                        <p class="text-center text-sm text-gray-400 py-6">Sin actividad registrada.</p>
                    @else
                        <ol class="relative">
                            @foreach ($timelineItems as $i => $item)
                                @php
                                    $isLast = $loop->last;
                                @endphp

                                @if ($item['type'] === 'event')
                                    @php
                                        $event = $item['data'];
                                        $evType = $event->type->value;
                                    @endphp

                                    @php
                                        $iconBg = match ($evType) {
                                            'created'
                                                => 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400',
                                            'status_changed'
                                                => 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400',
                                            'priority_changed'
                                                => 'bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-400',
                                            'assigned_changed'
                                                => 'bg-violet-100 dark:bg-violet-900/40 text-violet-600 dark:text-violet-400',
                                            'closed' => 'bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400',
                                            'resolved'
                                                => 'bg-teal-100 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400',
                                            'reopened'
                                                => 'bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400',
                                            'attachment_added'
                                                => 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400',
                                            default => 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400',
                                        };
                                    @endphp

                                    <li class="flex gap-4 {{ $isLast ? '' : 'pb-6' }} relative">
                                        @if (!$isLast)
                                            <span
                                                class="absolute left-5 top-10 bottom-0 w-px bg-gray-200 dark:bg-gray-700"></span>
                                        @endif
                                        <div
                                            class="shrink-0 w-10 h-10 rounded-full {{ $iconBg }} flex items-center justify-center ring-4 ring-white dark:ring-gray-800">
                                            @php $icon = $event->type->icon(); @endphp
                                            <x-form.icon :name="$icon" class="w-4 h-4" />
                                        </div>
                                        <div class="flex-1 min-w-0 pt-1.5">
                                            <p class="text-sm text-gray-800 dark:text-gray-200">
                                                <span
                                                    class="font-semibold">{{ $event->actor->name ?? 'Sistema' }}</span>
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    {{ $this->formatEventDescription($event) }}</span>
                                            </p>
                                            <time class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 block">
                                                {{ $event->created_at->format('d/m/Y H:i') }} ·
                                                {{ $event->created_at->diffForHumans() }}
                                            </time>
                                        </div>
                                    </li>
                                @else
                                    @php $message = $item['data']; @endphp
                                    <li class="flex gap-4 {{ $isLast ? '' : 'pb-6' }} relative">
                                        @if (!$isLast)
                                            <span
                                                class="absolute left-5 top-10 bottom-0 w-px bg-gray-200 dark:bg-gray-700"></span>
                                        @endif
                                        <div
                                            class="shrink-0 w-10 h-10 rounded-full
                                        {{ $message->is_internal ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400' : 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400' }}
                                        flex items-center justify-center ring-4 ring-white dark:ring-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div
                                                class="{{ $message->is_internal ? 'bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/40' : 'bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700' }} rounded-xl p-4">
                                                <div class="flex items-center justify-between mb-2 gap-2">
                                                    <span
                                                        class="font-semibold text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $message->author->name ?? 'Usuario' }}
                                                    </span>
                                                    @if ($message->is_internal)
                                                        <span
                                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                            </svg>
                                                            Nota interna
                                                        </span>
                                                    @endif
                                                </div>
                                                <p
                                                    class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
                                                    {{ $message->body }}</p>
                                                <time
                                                    class="text-xs text-gray-400 dark:text-gray-500 mt-2 block">{{ $message->created_at->format('d/m/Y H:i') }}</time>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>

            <!-- Adjuntos -->
            @if ($ticket->attachments->isNotEmpty())
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                            Archivos adjuntos</h3>
                        <span class="ml-auto text-xs text-gray-400">{{ $ticket->attachments->count() }}</span>
                    </div>
                    <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($ticket->attachments as $attachment)
                            <div
                                class="flex items-center gap-3 p-3 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                                <div
                                    class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                        {{ $attachment->file_name }}</p>
                                    <p class="text-xs text-gray-400">
                                        {{ number_format($attachment->file_size / 1024, 1) }} KB</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Nuevo Comentario / Nota Interna -->

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden"
                x-data="{ tab: 'comment' }">
                <!-- Tabs -->
                <div class="flex border-b border-gray-200 dark:border-gray-700">
                    <button @click="tab = 'comment'"
                        :class="tab === 'comment' ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400' :
                            'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z" />
                        </svg>
                        Comentario
                    </button>
                    <button @click="tab = 'note'"
                        :class="tab === 'note' ? 'border-b-2 border-amber-500 text-amber-600 dark:text-amber-400' :
                            'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Nota interna
                    </button>
                </div>

                <div class="p-5">
                    <template x-if="tab === 'comment'">
                        <p class="text-xs text-gray-400 mb-3">Visible para el cliente y el equipo.</p>
                    </template>
                    <template x-if="tab === 'note'">
                        <p class="text-xs text-amber-500 mb-3 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Solo visible para el equipo interno.
                        </p>
                    </template>

                    <!-- Plantillas de respuesta -->
                    @if ($templates->isNotEmpty())
                        <div class="mb-3">
                            <select wire:model="selectedTemplate" wire:change="applyTemplate"
                                class="form-select text-xs w-full bg-gray-50 dark:bg-gray-900/50 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-lg">
                                <option value="">📄 Usar plantilla de respuesta...</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <textarea wire:model="newMessage" rows="4" placeholder="Escribe tu mensaje aquí..."
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2
                                focus:ring-indigo-400 dark:focus:ring-indigo-600 resize-none transition-colors"></textarea>

                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ Auth::user()->name }}
                        </div>
                        <button wire:click="$set('isInternal', tab === 'note')"
                            x-on:click="$wire.set('isInternal', tab === 'note'); $wire.call('addMessage')"
                            wire:loading.attr="disabled"
                            :class="tab === 'note' ?
                                'bg-amber-500 hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-500' :
                                'bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400'"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors disabled:opacity-50">
                            <svg wire:loading wire:target="addMessage" class="w-4 h-4 animate-spin" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span x-text="tab === 'note' ? 'Guardar nota' : 'Enviar comentario'"></span>
                        </button>
                    </div>
                </div>
            </div>


            <!-- Subir Archivos -->

            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Adjuntar
                        archivos</h3>
                </div>
                <div class="px-6 py-5">
                    <label
                        class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-indigo-400 dark:hover:border-indigo-600 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-colors">
                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mb-2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <span class="text-sm text-gray-400">Haz clic o arrastra archivos aquí</span>
                        <span class="text-xs text-gray-300 mt-0.5">Máx. 10 MB por archivo</span>
                        <input type="file" wire:model="attachments" multiple class="hidden">
                    </label>
                    @if (count($attachments) > 0)
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ count($attachments) }}
                                archivo(s) seleccionado(s)</span>
                            <x-form.button primary label="Subir archivos" wire:click="uploadAttachments"
                                spinner="uploadAttachments" />
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- ─── SIDEBAR ─── -->
        <div class="space-y-4">

            <!-- SLA & Métricas -->
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">SLA &
                        Tiempos</h3>
                </div>
                <dl class="divide-y divide-gray-100 dark:divide-gray-700 text-xs">
                    @if ($ticket->due_at)
                        <div class="px-5 py-3 flex items-start justify-between gap-2">
                            <dt class="text-gray-400 dark:text-gray-500 pt-0.5 whitespace-nowrap">Vence SLA</dt>
                            <dd
                                class="font-medium text-right {{ $ticket->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-gray-800 dark:text-gray-200' }}">
                                @if ($ticket->isOverdue())
                                    ⚠ Vencido {{ $ticket->due_at->diffForHumans() }}
                                @else
                                    {{ $ticket->due_at->format('d/m/Y H:i') }}
                                    <span class="block text-gray-400">{{ $ticket->due_at->diffForHumans() }}</span>
                                @endif
                            </dd>
                        </div>
                    @endif
                    @if ($ticket->escalation_level > 0)
                        <div class="px-5 py-3 flex items-start justify-between gap-2">
                            <dt class="text-gray-400 dark:text-gray-500 pt-0.5">Escalamiento</dt>
                            <dd class="font-semibold text-red-600 dark:text-red-400">Nivel
                                {{ $ticket->escalation_level }}</dd>
                        </div>
                    @endif
                    @if ($ticket->first_response_at)
                        <div class="px-5 py-3 flex items-start justify-between gap-2">
                            <dt class="text-gray-400 dark:text-gray-500 pt-0.5 whitespace-nowrap">1ª respuesta</dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200 text-right">
                                {{ $ticket->first_response_at->format('d/m/Y H:i') }}
                                @php
                                    $responseMinutes = $ticket->created_at->diffInMinutes($ticket->first_response_at);
                                @endphp
                                <span class="block text-gray-400">
                                    {{ $responseMinutes < 60 ? "{$responseMinutes} min" : round($responseMinutes / 60, 1) . ' h' }}
                                </span>
                            </dd>
                        </div>
                    @endif
                    @if ($ticket->resolved_at)
                        <div class="px-5 py-3 flex items-start justify-between gap-2">
                            <dt class="text-gray-400 dark:text-gray-500 pt-0.5 whitespace-nowrap">Resolución</dt>
                            <dd class="font-medium text-teal-600 dark:text-teal-400 text-right">
                                {{ $ticket->resolved_at->format('d/m/Y H:i') }}
                                @php
                                    $resolutionHours = round($ticket->created_at->diffInHours($ticket->resolved_at), 1);
                                @endphp
                                <span class="block text-gray-400">{{ $resolutionHours }} h totales</span>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Reabrir (solo si está cerrado/resuelto) -->
            @if ($ticket->canBeReopened())
                <div class="bg-white dark:bg-gray-800 border border-sky-200 dark:border-sky-700 rounded-2xl shadow-sm">
                    <div class="px-5 py-4">
                        <p class="text-xs text-sky-600 dark:text-sky-400 mb-3">
                            Este ticket está {{ $ticket->status->label() }}. ¿Necesitas reabrirlo?
                        </p>
                        <x-form.button flat label="↺ Reabrir ticket" wire:click="reopen" spinner="reopen"
                            class="w-full border border-sky-300 dark:border-sky-600 text-sky-600 dark:text-sky-400 hover:bg-sky-50 dark:hover:bg-sky-900/20" />
                    </div>
                </div>
            @endif

            <!-- Detalles del ticket -->
            <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                        Detalles</h3>
                </div>
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="px-5 py-3 flex items-start justify-between gap-2">
                        <dt class="text-xs text-gray-400 dark:text-gray-500 pt-0.5 whitespace-nowrap">Asignado a</dt>
                        <dd class="text-xs font-medium text-gray-800 dark:text-gray-200 text-right">
                            @if ($ticket->assignedTo)
                                <span class="inline-flex items-center gap-1.5">
                                    <span
                                        class="w-5 h-5 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs font-bold">{{ substr($ticket->assignedTo->name, 0, 1) }}</span>
                                    {{ $ticket->assignedTo->name }}
                                </span>
                            @else
                                <span class="text-gray-400">Sin asignar</span>
                            @endif
                        </dd>
                    </div>
                    <div class="px-5 py-3 flex items-start justify-between gap-2">
                        <dt class="text-xs text-gray-400 dark:text-gray-500 pt-0.5 whitespace-nowrap">Creado por</dt>
                        <dd class="text-xs font-medium text-gray-800 dark:text-gray-200 text-right">
                            <span class="inline-flex items-center gap-1.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 flex items-center justify-center text-xs font-bold">{{ substr($ticket->createdBy->name ?? '?', 0, 1) }}</span>
                                {{ $ticket->createdBy->name ?? 'N/A' }}
                            </span>
                        </dd>
                    </div>
                    <div class="px-5 py-3 flex items-start justify-between gap-2">
                        <dt class="text-xs text-gray-400 dark:text-gray-500 pt-0.5 whitespace-nowrap">Creado</dt>
                        <dd class="text-xs font-medium text-gray-800 dark:text-gray-200 text-right">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div class="px-5 py-3 flex items-start justify-between gap-2">
                        <dt class="text-xs text-gray-400 dark:text-gray-500 pt-0.5 whitespace-nowrap">Última actividad
                        </dt>
                        <dd class="text-xs font-medium text-gray-800 dark:text-gray-200 text-right">
                            {{ $ticket->last_activity_at?->diffForHumans() ?? 'N/A' }}</dd>
                    </div>
                    @if ($ticket->vehiculo)
                        <div class="px-5 py-3 flex items-start justify-between gap-2">
                            <dt class="text-xs text-gray-400 dark:text-gray-500 pt-0.5 whitespace-nowrap">Vehículo</dt>
                            <dd class="text-xs font-medium text-gray-800 dark:text-gray-200 text-right">
                                <span class="font-mono font-bold">{{ $ticket->vehiculo->placa }}</span>
                                @if ($ticket->vehiculo->marca)
                                    <span class="text-gray-400 block">{{ $ticket->vehiculo->marca }}
                                        {{ $ticket->vehiculo->modelo }}</span>
                                @endif
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Cambiar Estado -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Estado
                    </h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <x-form.select wire:model="newStatus" placeholder="Seleccionar estado">
                        @foreach (App\Enums\TicketStatus::cases() as $status)
                            <x-select.option :label="$status->label()" :value="$status->value" />
                        @endforeach
                    </x-form.select>
                    <x-form.button primary label="Actualizar estado" wire:click="changeStatus" spinner="changeStatus"
                        class="w-full" />
                </div>
            </div>

            <!-- Cambiar Prioridad -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                        Prioridad</h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <x-form.select wire:model="newPriority" placeholder="Seleccionar prioridad">
                        @foreach (App\Enums\TicketPriority::cases() as $priority)
                            <x-select.option :label="$priority->label()" :value="$priority->value" />
                        @endforeach
                    </x-form.select>
                    <x-form.button primary label="Actualizar prioridad" wire:click="changePriority"
                        spinner="changePriority" class="w-full" />
                </div>
            </div>

            <!-- Cambiar Categoría -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                        Categoría</h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <x-form.select wire:model="newCategoryId" placeholder="Sin categoría">
                        <x-select.option label="Sin categoría" value="" />
                        @foreach ($categories as $cat)
                            <x-select.option :label="$cat->name" :value="$cat->id" />
                        @endforeach
                    </x-form.select>
                    <x-form.button primary label="Actualizar categoría" wire:click="changeCategory"
                        spinner="changeCategory" class="w-full" />
                </div>
            </div>

            <!-- Asignar Usuario -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                        Asignar a</h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <x-form.select wire:model="newAssignedTo" placeholder="Seleccionar agente">
                        <x-select.option label="Sin asignar" value="" />
                        @foreach ($users as $user)
                            <x-select.option :label="$user->name" :value="$user->id" />
                        @endforeach
                    </x-form.select>
                    <x-form.button primary label="Asignar" wire:click="assignTicket" spinner="assignTicket"
                        class="w-full" />
                </div>
            </div>

        </div>
    </div>

    <!-- ── TICKETS RELACIONADOS ── -->
    <div
        class="mt-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
            </svg>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Tickets
                relacionados</h3>
            <span class="ml-auto text-xs text-gray-400">{{ $ticket->relatedTickets->count() }}</span>
        </div>
        <div class="px-6 py-4">
            <!-- Link new -->
            <div class="flex gap-2 mb-4">
                <input wire:model="relatedTicketCode" type="text"
                    placeholder="Código del ticket (ej: TK-2026-000012)"
                    class="form-input flex-1 text-sm bg-gray-50 dark:bg-gray-900/50 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300" />
                <x-form.button primary label="Vincular" wire:click="linkRelatedTicket" spinner="linkRelatedTicket" />
            </div>
            @if ($ticket->relatedTickets->isEmpty())
                <p class="text-sm text-gray-400 text-center py-2">Sin tickets vinculados.</p>
            @else
                <div class="space-y-2">
                    @foreach ($ticket->relatedTickets as $relation)
                        <div
                            class="flex items-center justify-between gap-2 p-3 bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 rounded-xl">
                            <div class="min-w-0">
                                <a href="{{ route('admin.tickets.show', $relation->relatedTicket) }}"
                                    class="text-sm font-medium text-violet-500 hover:text-violet-600 font-mono">
                                    {{ $relation->relatedTicket->code }}
                                </a>
                                <p class="text-xs text-gray-500 truncate">{{ $relation->relatedTicket->subject }}</p>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $relation->relatedTicket->status->statusColor() }}">
                                    {{ $relation->relatedTicket->status->label() }}
                                </span>
                            </div>
                            <button wire:click="unlinkRelatedTicket({{ $relation->id }})"
                                class="shrink-0 text-red-400 hover:text-red-600 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('update-table', () => {
            $wire.$refresh();
        });
    </script>
@endscript
