<div class="space-y-6">
    <!-- Header con acciones rápidas -->
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $ticket->code }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Creado {{ $ticket->created_at->diffForHumans() }}
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-form.badge :label="$ticket->status->label()" :class="$ticket->status->statusColor()" />
                <x-form.badge :label="$ticket->priority->label()" :class="$ticket->priority->statusColor()" />
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Principal: Timeline -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información del Ticket -->
            <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $ticket->subject }}</h3>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $ticket->description }}</p>

                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Cliente:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">
                                {{ $ticket->customer->razon_social }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Categoría:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">
                                {{ $ticket->category->name ?? 'Sin categoría' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Timeline</h3>

                <div class="space-y-6">
                    @foreach ($timelineItems as $item)
                        @if ($item['type'] === 'event')
                            @php $event = $item['data']; @endphp
                            <div class="flex gap-4">
                                <div class="shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                        <x-form.icon name="information-circle"
                                            class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 dark:text-gray-100">
                                        <span class="font-medium">{{ $event->actor->name ?? 'Sistema' }}</span>
                                        {{ $this->formatEventDescription($event) }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $event->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @else
                            @php $message = $item['data']; @endphp
                            <div class="flex gap-4">
                                <div class="shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <x-form.icon name="chat" class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-medium text-sm text-gray-900 dark:text-gray-100">
                                                {{ $message->sender->name }}
                                            </span>
                                            @if ($message->is_internal)
                                                <x-form.mini.badge label="Interno" warning />
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                            {{ $message->message }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            {{ $message->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Adjuntos -->
            @if ($ticket->attachments->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Archivos Adjuntos</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($ticket->attachments as $attachment)
                            <div
                                class="flex items-center gap-3 p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <x-form.icon name="document" class="w-8 h-8 text-gray-400" />
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                        {{ $attachment->file_name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ number_format($attachment->file_size / 1024, 2) }} KB
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Formulario de nuevo mensaje -->
            @can('addMessage', $ticket)
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Agregar Comentario</h3>
                    <x-form.textarea wire:model="newMessage" placeholder="Escribe un comentario..." rows="4" />
                    <div class="flex items-center justify-between mt-4">
                        <x-form.checkbox wire:model="isInternal" label="Nota interna" />
                        <x-form.button primary label="Agregar Comentario" wire:click="addMessage" spinner="addMessage" />
                    </div>
                </div>
            @endcan

            <!-- Subir archivos -->
            @can('addAttachment', $ticket)
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Adjuntar Archivos</h3>
                    <input type="file" wire:model="attachments" multiple
                        class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-primary-50 file:text-primary-700
                        hover:file:bg-primary-100
                        dark:file:bg-primary-900 dark:file:text-primary-300">
                    @if (count($attachments) > 0)
                        <x-form.button primary label="Subir Archivos" wire:click="uploadAttachments"
                            spinner="uploadAttachments" class="mt-4" />
                    @endif
                </div>
            @endcan
        </div>

        <!-- Columna Lateral: Acciones -->
        <div class="space-y-6">
            <!-- Cambiar Estado -->
            @can('changeStatus', $ticket)
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Cambiar Estado</h3>
                    <x-form.select wire:model="newStatus" placeholder="Seleccionar estado">
                        @foreach (App\Enums\TicketStatus::cases() as $status)
                            <x-select.option :label="$status->label()" :value="$status->value" />
                        @endforeach
                    </x-form.select>
                    <x-form.button primary label="Actualizar" wire:click="changeStatus" spinner="changeStatus"
                        class="w-full mt-3" />
                </div>
            @endcan

            <!-- Cambiar Prioridad -->
            @can('update', $ticket)
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Cambiar Prioridad</h3>
                    <x-form.select wire:model="newPriority" placeholder="Seleccionar prioridad">
                        @foreach (App\Enums\TicketPriority::cases() as $priority)
                            <x-select.option :label="$priority->label()" :value="$priority->value" />
                        @endforeach
                    </x-form.select>
                    <x-form.button primary label="Actualizar" wire:click="changePriority" spinner="changePriority"
                        class="w-full mt-3" />
                </div>
            @endcan

            <!-- Asignar Usuario -->
            @can('assign', $ticket)
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Asignar a</h3>
                    <x-form.select wire:model="newAssignedTo" placeholder="Seleccionar usuario">
                        <x-select.option label="Sin asignar" value="" />
                        @foreach ($users as $user)
                            <x-select.option :label="$user->name" :value="$user->id" />
                        @endforeach
                    </x-form.select>
                    <x-form.button primary label="Asignar" wire:click="assignTicket" spinner="assignTicket"
                        class="w-full mt-3" />
                </div>
            @endcan

            <!-- Asignar Equipo -->
            @can('assign', $ticket)
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Asignar Equipo</h3>
                    <x-form.select wire:model="newTeamId" placeholder="Seleccionar equipo">
                        <x-select.option label="Sin equipo" value="" />
                        @foreach ($teams as $team)
                            <x-select.option :label="$team->name" :value="$team->id" />
                        @endforeach
                    </x-form.select>
                    <x-form.button primary label="Asignar" wire:click="assignTeam" spinner="assignTeam"
                        class="w-full mt-3" />
                </div>
            @endcan

            <!-- Información Adicional -->
            <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Información</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Asignado a:</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium mt-1">
                            {{ $ticket->assignedTo->name ?? 'No asignado' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Equipo:</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium mt-1">
                            {{ $ticket->team->name ?? 'Sin equipo' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Creado por:</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium mt-1">
                            {{ $ticket->createdBy->name }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Última actividad:</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium mt-1">
                            {{ $ticket->last_activity_at?->diffForHumans() ?? 'N/A' }}
                        </dd>
                    </div>
                </dl>
            </div>
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
