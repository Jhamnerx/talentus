@extends('layouts.admin')
@section('ruta', 'clientes-clientes')
@section('contenido')

    <!-- Table -->
    @livewire('admin.clientes.clientes-index')
    @livewire('admin.clientes.import')
    @livewire('admin.clientes.save')
    @livewire('admin.clientes.edit')

@stop

@section('js')

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
