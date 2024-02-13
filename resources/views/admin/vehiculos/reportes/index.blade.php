@extends('layouts.admin')
@section('ruta', 'vehiculos-reportes')
@section('contenido')

    <!-- Table -->


    @livewire('admin.vehiculos.reportes.index')

@stop

@push('modals')
    @livewire('admin.vehiculos.reportes.show-contactos')
    @livewire('admin.vehiculos.reportes.save')
    @livewire('admin.vehiculos.reportes.edit')
    @livewire('admin.vehiculos.reportes.delete')
    @livewire('admin.vehiculos.reportes.show-detalle')
    @livewire('admin.vehiculos.reportes.recordatorio')
@endpush



@section('js')

    <script>
        window.addEventListener('reporte-edit', event => {
            iziToast.success({
                position: 'topRight',
                title: 'ACTUALIZADO',
                message: 'El Reporte de ' + event.detail.vehiculo + ' Fue Actualizado',
            });
            $('.vehiculos_id').val(null).trigger('change');

        })
    </script>


    <script>
        window.addEventListener('detalle-reporte', event => {
            iziToast.success({
                position: 'topRight',
                title: 'DETALLE AGREGADO',
                message: 'Se añadio un detalle al reporte',
            });

        })
    </script>

    <script>
        window.addEventListener('reporte-delete', event => {
            iziToast.error({
                position: 'topRight',
                title: 'ELIMINADO',
                message: 'El Reporte de ' + event.detail.vehiculo + ' Fue Eliminado',
            });

        })
    </script>
    <script>
        window.addEventListener('reporte-save', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'El Reporte de ' + event.detail.vehiculo + ' Fue Creado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
            $('.vehiculos_id').val(null).trigger('change');
        })
    </script>

    <script>
        window.addEventListener('recordatorio-save', event => {
            $(document).ready(function() {
                iziToast.success({
                    position: 'topRight',
                    title: 'RECORDATORIO CREADO',
                    message: 'Se creo un recordatorio para el Vehiculo ' + event.detail.vehiculo,
                });
            });
        })
    </script>


@stop
