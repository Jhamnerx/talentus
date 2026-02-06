<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Balance Financiero ✨</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Resumen de la situación financiera</p>
        </div>

        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Date filter dropdown -->
            <div class="relative inline-flex" x-data="{ open: false, selected: 30 }">
                <button
                    class="btn justify-between min-w-37.5 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100"
                    aria-label="Select date range" aria-haspopup="true" @click.prevent="open = !open"
                    :aria-expanded="open">
                    <span class="flex items-center">
                        <svg class="shrink-0 mr-2 fill-current text-gray-500" width="16" height="16"
                            viewBox="0 0 16 16">
                            <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                            <path
                                d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                        </svg>
                        <span
                            x-text="{
                            1: 'Hoy',
                            7: 'Últimos 7 días',
                            30: 'Este Mes',
                            90: 'Último Trimestre'
                        }[selected]"></span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-gray-400" width="11" height="7"
                        viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="z-10 absolute top-full left-0 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak>
                    <button
                        class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3 cursor-pointer"
                        :class="selected === 1 && 'text-violet-500'"
                        @click="selected = 1; open = false; $wire.filter(1)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 1 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Hoy</span>
                    </button>
                    <button
                        class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3 cursor-pointer"
                        :class="selected === 7 && 'text-violet-500'"
                        @click="selected = 7; open = false; $wire.filter(7)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 7 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Últimos 7 días</span>
                    </button>
                    <button
                        class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3 cursor-pointer"
                        :class="selected === 30 && 'text-violet-500'"
                        @click="selected = 30; open = false; $wire.filter(30)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 30 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Este Mes</span>
                    </button>
                    <button
                        class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/20 py-1 px-3 cursor-pointer"
                        :class="selected === 90 && 'text-violet-500'"
                        @click="selected = 90; open = false; $wire.filter(90)">
                        <svg class="shrink-0 mr-2 fill-current text-violet-500" :class="selected !== 90 && 'invisible'"
                            width="12" height="9" viewBox="0 0 12 9">
                            <path
                                d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                        </svg>
                        <span>Último Trimestre</span>
                    </button>
                </div>
            </div>
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
                            Por Cobrar
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
                            Por Pagar
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
