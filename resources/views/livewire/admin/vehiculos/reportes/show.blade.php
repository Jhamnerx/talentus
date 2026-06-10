<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.vehiculos.reportes.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver
        </a>
        <span class="text-gray-300 dark:text-gray-600">/</span>
        <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            Reporte #{{ $reporte->id }}
            @if($reporte->vehiculos)
                — {{ $reporte->vehiculos->placa }}
            @endif
        </h1>

        {{-- Estado badge --}}
        @if($reporte->estado == \App\Models\Reportes::ESTADO_ABIERTA)
            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Abierta
            </span>
        @elseif($reporte->estado == \App\Models\Reportes::ESTADO_EN_ATENCION)
            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                En atención
            </span>
        @else
            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                Cerrada
            </span>
        @endif

        @if($reporte->origen === \App\Models\Reportes::ORIGEN_AUTO)
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400">
                Auto
            </span>
        @endif
    </div>

    <div class="grid grid-cols-12 gap-6">

        {{-- ────────────────── Columna principal (timeline de notas) ────────────────── --}}
        <div class="col-span-12 lg:col-span-7 space-y-4">

            {{-- Notas / Timeline --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Notas / Bitácora
                        <span class="ml-1.5 text-xs font-normal text-gray-400">({{ $reporte->getRelation('detalle')->count() }})</span>
                    </h2>
                </div>

                <div class="divide-y divide-gray-50 dark:divide-gray-700/50 max-h-96 overflow-y-auto">
                    @forelse($reporte->getRelation('detalle')->sortByDesc('id') as $nota)
                        <div class="px-5 py-3 flex gap-3">
                            <div class="shrink-0 mt-0.5">
                                <img class="w-7 h-7 rounded-full object-cover"
                                     src="{{ $nota->user?->profile_photo_url ?? asset('images/default-avatar.png') }}"
                                     alt="{{ $nota->user?->name }}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-baseline gap-2 flex-wrap">
                                    <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                        {{ $nota->user?->name ?? 'Sistema' }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $nota->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $nota->detalle }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center text-sm text-gray-400">
                            Sin notas registradas aún.
                        </div>
                    @endforelse
                </div>

                {{-- Agregar nota --}}
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex gap-3 items-start">
                        <img class="w-7 h-7 rounded-full object-cover shrink-0 mt-1"
                             src="{{ auth()->user()->profile_photo_url }}"
                             alt="{{ auth()->user()->name }}">
                        <div class="flex-1">
                            <textarea
                                wire:model="nuevoDetalle"
                                rows="2"
                                placeholder="Escribe una nota..."
                                class="w-full text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 placeholder-gray-400 px-3 py-2 resize-none focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-700 focus:border-transparent outline-none"
                            ></textarea>
                            @error('nuevoDetalle')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <x-form.button
                            wire:click="guardarDetalle"
                            spinner="guardarDetalle"
                            primary
                            label="Guardar"
                            class="mt-1 shrink-0"
                        />
                    </div>
                </div>
            </div>

        </div>

        {{-- ────────────────── Columna lateral (info) ────────────────── --}}
        <div class="col-span-12 lg:col-span-5 space-y-4">

            {{-- Info del reporte --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Información del reporte</h2>
                </div>
                <div class="px-5 py-4 space-y-3 text-sm">

                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Descripción</p>
                        <p class="text-gray-700 dark:text-gray-200">{{ $reporte->detalle ?: '—' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Creado</p>
                            <p class="text-gray-700 dark:text-gray-200">{{ $reporte->created_at->format('d/m/Y H:i') }}</p>
                            <p class="text-xs text-gray-400">por {{ $reporte->user?->name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Origen</p>
                            <p class="text-gray-700 dark:text-gray-200">{{ $reporte->origen_label }}</p>
                        </div>
                    </div>

                    @if($reporte->horas_sin_transmision)
                        <div>
                            <p class="text-xs text-gray-400 mb-0.5">Horas sin señal al detectar</p>
                            <p class="text-amber-600 dark:text-amber-400 font-medium">{{ number_format($reporte->horas_sin_transmision, 1) }} h</p>
                        </div>
                    @endif

                    @if($reporte->atendido_at)
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Atendido</p>
                                <p class="text-gray-700 dark:text-gray-200">{{ $reporte->atendido_at->format('d/m/Y H:i') }}</p>
                                <p class="text-xs text-gray-400">por {{ $reporte->atendidoPor?->name ?? '—' }}</p>
                            </div>
                            @if($reporte->cerrado_at)
                                <div>
                                    <p class="text-xs text-gray-400 mb-0.5">Cerrado</p>
                                    <p class="text-gray-700 dark:text-gray-200">{{ $reporte->cerrado_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>

                {{-- Acciones de estado --}}
                <div class="px-5 pb-4 flex flex-wrap gap-2">
                    @if($reporte->estado == \App\Models\Reportes::ESTADO_ABIERTA)
                        <x-form.button
                            wire:click="atender"
                            wire:confirm="¿Marcar como En atención?"
                            spinner="atender"
                            info
                            sm
                            label="Tomar alerta"
                        />
                    @elseif($reporte->estado == \App\Models\Reportes::ESTADO_EN_ATENCION)
                        <x-form.button
                            wire:click="cerrar"
                            wire:confirm="¿Cerrar este reporte?"
                            spinner="cerrar"
                            positive
                            sm
                            label="Cerrar reporte"
                        />
                    @else
                        <x-form.button
                            wire:click="reabrir"
                            wire:confirm="¿Reabrir este reporte?"
                            spinner="reabrir"
                            flat
                            secondary
                            sm
                            label="Reabrir"
                        />
                    @endif
                </div>
            </div>

            {{-- Vehículo --}}
            @if($reporte->vehiculos)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Vehículo</h2>
                    </div>
                    <div class="px-5 py-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-gray-800 dark:text-gray-100 tracking-widest">
                                {{ $reporte->vehiculos->placa }}
                            </span>
                            @if($reporte->vehiculos->tipo)
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $reporte->vehiculos->tipo }}</span>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-y-2 text-xs">
                            @if($reporte->vehiculos->marca)
                                <div>
                                    <p class="text-gray-400">Marca</p>
                                    <p class="text-gray-700 dark:text-gray-200 font-medium">{{ $reporte->vehiculos->marca }}</p>
                                </div>
                            @endif
                            @if($reporte->vehiculos->modelo)
                                <div>
                                    <p class="text-gray-400">Modelo</p>
                                    <p class="text-gray-700 dark:text-gray-200 font-medium">{{ $reporte->vehiculos->modelo }}</p>
                                </div>
                            @endif
                            @if($reporte->vehiculos->color)
                                <div>
                                    <p class="text-gray-400">Color</p>
                                    <p class="text-gray-700 dark:text-gray-200 font-medium">{{ $reporte->vehiculos->color }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-gray-400">GPS</p>
                                <p class="text-gray-700 dark:text-gray-200 font-medium">
                                    {{ $reporte->vehiculos->dispositivoPrincipal?->dispositivo?->modelo?->modelo ?? 'Sin GPS' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Cliente --}}
            @if($reporte->vehiculos?->cliente)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Cliente</h2>
                    </div>
                    <div class="px-5 py-4 space-y-1 text-sm">
                        <p class="font-semibold text-gray-800 dark:text-gray-100">
                            {{ $reporte->vehiculos->cliente->razon_social }}
                        </p>
                        @can('editar-cliente')
                            @if($reporte->vehiculos->cliente->direccion)
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $reporte->vehiculos->cliente->direccion }}
                                </p>
                            @endif
                        @endcan
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
