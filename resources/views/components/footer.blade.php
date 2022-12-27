<footer class="site-footer site-footer__two">

    <img src="{{asset('images/footer-bg-2-1.png')}}" class="site-footer__shape-2" alt="">
    <img src="{{asset('images/footer-bg-2-2.png')}}" class="site-footer__shape-3" alt="">
    <div class="site-footer__upper">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-1 col-md-6 col-sm-122">
                    <div class="footer-widget footer-widget__about">
                        <a href="{{route('web.home')}}" class="footer-widget__logo">
                            <img src="{{asset('images/logo-2-1.png')}}" alt="">
                        </a>
                        <p><br> Calle Santa María Nº 209, Cajamarca. <br> PERÚ</p>
                        <p><span>Horario: </span></p>
                        <p>Lunes - Sabado: 9 am - 7 pm, <br> Domingos: WhatsApp, Solo Emergencias</p>
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-xl-3 col-lg-1 col-md-6 col-sm-122 -->
                <div class="col-lg-5 col-md-12">
                    <div class="footer-widget footer-widget__links">
                        <h3 class="footer-widget__title"><span>Enlaces</span></h3><!-- /.footer-widget__title -->
                        <ul class="list-unstyled footer-widget__links-list">
                            <li><a href="{{route('web.home')}}">Inicio</a></li>
                            <li><a href="#">Servicios</a></li>
                            <li><a href="{{route('solicitudes', ['solicitud' => 'servicio'])}}">Solicitudes</a></li>
                            <li><a href="{{route('web.contacto')}}">Contactar</a></li>

                        </ul><!-- /.list-unstyled footer-widget__links-list -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-5 col-md-12 -->
                <div class="col-lg-4 col-md-12">
                    <div class="footer-widget footer-widget__newsletter">
                        <h3 class="footer-widget__title"><span>Boletin</span></h3>
                        <!-- /.footer-widget__title -->
                        <p>Recibir notificaciones y actualizaciones</p>
                        <form class="footer-widget__mc-form mc-form" data-url="MAILCHIMP__POPUP__FORM__URL">
                            <input type="text" name="email" placeholder="Your mail address">
                            <button type="submit"><i class="fal fa-paper-plane"></i></button>
                        </form><!-- /.footer-widget__mc-form -->
                        <div class="mc-form__response"></div><!-- /.mc-form__response -->
                        <div class="footer-widget__social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-dribbble"></i></a>
                            <a href="#"><i class="fab fa-behance"></i></a>
                        </div><!-- /.footer-widget__social -->
                    </div><!-- /.footer-widget -->
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.site-footer__upper -->
    <div class="site-footer__bottom">
        <div class="container text-center">
            <p>{{date('y-m-d')}} Todos los Derechos Reservados a <a href="https://talentustechnology.com/">Talentus
                    Technology</a></p>
        </div><!-- /.container -->
    </div><!-- /.site-footer__bottom -->
</footer><!-- /.site-footer -->
