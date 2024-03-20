@extends('layouts.admin')
@section('ruta', 'vehiculos-vehiculos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.vehiculos.vehiculos-index')


@stop


@push('modals')
    @livewire('admin.vehiculos.save-vehiculo')
    @livewire('admin.vehiculos.edit-vehiculo')


    @livewire('admin.vehiculos.delete')
    @livewire('admin.vehiculos.import')
    @livewire('admin.vehiculos.suspend')
    @livewire('admin.vehiculos.mantenimiento.save', ['update' => session('updated-numero')])
    @livewire('admin.vehiculos.save-quick')
    @livewire('admin.lineas.save')
    @livewire('admin.dispositivos.save')
    @livewire('admin.clientes.save')
@endpush
@section('js')
    <script>
        Livewire.on('updated-numero', (event) => {

            Swal.fire({
                icon: 'success',
                title: 'VEHICULO ACTUALIZADO',
                text: 'La Actualización cambio el numero, deseas registrar una programación de mantenimiento?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Registrar!',
                cancelButtonText: 'Cerrar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    Livewire.dispatch('create-mantenimiento', {
                        placa: event.placa
                    })
                } else if (result.isDenied) {

                }
            })

        });
    </script>
@stop
