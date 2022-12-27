<x-app-layout>

    @section('contenido')
    {{-- componente de bienvenida --}}

    {{--
    <x-welcome />

    <x-cards /> --}}

    <div class="page-wrapper">

        @livewire('navigation')

        <section class="banner-two">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="banner-two__content">
                            <h3>
                                BIENVENIDO A TALENTUS APP
                            </h3>
                            <p>Podras encontrar diversar soluciones, desde consulta de duración y validez de actas, tus
                                vehiculos
                                y actualizar tus datos.</p>
                            <div class="banner-two__btn-block">
                                <a href="" class="thm-btn banner-two__btn-1">Plataforma Premium</a>
                                <!-- /.thm-btn banner-two__btn-1 -->
                                <a href="" class="thm-btn banner-two__btn-2">Plataforma Basica</a>
                                <!-- /.thm-btn banner-two__btn-2 -->
                            </div><!-- /.banner-two__btn-block -->
                        </div><!-- /.banner-two__content -->
                    </div><!-- /.col-lg-8 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.banner-two -->

        <section class="service-five">

            <div class="container">
                <img src="{{ asset('images/banner-2-moc-1.png') }}" class="service-five__moc-1 float-bob-y-2" alt="">
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
                <img src="{{ asset('images/service-4-shape-1.png') }}" class="service-four__image-1" alt="">
                <img src="images/service-moc-4-1.png" class="service-four__image-2 float-bob-y-2" alt="">
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

        <x-planes></x-planes>




        <x-footer></x-footer>


    </div><!-- /.page-wrapper -->
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>


    <x-slide-menu></x-slide-menu>
    @endsection



</x-app-layout>
