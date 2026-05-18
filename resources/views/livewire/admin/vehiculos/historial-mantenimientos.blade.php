<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

    {{-- Page header --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Historial de Mantenimientos</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Suspensiones, reactivaciones y mantenimientos de vehículos GPS.
            </p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mb-5">
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-4">
            <div class="grid grid-cols-12 gap-4">

                {{-- Búsqueda --}}
                <div class="col-span-12 sm:col-span-6 md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar</label>
                    <div class="relative">
                        <input wire:model.live="search" class="form-input w-full pl-9" type="search"
                            placeholder="Placa, dispositivo, motivo..." />
                        <button class="absolute inset-0 right-auto group" type="button">
                            <svg class="w-4 h-4 shrink-0 fill-current text-gray-400 ml-3 mr-2" viewBox="0 0 16 16">
                                <path
                                    d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                <path
                                    d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Tipo --}}
                <div class="col-span-12 sm:col-span-6 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
                    <select wire:model.live="tipo" class="form-select w-full">
                        <option value="">Todos</option>
                        <option value="mantenimiento">Mantenimiento</option>
                        <option value="suspension">Suspensión</option>
                        <option value="reactivacion">Reactivación</option>
                    </select>
                </div>

                {{-- Vehículo --}}
                <div class="col-span-12 sm:col-span-6 md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vehículo</label>
                    <select wire:model.live="vehiculo_id" class="form-select w-full">
                        <option value="">Todos los vehículos</option>
                        @foreach ($vehiculos as $v)
                            <option value="{{ $v->id }}">{{ $v->placa }} — {{ $v->marca }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Desde --}}
                <div class="col-span-6 sm:col-span-3 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Desde</label>
                    <input wire:model.live="desde" type="date" class="form-input w-full" />
                </div>

                {{-- Hasta --}}
                <div class="col-span-6 sm:col-span-3 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hasta</label>
                    <input wire:model.live="hasta" type="date" class="form-input w-full" />
                </div>

            </div>

            {{-- Reset --}}
            @if ($search || $tipo || $vehiculo_id || $desde || $hasta)
                <div class="mt-3">
                    <button wire:click="clearFilters" class="text-sm text-violet-600 hover:underline">
                        Limpiar filtros
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20">
                    <tr>
                        <th class="px-3 py-3 text-left whitespace-nowrap">Tipo</th>
                        <th class="px-3 py-3 text-left whitespace-nowrap">Vehículo</th>
                        <th class="px-3 py-3 text-left whitespace-nowrap">Dispositivo</th>
                        <th class="px-3 py-3 text-left whitespace-nowrap">Fecha</th>
                        <th class="px-3 py-3 text-left">Motivo</th>
                        <th class="px-3 py-3 text-left whitespace-nowrap">Fuente</th>
                        <th class="px-3 py-3 text-left whitespace-nowrap">Usuario</th>
                        <th class="px-3 py-3 text-left whitespace-nowrap">Creado</th>
                        <th class="px-3 py-3 text-center whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($registros as $reg)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition">

                            {{-- Tipo badge --}}
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if ($reg->tipo === 'suspension')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        Suspensión
                                    </span>
                                @elseif ($reg->tipo === 'reactivacion')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        Reactivación
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        Mantenimiento
                                    </span>
                                @endif
                            </td>

                            {{-- Vehículo --}}
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if ($reg->vehiculo)
                                    <span
                                        class="font-semibold text-gray-800 dark:text-gray-100">{{ $reg->vehiculo->placa }}</span>
                                    <span class="text-gray-400 text-xs ml-1">{{ $reg->vehiculo->marca }}</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Dispositivo (tracking) --}}
                            <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ $reg->tracking_device_name ?? ($reg->tracking_device_id ?? '—') }}
                            </td>

                            {{-- Fecha --}}
                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                {{ $reg->fecha?->format('d/m/Y') }}
                            </td>

                            {{-- Motivo --}}
                            <td class="px-3 py-2 text-gray-600 dark:text-gray-400 max-w-xs truncate"
                                title="{{ $reg->motivo }}">
                                {{ $reg->motivo ?? '—' }}
                            </td>

                            {{-- Fuente --}}
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if ($reg->source === 'tracking')
                                    <span
                                        class="inline-flex items-center gap-1 text-xs text-violet-600 dark:text-violet-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 2a8 8 0 100 16A8 8 0 0010 2zm0 14a6 6 0 110-12 6 6 0 010 12z" />
                                            <path
                                                d="M10 6a1 1 0 011 1v3.586l2.707 2.707a1 1 0 01-1.414 1.414l-3-3A1 1 0 019 11V7a1 1 0 011-1z" />
                                        </svg>
                                        Tracking
                                    </span>
                                @else
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Manual</span>
                                @endif
                            </td>

                            {{-- Usuario --}}
                            <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                {{ $reg->user?->name ?? '—' }}
                            </td>

                            {{-- Creado --}}
                            <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-400 dark:text-gray-500">
                                {{ $reg->created_at?->format('d/m/Y H:i') }}
                            </td>

                            {{-- Acciones --}}
                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                @can('eliminar-vehiculos-historial-mantenimientos')
                                    <button wire:click="delete({{ $reg->id }})"
                                        wire:confirm="¿Eliminar este registro de historial?"
                                        class="text-red-500 hover:text-red-700 transition" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3" />
                                        </svg>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-3 py-10 text-center text-gray-400 dark:text-gray-500">
                                Sin registros de historial.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if ($registros->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $registros->links() }}
            </div>
        @endif
    </div>

</div>
