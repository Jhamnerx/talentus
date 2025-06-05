<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">USUARIOS ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search" class="form-input pl-9 focus:border-slate-300"
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

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left side -->
        <div class="mb-4 sm:mb-0">
            <ul class="flex flex-wrap -m-1">
                <li class="m-1">
                    <button
                        class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-4 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">Todas
                        <span class="ml-1 text-indigo-200">{{ $usuarios->total() }}</span></button>
                </li>
            </ul>
        </div>

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Eliminar button -->
            <div class="table-items-action hidden">
                <div class="flex items-center">
                    <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                            class="table-items-count"></span> Items Seleccionados</div>
                    <button
                        class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Eliminar</button>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="relative float-right" x-data="{ open: false, selected: 4 }">
                <button wire:ignore
                    class="btn justify-between min-w-44 bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600"
                    aria-label="Select date range" aria-haspopup="true" @click.prevent="open = !open"
                    :aria-expanded="open">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0 mr-2" viewBox="0 0 16 16">
                            <path
                                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                        </svg>
                        <span x-text="$refs.options.children[selected].children[1].innerHTML"></span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-slate-400" width="11" height="7"
                        viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="z-10 absolute top-full right-0 w-full bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <div class="font-medium text-sm text-slate-600" x-ref="options">
                        <button wire:click="filter(1)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 0 && 'text-indigo-500'" @click="selected = 0;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 0 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Hoy</span>
                        </button>
                        <button wire:click="filter(7)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 1 && 'text-indigo-500'" @click="selected = 1;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 1 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Ultimos 7 días</span>
                        </button>
                        <button wire:click="filter(30)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 2 && 'text-indigo-500'" @click="selected = 2;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 2 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Ultimo Mes</span>
                        </button>
                        <button wire:click="filter(12)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 3 && 'text-indigo-500'" @click="selected = 3;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 3 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Ultimos 12 Meses</span>
                        </button>
                        <button wire:click="filter(0)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 4 && 'text-indigo-500'" @click="selected = 4;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 4 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Todos</span>
                        </button>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Filtro por Rol -->
    <div class="mb-4 sm:mb-0">
        <select wire:model.live="roleFilter" class="form-select border-slate-300 rounded shadow-sm">
            <option value="">Todos los roles</option>
            @foreach ($roles as $rol)
                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-lg border border-slate-200 mb-8 overflow-x-auto">
        <header class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Usuarios <span class="text-slate-400 font-medium">{{ $usuarios->total() }}</span>
            </h2>
        </header>
        <div>
            <table class="table-auto w-full text-sm">
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 py-3 whitespace-nowrap text-left">ID</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Nombre</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Email</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Tipo Doc</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">N° Doc</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Dirección</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Teléfonos</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Cumpleaños</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Cliente</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Serie</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Activo</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Estado</th>
                        <th class="px-2 py-3 whitespace-nowrap text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($usuarios as $usuario)
                        @if ($usuario->email !== 'jhamnerx1x@gmail.com')
                            <tr wire:key='u-{{ $usuario->id }}' class="hover:bg-slate-50 transition">
                                <td class="px-2 py-3 whitespace-nowrap text-slate-600">{{ $usuario->id }}</td>
                                <td class="px-2 py-3 whitespace-nowrap text-blue-500 font-semibold">
                                    {{ $usuario->name }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $usuario->email }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $usuario->tipo_documento }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $usuario->numero_documento }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $usuario->direccion }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">{{ $usuario->telefonos }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    {{ $usuario->birthday ? $usuario->birthday->format('d/m/Y') : '' }}</td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs {{ $usuario->is_client === 'si' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $usuario->is_client === 'si' ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    {{ optional($usuario->series)->serie }}
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <div class="m-3">
                                        <div class="flex items-center mt-2" x-data="{ checked: {{ $usuario->is_active ? 'true' : 'false' }} }">
                                            <div class="form-switch">
                                                <input wire:click="toggleStatus({{ $usuario->id }})" type="checkbox"
                                                    id="switch-e{{ $usuario->id }}" class="sr-only"
                                                    x-model="checked" {{ $usuario->is_active ? 'checked' : '' }} />
                                                <label class="bg-slate-400" for="switch-e{{ $usuario->id }}">
                                                    <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                    <span class="sr-only">Estado</span>
                                                </label>
                                            </div>
                                            <div class="text-sm text-slate-400 italic ml-2"
                                                x-text="checked ? 'Activo' : 'Inactivo'"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs {{ $usuario->estado ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap w-px">
                                    <div class="flex gap-1">
                                        @can('admin.usuarios.edit')
                                            <button wire:click.prevent="openModalEdit({{ $usuario->id }})"
                                                class="text-slate-400 hover:text-indigo-600 rounded-full p-1"
                                                title="Editar">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m2-2l-6 6" />
                                                </svg>
                                            </button>
                                        @endcan
                                        @can('admin.usuarios.delete')
                                            <button @click.prevent="modalDelete = true"
                                                class="text-rose-500 hover:text-rose-600 rounded-full p-1"
                                                title="Eliminar">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if ($usuarios->count() < 1)
                        <tr>
                            <td colspan="13" class="px-2 py-3 text-center text-slate-400">No hay Registros</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $usuarios->links() }}
    </div>


</div>
