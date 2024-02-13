@extends('layouts.admin')
@section('ruta', 'vehiculos-mantenimiento')
@section('contenido')

    <!-- Tabla -->
    @livewire('admin.vehiculos.mantenimiento.index')
    @livewire('admin.vehiculos.mantenimiento.save')
    @livewire('admin.vehiculos.mantenimiento.edit')
    @livewire('admin.vehiculos.mantenimiento.create-task')
    @livewire('admin.vehiculos.mantenimiento.delete')
    @livewire('admin.vehiculos.mantenimiento.export')

@stop

@section('js')

    <script>
        window.addEventListener('mark-as', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'MANTENIMIENTO MARCADO COMO: ' + event.detail.estado,
                timeout: 2500,
                message: 'Se ha cambiado el estado del registro',
                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(66, 245, 158)'
            });
        })
    </script>

@stop
