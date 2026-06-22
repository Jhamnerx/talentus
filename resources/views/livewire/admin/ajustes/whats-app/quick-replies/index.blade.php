<div>
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Respuestas Rápidas de WhatsApp</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Atajos reutilizables para responder más rápido en el chat. Escribe el atajo (ej. <code class="text-xs bg-gray-100 dark:bg-gray-700 px-1 rounded">/saludo</code>) para insertar el mensaje.
            </p>
        </div>
        <div>
            <x-form.button x-on:click="$dispatch('open-quick-reply-modal')" primary icon="plus" label="Nueva" />
        </div>
    </div>

    <div class="mb-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
        <x-form.input wire:model.live.debounce.300ms="search" placeholder="Buscar por atajo o título..." icon="magnifying-glass" />
    </div>

    @if ($replies->isEmpty())
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl py-16 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">Aún no hay respuestas rápidas registradas.</p>
            <x-form.button x-on:click="$dispatch('open-quick-reply-modal')" primary label="Crear primera respuesta" />
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-4 py-3 text-left">Atajo</th>
                            <th class="px-4 py-3 text-left">Título</th>
                            <th class="px-4 py-3 text-left">Mensaje</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        @foreach ($replies as $r)
                            <tr wire:key="qr-{{ $r->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 font-mono">
                                        {{ $r->shortcut }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-800 dark:text-gray-100">{{ $r->title }}</span>
                                </td>
                                <td class="px-4 py-3 max-w-xs">
                                    <p class="text-gray-600 dark:text-gray-300 truncate">{{ \Illuminate\Support\Str::limit($r->body, 80) }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                        @if ($r->active) bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                        @else bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400 @endif">
                                        {{ $r->active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <button x-on:click="$dispatch('open-quick-reply-modal', { id: {{ $r->id }} })"
                                            class="p-1.5 rounded text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button x-on:click="$dispatch('confirm-delete-quick-reply', { id: {{ $r->id }} })"
                                            class="p-1.5 rounded text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($replies->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/60">
                    {{ $replies->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
