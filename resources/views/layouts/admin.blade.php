<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="frame-src 'self'">
    <link rel="icon" href="{{ asset('images/favicon2023.png') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">

    {{-- plugins --}}
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    {{-- CKEDITOR --}}
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>


    <!-- Styles -->

    <wireui:scripts />
    @livewireStyles

    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>
</head>


<body class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }" x-data="{ page: '{{ $attributes->get('ruta', '') }}', {{ $attributes->get('panel', '') }} sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

    <x-form.notifications />
    <x-form.dialog />

    @if (session()->has('impersonator_id'))
        <div class="fixed top-0 inset-x-0 z-60 bg-amber-500 text-white text-sm font-medium px-4 py-2 flex items-center justify-center gap-3 shadow">
            <span>⚠ Estás viendo el sistema como <strong>{{ Auth::user()->name }}</strong>.</span>
            <a href="{{ route('admin.usuarios.impersonate.leave') }}"
                class="underline font-semibold hover:text-amber-100">Volver a mi cuenta</a>
        </div>
    @endif
    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>

    <div class="flex h-dvh overflow-hidden">

        <x-admin.sidebar :variant="$attributes['sidebarVariant']" />

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden @if ($attributes['background']) {{ $attributes['background'] }} @endif"
            x-ref="contentarea">

            {{-- <x-app.header :variant="$attributes['headerVariant']" /> --}}
            @livewire('admin.header', ['page' => request()->fullUrl(), 'variant' => 'v3'], key('header-' . request()->fullUrl()))

            <main class="grow">
                {{ $slot }}
            </main>

        </div>

    </div>




    @livewireScripts

    <script>
        // Selección masiva (select-all) compartida por los listados del admin.
        // Evita "uncheckParent/toggleAll is not defined" en tablas que no definen
        // su propio x-data. Los listados con handleSelect propio tienen precedencia.
        (function () {
            function updateBulkCount() {
                const countEl = document.querySelector('.table-items-action');
                if (!countEl) return;
                const n = document.querySelectorAll('input.table-item:checked').length;
                const countSpan = document.querySelector('.table-items-count');
                if (countSpan) countSpan.innerHTML = n;
                n > 0 ? countEl.classList.remove('hidden') : countEl.classList.add('hidden');
            }
            window.toggleAll = function (e) {
                const checked = !!(e && e.target && e.target.checked);
                document.querySelectorAll('input.table-item').forEach((el) => { el.checked = checked; });
                updateBulkCount();
            };
            window.uncheckParent = function () {
                const parent = document.getElementById('parent-checkbox');
                if (parent) parent.checked = false;
                updateBulkCount();
            };
        })();
    </script>

    @stack('modals')
    @stack('scripts')
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
                timer: event.timer ? event.timer : 3000,
            });

        });


    });
</script>



</html>
