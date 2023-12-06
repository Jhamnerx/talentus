@extends('layouts.admin')
@section('ruta', 'almacen-lineas')
@section('contenido')

    <!-- Table -->

    @livewire('admin.lineas.index')
    @livewire('admin.lineas.asign-to-placa')
    @livewire('admin.lineas.suspend-linea')

    @livewire('admin.gerencia.reportes.modales.reporte-lineas')
@stop

@section('js')
    <script>
        window.addEventListener('asign-linea-to-placa', event => {
            iziToast.success({
                position: 'topRight',
                title: '#' + event.detail.linea,
                message: 'Numero asignado a la siguiente placa: ' + event.detail.placa,
            });
            $('.vehiculos_id').val(null).trigger('change');
        })
    </script>

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
    @if (session('asign'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Asignado',
                    text: '{{ session('asign') }}',
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

    @if (session('unasign'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: '{{ session('unasign') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif
    @if (session()->has('import'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Importar',
                    text: '{{ session('import') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif



@stop
