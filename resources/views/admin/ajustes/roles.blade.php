@extends('layouts.admin')
@section('ruta', 'administracion-ajustes')
@section('panel', "settingsPanel: 'roles',")
@section('contenido')

    <!-- Table -->

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> Ajustes ✨</h1>

        </div>

        <div class="bg-white shadow-lg rounded-sm mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">

                <!-- Sidebar -->

                <x-admin.settings.navigation></x-admin.settings.navigation>
                <div class="grow">
                    <div class="p-6 space-y-6">

                        @livewire('admin.ajustes.roles.show')
                        @livewire('admin.ajustes.roles.save')
                        @livewire('admin.ajustes.roles.edit')
                    </div>


                </div>

            </div>

        </div>

    </div>


@stop

@section('js')
    @if (session('store'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: "{{ session('store') }}",
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
                    text: "{{ session('store') }}",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif
@endsection
