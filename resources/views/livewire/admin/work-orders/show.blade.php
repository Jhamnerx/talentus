<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto">
    {{-- Botón Regresar --}}
    <div class="mb-6">
        <a href="{{ route('admin.work-orders.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver al Listado
        </a>
    </div>

    {{-- Header con Información Principal --}}
    @php
        $cliente = $workOrder->cliente ?? $workOrder->vehiculo?->cliente;
        $vehiculo = $workOrder->vehiculo;
    @endphp

    <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">

        {{-- ── Barra superior: código + estado + fechas ── --}}
        <div class="bg-linear-to-r from-slate-800 to-slate-700 dark:from-slate-900 dark:to-slate-800 px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="shrink-0 w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-lg font-bold text-white tracking-tight">
                                {{ $workOrder->codigo ?? ('OT-' . str_pad($workOrder->id, 5, '0', STR_PAD_LEFT)) }}
                            </h1>
                            @if ($workOrder->es_proyecto)
                                <span class="px-2 py-0.5 rounded text-xs font-semibold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30">
                                    PROYECTO
                                </span>
                            @endif
                            @if ($workOrder->bloqueado)
                                <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-500/30 text-gray-200 border border-gray-400/30">
                                    🔒 BLOQUEADO
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Creada {{ $workOrder->created_at->format('d/m/Y H:i') }}
                            · por {{ $workOrder->creador->name ?? 'Sistema' }}
                        </p>
                    </div>
                </div>

                <span class="self-start sm:self-auto px-4 py-1.5 rounded-full text-sm font-bold {{ $workOrder->estado->statusColor() }}">
                    {{ $workOrder->estado->label() }}
                </span>
            </div>
        </div>

        {{-- ── Cuerpo: cuadrícula de datos ── --}}
        @php
            $meta            = $workOrder->metadata ?? [];
            $metaAccesorios  = $meta['accesorios'] ?? [];
            $metaAlertas     = $meta['alertas'] ?? [];
            $operadorSim     = $meta['operador_sim'] ?? null;
            $modeloDispId    = $meta['modelo_dispositivo_id'] ?? null;
            $modeloDisp      = $modeloDispId ? \App\Models\ModelosDispositivo::find((int) $modeloDispId) : null;
            $equipoTexto     = $modeloDisp
                ? trim(strtoupper(($modeloDisp->marca ?? '') . ' ' . ($modeloDisp->modelo ?? '')))
                : null;
            $accesorioLabels = array_values(array_filter(
                array_map(fn($k) => \App\Services\WorkOrderNotificationService::ACCESORIOS[$k] ?? null, $metaAccesorios)
            ));
            $alertaLabels = array_values(array_filter(
                array_map(fn($k) => \App\Services\WorkOrderNotificationService::ALERTAS[$k] ?? null, $metaAlertas)
            ));
        @endphp
        <div class="divide-y divide-gray-100 dark:divide-gray-700/60">

            {{-- Fila 1: Tipo + Cliente + Vehículo --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 dark:divide-gray-700/60">

                {{-- Tipo de Orden --}}
                <div class="px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tipo de Orden</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">
                            {{ $workOrder->tipo->nombre ?? '—' }}
                        </p>
                        @if ($workOrder->es_proyecto && $workOrder->titulo_proyecto)
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">{{ $workOrder->titulo_proyecto }}</p>
                        @endif
                    </div>
                </div>

                {{-- Cliente --}}
                <div class="px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Cliente</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5 truncate">
                            {{ $cliente->razon_social ?? '—' }}
                        </p>
                        @if ($cliente?->ruc)
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-0.5">RUC: {{ $cliente->ruc }}</p>
                        @endif
                    </div>
                </div>

                {{-- Vehículo --}}
                @if (!$workOrder->es_proyecto)
                    <div class="px-5 py-4 flex items-start gap-3">
                        <div class="shrink-0 mt-0.5 w-8 h-8 bg-amber-50 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Vehículo</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white font-mono mt-0.5">
                                {{ $vehiculo->placa ?? '—' }}
                            </p>
                            @if ($vehiculo)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ implode(' · ', array_filter([$vehiculo->marca, $vehiculo->modelo, $vehiculo->anio])) ?: '—' }}
                                </p>
                                @if ($vehiculo->color)
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Color: {{ $vehiculo->color }}</p>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Fila 2: Técnico + Fechas + Dispositivo --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 dark:divide-gray-700/60">

                {{-- Técnico --}}
                <div class="px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-violet-50 dark:bg-violet-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Técnico Asignado</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">
                            {{ $workOrder->tecnico->name ?? 'Sin asignar' }}
                        </p>
                        @if ($workOrder->tecnico?->phone)
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-mono mt-0.5">{{ $workOrder->tecnico->phone }}</p>
                        @endif
                    </div>
                </div>

                {{-- Fechas --}}
                <div class="px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-sky-50 dark:bg-sky-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Fechas</p>
                        <div class="mt-1 space-y-0.5">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs text-gray-400 dark:text-gray-500 w-20 shrink-0">Programada</span>
                                <span class="text-xs font-medium text-gray-800 dark:text-gray-200">
                                    {{ $workOrder->fecha_programada?->format('d/m/Y H:i') ?? '—' }}
                                </span>
                            </div>
                            @if ($workOrder->fecha_inicio)
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs text-gray-400 dark:text-gray-500 w-20 shrink-0">Inicio</span>
                                    <span class="text-xs font-medium text-green-600 dark:text-green-400">
                                        {{ $workOrder->fecha_inicio->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            @endif
                            @if ($workOrder->fecha_finalizacion)
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs text-gray-400 dark:text-gray-500 w-20 shrink-0">Finalización</span>
                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                        {{ $workOrder->fecha_finalizacion->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Dispositivo GPS --}}
                <div class="px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-rose-50 dark:bg-rose-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Equipo GPS</p>
                        <div class="mt-1 space-y-0.5">
                            @if ($equipoTexto)
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs text-gray-400 dark:text-gray-500 w-16 shrink-0">Modelo</span>
                                    <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $equipoTexto }}</span>
                                </div>
                            @endif
                            @if ($operadorSim)
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs text-gray-400 dark:text-gray-500 w-16 shrink-0">Operador</span>
                                    <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ strtoupper($operadorSim) }}</span>
                                </div>
                            @endif
                            @if ($workOrder->imei)
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs text-gray-400 dark:text-gray-500 w-16 shrink-0">IMEI</span>
                                    <span class="text-xs font-mono font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $workOrder->imei }}</span>
                                </div>
                            @endif
                            @if ($workOrder->iccid)
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs text-gray-400 dark:text-gray-500 w-16 shrink-0">ICCID</span>
                                    <span class="text-xs font-mono font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $workOrder->iccid }}</span>
                                </div>
                            @endif
                            @if (!$equipoTexto && !$operadorSim && !$workOrder->imei && !$workOrder->iccid)
                                <p class="text-xs text-gray-400 dark:text-gray-500 italic">Sin dispositivo registrado</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Fila 3: Sector + Plan + Contacto --}}
            @if ($workOrder->sector || $workOrder->plan || $workOrder->contacto)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 dark:divide-gray-700/60">

                    {{-- Sector --}}
                    <div class="px-5 py-4 flex items-start gap-3">
                        <div class="shrink-0 mt-0.5 w-8 h-8 bg-orange-50 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Sector</p>
                            @if ($workOrder->sector)
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @foreach (explode(', ', $workOrder->sector) as $s)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300">
                                            {{ $s }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 italic">No especificado</p>
                            @endif
                        </div>
                    </div>

                    {{-- Plan --}}
                    <div class="px-5 py-4 flex items-start gap-3">
                        <div class="shrink-0 mt-0.5 w-8 h-8 bg-cyan-50 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Plan</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">
                                {{ $workOrder->plan ?? '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Contacto --}}
                    <div class="px-5 py-4 flex items-start gap-3">
                        <div class="shrink-0 mt-0.5 w-8 h-8 bg-pink-50 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Contacto</p>
                            @if ($workOrder->contacto)
                                @foreach (explode(' — ', $workOrder->contacto) as $linea)
                                    <p class="text-sm {{ $loop->first ? 'font-semibold text-gray-900 dark:text-white' : 'text-xs text-gray-500 dark:text-gray-400' }} mt-0.5">
                                        {{ $linea }}
                                    </p>
                                @endforeach
                            @else
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 italic">Sin contacto registrado</p>
                            @endif
                        </div>
                    </div>

                </div>
            @endif

            {{-- Fila 4: Ubicación --}}
            <div class="px-5 py-4 flex items-start gap-3">
                <div class="shrink-0 mt-0.5 w-8 h-8 bg-teal-50 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-teal-500" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-2.007 3.96-5.07 3.96-8.827a8.25 8.25 0 00-16.5 0c0 3.756 2.017 6.82 3.96 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Ubicación del Servicio</p>
                    @if ($workOrder->ubicacion_lat)
                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-0.5">
                            @if ($workOrder->ubicacion_direccion)
                                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $workOrder->ubicacion_direccion }}</p>
                            @endif
                            <span class="text-xs font-mono text-gray-400 dark:text-gray-500">
                                {{ number_format($workOrder->ubicacion_lat, 6) }}, {{ number_format($workOrder->ubicacion_lng, 6) }}
                            </span>
                            <a href="https://www.google.com/maps?q={{ $workOrder->ubicacion_lat }},{{ $workOrder->ubicacion_lng }}"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1 text-xs text-blue-500 hover:text-blue-700 hover:underline font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Ver en Maps
                            </a>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 dark:text-gray-500 italic mt-0.5">Sin ubicación asignada</p>
                    @endif
                </div>
            </div>

            {{-- Fila 5: Consideraciones (observaciones_inicial) --}}
            @if ($workOrder->observaciones_inicial)
                <div class="px-5 py-4 bg-amber-50/50 dark:bg-amber-900/10 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Consideraciones</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1 leading-relaxed">{{ $workOrder->observaciones_inicial }}</p>
                    </div>
                </div>
            @endif

            {{-- Fila 6: Accesorios a instalar (metadata) --}}
            @if (!empty($accesorioLabels))
                <div class="px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">
                            Accesorios a Instalar
                            <span class="ml-1 text-indigo-400">({{ count($accesorioLabels) }})</span>
                        </p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($accesorioLabels as $acc)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $acc }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Fila 7: Alertas GPS a configurar (metadata) --}}
            @if (!empty($alertaLabels))
                <div class="px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-red-50 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">
                            Alertas GPS a Configurar
                            <span class="ml-1 text-red-400">({{ count($alertaLabels) }})</span>
                        </p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($alertaLabels as $alerta)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $alerta }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Fila 9: Calificación del cliente (si existe) --}}
            @if ($workOrder->calificacion_cliente)
                <div class="px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 mt-0.5 w-8 h-8 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Calificación del Cliente</p>
                        <div class="flex items-center gap-1.5 mt-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $workOrder->calificacion_cliente ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">
                                {{ $workOrder->calificado_at?->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

        </div>{{-- /divide-y --}}
    </div>

    {{-- ══ ÍTEMS DEL PROYECTO (solo si es_proyecto = true) ══════════════ --}}
    @if ($workOrder->es_proyecto)
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                            {{ $workOrder->titulo_proyecto ?? 'Unidades del Proyecto' }}
                        </h2>
                        @php
                            $totalItems = $workOrder->items->count();
                            $completados = $workOrder->items->where('estado', 'completado')->count();
                            $omitidos = $workOrder->items->where('estado', 'omitido')->count();
                            $pendientes = $workOrder->items->where('estado', 'pendiente')->count();
                            $pct = $totalItems > 0 ? round(($completados / $totalItems) * 100) : 0;
                        @endphp
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $totalItems }} unidades — {{ $completados }} completadas · {{ $omitidos }}
                            omitidas · {{ $pendientes }} pendientes
                        </p>
                    </div>
                </div>
                @if (!$workOrder->bloqueado)
                    <button wire:click="$toggle('mostrarAddItem')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Agregar unidad
                    </button>
                @endif
            </div>

            {{-- Barra de progreso --}}
            @if ($totalItems > 0)
                <div class="px-6 pt-3 pb-1">
                    <div class="flex items-center gap-2">
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all"
                                style="width: {{ $pct }}%"></div>
                        </div>
                        <span
                            class="text-xs font-medium text-gray-600 dark:text-gray-400 w-10 text-right">{{ $pct }}%</span>
                    </div>
                </div>
            @endif

            {{-- Formulario agregar ítem --}}
            @if ($mostrarAddItem)
                <div
                    class="px-6 py-4 bg-indigo-50 dark:bg-indigo-950/20 border-b border-indigo-100 dark:border-indigo-800">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Placa
                                *</label>
                            <input wire:model="nuevoItemPlaca" type="text" placeholder="ARS-173"
                                class="w-full uppercase rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-mono text-gray-900 dark:text-white px-3 py-2" />
                            @error('nuevoItemPlaca')
                                <p class="text-red-500 text-xs mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-form.select wire:model="nuevoItemTipoTrabajo" label="Tipo de trabajo"
                                placeholder="Seleccionar..." option-label="nombre" option-value="id"
                                :options="$tiposOrden" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Notas
                                (opcional)</label>
                            <input wire:model="nuevoItemNotas" type="text" placeholder="Ej: cambio de chip"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-white px-3 py-2" />
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="agregarItem" wire:loading.attr="disabled"
                                class="flex-1 px-3 py-2 text-sm font-medium rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition disabled:opacity-50">
                                <span wire:loading.remove wire:target="agregarItem">Agregar</span>
                                <span wire:loading wire:target="agregarItem">...</span>
                            </button>
                            <button wire:click="$set('mostrarAddItem', false)"
                                class="px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tabla de ítems --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase w-6">
                                #</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Placa</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase hidden sm:table-cell">
                                Tipo</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase hidden md:table-cell">
                                Notas</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase hidden lg:table-cell">
                                IMEI / SIM</th>
                            <th
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Estado</th>
                            <th
                                class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($workOrder->items as $item)
                            <tr wire:key="item-{{ $item->id }}"
                                class="{{ $item->estado === 'completado' ? 'bg-emerald-50/40 dark:bg-emerald-950/10' : ($item->estado === 'omitido' ? 'opacity-50' : '') }}">
                                <td class="px-4 py-2.5 text-xs text-gray-400">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2.5">
                                    <span
                                        class="font-mono text-sm font-semibold text-gray-900 dark:text-white">{{ $item->placa }}</span>
                                    @if ($item->cliente_nombre)
                                        <p class="text-xs text-gray-400 truncate max-w-[200px]">
                                            {{ $item->cliente_nombre }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 hidden sm:table-cell">
                                    @php
                                        $tipoBadge = match ($item->tipo_trabajo) {
                                            'instalacion'
                                                => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                                            'mantenimiento'
                                                => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                            'cambio_chip'
                                                => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                                            'retiro' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                                            default => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $tipoBadge }}">
                                        {{ $item->labelTipoTrabajo() }}
                                    </span>
                                </td>
                                <td
                                    class="px-4 py-2.5 text-xs text-gray-500 dark:text-gray-400 hidden md:table-cell max-w-[160px] truncate">
                                    {{ $item->notas ?? '—' }}
                                </td>
                                <td class="px-4 py-2.5 hidden lg:table-cell" x-data="{ editImei: false, imei: '{{ $item->imei ?? '' }}', sim: '{{ $item->numero_sim ?? '' }}' }">
                                    @if ($item->imei || $item->numero_sim)
                                        <div class="text-xs font-mono text-gray-700 dark:text-gray-300">
                                            @if ($item->imei)
                                                <p>IMEI: {{ $item->imei }}</p>
                                            @endif
                                            @if ($item->numero_sim)
                                                <p>SIM: {{ $item->numero_sim }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                    @if (!$workOrder->bloqueado)
                                        <button @click="editImei = !editImei"
                                            class="text-xs text-indigo-500 hover:underline mt-0.5">
                                            <span x-text="editImei ? 'cancelar' : 'editar'"></span>
                                        </button>
                                        <div x-show="editImei" x-cloak class="mt-1 space-y-1">
                                            <input x-model="imei" type="text" placeholder="IMEI" maxlength="20"
                                                class="w-full text-xs font-mono rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-2 py-1" />
                                            <input x-model="sim" type="text" placeholder="N° SIM" maxlength="30"
                                                class="w-full text-xs font-mono rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-2 py-1" />
                                            <button
                                                @click="$wire.guardarImeiItem({{ $item->id }}, imei, sim); editImei = false"
                                                class="w-full text-xs bg-indigo-600 text-white rounded px-2 py-1 hover:bg-indigo-700">
                                                Guardar
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5">
                                    <button wire:click="toggleItemEstado({{ $item->id }})"
                                        @disabled($workOrder->bloqueado)
                                        title="{{ $workOrder->bloqueado ? '' : 'Click para cambiar estado' }}"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium transition
                                        {{ $item->estado === 'completado'
                                            ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300'
                                            : ($item->estado === 'omitido'
                                                ? 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400'
                                                : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300') }}
                                        {{ !$workOrder->bloqueado ? 'cursor-pointer hover:opacity-80' : '' }}">
                                        @if ($item->estado === 'completado')
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Completado
                                        @elseif ($item->estado === 'omitido')
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Omitido
                                        @else
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Pendiente
                                        @endif
                                    </button>
                                </td>
                                <td class="px-4 py-2.5 text-right">
                                    @if (!$workOrder->bloqueado)
                                        <button wire:click="eliminarItem({{ $item->id }})"
                                            wire:confirm="¿Eliminar esta unidad de la orden?"
                                            class="text-red-400 hover:text-red-600 transition p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20"
                                            title="Quitar unidad">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="px-6 py-8 text-center text-sm text-gray-400 dark:text-gray-500">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300 dark:text-gray-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    No hay unidades registradas. Usa "Agregar unidad" para añadirlas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    {{-- ══════════════════════════════════════════════════════════════════ --}}

    {{-- Mantenimiento Vinculado --}}
    @if ($workOrder->mantenimiento)
        @php $mt = $workOrder->mantenimiento; @endphp
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <div
                    class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">Mantenimiento Programado
                        Vinculado
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Esta orden fue generada a partir de un
                        mantenimiento programado</p>
                </div>
            </div>

            <div class="px-6 py-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">N°
                        Mantenimiento</h3>
                    <p class="text-sm text-gray-900 dark:text-white font-mono font-semibold">{{ $mt->numero }}</p>
                </div>

                <div>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Estado</h3>
                    @php
                        $mtColor = match ($mt->estado->value) {
                            'PENDIENTE' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/40 dark:text-orange-300',
                            'COMPLETADA'
                                => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300',
                            'CANCELADO' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300',
                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        };
                    @endphp
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $mtColor }}">
                        {{ $mt->estado->value }}
                    </span>
                </div>

                <div>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Fecha Programada</h3>
                    <p class="text-sm text-gray-900 dark:text-white font-medium">
                        {{ $mt->fecha_hora_mantenimiento ? $mt->fecha_hora_mantenimiento->format('d/m/Y') : 'No definida' }}
                    </p>
                </div>

                @if ($mt->detalle_trabajo)
                    <div class="md:col-span-2 lg:col-span-3">
                        <h3
                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Detalle del Trabajo</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $mt->detalle_trabajo }}
                        </p>
                    </div>
                @endif

                @if ($mt->nota)
                    <div class="md:col-span-2 lg:col-span-3">
                        <h3
                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Nota</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $mt->nota }}</p>
                    </div>
                @endif

                <div>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Notificaciones</h3>
                    <div class="flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                            {{ $mt->notify_admin ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                            Admin {{ $mt->notify_admin ? '✓' : '✗' }}
                        </span>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                            {{ $mt->notify_client ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                    clip-rule="evenodd" />
                            </svg>
                            Cliente {{ $mt->notify_client ? '✓' : '✗' }}
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                        Registrado</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $mt->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Acciones Rápidas --}}
    @if (!$workOrder->bloqueado)
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Acciones</h2>

            <div class="flex flex-wrap gap-3">
                @if (!$workOrder->bloqueado)
                    <x-form.button outline secondary icon="pencil" wire:click="abrirEdicion" spinner="abrirEdicion">
                        Editar Orden
                    </x-form.button>
                @endif

                @if ($workOrder->estado->value === 'pendiente')
                    <x-form.button primary icon="play" wire:click="iniciar" spinner="iniciar">
                        Iniciar Trabajo
                    </x-form.button>
                @endif

                @if ($workOrder->estado->value === 'en_proceso')
                    @if (!$workOrder->es_proyecto)
                        <x-form.button teal icon="qr-code" wire:click="abrirModalDispositivo('imei', 'instalado')"
                            spinner="abrirModalDispositivo('imei', 'instalado')">
                            Registrar IMEI
                        </x-form.button>

                        <x-form.button purple icon="identification"
                            wire:click="abrirModalDispositivo('sim', 'instalado')"
                            spinner="abrirModalDispositivo('sim', 'instalado')">
                            Registrar SIM
                        </x-form.button>

                        <x-form.button secondary icon="clipboard-document-list" wire:click="verChecklist('before')"
                            spinner="verChecklist('before')">
                            Checklist Inicial
                        </x-form.button>

                        <x-form.button secondary icon="clipboard-document-check" wire:click="verChecklist('after')"
                            spinner="verChecklist('after')">
                            Checklist Final
                        </x-form.button>

                        @if (!$workOrder->signatures()->where('tipo', 'conformidad')->exists())
                            <x-form.button warning icon="pencil-square" wire:click="abrirModalFirma"
                                spinner="abrirModalFirma">
                                Firma de Conformidad
                            </x-form.button>
                        @endif
                    @endif

                    <x-form.button positive icon="check" wire:click="finalizar" spinner="finalizar">
                        Finalizar Trabajo
                    </x-form.button>
                @endif

                @if ($workOrder->estado->value === 'finalizado')
                    <x-form.button info icon="lock-closed" wire:click="cerrar" spinner="cerrar">
                        Cerrar y Bloquear
                    </x-form.button>
                @endif

                @if (in_array($workOrder->estado->value, ['pendiente', 'en_proceso']))
                    <x-form.button negative icon="x-mark" wire:click="cancelar('Cancelado por usuario')"
                        spinner="cancelar">
                        Cancelar Orden
                    </x-form.button>
                @endif

                <a href="{{ route('admin.work-orders.pdf', $workOrder) }}" target="_blank">
                    <x-form.button outline secondary icon="document-arrow-down">
                        Descargar PDF
                    </x-form.button>
                </a>
            </div>
        </div>
    @endif

    {{-- Timeline de Actividades --}}
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
            Timeline de Actividades
        </h2>

        <div class="relative">
            {{-- Línea vertical --}}
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-300 dark:bg-gray-600"></div>

            <div class="space-y-6">
                @forelse ($timeline as $event)
                    <div class="relative flex items-start gap-4 pl-12">
                        {{-- Icono --}}
                        <div
                            class="absolute left-0 flex items-center justify-center w-8 h-8 rounded-full 
                            bg-{{ $event['color'] }}-100 dark:bg-{{ $event['color'] }}-900
                            border-4 border-white dark:border-gray-800 z-10">
                            <svg class="w-4 h-4 text-{{ $event['color'] }}-600 dark:text-{{ $event['color'] }}-400"
                                fill="currentColor" viewBox="0 0 20 20">
                                @if ($event['icono'] === 'plus-circle')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'play')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'check-circle')
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'camera')
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                @elseif($event['icono'] === 'lock-closed')
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                @else
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                @endif
                            </svg>
                        </div>

                        {{-- Contenido --}}
                        <div class="flex-1 bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $event['titulo'] }}
                                    </h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $event['descripcion'] }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-4 whitespace-nowrap">
                                    {{ $event['fecha']->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            {{-- Data adicional si existe --}}
                            @if (isset($event['data']))
                                @if ($event['tipo'] === 'foto')
                                    <div class="mt-3">
                                        @php
                                            $photo = $event['data'];
                                            $filename = basename($photo->path);
                                        @endphp
                                        <img src="{{ route('admin.work-orders.file', ['workOrder' => $workOrder->id, 'type' => 'checklist', 'filename' => $filename]) }}"
                                            alt="Evidencia"
                                            class="h-32 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm">
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">No hay actividades registradas aún</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Accesorios Instalados --}}
    @if ($workOrder->accessories->isNotEmpty())
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Accesorios Instalados</h2>

            <div class="overflow-x-auto min-h-screen">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Producto</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Cantidad</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Precio Unit.</th>
                            <th
                                class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($workOrder->accessories as $accessory)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $accessory->producto->nombre ?? $accessory->descripcion }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $accessory->cantidad }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white font-mono">
                                    S/ {{ number_format($accessory->precio_unitario, 2) }}
                                </td>
                                <td
                                    class="px-4 py-3 text-sm text-gray-900 dark:text-white font-mono text-right font-semibold">
                                    S/ {{ number_format($accessory->precio_unitario * $accessory->cantidad, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50 dark:bg-gray-900 font-semibold">
                            <td colspan="3" class="px-4 py-3 text-sm text-gray-900 dark:text-white text-right">
                                Total:
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white font-mono text-right">
                                S/
                                {{ number_format($workOrder->accessories->sum(fn($a) => $a->precio_unitario * $a->cantidad), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Modal de Firma --}}
    @if ($modalFirma)
        <x-form.modal.card wire:model="modalFirma" title="Firma de Conformidad del Cliente" max-width="2xl">
            <div class="space-y-4">
                <x-form.input wire:model="nombreFirmante" label="Nombre del Firmante *"
                    placeholder="Ej: Juan Pérez" />

                <x-form.select wire:model="tipoFirmante" label="Tipo de Firmante *" placeholder="Seleccione un tipo">
                    <x-select.option label="Cliente" value="cliente" />
                    <x-select.option label="Conductor" value="conductor" />
                    <x-select.option label="Encargado" value="encargado" />
                    <x-select.option label="Supervisor" value="supervisor" />
                </x-form.select>

                <x-form.input wire:model="documentoFirmante" label="Documento (Opcional)" placeholder="DNI o RUC" />

                <div wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Firma Digital *
                    </label>
                    <div class="border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                        <canvas id="signatureCanvas" width="600" height="200"
                            class="w-full touch-none cursor-crosshair"></canvas>
                    </div>
                    <div class="mt-2 flex justify-end">
                        <button type="button" onclick="clearSignature()"
                            class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                            Limpiar Firma
                        </button>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <p class="text-sm text-blue-800 dark:text-blue-300">
                        <strong>Nota:</strong> Al firmar, confirma que el trabajo ha sido realizado satisfactoriamente
                        y que está conforme con el servicio prestado.
                    </p>
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-3">
                    <x-form.button outline secondary wire:click="$set('modalFirma', false)">
                        Cancelar
                    </x-form.button>

                    <x-form.button primary onclick="guardarFirmaConDatos()">
                        Guardar Firma
                    </x-form.button>
                </div>
            </x-slot>
        </x-form.modal.card>
    @endif

    @push('scripts')
        <script>
            let signatureCanvas = null;
            let signatureCtx = null;
            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;

            function initSignatureCanvas() {
                signatureCanvas = document.getElementById('signatureCanvas');
                if (!signatureCanvas) return;

                signatureCtx = signatureCanvas.getContext('2d');

                // Limpiar listeners previos
                signatureCanvas.replaceWith(signatureCanvas.cloneNode(true));
                signatureCanvas = document.getElementById('signatureCanvas');
                signatureCtx = signatureCanvas.getContext('2d');

                function getMousePos(e) {
                    const rect = signatureCanvas.getBoundingClientRect();
                    const scaleX = signatureCanvas.width / rect.width;
                    const scaleY = signatureCanvas.height / rect.height;
                    return {
                        x: (e.clientX - rect.left) * scaleX,
                        y: (e.clientY - rect.top) * scaleY
                    };
                }

                function getTouchPos(e) {
                    const rect = signatureCanvas.getBoundingClientRect();
                    const scaleX = signatureCanvas.width / rect.width;
                    const scaleY = signatureCanvas.height / rect.height;
                    return {
                        x: (e.touches[0].clientX - rect.left) * scaleX,
                        y: (e.touches[0].clientY - rect.top) * scaleY
                    };
                }

                function startDrawing(e) {
                    isDrawing = true;
                    const pos = e.touches ? getTouchPos(e) : getMousePos(e);
                    [lastX, lastY] = [pos.x, pos.y];
                }

                function draw(e) {
                    if (!isDrawing) return;
                    e.preventDefault();

                    const pos = e.touches ? getTouchPos(e) : getMousePos(e);

                    signatureCtx.strokeStyle = '#000';
                    signatureCtx.lineWidth = 2;
                    signatureCtx.lineCap = 'round';
                    signatureCtx.lineJoin = 'round';

                    signatureCtx.beginPath();
                    signatureCtx.moveTo(lastX, lastY);
                    signatureCtx.lineTo(pos.x, pos.y);
                    signatureCtx.stroke();

                    [lastX, lastY] = [pos.x, pos.y];
                    // NO actualizar Livewire en cada trazo
                }

                function stopDrawing() {
                    isDrawing = false;
                }

                // Mouse events
                signatureCanvas.addEventListener('mousedown', startDrawing);
                signatureCanvas.addEventListener('mousemove', draw);
                signatureCanvas.addEventListener('mouseup', stopDrawing);
                signatureCanvas.addEventListener('mouseout', stopDrawing);

                // Touch events
                signatureCanvas.addEventListener('touchstart', startDrawing, {
                    passive: false
                });
                signatureCanvas.addEventListener('touchmove', draw, {
                    passive: false
                });
                signatureCanvas.addEventListener('touchend', stopDrawing);
            }

            window.clearSignature = function() {
                if (signatureCanvas && signatureCtx) {
                    signatureCtx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
                }
            };

            window.guardarFirmaConDatos = function() {
                if (signatureCanvas) {
                    const signatureData = signatureCanvas.toDataURL('image/png');
                    @this.set('signatureData', signatureData).then(() => {
                        @this.call('guardarFirma');
                    });
                } else {
                    @this.call('guardarFirma');
                }
            };

            // Inicializar cuando el modal se abre
            document.addEventListener('livewire:initialized', () => {
                Livewire.hook('morph.updated', () => {
                    setTimeout(() => {
                        const canvas = document.getElementById('signatureCanvas');
                        if (canvas && !canvas.dataset.initialized) {
                            canvas.dataset.initialized = 'true';
                            initSignatureCanvas();
                        }
                    }, 100);
                });
            });

            // También inicializar en DOMContentLoaded por si acaso
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const canvas = document.getElementById('signatureCanvas');
                    if (canvas) {
                        initSignatureCanvas();
                    }
                }, 500);
            });
        </script>
    @endpush

    {{-- Modal Captura de Dispositivo (IMEI/SIM) --}}
    <x-form.modal.card title="{{ $tipoDispositivo === 'imei' ? 'Registrar IMEI' : 'Registrar SIM Card' }}"
        wire:model="modalDispositivo" max-width="2xl">
        <div class="space-y-4">
            {{-- Selector de Acción --}}
            <x-form.select wire:model="accionDispositivo" label="Acción" placeholder="Seleccione una acción">
                <x-select.option value="instalado">Instalado</x-select.option>
                <x-select.option value="retirado">Retirado</x-select.option>
                <x-select.option value="reemplazado">Reemplazado</x-select.option>
            </x-form.select>

            {{-- Área de Escaneo --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ $tipoDispositivo === 'imei' ? 'Escanear Código QR del Equipo' : 'Escanear Código de Barras de SIM' }}
                </label>

                <div
                    class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-900">
                    {{-- Video para la cámara --}}
                    <div id="scanner-container-{{ $tipoDispositivo }}" wire:ignore class="mb-4">
                        <div id="reader" style="width: 100%; max-width: 500px; margin: 0 auto;"></div>
                    </div>

                    {{-- Botones de control --}}
                    <div class="flex justify-center gap-2 mb-4">
                        <x-form.button xs primary icon="camera" onclick="iniciarEscaner('{{ $tipoDispositivo }}')"
                            type="button">
                            Activar Cámara
                        </x-form.button>
                        <x-form.button xs secondary icon="stop" onclick="detenerEscaner()" type="button">
                            Detener
                        </x-form.button>
                    </div>

                    <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                        @if ($tipoDispositivo === 'imei')
                            📱 Coloca el código QR del equipo frente a la cámara
                        @else
                            📊 Coloca el código de barras de la SIM frente a la cámara
                        @endif
                    </div>
                </div>
            </div>

            {{-- Campo de Entrada Manual --}}
            <div>
                <x-form.input wire:model.live="codigoDispositivo" :label="$tipoDispositivo === 'imei' ? 'Código IMEI' : 'Código ICCID/Número'"
                    placeholder="O ingresa el código manualmente" icon="hashtag" />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    @if ($tipoDispositivo === 'imei')
                        IMEI: 15 dígitos (ej: 868018071097359)
                    @else
                        ICCID: 19-20 dígitos (ej: 89512010030469935)
                    @endif
                </p>
            </div>

            {{-- Observaciones --}}
            <div>
                <x-form.textarea wire:model="observacionesDispositivo" label="Observaciones (Opcional)"
                    placeholder="Agrega notas adicionales..." rows="3" />
            </div>

            {{-- Ubicación de Instalación --}}
            <div>
                <x-form.select wire:model.live="ubicacionInstalacion" label="Ubicación de Instalación *"
                    placeholder="Seleccione una ubicación">
                    @foreach ($this::UBICACIONES as $ubicacion)
                        <x-select.option value="{{ $ubicacion }}">{{ $ubicacion }}</x-select.option>
                    @endforeach
                </x-form.select>
            </div>

            @if ($ubicacionInstalacion === 'OTRO')
                <div>
                    <x-form.input wire:model="ubicacionPersonalizada" label="Especifica la ubicación *"
                        placeholder="Ej: Detrás de la consola central..." icon="map-pin" />
                </div>
            @endif
        </div>

        <x-slot name="footer">
            <div class="flex justify-between w-full">
                <x-form.button flat label="Cancelar" x-on:click="close"
                    wire:click="$set('modalDispositivo', false)" />
                <x-form.button primary label="Guardar" wire:click="guardarDispositivo"
                    spinner="guardarDispositivo" />
            </div>
        </x-slot>
    </x-form.modal.card>

    @push('scripts')
        {{-- Librería html5-qrcode para escaneo de códigos --}}
        <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

        <script>
            let html5QrcodeScanner = null;

            window.iniciarEscaner = function(tipo) {
                // Detener escáner anterior si existe
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear().catch(error => {
                        console.error("Error al limpiar escáner anterior", error);
                    });
                }

                // Configuración optimizada según tipo
                const config = {
                    fps: 10,
                    qrbox: function(viewfinderWidth, viewfinderHeight) {
                        // Área de escaneo adaptativa
                        let minEdgePercentage = 0.7;
                        let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
                        let qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
                        return {
                            width: qrboxSize,
                            height: tipo === 'imei' ? qrboxSize : Math.floor(qrboxSize * 0.6)
                        };
                    },
                    aspectRatio: 1.777778, // 16:9
                    disableFlip: false,
                    rememberLastUsedCamera: true,
                    showTorchButtonIfSupported: true,
                    experimentalFeatures: {
                        useBarCodeDetectorIfSupported: true
                    },
                    // NO especificar formatsToSupport para permitir todos los formatos
                    // Esto es más flexible y detecta mejor
                };

                html5QrcodeScanner = new Html5QrcodeScanner("reader", config, false);

                html5QrcodeScanner.render(onScanSuccess, onScanError);
            };

            function onScanSuccess(decodedText, decodedResult) {
                console.log('Código detectado:', decodedText, decodedResult);

                // Enviar código a Livewire
                @this.call('recibirCodigoEscaneado', decodedText);

                // Mostrar notificación
                window.$wireui.notify({
                    title: 'Código Escaneado',
                    description: decodedText,
                    icon: 'success'
                });

                // Detener escáner
                detenerEscaner();
            }

            function onScanError(errorMessage) {
                // Solo mostrar errores significativos, no los de escaneo continuo
                const errorString = typeof errorMessage === 'string' ? errorMessage : String(errorMessage);
                if (!errorString.includes('No MultiFormat') &&
                    !errorString.includes('NotFoundException')) {}

                window.detenerEscaner = function() {
                    if (html5QrcodeScanner) {
                        html5QrcodeScanner.clear().then(() => {
                            html5QrcodeScanner = null;
                        }).catch(error => {
                            console.error("Error al detener escáner", error);
                        });
                    }
                };

                // Limpiar escáner cuando se cierra el modal
                document.addEventListener('livewire:initialized', () => {
                    Livewire.hook('morph.updated', () => {
                        const modalDispositivo = @this.modalDispositivo;
                        if (!modalDispositivo && html5QrcodeScanner) {
                            detenerEscaner();
                        }
                    });
                });
            }
        </script>
    @endpush
</div>
