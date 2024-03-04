<header class="sticky top-0 bg-white border-b border-slate-200 z-30">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 -mb-px">

            <!-- Header: Left side -->
            <div class="flex lg:hidden">
                <!-- Hamburger button -->
                <button class="text-slate-500 hover:text-slate-600 lg:hidden" @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2" />
                        <rect x="4" y="11" width="16" height="2" />
                        <rect x="4" y="17" width="16" height="2" />
                    </svg>
                </button>

            </div>

            <div class="hover text-left mx-2 hidden md:flex">
                <p class="text-talentus-200 text-wrap text-xs md:text-base ">EMPRESA: <b
                        class="hover:text-talentus-200">{{ $empresa_actual }}</b>
                </p>
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-4">

                <div class="m-1.5">
                    <!-- Start -->

                    @if (!Cache::has('precioVenta'))
                        Obtener TC <x-form.button.circle wire:click.prevent="getTipoCambio()" spinner="getTipoCambio"
                            positive icon="refresh" xs />
                    @else
                        <div
                            class="text-sm hidden md:inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-1">
                            TC - Venta: {{ Cache::get('precioVenta') }} Compra: {{ Cache::get('precioCompra') }}


                        </div>
                    @endif


                    <!-- End -->
                </div>

                <!-- Notifications button -->
                @livewire('admin.header.notificaciones')


                <!-- Empresa button -->
                <div class="relative inline-flex" x-data="{ open: false }">
                    <button
                        class="w-8 h-8 flex items-center justify-center bg-slate-100 hover:bg-slate-200 transition duration-150 rounded-full"
                        :class="{ 'bg-slate-200': open }" aria-haspopup="true" @click.prevent="open = !open"
                        :aria-expanded="open">
                        <span class="sr-only">Empresa</span>

                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path class="fill-current text-slate-500"
                                    d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </button>
                    <div class="origin-top-right z-10 absolute top-full right-0 min-w-44 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                        x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" x-cloak>
                        <div class="text-xs font-semibold text-slate-400 uppercase pt-1.5 pb-2 px-3">
                            Selecciona Empresa¡
                        </div>
                        <ul x-data="{ selected: {{ session('empresa') }} }">


                            @foreach ($empresas as $empresa)
                                <li>

                                    <a wire:click.prevent="changeBussines({{ $empresa->id }})"
                                        class="hover:bg-violet-400 focus:outline-none focus:ring font-medium text-sm hover:text-white flex items-center py-1 px-3"
                                        :class="selected === {{ $empresa->id }} &&
                                            'border-transparent shadow-sm bg-violet-700 text-white'"
                                        href="#0" @click="open = false; selected = {{ $empresa->id }}"
                                        @focus="open = true" @focusout="open = false">
                                        <svg class="w-3 h-3 fill-current text-indigo-300 shrink-0 mr-2"
                                            viewBox="0 0 12 12">
                                            <rect y="3" width="12" height="9" rx="1" />
                                            <path d="M2 0h8v2H2z" />
                                        </svg>
                                        <span class="truncate">{{ $empresa->plantilla->razon_social }}</span>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <!-- Divider -->
                <hr class="w-px h-6 bg-slate-200" />

                <!-- User button -->
                @livewire('admin.header.user-info')

            </div>

        </div>
    </div>
</header>
