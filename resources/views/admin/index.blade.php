@extends('layouts.admin')
@section('ruta', 'dashboard-inicio')
@section('contenido')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{page: 'dashboard-inicio',sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

    <div class="relative bg-indigo-200 p-4 sm:p-6 rounded-sm overflow-hidden mb-8">

        <!-- Background illustration -->
        <div class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block" aria-hidden="true">
            <svg width="319" height="198" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
                    <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
                    <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
                    <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="welcome-b">
                        <stop stop-color="#A5B4FC" offset="0%" />
                        <stop stop-color="#818CF8" offset="100%" />
                    </linearGradient>
                    <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="welcome-c">
                        <stop stop-color="#4338CA" offset="0%" />
                        <stop stop-color="#6366F1" stop-opacity="0" offset="100%" />
                    </linearGradient>
                </defs>
                <g fill="none" fill-rule="evenodd">
                    <g transform="rotate(64 36.592 105.604)">
                        <mask id="welcome-d" fill="#fff">
                            <use xlink:href="#welcome-a" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-a" />
                        <path fill="url(#welcome-c)" mask="url(#welcome-d)" d="M64-24h80v152H64z" />
                    </g>
                    <g transform="rotate(-51 91.324 -105.372)">
                        <mask id="welcome-f" fill="#fff">
                            <use xlink:href="#welcome-e" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-e" />
                        <path fill="url(#welcome-c)" mask="url(#welcome-f)" d="M40.333-15.147h50v95h-50z" />
                    </g>
                    <g transform="rotate(44 61.546 392.623)">
                        <mask id="welcome-h" fill="#fff">
                            <use xlink:href="#welcome-g" />
                        </mask>
                        <use fill="url(#welcome-b)" xlink:href="#welcome-g" />
                        <path fill="url(#welcome-c)" mask="url(#welcome-h)" d="M40.333-15.147h50v95h-50z" />
                    </g>
                </g>
            </svg>
        </div>

        <!-- Content -->
        <div class="relative">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-1">Bienvenido al Panel de Talentus. 👋
            </h1>
            <p>Aqui veras el resumen de todo el sistema:</p>
        </div>

    </div>
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Avatars -->
        <ul class="flex flex-wrap justify-center sm:justify-start mb-8 sm:mb-0 -space-x-3 -ml-px">
            <li>
                <a class="block" href="#0">
                    <img class="w-9 h-9 rounded-full" src="{{asset('images/user-36-01.jpg')}}" width="36" height="36"
                        alt="User 01" />
                </a>
            </li>
            <li>
                <a class="block" href="#0">
                    <img class="w-9 h-9 rounded-full" src="../images/user-36-02.jpg" width="36" height="36"
                        alt="User 02" />
                </a>
            </li>
            <li>
                <a class="block" href="#0">
                    <img class="w-9 h-9 rounded-full" src="../images/user-36-03.jpg" width="36" height="36"
                        alt="User 03" />
                </a>
            </li>
            <li>
                <a class="block" href="#0">
                    <img class="w-9 h-9 rounded-full" src="../images/user-36-04.jpg" width="36" height="36"
                        alt="User 04" />
                </a>
            </li>
            <li>
                <button
                    class="flex justify-center items-center w-9 h-9 rounded-full bg-white border border-slate-200 hover:border-slate-300 text-indigo-500 shadow-sm transition duration-150 ml-2">
                    <span class="sr-only">Add new user</span>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                </button>
            </li>
        </ul>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Filter button -->
            <div class="relative inline-flex" x-data="{ open: false }">
                <button class="btn bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600"
                    aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                    <span class="sr-only">Filtro</span><wbr>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                        <path
                            d="M9 15H7a1 1 0 010-2h2a1 1 0 010 2zM11 11H5a1 1 0 010-2h6a1 1 0 010 2zM13 7H3a1 1 0 010-2h10a1 1 0 010 2zM15 3H1a1 1 0 010-2h14a1 1 0 010 2z" />
                    </svg>
                </button>
                <div class="origin-top-right z-10 absolute top-full left-0 right-auto md:left-auto md:right-0 min-w-56 bg-white border border-slate-200 pt-1.5 rounded shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <div class="text-xs font-semibold text-slate-400 uppercase pt-1.5 pb-2 px-4">Filters
                    </div>
                    <ul class="mb-4">
                        <li class="py-1 px-3">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" checked />
                                <span class="text-sm font-medium ml-2">Direct VS Indirect</span>
                            </label>
                        </li>
                        <li class="py-1 px-3">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" checked />
                                <span class="text-sm font-medium ml-2">Real Time Value</span>
                            </label>
                        </li>
                        <li class="py-1 px-3">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" checked />
                                <span class="text-sm font-medium ml-2">Top Channels</span>
                            </label>
                        </li>
                        <li class="py-1 px-3">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" />
                                <span class="text-sm font-medium ml-2">Sales VS Refunds</span>
                            </label>
                        </li>
                        <li class="py-1 px-3">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" />
                                <span class="text-sm font-medium ml-2">Last Order</span>
                            </label>
                        </li>
                        <li class="py-1 px-3">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox" />
                                <span class="text-sm font-medium ml-2">Total Spent</span>
                            </label>
                        </li>
                    </ul>
                    <div class="py-2 px-3 border-t border-slate-200 bg-slate-50">
                        <ul class="flex items-center justify-between">
                            <li>
                                <button
                                    class="btn-xs bg-white border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-600">
                                    Limpiar
                                </button>
                            </li>
                            <li>
                                <button class="btn-xs bg-indigo-500 hover:bg-indigo-600 text-white"
                                    @click="open = false" @focusout="open = false">Aplicar</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Datepicker built with flatpickr -->
            <div class="relative">
                <input
                    class="datepicker form-input pl-9 text-slate-500 hover:text-slate-600 font-medium focus:border-slate-300 w-60"
                    placeholder="Select dates" data-class="flatpickr-right" />
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="w-4 h-4 fill-current text-slate-500 ml-3" viewBox="0 0 16 16">
                        <path
                            d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                    </svg>
                </div>
            </div>


        </div>

    </div>

    <!-- Cards -->
    <div class="grid grid-cols-12 gap-6">

        <!-- card  (Clientes) -->
        <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <div class="px-5 pt-5">
                <header class="flex justify-between items-start mb-2">
                    <!-- Icon -->
                    <img src="../images/icon-01.svg" width="32" height="32" alt="Icon 01" />
                    <!-- Menu button -->
                    <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 rounded-sm">

                        <div class="px-4 mt-10">
                            <div class="w-full bg-white rounded-xl overflow-hdden shadow-md p-4 undefined">
                                <div class="flex flex-wrap border-b border-gray-200 undefined">
                                    <div
                                        class="bg-gradient-to-tr from-blue-500 to-blue-700 -mt-10 rounded-xl text-white grid items-center w-24 h-24 py-4 px-4 justify-center shadow-lg-blue mb-0">
                                        <span class="material-icons text-white text-3xl leading-none">Icono</span>
                                    </div>
                                    <div class="w-full pl-4 max-w-full flex-grow flex-1 mb-2 text-right undefined">
                                        <h5 class="text-gray-500 font-light tracking-wide text-base mb-1">Hoy</h5>
                                        <span class="text-3xl text-gray-900">10</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </header>
                <h2 class="text-lg font-semibold text-slate-800 mb-2">Clientes</h2>
                <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total</div>
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2">17.489</div>
                </div>
            </div>
        </div>
        <!-- card  (Vehiculos) -->
        <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <div class="px-5 pt-5">
                <header class="flex justify-between items-start mb-2">
                    <!-- Icon -->
                    <img src="../images/icon-02.svg" width="32" height="32" alt="Icon 02" />
                    <!-- Menu button -->
                    <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 rounded-sm">

                        <div class="px-4 mt-10">
                            <div class="w-full bg-white rounded-xl overflow-hdden shadow-md p-4 undefined">
                                <div class="flex flex-wrap border-b border-gray-200 undefined">
                                    <div
                                        class="bg-gradient-to-tr from-blue-500 to-blue-700 -mt-10 rounded-xl text-white grid items-center w-24 h-24 py-4 px-4 justify-center shadow-lg-blue mb-0">
                                        <span class="material-icons text-white text-3xl leading-none">Icono</span>
                                    </div>
                                    <div class="w-full pl-4 max-w-full flex-grow flex-1 mb-2 text-right undefined">
                                        <h5 class="text-gray-500 font-light tracking-wide text-base mb-1">Hoy</h5>
                                        <span class="text-3xl text-gray-900">10</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </header>
                <h2 class="text-lg font-semibold text-slate-800 mb-2">Vehiculos</h2>
                <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total</div>
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2">17.489</div>
                </div>
            </div>
        </div>

        <!-- card  (flotas) -->
        <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <div class="px-5 pt-5">
                <header class="flex justify-between items-start mb-2">
                    <!-- Icon -->
                    <img src="../images/icon-03.svg" width="32" height="32" alt="Icon 03" />
                    <!-- Menu button -->
                    <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 rounded-sm">

                        <div class="px-4 mt-10">
                            <div class="w-full bg-white rounded-xl overflow-hdden shadow-md p-4 undefined">
                                <div class="flex flex-wrap border-b border-gray-200 undefined">
                                    <div
                                        class="bg-gradient-to-tr from-blue-500 to-blue-700 -mt-10 rounded-xl text-white grid items-center w-24 h-24 py-4 px-4 justify-center shadow-lg-blue mb-0">
                                        <span class="material-icons text-white text-3xl leading-none">Icono</span>
                                    </div>
                                    <div class="w-full pl-4 max-w-full flex-grow flex-1 mb-2 text-right undefined">
                                        <h5 class="text-gray-500 font-light tracking-wide text-base mb-1">Hoy</h5>
                                        <span class="text-3xl text-gray-900">10</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </header>
                <h2 class="text-lg font-semibold text-slate-800 mb-2">Flotas</h2>
                <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total</div>
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2">17.489</div>
                </div>
            </div>
        </div>
        <!-- Bar chart (Direct vs Indirect) -->
        <div class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Direct VS Indirect</h2>
            </header>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-04.js for config -->
            <div id="dashboard-card-04-legend" class="px-5 py-3">
                <ul class="flex flex-wrap"></ul>
            </div>
            <div class="grow">
                <!-- Change the height attribute to adjust the chart height -->
                <canvas id="dashboard-card-04" width="595" height="248"></canvas>
            </div>
        </div>
        <!-- Line chart (Real Time Value) -->
        <div class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100 flex items-center">
                <h2 class="font-semibold text-slate-800">Real Time Value</h2>
                <div class="relative ml-2" x-data="{ open: false }" @mouseenter="open = true"
                    @mouseleave="open = false">
                    <button class="block" aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                        @focusout="open = false" @click.prevent>
                        <svg class="w-4 h-4 fill-current text-slate-400" viewBox="0 0 16 16">
                            <path
                                d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                        </svg>
                    </button>
                    <div class="z-10 absolute bottom-full left-1/2 transform -translate-x-1/2">
                        <div class="bg-white border border-slate-200 p-3 rounded shadow-lg overflow-hidden mb-2"
                            x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" x-cloak>
                            <div class="text-xs text-center whitespace-nowrap">Built with <a class="underline"
                                    @focus="open = true" @focusout="open = false" href="https://www.chartjs.org/"
                                    target="_blank">Chart.js</a></div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-05.js for config -->
            <div class="px-5 py-3">
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2 tabular-nums">$<span
                            id="dashboard-card-05-value">57.81</span></div>
                    <div id="dashboard-card-05-deviation" class="text-sm font-semibold text-white px-1.5 rounded-full">
                    </div>
                </div>
            </div>
            <div class="grow">
                <!-- Change the height attribute to adjust the chart height -->
                <canvas id="dashboard-card-05" width="595" height="248"></canvas>
            </div>
        </div>
        <!-- Doughnut chart (Top Countries) -->
        <div
            class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Top Countries</h2>
            </header>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-06.js for config -->
            <div class="grow flex flex-col justify-center">
                <div>
                    <!-- Change the height attribute to adjust the chart height -->
                    <canvas id="dashboard-card-06" width="389" height="260"></canvas>
                </div>
                <div id="dashboard-card-06-legend" class="px-5 pt-2 pb-6">
                    <ul class="flex flex-wrap justify-center -m-1"></ul>
                </div>
            </div>
        </div>
        <!-- Table (Top Channels) -->
        <div
            class="flex flex-col col-span-full sm:col-span-12 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100 flex items-center">
                <h2 class="font-semibold text-slate-800">Portfolio Returns</h2>
            </header>
            <div class="px-5 py-3">
                <div class="text-sm italic mb-2">Hey Mark, you're very close to your goal:</div>
                <div class="flex items-center">
                    <div class="text-3xl font-bold text-slate-800 mr-2">$5,247.09</div>
                    <div class="text-sm"><span class="font-medium text-amber-500">97.4%</span></div>
                </div>
                <div class="text-sm text-slate-500">Out of $6,000</div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/fintech-card-07.js for config -->
            <div class="grow">
                <!-- Change the height attribute to adjust the chart height -->
                <canvas id="fintech-card-07" width="389" height="262"></canvas>
            </div>
        </div>
        <!-- Line chart (Sales Over Time) -->
        <div class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100 flex items-center">
                <h2 class="font-semibold text-slate-800">Sales Over Time (all stores)</h2>
            </header>
            <div class="px-5 py-3">
                <div class="flex flex-wrap justify-between items-end">
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-slate-800 mr-2">$1,482</div>
                        <div class="text-sm font-semibold text-white px-1.5 bg-yellow-500 rounded-full">
                            -22%</div>
                    </div>
                    <div id="dashboard-card-08-legend" class="grow ml-2 mb-1">
                        <ul class="flex flex-wrap justify-end"></ul>
                    </div>
                </div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-08.js for config -->
            <div class="grow">
                <!-- Change the height attribute to adjust the chart height -->
                <canvas id="dashboard-card-08" width="595" height="248"></canvas>
            </div>
        </div>
        <!-- Stacked bar chart (Sales VS Refunds) -->
        <div class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100 flex items-center">
                <h2 class="font-semibold text-slate-800">Sales VS Refunds</h2>
                <div class="relative ml-2" x-data="{ open: false }" @mouseenter="open = true"
                    @mouseleave="open = false">
                    <button class="block" href="#0" aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                        @focusout="open = false" @click.prevent>
                        <svg class="w-4 h-4 fill-current text-slate-400" viewBox="0 0 16 16">
                            <path
                                d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                        </svg>
                    </button>
                    <div class="z-10 absolute bottom-full left-1/2 transform -translate-x-1/2">
                        <div class="min-w-72 bg-white border border-slate-200 p-3 rounded shadow-lg overflow-hidden mb-2"
                            x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" x-cloak>
                            <div class="text-sm">Sint occaecat cupidatat non proident, sunt in culpa qui
                                officia deserunt
                                mollit.</div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="px-5 py-3">
                <div class="flex items-start">
                    <div class="text-3xl font-bold text-slate-800 mr-2">+$6,796</div>
                    <div class="text-sm font-semibold text-white px-1.5 bg-yellow-500 rounded-full">-34%
                    </div>
                </div>
            </div>
            <!-- Chart built with Chart.js 3 -->
            <!-- Check out src/js/components/dashboard-card-09.js for config -->
            <div class="grow">
                <!-- Change the height attribute to adjust the chart height -->
                <canvas id="dashboard-card-09" width="595" height="248"></canvas>
            </div>
        </div>
        <!-- Card (Recent Activity) -->
        <div class="col-span-full xl:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Recent Activity</h2>
            </header>
            <div class="p-3">

                <!-- Card content -->
                <!-- "Today" group -->
                <div>
                    <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">
                        Today</header>
                    <ul class="my-1">
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-indigo-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36">
                                    <path
                                        d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">Nick
                                            Mark</a> mentioned <a class="font-medium text-slate-800" href="#0">Sara
                                            Smith</a>
                                        in a new post</div>
                                    <div class="shrink-0 self-end ml-2">
                                        <a class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span
                                                class="hidden sm:inline">
                                                -&gt;</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-rose-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-rose-50" viewBox="0 0 36 36">
                                    <path d="M25 24H11a1 1 0 01-1-1v-5h2v4h12v-4h2v5a1 1 0 01-1 1zM14 13h8v2h-8z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center">The post <a class="font-medium text-slate-800"
                                            href="#0">Post
                                            Name</a> was removed by <a
                                            class="font-medium text-slate-800 hover:text-slate-900" href="#0">Nick
                                            Mark</a></div>
                                    <div class="shrink-0 self-end ml-2">
                                        <a class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span
                                                class="hidden sm:inline">
                                                -&gt;</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-emerald-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-emerald-50" viewBox="0 0 36 36">
                                    <path
                                        d="M15 13v-3l-5 4 5 4v-3h8a1 1 0 000-2h-8zM21 21h-8a1 1 0 000 2h8v3l5-4-5-4v3z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">Patrick Sullivan</a> published a new <a
                                            class="font-medium text-slate-800" href="#0">post</a></div>
                                    <div class="shrink-0 self-end ml-2">
                                        <a class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span
                                                class="hidden sm:inline">
                                                -&gt;</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- "Yesterday" group -->
                <div>
                    <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">
                        Yesterday</header>
                    <ul class="my-1">
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-sky-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-sky-50" viewBox="0 0 36 36">
                                    <path
                                        d="M23 11v2.085c-2.841.401-4.41 2.462-5.8 4.315-1.449 1.932-2.7 3.6-5.2 3.6h-1v2h1c3.5 0 5.253-2.338 6.8-4.4 1.449-1.932 2.7-3.6 5.2-3.6h3l-4-4zM15.406 16.455c.066-.087.125-.162.194-.254.314-.419.656-.872 1.033-1.33C15.475 13.802 14.038 13 12 13h-1v2h1c1.471 0 2.505.586 3.406 1.455zM24 21c-1.471 0-2.505-.586-3.406-1.455-.066.087-.125.162-.194.254-.316.422-.656.873-1.028 1.328.959.878 2.108 1.573 3.628 1.788V25l4-4h-3z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">240+</a> users have subscribed to <a
                                            class="font-medium text-slate-800" href="#0">Newsletter
                                            #1</a></div>
                                    <div class="shrink-0 self-end ml-2">
                                        <a class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span
                                                class="hidden sm:inline">
                                                -&gt;</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-indigo-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36">
                                    <path
                                        d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center">The post <a class="font-medium text-slate-800"
                                            href="#0">Post
                                            Name</a> was suspended by <a
                                            class="font-medium text-slate-800 hover:text-slate-900" href="#0">Nick
                                            Mark</a></div>
                                    <div class="shrink-0 self-end ml-2">
                                        <a class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">View<span
                                                class="hidden sm:inline">
                                                -&gt;</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- Card (Income/Expenses) -->
        <div class="col-span-full xl:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
            <header class="px-5 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-slate-800">Income/Expenses</h2>
            </header>
            <div class="p-3">

                <!-- Card content -->
                <!-- "Today" group -->
                <div>
                    <header class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm font-semibold p-2">
                        Today</header>
                    <ul class="my-1">
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-rose-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-rose-50" viewBox="0 0 36 36">
                                    <path d="M17.7 24.7l1.4-1.4-4.3-4.3H25v-2H14.8l4.3-4.3-1.4-1.4L11 18z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">Qonto</a> billing</div>
                                    <div class="shrink-0 self-start ml-2">
                                        <span class="font-medium text-slate-800">-$49.88</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-emerald-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-emerald-50" viewBox="0 0 36 36">
                                    <path d="M18.3 11.3l-1.4 1.4 4.3 4.3H11v2h10.2l-4.3 4.3 1.4 1.4L25 18z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">Cruip.com</a> Market Ltd 70 Wilson St London</div>
                                    <div class="shrink-0 self-start ml-2">
                                        <span class="font-medium text-emerald-500">+249.88</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-emerald-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-emerald-50" viewBox="0 0 36 36">
                                    <path d="M18.3 11.3l-1.4 1.4 4.3 4.3H11v2h10.2l-4.3 4.3 1.4 1.4L25 18z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">Notion
                                            Labs Inc</a></div>
                                    <div class="shrink-0 self-start ml-2">
                                        <span class="font-medium text-emerald-500">+99.99</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-emerald-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-emerald-50" viewBox="0 0 36 36">
                                    <path d="M18.3 11.3l-1.4 1.4 4.3 4.3H11v2h10.2l-4.3 4.3 1.4 1.4L25 18z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">Market
                                            Cap Ltd</a></div>
                                    <div class="shrink-0 self-start ml-2">
                                        <span class="font-medium text-emerald-500">+1,200.88</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-slate-200 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-slate-400" viewBox="0 0 36 36">
                                    <path
                                        d="M21.477 22.89l-8.368-8.367a6 6 0 008.367 8.367zm1.414-1.413a6 6 0 00-8.367-8.367l8.367 8.367zM18 26a8 8 0 110-16 8 8 0 010 16z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">App.com</a> Market Ltd 70 Wilson St London</div>
                                    <div class="shrink-0 self-start ml-2">
                                        <span class="font-medium text-slate-800 line-through">+$99.99</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Item -->
                        <li class="flex px-2">
                            <div class="w-9 h-9 rounded-full shrink-0 bg-rose-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-rose-50" viewBox="0 0 36 36">
                                    <path d="M17.7 24.7l1.4-1.4-4.3-4.3H25v-2H14.8l4.3-4.3-1.4-1.4L11 18z" />
                                </svg>
                            </div>
                            <div class="grow flex items-center text-sm py-2">
                                <div class="grow flex justify-between">
                                    <div class="self-center"><a class="font-medium text-slate-800 hover:text-slate-900"
                                            href="#0">App.com</a> Market Ltd 70 Wilson St London</div>
                                    <div class="shrink-0 self-start ml-2">
                                        <span class="font-medium text-slate-800">-$49.88</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>

</div>


@stop