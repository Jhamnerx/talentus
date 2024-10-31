@extends('layouts.admin')
@section('ruta', 'vehiculos-vehiculos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.vehiculos.vehiculos-index', [], key('vehiculos-index'))


@stop


@push('modals')
    @livewire('admin.vehiculos.save-vehiculo', [], key('save-vehiculo'))
    @livewire('admin.vehiculos.edit-vehiculo', [], key('edit-vehiculo'))


    @livewire('admin.vehiculos.delete', [], key('delete'))
    @livewire('admin.vehiculos.import', [], key('import'))
    @livewire('admin.vehiculos.suspend', [], key('suspend'))
    @livewire('admin.vehiculos.mantenimiento.save', ['update' => session('updated-numero')], key('mantenimiento-save'))
    @livewire('admin.vehiculos.save-quick', [], key('save-quick'))
    @livewire('admin.lineas.save', [], key('lineas-save'))
    @livewire('admin.dispositivos.save', [], key('dispositivos-save'))
    @livewire('admin.clientes.save', [], key('clientes-save'))
    @livewire('admin.vehiculos.get-devices-wox', [], key('devices-wox'))
    @livewire('admin.vehiculos.get-info-device-wox', [], key('devices-info-wox'))
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
