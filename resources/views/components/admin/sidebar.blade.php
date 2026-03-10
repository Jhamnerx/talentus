<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-dvh overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:w-64! 2xl:w-64! shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-xs' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">

        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('admin.home') }}">

                <img width="56" height="56" src="{{ asset('images/logo.png') }}" alt="">

            </a>
        </div>

        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Módulos</span>
                </h3>
                <ul class="mt-3">
                    <!-- Dashboard -->
                    @role('admin')
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(1), ['dashboard'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['dashboard']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['dashboard'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['dashboard'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 64 64">
                                            <g fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                                                <line data-color="color-2" x1="9" y1="39" x2="13"
                                                    y2="39" fill="none" stroke-linecap="square"
                                                    stroke-miterlimit="10"></line>
                                                <line data-color="color-2" x1="32" y1="16" x2="32"
                                                    y2="20" fill="none" stroke-linecap="square"
                                                    stroke-miterlimit="10"></line>
                                                <line data-color="color-2" x1="48.263" y1="22.737" x2="45.435"
                                                    y2="25.565" fill="none" stroke-linecap="square"
                                                    stroke-miterlimit="10"></line>
                                                <line data-color="color-2" x1="55" y1="39" x2="51"
                                                    y2="39" fill="none" stroke-linecap="square"
                                                    stroke-miterlimit="10"></line>
                                                <line data-color="color-2" x1="28.464" y1="35.464" x2="16"
                                                    y2="23" fill="none" stroke-linecap="square"
                                                    stroke-miterlimit="10"></line>
                                                <circle data-color="color-2" cx="31.999" cy="39" r="5"
                                                    fill="none" stroke-linecap="square" stroke-miterlimit="10"></circle>
                                                <path d="M57.372,55A30,30,0,1,0,6.628,55Z" fill="none"
                                                    stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10">
                                                </path>
                                            </g>
                                        </svg>

                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Tablero Informativo
                                        </span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.home')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.home') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Información</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endrole

                    <!-- Almacen -->
                    @canany(['ver-categoria', 'ver-producto', 'ver-sim_card', 'ver-dispositivo', 'ver-guias'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['categorias', 'productos', 'sim-card', 'lineas', 'dispositivos', 'guias'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['categorias', 'productos','servicios' ,'sim-card', 'lineas', 'dispositivos', 'guias', 'modelos']) ? 1 : 0 }} }">


                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), [''])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">

                                        <svg class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['categorias', 'productos', 'servicios', 'sim-card', 'lineas', 'dispositivos', 'guias', 'modelos'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 64 64">
                                            <g fill="currentColor" class="nc-icon-wrapper">
                                                <path
                                                    d="M33,47.645V60.71c.024-.014.05-.018.073-.033l11-7A2,2,0,0,0,45,51.992V40.012Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M31,47.645,19,40.011V51.992a2,2,0,0,0,.927,1.688l11,7c.023.015.049.019.073.033Z"
                                                    fill="currentColor"></path>
                                                <path d="M32,21.693l12-7.634L33.076,7.086a2,2,0,0,0-2.152,0L20,14.059Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M12,35.556,0,27.922V39.9A2,2,0,0,0,.927,41.59l11,7c.023.014.049.019.073.033Z"
                                                    data-color="color-2"></path>
                                                <path
                                                    d="M52,35.556l12-7.634V39.9a2,2,0,0,1-.927,1.687l-11,7c-.023.014-.049.019-.073.033Z"
                                                    data-color="color-2"></path>
                                                <path
                                                    d="M47,38.914a2,2,0,0,0-.924-1.686L38,32.074V27.922l12,7.634V48.621c-.024-.014-.05-.019-.073-.033L47,46.726Z"
                                                    data-color="color-2"></path>
                                                <path d="M13,33.821l12-7.634L14.076,19.214a2,2,0,0,0-2.152,0L1,26.187Z"
                                                    data-color="color-2"></path>
                                                <path
                                                    d="M17,38.914a2,2,0,0,1,.924-1.686L26,32.074V27.922L14,35.556V48.621c.024-.014.05-.019.073-.033L17,46.726Z"
                                                    data-color="color-2"></path>
                                                <path d="M32,45.91l12-7.634L33.076,31.3a2,2,0,0,0-2.152,0L20,38.276Z"
                                                    fill="currentColor"></path>
                                                <path d="M14.076,19.214a2,2,0,0,0-2.152,0L1,26.187l12,7.634,12-7.634Z"
                                                    data-color="color-2"></path>
                                                <path d="M49.924,19.214a2,2,0,0,1,2.152,0L63,26.187,51,33.821,39,26.187Z"
                                                    data-color="color-2"></path>
                                                <path
                                                    d="M26,27.922,14,35.556V48.621c.024-.014.05-.019.073-.033L17,46.726V38.914a2,2,0,0,1,.924-1.686L26,32.074Z"
                                                    data-color="color-2"></path>
                                                <path
                                                    d="M27.076,25.138A2,2,0,0,1,28,26.824V30.8l1.848-1.179A4,4,0,0,1,31,29.123V23.428L19,15.794v4.19Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M36.924,25.138A2,2,0,0,0,36,26.824V30.8l-1.848-1.179A4,4,0,0,0,33,29.123V23.428l12-7.634v4.19Z"
                                                    fill="currentColor"></path>
                                                <path d="M33.076,31.3a2,2,0,0,0-2.152,0L20,38.276,32,45.91l12-7.634Z"
                                                    fill="currentColor"></path>
                                            </g>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Almacen</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>

                                    @can('ver-categoria')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.almacen.categorias.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.almacen.categorias.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Categorias</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('ver-producto')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.almacen.productos.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.almacen.productos.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Productos</span>
                                            </a>
                                        </li>
                                        
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.almacen.servicios.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.almacen.servicios.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Servicios</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('ver-sim_card')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.almacen.sim-card.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.almacen.sim-card.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sim
                                                    Cards</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ver-sim_card')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.almacen.lineas.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.almacen.lineas.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Lineas</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ver-dispositivo')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.almacen.dispositivos.index', 'admin.almacen.modelos-dispositivos')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.almacen.dispositivos.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dispositivos</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ver-guias')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.almacen.guias.index', 'admin.almacen.guias.create', 'admin.almacen.guias.edit')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.almacen.guias.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Guias
                                                    Remisión
                                                </span>
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        </li>
                    @endcanany

                    @if (auth()->user()->can('*-categoria'))
                    @endif

                    <!-- Clientes -->
                    @canany(['ver-cliente', 'ver-contacto'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['clientes', 'contactos'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['clientes', 'contactos']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (in_array(Request::segment(1), ['clientes', 'contactos'])) text-violet-500! @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['clientes', 'contactos'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 64 64">
                                            <g fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                                                <path
                                                    d="M38,39H26A18,18,0,0,0,8,57H8s9,4,24,4,24-4,24-4h0A18,18,0,0,0,38,39Z"
                                                    fill="none" stroke="currentColor" stroke-linecap="square"
                                                    stroke-miterlimit="10" stroke-width="2"></path>
                                                <path data-color="color-2"
                                                    d="M19,17.067a13,13,0,1,1,26,0C45,24.283,39.18,32,32,32S19,24.283,19,17.067Z"
                                                    fill="none" stroke-linecap="square" stroke-miterlimit="10"
                                                    stroke-width="2"></path>
                                            </g>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Clientes</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    @can('ver-cliente')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.clientes.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.clientes.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Clientes
                                                </span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('ver-contacto')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.clientes.contactos.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.clientes.contactos.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Contactos
                                                </span>
                                            </a>
                                        </li>
                                    @endcan

                                    <!-- Mensajes de Contacto Web -->
                                    {{-- <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.contactos.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.contactos.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Mensajes Web
                                            </span>
                                        </a>
                                    </li> --}}

                                </ul>

                            </div>
                        </li>
                    @endcanany


                    <!-- Tickets -->
                    @can('ver-ticket')
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['tickets'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['tickets']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (in_array(Request::segment(1), ['tickets'])) text-violet-500! @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['tickets'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <g class="nc-icon-wrapper">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </g>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tickets</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.tickets.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.tickets.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Listado de Tickets
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan


                    <!-- Finanzas -->
                    {{-- TODO: implementar permisos de finanzas --}}
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['finanzas', 'pagos', 'cobros', 'planes', 'cobros-notificaciones'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['finanzas', 'pagos', 'cobros', 'planes', 'cobros-notificaciones']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), [''])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['finanzas', 'pagos', 'cobros', 'planes', 'cobros-notificaciones'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <rect x="2" y="4" width="20" height="16" rx="2" stroke-width="2"/>
                                            <line x1="2" y1="9" x2="22" y2="9" stroke-width="2"/>
                                            <line x1="7" y1="14" x2="13" y2="14" stroke-width="2"/>
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Finanzas</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('finanzas.caja-chica.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('finanzas.caja-chica.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Caja chica
                                            </span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('finanzas.movimientos.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('finanzas.movimientos.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Movimientos
                                            </span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('finanzas.transacciones.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('finanzas.transacciones.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Transacciones
                                            </span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('finanzas.cuentas-cobrar.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('finanzas.cuentas-cobrar.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cuentas por cobrar
                                            </span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('finanzas.cuentas-pagar.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('finanzas.cuentas-pagar.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cuentas por pagar
                                            </span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.payments.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.payments.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Pagos
                                            </span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('finanzas.balance.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('finanzas.balance.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Balance
                                            </span>
                                        </a>
                                    </li>

                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.cobros.index', 'admin.cobros.create', 'admin.cobros.edit')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.cobros.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cobros
                                            </span>
                                        </a>
                                    </li>

                                    {{-- Notificaciones de Cobro con Badge --}}
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.cobros.notificaciones')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.cobros.notificaciones') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 flex items-center gap-2">
                                                🔔 Notificaciones
                                                @php
                                                    $pendientesCount = \App\Models\NotificacionCobro::pendientes()->count();
                                                @endphp
                                                @if($pendientesCount > 0)
                                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                                        {{ $pendientesCount }}
                                                    </span>
                                                @endif
                                            </span>
                                        </a>
                                    </li>

                                    {{-- Planes de Servicio --}}
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.planes.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.planes.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">💳 Planes
                                            </span>
                                        </a>
                                    </li>

                                </ul>

                            </div>
                        </li>


                    <!-- Proveedores -->
                    @can('ver-proveedor')
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['proovedores'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif">
                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.proveedores.index')) {{ 'text-violet-500!' }} @endif"
                                href="{{ route('admin.proveedores.index') }}">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6 @if (Route::is('admin.proveedores.index')) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                        <g fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                                            <path d="M38,39H26A18,18,0,0,0,8,57H8s9,4,24,4,24-4,24-4h0A18,18,0,0,0,38,39Z"
                                                fill="none" stroke="currentColor" stroke-linecap="square"
                                                stroke-miterlimit="10" stroke-width="2"></path>
                                            <path data-color="color-2"
                                                d="M19,17.067a13,13,0,1,1,26,0C45,24.283,39.18,32,32,32S19,24.283,19,17.067Z"
                                                fill="none" stroke-linecap="square" stroke-miterlimit="10"
                                                stroke-width="2">
                                            </path>
                                        </g>
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Proveedores</span>
                                </div>
                            </a>
                        </li>
                    @endcan

                    <!-- Compras -->
                    @canany(['ver-compras_facturas', 'crear-compras_facturas'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['compras'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['compras']) ? 1 : 0 }} }">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['dashboard'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['compras'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" viewBox="0 0 1024 1024"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor"
                                                d="M256 640v192h640V384H768v-64h150.976c14.272 0 19.456 1.472 24.64 4.288a29.056 29.056 0 0 1 12.16 12.096c2.752 5.184 4.224 10.368 4.224 24.64v493.952c0 14.272-1.472 19.456-4.288 24.64a29.056 29.056 0 0 1-12.096 12.16c-5.184 2.752-10.368 4.224-24.64 4.224H233.024c-14.272 0-19.456-1.472-24.64-4.288a29.056 29.056 0 0 1-12.16-12.096c-2.688-5.184-4.224-10.368-4.224-24.576V640h64z" />
                                            <path fill="currentColor"
                                                d="M768 192H128v448h640V192zm64-22.976v493.952c0 14.272-1.472 19.456-4.288 24.64a29.056 29.056 0 0 1-12.096 12.16c-5.184 2.752-10.368 4.224-24.64 4.224H105.024c-14.272 0-19.456-1.472-24.64-4.288a29.056 29.056 0 0 1-12.16-12.096C65.536 682.432 64 677.248 64 663.04V169.024c0-14.272 1.472-19.456 4.288-24.64a29.056 29.056 0 0 1 12.096-12.16C85.568 129.536 90.752 128 104.96 128h685.952c14.272 0 19.456 1.472 24.64 4.288a29.056 29.056 0 0 1 12.16 12.096c2.752 5.184 4.224 10.368 4.224 24.64z" />
                                            <path fill="currentColor"
                                                d="M448 576a160 160 0 1 1 0-320 160 160 0 0 1 0 320zm0-64a96 96 0 1 0 0-192 96 96 0 0 0 0 192z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Compras</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.compras.index')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.compras.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Listado
                                            </span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.compras.create')) {{ 'text-violet-500!' }} @endif"
                                            href="{{ route('admin.compras.create') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Registrar compra
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcanany

                    <!-- Comprobantes -->
                    @canany(['ver-comprobantes', 'comprobantes-emitir-factura', 'comprobantes-emitir-boleta',
                        'comprobantes-emitir-nota-venta', 'comprobantes-emitir-nota-debito',
                        'comprobantes-emitir-nota-credito', 'ver-cotizaciones'])

                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['emitir', 'ventas', 'presupuestos', 'recibos'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['emitir', 'ventas', 'presupuestos', 'recibos', 'notas']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), ['dashboard'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">

                                        <svg class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['emitir', 'ventas', 'presupuestos', 'recibos', 'notas'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" fill="currentColor" width="800px" height="800px"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15,8a1,1,0,0,1-1,1H6A1,1,0,0,1,6,7h8A1,1,0,0,1,15,8Zm-1,3H6a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Zm-4,4H6a1,1,0,0,0,0,2h4a1,1,0,0,0,0-2Zm13-3v8a3,3,0,0,1-3,3H4a3,3,0,0,1-3-3V4A3,3,0,0,1,4,1H16a3,3,0,0,1,3,3v7h3A1,1,0,0,1,23,12ZM17,4a1,1,0,0,0-1-1H4A1,1,0,0,0,3,4V20a1,1,0,0,0,1,1H17Zm4,9H19v8h1a1,1,0,0,0,1-1Z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Comprobantes
                                        </span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400 @if (in_array(Request::segment(1), ['comprobantes'])) {{ 'rotate-180' }} @endif"
                                            :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>

                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1 @if (!in_array(Request::segment(1), ['emitir', 'ventas', 'presupuestos', 'recibos', 'notas'])) {{ 'hidden' }} @endif"
                                    :class="open ? 'block!' : 'hidden'">

                                    @can('ver-cotizaciones')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.ventas.presupuestos.index', 'admin.ventas.presupuestos.create', 'admin.ventas.presupuestos.edit')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.ventas.presupuestos.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cotizaciones
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ver-comprobantes')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.ventas.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.ventas.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Administrar Ventas
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('comprobantes-emitir-factura')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.factura.create')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.factura.create') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Emitir Factura
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('comprobantes-emitir-boleta')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.boleta.create')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.boleta.create') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Emitir Boleta
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('comprobantes-emitir-nota-venta')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.nota.venta.create')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.nota.venta.create') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Emitir Nota de venta
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('comprobantes-emitir-nota-credito')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.nota.credito.create')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.nota.credito.create') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Emitir nota de credito
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('comprobantes-emitir-nota-debito')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.nota.debito.create')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.nota.debito.create') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Emitir nota de debito
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @canany(['comprobantes-emitir-nota-debito', 'comprobantes-emitir-nota-credito'])
                                        <li class="mb-1 last:mb-0">
                                            <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.nota.index')) {{ 'text-violet-500!' }} @endif"
                                                href="{{ route('admin.nota.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Ver notas de debito/credito
                                                </span>
                                            </a>
                                        </li>
                                    @endcanany
                                    @can('ver-recibos')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                            text-gray-800 dark:text-gray-100
                                            hover:text-gray-900 dark:hover:text-white
                                            @if (Route::is('admin.ventas.recibos.index', 'admin.ventas.recibos.create', 'admin.ventas.recibos.edit')) {{ 'text-violet-500!' }} @endif
                                            transition truncate"
                                                href="{{ route('admin.ventas.recibos.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Recibos</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany
                    <!-- VENTAS -->
                    {{-- @canany(['ver-cotizaciones', 'ver-ventas-facturas', 'ver-recibos', 'ver-contrato'])
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0" :class="{
                                'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4': page
                                    .startsWith('ventas-')
                            }" x-data="{ open: false }" x-init="$nextTick(() => open = page.startsWith('ventas-'))">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), [''])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            :class="page.startsWith('ventas-') &&
                                    'hover:text-gray-900 dark:hover:text-white'"
                            href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['ventas'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif icon icon-tabler icon-tabler-businessplan"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <ellipse cx="16" cy="6" rx="5" ry="3" />
                                        <path :class="page.startsWith('ventas-') && 'text-indigo-300'"
                                            d="M11 6v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                                        <path :class="page.startsWith('ventas-') && 'text-indigo-300'"
                                            d="M11 10v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                                        <path :class="page.startsWith('ventas-') && 'text-indigo-300'"
                                            d="M11 14v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                                        <path :class="page.startsWith('ventas-') && 'text-indigo-300'"
                                            d="M7 9h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                        <path :class="page.startsWith('ventas-') && 'text-indigo-300'"
                                            d="M5 15v1m0 -8v1" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Ventas</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">

                            <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>

                                @can('ver-ventas-facturas')
                                <li class="mb-1 last:mb-0">
                                    <a block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.ventas.presupuestos.index')) {{ 'text-violet-500!' }} @endif transition truncate
                                        :class="page === 'ventas-facturas' &&
                                                    'text-violet-500!'"
                                        href="{{ route('admin.ventas.facturas.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Facturas
                                        </span>
                                    </a>
                                </li>
                                @endcan



                                @can('ver-contrato')
                                <li class="mb-1 last:mb-0">
                                    <a block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate  @if (Route::is('admin.ventas.presupuestos.index')) {{ 'text-violet-500!' }} @endif transition truncate
                                        :class="page === 'ventas-contratos' &&
                                                    'text-violet-500!'"
                                        href="{{ route('admin.ventas.contratos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Contratos</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    @endcanany --}}

                    @can('ver-contrato')
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['contratos'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['contratos']) ? 1 : 0 }} }">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (Route::is('admin.ventas.contratos.index')) {{ 'text-violet-500!' }} @endif"
                                href="{{ route('admin.ventas.contratos.index') }}">
                                <div class="flex items-center">

                                    <svg class="shrink-0 h-6 w-6 @if (Route::is('admin.ventas.contratos.index')) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                        <g fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                                            <path d="M7,45a4,4,0,0,1-4-4V25H6" fill="none" stroke="currentColor"
                                                stroke-linecap="square" stroke-miterlimit="10"></path>
                                            <path d="M11,3V41a4,4,0,0,1-4,4H41a4,4,0,0,0,4-4V3Z" fill="none"
                                                stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10">
                                            </path>
                                            <line data-color="color-2" x1="18" y1="27" x2="38"
                                                y2="27" fill="none" stroke-linecap="square"
                                                stroke-miterlimit="10"></line>
                                            <line data-color="color-2" x1="18" y1="35" x2="38"
                                                y2="35" fill="none" stroke-linecap="square"
                                                stroke-miterlimit="10"></line>
                                            <rect data-color="color-2" x="18" y="11" width="20" height="8"
                                                fill="none" stroke-linecap="square" stroke-miterlimit="10"></rect>
                                        </g>
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Contratos</span>
                                </div>
                            </a>
                        </li>
                    @endcan

                    <!-- Vehiculos -->
                    @canany(['ver-vehiculos-flotas', 'ver-vehiculos-vehiculos', 'ver-vehiculos-reportes',
                        'ver-mantenimientos-vehiculos'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['flotas', 'vehiculos', 'mantenimiento', 'reportes'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['flotas', 'vehiculos', 'mantenimiento', 'reportes']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition
                                @if (in_array(Request::segment(1), ['flotas', 'vehiculos', 'mantenimiento', 'reportes'])) hover:text-gray-900 dark:hover:text-white @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['flotas', 'vehiculos', 'mantenimiento', 'reportes'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif icon icon-tabler icon-tabler-car" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <circle cx="7" cy="17" r="2" />
                                            <circle cx="17" cy="17" r="2" />
                                            <path
                                                d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Vehiculos</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    @can('ver-vehiculos-flotas')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.vehiculos.flotas.index')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.vehiculos.flotas.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Flotas
                                                </span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('ver-vehiculos-vehiculos')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.vehiculos.index')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.vehiculos.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Vehiculos</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ver-mantenimientos-vehiculos')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                            text-gray-800 dark:text-gray-100
                                            hover:text-gray-900 dark:hover:text-white
                                            @if (Route::is('admin.vehiculos.mantenimiento.index')) {{ 'text-violet-500!' }} @endif
                                            transition truncate"
                                                href="{{ route('admin.vehiculos.mantenimiento.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Mantenimientos
                                                    Programados
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ver-vehiculos-reportes')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.vehiculos.reportes.index', 'admin.vehiculos.reportes.show')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.vehiculos.reportes.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reportes
                                                </span>
                                            </a>
                                        </li>
                                    @endcan


                                </ul>
                            </div>
                        </li>
                    @endcanany

                    <!-- Certificados -->
                    @canany(['ver-certificados-actas', 'ver-certificados-gps', 'ver-certificados-velocimetros',
                        'ver-certificados-antifatiga'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), [
                                'actas',
                                'certificados-gps',
                                'certificados-velocimetros',
                                'certificados-antifatiga',
                            ])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['actas', 'certificados-gps', 'certificados-velocimetros', 'certificados-antifatiga']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), [''])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="shrink-0 h-6 w-6 @if (in_array(Request::segment(1), ['actas', 'certificados-gps', 'certificados-velocimetros', 'certificados-antifatiga'])) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif icon icon-tabler icon-tabler-certificate"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <circle cx="15" cy="15" r="3" />
                                            <path d="M13 17.5v4.5l2 -1.5l2 1.5v-4.5" />
                                            <path
                                                d="M10 19h-5a2 2 0 0 1 -2 -2v-10c0 -1.1 .9 -2 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -1 1.73" />
                                            <line x1="6" y1="9" x2="18" y2="9" />
                                            <line x1="6" y1="12" x2="9" y2="12" />
                                            <line x1="6" y1="15" x2="8" y2="15" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Certificados</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">

                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    @can('ver-certificados-actas')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.certificados.actas.index')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.certificados.actas.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Actas</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('ver-certificados-gps')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.certificados.gps.index')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.certificados.gps.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Certificados
                                                    Gps</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('ver-certificados-velocimetros')
                                        <li class="mb-1 last:mb-0">
                                            <a class=" block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.certificados.velocimetros.index')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.certificados.velocimetros.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Certificados
                                                    Velocimetros</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('ver-certificados-antifatiga')
                                        <li class="mb-1 last:mb-0">
                                            <a class=" block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.certificados.antifatiga.index')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.certificados.antifatiga.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Certificados
                                                    Antifatiga</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany

                    <!-- Órdenes de Trabajo -->
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['work-orders'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif">
                        <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.work-orders.index', 'admin.work-orders.show', 'admin.work-orders.checklist')) {{ 'text-violet-500!' }} @endif"
                            href="{{ route('admin.work-orders.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6 @if (Route::is('admin.work-orders.index', 'admin.work-orders.show', 'admin.work-orders.checklist')) {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" 
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    Órdenes de Trabajo
                                </span>
                            </div>
                        </a>
                    </li>

                    <!-- administracion -->
                    @canany(['admin.solicitudes.index', 'admin.reportes.index', 'admin.usuarios.index',
                        'admin.payments.index', 'admin.settings.ciudades.index',
                        'admin.settings.roles.index', 'admin.settings.plantilla.index'])
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), [
                                'solicitudes',
                                'reviews',
                                'gerencia',
                                'usuarios',
                                'payments',
                                'recibos-pagos',
                                'ajustes',
                            ])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), [
                                'solicitudes',
                                'reviews',
                                'gerencia',
                                'usuarios',
                                'payments',
                                'recibos-pagos',
                                'ajustes',
                            ])
                                ? 1
                                : 0 }} }">


                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), [''])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <x-admin.iconos.admin :active="in_array(Request::segment(1), ['solicitudes', 'reviews', 'gerencia', 'usuarios', 'recibos-pagos', 'ajustes'])">
                                        </x-admin.iconos.admin>

                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Administracion</span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    @can('admin.solicitudes.index')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.solicitudes.index')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.solicitudes.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Solicitudes
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @role('admin')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                            text-gray-800 dark:text-gray-100
                                            hover:text-gray-900 dark:hover:text-white
                                            @if (Route::is('admin.reviews.index')) {{ 'text-violet-500!' }} @endif
                                            transition truncate"
                                                href="{{ route('admin.reviews.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Review Clientes
                                                </span>
                                            </a>
                                        </li>
                                    @endrole
                                    @can('admin.reportes.index')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.gerencia.reportes')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.gerencia.reportes') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Reportes Gerenciales
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.usuarios.index')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.users.index', 'admin.users.create', 'admin.users.edit')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.users.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Usuarios
                                                </span>
                                            </a>
                                        </li>
                                    @endcan

                                    {{-- @can('admin.payments.index')
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is('admin.payments.index')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.payments.index') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                    Pagos</span>
                                            </a>
                                        </li>
                                    @endcan --}}

                                    {{-- añadir permiso --}}
                                    <li class="mb-1 last:mb-0">
                                        <a class="block
                                            text-gray-800 dark:text-gray-100
                                            hover:text-gray-900 dark:hover:text-white
                                            @if (Route::is('admin.gerencia.recibos.index', 'admin.gerencia.recibos.create', 'admin.gerencia.recibos.edit')) {{ 'text-violet-500!' }} @endif
                                            transition truncate"
                                            href="{{ route('admin.gerencia.recibos.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Recibos Egresos</span>
                                        </a>
                                    </li>

                                    @canany(['admin.settings.ciudades.index', 'admin.settings.roles.index',
                                        'admin.settings.plantilla.index'])
                                        <li class="mb-1 last:mb-0">
                                            <a class="block
                                                text-gray-800 dark:text-gray-100
                                                hover:text-gray-900 dark:hover:text-white
                                                @if (Route::is(
                                                        'admin.ajustes.cuenta',
                                                        'admin.ajustes.notificaciones',
                                                        'admin.ajustes.roles',
                                                        'admin.ajustes.roles.store',
                                                        'admin.ajustes.series',
                                                        'admin.ajustes.plantilla',
                                                        'admin.ajustes.ciudades',
                                                        'admin.ajustes.sunat')) {{ 'text-violet-500!' }} @endif
                                                transition truncate"
                                                href="{{ route('admin.ajustes.cuenta') }}">
                                                <span
                                                    class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Ajustes
                                                    Empresa</span>
                                            </a>
                                        </li>
                                    @endcanany

                                </ul>
                            </div>
                        </li>
                    @endcanany

                    <!-- Marketing -->
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['mensajes-contacto'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                        x-data="{ open: {{ in_array(Request::segment(1), ['mensajes-contacto']) ? 1 : 0 }} }">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), [''])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6 @if (Request::segment(1) == 'mensajes-contacto') {{ 'text-violet-500' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none">
                                        <path class="fill-current" d="M21 8V20.993C20.9982 21.5519 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.556 3 21.008V2.992C3 2.455 3.44495 2 3.9934 2H14V8ZM21 6H16V1L21 6ZM8 7V9H11V7H8ZM8 11V13H16V11H8ZM8 15V17H16V15H8Z"/>
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Marketing</span>
                                </div>
                                <div class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate @if (Route::is('admin.contactos.index')) {{ 'text-violet-500!' }} @endif"
                                        href="{{ route('admin.contactos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Mensajes de Contacto
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- More group -->
            @canany(['tecnico.tareas.reportes', 'tecnico.tareas.index', 'tecnico.tareas.cards',
                'tecnico.tareas.cards.sin-leer.actions', 'tecnico.tareas.cards.complete.actions',
                'tecnico.tareas.cards.pendient.actions', 'tecnico.tareas.cards.canceled.actions',
                'tecnico.tareas.tecnicos.admin', 'tecnico.tareas.tabla-historial', 'tecnico.tareas.create',
                'tecnico.tareas.edit', 'tecnico.tareas.delete', 'tecnico.tareas.action.pdf', 'tecnico.tareas.action.wsp',
                'tecnico.tareas.tipo.index', 'tecnico.tareas.tipo.create', 'tecnico.tareas.tipo.edit',
                'tecnico.tareas.tipo.delete'])
                <div>
                    <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                        <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                            aria-hidden="true">•••</span>
                        <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Area Servicio Tecnico</span>
                    </h3>
                    <ul class="mt-3">
                        <!-- tecnico -->
                        <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 @if (in_array(Request::segment(1), ['tecnico'])) {{ 'from-violet-500/12 dark:from-violet-500/24 to-violet-500/4' }} @endif"
                            x-data="{ open: {{ in_array(Request::segment(1), ['tecnico']) ? 1 : 0 }} }">

                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(1), [''])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#0" @click.prevent="open = !open; sidebarExpanded = true">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">

                                        <x-admin.iconos.task :active="in_array(Request::segment(1), ['tecnico'])">
                                        </x-admin.iconos.task>

                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Tareas
                                        </span>
                                    </div>
                                    <!-- Icon -->
                                    <div
                                        class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500"
                                            :class="{ 'transform rotate-180': open }" viewBox="0 0 12 12">
                                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                                <ul class="pl-8 mt-1" :class="open ? 'block!' : 'hidden'" x-cloak>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block
                                            text-gray-800 dark:text-gray-100
                                            hover:text-gray-900 dark:hover:text-white
                                            @if (Route::is('admin.tecnico.tareas.index')) {{ 'text-violet-500!' }} @endif
                                            transition truncate"
                                            href="{{ route('admin.tecnico.tareas.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Modulo Tareas
                                            </span>
                                        </a>
                                    </li>
                                    <li class="mb-1 last:mb-0">
                                        <a class="block
                                            text-gray-800 dark:text-gray-100
                                            hover:text-gray-900 dark:hover:text-white
                                            @if (Route::is('admin.tecnico.tecnico.index')) {{ 'text-violet-500!' }} @endif
                                            transition truncate"
                                            href="{{ route('admin.tecnico.tecnico.index') }}">
                                            <span
                                                class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                                Administrar Tecnicos
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            @endcanany
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="px-3 py-2">
                <button @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
                        <path class="text-gray-800 dark:text-gray-100"
                            d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-sky-900" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
