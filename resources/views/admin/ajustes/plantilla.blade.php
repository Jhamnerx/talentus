@extends('layouts.admin')
@section('ruta', 'administracion-ajustes')
@section('panel', "settingsPanel: 'notifications',")
@section('contenido')


    @livewire('admin.ajustes.plantilla.form', ['plantilla' => $plantilla])

@stop

{{-- section de js --}}
@section('js')

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

    @if (session('delete'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: '{{ session('delete') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif

    <script>
        window.addEventListener('save.image', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: event.detail.mensaje,
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
    </script>
@stop
