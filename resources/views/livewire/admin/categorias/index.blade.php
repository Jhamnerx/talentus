<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">

        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Categorias ✨</h1>
        </div>

        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            @can('crear-categoria')
                <x-form.button label="Añadir Categoria" icon="plus" wire:click.prevent='openModalCreate' />
            @endcan

        </div>

    </div>


    <livewire:admin.categorias.tabla />



</div>




@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('store-categoria', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: event.mensaje,
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })

            });
            Livewire.on('delete-categoria', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: event.mensaje,
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })

            });
        });
    </script>
@endpush
