<x-admin-layout>

    <!-- Table -->
    @livewire('admin.vehiculos.vehiculos-index', [], key('vehiculos-index'))

    @livewire('admin.vehiculos.save-vehiculo', [], key('save-vehiculo'))
    @livewire('admin.vehiculos.edit-vehiculo', [], key('edit-vehiculo'))


    @livewire('admin.vehiculos.delete', [], key('delete'))
    @livewire('admin.vehiculos.import', [], key('import'))
    @livewire('admin.vehiculos.suspend', [], key('suspend'))
    @livewire('admin.vehiculos.activar', [], key('activar'))
    @livewire('admin.vehiculos.mantenimiento.save', ['update' => session('updated-numero')], key('mantenimiento-save'))
    @livewire('admin.lineas.save', [], key('lineas-save'))
    @livewire('admin.dispositivos.save', [], key('dispositivos-save'))
    @livewire('admin.clientes.save', [], key('clientes-save'))
    @livewire('admin.vehiculos.modal-ver-suscripcion', [], key('modal-ver-suscripcion'))

    <script>
        document.addEventListener('livewire:init', function() {
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
        });
    </script>

</x-admin-layout>
