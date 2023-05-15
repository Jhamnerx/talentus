<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon2023.png') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->

    <link rel="stylesheet" href="{{ mix('css/cliente/cliente.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">


    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">


    @livewireStyles

    <!-- Scripts -->

    <!-- Alpine Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine Core -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="font-sans antialiased">
    <x-jet-banner />


    {{-- @livewire('navigation') --}}



    <!-- Page Content -->
    <main class="min-h-full">

        @yield('contenido')


    </main>



    {{--
    <x-footer /> --}}

    @stack('modals')

    @livewireScripts

    @yield('js')



    <script src="{{ mix('js/cliente.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('plugins/isotope.js') }}"></script>
    <script src="{{ asset('plugins/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('plugins/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('plugins/TweenMax.min.js') }}"></script>
    <script src="{{ asset('plugins/input-case-enforcer/input-case-enforcer.min.js') }}"></script>
    <script src="{{ asset('plugins/wow.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>

    @stack('scripts')

    <script>
        window.addEventListener('save-review', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'GRACIAS POR TU RESPUESTAS',
                    text: 'Estamos comprometidos a ayudarte!',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });

        })
    </script>
</body>

</html>
