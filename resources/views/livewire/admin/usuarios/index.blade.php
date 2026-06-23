<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">USUARIOS ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative" @submit.prevent>
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live.debounce.300ms='search' id="action-search"
                    class="form-input pl-9 bg-white dark:bg-gray-800 border-slate-200 dark:border-gray-700 text-slate-700 dark:text-slate-200 focus:border-slate-300"
                    type="search" placeholder="Buscar Usuario" />
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>

            {{-- BOTON Y MODAL PARA CREAR --}}
            @can('admin.usuarios.create')
                <button wire:click.prevent="openModalCreate" class="btn bg-teal-500 hover:bg-teal-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Añadir Usuario</span>
                </button>
            @endcan

        </div>

    </div>

    <!-- Filtro por Rol -->
    <div class="mb-4">
        <select wire:model.live="roleFilter"
            class="form-select bg-white dark:bg-gray-800 border-slate-300 dark:border-gray-700 text-slate-700 dark:text-slate-200 rounded shadow-sm">
            <option value="">Todos los roles</option>
            @foreach ($roles as $rol)
                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Table -->
    <div
        class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-slate-200 dark:border-gray-700 mb-8 overflow-x-auto">
        <header class="px-5 py-4 border-b border-slate-200 dark:border-gray-700 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Usuarios <span class="text-slate-400 dark:text-slate-500 font-medium">{{ $usuarios->total() }}</span>
            </h2>
        </header>
        <div>
            <table class="table-auto w-full text-sm">
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-gray-700/40 border-t border-b border-slate-200 dark:border-gray-700">
                    <tr>
                        <th class="px-2 py-3 whitespace-nowrap text-left">ID</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Nombre</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Email</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Teléfonos</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Rol</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Serie</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Activo</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-gray-700">
                    @forelse ($usuarios as $usuario)
                        <tr wire:key='u-{{ $usuario->id }}'
                            class="hover:bg-slate-50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-2 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300">
                                {{ $usuario->id }}</td>
                            <td class="px-2 py-3 whitespace-nowrap text-blue-500 dark:text-blue-400 font-semibold">
                                {{ $usuario->name }}</td>
                            <td class="px-2 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300">
                                {{ $usuario->email }}</td>
                            <td class="px-2 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300">
                                {{ $usuario->telefonos }}</td>
                            <td class="px-2 py-3 whitespace-nowrap">
                                @forelse ($usuario->roles as $rol)
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300 mr-1 mb-1">{{ $rol->name }}</span>
                                @empty
                                    <span class="text-slate-400 dark:text-slate-500">—</span>
                                @endforelse
                            </td>
                            <td class="px-2 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300">
                                {{ optional($usuario->series)->serie }}</td>
                            <td class="px-2 py-3 whitespace-nowrap">
                                <div class="flex items-center" x-data="{ checked: {{ $usuario->is_active ? 'true' : 'false' }} }">
                                    <div class="form-switch">
                                        <input wire:click="toggleStatus({{ $usuario->id }})" type="checkbox"
                                            id="switch-e{{ $usuario->id }}" class="sr-only" x-model="checked"
                                            {{ $usuario->is_active ? 'checked' : '' }} />
                                        <label class="bg-slate-400 dark:bg-gray-600" for="switch-e{{ $usuario->id }}">
                                            <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                            <span class="sr-only">Estado</span>
                                        </label>
                                    </div>
                                    <div class="text-sm text-slate-400 dark:text-slate-500 italic ml-2"
                                        x-text="checked ? 'Activo' : 'Inactivo'"></div>
                                </div>
                            </td>
                            <td class="px-2 py-3 whitespace-nowrap w-px">
                                <div class="flex gap-1">
                                    @if (auth()->user()?->canImpersonate($usuario))
                                        <a href="{{ route('admin.usuarios.impersonate', $usuario) }}"
                                            class="text-amber-500 hover:text-amber-600 rounded-full p-1"
                                            title="Ingresar como este usuario">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                        </a>
                                    @endif
                                    @can('admin.usuarios.edit')
                                        <button wire:click.prevent="openModalEdit({{ $usuario->id }})"
                                            class="text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-full p-1"
                                            title="Editar">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m2-2l-6 6" />
                                            </svg>
                                        </button>
                                    @endcan
                                    @can('admin.usuarios.delete')
                                        <button wire:click.prevent="confirmDelete({{ $usuario->id }})"
                                            class="text-rose-500 hover:text-rose-600 rounded-full p-1" title="Eliminar">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-2 py-3 text-center text-slate-400 dark:text-slate-500">No hay
                                Registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $usuarios->links() }}
    </div>

</div>
