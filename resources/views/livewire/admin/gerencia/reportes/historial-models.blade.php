<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ page: 'almacen-categorias', sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Modificaciones</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <!-- Search form -->
                <form class="relative">
                    <label for="action-search" class="sr-only">Buscar</label>
                    <input wire:model.live="search" class="form-input pl-9 focus:border-slate-300" type="search"
                        placeholder="Buscar" />

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

        <div class="bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4">
                <h2 class="font-semibold text-slate-800">Modificaciones <span
                        class="text-slate-400 font-medium">{{ 10 }}</span>
                </h2>

            </header>
            <div>
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table header -->
                        <thead
                            class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                            <tr>

                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">#</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Acción</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Acciónes</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Modelo</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">usuario</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Fecha</div>
                                </th>

                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm divide-y divide-slate-200">
                            <!-- Row -->
                            @if ($activities->count())

                                <!-- Table -->
                                @foreach ($activities as $key => $activity)
                                    <tr>

                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="font-medium text-slate-800">
                                                    {{ $key + 1 }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            @can('admin.reportes.logs.actions')
                                                @if ($activity->description == 'deleted')
                                                    <div class="space-x-1">

                                                        <button
                                                            wire:click="restart('{{ class_basename($activity->subject_type) }}', '{{ $activity->subject_id }}')"
                                                            class="text-emerald-400 hover:text-emerald-500 rounded-full">
                                                            <span class="sr-only">Restart</span>
                                                            <svg class="w-8 h-8 fill-current"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                                                <g stroke-linecap="round" stroke-width="2" fill="none"
                                                                    stroke="currentColor" stroke-linejoin="round"
                                                                    class="nc-icon-wrapper">
                                                                    <polyline points="32 12 32 32 49 32"></polyline>
                                                                    <path data-cap="butt"
                                                                        d="M5.02,42.655A29.018,29.018,0,1,0,3,32">
                                                                    </path>
                                                                    <polyline points="6.022 59.041 5 42.649 20.689 48.103">
                                                                    </polyline>
                                                                </g>
                                                            </svg>
                                                        </button>

                                                        <button
                                                            wire:click.prevent="delete('{{ class_basename($activity->subject_type) }}', '{{ $activity->subject_id }}')"
                                                            aria-controls="danger-modal"
                                                            class="text-rose-500 hover:text-rose-600 rounded-full">
                                                            <span class="sr-only">Eliminar</span>
                                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                                <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                                                <path
                                                                    d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endcan

                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left">{{ $activity->description }}</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left">
                                                @if ($activity->description == 'updated' || $activity->description == 'deleted')
                                                    {{ $activity->changes }}
                                                @else
                                                    {{ $activity->subject }}
                                                @endif


                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left">
                                                @if ($activity->causer)
                                                    {{ $activity->causer->name }}
                                                @endif

                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left">{{ $activity->created_at }}</div>
                                        </td>


                                    </tr>
                                @endforeach
                            @else
                                <td colspan="5"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center">No hay modificaciones</div>
                                </td>
                            @endif


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="mt-8 w-full">
            {{ $activities->links() }}


        </div>
    </div>
</div>
