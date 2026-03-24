<div>
    <x-form.modal.card wire:model="showModal" blur max-width="4xl">
        <x-slot name="title">
            @if ($ticket)
                <div class="flex items-center gap-3 flex-wrap">
                    <span
                        class="font-mono text-sm font-bold text-violet-600 dark:text-violet-400">{{ $ticket->code }}</span>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->status->statusColor() }}">
                        {{ $ticket->status->label() }}
                    </span>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->priority->statusColor() }}">
                        {{ $ticket->priority->label() }}
                    </span>
                </div>
            @else
                Ticket
            @endif
        </x-slot>

        @if ($ticket)
            {{-- Cabecera resumen --}}
            <div class="mb-4">
                <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100 leading-snug">{{ $ticket->subject }}
                </h2>
                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <span>Cliente: <span
                            class="font-medium text-gray-700 dark:text-gray-300">{{ $ticket->customer->razon_social ?? '—' }}</span></span>
                    <span>Asignado: <span
                            class="font-medium text-gray-700 dark:text-gray-300">{{ $ticket->assignedTo->name ?? 'Sin asignar' }}</span></span>
                    @if ($ticket->vehiculo)
                        <span>Vehículo:
                            <span class="font-medium text-gray-700 dark:text-gray-300 font-mono">
                                {{ $ticket->vehiculo->placa }}
                                @if ($ticket->vehiculo->marca)
                                    · {{ $ticket->vehiculo->marca }} {{ $ticket->vehiculo->modelo }}
                                @endif
                            </span>
                        </span>
                    @endif
                    <span>Creado: <span
                            class="font-medium text-gray-700 dark:text-gray-300">{{ $ticket->created_at->format('d/m/Y H:i') }}</span></span>
                </div>
            </div>

            {{-- Descripción --}}
            <div class="bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 rounded-xl p-4 mb-5">
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-widest mb-2">
                    Descripción</p>
                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
                    {{ $ticket->description }}</p>
            </div>

            {{-- Timeline --}}
            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                <div
                    class="px-5 py-3 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2 bg-gray-50 dark:bg-gray-900/30">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                        Timeline</h3>
                    <span class="ml-auto text-xs text-gray-400">{{ count($timelineItems) }} actividades</span>
                </div>

                <div class="px-5 py-5 max-h-96 overflow-y-auto">
                    @if (count($timelineItems) === 0)
                        <p class="text-center text-sm text-gray-400 py-6">Sin actividad registrada.</p>
                    @else
                        <ol class="relative">
                            @foreach ($timelineItems as $item)
                                @php $isLast = $loop->last; @endphp

                                @if ($item['type'] === 'event')
                                    @php
                                        $event = $item['data'];
                                        $evType = $event->type->value;
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
                                            default => 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400',
                                        };
                                    @endphp
                                    <li class="flex gap-4 {{ $isLast ? '' : 'pb-5' }} relative">
                                        @if (!$isLast)
                                            <span
                                                class="absolute left-5 top-10 bottom-0 w-px bg-gray-200 dark:bg-gray-700"></span>
                                        @endif
                                        <div
                                            class="shrink-0 w-10 h-10 rounded-full {{ $iconBg }} flex items-center justify-center ring-4 ring-white dark:ring-gray-800">
                                            <x-form.icon :name="$event->type->icon()" class="w-4 h-4" />
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
                                    <li class="flex gap-4 {{ $isLast ? '' : 'pb-5' }} relative">
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
                                                class="{{ $message->is_internal ? 'bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/40' : 'bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700' }} rounded-xl p-3">
                                                <div class="flex items-center justify-between mb-1 gap-2">
                                                    <span
                                                        class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $message->author->name ?? 'Usuario' }}</span>
                                                    @if ($message->is_internal)
                                                        <span
                                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">
                                                            Nota interna
                                                        </span>
                                                    @endif
                                                </div>
                                                <p
                                                    class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
                                                    {{ $message->body }}</p>
                                                <time
                                                    class="text-xs text-gray-400 dark:text-gray-500 mt-1 block">{{ $message->created_at->format('d/m/Y H:i') }}</time>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>

        @endif

        <x-slot name="footer">
            <div class="flex justify-between items-center">
                @if ($ticket)
                    <a href="{{ route('admin.tickets.show', $ticket) }}"
                        class="inline-flex items-center gap-1.5 text-sm font-medium text-violet-600 dark:text-violet-400 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Ver detalle completo
                    </a>
                @else
                    <span></span>
                @endif
                <x-form.button flat label="Cerrar" wire:click="$set('showModal', false)" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
