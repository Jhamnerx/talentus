@extends('layouts.admin')
@section('ruta', 'ventas-recibos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.ventas.recibos.recibos-index')
    @livewire('admin.ventas.recibos.reportes')
    @livewire('admin.ventas.recibos.send')
    @livewire('admin.ventas.recibos.delete')

@stop

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


    <script>
        window.addEventListener('recibo-delete', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: 'Factura Eliminada',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
    </script>
    <script>
        window.addEventListener('recibo-send', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'CORREO ENVIADO<br>',
                timeout: 1500,
                message: 'Se ha enviado el recibo ' + event.detail.recibo.numero + '!',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(5, 44, 82)'
            });
        })
    </script>


@stop
