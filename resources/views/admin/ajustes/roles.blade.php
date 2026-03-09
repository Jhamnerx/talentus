<x-admin-layout>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

        <!-- Page header -->
        <div class="mb-8">

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Ajustes ✨</h1>

        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">

                <!-- Sidebar -->

                <x-admin.settings.navigation></x-admin.settings.navigation>
                <div class="grow">
                    <div class="p-6 space-y-6">

                        @livewire('admin.ajustes.roles.show')

                    </div>


                </div>

            </div>

        </div>

    </div>

    @livewire('admin.ajustes.roles.save')
    @livewire('admin.ajustes.roles.edit')

    @if (session('store'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: "{{ session('store') }}",
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
                    text: "{{ session('store') }}",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif

</x-admin-layout>
