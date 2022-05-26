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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css">
    {{--
    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}"> --}}
    <!-- Scripts -->

    {{--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <script src="{{asset('plugins/tw-elements/index.min.js')}}"></script> --}}
    <script src="{{ mix('js/app.js') }}" defer></script>
    {{-- plugins --}}
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('plugins/jquery.mockjax.js')}}"></script>
    {{-- <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script> --}}
    <script src="{{asset('plugins/jquery.autocomplete.js')}}"></script>

    {{-- Select2 --}}



    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>



    @livewireStyles

</head>

<body class="font-inter antialiased bg-slate-200 text-slate-600" :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{page: '@yield('ruta')',sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
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
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            @livewire('admin.header')
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
</body>

</html>