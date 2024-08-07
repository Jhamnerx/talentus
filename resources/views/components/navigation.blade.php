<section class="main-header-wrapper">
    <div class="topbar-one">
        <div class="container">
            <div class="topbar-one__left">
                <p><i class="fa fa-map-marker"></i>Calle Santa María Nº 209, Cajamarca - Perú</p>
            </div>
            <div class="topbar-one__right">
                <p><i class="fa fa-clock"></i>Horario: Lunes - Sabado: 9 am - 7 pm, Domingos: Solo WhatsApp
                    Urgencias</p>
            </div>
        </div>
    </div>
    <header class="site-header-one stricky site-header-two ">
        <div class="container">
            <div class="inner-container">
                <div class="site-header-one__logo">
                    <a href="{{ route('web.home') }}">
                        <img src="{{ asset('images/logo-2-1.png') }}" alt="">
                    </a>
                    <a href="javascript:void(0);" class="side-menu__toggler"><i class="fa fa-bars"></i></a>
                </div>
                <div class="main-nav__main-navigation">
                    <ul class="main-nav__navigation-box">
                        <li>
                            <a href="{{ route('web.home') }}">Inicio</a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0)">Servicios</a>
                            <ul>
                                <li>
                                    <a id="consulta" href="{{ route('consulta.actas') }}">
                                        Consulta Actas
                                    </a>
                                </li>
                                <li>
                                    <a id="consulta_certificado" href="{{ route('consulta.certificado') }}">
                                        Consulta Certificados
                                    </a>
                                </li>
                                <li>
                                    <a id="consulta_velocimetro" href="{{ route('consulta.certificado.velocimetro') }}">
                                        Consulta Cert. Velocimetro
                                    </a>
                                </li>
                                {{-- <li><a href="{{ route('consulta.vehiculos') }}">Consulta Vehiculos</a></li> --}}
                                {{-- <li><a href="{{ route('solicitudes') }}">Solicitar Reporte</a></li> --}}
                            </ul>
                        </li>
                        <li id="solicitudes" class="dropdown">
                            <a href="javascript:void(0)">Solicitudes</a>
                            <ul>
                                <li><a href="{{ route('solicitudes', ['solicitud' => 'servicio']) }}">Solicitar
                                        Servicio</a></li>
                                <li><a href="{{ route('solicitudes', ['solicitud' => 'reporte']) }}">Solicitar
                                        Reporte</a></li>

                                {{-- <li><a href="{{ route('web.faq') }}">Preguntas Frecuentes</a></li> --}}
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('manuales.plataforma') }}">Manual Plataforma</a>
                        </li>
                        <li>
                            <a href="{{ route('web.contacto') }}">Contactar</a>
                        </li>
                    </ul>
                </div>
                @guest
                    <div class="main-nav__right">
                        <a href="{{ route('login') }}" class="thm-btn main-nav__btn">Iniciar Sesion</a>
                        {{-- <a href="{{ route('register') }}" class="thm-btn main-nav__btn">Registrarse</a> --}}
                    </div>
                @endguest

                @auth
                    <div class="relative sm:inline-flex shadow-sm hidden" x-data="{ open: false }">
                        <button class="inline-flex justify-center items-center group" aria-haspopup="true"
                            @click.prevent="open = !open" :aria-expanded="open">
                            <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profile_photo_url }}" width="32"
                                height="32" alt="User" />
                            <div class="flex items-center truncate">
                                <span
                                    class="truncate ml-2 text-sm font-medium group-hover:text-slate-600">{{ auth()->user()->name }}.</span>
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
        </div>
    </header>

</section>
