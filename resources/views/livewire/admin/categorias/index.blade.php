<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto" :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ page: 'almacen-categorias', sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">
        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Categorias ✨</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                @can('crear-categoria')
                    <button wire:click.prevent='openModalCreate' class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Añadir Categoria</span>
                    </button>
                @endcan

            </div>

        </div>


        <livewire:admin.categorias.tabla />



    </div>


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
