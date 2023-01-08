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
                    <li><span>Consulta de Certificados</span></li>
                </ul>
            </div>
        </section>

        <div class="py-6 w-full servicios">
            <div class="m-auto px-4 text-gray-800 md:px-4 xl:px-8">
                <div class="block-title text-center">
                    <div class="block-title__line line-two"></div>
                    <h3>CONSULTA VALIDEZ <span>DE CERTIFICADO VELOCIMETRO</span></h3>
                    <p>Todas nuestros certificados emitidos tienen un codigo unico, consulta su validez.</p>
                </div>
                <div class="mx-auto grid gap-6 lg:w-full lg:grid-cols-2">

                    <div class="bg-white w-full rounded-2xl shadow-xl px-8 py-12 sm:px-6 lg:px-8">

                        @livewire('app.consultas.certificados.velocimetro-search', ['codigo_certificado' => $codigo])

                        <div class="flex flex-wrap -mx-px overflow-hidden">

                            <div class="my-px px-px overflow-hidden">
                                <img class="" src="{{ asset('images/acta_numero.png') }}" alt="">

                            </div>

                            <div class="my-px px-px  overflow-hidden">
                                <img src="{{ asset('images/acta_codigo.png') }}" alt="">

                            </div>



                        </div>
                    </div>

                    <div class="bg-white w-full rounded-2xl shadow-xl px-6 py-12 sm:px-4">
                        <div class="mb-12 space-y-4">
                            <h6 class="py-2 w-full  leading-4 mt-4 text-gray-600 dark:text-gray-300">INGRESA LOS
                                DATOS Y HAZ CLICK EN BUSCAR</h6>
                            @livewire('app.consultas.certificados.result-velocimetro-search')
                        </div>

                    </div>

                </div>
            </div>
        </div>


        <x-planes>

        </x-planes>



        <section class="cta-one wow fadeInUp" data-wow-duration="1500ms">
            <div class="container ">
                <div class="inner-container ">
                    <h3>Quieres comunicarte con <span>nosotros?</span></h3>

                    <div class="cta-one__btn-block">
                        <a href="{{ route('web.contacto') }}" class="thm-btn cta-one__btn">Escribenos</a>

                    </div>
                </div>
            </div>
        </section>


        <x-footer></x-footer>

        <x-slide-menu></x-slide-menu>
    </div>
    @endsection

</x-app-layout>
