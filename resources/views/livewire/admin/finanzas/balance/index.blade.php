<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Balance Financiero ✨</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Resumen de la situación financiera</p>
        </div>
    </div>

    <!-- Filtros de fecha personalizados -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-form.datetime.picker label="Desde:" wire:model.live="from" without-time parse-format="YYYY-MM-DD"
                    display-format="DD-MM-YYYY" />
            </div>
            <div>
                <x-form.datetime.picker label="Hasta:" wire:model.live="to" without-time parse-format="YYYY-MM-DD"
                    display-format="DD-MM-YYYY" />
            </div>
            <div class="flex items-end">
                <div class="grid grid-cols-3 gap-2 w-full">
                    <x-form.button label="Hoy" wire:click="filter(1)" sm flat primary />
                    <x-form.button label="7 días" wire:click="filter(7)" sm flat secondary />
                    <x-form.button label="3 Meses" wire:click="filter(90)" sm flat warning />
                    <x-form.button label="Mes Pasado" wire:click="filter('last_month')" sm flat info />
                    <x-form.button label="Este Mes" wire:click="filter(30)" sm flat positive />
                </div>
            </div>
        </div>
        <div class="mt-2 text-center text-xs text-gray-500 dark:text-gray-400">
            Mostrando datos desde {{ date('d/m/Y', strtotime($from)) }} hasta {{ date('d/m/Y', strtotime($to)) }}
        </div>
    </div>

    <!-- Métricas principales -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Saldo en Cajas -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-full bg-violet-100 dark:bg-violet-500/10">
                        <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Saldo en Cajas
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                S/ {{ number_format($saldoTotalCajas, 2) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Balance del Período -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-full {{ $balance >= 0 ? 'bg-emerald-100 dark:bg-emerald-500/10' : 'bg-rose-100 dark:bg-rose-500/10' }}">
                        <svg class="w-6 h-6 {{ $balance >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Balance Período
                        </dt>
                        <dd class="flex items-baseline">
                            <div
                                class="text-2xl font-semibold {{ $balance >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                {{ $balance >= 0 ? '+' : '' }} S/ {{ number_format($balance, 2) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Por Cobrar -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-500/10">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Por Cobrar (Total)
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                S/ {{ number_format($totalPorCobrar, 2) }}
                            </div>
                        </dd>
                        @if ($cuentasVencidas > 0)
                            <dd class="mt-1 text-xs text-rose-600 dark:text-rose-400">
                                {{ $cuentasVencidas }} vencida(s)
                            </dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Por Pagar -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-500/10">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Por Pagar (Total)
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                S/ {{ number_format($totalPorPagar, 2) }}
                            </div>
                        </dd>
                        @if ($cuentasPorPagarVencidas > 0)
                            <dd class="mt-1 text-xs text-rose-600 dark:text-rose-400">
                                {{ $cuentasPorPagarVencidas }} vencida(s)
                            </dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas del Período Seleccionado -->
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            📊 Análisis del Período Seleccionado
        </h3>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        <!-- Facturado y Pagado -->
        <div
            class="bg-linear-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 shadow-sm rounded-lg border border-emerald-200 dark:border-emerald-700/50 p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-full bg-emerald-200 dark:bg-emerald-700/30">
                        <svg class="w-6 h-6 text-emerald-700 dark:text-emerald-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-emerald-700 dark:text-emerald-300 truncate">
                            ✅ Facturado y Pagado
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-emerald-900 dark:text-emerald-100">
                                S/ {{ number_format($facturadoYPagado, 2) }}
                            </div>
                        </dd>
                        <dd class="mt-1 text-xs text-emerald-600 dark:text-emerald-400">
                            {{ $documentosPagados }} documento(s) pagado(s)
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Facturado Pendiente -->
        <div
            class="bg-linear-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 shadow-sm rounded-lg border border-blue-200 dark:border-blue-700/50 p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-200 dark:bg-blue-700/30">
                        <svg class="w-6 h-6 text-blue-700 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-blue-700 dark:text-blue-300 truncate">
                            📄 Facturado Pendiente
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-blue-900 dark:text-blue-100">
                                S/ {{ number_format($facturadoPendiente, 2) }}
                            </div>
                        </dd>
                        <dd class="mt-1 text-xs text-blue-600 dark:text-blue-400">
                            {{ $documentosPendientes }} por cobrar
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Pendiente de Facturar -->
        <div
            class="bg-linear-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 shadow-sm rounded-lg border border-amber-200 dark:border-amber-700/50 p-5">
            <div class="flex items-center">
                <div class="shrink-0">
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-full bg-amber-200 dark:bg-amber-700/30">
                        <svg class="w-6 h-6 text-amber-700 dark:text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-amber-700 dark:text-amber-300 truncate">
                            ⏳ Pendiente de Facturar
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-amber-900 dark:text-amber-100">
                                S/ {{ number_format($pendienteFacturar, 2) }}
                            </div>
                        </dd>
                        <dd class="mt-1 text-xs text-amber-600 dark:text-amber-400">
                            {{ $detallesSinFacturarCount }} cobro(s) por facturar
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y detalles -->
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 mb-8">
        <!-- Ingresos vs Egresos -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 p-5">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Movimientos del Período</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Ingresos</span>
                        <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">S/
                            {{ number_format($ingresos, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                        <div class="bg-emerald-600 h-2.5 rounded-full"
                            style="width: {{ $ingresos + $egresos > 0 ? ($ingresos / ($ingresos + $egresos)) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Egresos</span>
                        <span class="text-sm font-semibold text-rose-600 dark:text-rose-400">S/
                            {{ number_format($egresos, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                        <div class="bg-rose-600 h-2.5 rounded-full"
                            style="width: {{ $ingresos + $egresos > 0 ? ($egresos / ($ingresos + $egresos)) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liquidez Neta -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60 p-5">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Liquidez Neta</h3>
            <div class="text-center py-4">
                <div
                    class="text-5xl font-bold {{ $liquidezNeta >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} mb-2">
                    S/ {{ number_format($liquidezNeta, 2) }}
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Caja + Por Cobrar - Por Pagar
                </p>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    <div class="text-xs text-gray-500 dark:text-gray-400">En Caja</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($saldoTotalCajas, 0) }}</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-500 dark:text-gray-400">+ Cobrar</div>
                    <div class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                        {{ number_format($totalPorCobrar, 0) }}</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-500 dark:text-gray-400">- Pagar</div>
                    <div class="text-sm font-semibold text-amber-600 dark:text-amber-400">
                        {{ number_format($totalPorPagar, 0) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
