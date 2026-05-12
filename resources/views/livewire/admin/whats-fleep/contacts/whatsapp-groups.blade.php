<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Grupos de WhatsApp</h1>
        </div>
        <div class="flex flex-wrap justify-start sm:justify-end gap-2">
            <x-form.button wire:click="syncGroups" spinner="syncGroups" icon="arrow-path" primary :disabled="!$deviceConnected"
                label="Sincronizar grupos" />
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-5">
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
            <div class="flex flex-wrap gap-3">

                <!-- Selector de dispositivo -->
                <div class="w-full sm:w-72">
                    <x-form.select wire:model.live="selectedDevice" placeholder="Seleccionar dispositivo...">
                        @foreach ($devices as $device)
                            <x-select.option value="{{ $device->body }}"
                                label="{{ $device->body }} — {{ $device->status === 'Connected' ? '✓ Conectado' : '✗ Desconectado' }}" />
                        @endforeach
                    </x-form.select>
                </div>

                <!-- Estado del dispositivo -->
                @if ($selectedDevice)
                    <div class="flex items-center">
                        @if ($deviceConnected)
                            <span
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                Conectado
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-900/30 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                                Desconectado
                            </span>
                        @endif
                    </div>
                @endif

                <!-- Búsqueda -->
                <div class="w-full sm:flex-1 sm:min-w-48">
                    <x-form.input wire:model.live.debounce="groupSearch" placeholder="Buscar grupo..."
                        icon="magnifying-glass" class="w-full" />
                </div>

            </div>
        </div>
    </div>

    @if ($syncing)
        <div
            class="flex items-center gap-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-4 text-blue-700 dark:text-blue-300">
            <x-form.icon name="arrow-path" class="w-5 h-5 animate-spin" />
            <span>Sincronizando grupos desde WhatsApp...</span>
        </div>
    @endif

    @if ($error)
        <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 mb-4 text-red-700 dark:text-red-300 text-sm">
            {{ $error }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($groups as $group)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="font-medium text-gray-800 dark:text-gray-100 text-sm">{{ $group->name }}</h3>
                        <p class="text-xs text-gray-400 font-mono mt-0.5">{{ $group->group_id }}</p>
                    </div>
                    <span
                        class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-0.5 rounded-full">
                        {{ $group->participant_count }} miembros
                    </span>
                </div>
                <div class="flex gap-2">
                    @if ($importingGroupId === $group->id)
                        <div
                            class="flex-1 flex items-center justify-center gap-1.5 text-xs text-teal-600 dark:text-teal-400 py-1.5">
                            <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            <span>Importando...</span>
                        </div>
                    @else
                        <x-form.button wire:click="importAsContacts({{ $group->id }})" size="xs" flat teal
                            icon="arrow-down-tray" label="Importar" class="flex-1" :disabled="$importingGroupId !== null" />
                    @endif
                    <x-form.button
                        wire:click="openSendMessage('{{ $group->group_id }}', '{{ addslashes($group->name) }}')"
                        size="xs" flat primary icon="paper-airplane" label="Enviar" class="flex-1"
                        :disabled="$importingGroupId !== null" />
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-400">
                <x-form.icon name="users" class="w-12 h-12 mx-auto mb-3 opacity-30" />
                <p>No hay grupos sincronizados. Haz clic en "Sincronizar grupos" para cargarlos.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $groups->links() }}
    </div>

    @livewire('admin.whats-fleep.contacts.send-group-message')
</div>
