<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">TECNICOS ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative" autocomplete="off">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live="search" class="form-input pl-9 focus:border-slate-300" type="search"
                    placeholder="Buscar Tecnico" />

                <button class="absolute inset-0 right-auto group" type="button" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>



            <!-- Filter button -->
            <div class="relative inline-flex">
                <button
                    class="btn bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600">
                    <span class="sr-only">Filtro</span><wbr>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                        <path
                            d="M9 15H7a1 1 0 010-2h2a1 1 0 010 2zM11 11H5a1 1 0 010-2h6a1 1 0 010 2zM13 7H3a1 1 0 010-2h10a1 1 0 010 2zM15 3H1a1 1 0 010-2h14a1 1 0 010 2z" />
                    </svg>
                </button>
            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Tecnicos: <span
                    class="text-slate-400 font-medium">{{ $tecnicos->total() }}</span>
            </h2>

        </header>
        <div>
            <!-- Table -->
            <div class="overflow-x-auto">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <!-- Table header -->
                        <thead
                            class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                            <tr>

                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nombres</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Email</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Roles</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Estado</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">DISPOSTIVOS</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">SIM CARDS</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Acciones</div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody class="text-sm divide-y divide-slate-200">
                            <!-- Row -->

                            @foreach ($tecnicos as $tecnico)
                                @if ($tecnico->email !== 'jhamnerx1x@gmail.com')
                                    <tr>

                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-medium text-blue-500">{{ $tecnico->name }}
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-medium text-slate-800">
                                                {{ $tecnico->email }}</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-medium text-slate-800">
                                                @if (!empty($tecnico->getRoleNames()))
                                                    @foreach ($tecnico->getRoleNames() as $rolName)
                                                        {{ $rolName }}
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div>
                                                <div class="m-3 ">
                                                    <div class="flex items-center mt-2" x-data="{ checked: {{ $tecnico->is_active ? 'true' : 'false' }} }">
                                                        <div class="form-switch">
                                                            <input wire:click="toggleStatus({{ $tecnico->id }})"
                                                                type="checkbox" id="switch-e{{ $tecnico->id }}"
                                                                class="sr-only" x-model="checked" />
                                                            <label class="bg-slate-400"
                                                                for="switch-e{{ $tecnico->id }}">
                                                                <span class="bg-white shadow-sm"
                                                                    aria-hidden="true"></span>
                                                                <span class="sr-only">Estado</span>
                                                            </label>
                                                        </div>
                                                        <div class="text-sm text-slate-400 italic ml-2"
                                                            x-text="checked ? 'Activo' : 'Inactivo'">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3">

                                            <div x-data="{ isOpen: false }">
                                                <button @mouseover="isOpen = true" @mouseleave="isOpen = false"
                                                    wire:click.prevent='openModalDevices({{ $tecnico->id }})'
                                                    class="text-gray-800 hover:bg-gray-200 font-bold p-2 rounded transition-colors duration-300">

                                                    <svg width="1.5em" height="1.5em"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <g fill="none" class="nc-icon-wrapper">
                                                            <path
                                                                d="M13 7h-2v2h2V7zm0 4h-2v6h2v-6zm4-9.99L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"
                                                                fill="currentColor"></path>
                                                        </g>
                                                    </svg>
                                                </button>

                                                <div x-show="isOpen"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 transform scale-95"
                                                    x-transition:enter-end="opacity-100 transform scale-100"
                                                    x-transition:leave="transition ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 transform scale-100"
                                                    x-transition:leave-end="opacity-0 transform scale-95"
                                                    class="popover absolute bg-gray-700 border shadow-md mt-2 px-4 py-2 rounded-lg">

                                                    <p class="text-white">Ver dispositivos</p>
                                                </div>
                                            </div>

                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                                            <div x-data="{ isOpen: false }">
                                                <button @mouseover="isOpen = true" @mouseleave="isOpen = false"
                                                    wire:click.prevent='openModalSim({{ $tecnico->id }})'
                                                    class="text-gray-800 hover:bg-gray-200 font-bold p-2 rounded transition-colors duration-300">

                                                    <svg width="1.5em" height="1.5em"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <g fill="none" class="nc-icon-wrapper">
                                                            <path
                                                                d="M18 2h-8L4 8v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 2v16H6V8.83L10.83 4H18zM7 17h2v2H7v-2zm8 0h2v2h-2v-2zm-8-6h2v4H7v-4zm4 4h2v4h-2v-4zm0-4h2v2h-2v-2zm4 0h2v4h-2v-4z"
                                                                fill="currentColor"></path>
                                                        </g>
                                                    </svg>
                                                </button>

                                                <div x-show="isOpen"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 transform scale-95"
                                                    x-transition:enter-end="opacity-100 transform scale-100"
                                                    x-transition:leave="transition ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 transform scale-100"
                                                    x-transition:leave-end="opacity-0 transform scale-95"
                                                    class="popover absolute bg-gray-700 border shadow-md mt-2 px-4 py-2 rounded-lg">

                                                    <p class="text-white">Ver Sim card's</p>
                                                </div>
                                            </div>

                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <div class="space-x-1">

                                                <a href="{{ route('admin.users.edit', $tecnico) }}">
                                                    <button class="text-slate-400 hover:text-slate-500 rounded-full">
                                                        <span class="sr-only">Editar</span>
                                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                            <path
                                                                d="M19.7 8.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 22H10v-2.6l6-6 2.6 2.6-6 6zm7.4-7.4L17.4 12l1.6-1.6 2.6 2.6-1.6 1.6z" />
                                                        </svg>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if ($tecnicos->count() < 1)
                                <td colspan="10"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center">No hay Registros</div>
                                </td>
                            @endif


                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <div class="mt-8 w-full">
        {{ $tecnicos->links() }}


    </div>
</div>




@push('scripts')
@endpush
