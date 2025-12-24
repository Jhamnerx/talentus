<x-admin-layout>

    <!-- Table -->
    @livewire('admin.clientes.contactos.contactos-index')

    @livewire('admin.clientes.contactos.save')
    @livewire('admin.clientes.contactos.edit')
    @livewire('admin.clientes.contactos.delete')

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

</x-admin-layout>
