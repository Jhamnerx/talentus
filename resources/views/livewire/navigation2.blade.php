{{-- <nav class="min-h-full bg-talentus" x-data="{open:false}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-28">
            <div class="flex items-center">
                {{-- LOGOTIPO --}}
                <div class="flex items-center justify-between w-full md:w-auto">
                    <a href="{{route('web.home')}}">
                        <img class="h-14 w-36" src="{{Storage::url('images/logo/logo-talentus.png')}}"
                            alt="Talentus Logo">
                    </a>

                </div>
                {{-- MENU LG --}}
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        @auth
                        <a href="{{route('admin.home')}}"
                            class="bg-gray-900 text-white px-3 py-2 rounded-md text-base font-bold"
                            aria-current="page">Dashboard</a>
                        @endauth
                        <a href="{{route('web.home')}}"
                            class="text-white before:bg-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold leading-tight">Inicio</a>
                        <!-- 1st level: hover -->
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                            @mouseleave="open = false">
                            <a class="text-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold items-center transition duration-150 ease-in-out"
                                href="#0" aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                                @focusout="open = false" @click.prevent>
                                Plataformas
                            </a>
                            <!-- 2nd level: hover -->
                            <div class="origin-top-right absolute top-full right-0 w-40 bg-white py-4 ml-4 rounded shadow-lg"
                                x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-out duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                                <div>
                                    <a class="font-bold text-base text-slate-600 hover:text-blue-600 flex py-2 px-5 leading-tight"
                                        href="{{route('plataforma.basica')}}" @focus="open = true"
                                        @focusout="open = false">Plataforma Basica</a>
                                </div>
                                <div>
                                    <a class="font-bold text-base text-slate-600 hover:text-blue-600 flex py-2 px-5 leading-tight"
                                        href="{{route('plataforma.premium')}}" @focus="open = true"
                                        @focusout="open = false">Plataforma
                                        Premium</a>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('usos')}}"
                            class="text-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">Usos</a>

                        <a href="{{route('servicios')}}"
                            class="text-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">Soluciones/Productos</a>
                        <a href="{{route('contacto')}}"
                            class="text-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">Contacto</a>
                    </div>
                </div>
            </div>

            {{-- PANEL DE SESSION --}}
            @auth
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <button type="button"
                        class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                        <span class="sr-only">Ver notificaciones</span>
                        <!-- Heroicon name: outline/bell -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        {{-- FOTO PERFIL --}}
                        <div>
                            <button x-on:click="open = true" type="button"
                                class="max-w-xs bg-gray-800 rounded-full flex items-center text-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="">
                            </button>
                        </div>
                        <div x-show="open" x-on:click.away="open=false"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <a href="{{route('profile.show')}}" class="block px-4 py-2 text-base text-gray-700"
                                role="menuitem" tabindex="-1" id="user-menu-item-0">Perfil</a>

                            <a href="ajustes" class="block px-4 py-2 text-base text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-1">Ajustes</a>
                            <a href="{{route('admin.home')}}" class="block px-4 py-2 text-base text-gray-700"
                                role="menuitem" tabindex="-1" id="user-menu-item-1">Sistema</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-base text-gray-700"
                                    role="menuitem" onclick="event.preventDefault(); this.closest('form').submit();"
                                    tabindex=" -1" id="user-menu-item-2">Salir</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="hidden md:block">

                <a href="{{route('login')}}"
                    class="text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">
                    Ingresar
                </a>
                <a href="{{route('register')}}"
                    class="text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">Registrar</a>

            </div>

            @endauth

            {{-- MOBILE MENU --}}
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button x-on:click="open=true" type="button"
                    class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="open" x-on:click.away="open = false" class="md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            @auth
            <a href="{{ route('dashboard') }}"
                class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-bold"
                aria-current="page">Dashboard</a>
            @endauth
            <a href="{{ route('web.home') }}"
                class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-bold">Inicio</a>

            <div x-data="{ mobil: false }">
                <div x-on:click="mobil=true" href="#"
                    class="flex justify-between items-center bg-gray-900 text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-bold">
                    Plataformas
                    <svg x-on:click="mobil = true" class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>

                <div x-show="mobil" x-on:click.away="mobil = false">
                    <a href="{{ route('plataforma.basica') }}"
                        class="bg-gray-900 text-white hover:bg-gray-600 hover:text-white block px-5 py-1 my-1 ml-3 rounded-md text-base font-bold">Basica</a>
                    <a href="{{ route('plataforma.premium') }}"
                        class="bg-gray-900 text-white hover:bg-gray-600 hover:text-white block px-5 py-1 my-1 ml-3 rounded-md text-base font-bold">Premium</a>
                </div>
            </div>

            <a href="{{ route('usos') }}"
                class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-bold">Usos
            </a>

            <a href="{{ route('servicios') }}"
                class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Soluciones/Productos</a>
            <a href="{{ route('contacto') }}"
                class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Contacto</a>
        </div>
        @auth
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center px-5">
                {{-- FOTO PERFIL --}}
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium leading-none text-white">Jhamner Sifuentes</div>
                    <div class="text-base font-medium leading-none text-gray-400">soporte@talentustechnology.com</div>
                </div>
                <button type="button"
                    class="ml-auto bg-gray-800 flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Ver Notificaciones</span>
                    <!-- Heroicon name: outline/bell -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
            </div>
            <div class="mt-3 px-2 space-y-1">
                <a href="{{route('profile.show')}}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Tu
                    Perfil</a>

                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Ajustes</a>
                <a href="{{route('admin.home')}}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Sistema</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
                        onclick="event.preventDefault(); this.closest('form').submit();">Salir
                    </a>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-3 border-t border-gray-700">

            <a href="{{route('login')}}"
                class="text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-medium">
                Ingresar
            </a>
            <a href="{{route('register')}}"
                class="text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-medium">Registrar</a>

        </div>
        @endauth
    </div>
    {{--
</nav> --}}
<nav class="min-h-full bg-talentus" x-data="{open:false}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-28">
            <div class="flex items-center">
                {{-- LOGOTIPO --}}
                <div class="flex items-center justify-between w-full md:w-auto">
                    <a href="{{route('web.home')}}">
                        <img class="h-14 w-36" src="{{Storage::url('images/logo/logo-talentus.png')}}"
                            alt="Talentus Logo">
                    </a>

                </div>
                {{-- MENU LG --}}
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        @auth
                        <a href="{{route('admin.home')}}"
                            class="bg-gray-900 text-white px-3 py-2 rounded-md text-base font-bold"
                            aria-current="page">Dashboard</a>
                        @endauth
                        <a href="{{route('web.home')}}"
                            class="text-white before:bg-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold leading-tight">Inicio</a>
                        <!-- 1st level: hover -->
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                            @mouseleave="open = false">
                            <a class="text-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold items-center transition duration-150 ease-in-out"
                                href="#0" aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                                @focusout="open = false" @click.prevent>
                                Plataformas
                            </a>
                            <!-- 2nd level: hover -->
                            <div class="origin-top-right absolute top-full right-0 w-40 bg-white py-4 ml-4 rounded shadow-lg"
                                x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-out duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                                <div>
                                    <a class="font-bold text-base text-slate-600 hover:text-blue-600 flex py-2 px-5 leading-tight"
                                        href="{{route('plataforma.basica')}}" @focus="open = true"
                                        @focusout="open = false">Plataforma Basica</a>
                                </div>
                                <div>
                                    <a class="font-bold text-base text-slate-600 hover:text-blue-600 flex py-2 px-5 leading-tight"
                                        href="{{route('plataforma.premium')}}" @focus="open = true"
                                        @focusout="open = false">Plataforma
                                        Premium</a>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('usos')}}"
                            class="text-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">Usos</a>

                        <a href="{{route('servicios')}}"
                            class="text-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">Soluciones/Productos</a>
                        <a href="{{route('contacto')}}"
                            class="text-white hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">Contacto</a>
                    </div>
                </div>
            </div>

            {{-- PANEL DE SESSION --}}
            @auth
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <button type="button"
                        class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                        <span class="sr-only">Ver notificaciones</span>
                        <!-- Heroicon name: outline/bell -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        {{-- FOTO PERFIL --}}
                        <div>
                            <button x-on:click="open = true" type="button"
                                class="max-w-xs bg-gray-800 rounded-full flex items-center text-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="">
                            </button>
                        </div>
                        <div x-show="open" x-on:click.away="open=false"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <a href="{{route('profile.show')}}" class="block px-4 py-2 text-base text-gray-700"
                                role="menuitem" tabindex="-1" id="user-menu-item-0">Perfil</a>

                            <a href="ajustes" class="block px-4 py-2 text-base text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-1">Ajustes</a>
                            <a href="{{route('admin.home')}}" class="block px-4 py-2 text-base text-gray-700"
                                role="menuitem" tabindex="-1" id="user-menu-item-1">Sistema</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-base text-gray-700"
                                    role="menuitem" onclick="event.preventDefault(); this.closest('form').submit();"
                                    tabindex=" -1" id="user-menu-item-2">Salir</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="hidden md:block">

                <a href="{{route('login')}}"
                    class="text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">
                    Ingresar
                </a>
                <a href="{{route('register')}}"
                    class="text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-bold">Registrar</a>

            </div>

            @endauth

            {{-- MOBILE MENU --}}
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button x-on:click="open=true" type="button"
                    class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="open" x-on:click.away="open = false" class="md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            @auth
            <a href="{{ route('dashboard') }}"
                class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-bold"
                aria-current="page">Dashboard</a>
            @endauth
            <a href="{{ route('web.home') }}"
                class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-bold">Inicio</a>

            <div x-data="{ mobil: false }">
                <div x-on:click="mobil=true" href="#"
                    class="flex justify-between items-center bg-gray-900 text-white hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-bold">
                    Plataformas
                    <svg x-on:click="mobil = true" class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>

                <div x-show="mobil" x-on:click.away="mobil = false">
                    <a href="{{ route('plataforma.basica') }}"
                        class="bg-gray-900 text-white hover:bg-gray-600 hover:text-white block px-5 py-1 my-1 ml-3 rounded-md text-base font-bold">Basica</a>
                    <a href="{{ route('plataforma.premium') }}"
                        class="bg-gray-900 text-white hover:bg-gray-600 hover:text-white block px-5 py-1 my-1 ml-3 rounded-md text-base font-bold">Premium</a>
                </div>
            </div>

            <a href="{{ route('usos') }}"
                class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-bold">Usos
            </a>

            <a href="{{ route('servicios') }}"
                class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Soluciones/Productos</a>
            <a href="{{ route('contacto') }}"
                class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Contacto</a>
        </div>
        @auth
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center px-5">
                {{-- FOTO PERFIL --}}
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium leading-none text-white">Jhamner Sifuentes</div>
                    <div class="text-base font-medium leading-none text-gray-400">soporte@talentustechnology.com</div>
                </div>
                <button type="button"
                    class="ml-auto bg-gray-800 flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Ver Notificaciones</span>
                    <!-- Heroicon name: outline/bell -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
            </div>
            <div class="mt-3 px-2 space-y-1">
                <a href="{{route('profile.show')}}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Tu
                    Perfil</a>

                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Ajustes</a>
                <a href="{{route('admin.home')}}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Sistema</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
                        onclick="event.preventDefault(); this.closest('form').submit();">Salir
                    </a>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-3 border-t border-gray-700">

            <a href="{{route('login')}}"
                class="text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-medium">
                Ingresar
            </a>
            <a href="{{route('register')}}"
                class="text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 rounded-md text-base font-medium">Registrar</a>

        </div>
        @endauth
    </div>
</nav>