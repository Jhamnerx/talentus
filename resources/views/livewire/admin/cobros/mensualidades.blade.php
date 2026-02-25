<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
            📊 Dashboard de Mensualidades
        </h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Vista panorámica de todas las mensualidades vehiculares
        </p>
    </div>

    {{-- ESTADÍSTICAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Total --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xs border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Mensualidades</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                    <span class="text-2xl">📋</span>
                </div>
            </div>
        </div>

        {{-- Sin Facturar --}}
        <button wire:click="$set('filtroEstado', 'SIN_FACTURAR')"
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xs border-2 transition-all text-left
                {{ $filtroEstado === 'SIN_FACTURAR' ? 'border-gray-500 dark:border-gray-400' : 'border-gray-200 dark:border-gray-700 hover:border-gray-400' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Sin Facturar</p>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300 mt-1">{{ $stats['sin_facturar'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">S/
                        {{ number_format($stats['monto_pendiente'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    <span class="text-2xl">📋</span>
                </div>
            </div>
        </button>

        {{-- Facturados (pendiente pago) --}}
        <button wire:click="$set('filtroEstado', 'FACTURADO')"
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xs border-2 transition-all text-left
                {{ $filtroEstado === 'FACTURADO' ? 'border-amber-500 dark:border-amber-400' : 'border-gray-200 dark:border-gray-700 hover:border-amber-400' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Facturados</p>
                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $stats['facturados'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">S/
                        {{ number_format($stats['monto_facturado_pendiente'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                    <span class="text-2xl">📄</span>
                </div>
            </div>
        </button>

        {{-- Pagados --}}
        <button wire:click="$set('filtroEstado', 'PAGADO')"
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-xs border-2 transition-all text-left
                {{ $filtroEstado === 'PAGADO' ? 'border-emerald-500 dark:border-emerald-400' : 'border-gray-200 dark:border-gray-700 hover:border-emerald-400' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Pagados</p>
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['pagados'] }}
                    </p>
                </div>
                <div
                    class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                    <span class="text-2xl">✅</span>
                </div>
            </div>
        </button>
    </div>

    {{-- ALERTAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        {{-- Vencidos --}}
        @if ($stats['vencidos'] > 0)
            <button wire:click="$set('filtroEstado', 'vencidos')"
                class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-700 rounded-xl p-4 hover:border-red-400 transition-all text-left">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center">
                            <span class="text-xl">⚠️</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-red-800 dark:text-red-300">Mensualidades Vencidas</p>
                            <p class="text-xs text-red-600 dark:text-red-400">Requieren atención inmediata</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $stats['vencidos'] }}</span>
                </div>
            </button>
        @endif

        {{-- Por vencer --}}
        @if ($stats['por_vencer'] > 0)
            <button wire:click="$set('filtroEstado', 'por_vencer')"
                class="bg-orange-50 dark:bg-orange-900/20 border-2 border-orange-200 dark:border-orange-700 rounded-xl p-4 hover:border-orange-400 transition-all text-left">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-orange-100 dark:bg-orange-900/50 rounded-full flex items-center justify-center">
                            <span class="text-xl">⏰</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-orange-800 dark:text-orange-300">Por Vencer (7 días)
                            </p>
                            <p class="text-xs text-orange-600 dark:text-orange-400">Planificar facturación próximamente
                            </p>
                        </div>
                    </div>
                    <span
                        class="text-2xl font-bold text-orange-700 dark:text-orange-400">{{ $stats['por_vencer'] }}</span>
                </div>
            </button>
        @endif
    </div>

    {{-- FILTROS --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xs border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            {{-- Búsqueda --}}
            <div class="md:col-span-2">
                <x-form.input wire:model.live="search" placeholder="Buscar por placa, cliente o RUC/DNI..."
                    icon="search" />
            </div>

            {{-- Período --}}
            <div>
                <select wire:model.live="filtroPeriodo"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm">
                    <option value="">Todos los períodos</option>
                    <option value="MENSUAL">Mensual</option>
                    <option value="BIMENSUAL">Bimensual</option>
                    <option value="TRIMESTRAL">Trimestral</option>
                    <option value="SEMESTRAL">Semestral</option>
                    <option value="ANUAL">Anual</option>
                </select>
            </div>

            {{-- Fecha desde --}}
            <div>
                <x-form.datetime.picker wire:model.live="fecha_desde" without-time placeholder="Desde" />
            </div>

            {{-- Fecha hasta --}}
            <div>
                <x-form.datetime.picker wire:model.live="fecha_hasta" without-time placeholder="Hasta" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-semibold">{{ $detalles->total() }}</span> mensualidades encontradas
            </div>
            <button wire:click="limpiarFiltros"
                class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                Limpiar filtros
            </button>
        </div>
    </div>

    {{-- TABLA --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-xs border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Vehículo
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Vencimiento
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Monto
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Período
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Documento
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Estado
                        </th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($detalles as $detalle)
                        @php
                            $diasRestantes = \Carbon\Carbon::now()->diffInDays($detalle->fecha, false);
                            $colorFila = '';
                            if ($diasRestantes < 0 && $detalle->estado_facturacion->value === 'SIN_FACTURAR') {
                                $colorFila = 'bg-red-50 dark:bg-red-900/10';
                            } elseif (
                                $diasRestantes <= 7 &&
                                $diasRestantes >= 0 &&
                                $detalle->estado_facturacion->value === 'SIN_FACTURAR'
                            ) {
                                $colorFila = 'bg-orange-50 dark:bg-orange-900/10';
                            }
                        @endphp
                        <tr class="{{ $colorFila }} hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">🚗</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $detalle->vehiculo->placa ?? 'N/A' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $detalle->vehiculo->marca }} {{ $detalle->vehiculo->modelo }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $detalle->cobro->clientes->razon_social ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $detalle->cobro->clientes->numero_documento ?? '' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $detalle->fecha->format('d/m/Y') }}
                                </p>
                                @if ($diasRestantes < 0)
                                    <p class="text-xs text-red-600 dark:text-red-400 font-medium">
                                        Vencido ({{ abs($diasRestantes) }}d)
                                    </p>
                                @elseif($diasRestantes <= 7)
                                    <p class="text-xs text-orange-600 dark:text-orange-400 font-medium">
                                        {{ $diasRestantes }}d restantes
                                    </p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    S/ {{ number_format($detalle->monto_calculado, 2) }}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">
                                    {{ $detalle->cobro->periodo }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($detalle->numero_documento)
                                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                        {{ $detalle->numero_documento }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $detalle->fecha_facturacion?->format('d/m/Y') }}
                                    </p>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">Sin documento</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold {{ $detalle->estado_facturacion->color() }}">
                                    {{ $detalle->estado_facturacion->icon() }}
                                    {{ $detalle->estado_facturacion->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $estadoFacturacion = $detalle->estado_facturacion->value;
                                @endphp

                                @if ($estadoFacturacion === 'SIN_FACTURAR')
                                    <div class="flex items-center justify-center gap-1">
                                        <button wire:click="facturarContado({{ $detalle->id }})"
                                            class="p-1.5 text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300"
                                            title="Facturar y Cobrar (CONTADO)">
                                            <span class="text-lg">💰</span>
                                        </button>
                                        <button wire:click="facturarCredito({{ $detalle->id }})"
                                            class="p-1.5 text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300"
                                            title="Solo Facturar (CRÉDITO)">
                                            <span class="text-lg">📄</span>
                                        </button>
                                    </div>
                                @elseif($estadoFacturacion === 'FACTURADO')
                                    <button wire:click="registrarPago({{ $detalle->id }})"
                                        class="p-1.5 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                        title="Registrar Pago">
                                        <span class="text-lg">💳</span>
                                    </button>
                                @else
                                    <span class="text-emerald-600 dark:text-emerald-400 text-lg">✅</span>
                                @endif

                                <button wire:click="verDetalle({{ $detalle->cobro_id }})"
                                    class="ml-2 p-1.5 text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                                    title="Ver detalle del cobro">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-5xl mb-4">🔍</span>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">No se encontraron
                                        mensualidades</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Ajusta los filtros para
                                        ver más resultados</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if ($detalles->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $detalles->links() }}
            </div>
        @endif
    </div>

    {{-- COMPONENTE FACTURAR Y COBRAR --}}
    @livewire('admin.cobros.facturar-y-cobrar')

    {{-- COMPONENTE PAYMENT (para registrar pagos desde dashboard) --}}
    @livewire('admin.cobros.payment')
</div>
