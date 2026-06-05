<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    {{-- Encabezado --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Proyección de Cobros</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Periodos pendientes de cobros activos en el rango
                seleccionado</p>
        </div>

        {{-- Totales resumen --}}
        <div class="flex flex-wrap gap-3">
            @if ($totalItems > 0)
                <div
                    class="bg-violet-50 dark:bg-violet-900/20 border border-violet-200 dark:border-violet-700 rounded-lg px-4 py-2 text-center">
                    <p class="text-xs text-violet-600 dark:text-violet-400 font-medium">Total períodos</p>
                    <p class="text-lg font-bold text-violet-700 dark:text-violet-300">{{ $totalItems }}</p>
                </div>
                @if ($totalPen > 0)
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-lg px-4 py-2 text-center">
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Total S/.</p>
                        <p class="text-lg font-bold text-emerald-700 dark:text-emerald-300">S/
                            {{ number_format($totalPen, 2) }}</p>
                    </div>
                @endif
                @if ($totalUsd > 0)
                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg px-4 py-2 text-center">
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Total $</p>
                        <p class="text-lg font-bold text-blue-700 dark:text-blue-300">$
                            {{ number_format($totalUsd, 2) }}</p>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Fecha desde --}}
            <x-form.datetime.picker label="Desde" wire:model.live="fechaDesde" parse-format="YYYY-MM-DD"
                display-format="DD/MM/YYYY" without-time :clearable=false />

            {{-- Fecha hasta --}}
            <x-form.datetime.picker label="Hasta" wire:model.live="fechaHasta" parse-format="YYYY-MM-DD"
                display-format="DD/MM/YYYY" without-time :clearable=false />

            {{-- Tipo de comprobante --}}
            <x-form.select label="Tipo de comprobante" wire:model.live="tipoPago" placeholder="Todos" :options="[
                ['value' => 'FACTURA', 'label' => 'Facturas por cobrar'],
                ['value' => 'RECIBO', 'label' => 'Recibos por cobrar'],
            ]"
                option-label="label" option-value="value" />

            {{-- Agrupar por --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Agrupar por</label>
                <div class="flex rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600">
                    <button wire:click="$set('agruparPor', 'dia')" @class([
                        'flex-1 text-sm py-2 font-medium transition',
                        'bg-violet-600 text-white' => $agruparPor === 'dia',
                        'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600' =>
                            $agruparPor !== 'dia',
                    ])>Día</button>
                    <button wire:click="$set('agruparPor', 'semana')" @class([
                        'flex-1 text-sm py-2 font-medium transition border-l border-gray-300 dark:border-gray-600',
                        'bg-violet-600 text-white' => $agruparPor === 'semana',
                        'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600' =>
                            $agruparPor !== 'semana',
                    ])>Semana</button>
                </div>
            </div>

        </div>

        {{-- Accesos rápidos de rango --}}
        <div class="mt-3 flex flex-wrap gap-2">
            <span class="text-xs text-gray-400 dark:text-gray-500 self-center">Rango rápido:</span>
            <button wire:click="$set('fechaHasta', '{{ \Carbon\Carbon::today()->format('Y-m-d') }}')"
                wire:click.then="$set('fechaDesde', '{{ \Carbon\Carbon::today()->format('Y-m-d') }}')"
                class="text-xs px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                onclick="
                    let today = new Date().toISOString().split('T')[0];
                    @this.set('fechaDesde', today);
                    @this.set('fechaHasta', today);
                ">Hoy</button>
            <button
                class="text-xs px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                onclick="
                    let today = new Date();
                    let from = today.toISOString().split('T')[0];
                    let to = new Date(today.setDate(today.getDate()+6)).toISOString().split('T')[0];
                    @this.set('fechaDesde', from);
                    @this.set('fechaHasta', to);
                ">Próximos
                7 días</button>
            <button
                class="text-xs px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                onclick="
                    let today = new Date();
                    let from = today.toISOString().split('T')[0];
                    let to = new Date(today.setDate(today.getDate()+29)).toISOString().split('T')[0];
                    @this.set('fechaDesde', from);
                    @this.set('fechaHasta', to);
                ">Próximos
                30 días</button>
            <button
                class="text-xs px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                onclick="
                    let d = new Date();
                    let from = new Date(d.getFullYear(), d.getMonth(), 1).toISOString().split('T')[0];
                    let to = new Date(d.getFullYear(), d.getMonth()+1, 0).toISOString().split('T')[0];
                    @this.set('fechaDesde', from);
                    @this.set('fechaHasta', to);
                ">Este
                mes</button>
            <button
                class="text-xs px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                onclick="
                    let d = new Date();
                    let from = new Date(d.getFullYear(), d.getMonth()+1, 1).toISOString().split('T')[0];
                    let to = new Date(d.getFullYear(), d.getMonth()+2, 0).toISOString().split('T')[0];
                    @this.set('fechaDesde', from);
                    @this.set('fechaHasta', to);
                ">Próximo
                mes</button>
        </div>
    </div>

    {{-- Resultados --}}
    <div wire:loading.class="opacity-50" class="transition-opacity space-y-4">

        @forelse($agrupados as $clave => $periodos)
            @php
                if ($agruparPor === 'semana') {
                    [$semDes, $semHas] = explode('|', $clave);
                    $labelGrupo =
                        'Semana del ' .
                        \Carbon\Carbon::parse($semDes)->format('d M') .
                        ' al ' .
                        \Carbon\Carbon::parse($semHas)->format('d M Y');
                } else {
                    $fecha = \Carbon\Carbon::parse($clave);
                    $labelGrupo = ucfirst($fecha->translatedFormat('l, d \d\e F Y'));
                    $esHoy = $fecha->isToday();
                    $esManana = $fecha->isTomorrow();
                    if ($esHoy) {
                        $labelGrupo = 'HOY — ' . $labelGrupo;
                    }
                    if ($esManana) {
                        $labelGrupo = 'MAÑANA — ' . $labelGrupo;
                    }
                }
                $subtotalPen = $periodos->filter(fn($p) => $p->cobro?->divisa === 'PEN')->sum('monto');
                $subtotalUsd = $periodos->filter(fn($p) => $p->cobro?->divisa === 'USD')->sum('monto');
            @endphp

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                {{-- Cabecera del grupo --}}
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-sm text-gray-700 dark:text-gray-200">{{ $labelGrupo }}</span>
                        <span class="text-xs text-gray-400 dark:text-gray-500">({{ $periodos->count() }}
                            período{{ $periodos->count() !== 1 ? 's' : '' }})</span>
                    </div>
                    <div class="flex items-center gap-3">
                        @if ($subtotalPen > 0)
                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">S/
                                {{ number_format($subtotalPen, 2) }}</span>
                        @endif
                        @if ($subtotalUsd > 0)
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">$
                                {{ number_format($subtotalUsd, 2) }}</span>
                        @endif
                    </div>
                </div>

                {{-- Tabla de períodos --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr
                                class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wide border-b border-gray-100 dark:border-gray-700">
                                <th class="text-left px-4 py-2">Cliente</th>
                                <th class="text-left px-4 py-2">Placa</th>
                                <th class="text-left px-4 py-2">Plan</th>
                                <th class="text-left px-4 py-2">Tipo</th>
                                <th class="text-left px-4 py-2">Vence</th>
                                <th class="text-right px-4 py-2">Monto</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($periodos as $periodo)
                                @php
                                    $cobro = $periodo->cobro;
                                    $cliente = $cobro?->clientes;
                                    $placa = $periodo->vehiculo?->placa ?? ($cobro?->vehiculo?->placa ?? '—');
                                    $plan = $cobro?->plan_nombre ?? '—';
                                    $tipo = $cobro?->tipo_pago ?? '—';
                                    $divisa = $cobro?->divisa === 'USD' ? '$' : 'S/';
                                    $vencido = \Carbon\Carbon::parse($periodo->fecha_fin)->isPast();
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                    <td class="px-4 py-2.5">
                                        <p class="font-medium text-gray-800 dark:text-gray-200 truncate max-w-[200px]">
                                            {{ $cliente?->razon_social ?? ($cliente?->nombre ?? '—') }}
                                        </p>
                                        @if ($cliente?->numero_documento)
                                            <p class="text-xs text-gray-400">{{ $cliente->numero_documento }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <span
                                            class="font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">{{ $placa }}</span>
                                    </td>
                                    <td class="px-4 py-2.5 text-gray-600 dark:text-gray-400 text-xs">
                                        {{ $plan }}</td>
                                    <td class="px-4 py-2.5">
                                        @if ($tipo === 'FACTURA')
                                            <span
                                                class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300">
                                                Factura
                                            </span>
                                        @elseif($tipo === 'RECIBO')
                                            <span
                                                class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300">
                                                Recibo
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">{{ $tipo }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <span @class([
                                            'text-xs font-medium',
                                            'text-red-600 dark:text-red-400' => $vencido,
                                            'text-gray-600 dark:text-gray-400' => !$vencido,
                                        ])>
                                            {{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }}
                                            @if ($vencido)
                                                <span class="ml-1">(vencido)</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5 text-right font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $divisa }} {{ number_format($periodo->monto, 2) }}
                                    </td>
                                    <td class="px-4 py-2.5 text-right">
                                        @if ($cobro)
                                            <button
                                                wire:click="$dispatch('abrirVerPeriodos', { cobroId: {{ $cobro->id }} })"
                                                class="inline-flex items-center gap-1 text-xs text-violet-600 dark:text-violet-400 hover:text-violet-800 dark:hover:text-violet-200 font-medium transition">
                                                Ver períodos
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        @empty
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">No hay períodos pendientes en el rango
                    seleccionado</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Ajusta las fechas o el filtro de tipo de
                    comprobante</p>
            </div>
        @endforelse

    </div>

    {{-- Indicador de carga --}}
    <div wire:loading
        class="fixed bottom-6 right-6 bg-violet-600 text-white text-sm px-4 py-2 rounded-lg shadow-lg flex items-center gap-2">
        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Cargando...
    </div>

</div>
