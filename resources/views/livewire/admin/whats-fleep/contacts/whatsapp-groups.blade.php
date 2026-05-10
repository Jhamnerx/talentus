<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Grupos de WhatsApp</h2>
        <x-form.button wire:click="syncGroups" spinner="syncGroups" icon="arrow-path" primary label="Sincronizar grupos" />
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
                    <x-form.button wire:click="importAsContacts({{ $group->id }})" size="xs" flat teal
                        icon="arrow-down-tray" label="Importar" class="flex-1" />
                    <x-form.button
                        wire:click="openSendMessage('{{ $group->group_id }}', '{{ addslashes($group->name) }}')"
                        size="xs" flat primary icon="paper-airplane" label="Enviar" class="flex-1" />
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-400">
                <x-form.icon name="users" class="w-12 h-12 mx-auto mb-3 opacity-30" />
                <p>No hay grupos sincronizados. Haz clic en "Sincronizar grupos" para cargarlos.</p>
            </div>
        @endforelse
    </div>

    @livewire('admin.whats-fleep.contacts.send-group-message')
</div>
