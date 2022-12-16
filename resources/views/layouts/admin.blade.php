<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
    @yield('css')
    {{-- dataTables --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables/css/jquery.dataTables.min.css') }}">

    {{--
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}"> --}}
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    {{--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <script src="{{asset('plugins/tw-elements/index.min.js')}}"></script> --}}
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    {{-- plugins --}}
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    {{-- dataTables --}}
    <script src="{{ asset('plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery.mockjax.js') }}"></script>
    {{-- <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script> --}}
    <script src="{{ asset('plugins/jquery.autocomplete.js') }}"></script>
    <script src="{{ asset('plugins/input-case-enforcer/input-case-enforcer.min.js') }}"></script>


    {{-- VenoBox IMAGEN VIEWER --}}
    <link rel="stylesheet" href="{{asset('plugins/veno-box/venobox.css')}}" type="text/css" media="screen" />
    {{-- <script src="{{ asset('plugins/veno-box/venobox.esm.js') }}"></script> --}}
    {{-- Select2 --}}

    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
        integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    @livewireStyles

</head>

<body class="font-inter antialiased bg-slate-200 text-slate-600" :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ page: '@yield('ruta')', @yield('panel') sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true', profileSidebarOpen: false }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">


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
            <main>


                @yield('contenido')

            </main>

        </div>

    </div>

    @stack('modals')

    @livewireScripts

    @yield('js')

    @stack('scripts')


    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
</body>
<script>
    $(document).ready(function() {

        Echo.private('App.Models.User.' + {{ Auth::user()->id }})
            .notification((notification) => {
                Livewire.emit('notificaciones-update');
                //console.log("evento");
            });

        // Echo.channel('clientes')
        //     .listen('ClientesImportUpdated', (e) => {
        //         console.log("evento recibido");
        //     });

        // Echo.channel('clientes')
        //     .listen('ClientesImportUpdated', (e) => {
        //         console.log("evento recibido");
        //     });

    });
</script>
<script>
    Livewire.onPageExpired((response, message) => {
        console.log('pagina expirada')

    })
</script>

</html>
