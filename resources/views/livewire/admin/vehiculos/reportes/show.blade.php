<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Reporte Detalle ✨</h1>
        </div>

    </div>

    <!-- Filters -->
    <div class="mb-4 border-b border-slate-200">
        <ul class="text-sm font-medium flex flex-nowrap -mx-4 sm:-mx-6 lg:-mx-8 overflow-x-scroll no-scrollbar">
            <li class="pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                <a class="text-indigo-500 whitespace-nowrap" href="#0">Ver Todo</a>
            </li>
            <li class="pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                <a class="text-slate-500 hover:text-slate-600 whitespace-nowrap" href="#0">Vehiculo</a>
            </li>
            <li class="pb-3 mr-6 last:mr-0 first:pl-4 sm:first:pl-6 lg:first:pl-8 last:pr-4 sm:last:pr-6 lg:last:pr-8">
                <a class="text-slate-500 hover:text-slate-600 whitespace-nowrap" href="#0">Cliente</a>
            </li>
        </ul>
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-12 gap-x-4 gap-y-8">

        <!-- Tasks cards -->
        <!-- Column 1 -->
        <div class="col-span-full sm:col-span-6 xl:col-span-4">

            <!-- Column header -->
            <header>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="grow font-semibold text-slate-800 truncate">Reporte Información 🖋️</h2>
                    <button class="shrink-0 text-indigo-500 hover:text-indigo-600 ml-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                    </button>
                </div>

                <!-- Cards -->
                <div class="grid gap-2">

                    <!-- Card 1 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <h2 class="font-semibold text-slate-800 mb-1">{{ $reporte->vehiculos->placa }}</h2>
                            <!-- Content -->
                            <div>
                                <div class="text-sm">#{{ $reporte->id }} creado por <a
                                        class="font-medium text-slate-800 hover:underline"
                                        href="javascript: void(0)">{{ $reporte->user->name }}</a>
                                </div>
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <!-- Left side -->
                            <div class="flex shrink-0 -space-x-3 -ml-px">
                                <a class="block" href="javascript: void(0)">
                                    <img class="rounded-full border-2 border-white box-content"
                                        src="{{ $reporte->user->profile_photo_url }}" width="30" height="30"
                                        alt="{{ $reporte->user->name }}" />
                                </a>
                            </div>
                            <!-- Right side -->
                            <div class="flex items-center">
                                <!-- Like button -->
                                <button class="flex items-center text-slate-400 hover:text-indigo-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M14.682 2.318A4.485 4.485 0 0011.5 1 4.377 4.377 0 008 2.707 4.383 4.383 0 004.5 1a4.5 4.5 0 00-3.182 7.682L8 15l6.682-6.318a4.5 4.5 0 000-6.364zm-1.4 4.933L8 12.247l-5.285-5A2.5 2.5 0 014.5 3c1.437 0 2.312.681 3.5 2.625C9.187 3.681 10.062 3 11.5 3a2.5 2.5 0 011.785 4.251h-.003z" />
                                    </svg>
                                    <div class="text-sm text-slate-500">4</div>
                                </button>
                                <!-- Replies button -->
                                <button class="flex items-center text-slate-400 hover:text-indigo-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M8 0C3.6 0 0 3.1 0 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L8.9 12H8c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
                                    </svg>
                                    <div class="text-sm text-slate-500">7</div>
                                </button>
                                <!-- Attach button -->
                                <button class="text-slate-400 hover:text-indigo-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0zM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <h2 class="font-semibold text-slate-800 mb-1">
                                Detalle del reporte
                            </h2>
                            <!-- Content -->
                            <div>
                                <div class="text-sm">
                                    {{ $reporte->detalle }}
                                </div>
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <!-- Left side -->
                            <div></div>
                            <!-- Right side -->
                            <div class="flex items-center">
                                <!-- Date -->
                                <div class="flex items-center text-amber-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                    </svg>
                                    <div class="text-sm text-amber-600">{{ ucFirst($reporte->created_at->monthName) }}
                                        {{ $reporte->created_at->format('d') }}</div>
                                </div>
                                <!-- Replies button -->
                                <button class="flex items-center text-slate-400 hover:text-indigo-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M8 0C3.6 0 0 3.1 0 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L8.9 12H8c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
                                    </svg>
                                    <div class="text-sm text-slate-500">6</div>
                                </button>
                                <!-- Attach button -->
                                <button class="text-slate-400 hover:text-indigo-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0zM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    {{-- <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <h2 class="font-semibold text-slate-800 mb-1">Change license and remove references to
                                products</h2>
                        </div>
                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <!-- Left side -->
                            <div class="flex shrink-0 -space-x-3 -ml-px">
                                <a class="block" href="#0">
                                    <img class="rounded-full border-2 border-white box-content"
                                        src="./images/user-28-03.jpg" width="28" height="28" alt="User 03" />
                                </a>
                                <a class="block" href="#0">
                                    <img class="rounded-full border-2 border-white box-content"
                                        src="./images/user-28-10.jpg" width="28" height="28" alt="User 10" />
                                </a>
                            </div>
                            <!-- Right side -->
                            <div class="flex items-center">
                                <!-- Replies button -->
                                <button class="flex items-center text-slate-400 hover:text-indigo-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M8 0C3.6 0 0 3.1 0 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L8.9 12H8c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
                                    </svg>
                                    <div class="text-sm text-slate-500">4</div>
                                </button>
                                <!-- Attach button -->
                                <button class="text-slate-400 hover:text-indigo-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0zM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </header>
        </div>

        <!-- Column 2 -->
        <div class="col-span-full sm:col-span-6 xl:col-span-4">

            <!-- Column header -->
            <header>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="grow font-semibold text-slate-800 truncate">Detalles Adicionales ✌️</h2>
                    <button class="shrink-0 text-indigo-500 hover:text-indigo-600 ml-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                    </button>
                </div>

                <!-- Cards -->
                <div class="grid gap-2">

                    <!-- Card 1 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <h2 class="font-semibold text-slate-800 mb-1">Información</h2>
                        </div>
                        <!-- Meta -->
                        <div class="flex items-center justify-between">
                            <!-- Left side -->
                            <div class="flex shrink-0 -space-x-3 -ml-px">
                                <a class="block" href="javascript: void(0)">
                                    <img class="rounded-full border-2 border-white box-content"
                                        src="{{ asset('images/buses.png') }}" width="82" height="82" />
                                </a>
                            </div>
                            <!-- Right side -->
                            <div class="flex items-center">
                                <!-- To-do info -->
                                <div class="flex items-center text-slate-400 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M6.974 14c-.3 0-.7-.2-.9-.5l-2.2-3.7-2.1 2.8c-.3.4-1 .5-1.4.2-.4-.3-.5-1-.2-1.4l3-4c.2-.3.5-.4.9-.4.3 0 .6.2.8.5l2 3.3 3.3-8.1c0-.4.4-.7.8-.7s.8.2.9.6l4 8c.2.5 0 1.1-.4 1.3-.5.2-1.1 0-1.3-.4l-3-6-3.2 7.9c-.2.4-.6.6-1 .6z" />
                                    </svg>
                                    <div class="text-sm text-slate-500">1/3</div>
                                </div>
                                <!-- Attach button -->
                                <button class="text-slate-400 hover:text-indigo-500 ml-3">
                                    <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                        <path
                                            d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0zM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- List -->
                        <ul class="mt-3">
                            @foreach ($reporte->detalle()->get() as $detalle)
                                <li class="flex items-center border-t border-slate-200 py-2">
                                    <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2"
                                        viewBox="0 0 12 12">
                                        <path
                                            d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                    </svg>
                                    <div class="text-sm text-slate-400">{{ $detalle->detalle }}</div>

                                </li>
                                <!-- Footer -->
                                <div class="mb-3 flex items-center justify-between">
                                    <!-- Left side -->
                                    <div></div>
                                    <!-- Right side -->
                                    <div class="flex items-center">
                                        <!-- Date -->
                                        <div class="flex items-center text-amber-500 ml-3">
                                            <svg class="w-4 h-4 shrink-0 fill-current mr-1.5" viewBox="0 0 16 16">
                                                <path
                                                    d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                                            </svg>
                                            <div class="text-sm text-amber-600">
                                                {{ ucFirst($detalle->created_at->monthName) }}
                                                {{ $detalle->created_at->format('d, Y - h:m') }}</div>
                                        </div>
                                        <!-- delete button -->
                                        <button class="text-rose-400 hover:text-rose-500 ml-3">
                                            <svg class="w-4 h-4 shrink-0 fill-current mr-1.5"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                                <g stroke-linecap="square" stroke-width="3" stroke-miterlimit="10"
                                                    fill="none" stroke="currentColor" stroke-linejoin="miter"
                                                    class="nc-icon-wrapper" transform="translate(0.5 0.5)">
                                                    <path d="M22,13V3H42V13"></path>
                                                    <line x1="59" y1="13" x2="5"
                                                        y2="13"></line>
                                                    <path
                                                        d="M53,19,50.332,56.356A5,5,0,0,1,45.345,61H18.655a5,5,0,0,1-4.987-4.644L11,19">
                                                    </path>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach


                        </ul>

                        <!-- Footer -->
                        <div class="flex items-center justify-between">
                            <!-- Left side -->
                            <button wire:click="openModalShow({{ $reporte->id }})"
                                class="p-2 shrink-0 rounded-full bg-white border border-slate-200 hover:border-slate-300
                                text-indigo-500 transition duration-150">
                                <span class="sr-only">Añadir</span>
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 12 12">
                                    <path d="M11 5H7V1a1 1 0 00-2 0v4H1a1 1 0 000 2h4v4a1 1 0 002 0V7h4a1 1 0 000-2z" />
                                </svg>
                            </button>

                        </div>
                    </div>


                </div>
            </header>
        </div>


        <!-- Column 4 -->
        <div class="col-span-full sm:col-span-6 xl:col-span-4">

            <!-- Column header -->
            <header>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="grow font-semibold text-slate-800 truncate">Datos Vehiculos 🚍 </h2>
                    <button class="shrink-0 text-indigo-500 hover:text-indigo-600 ml-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                    </button>
                </div>

                <!-- Cards -->
                <div class="grid gap-2">

                    <!-- Card 1 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <div class="flex items-center mb-2">
                                <div class="flex shrink-0 -space-x-3 -ml-px mr-2">
                                    <a class="block" href="javascript: void(0)">
                                        <img class="rounded-full border-2 border-white box-content"
                                            src="{{ asset('images/camioneta.png') }}" width="64"
                                            height="64" />
                                    </a>
                                </div>
                                <div class="grow">
                                    <a class="inline-flex text-slate-800 hover:text-slate-900"
                                        href="javascript: void(0)">
                                        <h2 class="font-semibold text-slate-800">{{ $reporte->vehiculos->placa }}</h2>
                                    </a>
                                    <div class="text-xs font-medium text-slate-500">
                                        {{ $reporte->vehiculos->created_at->format('h:m a, d-m-Y') }}</div>
                                </div>
                            </div>
                            <!-- Content -->
                            <div>
                                <div class="text-sm">{{ $reporte->vehiculos->descripcion }}
                                    <a class="font-medium text-indigo-500 hover:text-indigo-600"
                                        href="javascript: void(0)">#{{ $reporte->vehiculos->tipo }}</a>
                                    🔥
                                </div>
                                <!-- Credit Card -->
                                <div
                                    class="flex flex-col col-span-full xl:col-span-4 bg-gradient-to-b from-slate-700 to-slate-800 shadow-lg rounded-sm border border-slate-800">
                                    <header class="px-5 py-4 border-b border-slate-600 flex items-center">
                                        <h2 class="font-semibold text-slate-200">TARJETA DE PROPIEDAD</h2>
                                    </header>
                                    <div class="h-full flex flex-col px-5 py-6">

                                        <div class="relative w-full max-w-sm mx-auto bg-slate-800 p-3 rounded-2xl">

                                            <div
                                                class="relative aspect-[7/4] bg-gradient-to-tr from-indigo-500 to-indigo-400 p-5 rounded-xl overflow-hidden">

                                                <div class="absolute left-0 -bottom-1/3 w-[398px] aspect-square"
                                                    aria-hidden="true">
                                                    <svg class="w-full h-full" width="398" height="392"
                                                        viewBox="0 0 398 392" xmlns="http://www.w3.org/2000/svg">
                                                        <defs>
                                                            <filter x="-88.2%" y="-88.2%" width="276.5%"
                                                                height="276.5%" filterUnits="objectBoundingBox"
                                                                id="glow-a">
                                                                <feGaussianBlur stdDeviation="50"
                                                                    in="SourceGraphic" />
                                                            </filter>
                                                        </defs>
                                                        <circle class="fill-indigo-100 opacity-60"
                                                            filter="url(#glow-a)" cx="85" cy="85"
                                                            r="85" transform="translate(0 216)" />
                                                    </svg>
                                                </div>
                                                <div class="absolute right-0 -top-1/3 w-[398px] aspect-square"
                                                    aria-hidden="true">
                                                    <svg class="w-full h-full" width="398" height="392"
                                                        viewBox="0 0 398 392" xmlns="http://www.w3.org/2000/svg">
                                                        <defs>
                                                            <filter x="-88.2%" y="-88.2%" width="276.5%"
                                                                height="276.5%" filterUnits="objectBoundingBox"
                                                                id="glow-b">
                                                                <feGaussianBlur stdDeviation="50"
                                                                    in="SourceGraphic" />
                                                            </filter>
                                                        </defs>
                                                        <circle class="fill-sky-400 opacity-60" filter="url(#glow-b)"
                                                            cx="85" cy="85" r="85"
                                                            transform="translate(228 0)" />
                                                    </svg>
                                                </div>
                                                <div class="relative h-full flex flex-col justify-between">

                                                    <svg width="32" height="32" viewBox="0 0 32 32"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                        <defs>
                                                            <linearGradient x1="50%" y1="0%"
                                                                x2="50%" y2="100%" id="icon1-b">
                                                                <stop stop-color="#A5B4FC" offset="0%" />
                                                                <stop stop-color="#E0E7FF" offset="100%" />
                                                            </linearGradient>
                                                            <linearGradient x1="50%" y1="24.537%"
                                                                x2="50%" y2="100%" id="icon1-c">
                                                                <stop stop-color="#4338CA" offset="0%" />
                                                                <stop stop-color="#6366F1" stop-opacity="0"
                                                                    offset="100%" />
                                                            </linearGradient>
                                                            <path id="icon1-a" d="M16 0l16 32-16-5-16 5z" />
                                                        </defs>
                                                        <g transform="rotate(90 16 16)" fill="none"
                                                            fill-rule="evenodd">
                                                            <mask id="icon1-d" fill="#fff">
                                                                <use xlink:href="#icon1-a" />
                                                            </mask>
                                                            <use fill="url(#icon1-b)" xlink:href="#icon1-a" />
                                                            <path fill="url(#icon1-c)" mask="url(#icon1-d)"
                                                                d="M16-6h20v38H16z" />
                                                        </g>
                                                    </svg>


                                                    <div
                                                        class="flex justify-between text-lg font-bold gap-8 text-slate-200 tracking-widest drop-shadow-sm">
                                                        <span class="text-xs">{{ $reporte->vehiculos->marca }}</span>
                                                        <span class="text-xs">{{ $reporte->vehiculos->modelo }}</span>
                                                        <span class="text-xs">{{ $reporte->vehiculos->tipo }}</span>
                                                    </div>

                                                    <div
                                                        class="relative flex gap-2 justify-between items-center z-10 mb-0.5">

                                                        <div
                                                            class="text-sm font-bold text-slate-200 tracking-widest drop-shadow-sm space-x-3">
                                                            <span>{{ $reporte->vehiculos->color }}</span>
                                                            |
                                                            <span>
                                                                {{ $reporte->vehiculos->dispositivos
                                                                    ? $reporte->vehiculos->dispositivos->modelo->modelo
                                                                    : 'SIN
                                                                                                                                                                                                                                                                GPS' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- Mastercard logo -->
                                                    <svg class="absolute bottom-0 right-0" width="48"
                                                        height="28" viewBox="0 0 48 28">
                                                        <circle fill="#F59E0B" cx="34" cy="14" r="14"
                                                            fill-opacity=".8" />
                                                        <circle fill="#F43F5E" cx="14" cy="14" r="14"
                                                            fill-opacity=".8" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-4">
                        <!-- Body -->
                        <div class="mb-3">
                            <!-- Title -->
                            <div class="flex items-center mb-2">
                                <div class="flex shrink-0 -space-x-3 -ml-px mr-2">
                                    <a class="block" href="javascript: void(0)">
                                        <img class="rounded-full border-2 border-white box-content"
                                            src="{{ asset('images/logo.png') }}" width="28" height="28"
                                            alt="User 12" />
                                    </a>
                                </div>
                                <div class="grow">
                                    <a class="inline-flex text-slate-800 hover:text-slate-900"
                                        href="javascript: void(0)">
                                        <h2 class="font-semibold text-slate-800">
                                            {{ $reporte->vehiculos->cliente ? $reporte->vehiculos->cliente->razon_social : 'REGISTRAR CLIENTE' }}
                                        </h2>
                                    </a>
                                    <div class="text-xs font-medium text-slate-500">
                                        {{ $reporte->vehiculos->cliente->created_at->format('h:m a, d-m-Y') }}</div>
                                </div>
                            </div>
                            <!-- Content -->
                            @can('editar-cliente')
                                <div>
                                    <div class="text-sm">
                                        {{ $reporte->vehiculos->cliente ? $reporte->vehiculos->cliente->direccion : '' }}
                                    </div>
                                </div>
                            @endcan

                        </div>

                    </div>

                </div>
            </header>
        </div>

    </div>

</div>
