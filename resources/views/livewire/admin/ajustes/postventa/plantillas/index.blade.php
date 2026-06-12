<div>
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Plantillas Post-Venta</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Mensajes automáticos enviados al cliente al cerrar una OT. Variables: <code class="text-xs bg-gray-100 dark:bg-gray-700 px-1 rounded">{placa} {cliente} {fecha_instalacion} {fecha_cierre}</code>
            </p>
        </div>
        <div>
            <x-form.button wire:click="openModalSave" primary icon="plus" label="Nueva plantilla" />
        </div>
    </div>

    <div class="mb-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
        <x-form.input wire:model.live.debounce="search" placeholder="Buscar plantilla..." icon="magnifying-glass" />
    </div>

    @if ($plantillas->isEmpty())
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl py-16 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">Aún no hay plantillas registradas.</p>
            <x-form.button wire:click="openModalSave" primary label="Crear primera plantilla" />
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                        <tr>
                            <th class="px-4 py-3 text-left">Sector</th>
                            <th class="px-4 py-3 text-left">Cuerpo del mensaje</th>
                            <th class="px-4 py-3 text-center">Archivo</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        @foreach ($plantillas as $plantilla)
                            <tr wire:key="plantilla-{{ $plantilla->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-800 dark:text-gray-100">
                                        {{ $plantilla->sector?->nombre ?? '— Por defecto —' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 max-w-xs">
                                    <p class="text-gray-600 dark:text-gray-300 truncate">{{ $plantilla->cuerpo }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($plantilla->archivo_url)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                            @if ($plantilla->archivo_tipo === 'pdf') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                            @else bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 @endif">
                                            {{ strtoupper($plantilla->archivo_tipo) }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600 text-xs">&mdash;</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button wire:click="toggleActivo({{ $plantilla->id }})"
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full cursor-pointer transition
                                            @if ($plantilla->activo) bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200
                                            @else bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400 hover:bg-gray-200 @endif">
                                        {{ $plantilla->activo ? 'Activa' : 'Inactiva' }}
                                    </button>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="openModalEdit({{ $plantilla->id }})"
                                            class="p-1.5 rounded text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="openModalDelete({{ $plantilla->id }})"
                                            class="p-1.5 rounded text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($plantillas->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/60">
                    {{ $plantillas->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
