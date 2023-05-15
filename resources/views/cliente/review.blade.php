<x-app-layout>

    @section('contenido')
        <div class="page-wrapper">

            <x-navigation></x-navigation>

            <section class="page-header">
                <div class="container">
                    <h2>Sugerencias</h2>
                    <ul class="list-unstyled thm-breadcrumb">
                        <li><a href="{{ route('web.home') }}">Inicio</a></li>
                        <li><span>Sugerencias</span></li>
                    </ul>
                </div>
            </section>



            <section class="contact-info-one">
                <div class="container">
                    <img src="{{ asset('images/contact-info-shape-1-1.png') }}" class="contact-info-one__bg-shape-1"
                        alt="">

                    <div class="block-title text-center">
                        <div class="block-title__line"></div>
                        <h3>Encuesta de calidad a clientes, para mejora de servicio.</h3>
                        <p>Responde estas preguntas que nos ayudaran a seguir mejorando.</p>
                    </div>

                </div>
            </section>



            <div class="contents order-2 order-md-1">

                @livewire('cliente.formularios.review')

            </div>



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
