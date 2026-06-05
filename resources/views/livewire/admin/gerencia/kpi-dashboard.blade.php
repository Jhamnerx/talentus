<div>
    {{-- ============================
         ENCABEZADO
    =============================== --}}
    <div class="p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Dashboard KPI — MOF Talentus
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Semáforo de indicadores clave de rendimiento por área
                </p>
            </div>

            {{-- Selector de período --}}
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500 dark:text-gray-400 hidden sm:inline">Período:</span>
                <div class="flex rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button wire:click="setPeriodo('semana')"
                        class="px-3 py-1.5 text-xs font-medium transition-colors
                            {{ $periodo === 'semana'
                                ? 'bg-rose-500 text-white'
                                : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50' }}">
                        Esta semana
                    </button>
                    <button wire:click="setPeriodo('mes')"
                        class="px-3 py-1.5 text-xs font-medium transition-colors border-l border-gray-200 dark:border-gray-700
                            {{ $periodo === 'mes'
                                ? 'bg-rose-500 text-white'
                                : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-50' }}">
                        Este mes
                    </button>
                </div>
                <span class="text-xs text-gray-400 dark:text-gray-500">
                    {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m') }}
                    – {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                </span>
                <button wire:click="calcular" wire:loading.attr="disabled"
                    class="p-1.5 rounded-md bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-gray-500 dark:text-gray-400"
                    title="Recalcular">
                    <svg wire:loading.class="animate-spin" class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ============================
         WIGs - WILDLY IMPORTANT GOALS
    =============================== --}}
    @if (count($wigs))
        <div class="px-4 sm:px-6 pb-4">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-3">
                🎯 WIGs — Metas Verdaderamente Importantes
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
                @foreach ($wigs as $wig)
                    @php
                        $pct = min($wig['porcentaje'], 100);
                        $barColor = match ($wig['semaforo']) {
                            'verde' => 'bg-emerald-500',
                            'amarillo' => 'bg-amber-500',
                            default => 'bg-red-500',
                        };
                        $borderColor = match ($wig['semaforo']) {
                            'verde' => 'border-emerald-200 dark:border-emerald-800',
                            'amarillo' => 'border-amber-200 dark:border-amber-800',
                            default => 'border-red-200 dark:border-red-800',
                        };
                        $badgeCss = match ($wig['semaforo']) {
                            'verde' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300',
                            'amarillo' => 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300',
                            default => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                        };
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-xl border {{ $borderColor }} p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div>
                                <p class="text-xs font-medium text-gray-600 dark:text-gray-400 leading-tight">
                                    {{ $wig['titulo'] }}
                                </p>
                                @if ($wig['responsable'])
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $wig['responsable'] }}
                                    </p>
                                @endif
                            </div>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full shrink-0 {{ $badgeCss }}">
                                {{ $pct }}%
                            </span>
                        </div>

                        {{-- Barra de progreso --}}
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2 mb-2">
                            <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500"
                                style="width: {{ $pct }}%">
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>Actual: <strong
                                    class="text-gray-900 dark:text-white">{{ number_format($wig['valor_actual'], 1) }}{{ $wig['unidad'] }}</strong></span>
                            <span>Meta:
                                <strong>{{ number_format($wig['meta'], 0) }}{{ $wig['unidad'] }}</strong></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ============================
         KPIs POR ÁREA
    =============================== --}}
    <div class="px-4 sm:px-6 pb-4">
        <h2 class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-3">
            📊 KPIs por Área
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-4">
            @foreach ($kpisPorArea as $areaKey => $area)
                @php
                    $areaBorderColor = match ($area['semaforo']) {
                        'verde' => 'border-t-emerald-500',
                        'amarillo' => 'border-t-amber-500',
                        default => 'border-t-red-500',
                    };
                    $areaHeaderBg = match ($area['color']) {
                        'blue' => 'from-blue-500 to-blue-600',
                        'orange' => 'from-orange-500 to-orange-600',
                        'purple' => 'from-purple-500 to-purple-600',
                        'teal' => 'from-teal-500 to-teal-600',
                        'indigo' => 'from-indigo-500 to-indigo-600',
                        'rose' => 'from-rose-500 to-rose-600',
                        default => 'from-gray-500 to-gray-600',
                    };
                    $semaforoEmoji = match ($area['semaforo']) {
                        'verde' => '🟢',
                        'amarillo' => '🟡',
                        default => '🔴',
                    };
                @endphp
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden border-t-4 {{ $areaBorderColor }}">
                    {{-- Header del área --}}
                    <div
                        class="px-4 py-3 flex items-center justify-between bg-gray-50 dark:bg-gray-750 border-b border-gray-100 dark:border-gray-700">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $area['nombre'] }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $area['responsable'] }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Cumpl. prom.:</span>
                            <span
                                class="text-sm font-bold {{ $area['semaforo'] === 'verde' ? 'text-emerald-600' : ($area['semaforo'] === 'amarillo' ? 'text-amber-600' : 'text-red-600') }}">
                                {{ number_format($area['cumplimiento_promedio'] ?? 0, 0) }}%
                            </span>
                            <span class="text-lg">{{ $semaforoEmoji }}</span>
                        </div>
                    </div>

                    {{-- KPIs de esta área --}}
                    <div class="divide-y divide-gray-50 dark:divide-gray-700">
                        @forelse($area['kpis'] as $kpi)
                            @php
                                $semCss = match ($kpi['semaforo']) {
                                    'verde'
                                        => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                    'amarillo'
                                        => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                                    default => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                };
                                $barCss = match ($kpi['semaforo']) {
                                    'verde' => 'bg-emerald-500',
                                    'amarillo' => 'bg-amber-500',
                                    default => 'bg-red-500',
                                };
                                $cumplPct = min($kpi['cumplimiento'], 100);
                            @endphp
                            <div class="px-4 py-3">
                                <div class="flex items-start justify-between gap-3 mb-1.5">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-gray-800 dark:text-gray-200 truncate">
                                            {{ $kpi['nombre'] }}
                                        </p>
                                        @if ($kpi['responsable'])
                                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                                {{ $kpi['responsable'] }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <div class="text-right">
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                                {{ number_format($kpi['valor_actual'], 1) }}{{ $kpi['unidad'] }}
                                            </span>
                                            <span class="text-xs text-gray-400 dark:text-gray-500 block">
                                                / {{ number_format($kpi['valor_meta'], 0) }}{{ $kpi['unidad'] }}
                                            </span>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $semCss }}">
                                            {{ $kpi['cumplimiento'] }}%
                                        </span>
                                        {{-- Botón edición manual --}}
                                        @php
                                            $esManual =
                                                \App\Models\Kpi::where('slug', $kpi['slug'])->value('tipo') ===
                                                'manual';
                                        @endphp
                                        @if ($esManual)
                                            <button wire:click="abrirModalManual({{ $kpi['kpi_id'] }})"
                                                class="p-1 rounded text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors"
                                                title="Actualizar valor manualmente">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                {{-- Barra de progreso --}}
                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="{{ $barCss }} h-1.5 rounded-full transition-all duration-500"
                                        style="width: {{ $cumplPct }}%">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-4 text-center text-xs text-gray-400 dark:text-gray-500">
                                Sin datos para el período
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============================
         SCOREBOARD / TABLA RESUMEN
    =============================== --}}
    @if (count($scoreboardRows))
        <div class="px-4 sm:px-6 pb-6">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-3">
                📋 Scoreboard — Resumen General
            </h2>
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Área</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    KPI</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Meta</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Actual</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Cumpl.</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Estado</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Responsable</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($scoreboardRows as $row)
                                @php
                                    $semCss = match ($row['semaforo']) {
                                        'verde'
                                            => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                        'amarillo'
                                            => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                                        default => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                    };
                                    $areaBadgeCss = match ($row['color'] ?? 'gray') {
                                        'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                                        'orange'
                                            => 'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300',
                                        'purple'
                                            => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
                                        'teal' => 'bg-teal-100 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300',
                                        'indigo'
                                            => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300',
                                        'rose' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300',
                                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                    };
                                    $dot = match ($row['semaforo']) {
                                        'verde' => 'bg-emerald-500',
                                        'amarillo' => 'bg-amber-500',
                                        default => 'bg-red-500',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                    <td class="px-4 py-2.5">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $areaBadgeCss }}">
                                            {{ $row['area_nombre'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5 text-gray-800 dark:text-gray-200 max-w-xs">
                                        <span class="text-xs font-medium">{{ $row['nombre'] }}</span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            {{ number_format($row['valor_meta'], 0) }}{{ $row['unidad'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span class="text-xs font-bold text-gray-900 dark:text-white">
                                            {{ number_format($row['valor_actual'], 1) }}{{ $row['unidad'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span
                                            class="text-xs font-semibold {{ $row['semaforo'] === 'verde' ? 'text-emerald-600' : ($row['semaforo'] === 'amarillo' ? 'text-amber-600' : 'text-red-600') }}">
                                            {{ $row['cumplimiento'] }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $semCss }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                                            {{ ucfirst($row['semaforo']) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <span
                                            class="text-xs text-gray-600 dark:text-gray-400">{{ $row['responsable'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pie con leyenda --}}
                <div
                    class="px-4 py-3 bg-gray-50 dark:bg-gray-700/30 border-t border-gray-100 dark:border-gray-700 flex flex-wrap items-center gap-4">
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Leyenda:</span>
                    <span class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Verde = Meta alcanzada
                    </span>
                    <span class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span> Amarillo = Dentro del 80%
                    </span>
                    <span class="flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span> Rojo = Por debajo del umbral
                    </span>
                    <span class="ml-auto text-xs text-gray-400 dark:text-gray-500">
                        Última actualización: {{ now()->timezone('America/Lima')->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================
         MODAL EDICIÓN MANUAL
    =============================== --}}
    <x-form.modal.card :title="'Actualizar KPI: ' . $kpiNombreEditar" wire:model.live="modalManual" max-width="md">

        <div class="space-y-4">
            <div>
                <x-form.input wire:model="valorManual" label="Valor actual" type="number" min="0"
                    step="0.01" placeholder="0" />
                @error('valorManual')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-form.textarea wire:model="notasManual" label="Notas / observaciones"
                    placeholder="Describe brevemente el contexto del resultado..." rows="3" />
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                <p>Período: <strong>{{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}</strong>
                    al <strong>{{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</strong></p>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-button flat label="Cancelar" wire:click="$set('modalManual', false)" />
                <x-button primary label="Guardar" wire:click="guardarManual" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
