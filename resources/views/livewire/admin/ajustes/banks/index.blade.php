<div class="space-y-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Listado de bancos</h3>
        <x-form.button primary label="Nuevo" wire:click="create" icon="plus" />
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60">
        <div class="overflow-x-auto min-h-screen">>
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($banks as $bank)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                            <td class="px-4 py-3">{{ $bank->id }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-100">
                                {{ $bank->description }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <x-form.button xs primary label="Editar" wire:click="edit({{ $bank->id }})" />
                                    <x-form.button xs negative label="Eliminar"
                                        wire:click="confirmDelete({{ $bank->id }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-10 text-center text-gray-400 dark:text-gray-500">
                                No se encontraron bancos
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $banks->links() }}
    </div>
</div>
