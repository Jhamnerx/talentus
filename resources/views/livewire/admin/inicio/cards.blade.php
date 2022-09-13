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
                                        <div wire:click="toClientes"
                                            class="bg-gradient-to-tr from-blue-400 to-blue-600 hover:scale-75 ease-in duration-500 cursor-pointer -mt-10 rounded-xl text-white grid items-center w-24 h-24 py-4 px-4 justify-center shadow-lg-blue mb-0">

                                            <svg class="w-full  fill-white" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 64 64">
                                                <g stroke-linecap="square" stroke-miterlimit="10" fill="none"
                                                    stroke="currentColor" stroke-linejoin="miter"
                                                    class="nc-icon-wrapper">
                                                    <path
                                                        d="M38,39H26A18,18,0,0,0,8,57H8s9,4,24,4,24-4,24-4h0A18,18,0,0,0,38,39Z">
                                                    </path>
                                                    <path
                                                        d="M19,17.067a13,13,0,1,1,26,0C45,24.283,39.18,32,32,32S19,24.283,19,17.067Z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="w-full pl-4 max-w-full flex-grow flex-1 mb-2 text-right undefined">
                                            <h5 class="text-gray-500 font-light tracking-wide text-base mb-1">Hoy</h5>
                                            <span class="text-3xl text-gray-900">{{ $totales['clientes-hoy'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </header>
                    <h2 class="text-lg font-semibold text-slate-800 mb-2">Clientes</h2>
                    <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total</div>
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-slate-800 mr-2">
                            {{ number_format($totales['clientes-total'], 0, '.', '.') }}
                        </div>
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
                                        <div wire:click="toVehiculos"
                                            class="bg-gradient-to-tr from-white to-green-100 cursor-pointer -mt-10 hover:scale-75 ease-in duration-500 rounded-xl text-white grid items-center w-24 h-24 py-4 px-4 justify-center shadow-lg-blue mb-0">
                                            <svg class="w-full  fill-white" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 48 48">
                                                <g class="nc-icon-wrapper">
                                                    <path
                                                        d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                                        fill="#363636"></path>
                                                    <path
                                                        d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                                        fill="#363636"></path>
                                                    <path
                                                        d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                                        fill="#e3e3e3"></path>
                                                    <path
                                                        d="M42,22a1,1,0,0,1-.992-.883L39.422,7.649A3,3,0,0,0,36.442,5H11.558a3,3,0,0,0-2.98,2.649L6.993,21.117a1,1,0,0,1-1.986-.234L6.592,7.415A5,5,0,0,1,11.558,3H36.442a5,5,0,0,1,4.966,4.415l1.585,13.468a1,1,0,0,1-.876,1.11A.945.945,0,0,1,42,22Z"
                                                        fill="#38a838"></path>
                                                    <path
                                                        d="M46,38H2a1,1,0,0,1-1-1V26a6,6,0,0,1,6-6H41a6,6,0,0,1,6,6V37A1,1,0,0,1,46,38Z"
                                                        fill="#78d478"></path>
                                                    <circle cx="40" cy="27" r="3" fill="#fff">
                                                    </circle>
                                                    <circle cx="8" cy="27" r="3" fill="#fff">
                                                    </circle>
                                                    <path d="M31,31H17a2,2,0,0,1,0-4H31a2,2,0,0,1,0,4Z" fill="#363636">
                                                    </path>
                                                    <path
                                                        d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                                        fill="#49c549"></path>
                                                    <circle cx="8" cy="34" r="2" fill="#f7bf26">
                                                    </circle>
                                                    <circle cx="40" cy="34" r="2" fill="#f7bf26">
                                                    </circle>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="w-full pl-4 max-w-full flex-grow flex-1 mb-2 text-right undefined">
                                            <h5 class="text-gray-500 font-light tracking-wide text-base mb-1">Hoy</h5>
                                            <span class="text-3xl text-gray-900">{{ $totales['vehiculos-hoy'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </header>
                    <h2 class="text-lg font-semibold text-slate-800 mb-2">Vehiculos</h2>
                    <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total</div>
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-slate-800 mr-2">
                            {{ number_format($totales['vehiculos-total'], 0, '.', '.') }}
                        </div>
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
                                        <div wire:click="toFlotas"
                                            class="bg-gradient-to-tr from-white to-cyan-200 cursor-pointer -mt-10 hover:scale-75 ease-in duration-500 rounded-xl text-white grid items-center w-24 h-24 py-4 px-4 justify-center shadow-lg-blue mb-0">
                                            <svg class="w-full  fill-white" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 48 48">
                                                <g class="nc-icon-wrapper">
                                                    <path
                                                        d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                                        fill="#363636"></path>
                                                    <path
                                                        d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                                        fill="#363636"></path>
                                                    <path
                                                        d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                                        fill="#e3e3e3"></path>
                                                    <path
                                                        d="M42,22a1,1,0,0,1-.992-.883L39.422,7.649A3,3,0,0,0,36.442,5H11.558a3,3,0,0,0-2.98,2.649L6.993,21.117a1,1,0,0,1-1.986-.234L6.592,7.415A5,5,0,0,1,11.558,3H36.442a5,5,0,0,1,4.966,4.415l1.585,13.468a1,1,0,0,1-.876,1.11A.945.945,0,0,1,42,22Z"
                                                        fill="#38a838"></path>
                                                    <path
                                                        d="M46,38H2a1,1,0,0,1-1-1V26a6,6,0,0,1,6-6H41a6,6,0,0,1,6,6V37A1,1,0,0,1,46,38Z"
                                                        fill="#78d478"></path>
                                                    <circle cx="40" cy="27" r="3"
                                                        fill="#fff">
                                                    </circle>
                                                    <circle cx="8" cy="27" r="3"
                                                        fill="#fff">
                                                    </circle>
                                                    <path d="M31,31H17a2,2,0,0,1,0-4H31a2,2,0,0,1,0,4Z"
                                                        fill="#363636">
                                                    </path>
                                                    <path
                                                        d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                                        fill="#49c549"></path>
                                                    <circle cx="8" cy="34" r="2"
                                                        fill="#f7bf26">
                                                    </circle>
                                                    <circle cx="40" cy="34" r="2"
                                                        fill="#f7bf26">
                                                    </circle>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="w-full pl-4 max-w-full flex-grow flex-1 mb-2 text-right undefined">
                                            <h5 class="text-gray-500 font-light tracking-wide text-base mb-1">Hoy</h5>
                                            <span class="text-3xl text-gray-900">{{ $totales['flotas-hoy'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </header>
                    <h2 class="text-lg font-semibold text-slate-800 mb-2">Flotas</h2>
                    <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total</div>
                    <div class="flex items-start">
                        <div class="text-3xl font-bold text-slate-800 mr-2">
                            {{ number_format($totales['flotas-total'], 0, '.', '.') }}</div>
                    </div>
                </div>
            </div>


            <!-- Bar chart (fact vs recibos soles) -->

            @livewire('admin.inicio.charts.ventas-soles')


            <!-- Bar chart (fact vs recibos dolares) -->

            @livewire('admin.inicio.charts.ventas-dolares')



            <!-- Line chart (Real Time Value) -->

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
            <div
                class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
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
            <div
                class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4 border-b border-slate-100 flex items-center">
                    <h2 class="font-semibold text-slate-800">Sales VS Refunds</h2>
                    <div class="relative ml-2" x-data="{ open: false }" @mouseenter="open = true"
                        @mouseleave="open = false">
                        <button class="block" href="#0" aria-haspopup="true" :aria-expanded="open"
                            @focus="open = true" @focusout="open = false" @click.prevent>
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
                                x-transition:leave="transition ease-out duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
                                                href="#0">Nick
                                                Mark</a> mentioned <a class="font-medium text-slate-800"
                                                href="#0">Sara
                                                Smith</a>
                                            in a new post</div>
                                        <div class="shrink-0 self-end ml-2">
                                            <a class="font-medium text-indigo-500 hover:text-indigo-600"
                                                href="#0">View<span class="hidden sm:inline">
                                                    -&gt;</span></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- Item -->
                            <li class="flex px-2">
                                <div class="w-9 h-9 rounded-full shrink-0 bg-rose-500 my-2 mr-3">
                                    <svg class="w-9 h-9 fill-current text-rose-50" viewBox="0 0 36 36">
                                        <path
                                            d="M25 24H11a1 1 0 01-1-1v-5h2v4h12v-4h2v5a1 1 0 01-1 1zM14 13h8v2h-8z" />
                                    </svg>
                                </div>
                                <div class="grow flex items-center border-b border-slate-100 text-sm py-2">
                                    <div class="grow flex justify-between">
                                        <div class="self-center">The post <a class="font-medium text-slate-800"
                                                href="#0">Post
                                                Name</a> was removed by <a
                                                class="font-medium text-slate-800 hover:text-slate-900"
                                                href="#0">Nick
                                                Mark</a></div>
                                        <div class="shrink-0 self-end ml-2">
                                            <a class="font-medium text-indigo-500 hover:text-indigo-600"
                                                href="#0">View<span class="hidden sm:inline">
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
                                                href="#0">Patrick Sullivan</a> published a new <a
                                                class="font-medium text-slate-800" href="#0">post</a></div>
                                        <div class="shrink-0 self-end ml-2">
                                            <a class="font-medium text-indigo-500 hover:text-indigo-600"
                                                href="#0">View<span class="hidden sm:inline">
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
                                                href="#0">240+</a> users have subscribed to <a
                                                class="font-medium text-slate-800" href="#0">Newsletter
                                                #1</a></div>
                                        <div class="shrink-0 self-end ml-2">
                                            <a class="font-medium text-indigo-500 hover:text-indigo-600"
                                                href="#0">View<span class="hidden sm:inline">
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
                                                class="font-medium text-slate-800 hover:text-slate-900"
                                                href="#0">Nick
                                                Mark</a></div>
                                        <div class="shrink-0 self-end ml-2">
                                            <a class="font-medium text-indigo-500 hover:text-indigo-600"
                                                href="#0">View<span class="hidden sm:inline">
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
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
                                        <div class="self-center"><a
                                                class="font-medium text-slate-800 hover:text-slate-900"
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
