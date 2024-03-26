<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="frame-src 'self'">
    <link rel="icon" href="{{ asset('images/favicon2023.png') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @vite('resources/css/style.scss')
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
    @yield('css')


    {{-- plugins --}}
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    {{-- CKEDITOR --}}
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>

    @livewireStyles
    <wireui:scripts />
</head>

<body class="font-inter antialiased bg-slate-200 text-slate-600" :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ page: '@yield('ruta')', @yield('panel') sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true', profileSidebarOpen: false }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">


    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>

    <!-- Page wrapper -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        @livewire('admin.sidebar')

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-slate-50 dark:bg-gray-800">

            <!-- Site header -->
            @livewire('admin.header', ['page' => request()->fullUrl()])

            <x-jet-banner />

            <header class="sticky top-0 md:hidden bg-white border-b border-slate-200 z-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center h-16 -mb-px">

                        <div class="hover text-left mx-2">
                            <p class="text-talentus-200 text-wrap ">EMPRESA: <b
                                    class="hover:text-talentus-200">{{ \App\Models\plantilla::first()->razon_social }}</b>
                            </p>
                        </div>

                    </div>
                </div>
            </header>

            <x-admin.comprobantes />

            <main>


                @yield('contenido')

            </main>

        </div>

    </div>

    @stack('modals')

    @livewireScripts


</body>
<script>
    $(document).ready(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            //width: 600,
            //padding: "3em",
            showConfirmButton: false,
            timer: 2200,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });
        Echo.private('App.Models.User.' + {{ Auth::user()->id }})
            .notification((notification) => {
                Livewire.emit('notificaciones-update');

            });

    });
</script>
<script>
    // Livewire.onPageExpired((response, message) => {
    //     console.log('pagina expirada')

    // })
</script>
<script>
    document.addEventListener('livewire:initialized', () => {
        //success
        //question
        //info
        //warning
        //error
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });


        Livewire.on('notify-toast', (event) => {
            Toast.fire({
                icon: event.icon,
                title: `<div  style="font-size: 15px; color: #052c52;"> ` +
                    event.title + `</div`,
                html: `<div  style="font-size: 14px; color: #056b85;"> ` +
                    event.mensaje + `</div`,
                showCloseButton: true,
            });

        });


        Livewire.on('error', (event) => {
            Toast.fire({
                icon: 'error',
                title: event.title,
                html: event.mensaje,
                showCloseButton: true,
            });

        });

        Livewire.on('notify', (event) => {
            Swal.fire({
                icon: event.icon,
                title: event.title,
                text: event.mensaje,
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })

        });

        Livewire.on('suspend-save', (event) => {
            iziToast.success({
                maxWidth: 500,
                position: 'center',
                title: 'Se ha guardado el registro de suspencion!',
                message: 'Las siguientes Lineas: ' + event.lista,
                position: 'topRight',
                transitionIn: 'bounceInLeft',
                // iconText: 'star',
                onOpened: function(instance, toast) {},
                onClosed: function(instance, toast, closedBy) {
                    console.info('closedBy: ' + closedBy);
                }
            });

        });



    });
</script>
@yield('js')

@stack('scripts')

@if (session('venta-registrada'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'VENTA REGISTRADA',
                text: '{{ session('venta-registrada') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif
@if (session('cobro-registrado'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'REGISTRO DE COBRO REGISTRADO',
                text: '{{ session('cobro-registrado') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif
@if (session('cotizacion-registrada'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'COTIZACION REGISTRADA',
                text: '{{ session('cotizacion-registrada') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif

@if (session('cotizacion-actualizada'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'COTIZACION ACTUALIZADA',
                text: '{{ session('cotizacion-actualizada') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif

@if (session('recibo-registrado'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'GUARDADO',
                text: '{{ session('recibo-registrado') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif
@if (session('recibog-store'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'GUARDADO',
                text: '{{ session('recibog-store') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif
@if (session('recibo-actualizo'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'ACTUALIZADO',
                text: '{{ session('recibo-actualizo') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif
@if (session('recibog-actualizo'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'ACTUALIZADO',
                text: '{{ session('recibog-actualizo') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif
@if (session('store'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'Guardado',
                text: '{{ session('store') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif

@if (session('update'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'Actualizado',
                text: '{{ session('update') }}',
                showConfirmButton: true,
                confirmButtonText: "Cerrar"

            })
        });
    </script>
@endif

</html>
