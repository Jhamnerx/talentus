<section class="main-header-wrapper">
    <div class="topbar-one">
        <div class="container">
            <div class="topbar-one__left">
                <p><i class="fa fa-map-marker"></i>Calle Santa María Nº 209, Cajamarca - Perú</p>
            </div><!-- /.topbar-one__left -->
            <div class="topbar-one__right">
                <p><i class="fa fa-clock"></i>Horario: Lunes - Sabado: 9 am - 7 pm, Domingos: Solo WhatsApp
                    Urgencias</p>
            </div><!-- /.topbar-one__right -->
        </div><!-- /.container -->
    </div><!-- /.topbar-one -->
    <header class="site-header-one stricky site-header-two ">
        <div class="container">
            <div class="inner-container">
                <div class="site-header-one__logo">
                    <a href="{{route('web.home')}}">
                        <img src="{{asset('images/logo-2-1.png')}}" alt="">
                    </a>
                    <a href="#" class="side-menu__toggler"><i class="fa fa-bars"></i></a>
                </div><!-- /.site-header-one__logo -->
                <div class="main-nav__main-navigation">
                    <ul class="main-nav__navigation-box">
                        <li>
                            <a href="{{route('web.home')}}">Inicio</a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0)">Servicios</a>
                            <ul>
                                <li><a id="consulta" href="{{route('consulta.actas')}}">Consulta Actas</a></li>
                                <li><a href="{{route('consulta.vehiculos')}}">Consulta Vehiculos</a></li>
                                <li><a href="{{route('solicitudes.create')}}">Solicitar Reporte</a></li>
                            </ul>
                        </li>
                        <li id="solicitudes" class="dropdown">
                            <a href="javascript:void(0)">Solicitudes</a>
                            <ul>
                                <li><a href="{{route('solicitudes.create')}}">Solicitar Reporte</a></li>
                                <li><a href="{{route('web.faq')}}">Preguntas Frecuentes</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{route('web.contacto')}}">Contactar</a>
                        </li>
                        <li class="search-btn search-popup__toggler">
                            <a href="#"><i class="fa fa-search"></i></a>
                        </li>
                    </ul><!-- /.main-nav__navigation-box -->
                </div><!-- /.main-nav__main-navigation -->
                <div class="main-nav__right">
                    <a href="tel:+51977794338" class="header-cta-btn">
                        <i class="seolight-icon-phone-circle"></i>
                        <span>(24 horas / 7 dias)</span>
                        <strong>+51 977 794 338</strong>
                    </a><!-- /.header-cta-btn -->
                </div><!-- /.main-nav__right -->
            </div><!-- /.inner-container -->
        </div><!-- /.container -->
    </header><!-- /.site-header-one -->

</section><!-- /.main-header-wrapper -->