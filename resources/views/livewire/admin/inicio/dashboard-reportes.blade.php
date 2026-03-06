<div class="space-y-6 mb-8">

    {{-- ── TÍTULO ──────────────────────────────────────────────────────── --}}
    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
        </svg>
        Reportes del mes — indicadores clave
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ── 1. GPS Vendidos — gráfica 6 meses ─────────────────────── --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    📡 GPS Vendidos — últimos 6 meses
                </h3>
            </div>
            {{-- Gráfica --}}
            <div wire:ignore class="grow px-3 pb-4 pt-2" style="min-height:240px;" x-data="ventasBarChart('{{ route('admin.dashboard.chart-ventas', ['tipo' => 'gps']) }}')"
                x-init="init()">
                <canvas x-ref="canvas" style="width:100%;height:220px;"></canvas>
            </div>
        </div>

        {{-- ── 2. Servicio de Monitoreo — gráfica 6 meses ─────────────── --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    🛰️ Servicio de Monitoreo — últimos 6 meses
                </h3>
            </div>
            {{-- Gráfica --}}
            <div wire:ignore class="grow px-3 pb-4 pt-2" style="min-height:240px;" x-data="ventasBarChart('{{ route('admin.dashboard.chart-ventas', ['tipo' => 'monitoreo']) }}')"
                x-init="init()">
                <canvas x-ref="canvas" style="width:100%;height:220px;"></canvas>
            </div>
        </div>

        {{-- ── 3. Suspensiones de Líneas ───────────────────────────────── --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    ⚠️ Suspensiones de Líneas
                </h3>
                <div class="flex gap-2">
                    <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Semana:
                        {{ $suspensionesTotalSemana }}</span>
                    <span class="text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full">Mes:
                        {{ $suspensionesTotalMes }}</span>
                </div>
            </div>
            <div class="p-4 max-h-56 overflow-y-auto">
                @forelse($suspensionesDetallesMes as $linea)
                    <div
                        class="flex items-center justify-between py-1.5 border-b border-slate-50 dark:border-slate-700 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-200">{{ $linea->numero }}</p>
                            <p class="text-xs text-slate-400">{{ $linea->operador }}</p>
                        </div>
                        <span class="text-xs text-slate-400">{{ $linea->updated_at->format('d/m/Y') }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 py-2">Sin suspensiones registradas este mes.</p>
                @endforelse
            </div>
        </div>

        {{-- ── 4. Total Ventas Facturadas — placeholder (ver card full-width abajo) ── --}}

    </div>

    {{-- ── Total Ventas Facturadas — gráfica 6 meses (Ventas + Recibos pagados) ── --}}
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                🧾 Total Ventas Facturadas — últimos 6 meses
            </h3>
        </div>
        <div wire:ignore class="grow px-3 pb-4 pt-2" style="min-height:260px;" x-data="facturadasBarChart('{{ route('admin.dashboard.chart-facturadas') }}')"
            x-init="init()">
            <canvas x-ref="canvas" style="width:100%;height:240px;"></canvas>
        </div>
    </div>

    {{-- ── 5. Facturas y Recibos PAGADOS + Detalle de Método ───────────── --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
            <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                ✅ Pagados — Detalle por método de pago (mes)
            </h3>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Facturas --}}
                <div>
                    <h4 class="text-sm font-semibold text-slate-500 uppercase mb-3 flex items-center justify-between">
                        Facturas pagadas (mes)
                        <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-0.5 rounded-full">
                            {{ $facturasPagadasMes->count() }} · S/
                            {{ number_format($facturasPagadasMes->sum('total'), 2) }}
                        </span>
                    </h4>
                    <div class="space-y-2 mb-3">
                        @forelse($metodosFacturasMes as $metodo)
                            <div
                                class="flex items-center justify-between bg-slate-50 dark:bg-slate-700 rounded-lg px-3 py-2">
                                <span class="text-sm text-slate-600 dark:text-slate-300">
                                    {{ $metodo->paymentMethod->description ?? '(sin método)' }}
                                </span>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-slate-400">{{ $metodo->cantidad }} pago(s)</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-white">S/
                                        {{ number_format($metodo->total, 2) }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">Sin registros de pago este mes.</p>
                        @endforelse
                    </div>
                    <div class="text-xs text-slate-400">Semana: {{ $facturasPagadasSemana->count() }} factura(s) · S/
                        {{ number_format($facturasPagadasSemana->sum('total'), 2) }}</div>
                </div>

                {{-- Recibos --}}
                <div>
                    <h4 class="text-sm font-semibold text-slate-500 uppercase mb-3 flex items-center justify-between">
                        Recibos pagados (mes)
                        <span class="bg-violet-100 text-violet-700 text-xs px-2 py-0.5 rounded-full">
                            {{ $recibosPagadosMes->count() }} · S/
                            {{ number_format($recibosPagadosMes->sum('total'), 2) }}
                        </span>
                    </h4>
                    <div class="space-y-2 mb-3">
                        @forelse($metodosRecibosMes as $metodo)
                            <div
                                class="flex items-center justify-between bg-slate-50 dark:bg-slate-700 rounded-lg px-3 py-2">
                                <span class="text-sm text-slate-600 dark:text-slate-300">
                                    {{ $metodo->paymentMethod->description ?? '(sin método)' }}
                                </span>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-slate-400">{{ $metodo->cantidad }} pago(s)</span>
                                    <span class="text-sm font-semibold text-slate-800 dark:text-white">S/
                                        {{ number_format($metodo->total, 2) }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">Sin registros de pago este mes.</p>
                        @endforelse
                    </div>
                    <div class="text-xs text-slate-400">Semana: {{ $recibosPagadosSemana->count() }} recibo(s) · S/
                        {{ number_format($recibosPagadosSemana->sum('total'), 2) }}</div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── 6. Por Cobrar + Días de Vencimiento ─────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Facturas por cobrar --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    🔴 Facturas por cobrar
                </h3>
                <span class="text-xs bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full">
                    {{ $facturasPorCobrar->count() }} · S/ {{ number_format($facturasPorCobrar->sum('total'), 2) }}
                </span>
            </div>
            <div class="overflow-x-auto max-h-72">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="text-left px-3 py-2 text-slate-500">Comprobante</th>
                            <th class="text-left px-3 py-2 text-slate-500">Cliente</th>
                            <th class="text-right px-3 py-2 text-slate-500">Total</th>
                            <th class="text-center px-3 py-2 text-slate-500">Vence</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($facturasPorCobrar as $venta)
                            @php
                                $dias = $venta->dias_vencimiento;
                                $badge =
                                    $dias < 0
                                        ? 'bg-rose-100 text-rose-700'
                                        : ($dias <= 7
                                            ? 'bg-amber-100 text-amber-700'
                                            : 'bg-slate-100 text-slate-600');
                                $label =
                                    $dias < 0
                                        ? 'Vencido ' . abs($dias) . 'd'
                                        : ($dias === 0
                                            ? 'Vence hoy'
                                            : 'En ' . $dias . 'd');
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-3 py-2 font-medium text-slate-700 dark:text-slate-200">
                                    {{ $venta->serie_correlativo ?? $venta->serie . '-' . $venta->correlativo }}
                                </td>
                                <td class="px-3 py-2 text-slate-500 max-w-[120px] truncate">
                                    {{ $venta->cliente->razon_social ?? '—' }}
                                </td>
                                <td class="px-3 py-2 text-right font-semibold text-slate-800 dark:text-white">
                                    {{ $venta->divisa === 'USD' ? '$' : 'S/' }} {{ number_format($venta->total, 2) }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <span
                                        class="inline-flex px-1.5 py-0.5 rounded text-xs font-medium {{ $badge }}">
                                        {{ $label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-slate-400">Sin facturas pendientes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recibos por cobrar --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <h3 class="font-semibold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                    🟡 Recibos por cobrar
                </h3>
                <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">
                    {{ $recibosPorCobrar->count() }} · S/ {{ number_format($recibosPorCobrar->sum('total'), 2) }}
                </span>
            </div>
            <div class="overflow-x-auto max-h-72">
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="text-left px-3 py-2 text-slate-500">Serie/N°</th>
                            <th class="text-left px-3 py-2 text-slate-500">Cliente</th>
                            <th class="text-right px-3 py-2 text-slate-500">Total</th>
                            <th class="text-center px-3 py-2 text-slate-500">Emisión</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($recibosPorCobrar as $recibo)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="px-3 py-2 font-medium text-slate-700 dark:text-slate-200">
                                    {{ $recibo->serie }}-{{ $recibo->numero }}
                                </td>
                                <td class="px-3 py-2 text-slate-500 max-w-[120px] truncate">
                                    {{ $recibo->cliente->razon_social ?? '—' }}
                                </td>
                                <td class="px-3 py-2 text-right font-semibold text-slate-800 dark:text-white">
                                    {{ $recibo->divisa === 'USD' ? '$' : 'S/' }}
                                    {{ number_format($recibo->total, 2) }}
                                </td>
                                <td class="px-3 py-2 text-center text-slate-400">
                                    {{ $recibo->fecha_emision ? $recibo->fecha_emision->format('d/m/Y') : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-slate-400">Sin recibos
                                    pendientes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
