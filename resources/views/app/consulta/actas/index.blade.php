<x-app-layout>

    @section('contenido')
        <div class="page-wrapper">

            <x-navigation></x-navigation>

            <section class="page-header">
                <div class="container">
                    <h2>Servicios</h2>
                    <ul class="list-unstyled thm-breadcrumb">
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="#">Servicios</a></li>
                        <li><span>Consulta de Actas</span></li>
                    </ul><!-- /.list-unstyled thm-breadcrumb -->
                </div><!-- /.container -->
            </section><!-- /.page-header -->



            <div class="py-6 w-full servicios">
                <div class="m-auto px-4 text-gray-800 md:px-4 xl:px-8">
                    <div class="block-title text-center">
                        <div class="block-title__line line-two"></div><!-- /.block-title__line -->
                        <h3>CONSULTA VALIDEZ <span>DE ACTAS</span></h3>
                        <p>Todas nuestras actas emitidas tienen un codigo unico, consulta su validez.</p>
                    </div>
                    <div class="mx-auto grid gap-6 lg:w-full lg:grid-cols-2">

                        <div class="bg-white w-full rounded-2xl shadow-xl px-8 py-12 sm:px-6 lg:px-8">

                            @livewire('app.consultas.acta.search', ['codigo_acta' => $codigo])


                            <div class="flex flex-wrap -mx-px overflow-hidden">

                                <div class="my-px px-px overflow-hidden">
                                    <img class="" src="{{ asset('images/acta_numero.png') }}" alt="">

                                </div>

                                <div class="my-px px-px  overflow-hidden">
                                    <img src="{{ asset('images/acta_codigo.png') }}" alt="">

                                </div>



                            </div>
                        </div>

                        <div class="bg-white  w-full rounded-2xl shadow-xl px-6 py-12 sm:px-4">
                            <div class="mb-12 space-y-4">
                                <h6 class="py-2 w-full  leading-4 mt-4 text-gray-600">INGRESA LOS
                                    DATOS Y HAZ CLICK EN BUSCAR</h6>
                                @livewire('app.consultas.acta.result-search')
                            </div>

                        </div>



                    </div>
                </div>
            </div>
            {{-- <div class="row">
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
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="1500ms"
                data-wow-delay="400ms">
                <div class="service-one__single">
                    <div class="service-one__icon color-1">
                        <i class="seolight-icon-one-finger-click"></i>
                    </div><!-- /.service-one__icon -->
                    <h3><a href="service-details.html">SMM Marketing</a></h3>
                    <p>Lorem ipsum dolor sit amet, contop ctetur adipisicing elit, sed do eius</p>
                    <a href="service-details.html" class="service-one__link">View more <i
                            class="fal fa-long-arrow-right"></i></a><!-- /.service-one__link -->

                </div><!-- /.service-one__single -->
            </div><!-- /.col-lg-3 -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="1500ms"
                data-wow-delay="500ms">
                <div class="service-one__single">
                    <div class="service-one__icon color-2">
                        <i class="seolight-icon-options"></i>
                    </div><!-- /.service-one__icon -->
                    <h3><a href="service-details.html">SEM Optimizations</a></h3>
                    <p>Lorem ipsum dolor sit amet, contop ctetur adipisicing elit, sed do eius</p>
                    <a href="service-details.html" class="service-one__link">View more <i
                            class="fal fa-long-arrow-right"></i></a><!-- /.service-one__link -->

                </div><!-- /.service-one__single -->
            </div><!-- /.col-lg-3 -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="1500ms"
                data-wow-delay="600ms">
                <div class="service-one__single">
                    <div class="service-one__icon color-3">
                        <i class="seolight-icon-settings"></i>
                    </div><!-- /.service-one__icon -->
                    <h3><a href="service-details.html">Content Analysis</a></h3>
                    <p>Lorem ipsum dolor sit amet, contop ctetur adipisicing elit, sed do eius</p>
                    <a href="service-details.html" class="service-one__link">View more <i
                            class="fal fa-long-arrow-right"></i></a><!-- /.service-one__link -->

                </div><!-- /.service-one__single -->
            </div><!-- /.col-lg-3 -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-duration="1500ms"
                data-wow-delay="700ms">
                <div class="service-one__single">
                    <div class="service-one__icon color-4">
                        <i class="seolight-icon-goal"></i>
                    </div><!-- /.service-one__icon -->
                    <h3><a href="service-details.html">Digital Marketing</a></h3>
                    <p>Lorem ipsum dolor sit amet, contop ctetur adipisicing elit, sed do eius</p>
                    <a href="service-details.html" class="service-one__link">View more <i
                            class="fal fa-long-arrow-right"></i></a><!-- /.service-one__link -->

                </div><!-- /.service-one__single -->
            </div><!-- /.col-lg-3 -->

        </div> --}}



            <x-planes>

            </x-planes>



            <section class="cta-one wow fadeInUp" data-wow-duration="1500ms">
                <div class="container ">
                    <div class="inner-container ">
                        <h3>Quieres comunicarte con <span>nosotros?</span></h3>

                        <div class="cta-one__btn-block">
                            <a href="{{ route('web.contacto') }}" class="thm-btn cta-one__btn">Escribenos</a>
                            <!-- /.thm-btn cta-one__btn -->
                        </div><!-- /.cta-one__btn-block -->
                    </div><!-- /.inner-container -->
                </div><!-- /.container -->
            </section><!-- /.cta-one -->


            <x-footer></x-footer>

            <x-slide-menu></x-slide-menu>
        </div><!-- /.page-wrapper -->
    @endsection

</x-app-layout>
