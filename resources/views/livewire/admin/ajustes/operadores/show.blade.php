<div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Operadores ✨</h1>
            <span class="text-slate-500 dark:text-slate-400">Configura los operadores de telefonía disponibles</span>
        </div>

        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <form class="relative" @submit.prevent>
                <label for="search-operadores" class="sr-only">Buscar</label>
                <input id="search-operadores" wire:model.live="search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:placeholder-gray-500"
                    type="search" placeholder="Buscar operador…" />
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 dark:text-gray-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                        viewBox="0 0 16 16">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>

            <button wire:click="openModalSave" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="hidden xs:block ml-2">Añadir Operador</span>
            </button>
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 overflow-x-auto min-h-screen">
        <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead
                class="text-xs font-semibold uppercase text-slate-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-900/20">
                <tr>
                    <th class="px-4 py-3 text-left whitespace-nowrap">
                        <div class="font-semibold">Nombre</div>
                    </th>
                    <th class="px-4 py-3 text-center whitespace-nowrap">
                        <div class="font-semibold">Tiene API</div>
                    </th>
                    <th class="px-4 py-3 text-center whitespace-nowrap">
                        <div class="font-semibold">Acciones</div>
                    </th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($operadores as $operador)
                    <tr wire:key="operador-{{ $operador->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-medium text-gray-800 dark:text-gray-100">{{ strtoupper($operador->name) }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            @if ($operador->have_api)
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Sí
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                    No
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap w-px">
                            <div class="flex items-center justify-center space-x-1">
                                <button wire:click.prevent="openModalEdit({{ $operador->id }})"
                                    class="text-slate-400 hover:text-slate-500 dark:text-gray-500 dark:hover:text-gray-300 rounded-full">
                                    <span class="sr-only">Editar</span>
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                        <path
                                            d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                    </svg>
                                </button>
                                <button wire:click.prevent="openModalDelete({{ $operador->id }})"
                                    class="text-rose-500 hover:text-rose-600 dark:text-rose-400 dark:hover:text-rose-300 rounded-full">
                                    <span class="sr-only">Eliminar</span>
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                        <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                        <path
                                            d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                            No hay operadores registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $operadores->links() }}
    </div>

    @livewire('admin.ajustes.operadores.save')
    @livewire('admin.ajustes.operadores.edit')
    @livewire('admin.ajustes.operadores.delete')
</div>
