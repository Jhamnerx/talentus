@extends('layouts.admin')

@section('ruta', 'administracion-solicitudes')



@section('contenido')

    <!-- Table -->
    @livewire('admin.solicitudes.index')

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

    <script>
        window.addEventListener('update-solicitud', event => {
            iziToast.show({
                color: event.detail.color,
                icon: '<i class="fas fa-tasks"></i>',
                title: event.detail.titulo,
                timeout: 2500,
                message: '<b>' + event.detail.message + ' ' + event.detail.numero + '</b>',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: event.detail.progressBarColor
            });
        })
    </script>
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



@stop
