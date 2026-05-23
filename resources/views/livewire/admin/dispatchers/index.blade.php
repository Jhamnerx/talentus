<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Transportistas</h1>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <x-search-form placeholder="Buscar transportista…" />
            <x-form.button dark wire:click="openModalCreate" icon="plus">Nuevo Transportista</x-form.button>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700/60">
        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-gray-300 divide-y divide-gray-200 dark:divide-gray-700/60">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 text-left">Tipo Doc.</th>
                        <th class="px-4 py-3 text-left">N° Documento</th>
                        <th class="px-4 py-3 text-left">Razón Social</th>
                        <th class="px-4 py-3 text-left">N° MTC</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium divide-y divide-gray-200 dark:divide-gray-700/60">
                    @forelse ($dispatchers as $dispatcher)
                        <tr>
                            <td class="px-4 py-3">{{ $dispatcher->tipo_doc == '6' ? 'RUC' : 'DNI' }}</td>
                            <td class="px-4 py-3">{{ $dispatcher->numero_doc }}</td>
                            <td class="px-4 py-3">{{ $dispatcher->razon_social }}</td>
                            <td class="px-4 py-3">{{ $dispatcher->numero_mtc }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 rounded-full text-xs {{ $dispatcher->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $dispatcher->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <x-form.button flat icon="pencil" wire:click="openModalEdit({{ $dispatcher->id }})" />
                                <x-form.button flat icon="trash" red wire:click="delete({{ $dispatcher->id }})"
                                    wire:confirm="¿Eliminar este transportista?" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">No hay transportistas
                                registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $dispatchers->links() }}</div>
    </div>

</div>
