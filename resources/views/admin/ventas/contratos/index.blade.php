<x-admin-layout ruta="ventas-contratos">

    <!-- Table -->
    @livewire('admin.ventas.contratos.index')
    @livewire('admin.ventas.contratos.delete')
    @livewire('admin.ventas.contratos.send')
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


    <script>
        window.addEventListener('contrato-delete', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: 'Contrato Eliminado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
    </script>

</x-admin-layout>
