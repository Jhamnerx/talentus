<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Mantenimiento Vehiculos 🚗</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model='search' id="action-search" class="form-input pl-9 focus:border-slate-300"
                    type="search" placeholder="Buscar por numero" />
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

            <div class="relative inline-flex">

                <!-- Create button -->
                <button wire:click="openModalSave" aria-controls="basic-modal"
                    class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Crear Mantenimiento</span>
                </button>

            </div>

        </div>

    </div>

    <!-- More actions -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">



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


            <!-- Export button -->
            <div class="relative inline-flex">
                <a href="javascript:void(0)">
                    <button
                        class="btn bg-emerald-600 hover:bg-emerald-700 text-white btn border-slate-200 hover:border-slate-300">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 32 32">
                            <path
                                d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Exportar</span>
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Mantenimientos # <span
                    class="text-slate-400 font-medium">{{ $mantenimientos->total() }}</span>
            </h2>
        </header>
        <div x-data="handleSelect">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <!-- Table header -->
                    <thead
                        class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <div class="flex items-center">
                                    <label class="inline-flex">
                                        <span class="sr-only">Seleccionar todo</span>
                                        <input id="parent-checkbox" class="form-checkbox" type="checkbox"
                                            @click="toggleAll" />
                                    </label>
                                </div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">#</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Vehiculo</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Detalle</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha de Programación</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Estado</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Nota</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Registrado por:</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Informe</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Acciones</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->
                        @if ($mantenimientos->count())
                            @foreach ($mantenimientos as $mantenimiento)
                                <tr>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center">
                                            <label class="inline-flex">
                                                <span class="sr-only">Select</span>
                                                <input class="table-item form-checkbox" type="checkbox"
                                                    @click="uncheckParent" />
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-blue-500">{{ $mantenimiento->numero }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $mantenimiento->vehiculo->placa }}
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $mantenimiento->detalle_trabajo }}
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">
                                            {{ $mantenimiento->fecha_hora_mantenimiento->format('d-m-Y') }}</div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div
                                            class="inline-flex font-medium bg-{{ $mantenimiento->estado->color() }}-100 text-{{ $mantenimiento->estado->color() }}-600 rounded-full text-center px-2.5 py-0.5">
                                            {{ $mantenimiento->estado->name }}
                                        </div>

                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $mantenimiento->nota }}</div>
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $mantenimiento->user->name }}</div>
                                    </td>

                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div class="m-1.5">
                                            <!-- Start -->
                                            <button type="button" wire:click='generateInforme'
                                                class="py-1 hover:border hover:border-red-200 hover:rounded-sm">
                                                <svg class="w-9 shrink-0" viewBox="0 0 32 32"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M24.1,2.072h0l5.564,5.8V29.928H8.879V30H29.735V7.945L24.1,2.072"
                                                        style="fill:#909090" />
                                                    <path d="M24.031,2H8.808V29.928H29.664V7.873L24.03,2"
                                                        style="fill:#f4f4f4" />
                                                    <path d="M8.655,3.5H2.265v6.827h20.1V3.5H8.655"
                                                        style="fill:#7a7b7c" />
                                                    <path d="M22.472,10.211H2.395V3.379H22.472v6.832"
                                                        style="fill:#dd2025" />
                                                    <path
                                                        d="M9.052,4.534h-.03l-.207,0H7.745v4.8H8.773V7.715L9,7.728a2.042,2.042,0,0,0,.647-.117,1.427,1.427,0,0,0,.493-.291,1.224,1.224,0,0,0,.335-.454,2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65A2.149,2.149,0,0,0,9.37,4.56a2.232,2.232,0,0,0-.319-.026M8.862,6.828l-.089,0V5.348h.193a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                                                        style="fill:#464648" />
                                                    <path
                                                        d="M12.533,4.521c-.111,0-.219.008-.295.011L12,4.538h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.392h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                                                        style="fill:#464648" />
                                                    <path
                                                        d="M17.43,4.538H15v4.8h1.028V7.434h1.3V6.542h-1.3V5.43h1.4V4.538"
                                                        style="fill:#464648" />
                                                    <path
                                                        d="M21.781,20.255s3.188-.578,3.188.511S22.994,21.412,21.781,20.255Zm-2.357.083a7.543,7.543,0,0,0-1.473.489l.4-.9c.4-.9.815-2.127.815-2.127a14.216,14.216,0,0,0,1.658,2.252,13.033,13.033,0,0,0-1.4.288Zm-1.262-6.5c0-.949.307-1.208.546-1.208s.508.115.517.939a10.787,10.787,0,0,1-.517,2.434A4.426,4.426,0,0,1,18.161,13.841ZM13.513,24.354c-.978-.585,2.051-2.386,2.6-2.444C16.11,21.911,14.537,24.966,13.513,24.354ZM25.9,20.895c-.01-.1-.1-1.207-2.07-1.16a14.228,14.228,0,0,0-2.453.173,12.542,12.542,0,0,1-2.012-2.655,11.76,11.76,0,0,0,.623-3.1c-.029-1.2-.316-1.888-1.236-1.878s-1.054.815-.933,2.013a9.309,9.309,0,0,0,.665,2.338s-.425,1.323-.987,2.639-.946,2.006-.946,2.006a9.622,9.622,0,0,0-2.725,1.4c-.824.767-1.159,1.356-.725,1.945.374.508,1.683.623,2.853-.91a22.549,22.549,0,0,0,1.7-2.492s1.784-.489,2.339-.623,1.226-.24,1.226-.24,1.629,1.639,3.2,1.581,1.495-.939,1.485-1.035"
                                                        style="fill:#dd2025" />
                                                    <path d="M23.954,2.077V7.95h5.633L23.954,2.077Z"
                                                        style="fill:#909090" />
                                                    <path d="M24.031,2V7.873h5.633L24.031,2Z" style="fill:#f4f4f4" />
                                                    <path
                                                        d="M8.975,4.457h-.03l-.207,0H7.668v4.8H8.7V7.639l.228.013a2.042,2.042,0,0,0,.647-.117,1.428,1.428,0,0,0,.493-.291A1.224,1.224,0,0,0,10.4,6.79a2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65,2.149,2.149,0,0,0-.411-.105,2.232,2.232,0,0,0-.319-.026M8.785,6.751l-.089,0V5.271H8.89a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                                                        style="fill:#fff" />
                                                    <path
                                                        d="M12.456,4.444c-.111,0-.219.008-.295.011l-.235.006h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.315h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                                                        style="fill:#fff" />
                                                    <path
                                                        d="M17.353,4.461h-2.43v4.8h1.028V7.357h1.3V6.465h-1.3V5.353h1.4V4.461"
                                                        style="fill:#fff" />
                                                </svg>
                                            </button>
                                            <!-- End -->
                                        </div>
                                    </td>
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="relative inline-flex" x-data="{ open: false }">
                                            <div class="relative inline-block h-full text-left">
                                                <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                    :class="{ 'bg-slate-100 text-slate-500': open }"
                                                    aria-haspopup="true" @click.prevent="open = !open"
                                                    :aria-expanded="open">
                                                    <span class="sr-only">Menu</span>
                                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                        <circle cx="16" cy="16" r="2" />
                                                        <circle cx="10" cy="16" r="2" />
                                                        <circle cx="22" cy="16" r="2" />
                                                    </svg>
                                                </button>
                                                <div class="origin-top-right  z-10 absolute transform  -translate-x-3/4  top-full left-0 min-w-36 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1  ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                                                    @click.outside="open = false"
                                                    @keydown.escape.window="open = false" x-show="open"
                                                    x-transition:enter="transition ease-out duration-200 transform"
                                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-out duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" x-cloak>

                                                    <ul>

                                                        <li>
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent='openModalEdit({{ $mantenimiento->id }})'
                                                                class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-27"
                                                                role="menuitem" tabindex="-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                    </path>
                                                                </svg> Editar

                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent='openModalDelete({{ $mantenimiento->id }})'
                                                                class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-28"
                                                                role="menuitem" tabindex="-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                                Eliminar
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('admin.vehiculos.mantenimiento.show', $mantenimiento) }}"
                                                                class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-29"
                                                                role="menuitem" tabindex="-1"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="h-5 w-5  mr-3 text-gray-400 group-hover:text-violet-500">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                    </path>
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                    </path>
                                                                </svg> Ver
                                                            </a>
                                                        </li>




                                                        <li @click="open = false">
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent="createTask({{ $mantenimiento->id }})"
                                                                class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-30"
                                                                role="menuitem" tabindex="-1">

                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 64 64"
                                                                    class="h-5 w-5 mr-3 text-gray-400 group-hover:text-yellow-500">
                                                                    <g stroke-linecap="round" stroke-width="3"
                                                                        fill="none" stroke="currentColor"
                                                                        stroke-linejoin="round"
                                                                        class="nc-icon-wrapper">
                                                                        <path
                                                                            d="M47.75,37.458,56.352,45a8.034,8.034,0,0,1,.575,11.347c-.091.1-.184.2-.28.3h0a8.035,8.035,0,0,1-11.363,0c-.1-.1-.189-.2-.28-.3L35.667,46.167">
                                                                        </path>
                                                                        <polyline data-cap="butt"
                                                                            points="29.439 25.439 20 16 20 12 13 5 5 13 12 20 16 20 25.234 29.234">
                                                                        </polyline>
                                                                        <path
                                                                            d="M58.376,14.5,51,21.879l-8.872-8.872L49.5,5.629a15.142,15.142,0,0,0-5.266-.586,13.9,13.9,0,0,0-12.7,12.7,15.124,15.124,0,0,0,.588,5.271L6.283,46.344a3.89,3.89,0,0,0-.277,5.495c.044.049.089.1.135.142l5.882,5.882a3.891,3.891,0,0,0,5.5-.009c.044-.045.088-.09.13-.137L41,31.881a15.127,15.127,0,0,0,5.272.588,13.9,13.9,0,0,0,12.7-12.7A15.145,15.145,0,0,0,58.376,14.5Z">
                                                                        </path>
                                                                    </g>
                                                                </svg>
                                                                Crear Tarea Tecnico
                                                            </a>
                                                        </li>


                                                        <li>
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent="markAs({{ $mantenimiento->id }}, 'COMPLETADA')"
                                                                class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-33"
                                                                role="menuitem" tabindex="-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="h-5 w-5  mr-3 text-gray-400 group-hover:text-lime-500">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                                Marcar como Completada
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="javascript: void(0)"
                                                                wire:click.prevent="markAs({{ $mantenimiento->id }}, 'CANCELADO')"
                                                                class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                                disabled="false" id="headlessui-menu-item-34"
                                                                role="menuitem" tabindex="-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    class="h-5 w-5  mr-3 text-gray-400 group-hover:text-rose-600">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg> Marcar como Cancelada
                                                            </a>
                                                        </li>

                                                    </ul>


                                                </div>
                                            </div>

                                        </div>

                                    </td>


                                </tr>
                            @endforeach
                        @else
                            <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                <div class="text-center">No hay Registros</div>
                            </td>
                        @endif


                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $mantenimientos->links() }}


    </div>


</div>
