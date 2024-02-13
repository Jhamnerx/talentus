@extends('layouts.admin')
@section('ruta', 'vehiculos-reportes')
@section('contenido')



    @livewire('admin.vehiculos.reportes.show', ['reporte' => $reporte])


@stop

@push('modals')
    @livewire('admin.vehiculos.reportes.show-detalle')
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



@stop
