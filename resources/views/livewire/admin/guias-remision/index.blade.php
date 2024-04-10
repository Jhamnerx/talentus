<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Guias Remision ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Search form -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search" class="form-input pl-9 focus:border-slate-300"
                    type="search" placeholder="Buscar Guia..." />
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
            @can('crear-guias')
                <a href="{{ route('admin.almacen.guias.create') }}">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Registrar Guia</span>
                    </button>
                </a>
            @endcan


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
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">Guias Remision: <span
                    class="text-slate-400 font-medium">{{ $guias->total() }}</span>
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
                                        <input id="parent-checkbox" class="form-checkbox" type="checkbox" />
                                    </label>
                                </div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">#Numero</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha Emision</div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Destinatario</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 ">
                                <div class="font-semibold text-left">Motivo Traslado</div>
                            </th>

                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Modalidad Traslado</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Direccion Llegada</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Fecha inicio Traslado</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">PDF</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">XML</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">CDR</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Acciones</div>
                            </th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody class="text-sm divide-y divide-slate-200">
                        <!-- Row -->

                        @foreach ($guias as $guia)
                            <tr class="hover:cursor-pointer hover:shadow-md">
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="flex items-
                                        center">
                                        <label class="inline-flex">
                                            <span class="sr-only">Select</span>
                                            <input class="table-item form-checkbox" type="checkbox"
                                                @click="uncheckParent" />
                                        </label>
                                    </div>
                                </td>
                                <td wire:click.debounce.150ms="openDetallePanel('{{ $guia->id }}')"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">


                                    <div class="font-medium text-sky-600">

                                        {{ $guia->serie_correlativo }}

                                    </div>


                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                    <div>{{ $guia->fecha_emision->format('d-m-Y') }}</div>

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">
                                        {{ $guia->cliente->razon_social }}
                                    </div>
                                </td>



                                <td class="px-2 first:pl-5 last:pr-5 py-3 ">

                                    <div>{{ $guia->motivoTraslado->descripcion }}</div>

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">


                                    <div
                                        class="inline-flex font-medium bg-{{ $guia->modalidadTransporte->codigo == '01' ? 'emerald' : 'rose' }}-100 text-{{ $guia->modalidadTransporte->codigo == '01' ? 'emerald' : 'rose' }}-600 rounded-full text-center px-2.5 py-0.5">
                                        {{ $guia->modalidadTransporte->descripcion }}
                                    </div>



                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3">
                                    <div>
                                        {{ $guia->direccion_llegada }}

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div>
                                        {{ $guia->fecha_inicio_traslado->format('d-m-Y') }}

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">

                                    <div class="space-x-1">
                                        {{-- obtener pdf --}}
                                        <a target="_blank"
                                            href="{{ route('facturacion.guia.ver.pdf', ['id' => $guia->id, 'guia' => $guia]) }}">
                                            <button type="button" class="bg-white ">
                                                <svg class="w-8 h-8" viewBox="-4 0 40 40" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M25.6686 26.0962C25.1812 26.2401 24.4656 26.2563 23.6984 26.145C22.875 26.0256 22.0351 25.7739 21.2096 25.403C22.6817 25.1888 23.8237 25.2548 24.8005 25.6009C25.0319 25.6829 25.412 25.9021 25.6686 26.0962ZM17.4552 24.7459C17.3953 24.7622 17.3363 24.7776 17.2776 24.7939C16.8815 24.9017 16.4961 25.0069 16.1247 25.1005L15.6239 25.2275C14.6165 25.4824 13.5865 25.7428 12.5692 26.0529C12.9558 25.1206 13.315 24.178 13.6667 23.2564C13.9271 22.5742 14.193 21.8773 14.468 21.1894C14.6075 21.4198 14.7531 21.6503 14.9046 21.8814C15.5948 22.9326 16.4624 23.9045 17.4552 24.7459ZM14.8927 14.2326C14.958 15.383 14.7098 16.4897 14.3457 17.5514C13.8972 16.2386 13.6882 14.7889 14.2489 13.6185C14.3927 13.3185 14.5105 13.1581 14.5869 13.0744C14.7049 13.2566 14.8601 13.6642 14.8927 14.2326ZM9.63347 28.8054C9.38148 29.2562 9.12426 29.6782 8.86063 30.0767C8.22442 31.0355 7.18393 32.0621 6.64941 32.0621C6.59681 32.0621 6.53316 32.0536 6.44015 31.9554C6.38028 31.8926 6.37069 31.8476 6.37359 31.7862C6.39161 31.4337 6.85867 30.8059 7.53527 30.2238C8.14939 29.6957 8.84352 29.2262 9.63347 28.8054ZM27.3706 26.1461C27.2889 24.9719 25.3123 24.2186 25.2928 24.2116C24.5287 23.9407 23.6986 23.8091 22.7552 23.8091C21.7453 23.8091 20.6565 23.9552 19.2582 24.2819C18.014 23.3999 16.9392 22.2957 16.1362 21.0733C15.7816 20.5332 15.4628 19.9941 15.1849 19.4675C15.8633 17.8454 16.4742 16.1013 16.3632 14.1479C16.2737 12.5816 15.5674 11.5295 14.6069 11.5295C13.948 11.5295 13.3807 12.0175 12.9194 12.9813C12.0965 14.6987 12.3128 16.8962 13.562 19.5184C13.1121 20.5751 12.6941 21.6706 12.2895 22.7311C11.7861 24.0498 11.2674 25.4103 10.6828 26.7045C9.04334 27.3532 7.69648 28.1399 6.57402 29.1057C5.8387 29.7373 4.95223 30.7028 4.90163 31.7107C4.87693 32.1854 5.03969 32.6207 5.37044 32.9695C5.72183 33.3398 6.16329 33.5348 6.6487 33.5354C8.25189 33.5354 9.79489 31.3327 10.0876 30.8909C10.6767 30.0029 11.2281 29.0124 11.7684 27.8699C13.1292 27.3781 14.5794 27.011 15.985 26.6562L16.4884 26.5283C16.8668 26.4321 17.2601 26.3257 17.6635 26.2153C18.0904 26.0999 18.5296 25.9802 18.976 25.8665C20.4193 26.7844 21.9714 27.3831 23.4851 27.6028C24.7601 27.7883 25.8924 27.6807 26.6589 27.2811C27.3486 26.9219 27.3866 26.3676 27.3706 26.1461ZM30.4755 36.2428C30.4755 38.3932 28.5802 38.5258 28.1978 38.5301H3.74486C1.60224 38.5301 1.47322 36.6218 1.46913 36.2428L1.46884 3.75642C1.46884 1.6039 3.36763 1.4734 3.74457 1.46908H20.263L20.2718 1.4778V7.92396C20.2718 9.21763 21.0539 11.6669 24.0158 11.6669H30.4203L30.4753 11.7218L30.4755 36.2428ZM28.9572 10.1976H24.0169C21.8749 10.1976 21.7453 8.29969 21.7424 7.92417V2.95307L28.9572 10.1976ZM31.9447 36.2428V11.1157L21.7424 0.871022V0.823357H21.6936L20.8742 0H3.74491C2.44954 0 0 0.785336 0 3.75711V36.2435C0 37.5427 0.782956 40 3.74491 40H28.2001C29.4952 39.9997 31.9447 39.2143 31.9447 36.2428Z"
                                                        fill="#EB5757" />
                                                </svg>

                                            </button>
                                        </a>
                                    </div>

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px text-center">

                                    <div class="space-x-1">
                                        {{-- obtener xml --}}
                                        <a href="{{ route('facturacion.guia.ver.xml', $guia) }}">
                                            <button type="button" class="bg-white">
                                                <svg aria-hidden="true" class="w-8 h-8" viewBox="0 0 56 56"
                                                    style="enable-background:new 0 0 56 56;" xml:space="preserve">
                                                    <g>
                                                        <path style="fill:#E9E9E0;"
                                                            d="M36.985,0H7.963C7.155,0,6.5,0.655,6.5,1.926V55c0,0.345,0.655,1,1.463,1h40.074 c0.808,0,1.463-0.655,1.463-1V12.978c0-0.696-0.093-0.92-0.257-1.085L37.607,0.257C37.442,0.093,37.218,0,36.985,0z" />
                                                        <polygon style="fill:#D9D7CA;"
                                                            points="37.5,0.151 37.5,12 49.349,12" />
                                                        <path style="fill:#F29C1F;"
                                                            d="M48.037,56H7.963C7.155,56,6.5,55.345,6.5,54.537V39h43v15.537C49.5,55.345,48.845,56,48.037,56z" />
                                                        <g>
                                                            <path style="fill:#FFFFFF;"
                                                                d="M19.379,48.105L21.936,53h-1.9l-1.6-3.801h-0.137L16.576,53h-1.9l2.557-4.895l-2.721-5.182h1.873 l1.777,4.102h0.137l1.928-4.102H22.1L19.379,48.105z" />
                                                            <path style="fill:#FFFFFF;"
                                                                d="M31.998,42.924h1.668V53h-1.668v-6.932l-2.256,5.605h-1.449l-2.27-5.605V53h-1.668V42.924h1.668 l2.994,6.891L31.998,42.924z" />
                                                            <path style="fill:#FFFFFF;"
                                                                d="M37.863,42.924v8.832h4.635V53h-6.303V42.924H37.863z" />
                                                        </g>
                                                        <path style="fill:#F29C1F;"
                                                            d="M15.5,24c-0.256,0-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414l6-6 c0.391-0.391,1.023-0.391,1.414,0s0.391,1.023,0,1.414l-6,6C16.012,23.902,15.756,24,15.5,24z" />
                                                        <path style="fill:#F29C1F;"
                                                            d="M21.5,30c-0.256,0-0.512-0.098-0.707-0.293l-6-6c-0.391-0.391-0.391-1.023,0-1.414 s1.023-0.391,1.414,0l6,6c0.391,0.391,0.391,1.023,0,1.414C22.012,29.902,21.756,30,21.5,30z" />
                                                        <path style="fill:#F29C1F;"
                                                            d="M33.5,30c-0.256,0-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414l6-6 c0.391-0.391,1.023-0.391,1.414,0s0.391,1.023,0,1.414l-6,6C34.012,29.902,33.756,30,33.5,30z" />
                                                        <path style="fill:#F29C1F;"
                                                            d="M39.5,24c-0.256,0-0.512-0.098-0.707-0.293l-6-6c-0.391-0.391-0.391-1.023,0-1.414 s1.023-0.391,1.414,0l6,6c0.391,0.391,0.391,1.023,0,1.414C40.012,23.902,39.756,24,39.5,24z" />
                                                        <path style="fill:#F29C1F;"
                                                            d="M24.5,32c-0.11,0-0.223-0.019-0.333-0.058c-0.521-0.184-0.794-0.755-0.61-1.276l6-17 c0.185-0.521,0.753-0.795,1.276-0.61c0.521,0.184,0.794,0.755,0.61,1.276l-6,17C25.298,31.744,24.912,32,24.5,32z" />
                                                    </g>

                                                </svg>
                                            </button>
                                        </a>
                                    </div>


                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">

                                    <div class="space-x-1">

                                        @switch($guia->fe_estado)
                                            {{-- OBTENER CDR --}}
                                            @case('0')
                                                <x-form.button.circle flat
                                                    wire:click.prevent="consultaTicket({{ $guia->id }})" teal
                                                    icon="refresh" spinner='consultaTicket({{ $guia->id }})' />
                                            @break

                                            {{-- CDR OBTENIDO --}}
                                            @case('1')
                                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                                    <div>
                                                        <button
                                                            class="inline-flex justify-center items-center grou text-sm font-medium"
                                                            aria-haspopup="true" @click="open = !open" type="button"
                                                            :aria-expanded="open">
                                                            <div class="flex items-center truncate">
                                                                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                                                    height="511pt" version="1.1"
                                                                    viewBox="-38 0 511 511.99956" width="511pt">
                                                                    <g id="surface1">
                                                                        <path
                                                                            d="M 413.476562 341.910156 C 399.714844 379.207031 378.902344 411.636719 351.609375 438.289062 C 320.542969 468.625 279.863281 492.730469 230.699219 509.925781 C 229.085938 510.488281 227.402344 510.949219 225.710938 511.289062 C 223.476562 511.730469 221.203125 511.96875 218.949219 512 L 218.507812 512 C 216.105469 512 213.691406 511.757812 211.296875 511.289062 C 209.605469 510.949219 207.945312 510.488281 206.339844 509.9375 C 157.117188 492.769531 116.386719 468.675781 85.289062 438.339844 C 57.984375 411.6875 37.175781 379.277344 23.433594 341.980469 C -1.554688 274.167969 -0.132812 199.464844 1.011719 139.433594 L 1.03125 138.511719 C 1.261719 133.554688 1.410156 128.347656 1.492188 122.597656 C 1.910156 94.367188 24.355469 71.011719 52.589844 69.4375 C 111.457031 66.152344 156.996094 46.953125 195.90625 9.027344 L 196.246094 8.714844 C 202.707031 2.789062 210.847656 -0.117188 218.949219 0.00390625 C 226.761719 0.105469 234.542969 3.007812 240.773438 8.714844 L 241.105469 9.027344 C 280.023438 46.953125 325.5625 66.152344 384.429688 69.4375 C 412.664062 71.011719 435.109375 94.367188 435.527344 122.597656 C 435.609375 128.386719 435.757812 133.585938 435.988281 138.511719 L 436 138.902344 C 437.140625 199.046875 438.554688 273.898438 413.476562 341.910156 Z M 413.476562 341.910156 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,86.666667%,50.196078%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 413.476562 341.910156 C 399.714844 379.207031 378.902344 411.636719 351.609375 438.289062 C 320.542969 468.625 279.863281 492.730469 230.699219 509.925781 C 229.085938 510.488281 227.402344 510.949219 225.710938 511.289062 C 223.476562 511.730469 221.203125 511.96875 218.949219 512 L 218.949219 0.00390625 C 226.761719 0.105469 234.542969 3.007812 240.773438 8.714844 L 241.105469 9.027344 C 280.023438 46.953125 325.5625 66.152344 384.429688 69.4375 C 412.664062 71.011719 435.109375 94.367188 435.527344 122.597656 C 435.609375 128.386719 435.757812 133.585938 435.988281 138.511719 L 436 138.902344 C 437.140625 199.046875 438.554688 273.898438 413.476562 341.910156 Z M 413.476562 341.910156 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,66.666667%,38.823529%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 346.101562 256 C 346.101562 326.207031 289.097656 383.355469 218.949219 383.605469 L 218.5 383.605469 C 148.144531 383.605469 90.894531 326.359375 90.894531 256 C 90.894531 185.644531 148.144531 128.398438 218.5 128.398438 L 218.949219 128.398438 C 289.097656 128.648438 346.101562 185.796875 346.101562 256 Z M 346.101562 256 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 346.101562 256 C 346.101562 326.207031 289.097656 383.355469 218.949219 383.605469 L 218.949219 128.398438 C 289.097656 128.648438 346.101562 185.796875 346.101562 256 Z M 346.101562 256 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(88.235294%,92.156863%,94.117647%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 276.417969 237.625 L 218.949219 295.101562 L 206.53125 307.519531 C 203.597656 310.453125 199.75 311.917969 195.90625 311.917969 C 192.058594 311.917969 188.214844 310.453125 185.277344 307.519531 L 158.578125 280.808594 C 152.710938 274.941406 152.710938 265.4375 158.578125 259.566406 C 164.4375 253.699219 173.953125 253.699219 179.820312 259.566406 L 195.90625 275.652344 L 255.175781 216.382812 C 261.042969 210.511719 270.558594 210.511719 276.417969 216.382812 C 282.285156 222.25 282.285156 231.765625 276.417969 237.625 Z M 276.417969 237.625 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(70.588235%,82.352941%,84.313725%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 276.417969 237.625 L 218.949219 295.101562 L 218.949219 252.605469 L 255.175781 216.382812 C 261.042969 210.511719 270.558594 210.511719 276.417969 216.382812 C 282.285156 222.25 282.285156 231.765625 276.417969 237.625 Z M 276.417969 237.625 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(43.529412%,64.705882%,66.666667%);fill-opacity:1;" />
                                                                    </g>
                                                                </svg>

                                                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                                                    viewBox="0 0 12 12">
                                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                                </svg>
                                                            </div>
                                                        </button>
                                                    </div>

                                                    <div x-show="open" @click.away="open = false"
                                                        class="origin-top-right z-10 absolute top-full right-0 mt-2 min-w-44 rounded-md bg-white border border-slate-300 shadow-2xl ring-1 ring-black ring-opacity-5 overflow-hidden">
                                                        <div class="py-1" role="menu" aria-orientation="vertical"
                                                            aria-labelledby="options-menu">

                                                            <div
                                                                class="flex flex-nowrap px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900">
                                                                <div class="w-full">
                                                                    <span>FACTURA:</span>
                                                                </div>
                                                                <div class="w-full">
                                                                    <x-form.badge indigo md
                                                                        label="{{ $guia->serie_correlativo }}" />
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="flex flex-nowrap px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900">
                                                                <div class="w-full">
                                                                    <span>Estado:</span>
                                                                </div>
                                                                <div class="w-full">
                                                                    <x-form.badge indigo md
                                                                        label="{{ $guia->estado_texto }}" />
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="flex flex-nowrap px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900">
                                                                <div class="w-full">
                                                                    <span>Código:</span>
                                                                </div>
                                                                <div class="w-full">
                                                                    <x-form.badge indigo md label="{{ $guia->code_sunat }}" />
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="flex flex-nowrap px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900">
                                                                <div class="w-full">
                                                                    <span>Descripción: </span>
                                                                </div>
                                                                <div class="w-full mx-2">

                                                                    <span>{{ $guia->fe_mensaje_sunat }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @break

                                            {{-- RECHAZADO --}}
                                            @case('2')
                                                <button type="button" class="bg-white cursor-default">
                                                    <svg class="w-8 h-8" id="icons" enable-background="new 0 0 64 64"
                                                        height="512" viewBox="0 0 64 64" width="512"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <g>
                                                                <path
                                                                    d="m41 52c.55 0 1 .45 1 1v6.152 1.005s-.433.128-.962.278c0 0-5.519 1.566-9.038 1.566-2.06 0-5.014-.487-5.014-.487-.542-.089-.986-.613-.986-1.162v-7.352c0-.55.45-1 1-1h.01 2 9.99z"
                                                                    fill="#656d78" />
                                                            </g>
                                                            <g>
                                                                <path
                                                                    d="m43.95 20.05c-.22-1.16-1.23-2.03-2.45-2.03-1.38 0-2.5 1.12-2.5 2.5v-5.02c0-1.39-1.12-2.5-2.5-2.5s-2.5 1.11-2.5 2.5v-3c0-1.39-1.12-2.5-2.5-2.5s-2.5 1.11-2.5 2.5v3c0-1.39-1.12-2.5-2.5-2.5s-2.5 1.11-2.5 2.5v18.5l-3.89-3.41-.11-.09c-.42-.31-.94-.5-1.5-.5-1.38 0-2.5 1.12-2.5 2.5 0 .46.12.89.34 1.26l5.99 7.91 2.09 2.771c.96 1.42 2.17 2.659 3.59 3.569v3.99h11.99v-.17-3.83c2.39-1.4 4-4.01 4-7v-20.48c0-.16-.02-.32-.05-.47z"
                                                                    fill="#eac6bb" />
                                                            </g>
                                                            <g>
                                                                <path
                                                                    d="m51.8 12.2c-5.07-5.06-12.07-8.2-19.8-8.2-15.46 0-28 12.54-28 28 0 7.73 3.14 14.73 8.2 19.8 3.72 3.71 8.479 6.391 13.8 7.55v-7.35h2.01v-3.99c-1.42-.91-2.63-2.149-3.59-3.569l-2.09-2.771-5.99-7.91c-.22-.37-.34-.8-.34-1.26 0-1.38 1.12-2.5 2.5-2.5.56 0 1.08.19 1.5.5l.11.09 3.89 3.41v-18.5c0-1.39 1.12-2.5 2.5-2.5s2.5 1.11 2.5 2.5v-3c0-1.39 1.12-2.5 2.5-2.5s2.5 1.11 2.5 2.5v3c0-1.39 1.12-2.5 2.5-2.5s2.5 1.11 2.5 2.5v5.02c0-1.38 1.12-2.5 2.5-2.5 1.22 0 2.23.87 2.45 2.03.03.15.05.31.05.47v20.48c0 2.99-1.61 5.6-4 7v3.83.17h2v6.15c10.52-4.02 18-14.21 18-26.15 0-7.73-3.14-14.73-8.2-19.8z"
                                                                    fill="#f5f7fa" />
                                                            </g>
                                                            <g>
                                                                <path
                                                                    d="m28.998 15.259c0-1.379-1.12-2.5-2.5-2.5s-2.5 1.121-2.5 2.5v18.51l-3.89-3.408-.11-.102c-.42-.309-.94-.5-1.5-.5-1.38 0-2.5 1.121-2.5 2.5 0 .441.11.861.32 1.221l8.1 10.73c.97 1.41 2.17 2.66 3.59 3.559v3.99h11.99v-3.99c2.39-1.398 4-4.01 4-7.01v-20.479c0-1.381-1.12-2.5-2.5-2.5s-2.5 1.119-2.5 2.5v-5.021c0-1.379-1.12-2.5-2.5-2.5s-2.5 1.121-2.5 2.5v-3c0-1.379-1.12-2.5-2.5-2.5s-2.5 1.121-2.5 2.5z"
                                                                    fill="#eac6bb" />
                                                                <g fill="#d3b1a9">
                                                                    <path
                                                                        d="m28.981 14.272c.006 0 .011-.004.017-.004.553 0 1 .447 1 1v13.5c0 .553-.447 1-1 1-.006 0-.011-.004-.017-.004z" />
                                                                    <path
                                                                        d="m38.981 20.278c.006 0 .011-.004.017-.004.553 0 1 .447 1 1v7.494c0 .553-.447 1-1 1-.006 0-.011-.004-.017-.004z" />
                                                                    <path
                                                                        d="m33.998 29.769v-14.502c0-.814.396-1.531 1-1.988v15.49c0 .552-.447 1-1 1z" />
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m12.201 52.799c-.256 0-.512-.098-.707-.293-.391-.391-.391-1.023 0-1.414l39.598-39.598c.391-.391 1.023-.391 1.414 0s.391 1.023 0 1.414l-39.598 39.598c-.195.195-.451.293-.707.293z"
                                                                        fill="#da4453" />
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <path
                                                                    d="m1 32c0-17.12 13.88-31 31-31s31 13.88 31 31-13.88 31-31 31-31-13.88-31-31zm25 27.35c1.93.43 3.94.65 6 .65 3.52 0 6.89-.65 10-1.84v-.01c10.52-4.02 18-14.21 18-26.15 0-7.73-3.14-14.73-8.2-19.8-5.07-5.06-12.07-8.2-19.8-8.2-15.46 0-28 12.54-28 28 0 7.73 3.14 14.73 8.2 19.8 3.72 3.71 8.48 6.39 13.8 7.55z"
                                                                    fill="#ed5565" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </button>
                                            @break

                                            {{-- ACEPTADO PERO CON OBSERVACIONES --}}
                                            @case('3')
                                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                                    <div>
                                                        <button
                                                            class="inline-flex justify-center items-center grou text-sm font-medium"
                                                            aria-haspopup="true" @click="open = !open" type="button"
                                                            :aria-expanded="open">
                                                            <div class="flex items-center truncate">
                                                                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                                                    height="511pt" version="1.1"
                                                                    viewBox="-38 0 511 511.99956" width="511pt">
                                                                    <g id="surface1">
                                                                        <path
                                                                            d="M 413.476562 341.910156 C 399.714844 379.207031 378.902344 411.636719 351.609375 438.289062 C 320.542969 468.625 279.863281 492.730469 230.699219 509.925781 C 229.085938 510.488281 227.402344 510.949219 225.710938 511.289062 C 223.476562 511.730469 221.203125 511.96875 218.949219 512 L 218.507812 512 C 216.105469 512 213.691406 511.757812 211.296875 511.289062 C 209.605469 510.949219 207.945312 510.488281 206.339844 509.9375 C 157.117188 492.769531 116.386719 468.675781 85.289062 438.339844 C 57.984375 411.6875 37.175781 379.277344 23.433594 341.980469 C -1.554688 274.167969 -0.132812 199.464844 1.011719 139.433594 L 1.03125 138.511719 C 1.261719 133.554688 1.410156 128.347656 1.492188 122.597656 C 1.910156 94.367188 24.355469 71.011719 52.589844 69.4375 C 111.457031 66.152344 156.996094 46.953125 195.90625 9.027344 L 196.246094 8.714844 C 202.707031 2.789062 210.847656 -0.117188 218.949219 0.00390625 C 226.761719 0.105469 234.542969 3.007812 240.773438 8.714844 L 241.105469 9.027344 C 280.023438 46.953125 325.5625 66.152344 384.429688 69.4375 C 412.664062 71.011719 435.109375 94.367188 435.527344 122.597656 C 435.609375 128.386719 435.757812 133.585938 435.988281 138.511719 L 436 138.902344 C 437.140625 199.046875 438.554688 273.898438 413.476562 341.910156 Z M 413.476562 341.910156 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,86.666667%,50.196078%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 413.476562 341.910156 C 399.714844 379.207031 378.902344 411.636719 351.609375 438.289062 C 320.542969 468.625 279.863281 492.730469 230.699219 509.925781 C 229.085938 510.488281 227.402344 510.949219 225.710938 511.289062 C 223.476562 511.730469 221.203125 511.96875 218.949219 512 L 218.949219 0.00390625 C 226.761719 0.105469 234.542969 3.007812 240.773438 8.714844 L 241.105469 9.027344 C 280.023438 46.953125 325.5625 66.152344 384.429688 69.4375 C 412.664062 71.011719 435.109375 94.367188 435.527344 122.597656 C 435.609375 128.386719 435.757812 133.585938 435.988281 138.511719 L 436 138.902344 C 437.140625 199.046875 438.554688 273.898438 413.476562 341.910156 Z M 413.476562 341.910156 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,66.666667%,38.823529%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 346.101562 256 C 346.101562 326.207031 289.097656 383.355469 218.949219 383.605469 L 218.5 383.605469 C 148.144531 383.605469 90.894531 326.359375 90.894531 256 C 90.894531 185.644531 148.144531 128.398438 218.5 128.398438 L 218.949219 128.398438 C 289.097656 128.648438 346.101562 185.796875 346.101562 256 Z M 346.101562 256 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,100%,100%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 346.101562 256 C 346.101562 326.207031 289.097656 383.355469 218.949219 383.605469 L 218.949219 128.398438 C 289.097656 128.648438 346.101562 185.796875 346.101562 256 Z M 346.101562 256 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(88.235294%,92.156863%,94.117647%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 276.417969 237.625 L 218.949219 295.101562 L 206.53125 307.519531 C 203.597656 310.453125 199.75 311.917969 195.90625 311.917969 C 192.058594 311.917969 188.214844 310.453125 185.277344 307.519531 L 158.578125 280.808594 C 152.710938 274.941406 152.710938 265.4375 158.578125 259.566406 C 164.4375 253.699219 173.953125 253.699219 179.820312 259.566406 L 195.90625 275.652344 L 255.175781 216.382812 C 261.042969 210.511719 270.558594 210.511719 276.417969 216.382812 C 282.285156 222.25 282.285156 231.765625 276.417969 237.625 Z M 276.417969 237.625 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(70.588235%,82.352941%,84.313725%);fill-opacity:1;" />
                                                                        <path
                                                                            d="M 276.417969 237.625 L 218.949219 295.101562 L 218.949219 252.605469 L 255.175781 216.382812 C 261.042969 210.511719 270.558594 210.511719 276.417969 216.382812 C 282.285156 222.25 282.285156 231.765625 276.417969 237.625 Z M 276.417969 237.625 "
                                                                            style=" stroke:none;fill-rule:nonzero;fill:rgb(43.529412%,64.705882%,66.666667%);fill-opacity:1;" />
                                                                    </g>
                                                                </svg>

                                                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                                                    viewBox="0 0 12 12">
                                                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                                                </svg>
                                                            </div>
                                                        </button>
                                                    </div>

                                                    <div x-show="open" @click.away="open = false"
                                                        class="origin-top-right z-10 absolute top-full overflow-x-auto right-0 mt-2 min-w-44 max-w-md rounded-md bg-white border border-slate-300 shadow-2xl ring-1 ring-black ring-opacity-5 overflow-hidden">
                                                        <div class="py-1" role="menu" aria-orientation="vertical"
                                                            aria-labelledby="options-menu">

                                                            <div
                                                                class="flex flex-nowrap px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900">
                                                                <div class="w-full">
                                                                    <span>FACTURA:</span>
                                                                </div>
                                                                <div class="w-full">
                                                                    <x-form.badge indigo md
                                                                        label="{{ $guia->serie_correlativo }}" />
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="flex flex-nowrap px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900">
                                                                <div class="w-full">
                                                                    <span>Estado:</span>
                                                                </div>
                                                                <div class="w-full">
                                                                    <x-form.badge indigo md
                                                                        label="{{ $guia->estado_texto }}" />
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="flex flex-nowrap px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900">
                                                                <div class="w-full">
                                                                    <span>Código:</span>
                                                                </div>
                                                                <div class="w-full">
                                                                    <x-form.badge indigo md label="{{ $guia->code_sunat }}" />
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="flex flex-nowrap px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900 whitespace-normal">
                                                                <div class="w-full">
                                                                    <span>Descripción: </span>
                                                                </div>
                                                                <div class="w-full">


                                                                    {{ $guia->fe_mensaje_sunat }}
                                                                </div>
                                                            </div>
                                                            <table
                                                                class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                                <thead
                                                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                                    <tr>
                                                                        <th scope="col" class="px-6 py-3">
                                                                            #
                                                                        </th>
                                                                        <th scope="col" class="px-6 py-3">
                                                                            Nota
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($guia->nota as $key => $nota)
                                                                        <tr
                                                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                            <th scope="row"
                                                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">

                                                                                {{ $key + 1 }}

                                                                            </th>
                                                                            <td class="px-6 py-4 text-wrap">
                                                                                {{ $nota }}
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @break
                                        @endswitch
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">

                                    <div class=" text-center space-x-1">
                                        <x-form.dropdown class="w-60">
                                            @role('admin')
                                                @if (!$guia->clase && $guia->fe_estado == '0')
                                                    <x-form.dropdown.item
                                                        wire:click.prevent='createXml({{ $guia->id }})'
                                                        icon='refresh' label="Crear XML" />
                                                @endif
                                            @endrole
                                            @can('editar-guias')
                                                @if ($guia->fe_estado == '0')
                                                    <x-form.dropdown.item icon='pencil' label="Editar"
                                                        href="{{ route('admin.almacen.guias.edit', $guia) }}" />
                                                @else
                                                    <x-form.dropdown.item disabled icon='pencil' label="Editar" />
                                                @endif
                                            @endcan


                                            @can('eliminar-guias')
                                                <x-form.dropdown.item
                                                    wire:click.prevent="openModalDelete({{ $guia->id }})"
                                                    icon='trash' label="Eliminar" />
                                            @endcan
                                        </x-form.dropdown>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        @if ($guias->count() < 1)
                            <tr>
                                <td colspan="12"
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
        {{ $guias->links() }}
        {{-- @include('admin.partials.pagination-classic') --}}

    </div>
    @livewire('admin.guias-remision.detalle-panel', key('panel-detalle-guia'))
</div>
