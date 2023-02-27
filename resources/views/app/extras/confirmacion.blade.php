<x-app-layout>

    @section('contenido')
    <div class="page-wrapper">

        <x-navigation></x-navigation>



        <section class="">

            @livewire('app.extras.confirmacion-tarea', ['tarea' => $tarea, 'page'=>request()->fullUrl()])


        </section>



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
