<x-app-layout>

    @section('contenido')
    {{-- componente de bienvenida --}}

    {{--
    <x-welcome />

    <x-cards /> --}}

    <div class="page-wrapper navigation-test">


        <header class="site-header-one site-header-three stricky ">
            <div class="container">
                <div class="site-header-one__logo">
                    <a href="{{ route('web.home') }}">

                        <img src="{{ Vite::asset('resources/images/cliente/logo-2-1.png') }}" alt="">
                    </a>
                    <a href="javascript:void(0);" class="side-menu__toggler"><i class="fa fa-bars"></i></a>
                </div><!-- /.site-header-one__logo -->
                <div class="main-nav__main-navigation">
                    <ul class="main-nav__navigation-box">
                        <li class="current">
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
                        <li class="dropdown">
                            <a href="#">Solicitudes</a>
                            <ul>
                                <li><a href="{{ route('solicitudes', ['solicitud' => 'servicio']) }}">Solicitar
                                        Servicio</a>
                                </li>
                                <li><a href="{{ route('solicitudes', ['solicitud' => 'reporte']) }}">Solicitar
                                        Reporte</a></li>

                                {{-- <li class="dropdown">
                                    <a href="team.html">Team</a>
                                    <ul>
                                        <li><a href="team.html">Team</a></li>
                                        <li><a href="team-details.html">Team Details</a></li>
                                    </ul>
                                </li> --}}

                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('manuales.plataforma') }}">Manual Plataforma</a>
                        </li>
                        <li>
                            <a href="{{ route('web.contacto') }}">Contactar</a>
                        </li>

                    </ul><!-- /.main-nav__navigation-box -->
                </div><!-- /.main-nav__main-navigation -->
                @guest
                <div class="main-nav__right">
                    <a href="{{ route('login') }}" class="thm-btn main-nav__btn">Iniciar Sesion</a>
                    {{-- <a href="{{ route('register') }}"
                        class="thm-btn main-nav__btn hidden sm:inline-block lg:inline-block">Registrarse</a> --}}
                </div>
                @endguest

                @auth
                <!-- User button -->
                <div class="relative hidden sm:inline-flex shadow-sm" x-data="{ open: false }">
                    <button class="inline-flex justify-center items-center group" aria-haspopup="true"
                        @click.prevent="open = !open" :aria-expanded="open">
                        <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profile_photo_url }}" width="32"
                            height="32" alt="User" />
                        <div class="flex items-center truncate">
                            <span class="truncate ml-2 text-white text-sm font-medium group-hover:text-slate-200">{{
                                auth()->user()->name }}.</span>
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

                <!-- /.main-nav__right -->
            </div><!-- /.container -->
        </header>


        <section class="banner-two">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="banner-two__content">
                            <h3>
                                BIENVENIDO A TALENTUS
                            </h3>
                            <p>Podras encontrar diversar soluciones, desde consulta de duración y validez de actas, tus
                                vehiculos
                                y actualizar tus datos.</p>
                            <div class="banner-two__btn-block">
                                <a href="https://plataforma.talentustechnology.com/" target="_blank"
                                    class="thm-btn banner-two__btn-1">Plataforma Talentus Track</a>
                                <!-- /.thm-btn banner-two__btn-1 -->
                                <a href="https://play.google.com/store/apps/details?id=com.talentus.usuariosandroid"
                                    target="_blank" class="thm-btn banner-two__btn-2">App Plataforma</a>
                                <!-- /.thm-btn banner-two__btn-2 -->
                            </div><!-- /.banner-two__btn-block -->
                        </div><!-- /.banner-two__content -->
                    </div><!-- /.col-lg-8 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.banner-two -->

        <section class="service-five">

            <div class="container">
                <img src="{{ Vite::asset('resources/images/cliente/banner-2-moc-1.png') }}"
                    class="service-five__moc-1 float-bob-y-2" alt="">
                <div class="row">
                    <div class="col-lg-4 wow fadeInUp" data-wow-duration="1500ms">
                        <div class="service-five__box">
                            <div class="service-five__icon">
                                <div class="service-five__icon-bubble"></div>

                                <i class="far fa-file"></i>
                            </div>
                            <h3><a href="{{ route('consulta.actas') }}">CONSULTA DE ACTAS</a></h3>
                            <p>Consulta la validez y los detalles de nuestras actas emitidas. </p>
                            <a href="{{ route('consulta.actas') }}" class="service-five__link"><span>+</span></a>

                        </div>
                    </div>

                    <div class="col-lg-4 wow fadeInUp" data-wow-duration="1500ms">
                        <div class="service-five__box">
                            <div class="service-five__icon">
                                <div class="service-five__icon-bubble"></div>

                                <i class="far fa-file"></i>
                            </div>
                            <h3><a href="{{ route('consulta.certificado') }}">CONSULTA DE CERTIFICADOS</a></h3>
                            <p>Consulta la validez y los detalles de certificados emitidos. </p>
                            <a href="{{ route('consulta.certificado') }}" class="service-five__link"><span>+</span></a>

                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- CARD --}}

                    <div class="col-lg-4 wow fadeInUp" data-wow-duration="1500ms">
                        <div class="service-five__box">
                            <div class="service-five__icon">
                                <div class="service-five__icon-bubble"></div>

                                <i class="far fa-file"></i>
                            </div>
                            <h3><a href="{{ route('consulta.certificado.velocimetro') }}">CONSULTA DE CERTIFICADOS
                                    VELOCIMETROS</a>
                            </h3>
                            <p>Consulta la validez y los detalles de certificados velocimetros emitidos. </p>
                            <a href="{{ route('consulta.certificado.velocimetro') }}"
                                class="service-five__link"><span>+</span></a>

                        </div>
                    </div>

                    <div class="col-lg-4 wow fadeInUp" data-wow-duration="1500ms">
                        <div class="service-five__box active">
                            <div class="service-five__icon">
                                <div class="service-five__icon-bubble"></div>
                                <i class="fas fa-car-crash"></i>
                            </div>
                            <h3><a href="{{ route('solicitudes', ['solicitud' => 'reporte']) }}">SOLICITAR REPORTE</a>
                            </h3>
                            <p>Crea una solicitud de reporte, de tus unidades en nuestro sistema. </p>
                            <a href="{{ route('solicitudes', ['solicitud' => 'reporte']) }}"
                                class="service-five__link"><span>+</span></a>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="service-four">

            <div class="service-four__images wow fadeInLeft" data-wow-duration="1500ms">
                <img src="{{ Vite::asset('resources/images/cliente/shapes/service-4-shape-1.png') }}"
                    class="service-four__image-1" alt="">
                <img src="{{ Vite::asset('resources/images/cliente/service-moc-4-1.png') }}"
                    class="service-four__image-2 float-bob-y-2" alt="">
            </div><!-- /.service-four__images -->
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-8">
                        <div class="service-four__content">
                            <div class="block-title text-left">
                                <div class="block-title__line"></div><!-- /.block-title__line -->
                                <h3>PREGUNTAS <span>frecuentes</span></h3>
                                <p>Aqui responderemos algunas preguntas más frecuentes que nos hacen nuestros clientes.
                                </p>
                            </div><!-- /.block-title text-center -->
                            <div class="service-four__box">
                                <i class="seolight-icon-bank-building"></i>
                                <h3><a href="#">Cobertura</a></h3>
                                <p>Nuestra cobertura a es Nivel Nacional.</p>
                            </div><!-- /.service-four__box -->
                            <div class="service-four__box">
                                <i class="seolight-icon-tracking"></i>
                                <h3><a href="#">Cúales son los planes?</a></h3>
                                <p>Contamos con diversos planes que se ajustan a la necesidades de nuestros clientes.
                                </p>
                            </div><!-- /.service-four__box -->
                        </div><!-- /.service-four__content -->
                    </div><!-- /.col-lg-8 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.service-four -->

        {{-- <section class="service-one">
            <img src="images/service-2-shape.png" class="service-one__shape-1" alt="">
            <div class="container">
                <div class="block-title text-center">
                    <div class="block-title__line"></div><!-- /.block-title__line -->
                    <h3>Full Service Digital Marketing <span>agency</span></h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do <br> eiusmod tempor incididunt ut
                        labore et dolore.</p>
                </div><!-- /.block-title text-center -->

                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="1500ms"
                        data-wow-delay="000ms">
                        <div class="service-one__single">
                            <div class="service-one__icon color-1">
                                <i class="seolight-icon-pie-chart"></i>
                            </div><!-- /.service-one__icon -->
                            <h3><a href="service-details.html">Online Analysis</a></h3>
                            <p>Lorem ipsum dolor sit amet, contop ctetur adipisicing elit, sed do eius</p>
                            <a href="service-details.html" class="service-one__link">View more <i
                                    class="fal fa-long-arrow-right"></i></a><!-- /.service-one__link -->

                        </div><!-- /.service-one__single -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="1500ms"
                        data-wow-delay="100ms">
                        <div class="service-one__single">
                            <div class="service-one__icon color-2">
                                <i class="seolight-icon-layers"></i>
                            </div><!-- /.service-one__icon -->
                            <h3><a href="service-details.html">Web Design</a></h3>
                            <p>Lorem ipsum dolor sit amet, contop ctetur adipisicing elit, sed do eius</p>
                            <a href="service-details.html" class="service-one__link">View more <i
                                    class="fal fa-long-arrow-right"></i></a><!-- /.service-one__link -->

                        </div><!-- /.service-one__single -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="1500ms"
                        data-wow-delay="200ms">
                        <div class="service-one__single">
                            <div class="service-one__icon color-3">
                                <i class="seolight-icon-browser"></i>
                            </div><!-- /.service-one__icon -->
                            <h3><a href="service-details.html">Web Development</a></h3>
                            <p>Lorem ipsum dolor sit amet, contop ctetur adipisicing elit, sed do eius</p>
                            <a href="service-details.html" class="service-one__link">View more <i
                                    class="fal fa-long-arrow-right"></i></a><!-- /.service-one__link -->

                        </div><!-- /.service-one__single -->
                    </div><!-- /.col-lg-3 -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="1500ms"
                        data-wow-delay="300ms">
                        <div class="service-one__single">
                            <div class="service-one__icon color-4">
                                <i class="seolight-icon-target"></i>
                            </div><!-- /.service-one__icon -->
                            <h3><a href="service-details.html">SEO Marketing</a></h3>
                            <p>Lorem ipsum dolor sit amet, contop ctetur adipisicing elit, sed do eius</p>
                            <a href="service-details.html" class="service-one__link">View more <i
                                    class="fal fa-long-arrow-right"></i></a><!-- /.service-one__link -->

                        </div><!-- /.service-one__single -->
                    </div><!-- /.col-lg-3 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section> --}}

        <x-cliente.planes></x-cliente.planes>




        <x-cliente.footer>
            </x-cliente.-footer>


    </div><!-- /.page-wrapper -->
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>


    <x-cliente.slide-menu></x-cliente.slide-menu>
    @endsection



</x-app-layout>