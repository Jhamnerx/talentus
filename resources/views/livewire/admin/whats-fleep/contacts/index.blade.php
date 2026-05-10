<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Contactos WhatsApp</h1>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <button wire:click="openCreateTagModal"
                class="btn cursor-pointer bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 hover:border-slate-300 dark:hover:border-gray-600 text-slate-600 dark:text-gray-300">
                <svg class="w-4 h-4 shrink-0 fill-current opacity-50" viewBox="0 0 16 16">
                    <path d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM9 10H7V8H5V6h2V4h2v2h2v2H9v2z"/>
                </svg>
                <span class="hidden xs:block ml-2">Nueva lista</span>
            </button>
            <button wire:click="openImportModal"
                class="btn cursor-pointer bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 hover:border-slate-300 dark:hover:border-gray-600 text-slate-600 dark:text-gray-300">
                <svg class="w-4 h-4 shrink-0 fill-current opacity-50" viewBox="0 0 16 16">
                    <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12l-4-4h3V4h2v4h3l-4 4z"/>
                </svg>
                <span class="hidden xs:block ml-2">Importar</span>
            </button>
            <button wire:click="openCreateModal"
                class="btn cursor-pointer bg-emerald-500 hover:bg-emerald-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="hidden xs:block ml-2">Nuevo contacto</span>
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <x-form.input wire:model.live.debounce="search" placeholder="Buscar nombre o nÃºmero..." icon="magnifying-glass" class="w-64" />
            <x-native-select wire:model.live="selectedTag" class="btn">
                <option value="">Todas las listas</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }} ({{ $tag->contacts_count }})</option>
                @endforeach
            </x-native-select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-slate-200 dark:border-gray-700">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800 dark:text-gray-100">Total Contactos
                <span class="text-slate-400 dark:text-gray-400 font-medium">{{ $totalContacts }}</span>
            </h2>
        </header>
        <div>
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-900/20 border-t border-b border-slate-200 dark:border-gray-700">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">NOMBRE</div></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">NÃšMERO</div></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">LISTA</div></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-left">CREADO</div></th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap"><div class="font-semibold text-right">ACCIONES</div></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-700">
                        @forelse($contacts as $contact)
                            <tr wire:key="contact-{{ $contact->id }}">
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800 dark:text-gray-100">{{ $contact->name }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-mono text-slate-600 dark:text-gray-300">{{ $contact->number }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if ($contact->tag)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ $contact->tag->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 dark:text-gray-500 text-xs">&mdash;</span>
                                    @endif
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-slate-500 dark:text-gray-400 text-xs">{{ $contact->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button wire:click="openEditModal({{ $contact->id }})"
                                            class="text-slate-400 hover:text-slate-500 dark:text-gray-400 dark:hover:text-gray-300 cursor-pointer">
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                <path d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                            </svg>
                                        </button>
                                        <button wire:click="openDeleteModal({{ $contact->id }})"
                                            class="text-rose-500 hover:text-rose-600 cursor-pointer">
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                <path d="M13 15h2v6h-2zM17 15h2v6h-2zM20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-2 first:pl-5 last:pr-5 py-10 text-center">
                                    <div class="text-slate-500 dark:text-gray-400">No hay contactos registrados</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $contacts->links() }}
    </div>

    @livewire('admin.whats-fleep.contacts.create')
    @livewire('admin.whats-fleep.contacts.edit')
    @livewire('admin.whats-fleep.contacts.delete')
    @livewire('admin.whats-fleep.contacts.import-csv')
    @livewire('admin.whats-fleep.contacts.create-tag')
</div>