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
                        <li><span>Consulta de Transmisiones</span></li>
                    </ul>
                </div>
            </section>

            <div class="py-6 w-full servicios">
                <div class="container mx-auto px-4 text-gray-800">
                    <div class="block-title text-center">
                        <div class="block-title__line line-two"></div>
                        <h3>CONSULTA TRANMISION</span></h3>
                    </div>
                    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                        <div class="bg-white w-full rounded-2xl shadow-xl px-8 py-12 sm:px-6 lg:px-8">
                            @livewire('app.consultas.transmision.consulta-placa')
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
