<div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Rubros de Clientes ✨</h1>
            <span class="text-gray-500 dark:text-gray-400 text-sm">Define los rubros o sectores económicos de tus clientes (TRANSPORTES, MINERÍA, CONSTRUCCIÓN, etc.)</span>
        </div>
        <div class="flex items-center gap-2">
            <x-form.input wire:model.live="search" placeholder="Buscar rubro..." icon="magnifying-glass" />
            <button wire:click="openModalSave" class="btn bg-indigo-500 hover:bg-indigo-600 text-white inline-flex items-center gap-2">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                </svg>
                <span class="hidden xs:block">Añadir Rubro</span>
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-x-auto">
        <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                <tr>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Descripción</th>
                    <th class="px-4 py-3 text-center">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($rubros as $rubro)
                    <tr wire:key="rubro-{{ $rubro->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/30">
                        <td class="px-4 py-3">
                            <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $rubro->nombre }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">
                            {{ $rubro->descripcion ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if ($rubro->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300">Activo</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 w-px">
                            <div class="flex items-center justify-center gap-1">
                                <button wire:click="openModalEdit({{ $rubro->id }})"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button wire:click="openModalDelete({{ $rubro->id }})"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-gray-400 dark:text-gray-500">
                            No hay rubros configurados aún
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $rubros->links() }}</div>
</div>
