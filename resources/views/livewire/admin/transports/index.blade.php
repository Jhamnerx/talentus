<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Vehículos</h1>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <x-search-form placeholder="Buscar vehículo…" />
            <x-form.button dark wire:click="openModalCreate" icon="plus">Nuevo Vehículo</x-form.button>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700/60">
        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-gray-300 divide-y divide-gray-200 dark:divide-gray-700/60">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 text-left">Placa</th>
                        <th class="px-4 py-3 text-left">Marca</th>
                        <th class="px-4 py-3 text-left">Modelo</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium divide-y divide-gray-200 dark:divide-gray-700/60">
                    @forelse ($transports as $transport)
                        <tr>
                            <td class="px-4 py-3 font-bold">{{ $transport->placa }}</td>
                            <td class="px-4 py-3">{{ $transport->marca }}</td>
                            <td class="px-4 py-3">{{ $transport->modelo }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 rounded-full text-xs {{ $transport->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $transport->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <x-form.button flat icon="pencil" wire:click="openModalEdit({{ $transport->id }})" />
                                <x-form.button flat icon="trash" red wire:click="delete({{ $transport->id }})"
                                    wire:confirm="¿Eliminar este vehículo?" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">No hay vehículos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $transports->links() }}</div>
    </div>

</div>
