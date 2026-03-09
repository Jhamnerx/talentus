<div class="space-y-6 mb-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Tabla: Productos con menos stock ────────────────────────── --}}
        <div
            class="lg:col-span-1 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                    📦 Stock bajo
                </h3>
                <a href="{{ route('admin.almacen.productos.index') }}" class="text-xs text-indigo-500 hover:underline">Ver
                    todos</a>
            </div>
            <div class="overflow-x-auto max-h-72">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="text-left px-3 py-2 text-slate-500">Producto</th>
                            <th class="text-center px-3 py-2 text-slate-500">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($productosStockBajo as $producto)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-3 py-2">
                                    <p class="font-medium text-slate-700 dark:text-slate-200 truncate max-w-40">
                                        {{ $producto->descripcion }}</p>
                                    <p class="text-slate-400">{{ $producto->categoria->nombre ?? '—' }}</p>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    @php
                                        $colorStock =
                                            $producto->stock <= 0
                                                ? 'bg-rose-100 text-rose-700'
                                                : ($producto->stock <= 5
                                                    ? 'bg-amber-100 text-amber-700'
                                                    : 'bg-emerald-100 text-emerald-700');
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $colorStock }}">
                                        {{ $producto->stock }} {{ $producto->unit->descripcion ?? '' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-3 py-4 text-center text-slate-400">Sin productos
                                    registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── Cards: Tickets + Work Orders ────────────────────────────── --}}
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Tickets por estado --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                <div
                    class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                        🎫 Tickets
                    </h3>
                    <span
                        class="text-xs bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-2 py-0.5 rounded-full">
                        {{ $totalTickets }} total
                    </span>
                </div>
                <div class="p-4 space-y-2">
                    @forelse($ticketsPorEstado as $item)
                        <div class="flex items-center justify-between">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $item['color'] }}">
                                {{ $item['estado'] }}
                            </span>
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-slate-100 dark:bg-slate-700 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full bg-indigo-400"
                                        style="width: {{ $totalTickets > 0 ? round(($item['total'] / $totalTickets) * 100) : 0 }}%">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-bold text-slate-700 dark:text-slate-200 w-6 text-right">{{ $item['total'] }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-4">Sin tickets registrados.</p>
                    @endforelse
                </div>
                <div class="px-5 pb-3">
                    <a href="{{ route('admin.tickets.index') }}" class="text-xs text-indigo-500 hover:underline">Ver
                        tickets →</a>
                </div>
            </div>

            {{-- Work Orders por estado --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                <div
                    class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                        🔧 Órdenes de Trabajo
                    </h3>
                    <span
                        class="text-xs bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-2 py-0.5 rounded-full">
                        {{ $totalWorkOrders }} total
                    </span>
                </div>
                <div class="p-4 space-y-2">
                    @forelse($workOrdersPorEstado as $item)
                        <div class="flex items-center justify-between">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $item['color'] }}">
                                {{ $item['label'] }}
                            </span>
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-slate-100 dark:bg-slate-700 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full bg-orange-400"
                                        style="width: {{ $totalWorkOrders > 0 ? round(($item['total'] / $totalWorkOrders) * 100) : 0 }}%">
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-bold text-slate-700 dark:text-slate-200 w-6 text-right">{{ $item['total'] }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-4">Sin órdenes de trabajo.</p>
                    @endforelse
                </div>
                <div class="px-5 pb-3">
                    <a href="{{ route('admin.work-orders.index') }}"
                        class="text-xs text-indigo-500 hover:underline">Ver órdenes →</a>
                </div>
            </div>

        </div>

    </div>

    {{-- ── Segunda fila: Clientes activos + Dispositivos por modelo ─────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Clientes con vehículos activos y suscripción --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                    🚗 Clientes con vehículos activos y suscripción
                </h3>
                <span
                    class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">{{ $clientesActivos->count() }}</span>
            </div>
            <div class="overflow-x-auto max-h-80">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="text-left px-3 py-2 text-slate-500">Cliente</th>
                            <th class="text-center px-3 py-2 text-slate-500">Vehículos activos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($clientesActivos as $cliente)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-3 py-2">
                                    <p class="font-medium text-slate-700 dark:text-slate-200 truncate max-w-[200px]">
                                        {{ $cliente->razon_social }}</p>
                                    <p class="text-slate-400">{{ $cliente->numero_documento }}</p>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                        {{ $cliente->vehiculos_activos_count }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-3 py-4 text-center text-slate-400">Sin clientes con
                                    suscripción activa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Dispositivos por modelo --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2 text-sm">
                    📟 Dispositivos por modelo
                </h3>
                <a href="{{ route('admin.almacen.dispositivos.index') }}"
                    class="text-xs text-indigo-500 hover:underline">Ver todos</a>
            </div>
            <div class="overflow-x-auto max-h-80">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="text-left px-3 py-2 text-slate-500">Modelo</th>
                            <th class="text-center px-3 py-2 text-slate-500">Total</th>
                            <th class="text-center px-3 py-2 text-slate-500">Vendidos</th>
                            <th class="text-center px-3 py-2 text-slate-500">En stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($dispositivosPorModelo as $modelo)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-3 py-2 font-medium text-slate-700 dark:text-slate-200">
                                    {{ $modelo->modelo }}</td>
                                <td class="px-3 py-2 text-center font-bold text-slate-800 dark:text-white">
                                    {{ $modelo->total }}</td>
                                <td class="px-3 py-2 text-center">
                                    <span class="text-blue-600 font-medium">{{ $modelo->vendidos }}</span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span class="text-emerald-600 font-medium">{{ $modelo->en_stock }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-4 text-center text-slate-400">Sin modelos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
