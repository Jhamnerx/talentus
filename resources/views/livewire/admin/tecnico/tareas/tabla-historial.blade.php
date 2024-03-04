<div>
    <div class="sm:flex sm:justify-between sm:items-center my-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Historial de Tareas</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search form -->
            <div class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live="search" class="form-input pl-9 focus:border-slate-300" type="search"
                    placeholder="Buscar tarea" />

                <button type="button" class="absolute inset-0 right-auto group" type="button" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </div>
            {{-- button save --}}
            @can('tecnico.tareas.create')
                <button type="button" wire:click.prevent="addTask" class="btn bg-teal-600 hover:bg-teal-700 text-white">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Crear Tarea</span>
                </button>
            @endcan

        </div>

    </div>
    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Right side -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Delete button -->
            <div class="table-items-action hidden">
                <div class="flex items-center">
                    <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span
                            class="table-items-count"></span> items seleccionado</div>
                    <button
                        class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Eliminar</button>
                </div>
            </div>

            <!-- Dropdown -->
            <div class="relative float-right" x-data="{ open: false, selected: 1 }">
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
                        <button wire:click="pagination(5)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 0 && 'text-indigo-500'" @click="selected = 0;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 0 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Mostrar 5</span>
                        </button>
                        <button wire:click="pagination(10)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 1 && 'text-indigo-500'" @click="selected = 1;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 1 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Mostrar 10</span>
                        </button>
                        <button wire:click="pagination(15)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 2 && 'text-indigo-500'" @click="selected = 2;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 2 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Mostrar 15</span>
                        </button>
                        <button wire:click="pagination(20)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 3 && 'text-indigo-500'" @click="selected = 3;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 3 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Mostrar 20</span>
                        </button>
                        <button wire:click="pagination(30)" tabindex="0"
                            class="flex items-center w-full hover:bg-slate-50 py-1 px-3 cursor-pointer"
                            :class="selected === 4 && 'text-indigo-500'" @click="selected = 4;open = false"
                            @focus="open = true" @focusout="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 4 && 'invisible'" width="12" height="9"
                                viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Mostrar 30</span>
                        </button>

                    </div>
                </div>
            </div>

            <!-- tecnico button -->
            @can('tecnico.tareas.tecnicos.admin')
                <div class="relative inline-flex">

                    <button wire:click.prevent="showTecnicos"
                        class="btn bg-cyan-500 hover:bg-cyan-600 text-white btn border-slate-200 hover:border-slate-300">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path
                                    d="M43.989,35.373,30.167,23.437,23,30.389l12.373,13.6q.1.115.213.225a6.1,6.1,0,0,0,8.627,0h0c.073-.073.144-.148.213-.224A6.1,6.1,0,0,0,43.989,35.373Z"
                                    fill="#ff7163"></path>
                                <path
                                    d="M8.414,14H11l8.847,8.847L23,20l-9-9V8.414a1,1,0,0,0-.293-.707L8,2,2,8l5.707,5.707A1,1,0,0,0,8.414,14Z"
                                    fill="#949494"></path>
                                <path
                                    d="M35.629,24.383A11.321,11.321,0,0,0,45.977,14.034a12.35,12.35,0,0,0-.485-4.291L39.48,15.754,32.251,8.525l6.011-6.012a12.342,12.342,0,0,0-4.29-.477,11.321,11.321,0,0,0-10.35,10.348,12.345,12.345,0,0,0,.479,4.295L3.046,35.688a3.171,3.171,0,0,0-.226,4.478c.036.04.072.078.11.115l4.793,4.794a3.17,3.17,0,0,0,4.483-.008c.037-.036.072-.074.107-.112L31.333,23.9A12.353,12.353,0,0,0,35.629,24.383Z"
                                    fill="#c8c8c8"></path>
                                <path d="M39,40a1,1,0,0,1-.707-.293l-7-7a1,1,0,0,1,1.414-1.414l7,7A1,1,0,0,1,39,40Z"
                                    fill="#f74b3b">
                                </path>
                            </g>
                        </svg>
                        <span class="hidden xs:block ml-2">Administrar Tecnicos</span>
                    </button>

                </div>
            @endcan

        </div>

    </div>

    @can('tecnico.tareas.tabla-historial')
        <x-admin.tecnico.tareas.tabla-historial :tareas="$tareas">
        </x-admin.tecnico.tareas.tabla-historial>


        <div class="mt-8 w-full">
            {{ $tareas->links() }}

        </div>
    @endcan
    @cannot('tecnico.tareas.tabla-historial')
        <div class="mt-8 w-full">
            <h5>No tienes permisos para ver esta tabla</h5>

        </div>
    @endcannot

</div>
