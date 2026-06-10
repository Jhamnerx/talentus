<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto" wire:poll.30s>

    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Reportes de Monitoreo</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Alertas automáticas y manuales · se actualiza cada 30s</p>
        </div>
        <div class="flex flex-wrap gap-2 mt-4 sm:mt-0">
            <x-form.button wire:click.prevent="openModalEstadoTransmision" outline secondary icon="signal" label="Estado Transmisión" />
            <x-form.button wire:click.prevent="openModalSave" primary icon="plus" label="Nuevo Reporte" />
        </div>
    </div>

    {{-- Summary cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

        <button wire:click="$set('estado_filter', '{{ \App\Models\Reportes::ESTADO_ABIERTA }}')"
            class="bg-white dark:bg-gray-800 rounded-xl border-2 p-4 text-left transition hover:shadow-md
                {{ $estado_filter == \App\Models\Reportes::ESTADO_ABIERTA ? 'border-red-400' : 'border-gray-200 dark:border-gray-700' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase text-red-600 dark:text-red-400 tracking-wide">Abiertas</span>
                <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $counts['abiertas'] }}</div>
        </button>

        <button wire:click="$set('estado_filter', '{{ \App\Models\Reportes::ESTADO_EN_ATENCION }}')"
            class="bg-white dark:bg-gray-800 rounded-xl border-2 p-4 text-left transition hover:shadow-md
                {{ $estado_filter == \App\Models\Reportes::ESTADO_EN_ATENCION ? 'border-blue-400' : 'border-gray-200 dark:border-gray-700' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase text-blue-600 dark:text-blue-400 tracking-wide">En atención</span>
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $counts['en_atencion'] }}</div>
        </button>

        <div class="bg-white dark:bg-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase text-emerald-600 dark:text-emerald-400 tracking-wide">Cerradas hoy</span>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $counts['cerradas_hoy'] }}</div>
        </div>

        <button wire:click="$set('origen_filter', 'auto')"
            class="bg-white dark:bg-gray-800 rounded-xl border-2 p-4 text-left transition hover:shadow-md
                {{ $origen_filter === 'auto' ? 'border-violet-400' : 'border-gray-200 dark:border-gray-700' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase text-violet-600 dark:text-violet-400 tracking-wide">Auto hoy</span>
                <svg class="w-3.5 h-3.5 text-violet-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $counts['auto_hoy'] }}</div>
        </button>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
        <div class="grid grid-cols-12 gap-3">

            <div class="col-span-12 sm:col-span-6 md:col-span-4">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Buscar</label>
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" type="search"
                        class="form-input w-full pl-9 text-sm rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800"
                        placeholder="Placa, cliente, detalle..." />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400 ml-3 fill-current" viewBox="0 0 16 16">
                            <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-3 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Estado</label>
                <select wire:model.live="estado_filter"
                    class="form-select w-full text-sm rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <option value="">Todos</option>
                    <option value="{{ \App\Models\Reportes::ESTADO_ABIERTA }}">Abierta</option>
                    <option value="{{ \App\Models\Reportes::ESTADO_EN_ATENCION }}">En atención</option>
                    <option value="{{ \App\Models\Reportes::ESTADO_CERRADA }}">Cerrada</option>
                </select>
            </div>

            <div class="col-span-6 sm:col-span-3 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Origen</label>
                <select wire:model.live="origen_filter"
                    class="form-select w-full text-sm rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <option value="">Todos</option>
                    <option value="auto">Automática</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            <div class="col-span-6 sm:col-span-3 md:col-span-2">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Por página</label>
                <select wire:model.live="perPage"
                    class="form-select w-full text-sm rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-span-6 sm:col-span-3 md:col-span-2" x-data="{ open: false }">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Período</label>
                <div class="relative">
                    <button @click.prevent="open = !open"
                        class="form-input w-full text-sm text-left rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex items-center justify-between">
                        <span class="text-gray-500 dark:text-gray-400">
                            @if($from) {{ \Carbon\Carbon::parse($from)->format('d/m') }} - {{ \Carbon\Carbon::parse($to)->format('d/m') }} @else Todos @endif
                        </span>
                        <svg class="w-3 h-3 fill-current text-gray-400 ml-1 shrink-0" viewBox="0 0 12 12">
                            <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak
                        class="z-10 absolute top-full left-0 w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg py-1 mt-1">
                        <button wire:click="filter(1)" @click="open=false" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Hoy</button>
                        <button wire:click="filter(7)" @click="open=false" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Últimos 7 días</button>
                        <button wire:click="filter(30)" @click="open=false" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Últimos 30 días</button>
                        <button wire:click="filter(0)" @click="open=false" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">Todos</button>
                    </div>
                </div>
            </div>
        </div>

        @if($search || $estado_filter !== '' || $origen_filter !== '' || $from)
            <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                <x-form.button wire:click="limpiarFiltros" flat negative label="Limpiar filtros" />
                <span class="text-xs text-gray-400">{{ $reportes->total() }} resultado(s)</span>
            </div>
        @endif
    </div>

    {{-- List --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100">
                Reportes <span class="text-gray-400 font-medium ml-1">{{ $reportes->total() }}</span>
            </h2>
        </header>

        <div class="divide-y divide-gray-100 dark:divide-gray-700/60">
            @forelse ($reportes as $reporte)
                @php $veh = $reporte->vehiculos; @endphp
                <div wire:key="reporte-{{ $reporte->id }}" class="p-4 hover:bg-gray-50/70 dark:hover:bg-gray-900/20 transition-colors">

                    <div class="flex flex-wrap items-start gap-3">

                        {{-- Estado badge --}}
                        <div class="mt-0.5 shrink-0">
                            @if($reporte->estado == \App\Models\Reportes::ESTADO_ABIERTA)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>Abierta
                                </span>
                            @elseif($reporte->estado == \App\Models\Reportes::ESTADO_EN_ATENCION)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>En atención
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Cerrada
                                </span>
                            @endif
                        </div>

                        {{-- Origen badge --}}
                        @if($reporte->origen === 'auto')
                            <span class="mt-0.5 inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-400 uppercase tracking-wide">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                </svg>
                                Auto
                            </span>
                        @endif

                        {{-- Contenido principal --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-baseline gap-2">
                                <span class="font-bold text-sky-600 dark:text-sky-400 text-base">
                                    {{ $veh?->placa ?? 'Sin vehículo' }}
                                </span>
                                @if($veh?->cliente)
                                    @if($veh->cliente->contactos->count() > 0)
                                        <button wire:click="openModalContactos({{ $veh->cliente->id }})"
                                            class="text-sm text-gray-600 dark:text-gray-300 hover:text-sky-600 dark:hover:text-sky-400 underline cursor-pointer">
                                            {{ $veh->cliente->razon_social }}
                                        </button>
                                    @else
                                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ $veh->cliente->razon_social }}</span>
                                    @endif
                                @endif
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-0.5 line-clamp-2">
                                {{ $reporte->detalle }}
                            </p>

                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1.5">
                                @if($reporte->horas_sin_transmision)
                                    <span class="inline-flex items-center gap-1 text-xs text-amber-600 dark:text-amber-400 font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $reporte->horas_sin_transmision >= 24
                                            ? number_format($reporte->horas_sin_transmision / 24, 1).'d sin señal'
                                            : number_format($reporte->horas_sin_transmision, 1).'h sin señal' }}
                                    </span>
                                @endif

                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $reporte->created_at->diffForHumans() }}
                                </span>

                                @if($reporte->user)
                                    <span class="text-xs text-gray-400 dark:text-gray-500">por {{ $reporte->user->name }}</span>
                                @endif

                                @if($reporte->atendidoPor)
                                    <span class="text-xs text-blue-500 dark:text-blue-400">
                                        ↳ {{ $reporte->atendidoPor->name }}
                                        @if($reporte->atendido_at)· {{ $reporte->atendido_at->diffForHumans() }}@endif
                                    </span>
                                @endif

                                @if($reporte->notas_count > 0)
                                    <button wire:click="toggleDetalle({{ $reporte->id }})"
                                        class="text-xs text-violet-500 hover:text-violet-700 dark:text-violet-400 underline cursor-pointer">
                                        @if($detalleAbierto === $reporte->id) ▲ ocultar notas @else ▼ {{ $reporte->notas_count }} notas @endif
                                    </button>
                                @else
                                    <button wire:click="toggleDetalle({{ $reporte->id }})"
                                        class="text-xs text-gray-400 hover:text-violet-500 underline cursor-pointer">
                                        + añadir nota
                                    </button>
                                @endif
                            </div>
                        </div>

                        {{-- Botones de acción directa --}}
                        <div class="flex items-center gap-2 shrink-0 mt-0.5">
                            @if($reporte->estado == \App\Models\Reportes::ESTADO_ABIERTA)
                                <x-form.button wire:click="atender({{ $reporte->id }})"
                                    wire:confirm="¿Tomar esta alerta?"
                                    info xs icon="hand-raised" label="Atender" />
                            @elseif($reporte->estado == \App\Models\Reportes::ESTADO_EN_ATENCION)
                                <x-form.button wire:click="cerrar({{ $reporte->id }})"
                                    wire:confirm="¿Marcar como resuelta?"
                                    positive xs icon="check" label="Cerrar" />
                            @else
                                <x-form.button wire:click="reabrir({{ $reporte->id }})"
                                    flat secondary xs icon="arrow-uturn-left" label="Reabrir" />
                            @endif

                            {{-- Menú contextual --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click.prevent="open = !open"
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-full p-1"
                                    :class="{ 'bg-gray-100 dark:bg-gray-700': open }">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 32 32">
                                        <circle cx="16" cy="16" r="2" /><circle cx="10" cy="16" r="2" /><circle cx="22" cy="16" r="2" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-cloak
                                    class="absolute right-0 top-full mt-1 z-20 w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg py-1
                                        origin-top-right"
                                    x-transition:enter="transition ease-out duration-100 transform"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95">
                                    <a href="{{ route('admin.vehiculos.reportes.show', $reporte) }}"
                                        @click="open=false"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        Ver detalle
                                    </a>
                                    <button wire:click="openModalEdit({{ $reporte->id }})" @click="open=false"
                                        class="flex items-center gap-2 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        Editar
                                    </button>
                                    <button wire:click="openModalRecordatorio({{ $reporte->id }})" @click="open=false"
                                        class="flex items-center gap-2 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                        Recordatorio
                                    </button>
                                    <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                    <button wire:click="openModalDelete({{ $reporte->id }})" @click="open=false"
                                        class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Panel de notas expandible --}}
                    @if($detalleAbierto === $reporte->id)
                        <div class="mt-3 ml-0 md:ml-6 bg-gray-50 dark:bg-gray-900/30 rounded-lg p-3 space-y-2">
                            @forelse($reporte->getRelation('detalle')->sortByDesc('id') as $det)
                                <div class="flex items-start gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-gray-400 mt-2 shrink-0"></div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-200">{{ $det->detalle }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ $det->user?->name ?? 'Sistema' }} · {{ $det->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">Sin notas aún.</p>
                            @endforelse

                            <div class="flex items-end gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                <textarea wire:model.live="nuevoDetalle"
                                    rows="2"
                                    class="form-textarea flex-1 text-sm rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 resize-none"
                                    placeholder="Añadir nota..."></textarea>
                                <x-form.button wire:click="guardarDetalle({{ $reporte->id }})"
                                    primary xs icon="paper-airplane" label="Guardar" />
                            </div>
                            @error('nuevoDetalle')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                </div>
            @empty
                <div class="px-5 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-400 dark:text-gray-500">No hay reportes con los filtros actuales.</p>
                </div>
            @endforelse
        </div>

        @if($reportes->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $reportes->links() }}
            </div>
        @endif
    </div>

    {{-- Modales --}}
    @livewire('admin.vehiculos.reportes.save')
    @livewire('admin.vehiculos.reportes.edit')
    @livewire('admin.vehiculos.reportes.delete')
    @livewire('admin.vehiculos.reportes.recordatorio')
    @livewire('admin.vehiculos.reportes.show-contactos')
    @livewire('admin.vehiculos.reportes.estado-transmision')

</div>
