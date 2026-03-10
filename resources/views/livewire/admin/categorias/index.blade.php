<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Categorías</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <x-search-form placeholder="Buscar categoría…" />

            <!-- Create button -->
            @can('crear-categoria')
                <x-form.button dark wire:click="openModalCreate" icon="plus">
                    Crear Categoría
                </x-form.button>
            @endcan

        </div>

    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left side -->
        <div class="mb-4 sm:mb-0">
            <ul class="flex flex-wrap -m-1">
                <li class="m-1">
                    <button wire:click="$set('estadoFilter', '')"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border shadow-xs transition cursor-pointer {{ $estadoFilter === '' ? 'bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-800 border-transparent' : 'border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400' }}">
                        Todas
                        <span class="ml-1 text-gray-400 dark:text-gray-500">{{ $categorias->total() }}</span>
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="$set('estadoFilter', '1')"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border shadow-xs transition cursor-pointer {{ $estadoFilter === '1' ? 'bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-800 border-transparent' : 'border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400' }}">
                        Activas
                    </button>
                </li>
                <li class="m-1">
                    <button wire:click="$set('estadoFilter', '0')"
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border shadow-xs transition cursor-pointer {{ $estadoFilter === '0' ? 'bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-800 border-transparent' : 'border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400' }}">
                        Inactivas
                    </button>
                </li>
            </ul>
        </div>

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Per Page -->
            <select wire:model.live="perPage"
                class="form-select text-sm border-gray-200 dark:border-gray-700/60 rounded-lg focus:border-gray-300 dark:focus:border-gray-600 bg-white dark:bg-gray-800">
                <option value="5">5 por página</option>
                <option value="10">10 por página</option>
                <option value="25">25 por página</option>
                <option value="50">50 por página</option>
            </select>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700/60">
        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-gray-300 divide-y divide-gray-200 dark:divide-gray-700/60">
                <!-- Table header -->
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Nombre</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Descripción</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Facturación GPS</div>
                        </th>
                        @can('cambiar.estado-categoria')
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Estado</div>
                            </th>
                        @endcan
                        @if (auth()->user()->can('editar-categoria') || auth()->user()->can('eliminar-categoria'))
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right">Acciones</div>
                            </th>
                        @endif
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm">
                    @forelse ($categorias as $categoria)
                        <tr wire:key="categoria-{{ $categoria->id }}"
                            class="border-b border-gray-200 dark:border-gray-700/60 last:border-0">
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">{{ $categoria->nombre }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="text-gray-500 dark:text-gray-400">{{ $categoria->descripcion }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1">
                                    @if ($categoria->es_equipo_gps)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 ring-1 ring-inset ring-blue-500/30">
                                            📡 Equipo GPS
                                        </span>
                                    @endif
                                    @if ($categoria->es_servicio_monitoreo)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-violet-100 text-violet-800 dark:bg-violet-900/30 dark:text-violet-300 ring-1 ring-inset ring-violet-500/30">
                                            🛰️ Monitoreo
                                        </span>
                                    @endif
                                    @if (!$categoria->es_equipo_gps && !$categoria->es_servicio_monitoreo)
                                        <span class="text-gray-300 dark:text-gray-600 text-xs">&mdash;</span>
                                    @endif
                                </div>
                            </td>
                            @can('cambiar.estado-categoria')
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex justify-center">
                                        <x-form.toggle id="toggle-{{ $categoria->id }}" name="toggle-{{ $categoria->id }}"
                                            md :checked="(bool) $categoria->estado" x-on:change="$wire.toggleStatus({{ $categoria->id }})" />
                                    </div>
                                </td>
                            @endcan
                            @if (auth()->user()->can('editar-categoria') || auth()->user()->can('eliminar-categoria'))
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        @can('editar-categoria')
                                            <button wire:click="openModalEdit({{ $categoria->id }})"
                                                class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-indigo-500 cursor-pointer">
                                                <svg class="fill-current shrink-0" width="16" height="16"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                                                </svg>
                                            </button>
                                        @endcan
                                        @can('eliminar-categoria')
                                            <button wire:click="openModalDelete({{ $categoria->id }})"
                                                class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-red-500 hover:text-red-600 cursor-pointer">
                                                <svg class="fill-current shrink-0" width="16" height="16"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
                                <div class="text-gray-400 dark:text-gray-500">No se encontraron categorías</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $categorias->links() }}
    </div>

</div>
