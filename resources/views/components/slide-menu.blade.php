<div class="side-menu__block">


    <div class="side-menu__block-overlay custom-cursor__overlay">
        <div class="cursor"></div>
        <div class="cursor-follower"></div>
    </div><!-- /.side-menu__block-overlay -->
    <div class="side-menu__block-inner ">
        <div class="side-menu__top justify-content-end">

            <a href="javascript:void(0);" class="side-menu__toggler side-menu__close-btn"><img
                    src="{{ asset('images/close-1-1.png') }}" alt=""></a>
        </div><!-- /.side-menu__top -->


        <nav class="mobile-nav__container">
            <!-- content is loading via js -->
        </nav>
        <div class="side-menu__sep"></div><!-- /.side-menu__sep -->
        <div class="side-menu__content">
            <p></p>
            <p><a href="mailto:gerencia@talentustechnology.co">gerencia@talentustechnology.com</a> <br> <a
                    href="tel:+51977794338">51 977 794 338</a></p>
            <div class="">
                @guest
                    <div class="">
                        <a href="{{ route('login') }}" class="thm-btn main-nav__btn">Iniciar Sesión</a>
                        {{-- <a href="{{ route('register') }}" class="thm-btn main-nav__btn">Registrarse</a> --}}
                    </div>
                @endguest
                @auth
                    <!-- User button -->
                    <div class="relative inline-flex shadow-sm" x-data="{ open: false }">
                        <button class="inline-flex justify-center items-center group" aria-haspopup="true"
                            @click.prevent="open = !open" :aria-expanded="open">
                            <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profile_photo_url }}" width="32"
                                height="32" alt="User" />
                            <div class="flex items-center truncate">
                                <span
                                    class="truncate ml-2 text-sm font-medium group-hover:text-slate-500">{{ auth()->user()->name }}.</span>
                                <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" viewBox="0 0 12 12">
                                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                </svg>
                            </div>
                        </button>
                        <div class="origin-top-right z-10 absolute top-full right-0 min-w-44 bg-white border border-slate-200 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                            @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                            x-transition:enter="transition ease-out duration-200 transform"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" x-cloak>
                            <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-slate-200">
                                <div class="font-medium text-slate-800">{{ auth()->user()->name }}.</div>
                                <div class="text-xs text-slate-500 italic">Administrator</div>
                            </div>
                            <ul>
                                @role('cliente')
                                @else
                                    <li>
                                        <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                            href="{{ route('profile.show') }}" @click="open = false" @focus="open = true"
                                            @focusout="open = false">Perfil</a>
                                    </li>
                                @endrole

                                <li>
                                    <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                        href="{{ route('admin.home') }}" @click="open = false" @focus="open = true"
                                        @focusout="open = false">Panel de Control</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="font-medium text-sm text-indigo-500 hover:text-indigo-600 flex items-center py-1 px-3"
                                            href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            @click="open = false" @focus="open = true" @focusout="open = false">Cerrar
                                            Session</a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endauth
            </div>
        </div><!-- /.side-menu__content -->
    </div><!-- /.side-menu__block-inner -->
</div>
