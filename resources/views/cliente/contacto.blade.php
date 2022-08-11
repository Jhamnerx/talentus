<x-app-layout>

    @section('contenido')
        <div class="page-wrapper">

            <x-navigation></x-navigation>

            <section class="page-header">
                <div class="container">
                    <h2>Contacto</h2>
                    <ul class="list-unstyled thm-breadcrumb">
                        <li><a href="{{ route('web.home') }}">Inicio</a></li>
                        <li><span>Contacto</span></li>
                    </ul>
                </div>
            </section>



            <section class="contact-info-one">
                <div class="container">
                    <img src="{{ asset('images/contact-info-shape-1-1.png') }}" class="contact-info-one__bg-shape-1"
                        alt="">

                    <div class="block-title text-center">
                        <div class="block-title__line"></div>
                        <h3>Contacta con nosotros para cualquier ayuda</h3>
                        <p>Envianos tus consultas, te responderemos lo mas pronto posible.</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="contact-info-one__single">
                                <div class="contact-info-one__icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="contact-info-one__content">
                                    <h3>Llamanos:</h3>
                                    <h4><a href="tel:977794338">+51 977 794 338</a></h4>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-info-one__single">
                                <div class="contact-info-one__icon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="contact-info-one__content">
                                    <h3>Correo para cualquier ayuda:</h3>
                                    <h4><a href="mailto:info@seolight.com">soporte@talentustechnology.com</a></h4>
                                    <p>Envia tus consultas o problemas presentados en algunos de nuestros servicios.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-info-one__single">
                                <div class="contact-info-one__icon">
                                    <i class="fa fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-info-one__content">
                                    <h3>Ubicacion:</h3>
                                    <h4>Calle Santa María Nº 209, Cajamarca.</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="contact-one">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="col-lg-6">

                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3141.908161504803!2d-78.49665951747681!3d-7.17720878945567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91b25b3d8ab39def%3A0x1e4e3e532f57935b!2sTalentus%20Technology!5e0!3m2!1ses!2spe!4v1656945983178!5m2!1ses!2spe"
                                style="border:0;" class="google-map__contact" allowfullscreen loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-lg-6">
                            <form action="{{ route('contact.form') }}" class="contact-one__form contact-form-validated">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Nombre" name="name">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Email" name="email">
                                    </div>
                                    <div class="col-md-12">
                                        <select name="option" class="selectpicker">
                                            <option value="1">Problema con servicio</option>
                                            <option value="2">Consulta de servicio</option>

                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="body" placeholder="Cuentanos un poco.."></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="thm-btn contact-one__btn">Enviar</button>
                                    </div>
                                </div>
                            </form>
                            <div class="result"></div>
                        </div>
                    </div>
                </div>
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
