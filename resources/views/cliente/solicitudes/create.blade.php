<x-app-layout>

    @section('contenido')
    <div class="page-wrapper">

        <x-navigation></x-navigation>

        <section class="page-header">
            <div class="container">
                <h2>Solicitudes</h2>
                <ul class="list-unstyled thm-breadcrumb">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="#">Solicitudes</a></li>
                    <li><span></span></li>
                </ul>
            </div>
        </section>



        <div class="py-6 w-full servicios">
            <div class="m-auto px-4 text-gray-800 md:px-4 xl:px-8">
                <div class="block-title text-center">
                    <div class="block-title__line line-two"></div>
                    <h3>SOLICITUD DE <span>SERVICIO O REPORTE</span></h3>
                    <p>Solicita el reporte de una unidad o solicita contratar un servicio.</p>
                </div>
                <div
                    class="mx-auto flex justify-center lg:w-full bg-white w-full rounded-2xl shadow-xl px-8 py-12 sm:px-6 lg:px-8">
                    <div class="w-1/4"></div>
                    @livewire('app.solicitudes.create-form', ['tipo_solicitud' => $solicitud])

                    <div class="w-1/4"></div>

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
                        <!-- /.thm-btn cta-one__btn -->
                    </div><!-- /.cta-one__btn-block -->
                </div><!-- /.inner-container -->
            </div><!-- /.container -->
        </section><!-- /.cta-one -->

        <x-footer></x-footer>

        <x-slide-menu></x-slide-menu>
    </div><!-- /.page-wrapper -->
    @endsection

    @section('js')
    <script>
        window.addEventListener('solicitud-send', event => {
                iziToast.success({
                    position: 'topRight',
                    title: 'SOLICITUD ENVIADA',
                    message: 'Tu solicitud fue enviada en breve te responderemos',
                });

            })
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
        // Your code to run since DOM is loaded and ready
            flatpickr('.fecha', {
                mode: 'single',
                dateFormat: "Y-m-d",
                prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
            });
        });

    </script>
    @endsection
</x-app-layout>
