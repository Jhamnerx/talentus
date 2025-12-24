<x-admin-layout ruta="vehiculos-reportes">

    @livewire('admin.vehiculos.reportes.show', ['reporte' => $reporte])

    @livewire('admin.vehiculos.reportes.show-detalle')

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

</x-admin-layout>
