<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Header con estadísticas -->
    <div class="mb-8">
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Notificaciones de Cobro 🔔
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Cobros próximos a facturar generados automáticamente
                </p>
            </div>
            <div>
                <button wire:click="clearFilters" class="btn bg-red-500 hover:bg-red-600 text-white">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M5.414 4L4 5.414 6.586 8 4 10.586 5.414 12 8 9.414 10.586 12 12 10.586 9.414 8 12 5.414 10.586 4 8 6.586z" />
                    </svg>
                    <span class="ml-2">Limpiar</span>
                </button>
            </div>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Pendientes -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Pendientes</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $stats['pendientes'] }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Vencidos -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Vencidos</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $stats['vencidos'] }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Para Hoy -->
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">Para Hoy</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $stats['hoy'] }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Monto Total -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Monto Pendiente</p>
                        <p class="text-white text-2xl font-bold mt-1">S/
                            {{ number_format($stats['monto_pendiente'], 2) }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">

            <!-- Búsqueda -->
            <div class="relative">
                <label for="search" class="sr-only">Buscar</label>
                <input wire:model.live.debounce='search' id="search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100 w-full"
                    type="search" placeholder="Buscar cliente, placa..." />
                <button class="absolute inset-0 right-auto group" type="submit">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-gray-500 ml-3 mr-2"
                        viewBox="0 0 16 16">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </div>

            <!-- Estado -->
            <div>
                <select wire:model.live="estado" class="form-select w-full">
                    <option value="">Todos los estados</option>
                    <option value="PENDIENTE">⏳ Pendiente</option>
                    <option value="FACTURADO">📄 Facturado</option>
                    <option value="PAGADO">✅ Pagado</option>
                    <option value="CANCELADO">❌ Cancelado</option>
                </select>
            </div>

            <!-- Vencimiento -->
            <div>
                <select wire:model.live="filtroVencimiento" class="form-select w-full">
                    <option value="">Todos los vencimientos</option>
                    <option value="vencidos">🔴 Vencidos</option>
                    <option value="hoy">📅 Hoy</option>
                    <option value="7dias">🟡 Próximos 7 días</option>
                    <option value="15dias">🟢 Próximos 15 días</option>
                </select>
            </div>

            <!-- Per Page -->
            <div>
                <select wire:model.live="perPage" class="form-select w-full">
                    <option value="10">10 registros</option>
                    <option value="15">15 registros</option>
                    <option value="25">25 registros</option>
                    <option value="50">50 registros</option>
                </select>
            </div>

        </div>
    </div>

    <!-- Tabla de notificaciones -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-gray-300">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-b border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Estado</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Vencimiento</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Cliente</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Vehículo</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Descripción</th>
                        <th class="px-4 py-3 whitespace-nowrap text-right">Monto</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Documento</th>
                        <th class="px-4 py-3 whitespace-nowrap text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                    @forelse ($notificaciones as $notificacion)
                        <tr wire:key="notif-{{ $notificacion->id }}"
                            class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <!-- Estado -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($notificacion->estado === 'PENDIENTE')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 rounded-full">
                                        ⏳ Pendiente
                                    </span>
                                @elseif($notificacion->estado === 'FACTURADO')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 rounded-full">
                                        📄 Facturado
                                    </span>
                                @elseif($notificacion->estado === 'PAGADO')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 rounded-full">
                                        ✅ Pagado
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300 rounded-full">
                                        ❌ Cancelado
                                    </span>
                                @endif
                            </td>

                            <!-- Vencimiento -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $notificacion->fecha_vencimiento->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @if ($notificacion->fecha_vencimiento->isToday())
                                        Hoy
                                    @elseif($notificacion->fecha_vencimiento->isPast())
                                        🔴 Vencido hace {{ $notificacion->fecha_vencimiento->diffForHumans() }}
                                    @else
                                        Vence {{ $notificacion->fecha_vencimiento->diffForHumans() }}
                                    @endif
                                </div>
                            </td>

                            <!-- Cliente -->
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $notificacion->cliente->razon_social }}
                                </div>
                            </td>

                            <!-- Vehículo -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($notificacion->vehiculo)
                                    <span
                                        class="px-2 py-1 text-xs font-mono font-bold bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded">
                                        {{ $notificacion->vehiculo->placa }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">Sin vehículo</span>
                                @endif
                            </td>

                            <!-- Descripción -->
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">
                                    {{ $notificacion->descripcion }}
                                </div>
                            </td>

                            <!-- Monto -->
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $notificacion->moneda }} {{ number_format($notificacion->monto, 2) }}
                                </span>
                            </td>

                            <!-- Documento -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($notificacion->venta)
                                    <a href="{{ route('admin.ventas.show', $notificacion->venta) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline text-xs">
                                        Venta #{{ $notificacion->venta->id }}
                                    </a>
                                @elseif($notificacion->recibo)
                                    <a href="{{ route('admin.recibos.show', $notificacion->recibo) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline text-xs">
                                        Recibo #{{ $notificacion->recibo->id }}
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">Sin documento</span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($notificacion->estado === 'PENDIENTE')
                                        <button wire:click="redirectToFacturar({{ $notificacion->id }})"
                                            class="btn btn-sm bg-blue-500 hover:bg-blue-600 text-white">
                                            📝 Facturar
                                        </button>
                                        <button wire:click="cancelar({{ $notificacion->id }})"
                                            class="btn btn-sm bg-red-500 hover:bg-red-600 text-white">
                                            ❌
                                        </button>
                                    @else
                                        <a href="{{ route('admin.cobros.show', $notificacion->cobro_id) }}"
                                            class="btn btn-sm bg-gray-500 hover:bg-gray-600 text-white">
                                            👁️ Ver
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="font-medium">No hay notificaciones con los filtros aplicados</p>
                                <p class="text-sm mt-1">Intenta cambiar los filtros o crear nuevos cobros</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if ($notificaciones->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700/60">
                {{ $notificaciones->links() }}
            </div>
        @endif
    </div>
</div>
