<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Certificados ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search" class="form-input pl-9 focus:border-slate-300"
                    type="search" placeholder="Buscar certificados" />
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

            <!-- Create invoice button -->

            <button wire:click="openModalSave()" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="hidden xs:block ml-2">Crear Certificado</span>
            </button>


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
                        <span class="ml-1 text-indigo-200">{{ $certificados->total() }}</span></button>
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



        </div>

    </div>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Certificados <span
                    class="text-slate-400 font-medium">{{ $certificados->total() }}</span>
            </h2>
        </header>
        <div>

            <!-- Table -->
            <div class="overflow-x-auto min-h-screen">
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
                                <div class="font-semibold text-left">Codigo</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Descargar</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Vehiculo</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Cliente</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Dispositivo</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha Fin</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha Instalación</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Accesorios</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Caracteristicas</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Acciones</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->

                        @foreach ($certificados as $certificado)
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
                                    <div class="font-medium text-sky-500">
                                        @if (!$certificado->codigo == null)
                                            {{ $certificado->codigo }}
                                        @else
                                            {{ $certificado->ciudades->prefijo . '-' . $certificado->numero }}
                                        @endif

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="space-x-1">
                                        <a target="_blank"
                                            href="{{ route('admin.pdf.certificados', ['certificado' => $certificado, 'vehiculo' => $certificado->vehiculo]) }}">
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full">
                                                <span class="sr-only">Descargar</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <path
                                                        d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
                                                </svg>
                                            </button>
                                        </a>

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">
                                        {{ $certificado->vehiculo->placa }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div class="font-medium text-slate-800">
                                        {{ $certificado->vehiculo->cliente->razon_social }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">
                                        @php
                                            // Obtenemos el dispositivo principal (is_principal = 1)
                                            $dispositivoPrincipal = $certificado->vehiculo->dispositivos
                                                ->where('is_principal', 1)
                                                ->first();
                                        @endphp

                                        @if ($dispositivoPrincipal && $dispositivoPrincipal->dispositivo && $dispositivoPrincipal->dispositivo->modelo)
                                            {{ $dispositivoPrincipal->dispositivo->modelo->modelo }}
                                            <br><small>(IMEI: {{ $dispositivoPrincipal->imei }})</small>
                                        @else
                                            Registrar dispositivo
                                        @endif
                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">
                                        {{ $certificado->fin_cobertura->format('d-m-Y') }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>{{ $certificado->fecha_instalacion->format('d-m-Y') }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                    <!-- Start -->
                                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                        @mouseleave="open = false">
                                        <button class="btn border-slate-200 hover:border-slate-300 text-slate-600"
                                            aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                                            @focusout="open = false" @click.prevent>
                                            <span class="mr-2">Accesorios
                                                @if (!$certificado->accesorios->isEmpty())
                                                    ({{ $certificado->accesorios->count() }})
                                                @endif


                                            </span>
                                            <svg class="w-4 h-4 fill-current text-slate-400" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                                            </svg>
                                        </button>
                                        <div class="z-10 absolute top-3/4 left-1/2 transform -translate-x-1/2">
                                            <div class="min-w-72 p-3 z-10 rounded-2xl mb-2 bg-slate-100 shadow-2xl shadow-gray-800 overflow-auto max-h-full overflow-y-auto"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>
                                                <div class="">
                                                    <div
                                                        class="font-medium text-slate-800 mb-0.5 pb-2 text-center text-base">
                                                        <b>ACCESORIOS</b>
                                                    </div>
                                                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                                        <table
                                                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                            <thead
                                                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                <tr class="text-center">
                                                                    <th scope="col" class="px-6 py-3">
                                                                        #
                                                                    </th>
                                                                    <th scope="col" class="px-6 py-3 text-center">
                                                                        Accesorio
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @if ($certificado->accesorios->isEmpty())
                                                                    <tr
                                                                        class="bg-white border-b text-center dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                                                        <td colspan="2">SIN ACCESORIOS</td>

                                                                    </tr>
                                                                @else
                                                                    @foreach ($certificado->accesorios as $key => $accesorio)
                                                                        <tr
                                                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                                                            <th scope="row"
                                                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                                                {{ $key + 1 }}
                                                                            </th>

                                                                            <td class="px-6 py-4">
                                                                                {{ $accesorio }}
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                @endif



                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="font-medium text-blue-500">AHF-960</div> --}}
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 w-48">
                                    <div>
                                        <div class="m-3 w-48">
                                            <div class="flex items-center mt-2" x-data="{ checked: {{ $certificado->sello ? 'true' : 'false' }} }">
                                                <span class="text-sm mr-3">Sello: </span>
                                                <div class="form-switch">
                                                    <input wire:click="toggleSello({{ $certificado->id }})"
                                                        type="checkbox" id="switch-s{{ $certificado->id }}"
                                                        class="sr-only" x-model="checked" />
                                                    <label class="bg-slate-400" for="switch-s{{ $certificado->id }}">
                                                        <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                        <span class="sr-only">Estado</span>
                                                    </label>
                                                </div>
                                                <div class="text-sm text-slate-400 italic ml-2"
                                                    x-text="checked ? 'ON' : 'OFF'"></div>
                                            </div>
                                            <div class="flex items-center mt-2" x-data="{ checked: {{ $certificado->fondo ? 'true' : 'false' }} }">
                                                <span class="text-sm mr-3">Fondo: </span>
                                                <div class="form-switch">
                                                    <input wire:click="toggleFondo({{ $certificado->id }})"
                                                        type="checkbox" id="switch-f{{ $certificado->id }}"
                                                        class="sr-only" x-model="checked" />
                                                    <label class="bg-slate-400" for="switch-f{{ $certificado->id }}">
                                                        <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                                        <span class="sr-only">Estado</span>
                                                    </label>
                                                </div>
                                                <div class="text-sm text-slate-400 italic ml-2"
                                                    x-text="checked ? 'ON' : 'OFF'"></div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <div class="relative inline-block h-full text-left">
                                            <button class="text-slate-400 hover:text-slate-500 rounded-full"
                                                :class="{ 'bg-slate-100 text-slate-500': open }" aria-haspopup="true"
                                                @click.prevent="open = !open" :aria-expanded="open">
                                                <span class="sr-only">Menu</span>
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="2" />
                                                    <circle cx="10" cy="16" r="2" />
                                                    <circle cx="22" cy="16" r="2" />
                                                </svg>
                                            </button>
                                            <div class="origin-top-right  z-10 absolute transform  -translate-x-3/4  top-full left-0 min-w-36 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1  ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                                                @click.outside="open = false" @keydown.escape.window="open = false"
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200 transform"
                                                x-transition:enter-start="opacity-0 -translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>

                                                <ul>
                                                    <li>

                                                        <a href="javascript: void(0)"
                                                            wire:click.prevent="openModalEdit({{ $certificado->id }})"
                                                            class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                            disabled="false" id="headlessui-menu-item-27"
                                                            role="menuitem" tabindex="-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                </path>
                                                            </svg> Editar

                                                        </a>
                                                    </li>
                                                    <li>

                                                        <button type="button"
                                                            wire:click.prevent="openModalDelete({{ $certificado->id }})"
                                                            class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="h-5 w-5 mr-3 text-gray-400 group-hover:text-red-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                            Eliminar
                                                        </button>

                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.certificados.gps.show', $certificado) }}"
                                                            class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                            disabled="false" id="headlessui-menu-item-29"
                                                            role="menuitem" tabindex="-1"><svg
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="h-5 w-5  mr-3 text-gray-400 group-hover:text-violet-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg> Ver
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a wire:click.prevent="cambiarEstado('{{ $certificado->id }}', 'estado', '{{ $certificado->estado ? 0 : 1 }}')"
                                                            class="text-gray-700 group hover:cursor-pointer flex items-center px-4 py-2 text-sm font-normal"
                                                            disabled="false" id="headlessui-menu-item-29"
                                                            role="menuitem" tabindex="-1">
                                                            @if (!$certificado->estado)
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-6 w-6 mr-3" viewBox="0 0 48 48">
                                                                    <g stroke-linecap="square"
                                                                        transform="translate(0.5 0.5)" fill="none"
                                                                        stroke="currentColor" stroke-linejoin="miter"
                                                                        class="nc-icon-wrapper"
                                                                        stroke-miterlimit="10">
                                                                        <path data-cap="butt"
                                                                            d="M16,10H32A14,14,0,0,1,46,24h0A14,14,0,0,1,32,38H16"
                                                                            stroke-linecap="butt"></path>
                                                                        <circle cx="16" cy="24" r="14">
                                                                        </circle>
                                                                    </g>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-6 w-6 mr-3" viewBox="0 0 48 48">
                                                                    <g class="nc-icon-wrapper">
                                                                        <path
                                                                            d="M33,9H15a15,15,0,0,0,0,30H33A15,15,0,0,0,33,9Z"
                                                                            fill="#6cc4f5"></path>
                                                                        <circle cx="15" cy="24" r="13"
                                                                            fill="#fff">
                                                                        </circle>
                                                                    </g>
                                                                </svg>
                                                            @endif
                                                            Cambiar Estado
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript: void(0)"
                                                            wire:click="modalOpenSend({{ $certificado->id }})"
                                                            class="text-gray-700 group flex items-center px-4 py-2 text-sm font-normal"
                                                            disabled="false" id="headlessui-menu-item-32"
                                                            role="menuitem" tabindex="-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                class="h-5 w-5 mr-3 text-gray-400 group-hover:text-cyan-600">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                                                                </path>
                                                            </svg> Enviar
                                                        </a>
                                                    </li>

                                                </ul>


                                            </div>
                                        </div>

                                    </div>

                                </td>

                            </tr>
                        @endforeach

                        @if ($certificados->count() < 1)
                            <tr>
                                <td colspan="9"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center">No hay Registros</div>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="mt-8 w-full">
        {{ $certificados->links() }}

    </div>


</div>

@push('scripts')
@endpush
