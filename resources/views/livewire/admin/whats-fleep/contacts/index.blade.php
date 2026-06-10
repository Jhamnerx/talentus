<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Contactos</h1>
        </div>
        <div class="flex flex-wrap justify-start sm:justify-end gap-2 mt-3 sm:mt-0">
            <div class="w-full sm:w-52 relative">
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="form-input w-full pl-9 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 focus:border-violet-300 dark:focus:border-violet-500 rounded-lg text-sm"
                    placeholder="Buscar contacto..." />
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="w-4 h-4 fill-current text-gray-400 dark:text-gray-500 ml-3" viewBox="0 0 16 16">
                        <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </div>
            </div>
            <x-form.button wire:click="openImportModal" purple icon="arrow-up-tray" label="Importar CSV" />
            <x-form.button wire:click="openSyncContactsModal" sky icon="arrow-path" label="Sincronizar" />
            <x-form.button wire:click="openCreateModal" primary icon="plus" label="Agregar Contacto" />
        </div>
    </div>

    <!-- Stats cards -->
    <div class="grid grid-cols-12 gap-6 mb-5">
        <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <div class="px-5 py-5">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400">Total Contactos</h2>
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalContacts }}</div>
            </div>
        </div>

        <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <div class="px-5 py-5">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-400">Grupos/Etiquetas</h2>
                    <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $tags->count() }}</div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <button wire:click="openCreateTagModal" class="text-violet-500 hover:text-violet-600">+ Crear grupo</button>
                </p>
            </div>
        </div>

        <div class="flex flex-col col-span-full xl:col-span-4 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <div class="px-5 py-5">
                <x-form.select wire:model.live="selectedTag" label="Filtrar por Grupo" placeholder="Todos los grupos">
                    @foreach ($tags as $tag)
                        <x-select.option value="{{ $tag->id }}" label="{{ $tag->name }} ({{ $tag->contacts_count }})" />
                    @endforeach
                </x-form.select>
            </div>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl relative">
        <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                Todos los Contactos
                <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $contacts->total() }}</span>
            </h2>

            {{-- Barra de acciones masivas --}}
            @if (count($selected) > 0)
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ count($selected) }} {{ count($selected) === 1 ? 'seleccionado' : 'seleccionados' }}
                    </span>
                    <button wire:click="eliminarSeleccionados"
                        wire:confirm="¿Eliminar {{ count($selected) }} {{ count($selected) === 1 ? 'contacto' : 'contactos' }} seleccionados? Esta acción no se puede deshacer."
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Eliminar seleccionados
                    </button>
                    <button wire:click="$set('selected', []); $set('selectAll', false)"
                        class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        Cancelar
                    </button>
                </div>
            @endif
        </header>

        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-100 dark:border-gray-700/60">
                    <tr>
                        <th class="px-2 pl-5 py-3 w-10">
                            <input type="checkbox" wire:model.live="selectAll"
                                class="rounded border-gray-300 text-violet-500 focus:ring-violet-400 dark:border-gray-600 dark:bg-gray-700" />
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Nombre</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Número</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Grupo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Acciones</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse ($contacts as $contact)
                        <tr wire:key="contact-{{ $contact->id }}"
                            class="hover:bg-gray-50 dark:hover:bg-gray-900/20 {{ in_array((string) $contact->id, array_map('strval', $selected)) ? 'bg-violet-50 dark:bg-violet-900/10' : '' }}">
                            <td class="px-2 pl-5 py-3 w-10">
                                <input type="checkbox" wire:model.live="selected" value="{{ $contact->id }}"
                                    class="rounded border-gray-300 text-violet-500 focus:ring-violet-400 dark:border-gray-600 dark:bg-gray-700" />
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">{{ $contact->name ?: '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-mono text-gray-600 dark:text-gray-300">{{ $contact->number }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                @if ($contact->tag)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800 dark:bg-violet-500/20 dark:text-violet-400">
                                        {{ $contact->tag->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Sin grupo</span>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-gray-500 text-xs">{{ $contact->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $contact->id }})"
                                        class="text-gray-400 hover:text-violet-500 dark:hover:text-violet-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $contact->id }})"
                                        class="text-gray-400 hover:text-red-500 dark:hover:text-red-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-2">No hay contactos</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mb-4">Comienza agregando contactos o importándolos</p>
                                    <div class="flex gap-2">
                                        <x-form.button wire:click="openCreateModal" sm primary icon="plus" label="Agregar Contacto" />
                                        <x-form.button wire:click="openImportModal" sm purple icon="arrow-up-tray" label="Importar CSV" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($contacts->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/60">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>

    @livewire('admin.whats-fleep.contacts.create')
    @livewire('admin.whats-fleep.contacts.edit')
    @livewire('admin.whats-fleep.contacts.delete')
    @livewire('admin.whats-fleep.contacts.import-csv')
    @livewire('admin.whats-fleep.contacts.create-tag')
    @livewire('admin.whats-fleep.contacts.sync-contacts')
</div>
