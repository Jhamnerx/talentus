@extends('layouts.admin')
@section('ruta', 'ventas-facturas')
@section('contenido')


    <!-- Table -->
    @livewire('admin.ventas.facturas.index')
    @livewire('admin.ventas.facturas.delete')
    @livewire('admin.ventas.facturas.send')

@stop

@section('js')
    @if (session('store'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardada',
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
                    title: 'Actualizada',
                    text: '{{ session('update') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif


    <script>
        window.addEventListener('factura-delete', event => {
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
        window.addEventListener('factura-send', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'CORREO ENVIADO',
                timeout: 1500,
                message: 'Se ha enviado la factura ' + event.detail.factura.serie_numero
                    .factura + '!',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(5, 44, 82)'
            });
        })
    </script>


@stop
