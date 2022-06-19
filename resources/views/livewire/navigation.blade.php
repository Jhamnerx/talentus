<header class="site-header-one site-header-three stricky ">
    <div class="container">
        <div class="site-header-one__logo">
            <a href="">
                <img src="images/logo-2-1.png" alt="">
            </a>
            <a href="javascript:void(0);" class="side-menu__toggler"><i class="fa fa-bars"></i></a>
        </div><!-- /.site-header-one__logo -->
        <div class="main-nav__main-navigation">
            <ul class="main-nav__navigation-box">
                <li class="current">
                    <a href="">Inicio</a>

                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">Servicios</a>
                    <ul>
                        <li><a href="{{route('consulta.actas')}}">Consulta Actas</a></li>
                        <li><a href="{{route('consulta.vehiculos')}}">Consulta Vehiculos</a></li>
                        <li><a href="{{route('solicitudes.create')}}">Solicitar Reporte</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Solicitudes</a>
                    <ul>
                        <li><a href="{{route('solicitudes.create')}}">Solicitar Servicio</a></li>
                        <li><a href="{{route('web.faq')}}">Preguntar Frecuentes</a></li>
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
                    <a href="{{route('web.contacto')}}">Contactar</a>
                </li>

            </ul><!-- /.main-nav__navigation-box -->
        </div><!-- /.main-nav__main-navigation -->
        <div class="main-nav__right">
            <a href="{{route('login')}}" class="thm-btn main-nav__btn">Registrarse</a>
        </div><!-- /.main-nav__right -->
    </div><!-- /.container -->
</header><!-- /.site-header-one -->