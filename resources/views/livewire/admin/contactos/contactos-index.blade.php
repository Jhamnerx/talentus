<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Mensajes de Contacto 📧</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live="search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-slate-800 dark:border-slate-700" type="search"
                    placeholder="Buscar mensajes" />
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
        </div>
    </div>

    <!-- Filters -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Filtro Estado -->
            <div class="min-w-50">
                <x-form.select wire:model.live="filtro_leido">
                    <x-select.option label="Todos" value="todos" />
                    <x-select.option label="No leídos" value="0" />
                    <x-select.option label="Leídos" value="1" />
                </x-form.select>
            </div>

            <!-- Filtro Fechas -->
            <div class="min-w-55">
                <x-form.select wire:model.live="filtro_fecha" placeholder="Filtrar por fecha">
                    <x-select.option label="Todos" value="0" />
                    <x-select.option label="Hoy" value="1" />
                    <x-select.option label="Últimos 7 días" value="7" />
                    <x-select.option label="Último Mes" value="30" />
                </x-form.select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 relative">
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/20 border-t border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Estado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Nombre</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Email</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Teléfono</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Empresa</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Mensaje</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Acciones</div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($contactos as $contacto)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                @if ($contacto->leido)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">
                                        Leído
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">
                                        No leído
                                    </span>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-slate-800 dark:text-slate-100">{{ $contacto->name }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-slate-600 dark:text-slate-400">{{ $contacto->email }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-slate-600 dark:text-slate-400">{{ $contacto->phone ?? '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-slate-600 dark:text-slate-400">{{ $contacto->company ?? '-' }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="text-slate-600 dark:text-slate-400 line-clamp-2">
                                    {{ Str::limit($contacto->message, 50) }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-slate-600 dark:text-slate-400">
                                    {{ $contacto->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                <div class="space-x-1">
                                    <button wire:click="openModalVer({{ $contacto->id }})"
                                        class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">
                                        Ver
                                    </button>
                                    <button wire:click="toggleLeido({{ $contacto->id }})"
                                        class="btn btn-sm bg-slate-500 hover:bg-slate-600 text-white">
                                        {{ $contacto->leido ? 'Marcar no leído' : 'Marcar leído' }}
                                    </button>
                                    <button wire:click="openModalDelete({{ $contacto->id }})"
                                        class="btn btn-sm bg-rose-500 hover:bg-rose-600 text-white">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
                                <div class="text-slate-500 dark:text-slate-400">No hay mensajes de contacto</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $contactos->links() }}
    </div>
</div>
