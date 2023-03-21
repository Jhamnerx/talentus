<div>
    <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <div id="sidebar"
        class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 transform h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-slate-800 p-4 transition-all duration-200 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false" x-cloak="lg">

        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
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
                <h3 class="text-xs uppercase text-slate-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Modulos</span>
                </h3>
                <ul class="mt-3">
                    <!-- Dashboard -->
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('dashboard-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('dashboard-'))">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page.startsWith('dashboard-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-400"
                                            :class="page.startsWith('dashboard-') && '!text-indigo-500'"
                                            d="M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0z" />
                                        <path class="fill-current text-slate-600"
                                            :class="page.startsWith('dashboard-') && 'text-indigo-600'"
                                            d="M12 3c-4.963 0-9 4.037-9 9s4.037 9 9 9 9-4.037 9-9-4.037-9-9-9z" />
                                        <path class="fill-current text-slate-400"
                                            :class="page.startsWith('dashboard-') && 'text-indigo-200'"
                                            d="M12 15c-1.654 0-3-1.346-3-3 0-.462.113-.894.3-1.285L6 6l4.714 3.301A2.973 2.973 0 0112 9c1.654 0 3 1.346 3 3s-1.346 3-3 3z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Tablero
                                        Informativo</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="!open && 'hidden'" x-cloak>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'dashboard-inicio' && '!text-indigo-500'"
                                        href="{{ route('admin.home') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Información</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Almacen -->
                    @canany(['ver-categoria', 'ver-producto', 'ver-sim_card', 'ver-dispositivo', 'ver-guias'])
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('almacen-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('almacen-'))">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page.startsWith('almacen-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-400"
                                            :class="page.startsWith('almacen-') && 'text-indigo-300'"
                                            d="M13 15l11-7L11.504.136a1 1 0 00-1.019.007L0 7l13 8z" />
                                        <path class="fill-current text-slate-700"
                                            :class="page.startsWith('almacen-') && '!text-indigo-600'"
                                            d="M13 15L0 7v9c0 .355.189.685.496.864L13 24v-9z" />
                                        <path class="fill-current text-slate-600"
                                            :class="page.startsWith('almacen-') && 'text-indigo-500'"
                                            d="M13 15.047V24l10.573-7.181A.999.999 0 0024 16V8l-11 7.047z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Almacen</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="!open && 'hidden'" x-cloak>

                                @can('ver-categoria')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'almacen-categorias' && '!text-indigo-500'"
                                        href="{{ route('admin.almacen.categorias.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Categorias</span>
                                    </a>
                                </li>
                                @endcan

                                @can('ver-producto')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'almacen-productos' && '!text-indigo-500'"
                                        href="{{ route('admin.almacen.productos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Productos/Servicios</span>
                                    </a>
                                </li>
                                @endcan

                                @can('ver-sim_card')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'almacen-sim-card' && '!text-indigo-500'"
                                        href="{{ route('admin.almacen.sim-card.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Sim
                                            Cards</span>
                                    </a>
                                </li>
                                @endcan
                                @can('ver-sim_card')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'almacen-lineas' && '!text-indigo-500'"
                                        href="{{ route('admin.almacen.lineas.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Lineas</span>
                                    </a>
                                </li>
                                @endcan
                                @can('ver-dispositivo')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'almacen-dispositivos' && '!text-indigo-500'"
                                        href="{{ route('admin.almacen.dispositivos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dispositivos</span>
                                    </a>
                                </li>
                                @endcan
                                @can('ver-guias')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'almacen-guias' && '!text-indigo-500'"
                                        href="{{ route('admin.almacen.guias.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Guias
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
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('clientes-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('clientes-'))">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page.startsWith('clientes-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-600"
                                            :class="page.startsWith('clientes') && 'text-indigo-500'"
                                            d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                        <path class="fill-current text-slate-400"
                                            :class="page.startsWith('clientes') && 'text-indigo-300'"
                                            d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Clientes</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul href="{{ route('admin.clientes.index') }}" class="pl-9 mt-1" :class="!open && 'hidden'"
                                x-cloak>
                                @can('ver-cliente')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'clientes-clientes' && '!text-indigo-500'"
                                        href="{{ route('admin.clientes.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Clientes
                                        </span>
                                    </a>
                                </li>
                                @endcan

                                @can('ver-contacto')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'clientes-contactos' && '!text-indigo-500'"
                                        href="{{ route('admin.clientes.contactos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Contactos
                                        </span>
                                    </a>
                                </li>
                                @endcan

                            </ul>

                        </div>
                    </li>
                    @endcanany


                    <!-- Proveedores -->
                    @can('ver-proveedor')
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0" :class="page === 'proveedores' && 'bg-slate-900'">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page === 'proveedores' && 'hover:text-slate-200'"
                            href="{{ route('admin.proveedores.index') }}">
                            <div class="flex items-center">
                                <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                    <path class="fill-current text-slate-600"
                                        :class="page.startsWith('proveedores-') && 'text-indigo-500'"
                                        d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                    <path class="fill-current text-slate-400"
                                        :class="page.startsWith('proveedores-') && 'text-indigo-300'"
                                        d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                                </svg>
                                <span
                                    class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Proveedores</span>
                            </div>
                        </a>
                    </li>
                    @endcan

                    <!-- Compras -->
                    @canany(['ver-compras_facturas', 'crear-compras_facturas'])
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('compras-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('compras-'))">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page.startsWith('compras-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="shrink-0 h-6 w-6 icon icon-tabler icon-tabler-businessplan"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <ellipse cx="16" cy="6" rx="5" ry="3" />
                                        <path :class="page.startsWith('compras-') && 'text-indigo-300'"
                                            d="M11 6v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                                        <path :class="page.startsWith('compras-') && 'text-indigo-300'"
                                            d="M11 10v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                                        <path :class="page.startsWith('compras-') && 'text-indigo-300'"
                                            d="M11 14v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4" />
                                        <path :class="page.startsWith('compras-') && 'text-indigo-300'"
                                            d="M7 9h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                        <path :class="page.startsWith('compras-') && 'text-indigo-300'"
                                            d="M5 15v1m0 -8v1" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Compras</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="!open && 'hidden'" x-cloak>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'compras-facturas' && '!text-indigo-500'"
                                        href="{{ route('admin.compras.facturas.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Facturas
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcanany

                    <!-- VENTAS -->
                    @canany(['ver-cotizaciones', 'ver-ventas-facturas', 'ver-recibos', 'ver-contrato'])
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('ventas-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('ventas-'))">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page.startsWith('ventas-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="shrink-0 h-6 w-6 icon icon-tabler icon-tabler-businessplan"
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
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Ventas</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">

                            <ul class="pl-9 mt-1" :class="!open && 'hidden'" x-cloak>
                                @can('ver-cotizaciones')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'ventas-presupuestos' && '!text-indigo-500'"
                                        href="{{ route('admin.ventas.presupuestos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Cotizaciones
                                        </span>
                                    </a>
                                </li>
                                @endcan
                                @can('ver-ventas-facturas')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'ventas-facturas' && '!text-indigo-500'"
                                        href="{{ route('admin.ventas.facturas.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Facturas
                                        </span>
                                    </a>
                                </li>
                                @endcan

                                @can('ver-recibos')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'ventas-recibos' && '!text-indigo-500'"
                                        href="{{ route('admin.ventas.recibos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Recibos</span>
                                    </a>
                                </li>
                                @endcan

                                @can('ver-contrato')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'ventas-contratos' && '!text-indigo-500'"
                                        href="{{ route('admin.ventas.contratos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Contratos</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    @endcanany


                    <!-- Vehiculos -->
                    @canany(['ver-vehiculos-flotas', 'ver-vehiculos-vehiculos', 'ver-vehiculos-reportes'])
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('vehiculos-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('vehiculos-'))">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page.startsWith('vehiculos-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6 icon icon-tabler icon-tabler-car" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="7" cy="17" r="2" />
                                        <circle cx="17" cy="17" r="2" />
                                        <path
                                            d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Vehiculos</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="!open && 'hidden'" x-cloak>
                                @can('ver-vehiculos-flotas')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'vehiculos-flotas' && '!text-indigo-500'"
                                        href="{{ route('admin.vehiculos.flotas.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Flotas
                                        </span>
                                    </a>
                                </li>
                                @endcan

                                @can('ver-vehiculos-vehiculos')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'vehiculos-vehiculos' && '!text-indigo-500'"
                                        href="{{ route('admin.vehiculos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Vehiculos</span>
                                    </a>
                                </li>
                                @endcan

                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'vehiculos-mantenimiento' && '!text-indigo-500'"
                                        href="{{ route('admin.vehiculos.mantenimiento.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Mantenimientos
                                            Programados
                                        </span>
                                    </a>
                                </li>

                                @can('ver-vehiculos-reportes')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'vehiculos-reportes' && '!text-indigo-500'"
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

                    @canany(['ver-certificados-actas', 'ver-certificados-gps', 'ver-certificados-velocimetros'])
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('certificados-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('certificados-'))">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page.startsWith('certificados-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="shrink-0 h-6 w-6icon icon-tabler icon-tabler-certificate"
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
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Certificados</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">

                            <ul class="pl-9 mt-1" :class="!open && 'hidden'" x-cloak>
                                @can('ver-certificados-actas')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'certificados-actas' && '!text-indigo-500'"
                                        href="{{ route('admin.certificados.actas.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Actas</span>
                                    </a>
                                </li>
                                @endcan

                                @can('ver-certificados-gps')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'certificados-gps' && '!text-indigo-500'"
                                        href="{{ route('admin.certificados.gps.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Certificados
                                            Gps</span>
                                    </a>
                                </li>
                                @endcan
                                @can('ver-certificados-velocimetros')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'certificados-velocimetro' && '!text-indigo-500'"
                                        href="{{ route('admin.certificados.velocimetros.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Certificados
                                            Velocimetros</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    @endcanany

                    <!-- administracion -->
                    @canany(['admin.solicitudes.index', 'admin.reportes.index', 'admin.usuarios.index',
                    'admin.cobros.index', 'admin.payments.index', 'admin.settings.ciudades.index',
                    'admin.settings.roles.index', 'admin.settings.plantilla.index'])
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('administracion-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('administracion-'))">
                        <a class="block text-slate-200 hover:text-white truncate transition duration-150"
                            :class="page.startsWith('administracion-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 h-6 w-6" viewBox="0 0 24 24">
                                        <path class="fill-current text-slate-600"
                                            :class="page.startsWith('administracion-') && 'text-indigo-500'"
                                            d="M19.714 14.7l-7.007 7.007-1.414-1.414 7.007-7.007c-.195-.4-.298-.84-.3-1.286a3 3 0 113 3 2.969 2.969 0 01-1.286-.3z" />
                                        <path class="fill-current text-slate-400"
                                            :class="page.startsWith('administracion-') && 'text-indigo-300'"
                                            d="M10.714 18.3c.4-.195.84-.298 1.286-.3a3 3 0 11-3 3c.002-.446.105-.885.3-1.286l-6.007-6.007 1.414-1.414 6.007 6.007z" />
                                        <path class="fill-current text-slate-600"
                                            :class="page.startsWith('administracion-') && 'text-indigo-500'"
                                            d="M5.7 10.714c.195.4.298.84.3 1.286a3 3 0 11-3-3c.446.002.885.105 1.286.3l7.007-7.007 1.414 1.414L5.7 10.714z" />
                                        <path class="fill-current text-slate-400"
                                            :class="page.startsWith('administracion-') && 'text-indigo-300'"
                                            d="M19.707 9.292a3.012 3.012 0 00-1.415 1.415L13.286 5.7c-.4.195-.84.298-1.286.3a3 3 0 113-3 2.969 2.969 0 01-.3 1.286l5.007 5.006z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Administracion</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="open && 'transform rotate-180'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="!open && 'hidden'" x-cloak>
                                @can('admin.solicitudes.index')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'administracion-solicitudes' && '!text-indigo-500'"
                                        href="{{ route('admin.solicitudes.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Solicitudes
                                        </span>
                                    </a>
                                </li>
                                @endcan

                                @can('admin.reportes.index')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'administracion-reportes-gerenciales' && '!text-indigo-500'"
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
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'administracion-usuarios' && '!text-indigo-500'"
                                        href="{{ route('admin.users.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Usuarios
                                        </span>
                                    </a>
                                </li>
                                @endcan

                                @can('admin.cobros.index')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'administracion-cobros' && '!text-indigo-500'"
                                        href="{{ route('admin.cobros.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Registro de Cobros</span>
                                    </a>
                                </li>
                                @endcan

                                @can('admin.payments.index')
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'administracion-paymentes' && '!text-indigo-500'"
                                        href="{{ route('admin.payments.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Pagos</span>
                                    </a>
                                </li>
                                @endcan

                                {{-- añadir permiso --}}
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'administracion-recibos' && '!text-indigo-500'"
                                        href="{{ route('admin.gerencia.recibos.index') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Recibos Egresos</span>
                                    </a>
                                </li>

                                @canany(['admin.settings.ciudades.index', 'admin.settings.roles.index',
                                'admin.settings.plantilla.index'])
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        :class="page === 'administracion-ajustes' && '!text-indigo-500'"
                                        href="{{ route('admin.ajustes.cuenta') }}">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Ajustes</span>
                                    </a>
                                </li>
                                @endcanany

                            </ul>
                        </div>
                    </li>
                    @endcanany

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
                    <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0"
                        :class="{ 'bg-slate-900': page.startsWith('tecnico-') }" x-data="{ open: false }"
                        x-init="$nextTick(() => open = page.startsWith('tecnico-'))">
                        <a class="sidebar-expander-link block text-slate-200 hover:text-white transition duration-150"
                            :class="page.startsWith('tecnico-') && 'hover:text-slate-200'" href="#0"
                            @click.prevent="sidebarExpanded ? open = !open : sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="shrink-0 h-6 w-7 icon icon-tabler icon-tabler-subtask"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <line x1="6" y1="9" x2="12" y2="9" />
                                        <line class="fill-current text-slate-600" x1="4" y1="5" x2="8" y2="5" />
                                        <path d="M6 5v11a1 1 0 0 0 1 1h5" />
                                        <rect class="fill-current text-slate-400" x="12" y="7" width="8" height="4"
                                            rx="1" />
                                        <rect class="fill-current text-slate-400" x="12" y="15" width="8" height="4"
                                            rx="1" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                        Tareas
                                    </span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400"
                                        :class="{ 'transform rotate-180': open }" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-9 mt-1" :class="{ 'hidden': !open }" x-cloak>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-slate-400 hover:text-slate-200 transition duration-150 truncate"
                                        href="{{ route('admin.tecnico.tareas.index') }}"
                                        :class="page === 'tecnico-tareas-index' && '!text-indigo-500'">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                            Modulo Tareas
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
                        <path class="text-slate-400"
                            d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
                        <path class="text-slate-600" d="M3 23H1V1h2z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>