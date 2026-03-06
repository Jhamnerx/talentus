<div class="mb-8">
    {{-- ── Selector de Fechas ──────────────────────────────────────────── --}}
    <div wire:ignore
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 mb-6"
        x-data="dashboardDatepicker('{{ $fechaInicio }}', '{{ $fechaFin }}')" x-init="init()">
        <div class="flex flex-wrap items-center gap-4">

            {{-- Datepicker --}}
            <div class="relative">
                <input x-ref="input"
                    class="form-input pl-9 dark:bg-slate-700 text-slate-600 dark:text-slate-200 font-medium w-62"
                    placeholder="Seleccionar rango" readonly />
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                    <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16" height="16"
                        viewBox="0 0 16 16">
                        <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                        <path
                            d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                    </svg>
                </div>
            </div>

            {{-- Acceso rápido --}}
            <div class="flex gap-2 flex-wrap">
                <button @click="setPreset('hoy')"
                    class="px-3 py-1.5 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">Hoy</button>
                <button @click="setPreset('semana')"
                    class="px-3 py-1.5 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">Esta
                    semana</button>
                <button @click="setPreset('mes')"
                    class="px-3 py-1.5 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">Este
                    mes</button>
                <button @click="setPreset('ano')"
                    class="px-3 py-1.5 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">Este
                    año</button>
            </div>

        </div>
    </div>

    {{-- ── Cards de resumen ─────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-7 gap-4">

        {{-- Ventas PEN --}}
        <div class="col-span-1 bg-linear-to-br from-blue-500 to-blue-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Ventas PEN</p>
            <p class="text-2xl font-bold mt-1">S/ {{ number_format($resumen['ventas_pen'], 2) }}</p>
            <p class="text-xs opacity-70 mt-1">Facturas emitidas</p>
        </div>

        {{-- Ventas USD --}}
        <div class="col-span-1 bg-linear-to-br from-sky-500 to-sky-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Ventas USD</p>
            <p class="text-2xl font-bold mt-1">$ {{ number_format($resumen['ventas_usd'], 2) }}</p>
            <p class="text-xs opacity-70 mt-1">Facturas emitidas</p>
        </div>

        {{-- Recibos PEN --}}
        <div class="col-span-1 bg-linear-to-br from-violet-500 to-violet-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Recibos PEN</p>
            <p class="text-2xl font-bold mt-1">S/ {{ number_format($resumen['recibos_pen'], 2) }}</p>
            <p class="text-xs opacity-70 mt-1">Recibos emitidos</p>
        </div>

        {{-- Recibos USD --}}
        <div class="col-span-1 bg-linear-to-br from-purple-500 to-purple-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Recibos USD</p>
            <p class="text-2xl font-bold mt-1">$ {{ number_format($resumen['recibos_usd'], 2) }}</p>
            <p class="text-xs opacity-70 mt-1">Recibos emitidos</p>
        </div>

        {{-- Compras --}}
        <div class="col-span-1 bg-linear-to-br from-orange-500 to-orange-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Compras</p>
            <p class="text-2xl font-bold mt-1">S/ {{ number_format($resumen['compras'], 2) }}</p>
            <p class="text-xs opacity-70 mt-1">Total compras</p>
        </div>

        {{-- Ingresos --}}
        <div class="col-span-1 bg-linear-to-br from-emerald-500 to-emerald-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Ingresos</p>
            <p class="text-2xl font-bold mt-1">S/ {{ number_format($resumen['ingresos'], 2) }}</p>
            <p class="text-xs opacity-70 mt-1">Movimientos +</p>
        </div>

        {{-- Egresos --}}
        <div class="col-span-1 bg-linear-to-br from-rose-500 to-rose-700 rounded-xl p-4 text-white shadow">
            <p class="text-xs font-medium uppercase tracking-wide opacity-80">Egresos</p>
            <p class="text-2xl font-bold mt-1">S/ {{ number_format($resumen['egresos'], 2) }}</p>
            <p class="text-xs opacity-70 mt-1">Movimientos -</p>
        </div>

    </div>
</div>
