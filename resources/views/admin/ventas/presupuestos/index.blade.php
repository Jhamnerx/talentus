@extends('layouts.admin')
@section('ruta', 'ventas-presupuestos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.ventas.presupuestos.presupuestos-index')


@stop

@push('modals')
    @livewire('admin.ventas.presupuestos.send')
    @livewire('admin.ventas.presupuestos.delete')
    @livewire('admin.ventas.presupuestos.convert-to')
@endpush

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
        window.addEventListener('presupuesto-delete', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: 'Presupuesto Eliminado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
    </script>

    <script>
        window.addEventListener('save-invoice', event => {
            $(document).ready(function() {
                iziToast.success({
                    position: 'topRight',
                    title: 'FACTURA REGISTRADA',
                    message: 'Se registro una factura con el numero #' + event.detail.numero,
                });
            });
        })
    </script>

    <script>
        window.addEventListener('save-recibo', event => {
            $(document).ready(function() {
                iziToast.success({
                    position: 'topRight',
                    title: 'RECIBO REGISTRADO',
                    message: 'Se registro un recibo con el numero #' + event.detail.numero,
                });
            });
        })
    </script>
    <script>
        window.addEventListener('presupuesto-send', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'CORREO ENVIADO<br>',
                timeout: 1500,
                message: 'Se ha enviado la cotización ' + event.detail.presupuesto.numero + '!',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(5, 44, 82)'
            });
        })
    </script>


@stop
