<div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 w-full mx-auto">

    {{-- ====== HEADER ====== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <x-heroicons name="truck" class="w-6 h-6 sm:w-7 sm:h-7 text-indigo-500" />
                Guías de Remisión
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Gestión y seguimiento de guías electrónicas SUNAT</p>
        </div>
        <div class="flex items-center gap-2">
            @can('crear-guias')
                <a href="{{ route('admin.guias.create') }}">
                    <x-form.button primary icon="plus" label="Registrar Guía" />
                </a>
            @endcan
        </div>
    </div>

    {{-- ====== BÚSQUEDA + FILTROS ====== --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 mb-4 p-3 sm:p-4">
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <div class="relative flex-1 min-w-0">
                <x-heroicons name="magnifying-glass" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 dark:text-slate-500 pointer-events-none" />
                <input wire:model.live.debounce.300ms="search" type="search"
                    placeholder="Buscar por serie, destinatario, placa, conductor..."
                    class="w-full pl-9 pr-4 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            </div>
            <div class="flex items-center gap-2 shrink-0">
                @php
                    $activeFilters = ($filterModalidad !== '' ? 1 : 0)
                        + ($filterEstado !== '' ? 1 : 0)
                        + ($filterFechaDesde !== '' ? 1 : 0)
                        + ($filterFechaHasta !== '' ? 1 : 0)
                        + ($filterMotivoTraslado !== '' ? 1 : 0)
                        + ($filterConductor !== '' ? 1 : 0)
                        + ($filterVehiculo !== '' ? 1 : 0);
                @endphp
                <button wire:click="$toggle('showFilters')"
                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg border transition
                        {{ $showFilters
                            ? 'bg-indigo-50 border-indigo-300 text-indigo-700 dark:bg-indigo-900/40 dark:border-indigo-600 dark:text-indigo-300'
                            : 'bg-white border-slate-300 text-slate-600 hover:bg-slate-50 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    <x-heroicons name="funnel" class="w-4 h-4" />
                    <span class="hidden sm:inline">Filtros</span>
                    @if($activeFilters > 0)
                        <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold bg-indigo-500 text-white rounded-full">
                            {{ $activeFilters }}
                        </span>
                    @endif
                </button>
                @if($activeFilters > 0 || $search !== '')
                    <button wire:click="clearFilters"
                        class="inline-flex items-center gap-1 px-3 py-2 text-sm text-rose-600 hover:text-rose-700 dark:text-rose-400 font-medium rounded-lg border border-rose-200 hover:bg-rose-50 dark:border-rose-700 dark:hover:bg-rose-900/30 transition">
                        <x-heroicons name="x-circle" class="w-4 h-4" />
                        <span class="hidden sm:inline">Limpiar</span>
                    </button>
                @endif
            </div>
        </div>

        @if($showFilters)
            <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                    {{-- Modalidad --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Modalidad</label>
                        <select wire:model.live="filterModalidad"
                            class="w-full text-sm rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Todas</option>
                            <option value="01">Transporte Público</option>
                            <option value="02">Transporte Privado</option>
                        </select>
                    </div>

                    {{-- Estado SUNAT --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Estado SUNAT</label>
                        <select wire:model.live="filterEstado"
                            class="w-full text-sm rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            <option value="0">Pendiente</option>
                            <option value="1">Aceptada</option>
                            <option value="2">Rechazada</option>
                            <option value="3">Observada</option>
                        </select>
                    </div>

                    {{-- Motivo traslado --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Motivo traslado</label>
                        <select wire:model.live="filterMotivoTraslado"
                            class="w-full text-sm rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            @foreach($motivosTraslado as $motivo)
                                <option value="{{ $motivo->codigo }}">{{ $motivo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Vehículo --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Vehículo (placa)</label>
                        <div class="relative">
                            <x-heroicons name="identification" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 dark:text-slate-500 pointer-events-none" />
                            <input wire:model.live.debounce.300ms="filterVehiculo" type="text"
                                placeholder="Ej: CPV-388"
                                class="w-full pl-8 pr-3 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </div>

                    {{-- Conductor --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Conductor</label>
                        <div class="relative">
                            <x-heroicons name="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 dark:text-slate-500 pointer-events-none" />
                            <input wire:model.live.debounce.300ms="filterConductor" type="text"
                                placeholder="Nombre o apellido..."
                                class="w-full pl-8 pr-3 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </div>

                    {{-- Fecha desde --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Fecha desde</label>
                        <input wire:model.live="filterFechaDesde" type="date"
                            class="w-full text-sm rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    {{-- Fecha hasta --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Fecha hasta</label>
                        <input wire:model.live="filterFechaHasta" type="date"
                            class="w-full text-sm rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                </div>
            </div>
        @endif
    </div>

    {{-- ====== INFO BAR ====== --}}
    <div class="flex items-center justify-between px-1 mb-3">
        <div class="flex items-center gap-2">
            <x-heroicons name="document-text" class="w-4 h-4 text-slate-400 dark:text-slate-500" />
            <span class="text-sm text-slate-600 dark:text-slate-300">
                Total guías: <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $guias->total() }}</span>
            </span>
        </div>
        <span class="text-xs text-slate-400 dark:text-slate-500">Página {{ $guias->currentPage() }} de {{ $guias->lastPage() }}</span>
    </div>

    {{-- ====== VISTA MÓVIL (cards) — solo en pantallas pequeñas ====== --}}
    <div class="sm:hidden space-y-3 mb-4">
        @forelse($guias as $guia)
            @php
                $estadoConfig = [
                    '0' => ['label' => 'Pendiente', 'bg' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400'],
                    '1' => ['label' => 'Aceptada',  'bg' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400'],
                    '2' => ['label' => 'Rechazada', 'bg' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400'],
                    '3' => ['label' => 'Observada', 'bg' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-400'],
                ];
                $cfg = $estadoConfig[$guia->fe_estado] ?? $estadoConfig['0'];
            @endphp
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                {{-- Card header --}}
                <div class="flex items-center justify-between px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <button wire:click="openDetallePanel({{ $guia->id }})"
                            class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            {{ $guia->serie_correlativo }}
                        </button>
                        <span class="text-xs text-slate-400 dark:text-slate-500">{{ $guia->fecha_emision->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $cfg['bg'] }}">
                            {{ $cfg['label'] }}
                        </span>
                        <x-form.dropdown>
                            @role('admin')
                                @if(!$guia->clase && $guia->fe_estado == '0')
                                    <x-dropdown.item wire:click.prevent="createXml({{ $guia->id }})" icon="arrow-path" label="Crear XML" />
                                @endif
                            @endrole
                            @can('editar-guias')
                                @if($guia->fe_estado == '0')
                                    <x-dropdown.item icon="pencil" label="Editar" href="{{ route('admin.guias.edit', $guia) }}" />
                                @else
                                    <x-dropdown.item disabled icon="pencil" label="Editar" />
                                @endif
                            @endcan
                            @can('eliminar-guias')
                                <x-dropdown.item wire:click.prevent="openModalDelete({{ $guia->id }})" icon="trash" label="Eliminar" />
                            @endcan
                        </x-form.dropdown>
                    </div>
                </div>
                {{-- Card body --}}
                <div class="px-4 py-3 space-y-2">
                    <div>
                        <div class="text-xs font-semibold text-slate-800 dark:text-slate-100 leading-tight">{{ $guia->cliente->razon_social }}</div>
                        <div class="text-xs text-slate-400 dark:text-slate-500">{{ $guia->cliente->numero_documento }}</div>
                    </div>
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $guia->motivoTraslado->descripcion }}</span>
                        @if($guia->modalidadTransporte->codigo === '01')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">Público</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400">Privado</span>
                        @endif
                    </div>
                    @if($guia->transp_placa || $guia->chofer_nombre)
                        <div class="flex flex-wrap gap-2 items-center text-xs">
                            @if($guia->transp_placa)
                                <span class="font-mono font-bold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 px-2 py-0.5 rounded">{{ $guia->transp_placa }}</span>
                            @endif
                            @if($guia->chofer_nombre)
                                <span class="text-slate-500 dark:text-slate-400">{{ $guia->chofer_nombre }} {{ $guia->chofer_apellidos }}</span>
                            @endif
                        </div>
                    @endif
                    <div class="text-xs text-slate-500 dark:text-slate-400 space-y-0.5">
                        <div class="flex items-start gap-1">
                            <x-heroicons name="map-pin" class="w-3 h-3 mt-0.5 text-indigo-400 shrink-0" />
                            <span class="leading-tight">{{ Str::limit($guia->direccion_partida, 45) }}</span>
                        </div>
                        <div class="flex items-start gap-1 text-slate-700 dark:text-slate-200">
                            <x-heroicons name="map-pin" class="w-3 h-3 mt-0.5 text-emerald-400 shrink-0" />
                            <span class="leading-tight">{{ Str::limit($guia->direccion_llegada, 45) }}</span>
                        </div>
                    </div>
                </div>
                {{-- Card footer --}}
                <div class="flex items-center justify-between px-4 py-2.5 border-t border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        <span class="font-semibold text-slate-700 dark:text-slate-200">{{ number_format($guia->peso, 3) }} kg</span>
                        <span class="mx-1 text-slate-300">·</span>
                        {{ $guia->cantidad_items }} ítem(s)
                        <span class="mx-1 text-slate-300">·</span>
                        F.Traslado: {{ $guia->fecha_inicio_traslado->format('d/m/Y') }}
                    </div>
                    <div class="flex items-center gap-1">
                        <a target="_blank" href="{{ route('facturacion.guia.ver.pdf', ['id' => $guia->id, 'guia' => $guia]) }}" title="PDF"
                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition">
                            <x-heroicons name="document" class="w-4 h-4" />
                        </a>
                        <a href="{{ route('facturacion.guia.ver.xml', $guia) }}" title="XML"
                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 transition">
                            <x-heroicons name="code-bracket" class="w-4 h-4" />
                        </a>
                        @if($guia->cdr_base64)
                            <a href="{{ route('facturacion.guia.qver.cdr', $guia) }}" title="CDR"
                                class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 transition">
                                <x-heroicons name="shield-check" class="w-4 h-4" />
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-10 text-center">
                <div class="flex flex-col items-center gap-2 text-slate-400 dark:text-slate-500">
                    <x-heroicons name="document-magnifying-glass" class="w-10 h-10" />
                    <span class="font-medium">No se encontraron guías</span>
                    @if($search !== '' || $activeFilters > 0)
                        <button wire:click="clearFilters" class="text-indigo-500 hover:underline text-sm">Limpiar filtros</button>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    {{-- ====== VISTA ESCRITORIO (tabla) — oculta en móvil ====== --}}
    <div class="hidden sm:block bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-4 py-3 text-left whitespace-nowrap">#Guía</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Emisión</th>
                        <th class="px-4 py-3 text-left">Destinatario</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Motivo / Modalidad</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Vehículo / Conductor</th>
                        <th class="px-4 py-3 text-left">Ruta</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Peso / Ítems</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">F. Traslado</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Estado SUNAT</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Docs</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($guias as $guia)
                        @php
                            $estadoConfig = [
                                '0' => ['label' => 'Pendiente', 'bg' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400'],
                                '1' => ['label' => 'Aceptada',  'bg' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400'],
                                '2' => ['label' => 'Rechazada', 'bg' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400'],
                                '3' => ['label' => 'Observada', 'bg' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-400'],
                            ];
                            $cfg = $estadoConfig[$guia->fe_estado] ?? $estadoConfig['0'];
                        @endphp
                        <tr class="group hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors">

                            {{-- #Guía --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <button wire:click="openDetallePanel({{ $guia->id }})"
                                    class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 hover:underline">
                                    {{ $guia->serie_correlativo }}
                                </button>
                            </td>

                            {{-- Emisión --}}
                            <td class="px-4 py-3 whitespace-nowrap text-slate-600 dark:text-slate-300 text-xs">
                                {{ $guia->fecha_emision->format('d/m/Y') }}
                            </td>

                            {{-- Destinatario --}}
                            <td class="px-4 py-3 max-w-xs">
                                <div class="font-medium text-slate-800 dark:text-slate-100 truncate text-xs leading-tight">{{ $guia->cliente->razon_social }}</div>
                                <div class="text-slate-400 dark:text-slate-500 text-xs mt-0.5">{{ $guia->cliente->numero_documento }}</div>
                            </td>

                            {{-- Motivo / Modalidad --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-xs text-slate-600 dark:text-slate-300 font-medium mb-1">{{ $guia->motivoTraslado->descripcion }}</div>
                                @if($guia->modalidadTransporte->codigo === '01')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                                        <x-heroicons name="building-office" class="w-3 h-3" /> Público
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400">
                                        <x-heroicons name="user" class="w-3 h-3" /> Privado
                                    </span>
                                @endif
                            </td>

                            {{-- Vehículo / Conductor --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($guia->transp_placa)
                                    <div class="inline-flex items-center gap-1 text-xs font-mono font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded">
                                        <x-heroicons name="identification" class="w-3 h-3 text-slate-400" />
                                        {{ $guia->transp_placa }}
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                                @if($guia->chofer_nombre)
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 truncate max-w-[130px]">
                                        {{ $guia->chofer_nombre }} {{ $guia->chofer_apellidos }}
                                    </div>
                                @endif
                            </td>

                            {{-- Ruta --}}
                            <td class="px-4 py-3 max-w-xs">
                                <div class="flex flex-col gap-0.5 text-xs">
                                    <div class="flex items-start gap-1 text-slate-500 dark:text-slate-400">
                                        <x-heroicons name="map-pin" class="w-3 h-3 mt-0.5 text-indigo-400 shrink-0" />
                                        <span class="truncate leading-tight">{{ Str::limit($guia->direccion_partida, 40) }}</span>
                                    </div>
                                    <div class="ml-1"><x-heroicons name="arrow-down" class="w-3 h-3 text-slate-300 dark:text-slate-600" /></div>
                                    <div class="flex items-start gap-1 text-slate-700 dark:text-slate-200">
                                        <x-heroicons name="map-pin" class="w-3 h-3 mt-0.5 text-emerald-400 shrink-0" />
                                        <span class="truncate leading-tight">{{ Str::limit($guia->direccion_llegada, 40) }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Peso / Ítems --}}
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="text-xs font-semibold text-slate-700 dark:text-slate-200">{{ number_format($guia->peso, 3) }} kg</div>
                                <div class="text-xs text-slate-400 dark:text-slate-500">{{ $guia->cantidad_items }} ítem(s)</div>
                            </td>

                            {{-- F. Traslado --}}
                            <td class="px-4 py-3 text-center whitespace-nowrap text-xs text-slate-600 dark:text-slate-300">
                                {{ $guia->fecha_inicio_traslado->format('d/m/Y') }}
                            </td>

                            {{-- Estado SUNAT --}}
                            <td class="px-4 py-3 text-center">
                                @switch($guia->fe_estado)
                                    @case('0')
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $cfg['bg'] }}">
                                                <x-heroicons name="clock" class="w-3 h-3" /> {{ $cfg['label'] }}
                                            </span>
                                            <x-form.mini.button flat wire:click.prevent="consultaTicket({{ $guia->id }})"
                                                teal icon="arrow-path" spinner="consultaTicket({{ $guia->id }})" title="Consultar ticket SUNAT" />
                                        </div>
                                    @break
                                    @case('1')
                                    @case('3')
                                        <div x-data="{ open: false }" class="relative inline-block text-left">
                                            <button @click="open = !open" type="button"
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $cfg['bg'] }} hover:opacity-80 transition cursor-pointer">
                                                @if($guia->fe_estado === '1')
                                                    <x-heroicons name="check-circle" class="w-3 h-3" />
                                                @else
                                                    <x-heroicons name="exclamation-circle" class="w-3 h-3" />
                                                @endif
                                                {{ $cfg['label'] }}
                                                <x-heroicons name="chevron-down" class="w-3 h-3" />
                                            </button>
                                            <div x-show="open" x-cloak @click.away="open = false"
                                                class="absolute z-20 right-0 mt-1 w-72 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl text-left text-xs">
                                                <div class="p-3 space-y-2">
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 dark:text-slate-400">Guía</span>
                                                        <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $guia->serie_correlativo }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 dark:text-slate-400">Estado</span>
                                                        <span class="font-semibold {{ $cfg['bg'] }} px-2 py-0.5 rounded-full">{{ $guia->estado_texto }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 dark:text-slate-400">Código</span>
                                                        <span class="font-mono font-bold text-slate-700 dark:text-slate-200">{{ $guia->code_sunat }}</span>
                                                    </div>
                                                    <div class="pt-1 border-t border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 leading-relaxed">{{ $guia->fe_mensaje_sunat }}</div>
                                                    @if($guia->fe_estado === '3' && is_array($guia->nota) && count($guia->nota))
                                                        <div class="pt-1 border-t border-slate-100 dark:border-slate-700">
                                                            <p class="font-semibold text-amber-600 dark:text-amber-400 mb-1">Observaciones:</p>
                                                            @foreach($guia->nota as $obs)
                                                                <p class="text-slate-500 dark:text-slate-400">• {{ $obs }}</p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @break
                                    @case('2')
                                        <div x-data="{ open: false }" class="relative inline-block text-left">
                                            <button @click="open = !open" type="button"
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $cfg['bg'] }} hover:opacity-80 transition cursor-pointer">
                                                <x-heroicons name="x-circle" class="w-3 h-3" />
                                                {{ $cfg['label'] }}
                                                <x-heroicons name="chevron-down" class="w-3 h-3" />
                                            </button>
                                            <div x-show="open" x-cloak @click.away="open = false"
                                                class="absolute z-20 right-0 mt-1 w-80 rounded-xl bg-white dark:bg-slate-800 border border-rose-200 dark:border-rose-800 shadow-xl text-left text-xs">
                                                <div class="p-3 space-y-2">
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 dark:text-slate-400">Guía</span>
                                                        <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $guia->serie_correlativo }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 dark:text-slate-400">Estado</span>
                                                        <span class="font-semibold {{ $cfg['bg'] }} px-2 py-0.5 rounded-full">{{ $guia->estado_texto }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-slate-500 dark:text-slate-400">Código SUNAT</span>
                                                        <span class="font-mono font-bold text-rose-600 dark:text-rose-400">{{ $guia->fe_codigo_error }}</span>
                                                    </div>
                                                    <div class="pt-1 border-t border-rose-100 dark:border-rose-900 text-slate-600 dark:text-slate-300 leading-relaxed">{{ $guia->fe_mensaje_error }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @break
                                @endswitch
                            </td>

                            {{-- Docs --}}
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a target="_blank" href="{{ route('facturacion.guia.ver.pdf', ['id' => $guia->id, 'guia' => $guia]) }}" title="Ver PDF"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 dark:bg-rose-900/30 dark:hover:bg-rose-900/50 text-rose-600 dark:text-rose-400 transition">
                                        <x-heroicons name="document" class="w-4 h-4" />
                                    </a>
                                    <a href="{{ route('facturacion.guia.ver.xml', $guia) }}" title="Descargar XML"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/30 dark:hover:bg-amber-900/50 text-amber-600 dark:text-amber-400 transition">
                                        <x-heroicons name="code-bracket" class="w-4 h-4" />
                                    </a>
                                    @if($guia->cdr_base64)
                                        <a href="{{ route('facturacion.guia.qver.cdr', $guia) }}" title="Descargar CDR"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/30 dark:hover:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 transition">
                                            <x-heroicons name="shield-check" class="w-4 h-4" />
                                        </a>
                                    @else
                                        <span title="CDR no disponible"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed">
                                            <x-heroicons name="shield-exclamation" class="w-4 h-4" />
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-3 text-center">
                                <x-form.dropdown>
                                    @role('admin')
                                        @if(!$guia->clase && $guia->fe_estado == '0')
                                            <x-dropdown.item wire:click.prevent="createXml({{ $guia->id }})" icon="arrow-path" label="Crear XML" />
                                        @endif
                                    @endrole
                                    @can('editar-guias')
                                        @if($guia->fe_estado == '0')
                                            <x-dropdown.item icon="pencil" label="Editar" href="{{ route('admin.guias.edit', $guia) }}" />
                                        @else
                                            <x-dropdown.item disabled icon="pencil" label="Editar" />
                                        @endif
                                    @endcan
                                    @can('eliminar-guias')
                                        <x-dropdown.item wire:click.prevent="openModalDelete({{ $guia->id }})" icon="trash" label="Eliminar" />
                                    @endcan
                                </x-form.dropdown>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-slate-400 dark:text-slate-500">
                                    <x-heroicons name="document-magnifying-glass" class="w-10 h-10" />
                                    <span class="font-medium">No se encontraron guías</span>
                                    @if($search !== '' || $activeFilters > 0)
                                        <button wire:click="clearFilters" class="text-indigo-500 hover:underline text-sm">Limpiar filtros</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($guias->hasPages())
            <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700">
                {{ $guias->links() }}
            </div>
        @endif
    </div>

    {{-- Paginación móvil --}}
    @if($guias->hasPages())
        <div class="sm:hidden mt-4">
            {{ $guias->links() }}
        </div>
    @endif

    @livewire('admin.guias-remision.detalle-panel', key('panel-detalle-guia'))
</div>