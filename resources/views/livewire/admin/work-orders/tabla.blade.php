<div class="space-y-4">
    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-form.input wire:model.live.debounce.300ms="search" placeholder="Buscar por código, placa..."
                icon="search" />

            <x-form.select wire:model.live="estado_filter" placeholder="Todos los estados">
                <x-select.option value="">Todos</x-select.option>
                <x-select.option value="pendiente">Pendiente</x-select.option>
                <x-select.option value="en_proceso">En Proceso</x-select.option>
                <x-select.option value="finalizado">Finalizado</x-select.option>
                <x-select.option value="cancelado">Cancelado</x-select.option>
            </x-form.select>

            <x-form.datetime.picker wire:model.live="fecha_desde" placeholder="Fecha desde" without-time />
            <x-form.datetime.picker wire:model.live="fecha_hasta" placeholder="Fecha hasta" without-time />
        </div>

        @if ($search || $estado_filter || $fecha_desde || $fecha_hasta)
            <div class="mt-4">
                <x-form.button wire:click="limpiarFiltros" flat label="Limpiar filtros" icon="x" />
            </div>
        @endif
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehículo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Técnico</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ordenes as $orden)
                    <tr wire:key="orden-{{ $orden->id }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $orden->codigo }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $orden->tipo->nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $orden->vehiculo->placa }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ Str::limit($orden->cliente->razon_social, 30) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $orden->tecnico->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $orden->fecha_programada->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $orden->estado->statusColor() }}">
                                {{ $orden->estado->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <x-form.button xs icon="eye" wire:click="verDetalle({{ $orden->id }})" flat />

                            @if ($orden->estado->value === 'pendiente')
                                <x-form.button xs icon="play" wire:click="iniciarOrden({{ $orden->id }})"
                                    primary />
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            No se encontraron órdenes de trabajo
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4">
            {{ $ordenes->links() }}
        </div>
    </div>
</div>
