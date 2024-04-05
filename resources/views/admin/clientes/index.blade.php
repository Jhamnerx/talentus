@extends('layouts.admin')
@section('ruta', 'clientes-clientes')
@section('contenido')

    <!-- Table -->
    @livewire('admin.clientes.clientes-index')
    @livewire('admin.clientes.import')
    @livewire('admin.clientes.save')

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
    @if (session('export'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Exportar',
                    text: '{{ session('export') }}',
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
        window.addEventListener('clientes-import', event => {
            iziToast.success({
                position: 'topRight',
                title: 'IMPORTE COMPLETO',
                message: 'se importo los clientes perfectamente',
            });

        })
    </script>

@stop
